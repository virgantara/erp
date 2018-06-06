<?php

namespace app\controllers;

use Yii;
use app\models\BbmJual;
use app\models\BbmJualSearch;
use app\models\SalesBarang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * BbmJualController implements the CRUD actions for BbmJual model.
 */
class BbmJualController extends Controller
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

    private function inputKas($barang_id, $bulan, $tahun)
    {
       
            
        $listJualTanggal = BbmJual::getListJualTanggal($bulan, $tahun,$barang_id);
        
        $barang = SalesBarang::find()->where(['id_barang'=>$barang_id])->one();
        $listDispenser = \app\models\BbmDispenser::getDataProviderDispensers($barang_id);  

        foreach($listJualTanggal->models as $tgl)
        {
            $listShift = BbmJual::getListJualShifts($tgl->tanggal,$barang_id);
            $listShifts[$tgl->tanggal] = $listShift;
            foreach($listShift as $shift)
            {
                 $subtotal_liter = 0;
                foreach($listDispenser->models as $disp)
                {
                    $params = [
                        'tanggal' => $tgl->tanggal,
                        'barang_id' => $barang_id,
                        'shift_id' => $shift->shift_id,
                        'dispenser_id' => $disp->id
                    ];

                    $dataProvider = $searchModel->searchBy($params);
                    $listData[$tgl->tanggal][$shift->shift_id][$disp->id] = $dataProvider;
                    $stok_awal = !empty($dataProvider) ? $dataProvider->stok_awal : 0;
                    $stok_akhir = !empty($dataProvider) ? $dataProvider->stok_akhir : 0;
                    $saldo = $stok_akhir - $stok_awal;
                    $subtotal_liter += $saldo;
                    
                    $harga = !empty($dataProvider) && $dataProvider->harga != 0 ? $dataProvider->harga : $harga;
                }

                $kode_transaksi = $barang->id_barang.'-'.$tgl->id.'-'.$shift->shift_id;
                $userLevel = Yii::$app->user->identity->access_role;    
                
                $userPt = Yii::$app->user->identity->perusahaan_id;
                $kas = \app\models\Kas::find()->where(['kode_transaksi'=>$kode_transaksi])->one();
                if(empty($kas))
                {
                    $kas = new \app\models\Kas;    
                    
                }

                $kas->kas_masuk = $subtotal_liter * $harga;
                $kas->perkiraan_id = $barang->perkiraan_id;
                $kas->perusahaan_id = $userPt;
                $kas->penanggung_jawab = Yii::$app->user->identity->username;
                $uk = 'besar';
                $kas->keterangan = $barang->perkiraan->nama.' '.$barang->nama_barang;
                $kas->tanggal = $tgl->tanggal;
                $kas->jenis_kas = 1; // kas masuk    
                $kas->perusahaan_id = $userPt;
                $kas->kas_besar_kecil = $uk;
                $kas->kode_transaksi = $kode_transaksi;

                $kas->save();
                
                \app\models\Kas::updateSaldo($uk,$bulan,$tahun);
            }
        }            
        
    }

    /**
     * Lists all BbmJual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $barang = null;

        $searchModel = new BbmJualSearch();
        $dataProvider = null;

        $listDispenser = [];

        $listData = [];
        $listShifts = [];
        $listJualTanggal = [];

        if(!empty($_POST['barang_id']))
        {
            
            
            // $listJualTanggal = BbmJual::getListJualTanggal($_POST['bulan'], $_POST['tahun'],$_POST['barang_id']);
            
            $barang = SalesBarang::find()->where(['id_barang'=>$_POST['barang_id']])->one();
            $listDispenser = \app\models\BbmDispenser::getDataProviderDispensers($_POST['barang_id']);  
            // for($i = 0;$i<31;$i++)
            // {
                
                
            //     $tgl = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
            //     $fulldate = $_POST['tahun'].'-'.$_POST['bulan'].'-'.$tgl;
            // // foreach($listJualTanggal->models as $tgl)
            // // {
            //     $listShift = BbmJual::getListJualShifts($fulldate,$_POST['barang_id']);
            //     // $listShifts[$fulldate] = $listShift;
            //     foreach($listShift as $shift)
            //     {
            //          $subtotal_liter = 0;
            //         foreach($listDispenser->models as $disp)
            //         {
            //             $params = [
            //                 'tanggal' => $fulldate,
            //                 'barang_id' => $_POST['barang_id'],
            //                 'shift_id' => $shift->shift_id,
            //                 'dispenser_id' => $disp->id
            //             ];

            //             $dataProvider = $searchModel->searchBy($params);
            //             $listData[$fulldate][$shift->shift_id][$disp->id] = $dataProvider;
            //             $stok_awal = !empty($dataProvider) ? $dataProvider->stok_awal : 0;
            //             $stok_akhir = !empty($dataProvider) ? $dataProvider->stok_akhir : 0;
            //             $saldo = $stok_akhir - $stok_awal;
            //             $subtotal_liter += $saldo;
                        
            //             $harga = !empty($dataProvider) && $dataProvider->harga != 0 ? $dataProvider->harga : $harga;
            //         }

            //         // $kode_transaksi = $barang->id_barang.'-'.$tgl->id.'-'.$shift->shift_id;
            //         // $userLevel = Yii::$app->user->identity->access_role;    
                    
            //         // $userPt = Yii::$app->user->identity->perusahaan_id;
            //         // $kas = \app\models\Kas::find()->where(['kode_transaksi'=>$kode_transaksi])->one();
            //         // if(empty($kas))
            //         // {
            //         //     $kas = new \app\models\Kas;    
                        
            //         // }

            //         // $kas->kas_masuk = $subtotal_liter * $harga;
            //         // $kas->perkiraan_id = $barang->perkiraan_id;
            //         // $kas->perusahaan_id = $userPt;
            //         // $kas->penanggung_jawab = Yii::$app->user->identity->username;
            //         // $uk = 'besar';
            //         // $kas->keterangan = $barang->perkiraan->nama.' '.$barang->nama_barang;
            //         // $kas->tanggal = $tgl->tanggal;
            //         // $kas->jenis_kas = 1; // kas masuk    
            //         // $kas->perusahaan_id = $userPt;
            //         // $kas->kas_besar_kecil = $uk;
            //         // $kas->kode_transaksi = $kode_transaksi;

            //         // $kas->save();
                    
            //         // \app\models\Kas::updateSaldo($uk,$_POST['bulan'],$_POST['tahun']);
            //     }
            // }            
        }
    
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'barang'=>$barang,
            'listShifts' => $listShifts,
            'listJualTanggal' => $listJualTanggal,
            'listDispenser' => $listDispenser,
            'listData' => $listData
        ]);
    }

    /**
     * Displays a single BbmJual model.
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
     * Creates a new BbmJual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BbmJual();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            //if callback returns true than commit transaction
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', "Data telah tersimpan");
                return $this->redirect(['index']);
            }    
            
             
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BbmJual model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data telah tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BbmJual model.
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
     * Finds the BbmJual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BbmJual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BbmJual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
