<?php

namespace app\controllers;

use Yii;
use app\models\Kas;
use app\models\KasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Saldo;

/**
 * KasController implements the CRUD actions for Kas model.
 */
class KasController extends Controller
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

    public function actionUpdateSaldo($uk)
    {
        Kas::updateSaldo($uk,5,2018);
    }

    public function actionKeluar($uk='')
    {
        $model = new Kas();

        $session = Yii::$app->session;
           
        $saldo_id = 0;
        
        $userLevel = Yii::$app->user->identity->access_role;    
        
        $userPt = Yii::$app->user->identity->perusahaan_id;
        $model->perusahaan_id = $userPt;
        $model->penanggung_jawab = Yii::$app->user->identity->username;

        if ($model->load(Yii::$app->request->post())) {
            $model->jenis_kas = 0;    
            $model->kas_besar_kecil = $uk;
            $model->perusahaan_id = $userPt;

            $model->save();    
            $tgl = explode('-', $model->tanggal);

            $y = $tgl[0];
            $m = $tgl[1];

            Kas::updateSaldo($uk,$m,$y);
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['/kas/index','uk'=>$uk]);
        }

        $jenis = 0;

        return $this->render('create', [
            'model' => $model,
            'jenis' => $jenis,
            'uk'=> $uk
        ]);
    }

    public function actionMasuk($uk='')
    {
        $model = new Kas();

        $session = Yii::$app->session;
         
        $userLevel = Yii::$app->user->identity->access_role;    
        
        $userPt = Yii::$app->user->identity->perusahaan_id;
        $model->perusahaan_id = $userPt;
        $model->penanggung_jawab = Yii::$app->user->identity->username;

        if ($model->load(Yii::$app->request->post())) {
            $model->jenis_kas = 1;    
            $model->perusahaan_id = $userPt;
            $model->kas_besar_kecil = $uk;
            $model->save();    
            $tgl = explode('-', $model->tanggal);

            $y = $tgl[0];
            $m = $tgl[1];

            Kas::updateSaldo($uk,$m,$y);
            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['/kas/index','uk'=>$uk]);
        }

        $jenis = 1;

        return $this->render('create', [
            'model' => $model,
            'jenis' => $jenis,
            'uk'=> $uk
        ]);
    }

    /**
     * Lists all Kas models.
     * @return mixed
     */
    public function actionIndex($uk = '')
    {
        $searchModel = new KasSearch();
        if(!empty($_POST['bulan']) && !empty($_POST['tahun']))
        {
            $y = $_POST['tahun'];
            $m = $_POST['bulan'];
            $searchModel->start_date = $y.'-'.$m.'-01';
            $searchModel->end_date = $y.'-'.$m.'-'.date('t');
        }



        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$uk);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uk' => $uk
        ]);
    }

    /**
     * Displays a single Kas model.
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
     * Creates a new Kas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kas model.
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

        $jenis = $model->jenis_kas;

        return $this->render('update', [
            'model' => $model,
            'jenis' => $jenis
        ]);
    }

    /**
     * Deletes an existing Kas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$uk)
    {
        $this->findModel($id)->delete();
        

        $y = date('Y');
        $m = date('m');

        Kas::updateSaldo($uk,$m,$y);
        return $this->redirect(['index','uk'=>$uk]);
    }

    /**
     * Finds the Kas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
