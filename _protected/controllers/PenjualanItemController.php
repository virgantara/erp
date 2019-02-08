<?php

namespace app\controllers;

use Yii;
use app\models\PenjualanItem;
use app\models\PenjualanItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenjualanItemController implements the CRUD actions for PenjualanItem model.
 */
class PenjualanItemController extends Controller
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

    private function loadItems($pid)
    {
        $rows = PenjualanItem::find()->where(['penjualan_id'=>$pid])->all();
        $items = [];
        $total = 0;
        foreach($rows as $row)
        {
            $total += $row->subtotal;
            $items[] = [
                'id' => $row->id,
                'departemen_stok_id' => $row->stok_id,
                'barang_id' => $row->stok->barang_id,
                'kode_barang' => $row->stok->barang->kode_barang,
                'nama_barang' => $row->stok->barang->nama_barang,
                'kekuatan' => $row->kekuatan,
                'dosis_minta' => $row->dosis_minta,
                'qty' => $row->qty,
                'harga' => $row->stok->barang->harga_jual,
                'subtotal' => $row->subtotal,
                'signa1' => $row->signa1,
                'signa2' => $row->signa2,
                'is_racikan' => $row->is_racikan,
                'jumlah_ke_apotik' => $row->jumlah_ke_apotik

            ];


        } 


        $result = [
            'code' => 200,
            'message' => 'success',
            'items' => $items,
            'total' => $total
        ];
        return $result;
    }

    public function actionAjaxDelete(){
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $model = PenjualanItem::findOne($dataItem);
                $model->delete();
              
                $result = $this->loadItems($model->penjualan_id);

                $transaction->commit();
                echo json_encode($result);



            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                
                throw $e;
            }

            

        }
    }

    /**
     * Lists all PenjualanItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenjualanItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PenjualanItem model.
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
     * Creates a new PenjualanItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PenjualanItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PenjualanItem model.
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
     * Deletes an existing PenjualanItem model.
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
     * Finds the PenjualanItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PenjualanItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PenjualanItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
