<?php

namespace app\controllers;

use Yii;
use app\models\RequestOrderItem;
use app\models\RequestOrderItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequestOrderItemController implements the CRUD actions for RequestOrderItem model.
 */
class RequestOrderItemController extends Controller
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
        if (Yii::$app->request->isPost) {


            $model = new RequestOrderItem();
            $model->ro_id = $_POST['ro_id'];
            $model->stok_id = $_POST['stok_id'];
            $model->jumlah_minta = !empty($_POST['jml']) ? $_POST['jml'] : 0;
            $model->item_id = $_POST['item_id'];
            $model->satuan = '-';
            $model->keterangan = '-';
            

            if($model->validate())
            {
                $model->save();
            }

            else{
                print_r($model->errors);exit;
            }
        }
    }

    /**
     * Lists all RequestOrderItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RequestOrderItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RequestOrderItem model.
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
     * Creates a new RequestOrderItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ro_id = '')
    {
        $model = new RequestOrderItem();

        $model->ro_id = !empty($ro_id) ? $ro_id : '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data telah disimpan");
            return $this->redirect(['/request-order/view', 'id' => $ro_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RequestOrderItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$ro_id = '')
    {
        $model = $this->findModel($id);

        $model->ro_id = !empty($ro_id) ? $ro_id : '';

        if ($model->load(Yii::$app->request->post())) {
            $parent = $model->ro;
            $parent->is_approved = 2;
            $parent->save();
            $model->save();
            Yii::$app->session->setFlash('success', "Data telah disimpan");
            return $this->redirect(['/request-order/view', 'id' => $ro_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RequestOrderItem model.
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
     * Finds the RequestOrderItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RequestOrderItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequestOrderItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
