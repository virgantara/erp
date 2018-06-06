<?php

namespace app\controllers;

use Yii;
use app\models\TrRawatInapAlkesObat;
use app\models\TrRawatInapAlkesObatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrRawatInapAlkesObatController implements the CRUD actions for TrRawatInapAlkesObat model.
 */
class TrRawatInapAlkesObatController extends Controller
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
     * Lists all TrRawatInapAlkesObat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrRawatInapAlkesObatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrRawatInapAlkesObat model.
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
     * Creates a new TrRawatInapAlkesObat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new TrRawatInapAlkesObat();
        $rawatInap = \app\models\TrRawatInap::findOne($id);

        $searchModel = new TrRawatInapAlkesObatSearch();
        $searchModel->id_rawat_inap = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) ) {

            $model->kode_alkes = 'OBAT';
            $model->id_rawat_inap = $id;
            $model->save();
            $total = 0;
            foreach($rawatInap->trRawatInapAlkesObats as $obat)
            {
                $total += $obat->nilai;
            }

            $obatAlkes = \app\models\ObatAlkes::find()->where(['kode_alkes'=>'OBAT'])->one();
            $rit = \app\models\TrRawatInapAlkes::find()->where(['id_rawat_inap'=>$id])->one();
            if(empty($rit))
                $rit = new TrRawatInapAlkes;

            $rit->id_rawat_inap = $id;
            $rit->id_alkes = $obatAlkes->id_obat_alkes;
            $rit->biaya_irna = $total;
            $rit->biaya_ird = 0;
            $rit->jumlah_tindakan = 1;
            $rit->save();
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['create', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
            'rawatInap' => $rawatInap,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing TrRawatInapAlkesObat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $rawatInap = $model->rawatInap;

        $searchModel = new TrRawatInapAlkesObatSearch();
        $searchModel->id_rawat_inap = $rawatInap->id_rawat_inap;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $total = 0;
            foreach($rawatInap->trRawatInapAlkesObats as $obat)
            {
                $total += $obat->nilai;
            }

            $obatAlkes = \app\models\ObatAlkes::find()->where(['kode_alkes'=>'OBAT'])->one();
            $rit = \app\models\TrRawatInapAlkes::find()->where(['id_rawat_inap'=>$rawatInap->id_rawat_inap])->one();
            if(empty($rit))
                $rit = new TrRawatInapAlkes;

            $rit->id_rawat_inap = $rawatInap->id_rawat_inap;;
            $rit->id_alkes = $obatAlkes->id_obat_alkes;
            $rit->biaya_irna = $total;
            $rit->biaya_ird = 0;
            $rit->jumlah_tindakan = 1;
            $rit->save();
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['create', 'id' => $rawatInap->id_rawat_inap]);
        }

        return $this->render('update', [
            'model' => $model,
            'rawatInap' => $rawatInap,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing TrRawatInapAlkesObat model.
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
     * Finds the TrRawatInapAlkesObat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrRawatInapAlkesObat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrRawatInapAlkesObat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
