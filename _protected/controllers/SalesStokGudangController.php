<?php

namespace app\controllers;

use Yii;
use app\models\SalesStokGudang;
use app\models\SalesStokGudangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\SalesMasterBarang;
use app\models\SalesMasterBarangSearch;

use yii\db\Query;
use yii\helpers\Json;


/**
 * SalesStokGudangController implements the CRUD actions for SalesStokGudang model.
 */
class SalesStokGudangController extends Controller
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

    public function actionStatus()
    {
        $searchModel = new SalesStokGudangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('status', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAjaxBarang($q = null) {
        
        $query = new Query;
    
        $query->select('b.id_barang, kode_barang,nama_barang, g.id_stok, b.id_satuan as satuan')
            ->from('erp_sales_master_barang b')
            ->join('JOIN','erp_sales_stok_gudang g','g.id_barang=b.id_barang')
            ->where('(nama_barang LIKE "%' . $q .'%" OR kode_barang LIKE "%' . $q .'%") AND b.is_hapus = 0')
            ->orderBy('nama_barang')
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = [
                'id' => $d['id_barang'],
                'kode' => $d['kode_barang'],
                'nama' => $d['nama_barang'],
                'id_stok' => $d['id_stok'],
                'satuan' => $d['satuan'],
            ];
        }
        echo Json::encode($out);
    }


    public function actionGetGudangByBarang()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getGudangByBarangList($cat_id); 
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

    private function getGudangByBarangList($idbarang)
    {
        $list = SalesStokGudang::find()->where(['id_barang'=>$idbarang])->all();

        $result = [];
        foreach($list as $item)
        {
            $result[] = [
                'id' => $item->id_gudang,
                'name' => $item->gudang->nama
            ];
        }

        return $result;
    }

    public function actionGetBarangStok()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getBarangListStok($cat_id); 
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

    private function getBarangListStok($id_stok)
    {
        $list = SalesStokGudang::find()->where(['id_stok'=>$id_stok])->all();

        $result = [];
        foreach($list as $item)
        {
            $result[] = [
                'id' => $item->id_barang,
                'name' => $item->barang->nama_barang
            ];
        }

        return $result;
    }

    public function actionGetBarang()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getBarangList($cat_id); 
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

    private function getBarangList($id_gudang)
    {
        $list = SalesStokGudang::find()->where(['id_gudang'=>$id_gudang])->all();

        $result = [];
        foreach($list as $item)
        {
            $result[] = [
                'id' => $item->id_stok,
                'name' => $item->barang->nama_barang
            ];
        }

        return $result;
    }

    /**
     * Lists all SalesStokGudang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesStokGudangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesStokGudang model.
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
     * Creates a new SalesStokGudang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($barang_id = '')
    {
        $model = new SalesStokGudang();

        $model->id_barang = !empty($barang_id) ? $barang_id : '';

        if ($model->load(Yii::$app->request->post())) {
            $temp = SalesStokGudang::find()->where([
                'id_gudang'=> $model->id_gudang,
                'id_barang'=> $model->id_barang,
                'is_hapus' => 0
            ])->one();

            if(!empty($temp)){
                $temp->load(Yii::$app->request->post());
                $temp->save();
            }

            else{
                $model->save();
            }

            Yii::$app->session->setFlash('success', "Data tersimpan");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SalesStokGudang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data terupdate");
            return $this->redirect(['sales-gudang/view','id'=>$model->id_gudang]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SalesStokGudang model.
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

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }
    
    /**
     * Finds the SalesStokGudang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesStokGudang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesStokGudang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
