<?php

namespace app\controllers;

use Yii;
use app\models\BarangHarga;
use app\models\BarangHargaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BarangHargaController implements the CRUD actions for BarangHarga model.
 */
class BarangHargaController extends Controller
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
     * Lists all BarangHarga models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangHargaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BarangHarga model.
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
     * Creates a new BarangHarga model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($barang_id = '')
    {
        $model = new BarangHarga();

        $model->barang_id = !empty($barang_id) ? $barang_id : '';

        if ($model->load(Yii::$app->request->post())) {
            $model->pilih = 1;
            if($model->validate()){
               $result = \Yii::$app->db->createCommand("CALL proc_update_barang_harga(:p1,0,0,1)") 
                  ->bindValue(':p1' , $model->barang_id)
                  ->execute();

                $model->save();
                $result = \Yii::$app->db->createCommand("CALL proc_update_barang_harga(:p1,:p2,1,0)") 
                  ->bindValue(':p1' , $model->barang_id)
                  ->bindValue(':p2' , $model->id)
                  ->execute();
                return $this->redirect(['sales-master-barang/view', 'id' => $barang_id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BarangHarga model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$barang_id='')
    {
        $model = $this->findModel($id);

        $model->barang_id = !empty($barang_id) ? $barang_id : '';

        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()){
               $result = \Yii::$app->db->createCommand("CALL proc_update_barang_harga(:p1,0,0,1)") 
                  ->bindValue(':p1' , $model->barang_id)
                  ->execute();

                $model->save();
                $result = \Yii::$app->db->createCommand("CALL proc_update_barang_harga(:p1,:p2,1,0)") 
                  ->bindValue(':p1' , $model->barang_id)
                  ->bindValue(':p2' , $model->id)
                  ->execute();
                return $this->redirect(['sales-master-barang/view', 'id' => $barang_id]);
            }
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BarangHarga model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', "Data telah dihapus");
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    /**
     * Finds the BarangHarga model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BarangHarga the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BarangHarga::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
