<?php

namespace app\controllers;

use Yii;
use app\models\DistribusiBarangItem;
use app\models\DistribusiBarangItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DistribusiBarangItemController implements the CRUD actions for DistribusiBarangItem model.
 */
class DistribusiBarangItemController extends Controller
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

    public function actionAjaxUpdateItem()
    {
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $model = DistribusiBarangItem::findOne($dataItem['dist_id']);
            $model->qty = $dataItem['jml_beri'];
            
            $result = [
                'code' => 200,
                'message' => 'success'
            ];
            if($model->validate())
            {
                $model->save(false,['qty']);
            }

            else{

                $errors = '';
                foreach($model->getErrors() as $attribute){
                    foreach($attribute as $error){
                        $errors .= $error.' ';
                    }
                }
                        
                $result = [
                    'code' => 510,
                    'message' => $errors
                ];
                // print_r();exit;
            }

            echo json_encode($result);
        }
    }

    public function actionAjaxCreate()
    {
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $model = new DistribusiBarangItem();
            $model->distribusi_barang_id= $dataItem['dist_barang_id'];
            $model->stok_id = $dataItem['stok_id'];
            $model->qty = !empty($dataItem['jml_beri']) ? $dataItem['jml_beri'] : 0;
            
            $result = [
                'code' => 200,
                'message' => 'success'
            ];
            if($model->validate())
            {
                $model->save();
            }

            else{

                $errors = '';
                foreach($model->getErrors() as $attribute){
                    foreach($attribute as $error){
                        $errors .= $error.' ';
                    }
                }
                        
                $result = [
                    'code' => 204,
                    'message' => $errors
                ];
                // print_r();exit;
            }

            echo json_encode($result);
        }
    }

    /**
     * Lists all DistribusiBarangItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DistribusiBarangItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DistribusiBarangItem model.
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
     * Creates a new DistribusiBarangItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DistribusiBarangItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DistribusiBarangItem model.
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
     * Deletes an existing DistribusiBarangItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the DistribusiBarangItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DistribusiBarangItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DistribusiBarangItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
