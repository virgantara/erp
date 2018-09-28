<?php

namespace app\controllers;

use Yii;

use app\models\SalesStokGudang;
use app\models\SalesFakturBarang;
use app\models\SalesFakturBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalesFakturBarangController implements the CRUD actions for SalesFakturBarang model.
 */
class SalesFakturBarangController extends Controller
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

    public function actionAjaxCreate()
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if(!empty($_POST['fakturItem']))
            {
                $data = $_POST['fakturItem'];
                // print_r($data);exit;
                $model = new SalesFakturBarang();
                $model->attributes = $data;
                // $model->id_faktur = !empty($faktur_id) ? $faktur_id : '';

                if ($model->save()) {
                    echo "success";                
                    $transaction->commit();
                }

                else{
                    print_r($model->getErrors());
                }
                

            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


    /**
     * Lists all SalesFakturBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesFakturBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesFakturBarang model.
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
     * Creates a new SalesFakturBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($faktur_id = '')
    {
        $model = new SalesFakturBarang();

        $model->id_faktur = !empty($faktur_id) ? $faktur_id : '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $stok = SalesStokGudang::find()->where(['id_gudang'=>$model->id_gudang,'id_barang'=>$model->id_barang])->one();
            $stok->jumlah += $model->jumlah;
            $stok->save();
            return $this->redirect(['/sales-faktur/view', 'id' => $model->id_faktur]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SalesFakturBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_faktur_barang]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SalesFakturBarang model.
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
     * Finds the SalesFakturBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesFakturBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesFakturBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
