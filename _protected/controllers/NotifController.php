<?php

namespace app\controllers;

use Yii;
use app\models\Notif;
use app\models\NotifSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotifController implements the CRUD actions for Notif model.
 */
class NotifController extends Controller
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

     public function actionAjaxCountNotif()
    {
        $query = new \yii\db\Query;
    
        $query->select('count(*) as jml')
            ->from('erp_notif n')
            ->join('JOIN','erp_departemen_user du','n.departemen_from_id=du.departemen_id')
            ->join('JOIN','erp_departemen d','d.id=du.departemen_id')
            ->where('n.departemen_to_id='.Yii::$app->user->identity->id.' AND n.is_read_to = 0');
        $command = $query->createCommand();
        $data = $command->queryOne();
        
        
       
        $out = ['jumlah' => $data['jml']];
     

        
        echo \yii\helpers\Json::encode($out);
    }

    public function actionAjaxNotif()
    {
        $query = new \yii\db\Query;
    
        $query->select('n.id, keterangan, d.nama, n.item_id')
            ->from('erp_notif n')
            ->join('JOIN','erp_departemen_user du','n.departemen_from_id=du.departemen_id')
            ->join('JOIN','erp_departemen d','d.id=du.departemen_id')
            ->where('n.departemen_to_id='.Yii::$app->user->identity->id.' AND n.is_read_to = 0')
            ->orderBy('n.created DESC')
            ->limit(8);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            if(!empty($d['id']))
            {
                $out[] = [
                    'id' => $d['id'],
                    'keterangan' => $d['keterangan'].' '.$d['nama'],
                    'nama' => $d['nama'],
                    
                    'url' => \yii\helpers\Url::toRoute(['/request-order/view','id'=>$d['item_id']])
                ];
            }
        }

        $total = 0;
        $du = \app\models\DepartemenUser::find()->where(['user_id'=>Yii::$app->user->identity->id])->all();
        foreach($du as $d)
        {
            $listNotif = Notif::find();
            $listNotif->where('departemen_to_id = :p1 AND is_read_to = 0',[':p1'=>$d->departemen_id]);
        
            foreach($listNotif->all() as $notif)
            {
                $notif->is_read_to = 1;
                $notif->save();
            }
        }
        
        echo \yii\helpers\Json::encode($out);
    }

    /**
     * Lists all Notif models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notif model.
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
     * Creates a new Notif model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notif();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Notif model.
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
     * Deletes an existing Notif model.
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
     * Finds the Notif model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notif the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notif::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
