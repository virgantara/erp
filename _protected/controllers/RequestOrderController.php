<?php

namespace app\controllers;

use Yii;
use app\models\RequestOrder;
use app\models\RequestOrderSearch;
use app\models\Notif;
use app\models\RequestOrderIn;
use app\models\RequestOrderItem;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use arogachev\excel\export\basic\Exporter;


use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
/**
 * RequestOrderController implements the CRUD actions for RequestOrder model.
 */
class RequestOrderController extends Controller
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

    public function actionPrint($id)
    {

        $model = $this->findModel($id);
        $searchModel = $model->getRequestOrderItems();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        $content = $this->renderPartial('_print', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            'marginTop' => 5,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
             // call mPDF methods on the fly
            'methods' => [ 
                // 'SetHeader'=>['Krajee Report Header'], 
                // 'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    public function actionTemplate(){
        
        
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $template = Yii::getAlias('@app/template').'/excel/roi.xlsx';
        $objPHPExcel = $objReader->load($template);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
        exit;
    }

    public function actionUploadItem(){
        
    }

    public function actionApproveRo($id,$kode)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            $model = $this->findModel($id);
            $model->is_approved_by_kepala = $kode;

            $model->save();

            // \app\models\RequestOrder::updateStok($id);

            if($kode==1)
            {

                $notif = new Notif;
                $notif->departemen_from_id = $model->departemen->id;
                $notif->departemen_to_id = $model->departemenTo->id;
                $notif->keterangan = 'New Request Order from '.$model->departemen->nama;
                $notif->item_id = $model->id;
                $notif->save();
                
                $roIn = new RequestOrderIn;
                $roIn->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
                $roIn->departemen_id = $model->departemenTo->id;
                $roIn->ro_id = $model->id;
                $roIn->save();
    
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view','id'=>$id]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function actionApprove($id,$kode)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            $model = $this->findModel($id);
            $model->is_approved = $kode;

            $model->save();

            // \app\models\RequestOrder::updateStok($id);

            if($kode==1)
            {
                foreach($model->requestOrderItems as $item)
                {

                    $stokCabang = \app\models\DepartemenStok::find()->where(
                        [
                            'barang_id'=> $item->item_id,
                            'departemen_id' => $item->ro->departemen_id
                        ]
                    )->one();
                    if(empty($stokCabang)){
                        $stokCabang = new \app\models\DepartemenStok;
                        $stokCabang->barang_id = $item->item_id;
                        $stokCabang->departemen_id = $item->ro->departemen_id;
                        $stokCabang->stok_awal = $item->jumlah_beri;
                        $stokCabang->stok_akhir = $item->jumlah_beri;
                        $stokCabang->tanggal = !empty($item->ro->tanggal_penyetujuan) ? $item->ro->tanggal_penyetujuan : date('Y-m-d');
                        $stokCabang->stok_bulan_lalu = 0;
                        $stokCabang->stok = $item->jumlah_beri;
                        // $stokCabang->ro_item_id = $item->id;
                        $stokCabang->exp_date = date('Y-m-d');
                        
                        $tahun = date("Y",strtotime($stokCabang->tanggal));
                        $bulan = date("m",strtotime($stokCabang->tanggal));
                        $stokCabang->bulan = $bulan;
                        $stokCabang->tahun = $tahun;
                        $stokCabang->save();
                        
                    }

                    else
                    {

                        $datestring=$item->ro->tanggal_penyetujuan.' first day of last month';
                        $dt=date_create($datestring);
                        $lastMonth = $dt->format('m'); //2011-02
                        $lastYear = $dt->format('Y');
                        $stokLalu = \app\models\DepartemenStok::find()->where(
                        [
                            'barang_id'=> $item->item_id,
                            'departemen_id' => $item->ro->departemen_id,
                            'bulan' => $lastMonth,
                            'tahun' => $lastYear
                        ])->one();
                        $stokCabang->exp_date = date('Y-m-d');
                        $stokCabang->barang_id = $item->item_id;
                        $stokCabang->departemen_id = $item->ro->departemen_id;
                        $stokCabang->stok_awal = $stokCabang->stok + $item->jumlah_beri;
                        $stokCabang->stok_akhir = $stokCabang->stok + $item->jumlah_beri;
                        $stokCabang->tanggal = $item->ro->tanggal_penyetujuan;
                        $stokCabang->stok_bulan_lalu = !empty($stokLalu) ? $stokLalu->stok : 0;
                        $stokCabang->stok = $stokCabang->stok + $item->jumlah_beri;
                        $stokCabang->save();    
                    }

                    $params = [
                        'barang_id' => $item->item_id,
                        'status' => 0,
                        'qty' => $item->jumlah_beri,
                        'tanggal' => $model->tanggal_penyetujuan,
                        'departemen_id' => $item->ro->departemen_id_to,
                        'stok_id' => $item->stok_id,
                        'keterangan' => $item->ro->getNamaDeptAsal(),
                    ];

                    \app\models\KartuStok::createKartuStok($params);

                     $params = [
                        'barang_id' => $item->item_id,
                        'status' => 1,
                        'qty' => $item->jumlah_beri,
                        'tanggal' => $model->tanggal_penyetujuan,
                        'departemen_id' => $item->ro->departemen_id,
                        'stok_id' => $item->stok_id,
                        'keterangan' => $item->ro->getNamaDeptTujuan(),
                    ];

                    \app\models\KartuStok::createKartuStok($params);
                   
                }
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['view','id'=>$id]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Lists all RequestOrder models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new RequestOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RequestOrder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $searchModel = $model->getRequestOrderItems();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RequestOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RequestOrder();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->user->can('operatorCabang')){
                $model->petugas1 = Yii::$app->user->identity->username;
            }
            else if(Yii::$app->user->can('gudang')){
                $model->petugas2 = Yii::$app->user->identity->username;
            }

            $model->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
            $model->tanggal_penyetujuan = date('Y-m-d');
            $model->departemen_id = Yii::$app->user->identity->departemen;//\app\models\Departemen::getDepartemenId();
            if($model->validate()){
                $model->save();
                
                return $this->redirect(['view', 'id' => $model->id]);
            }


        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RequestOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->user->can('operatorCabang')){
                $model->petugas1 = Yii::$app->user->identity->username;
            }
            else if(Yii::$app->user->can('gudang')){
                $model->petugas2 = Yii::$app->user->identity->username;
            }
            if($model->validate()){
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RequestOrder model.
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
     * Finds the RequestOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RequestOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequestOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
