<?php

namespace app\controllers;

use Yii;
use app\models\ObatDetil;
use app\models\Produksi;
use app\models\ProduksiSearch;
use app\models\SalesMasterBarang;
use app\models\DepartemenStok;
use app\models\DepartemenStokSearch;
use app\models\SalesMasterBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProduksiController implements the CRUD actions for Produksi model.
 */
class ProduksiController extends Controller
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

    public function actionAjaxGenerateCode(){
        echo json_encode(strtoupper(\app\helpers\MyHelper::getRandomString(8,8)));
    
    }

    public function actionAjaxUpdateItem()
    {
     
        if (Yii::$app->request->isPost) 
        {

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try 
            {

                $id = $_POST['dataId'];
                $model = $this->findModel($id);
                $model->attributes = $_POST['dataItem'];
                
                if($model->validate())
                {
                    $model->save();
                }

                else
                {
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

                    echo json_encode($result);    
                    exit;
                }

                $result = [
                    'code' => 200,
                    'message' => 'success',
                    'items'=>$this->loadItems($model->parent_id)
                ];

                echo json_encode($result); 
                $transaction->commit();
                

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                
                throw $e;
            }
        }
    }

    public function actionAjaxHapusItem()
    {
        if (Yii::$app->request->isPost) 
        {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try 
            {
                $id = $_POST['dataItem'];
                $model = $this->findModel($id);
                $parent_id = $model->parent_id;
                $model->delete();
                
                $result = [
                    'code' => 200,
                    'message' => 'success',
                    'items'=>$this->loadItems($parent_id)
                ];

                echo json_encode($result); 
                 $transaction->commit();
                

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                
                throw $e;
            }
        }
    }

    private function loadItems($id)
    {
        $rows = Produksi::find()->where(['parent_id'=>$id])->all();
        $items = [];
        foreach($rows as $row)
        {

            $parent_id = $row->parent_id;
            $items[] = [
                'id' => $row->id,
                'kode_barang' => $row->barang->kode_barang,
                'nama_barang' => $row->barang->nama_barang,
                'kekuatan' => $row->kekuatan,
                'dosis_minta' => $row->dosis_minta,
                'jumlah' => $row->jumlah,
                'parent_id' => $row->parent->kode_barang

            ];
        } 


        return $items;
    }

    public function actionAjaxLoadItem()
    {
        if (Yii::$app->request->isPost) 
        {

            $id = $_POST['dataItem'];
            
            $result = [
                'code' => 200,
                'message' => 'success',
                'items'=>$this->loadItems($id)
            ];

            echo json_encode($result);
        }
    }

    public function actionAjaxSimpanItem(){
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];
            $dataPaket = $_POST['dataPaket'];
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try 
            {

                $barang = SalesMasterBarang::find()->where(['nama_barang'=>$dataPaket['nama_barang']])->one();

                if(empty($barang))
                    $barang = new SalesMasterBarang;

                $barang->id_perusahaan = Yii::$app->user->identity->perusahaan_id;
                $barang->perkiraan_id = 90;
                $barang->is_paket = 1;
                $barang->attributes = $dataPaket;

                if($barang->validate())
                {
                    $barang->save();
                }

                else{
                    $errors = '';
                    foreach($barang->getErrors() as $attribute){
                        foreach($attribute as $error){
                            $errors .= $error.' ';
                        }
                    }
                            
                    $result = [
                        'code' => 510,
                        'message' => $errors
                    ];
                    echo json_encode($result);    
                    exit;
                }
                
                $transaction->commit();
                

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                
                throw $e;
            }

            $transaction = $connection->beginTransaction();
            try 
            {


                $model = new Produksi;
                $model->attributes = $dataItem;
                $model->parent_id = $barang->id_barang;
                
                $dept = new DepartemenStok;
                $dept->barang_id = $barang->id_barang;
                $dept->departemen_id = Yii::$app->user->identity->departemen;
                $dept->stok = $dataPaket['stok'];
                $dept->tanggal = date('Y-m-d');
                $dept->bulan = date('m');
                $dept->tahun = date('Y');
                $dept->save();
                
                if($model->validate())
                {
                    $model->save();
                    $result = [
                        'code' => 200,
                        'message' => 'success',
                        'items'=>$this->loadItems($model->parent_id)
                    ];

                    $params = [
                        'barang_id' => $barang->id_barang,
                        'status' => 1,
                        'qty' => $dept->stok,
                        'tanggal' => date('Y-m-d'),
                        'departemen_id' => Yii::$app->user->identity->departemen,
                        'stok_id' => $dept->id,
                        'keterangan' => 'Produksi Paket '.$barang->nama_barang,
                    ];
                      
                    \app\models\KartuStok::createKartuStok($params);

                    $stokDept = DepartemenStok::find()->where([
                        'barang_id'=>$model->barang_id,
                        'departemen_id' => Yii::$app->user->identity->departemen
                    ])->one();

                    if(!empty($stokDept)){
                        $stokDept->stok = $stokDept->stok - $model->jumlah;
                        $stokDept->save(false,['stok']);

                        $params = [
                            'barang_id' => $model->barang_id,
                            'status' => 0,
                            'qty' => $model->jumlah,
                            'tanggal' => date('Y-m-d'),
                            'departemen_id' => Yii::$app->user->identity->departemen,
                            'stok_id' => $stokDept->id,
                            'keterangan' => 'Untuk produksi Paket '.$barang->nama_barang,
                        ];
                          
                        \app\models\KartuStok::createKartuStok($params);
                    }
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
     * Lists all Produksi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepartemenStokSearch();
        $dataProvider = $searchModel->searchPaket(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produksi model.
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
     * Creates a new Produksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Produksi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produksi model.
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
     * Deletes an existing Produksi model.
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
     * Finds the Produksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Produksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produksi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
