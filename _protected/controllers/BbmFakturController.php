<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

use app\models\BbmFaktur;
use app\models\BbmFakturSearch;
use app\models\BarangStok;

/**
 * BbmFakturController implements the CRUD actions for BbmFaktur model.
 */
class BbmFakturController extends Controller
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

    public function actionApprove($id,$kode)
    {
        $model = $this->findModel($id);
        $model->is_selesai = $kode;
        $model->save();

        if($kode == 1)
        {

            $tgl = $model->tanggal_so;
            $tahun = date("Y",strtotime($tgl));
            $bulan = date("m",strtotime($tgl));

            $datestring=$tgl.' first day of last month';
            $dt=date_create($datestring);
            $lastMonth = $dt->format('m'); //2011-02
            $lastYear = $dt->format('Y');

            foreach($model->bbmFakturItems as $m)
            {
                $stokLalu = BarangStok::getStokBulanLalu($lastMonth, $lastYear, $m->barang_id);

                $stok = new BarangStok;
                $stok->barang_id = $m->barang_id;
                $stok->stok = $m->jumlah;
                $stok->stok_bulan_lalu = !empty($stokLalu) ? $stokLalu->stok : 0;
                $stok->sisa_do_lalu = !empty($stokLalu) ? $stokLalu->sisa_do : 0;
                $stok->tebus_liter = $m->jumlah;
                $stok->tebus_rupiah = $m->jumlah * $m->barang->harga_beli;
                $stok->bulan = $bulan;
                $stok->tahun = $tahun;
                $stok->tanggal = $tgl;
                $stok->perusahaan_id = $model->perusahaan_id;
                $stok->save();
            } 

        }

        Yii::$app->session->setFlash('success', "Data tersimpan");
        return $this->redirect(['index']);
    }

    /**
     * Lists all BbmFaktur models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BbmFakturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BbmFaktur model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = $model->getBbmFakturItems();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new BbmFaktur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BbmFaktur();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BbmFaktur model.
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
     * Deletes an existing BbmFaktur model.
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
     * Finds the BbmFaktur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BbmFaktur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BbmFaktur::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
