<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaldoController implements the CRUD actions for Saldo model.
 */
class KeuanganController extends Controller
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
     * Lists all Saldo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SaldoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Saldo model.
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
     * Creates a new Saldo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLabaRugi()
    {
        $searchModel = new \app\models\KasSearch();

        if(!empty($_POST['bulan']) && !empty($_POST['tahun']))
        {
            $y = $_POST['tahun'];
            $m = $_POST['bulan'];
            $searchModel->start_date = $y.'-'.$m.'-01';
            $searchModel->end_date = $y.'-'.$m.'-'.date('t');
        }

        $pendapatan = $searchModel->searchLabaRugi('besar','4');
        $biayaAtasPendapatan = $searchModel->searchLabaRugi('besar','5');
        $biayaOperasional = $searchModel->searchLabaRugi('besar','6');
        $pendapatanLain = $searchModel->searchLabaRugi('besar','8');
        return $this->render('laba-rugi',[
            'pendapatan' => $pendapatan,
            'biayaAtasPendapatan' => $biayaAtasPendapatan,
            'biayaOperasional' => $biayaOperasional,
            'pendapatanLain' => $pendapatanLain
        ]);
    }

    /**
     * Updates an existing Saldo model.
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
     * Deletes an existing Saldo model.
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
     * Finds the Saldo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Saldo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Saldo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
