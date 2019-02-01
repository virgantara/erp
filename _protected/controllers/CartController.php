<?php

namespace app\controllers;

use Yii;
use app\models\Cart;
use app\models\DepartemenStok;
use app\models\CartSearch;
use app\models\Penjualan;
use app\models\PenjualanItem;
use app\models\PenjualanSearch;
use app\models\PenjualanResep;
use app\models\PenjualanResepSearch;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{

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
        echo json_encode(\app\helpers\MyHelper::getRandomString());
    }
    
    private function loadItems($kode_trx)
    {
        $rows = Cart::find()->where(['kode_transaksi'=>$kode_trx])->all();
        $items = [];
        $total = 0;
        foreach($rows as $row)
        {
            $total += $row->subtotal;
            $items[] = [
                'id' => $row->id,
                'departemen_stok_id' => $row->departemen_stok_id,
                'barang_id' => $row->departemenStok->barang_id,
                'kode_barang' => $row->departemenStok->barang->kode_barang,
                'nama_barang' => $row->departemenStok->barang->nama_barang,
                'kekuatan' => $row->kekuatan,
                'dosis_minta' => $row->dosis_minta,
                'qty' => $row->qty,
                'harga' => $row->departemenStok->barang->harga_jual,
                'subtotal' => $row->subtotal,
                'signa1' => $row->signa1,
                'signa2' => $row->signa2,
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

    public function actionAjaxLoadItem(){
        if (Yii::$app->request->isPost) {
            $dataItem = $_POST['dataItem'];
            $list_cart = $this->loadItems($dataItem['kode_transaksi']);
            
            echo json_encode($list_cart);
        }
    }

    public function actionAjaxBayar()
    {
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {

                $model = Penjualan::find()->where(['kode_transaksi'=>$dataItem['kode_transaksi']])->one();

                if(empty($model))
                    $model = new Penjualan;
                
                $rawat = [1=>'RJ',2=>'RI'];
                $model->jenisRawat = $rawat[$dataItem['jenis_rawat']];
                
                $model->attributes = $dataItem;

                $model->departemen_id = Yii::$app->user->identity->departemen;
               
                if($model->validate())
                {
                    $model->save();

                    // $jr = PenjualanResep::find()->where(['penjualan_id' => $model->id,''])->all();
                    // if(empty($jr))
                        $jr = new PenjualanResep;
                    
                    $jr->attributes = $dataItem;
                    $jr->kode_daftar = $dataItem['kode_daftar'];
                    $jr->penjualan_id = $model->id;
                    $jr->dokter_id = $dataItem['dokter_id'];
                    $jr->jenis_resep_id = $dataItem['jenis_resep_id'];
                    $jr->pasien_id = $dataItem['customer_id'];
                    $jr->jenis_resep_id = $dataItem['jenis_resep_id'];
                    $jr->jenis_rawat = $dataItem['jenis_rawat'];
                    if($jr->validate())
                        $jr->save();
                    else{

                        $errors = \app\helpers\MyHelper::logError($jr);
                        print_r($errors);exit;
                    }

                    $listCart = Cart::find()->where(['kode_transaksi' => $dataItem['kode_penjualan']])->all();
                    
                    foreach($listCart as $item)
                    {
                        $m = new PenjualanItem;
                        $m->penjualan_id = $model->id;
                        $m->attributes = $item->attributes;
                        $m->stok_id = $item->departemen_stok_id;
                        $m->is_racikan = $item->is_racikan;

                        $params = [
                            'barang_id' => $item->departemenStok->barang_id,
                            'status' => 0,
                            'qty' => $item->qty,
                            'tanggal' => date('Y-m-d'),
                            'departemen_id' => Yii::$app->user->identity->departemen,
                            'stok_id' => $item->departemen_stok_id,
                            'keterangan' => 'Jual '.$item->departemenStok->barang->kode_barang,
                        ];
                          
                        \app\models\KartuStok::createKartuStok($params);

                        if($m->validate())
                            $m->save();
                        else{
                            $errors = \app\helpers\MyHelper::logError($m);
                            
                            $result = [
                                'code' => 510,
                                'message' => $errors
                            ]; 

                            exit;
                        }
                    }

                    $result = [
                        'code' => 200,
                        'message' => 'success',
                        'items' => $model->id
                    ];


                }

                else{

                    $errors = \app\helpers\MyHelper::logError($model);
                            
                    $result = [
                        'code' => 510,
                        'message' => $errors
                    ];
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

    public function actionAjaxDelete(){
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $model = Cart::findOne($dataItem);
                $model->delete();
              
                $result = $this->loadItems($model->kode_transaksi);

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

    public function actionAjaxSimpanItem(){
        if (Yii::$app->request->isPost) {

            $dataItem = $_POST['dataItem'];

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {


                $model = new Cart;
                $model->attributes = $dataItem;
              
               
                if($model->validate())
                {
                    $model->save();
                    $result = $this->loadItems($dataItem['kode_transaksi']);


                }

                else{

                    $errors = \app\helpers\MyHelper::logError($model);
                            
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
     * Lists all Cart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
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
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}
