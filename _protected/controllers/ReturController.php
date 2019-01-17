<?php

namespace app\controllers;

use Yii;
use app\models\Retur;
use app\models\ReturSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\ReturItem;

/**
 * ReturController implements the CRUD actions for Retur model.
 */
class ReturController extends Controller
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
                foreach($model->returItems as $item)
                {
                    $sg = \app\models\SalesStokGudang::find()->where([
                        'faktur_barang_id' => $item->faktur_barang_id,
                    ])->one();

                    if(!empty($sg)){

                        $sg->jumlah = $sg->jumlah - $item->qty;
                        $sg->save(false,['jumlah']);
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
     * Lists all Retur models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Retur model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $searchModel = $model->getReturItems();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Retur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Retur();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $faktur = $model->faktur;
                
                foreach($faktur->salesFakturBarangs as $item)
                {
                    $m = new ReturItem;
                    $m->barang_id = $item->id_barang;
                    $m->faktur_barang_id = $item->id_faktur_barang;
                    $m->retur_id = $model->id;
                    $m->batch_no = $item->no_batch;
                    $m->exp_date = empty($item->exp_date) || $item->exp_date == '0000-00-00' ? date('Y-m-d') : $item->exp_date;
                    $m->save();
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Retur model.
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
     * Deletes an existing Retur model.
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
     * Finds the Retur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Retur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Retur::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
