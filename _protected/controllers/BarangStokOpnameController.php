<?php

namespace app\controllers;

use Yii;
use app\models\BarangStokOpname;
use app\models\BarangStokOpnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BarangStokOpnameController implements the CRUD actions for BarangStokOpname model.
 */
class BarangStokOpnameController extends Controller
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
     * Lists all BarangStokOpname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangStokOpnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BarangStokOpname model.
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
     * Creates a new BarangStokOpname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BarangStokOpname();

        if ($model->load(Yii::$app->request->post())) {
            $model->bulan = date("m",strtotime($model->tanggal));
            $model->tahun = date("Y",strtotime($model->tanggal));
            $tmp = BarangStokOpname::getStokLalu($model->bulan, $model->tahun, $model->barang_id);
            $model->stok_lalu = !empty($tmp) ? $tmp->stok : 0;
            $model->save();
            \app\models\BarangStok::hitungLoss($model->bulan,$model->tahun,$model->barang_id);
            Yii::$app->session->setFlash('success', "Data telah tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BarangStokOpname model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {

            $model->bulan = date("m",strtotime($model->tanggal));
            $model->tahun = date("Y",strtotime($model->tanggal));
            $tmp = BarangStokOpname::getStokLalu($model->bulan, $model->tahun, $model->barang_id);
            $model->stok_lalu = !empty($tmp) ? $tmp->stok : 0;
            $model->save();
            \app\models\BarangStok::hitungLoss($model->bulan,$model->tahun,$model->barang_id);
            Yii::$app->session->setFlash('success', "Data telah diupdate");
            return $this->redirect(['index']);
        }

        $model->tanggal = Yii::$app->formatter->asDate($model->tanggal);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BarangStokOpname model.
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
     * Finds the BarangStokOpname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BarangStokOpname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BarangStokOpname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
