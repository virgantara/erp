<?php

namespace app\controllers;

use Yii;
use app\models\Cart;
use app\models\PenjualanItem;
use app\models\Penjualan;
use app\models\PenjualanSearch;
use app\models\SalesFaktur;
use app\models\SalesFakturSearch;
use app\models\RequestOrder;
use app\models\RequestOrderSearch;
use app\models\Pasien;
use app\models\SalesMasterBarang;
use app\models\MasterJenisBarang;
use app\models\SalesStokGudang;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\httpclient\Client;


/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class LaporanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionResepRekap()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->searchTanggal(Yii::$app->request->queryParams);

        $results = [];




        if(!empty($_GET['search']))
        {

            $tipe = $_GET['tipe'] == 1 ? 2 : 1;
        
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $response = $client->get('/m/unit/list', ['tipe'=>$tipe])->send();
            
            $results = [];
            
            if ($response->isOk) {
                $result = $response->data['values'];
                
                if(!empty($result))
                {
                    foreach ($result as $d) {
                        $label = $d['unit_tipe'] == 2 ? 'Poli '.$d['NamaUnit'] : $d['NamaUnit'];

                        $query = \app\models\PenjualanResep::find()->where(['unit_id'=>$d['KodeUnit']]);
                        $listResep = $query->all();

                        $total = 0;
                        $count = count($listResep);
                        foreach($listResep as $item)
                        {
                            $total += Penjualan::getTotalSubtotal($item->penjualan);
                        }

                        $avg = $total / ($count == 0 ? 1 : $count);

                        $results[] = [
                            'id' => $d['KodeUnit'],
                            'label'=> $label,
                            'count' => $count,
                            'total' => \app\helpers\MyHelper::formatRupiah($total,2) ,
                            'avg' => \app\helpers\MyHelper::formatRupiah($avg,2) 
                        ];
                    }    
                }

                else
                {
                    $results[] = [
                        'id' => 0,
                        'label'=> 'Data tidak ditemukan',
                       
                    ];
                }
                
            }

            
            $model = new Penjualan;
            return $this->render('resep_rekap', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }   

        else if(!empty($_GET['export']))
        {
             
            $jenisResep = \app\models\JenisResep::findOne($_GET['jenis_resep_id']);
            $jenisRawat = 'RAWAT '.($_GET['jenis_rawat'] == 1 ? 'JALAN' : 'INAP');
            $query = Penjualan::find();
            $query->joinWith(['penjualanResep as pr']);

            $style = [
                'alignment' => [
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ]
            ];
            $tanggal_awal = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_awal']));
            $tanggal_akhir = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_akhir']));
                
            $query->where(['departemen_id'=>Yii::$app->user->identity->departemen]);
            if(!empty($_GET['unit_id'])){
                $query->andWhere(['pr.unit_id'=>$_GET['unit_id']]);    
            }

            $query->andFilterWhere(['between', 'tanggal', $tanggal_awal, $tanggal_akhir]);
            $query->orderBy(['tanggal'=>SORT_ASC]);
            $hasil = $query->all();        


            
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = new \PHPExcel();

            //prepare the records to be added on the excel file in an array
           
            // Set document properties
            // $objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            $sheet = $objPHPExcel->getActiveSheet();
            // Add column headers
            $sheet->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Tgl')
                ->setCellValue('C3', 'Nama Px')
                ->setCellValue('D3', 'No RM')
                ->setCellValue('E3', 'No Resep')
                ->setCellValue('F3', 'Poli')
                ->setCellValue('G3', 'Dokter')
                ->setCellValue('H3', 'Jumlah');

            $sheet->mergeCells('A1:H1')->getStyle('A1:H1')->applyFromArray($style);
            $sheet->setCellValue('A1',$jenisResep->nama.' '.$jenisRawat);

            $sheet->mergeCells('A2:H2')->getStyle('A2:H2')->applyFromArray($style);
            $sheet->setCellValue('A2','Tanggal '.$_GET['Penjualan']['tanggal_awal'].' s/d '.$_GET['Penjualan']['tanggal_akhir']);

            //Put each record in a new cell

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(20);
            $i= 0;
            $ii = 3;

            $total = 0;
            foreach($hasil as $row)
            {

                $i++;

                $subtotal = \app\models\Penjualan::getTotalSubtotal($row);
                $total += $subtotal;

                $sheet->setCellValue('A'.$ii, $i);
                $sheet->setCellValue('B'.$ii, date('d/m/Y',strtotime($row->tanggal)));
                $sheet->setCellValue('C'.$ii, $row->penjualanResep->pasien_nama);
                $sheet->setCellValue('D'.$ii, $row->penjualanResep->pasien_id);
                $sheet->setCellValue('E'.$ii, $row->kode_penjualan);
                $sheet->setCellValue('F'.$ii, $row->penjualanResep->unit_nama);
                $sheet->setCellValue('G'.$ii, $row->penjualanResep->dokter_nama);
                $sheet->setCellValue('H'.$ii, $subtotal);
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->subtotal);
                
                $ii++;

                
            }       

            // Set worksheet title
            $sheet->setTitle('Laporan Rekapitulasi Nominal Resep');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_rekap_resep.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit;
        }

        else{
            
            $tipe = 2;
        
            $api_baseurl = Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $response = $client->get('/m/unit/list', ['tipe'=>$tipe])->send();
            
            $results = [];
            
            if ($response->isOk) {
                $result = $response->data['values'];
                
                if(!empty($result))
                {
                    foreach ($result as $d) {
                        $label = $d['unit_tipe'] == 2 ? 'Poli '.$d['NamaUnit'] : $d['NamaUnit'];

                        $query = \app\models\PenjualanResep::find()->where(['unit_id'=>$d['KodeUnit']]);
                        $listResep = $query->all();

                        $total = 0;
                        $count = count($listResep);
                        foreach($listResep as $item)
                        {
                            $total += Penjualan::getTotalSubtotal($item->penjualan);
                        }

                        $avg = $total / ($count == 0 ? 1 : $count);

                        $results[] = [
                            'id' => $d['KodeUnit'],
                            'label'=> $label,
                            'count' => $count,
                            'total' => \app\helpers\MyHelper::formatRupiah($total,2) ,
                            'avg' => \app\helpers\MyHelper::formatRupiah($avg,2) 
                        ];
                    }    
                }

                else
                {
                    $results[] = [
                        'id' => 0,
                        'label'=> 'Data tidak ditemukan',
                       
                    ];
                }
                
            }

            
            $model = new Penjualan;
            return $this->render('resep_rekap', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }

        // print_r($results);exit;

        
    }

    public function actionResep()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->searchTanggal(Yii::$app->request->queryParams);

        $results = [];




        if(!empty($_GET['search']))
        {
            $model = new Penjualan;
            return $this->render('resep', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]); 
        }   

        else if(!empty($_GET['export']))
        {
             
            $jenisResep = \app\models\JenisResep::findOne($_GET['jenis_resep_id']);
            $jenisRawat = 'RAWAT '.($_GET['jenis_rawat'] == 1 ? 'JALAN' : 'INAP');
            $query = Penjualan::find();
            $query->joinWith(['penjualanResep as pr']);

            $style = [
                'alignment' => [
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ]
            ];
            $tanggal_awal = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_awal']));
            $tanggal_akhir = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_akhir']));
                
            $query->where(['departemen_id'=>Yii::$app->user->identity->departemen]);
            if(!empty($_GET['unit_id'])){
                $query->andWhere(['pr.unit_id'=>$_GET['unit_id']]);    
            }

            $query->andFilterWhere(['between', 'tanggal', $tanggal_awal, $tanggal_akhir]);
            $query->orderBy(['tanggal'=>SORT_ASC]);
            $hasil = $query->all();        


            
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = new \PHPExcel();

            //prepare the records to be added on the excel file in an array
           
            // Set document properties
            // $objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            $sheet = $objPHPExcel->getActiveSheet();
            // Add column headers
            $sheet->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Tgl')
                ->setCellValue('C3', 'Nama Px')
                ->setCellValue('D3', 'No RM')
                ->setCellValue('E3', 'No Resep')
                ->setCellValue('F3', 'Poli')
                ->setCellValue('G3', 'Dokter')
                ->setCellValue('H3', 'Jumlah');

            $sheet->mergeCells('A1:H1')->getStyle('A1:H1')->applyFromArray($style);
            $sheet->setCellValue('A1',$jenisResep->nama.' '.$jenisRawat);

            $sheet->mergeCells('A2:H2')->getStyle('A2:H2')->applyFromArray($style);
            $sheet->setCellValue('A2','Tanggal '.$_GET['Penjualan']['tanggal_awal'].' s/d '.$_GET['Penjualan']['tanggal_akhir']);

            //Put each record in a new cell

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(20);
            $i= 0;
            $ii = 3;

            $total = 0;
            foreach($hasil as $row)
            {

                $i++;

                $subtotal = \app\models\Penjualan::getTotalSubtotal($row);
                $total += $subtotal;

                $sheet->setCellValue('A'.$ii, $i);
                $sheet->setCellValue('B'.$ii, date('d/m/Y',strtotime($row->tanggal)));
                $sheet->setCellValue('C'.$ii, $row->penjualanResep->pasien_nama);
                $sheet->setCellValue('D'.$ii, $row->penjualanResep->pasien_id);
                $sheet->setCellValue('E'.$ii, $row->kode_penjualan);
                $sheet->setCellValue('F'.$ii, $row->penjualanResep->unit_nama);
                $sheet->setCellValue('G'.$ii, $row->penjualanResep->dokter_nama);
                $sheet->setCellValue('H'.$ii, $subtotal);
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->subtotal);
                
                $ii++;

                
            }       

            // Set worksheet title
            $sheet->setTitle('Laporan Resep');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_resep.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit;
        }

        else{
             $model = new Penjualan;
            return $this->render('resep', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }

        // print_r($results);exit;

        
    }

    
    public function actionEdTahunan(){

        $results = [];
        if(!empty($_POST['tanggal_awal']) && !empty($_POST['tanggal_akhir']) && !empty($_POST['gudang_id']))
        {


            $tanggal_awal = $_POST['tanggal_awal'];
            $tanggal_akhir = $_POST['tanggal_akhir'];
            $a = $tanggal_awal;
            $b = $tanggal_akhir;

            $i = date("Ym", strtotime($a));
            $list_bulan = [];
            while($i <= date("Ym", strtotime($b))){
                $list_bulan[] = $i;
                if(substr($i, 4, 2) == "12")
                    $i = (date("Y", strtotime($i."01")) + 1)."01";
                else
                    $i++;
            }


            foreach($list_bulan as $bln)
            {
                $y = substr($bln, 0,4);
                $mm = substr($bln,4,2);
                $ds = $y.'-'.$mm.'-01';
                $de = $y.'-'.$mm.'-31';
                $query = SalesStokGudang::find();
                $query->joinWith(['barang as barang']);
                $query->where(['id_gudang'=>$_POST['gudang_id']]);
                $query->andWhere(['barang.is_hapus'=>0]);
                // $query->andWhere(['id_barang'=>$obat->id_barang]);
                $query->andWhere(['between','exp_date',$ds,$de]);
                $query->orderBy(['exp_date'=>SORT_ASC]);
                $list = $query->all();
                
                $total = 0;
                foreach($list as $q => $m)
                {
                    
                    if($m->jumlah > 0)
                    {
                        $subtotal = $m->jumlah * $m->barang->harga_beli;
                        $total += $subtotal;
                        $results[] = [
                            'bulan' => date('M',strtotime($m->exp_date)),
                            'tahun' => $y, 
                            'stok_id' => $m->id_stok,
                            'kode' => $m->barang->kode_barang,
                            'nama' => $m->barang->nama_barang,
                            'satuan' => $obat->id_satuan,
                            'ed' => $m->exp_date,
                            'jumlah' => $m->jumlah,
                            'hb' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_beli,2),
                            'hj' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_jual,2),
                            'subtotal' => \app\helpers\MyHelper::formatRupiah($subtotal,2),
                        ];
                    }
                    
                }
            }

            $results['total'] = $total;

        }

        return $this->render('ed_tahunan', [
            'list' => $results,
            'model' => $model,

        ]);
    }

    public function actionJenisObat(){

        $results = [];

        if(!empty($_POST['tanggal']) && !empty($_POST['dept_id']))
        {


            $tanggal = date('d',strtotime($_POST['tanggal']));
            $bulan = date('m',strtotime($_POST['tanggal']));
            $tahun = date('Y',strtotime($_POST['tanggal']));
            $query = \app\models\MasterJenisBarang::find();
            $query->where(['tipe'=>2]);
            
            $list = $query->all();

            $total = 0;
            foreach($list as $q => $m)
            {
                $barang_id = $m->departemenStok->barang_id;


                $kartuStok = \app\models\KartuStok::find()->where([
                    'barang_id' => $barang_id,
                    'departemen_id' => $_POST['dept_id'],

                ]);

                $tanggal_awal = date('Y-m-01',strtotime($_POST['tanggal']));
                $tanggal_akhir = date('Y-m-t',strtotime($_POST['tanggal']));

                $kartuStok->andFilterWhere(['between', 'tanggal', $tanggal_awal, $tanggal_akhir]);
                $qry = $kartuStok->all();
                $qty_in = 0;
                $qty_out = 0;
                foreach($qry as $ks)
                {
                    $qty_in += $ks->qty_in;
                    $qty_out += $ks->qty_out;
                }

                $subtotal = $m->stok_riil * $m->barang->harga_beli;
                $total += $subtotal;
                $results[] = [
                    'stok_id' => $m->departemenStok->barang_id,
                    'kode' => $m->barang->kode_barang,
                    'nama' => $m->barang->nama_barang,
                    'satuan' => $m->barang->id_satuan,
                    'stok_lalu' => $m->stok_lalu,
                    'masuk' => $qty_in,
                    'keluar' => $qty_out,
                    'stok_riil' => $m->stok_riil,
                    'hb' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_beli,2),
                    'hj' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_jual,2),
                    'subtotal' => \app\helpers\MyHelper::formatRupiah($subtotal,2),
                ];
            }


            $results['total'] = $total;
            if(!empty($_POST['export']) && empty($_POST['search']))
            {
                return $this->renderPartial('_tabel_opname', [
                    'list' => $results,
                    'model' => $model,
                    'export' => 1
                ]); 
            }

        }

        return $this->render('jenis_obat', [
            'list' => $results,
            'model' => $model,

        ]);
    }

    public function actionOpnameBulanan(){

        $results = [];

        if(!empty($_POST['tanggal']) && !empty($_POST['dept_id']))
        {


            $tanggal = date('d',strtotime($_POST['tanggal']));
            $bulan = date('m',strtotime($_POST['tanggal']));
            $tahun = date('Y',strtotime($_POST['tanggal']));
            $query = \app\models\BarangOpname::find();
            $query->where(['<>','barang.nama_barang','-']);
            $query->andWhere(['ds.departemen_id'=>$_POST['dept_id']]);
            $query->andWhere(['barang.is_hapus'=>0]);
            $query->andWhere([\app\models\BarangOpname::tableName().'.tahun'=>$tahun.$bulan]);
            $query->joinWith(['barang as barang','departemenStok as ds']);
            $query->orderBy(['barang.nama_barang'=>SORT_ASC]);
            $list = $query->all();

            $total = 0;
            foreach($list as $q => $m)
            {
                $barang_id = $m->departemenStok->barang_id;


                $kartuStok = \app\models\KartuStok::find()->where([
                    'barang_id' => $barang_id,
                    'departemen_id' => $_POST['dept_id'],

                ]);

                $tanggal_awal = date('Y-m-01',strtotime($_POST['tanggal']));
                $tanggal_akhir = date('Y-m-t',strtotime($_POST['tanggal']));

                $kartuStok->andFilterWhere(['between', 'tanggal', $tanggal_awal, $tanggal_akhir]);
                $qry = $kartuStok->all();
                $qty_in = 0;
                $qty_out = 0;
                foreach($qry as $ks)
                {
                    $qty_in += $ks->qty_in;
                    $qty_out += $ks->qty_out;
                }

                $subtotal = $m->stok_riil * $m->barang->harga_beli;
                $total += $subtotal;
                $results[] = [
                    'stok_id' => $m->departemenStok->barang_id,
                    'kode' => $m->barang->kode_barang,
                    'nama' => $m->barang->nama_barang,
                    'satuan' => $m->barang->id_satuan,
                    'stok_lalu' => $m->stok_lalu,
                    'masuk' => $qty_in,
                    'keluar' => $qty_out,
                    'stok_riil' => $m->stok_riil,
                    'hb' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_beli,2),
                    'hj' => \app\helpers\MyHelper::formatRupiah($m->barang->harga_jual,2),
                    'subtotal' => \app\helpers\MyHelper::formatRupiah($subtotal,2),
                ];
            }


            $results['total'] = $total;
            if(!empty($_POST['export']) && empty($_POST['search']))
            {
                return $this->renderPartial('_tabel_opname', [
                    'list' => $results,
                    'model' => $model,
                    'export' => 1
                ]); 
            }

        }

        return $this->render('opname_bulanan', [
            'list' => $results,
            'model' => $model,

        ]);
    }

    public function actionMutasiKeluar()
    {
        $searchModel = new RequestOrderSearch();
        $dataProvider = $searchModel->searchByTanggal(Yii::$app->request->queryParams);


        if(!empty($_GET['search']))
        {
            $model = new RequestOrder;
            return $this->render('mutasi_barang_keluar', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                // 'results' => $dataProvider->getModels(),

            ]); 
        }   

        else if(!empty($_GET['export']))
        {
             
            $params = $_GET;
            $dataProvider = $searchModel->searchByTanggal($params);

            
            
          
            return $this->renderPartial('_tabel_mutasi_keluar', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                // 'results' => $results,
                'export' => 1
            ]); 
        }

        else{
            $model = new RequestOrder;
            return $this->render('mutasi_barang_keluar', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }

        // print_r($results);exit;

        
    }

    public function actionMutasiMasuk()
    {
        $searchModel = new SalesFakturSearch();
        $dataProvider = $searchModel->searchByTanggal(Yii::$app->request->queryParams);


        // print_r(Yii::$app->request->queryParams);exit;

        if(!empty($_GET['search']))
        {
            $model = new SalesFaktur;
            return $this->render('mutasi_barang_masuk', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                // 'results' => $results,

            ]); 
        }   

        else if(!empty($_GET['export']))
        {
             
            $params = $_GET;
            $dataProvider = $searchModel->searchByTanggal($params);

            return $this->renderPartial('_tabel_mutasi_masuk', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                // 'results' => $results,
                'export' => 1
            ]); 
        }

        else{
            $model = new SalesFaktur;
            return $this->render('mutasi_barang_masuk', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                // 'results' => $results
            ]); 
        }

        // print_r($results);exit;

        
    }

    /**
     * Lists all Penjualan models.
     * @return mixed
     */
    public function actionPenjualan()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->searchTanggal(Yii::$app->request->queryParams);

        $results = [];



        foreach($dataProvider->getModels() as $row)
        {
            
            foreach($row->penjualanItems as $item)
            {
                $results[] = $item;
            }

            
        }

        if(!empty($_GET['search']))
        {
            $model = new Penjualan;
            return $this->render('penjualan', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }   

        else if(!empty($_GET['export']))
        {
             
            $query = Penjualan::find();

            $tanggal_awal = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_awal']));
            $tanggal_akhir = date('Y-m-d',strtotime($_GET['Penjualan']['tanggal_akhir']));
                
            $query->where(['departemen_id'=>Yii::$app->user->identity->departemen]);
            $query->andFilterWhere(['between', 'tanggal', $tanggal_awal, $tanggal_akhir]);
            $query->orderBy(['tanggal'=>SORT_ASC]);
            $hasil = $query->all();        


            foreach($hasil as $row)
            {
                
                foreach($row->penjualanItems as $item)
                {
                    $results[] = $item;
                }

                
            }
            
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = new \PHPExcel();

            //prepare the records to be added on the excel file in an array
           
            // Set document properties
            // $objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            // Add column headers
            $objPHPExcel->getActiveSheet()
                        ->setCellValue('A1', 'No')
                        ->setCellValue('B1', 'Tgl')
                        ->setCellValue('C1', 'Kode')
                        ->setCellValue('D1', 'Nama')
                        ->setCellValue('E1', 'Qty')
                        ->setCellValue('F1', 'HB')
                        ->setCellValue('G1', 'HJ')
                        ->setCellValue('H1', 'Laba');

            //Put each record in a new cell

            $i= 0;
            $ii = 0;

            $total = 0;
            $total_laba = 0;
            foreach($results as $row)
            {
                  $laba = ($row->stok->barang->harga_jual - $row->stok->barang->harga_beli) * $row->qty;
                $total += $laba;
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, date('d/m/Y',strtotime($row->penjualan->tanggal)));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $row->stok->barang->kode_barang);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $row->stok->barang->nama_barang);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $row->qty);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$ii, $row->stok->barang->harga_beli);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$ii, $row->stok->barang->harga_jual);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $laba);
                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$ii, $row->subtotal);
                $i++;
                $ii = $i+2;
                

                
            }       

            // Set worksheet title
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Penjualan');
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_penjualan.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');
            exit;
        }

        else{
             $model = new Penjualan;
            return $this->render('penjualan', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'results' => $results
            ]); 
        }

        // print_r($results);exit;

        
    }

    /**
     * Displays a single Penjualan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Penjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penjualan();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Penjualan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Penjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
