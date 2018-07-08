<?php

namespace app\controllers;

use Yii;
use app\models\RequestOrder;
use app\models\RequestOrderSearch;
use app\models\Notif;
use app\models\RequestOrderIn;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



use yii\data\ActiveDataProvider;

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
                        $stokCabang->tanggal = $item->ro->tanggal_penyetujuan;
                        $stokCabang->stok_bulan_lalu = 0;
                        $stokCabang->stok = $item->jumlah_beri;
                        $stokCabang->ro_item_id = $item->id;
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
                        $stokCabang->barang_id = $item->item_id;
                        $stokCabang->departemen_id = $item->ro->departemen_id;
                        $stokCabang->stok_awal = $stokCabang->stok + $item->jumlah_beri;
                        $stokCabang->stok_akhir = $stokCabang->stok + $item->jumlah_beri;
                        $stokCabang->tanggal = $item->ro->tanggal_penyetujuan;
                        $stokCabang->stok_bulan_lalu = !empty($stokLalu) ? $stokLalu->stok : 0;
                        $stokCabang->stok = $stokCabang->stok + $item->jumlah_beri;
                        $stokCabang->save();    
                    }

                   
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
            $model->departemen_id = \app\models\Departemen::getDepartemenId();
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
