<?php

namespace app\controllers;

use Yii;
use app\models\Perkiraan;
use app\models\PerkiraanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * PerkiraanController implements the CRUD actions for Perkiraan model.
 */
class PerkiraanController extends Controller
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

    public function actionAjaxGetPerkiraan() {
        $userPt = '';
            
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
        }

        $q = $_POST['id'];

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id','CONCAT(kode," - ",nama) as text','(level+1) as level','kode'])
                ->from('erp_perkiraan')
                ->where(['id'=>$q]);
            $command = $query->createCommand();
            $data = $command->queryOne();
            
            $out['results'] = array_values($data);
        }
        
        return $out;
    }

    public function actionAjaxPerkiraan($q = null, $id = null) {
        $userPt = '';
            
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id','CONCAT(kode," - ",nama) as text'])
                ->from('erp_perkiraan')
                ->where(['perusahaan_id'=>$userPt])
                ->andWhere(['or',['like', 'nama', $q],['like','kode',$q]])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Perkiraan::find($id)->nama];
        }
        return $out;
    }

    /**
     * Lists all Perkiraan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PerkiraanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Perkiraan model.
     * @param string $id
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
     * Creates a new Perkiraan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Perkiraan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Perkiraan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data diupdate");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Perkiraan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Perkiraan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Perkiraan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perkiraan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
