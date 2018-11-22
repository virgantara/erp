<?php

namespace app\controllers;

use Yii;
use app\models\SalesIncome;
use app\models\SalesIncomeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalesIncomeController implements the CRUD actions for SalesIncome model.
 */
class SalesIncomeController extends Controller
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
     * Lists all SalesIncome models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesIncomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesIncome model.
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
     * Creates a new SalesIncome model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalesIncome();

        if ($model->load(Yii::$app->request->post())) {

            $stok = $model->stok;
            $model->harga = $stok->barang->harga_jual * $model->jumlah;
            $stok->jumlah -= $model->jumlah;
            $stok->save();
            // print_r($model->harga);exit;
            if ($model->validate()) {
                $model->save();
                // all inputs are valid
            } else {

                // validation failed: $errors is an array containing error messages
                $errors = $model->errors;
                print_r($errors);exit;
            }
            
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SalesIncome model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $stok = $model->stok;
            $model->harga = $stok->barang->harga_jual * $model->jumlah;
            // print_r($model->harga);exit;
            if ($model->validate()) {
                $model->save();
                // all inputs are valid
            } else {

                // validation failed: $errors is an array containing error messages
                $errors = $model->errors;
                print_r($errors);exit;
            }
            
            Yii::$app->session->setFlash('success', "Data terupdate");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SalesIncome model.
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
     * Finds the SalesIncome model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesIncome the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesIncome::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
