<?php

namespace app\controllers;

use Yii;
use app\models\BbmDispenserLog;
use app\models\BbmDispenserLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BbmDispenserLogController implements the CRUD actions for BbmDispenserLog model.
 */
class BbmDispenserLogController extends Controller
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

    public function actionAjaxGetAngkaDispenser()
    {
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $query = BbmDispenserLog::find()->where([
                'dispenser_id' => $dataItem['dispenser_id'],
                'barang_id' => $dataItem['barang_id'],

            ]);

            $tanggal = date('Y-m-d',strtotime($dataItem['tanggal']));
            $prevDate = date('Y-m-d',strtotime($tanggal.' -1 month'));
            $bulan = date('m',strtotime($prevDate));
            $tahun = date('Y',strtotime($prevDate));
            $prevDate = $tahun.'-'.$bulan.'-01';
            $lastDate = $tahun.'-'.$bulan.'-'.date('t');
            $query->andWhere(['between','tanggal',$prevDate,$lastDate]);
            $hasil = $query->one();

            $jumlah = !empty($hasil) ? $hasil->jumlah : 0;

            $result = [
                'code' => 200,
                'message' => 'success',
                'jumlah' => $jumlah
            ];
           
            echo json_encode($result);
        }
    }

    /**
     * Lists all BbmDispenserLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BbmDispenserLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BbmDispenserLog model.
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
     * Creates a new BbmDispenserLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BbmDispenserLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BbmDispenserLog model.
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
     * Deletes an existing BbmDispenserLog model.
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
     * Finds the BbmDispenserLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BbmDispenserLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BbmDispenserLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
