<?php

namespace app\controllers;

use Yii;
use app\models\BarangDatang;
use app\models\BarangDatangSearch;
use app\models\SalesStokGudang;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BarangDatangController implements the CRUD actions for BarangDatang model.
 */
class BarangDatangController extends Controller
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
     * Lists all BarangDatang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangDatangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BarangDatang model.
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
     * Creates a new BarangDatang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BarangDatang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BarangDatang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sg = SalesStokGudang::find()->where([
                'faktur_barang_id' => $model->no_lo,
            ])->one();

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try 
            {
                if(empty($sg))     
                    $sg = new SalesStokGudang;

                $sg->jumlah = $model->jumlah;
                $sg->id_gudang = $model->gudang_id;
                $sg->id_barang = $model->gudang_id;
                $sg->exp_date = date('Y-m-d');
                $sg->batch_no = '-';
                $sg->faktur_barang_id = $model->no_lo;                    
                $sg->save();

                $params = [
                    'barang_id' => $sg->id_barang,
                    'status' => 1,
                    'qty' => $sg->jumlah,
                    'tanggal' => $model->tanggal,
                    'departemen_id' => 1,
                    'stok_id' => $sg->id_stok,
                    'keterangan' => '',
                ];
                \app\models\KartuStok::createKartuStok($params);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->tanggal = Yii::$app->formatter->asDate($model->tanggal);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BarangDatang model.
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
     * Finds the BarangDatang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BarangDatang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BarangDatang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
