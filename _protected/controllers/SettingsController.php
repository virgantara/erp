<?php

namespace app\controllers;

use Yii;
use app\models\Settings;
use app\models\SettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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

    public function actionSyncObat(){

        $akhp = \app\models\MObatAkhp::find()->all();

        foreach($akhp as $item)
        {
            $m = \app\models\SalesMasterbarang::find()->where(['kode_barang'=>$item->kd_barang])->one();

            if(empty($m))
                $m = new \app\models\SalesMasterbarang;

            $m->kode_barang = $item->kd_barang;
            $m->nama_barang = $item->nama_barang;
            $m->harga_beli = $item->hb;
            $m->harga_jual = $item->hj;
            $m->id_satuan = $item->satuan;
            $m->id_perusahaan = Yii::$app->user->identity->perusahaan_id;
            $m->perkiraan_id = 90;
            $m->save();
        }

        $master_barang = \app\models\SalesMasterbarang::find()->all();

        foreach($master_barang as $m)
        {
            $akhp = \app\models\MObatAkhp::find()->where([
                'kd_barang' => $m->kode_barang, 
            ])->one();

            if(!empty($akhp) && $m->kode_barang != '-')
            {

                $tmp = \app\models\ObatDetil::find()->where([
                    'barang_id' => $m->id_barang, 
                ])->one();

                if(empty($tmp))
                    $tmp = new \app\models\ObatDetil;

                $tmp->barang_id = $m->id_barang;
                $tmp->nama_generik = $akhp->nama_generik;
                $tmp->kekuatan = $akhp->kekuatan;
                $tmp->satuan_kekuatan = $akhp->satuan_kekuatan;
                $tmp->jns_sediaan = $akhp->jns_sediaan;
                $tmp->b_i_r = $akhp->b_i_r;
                $tmp->gen_non = $akhp->gen_non;
                $tmp->nar_p_non = $akhp->nar_p_non;
                $tmp->oakrl = $akhp->oakrl;
                $tmp->kronis= $akhp->kronis;
                if($tmp->validate())
                    $tmp->save();
                else{
                    print_r($tmp->getErrors());exit;
                }
            }

        }
    }

    /**
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Settings model.
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
     * Creates a new Settings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Settings model.
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
     * Deletes an existing Settings model.
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
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
