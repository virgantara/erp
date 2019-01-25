<?php

namespace app\controllers;

use Yii;

use app\models\SalesStokGudang;
use app\models\SalesFakturBarang;
use app\models\SalesFakturBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalesFakturBarangController implements the CRUD actions for SalesFakturBarang model.
 */
class SalesFakturBarangController extends Controller
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

    private function loadItems($fid)
    {
        $row = SalesFakturBarang::findOne($fid);
        
        $item = $row->attributes;
        
        $item['nama_barang'] = $row->barang->nama_barang;
        $result = [
            'code' => 200,
            'message' => 'success',
            'item' => $item,
        ];

        return $result;
    }

    public function actionAjaxLoadItem(){
        if (Yii::$app->request->isPost) {
            $dataItem = $_POST['fakturItem'];
            $item = $this->loadItems($dataItem);
            
            echo json_encode($item);
        }
    }

    public function actionAjaxUpdate()
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if(!empty($_POST['fakturItem']))
            {
                $data = $_POST['fakturItem'];


                // print_r($data);exit;
                $model = SalesFakturBarang::findOne($data['id_faktur_barang']);
                $model->attributes = $data;
                // $ppn = $model->ppn / 100 * $model->harga_netto;
                $diskon = $model->diskon / 100 * $model->harga_netto;
                $afterDiskon = $model->harga_netto - $diskon;
                $ppn = $model->ppn / 100 * $afterDiskon;
                $model->harga_beli = $model->harga_netto - $diskon + $ppn;
                $model->harga_jual = \app\models\Margin::getMargin($model->harga_beli) + $model->harga_beli;
                // $model->id_faktur = !empty($faktur_id) ? $faktur_id : '';
                $result = [];
                if ($model->save()) {
                    $result = [
                        'code' => 'success',
                        'message' => 'Data tersimpan',
                    ];                

                    $sg = SalesStokGudang::find()->where(['faktur_barang_id'=>$data['id_faktur_barang']])->one();
                    if(!empty($sg))
                    {
                        $sg->jumlah = $model->jumlah;
                        $sg->id_gudang = $model->id_gudang;
                        $sg->id_barang = $model->id_barang;
                        $sg->exp_date = $model->exp_date;
                        $sg->batch_no = $model->no_batch;
                        $sg->faktur_barang_id = $model->id_faktur_barang;                    
                        if($sg->validate()){
                            
                            $sg->save();
                            $barang = $model->barang;
                            $barang->harga_beli = $model->harga_beli;
                            $barang->harga_jual = $model->harga_jual;
                            // print_r($barang->harga_jual);exit;
                            $barang->save();

                        }

                        // $params = [
                        //     'barang_id' => $model->id_barang,
                        //     'status' => 1,
                        //     'qty' => $model->jumlah,
                        //     'tanggal' => $model->faktur->tanggal_faktur,
                        //     'departemen_id' => Yii::$app->user->identity->departemen,
                        //     'stok_id' => $sg->id_stok,
                        //     'keterangan' => 'Ubah Faktur Item '.$model->barang->nama_barang,
                        // ];

                        // \app\models\KartuStok::createKartuStok($params);
                    }
                    
                    $transaction->commit();
                }

                else{
                    $errors = '';
                    foreach($model->getErrors() as $key => $value)
                    {
                        $errors .= $value[0].' ';
                    }
                    $result = [
                        'code' => 'danger',
                        'message' => $errors,
                    ];
                }
                
                echo json_encode($result);

            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }



    public function actionAjaxCreate()
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            if(!empty($_POST['fakturItem']))
            {
                $data = $_POST['fakturItem'];


                // print_r($data);exit;
                $model = new SalesFakturBarang();
                $model->attributes = $data;
                // $ppn = $model->ppn / 100 * $model->harga_netto;
                $diskon = $model->diskon / 100 * $model->harga_netto;
                $afterDiskon = $model->harga_netto - $diskon;
                $ppn = $model->ppn / 100 * $afterDiskon;
                $model->harga_beli = $model->harga_netto - $diskon + $ppn;
                $model->harga_jual = \app\models\Margin::getMargin($model->harga_beli) + $model->harga_beli;
                // $model->id_faktur = !empty($faktur_id) ? $faktur_id : '';
                $result = [];
                if ($model->save()) {
                    $result = [
                        'code' => 'success',
                        'message' => 'Data tersimpan',
                        'items' => $model->faktur->totalFakturFormatted
                    ];                

                    $sg = new SalesStokGudang;

                    $sg->jumlah = $model->jumlah;
                    $sg->id_gudang = $model->id_gudang;
                    $sg->id_barang = $model->id_barang;
                    $sg->exp_date = $model->exp_date;
                    $sg->batch_no = $model->no_batch;
                    $sg->faktur_barang_id = $model->id_faktur_barang;                    
                    if($sg->validate()){
                        
                        $sg->save();
                        $barang = $model->barang;
                        $barang->harga_beli = $model->harga_beli;
                        $barang->harga_jual = $model->harga_jual;
                        // print_r($barang->harga_jual);exit;
                        $barang->save();

                    }
                    $params = [
                        'barang_id' => $model->id_barang,
                        'status' => 1,
                        'qty' => $model->jumlah,
                        'tanggal' => $model->faktur->tanggal_faktur,
                        'departemen_id' => Yii::$app->user->identity->departemen,
                        'stok_id' => $sg->id_stok,
                        'keterangan' => 'Beli '.$model->barang->nama_barang,
                    ];

                    \app\models\KartuStok::createKartuStok($params);
                    $transaction->commit();
                }

                else{
                    $errors = '';
                    foreach($model->getErrors() as $key => $value)
                    {
                        $errors .= $value[0].' ';
                    }
                    $result = [
                        'code' => 'danger',
                        'message' => $errors,
                    ];
                }
                
                echo json_encode($result);

            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


    /**
     * Lists all SalesFakturBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalesFakturBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesFakturBarang model.
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
     * Creates a new SalesFakturBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($faktur_id = '')
    {
        $model = new SalesFakturBarang();

        $model->id_faktur = !empty($faktur_id) ? $faktur_id : '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $stok = SalesStokGudang::find()->where(['id_gudang'=>$model->id_gudang,'id_barang'=>$model->id_barang])->one();
            $stok->jumlah += $model->jumlah;
            $stok->save();
            return $this->redirect(['/sales-faktur/view', 'id' => $model->id_faktur]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SalesFakturBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_faktur_barang]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SalesFakturBarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);                
        $parent = $model->faktur;
        $model->delete();

        $result = [
            'code' => 'success',
            'message' => 'Data terhapus',
            'items' => 'Rp '.$parent->totalFakturFormatted
        ];
        echo json_encode($result);

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the SalesFakturBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SalesFakturBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesFakturBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
