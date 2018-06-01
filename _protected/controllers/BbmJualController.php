<?php

namespace app\controllers;

use Yii;
use app\models\BbmJual;
use app\models\BbmJualSearch;
use app\models\SalesBarang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Shift;
use app\models\BbmDispenser;

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

        if(!empty($_POST['barang_id'])){
            
            $listJualTanggal = BbmJual::getListJualTanggal($_POST['bulan'], $_POST['tahun'],$_POST['barang_id']);
            
            $barang = SalesBarang::find()->where(['id_barang'=>$_POST['barang_id']])->one();
            $listDispenser = BbmDispenser::getDataProviderDispensers($_POST['barang_id']);  

            foreach($listJualTanggal->models as $tgl)
            {
                $listShift = BbmJual::getListJualShifts($tgl->tanggal,$_POST['barang_id']);
                $listShifts[$tgl->tanggal] = $listShift;
                foreach($listShift as $shift)
                {
                    
                    foreach($listDispenser->models as $disp)
                    {
                        $params = [
                            'tanggal' => $tgl->tanggal,
                            'barang_id' => $_POST['barang_id'],
                            'shift_id' => $shift->shift_id,
                            'dispenser_id' => $disp->id
                        ];

                        $dataProvider = $searchModel->searchBy($params);
                        $listData[$tgl->tanggal][$shift->shift_id][$disp->id] = $dataProvider;
                    }
                }
            }            
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

        if ($model->load(Yii::$app->request->post())) {
            $barang = SalesBarang::find()->where(['id_barang'=>$model->barang_id])->one();
            $model->harga = $barang->harga_jual;
            $model->save();
            Yii::$app->session->setFlash('success', "Data telah tersimpan");
            return $this->redirect(['index']);
            
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
