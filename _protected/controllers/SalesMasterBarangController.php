<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\BarangHarga;
use app\models\SalesMasterBarang;
use app\models\SalesMasterBarangSearch;
use app\models\BbmDispenser;
use yii\helpers\Json;
use yii\db\Query;
/**
 * SalesMasterBarangController implements the CRUD actions for SalesMasterBarang model.
 */
class SalesMasterBarangController extends Controller
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

    public function actionAjaxSearch($term)
    {
        if (Yii::$app->request->isAjax) {

            $results = [];

            $q = addslashes($term);

            foreach(SalesMasterBarang::find()->where(['like','nama_barang',$q])->all() as $model) {
                $results[] = [
                    'id' => $model->id_barang,
                    'label' => $model->nama_barang
                ];
            }
            echo Json::encode($results);
        }
    }

     public function actionAjaxBarang($q = null, $id = null) {
        $userPt = Yii::$app->user->identity->perusahaan_id;
        

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['id_barang','CONCAT(kode_barang," - ",nama_barang) as text'])
                ->from('erp_sales_master_barang')
                ->where(['id_perusahaan'=>$userPt])
                ->andWhere(['or',['like', 'nama_barang', $q],['like','kode_barang',$q]])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id_barang' => $id, 'text' => SalesMasterBarang::find($id)->nama_barang];
        }
        return $out;
    }

     public function actionGetDispenser()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getDispenserList($cat_id); 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    private function getDispenserList($id)
    {
        $list = BbmDispenser::find()->where(['barang_id'=>$id])->all();

        $result = [];
        foreach($list as $item)
        {
            $result[] = [
                'id' => $item->id,
                'name' => $item->nama
            ];
        }

        return $result;
    }    

    public function actionPilihHarga($id)
    {
        
        $model = BarangHarga::find()->where(['id'=>$id])->one();
        $result = \Yii::$app->db->createCommand("CALL proc_update_barang_harga(:p1,:p2,1,1)") 
              ->bindValue(':p1' , $model->barang_id )
              ->bindValue(':p2' , $id )
              ->execute();
      
        Yii::$app->session->setFlash('success', "Data tersimpan");
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    /**
     * Lists all SalesMasterBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesMasterBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesMasterBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $searchModel = $model->getBarangHargas();
        $searchModelStok = $model->getSalesStokGudangs()->where(['is_hapus'=>0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);

        $dataProviderStok = new ActiveDataProvider([
            'query' => $searchModelStok,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'dataProviderStok' => $dataProviderStok
        ]);
    }

    /**
     * Creates a new SalesMasterBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SalesMasterBarang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_barang]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SalesMasterBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_barang]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SalesMasterBarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_hapus = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesMasterBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesMasterBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesMasterBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
