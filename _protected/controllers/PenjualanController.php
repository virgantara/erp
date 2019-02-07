<?php

namespace app\controllers;

use Yii;
use app\models\Cart;
use app\models\Penjualan;
use app\models\PenjualanItem;
use app\models\PenjualanSearch;
use app\models\Pasien;
use app\models\Pendaftaran;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;



/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class PenjualanController extends Controller
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

    public function actionPrintResep($id)
    {
        $model = $this->findModel($id);
        $searchModel = $model->getPenjualanItems();

        $reg = Pendaftaran::findOne($model->kode_daftar);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);


        $content = $this->renderPartial('printResep', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'reg' => $reg
        ]);

        $pdf = new Pdf(['mode' => 'utf-8', 'format' => [75, 130],
            'marginLeft'=>8,
            'marginRight'=>1,
            'marginTop'=>0,
            'marginBottom'=>0,
        ]);
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->SetHeader(false); // call methods or set any properties
        $mpdf->WriteHtml($content); // call mpdf write html
        echo $mpdf->Output('filename', 'I'); // call the mpdf api output as needed
    }

    public function actionPrintPengantar($id)
    {
        $model = $this->findModel($id);
        $searchModel = $model->getPenjualanItems();

        $reg = Pendaftaran::findOne($model->kode_daftar);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel,
        ]);


        $content = $this->renderPartial('printPengantar', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'reg' => $reg
        ]);

        $pdf = new Pdf(['mode' => 'utf-8', 'format' => [75, 130],
           'marginLeft'=>8,
            'marginRight'=>1,
            'marginTop'=>0,
            'marginBottom'=>0,
        ]);
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->SetHeader(false); // call methods or set any properties
        $mpdf->WriteHtml($content); // call mpdf write html
        echo $mpdf->Output('filename', 'I'); // call the mpdf api output as needed
    }

    private function loadItems($id)
    {
        $rows = PenjualanItem::find()->where(['penjualan_id'=>$id])->all();
        $items = [];
        
        $total = 0;
        foreach($rows as $row)
        {
            
            $total += $row->subtotal;
            $results = [
                'kode_barang' => $row->stok->barang->kode_barang,
                'nama_barang' => $row->stok->barang->nama_barang,
                'harga_jual' => $row->stok->barang->harga_jual,
                'harga_beli' => $row->stok->barang->harga_beli,
            ];

            $results = array_merge($results,$row->attributes);
            $items['rows'][] = $results;
            

        } 

        $items['total'] = $total;


        return $items;
    }

    public function actionAjaxLoadItemJual()
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

    

    public function actionAjaxInputItem()
    {
        if (Yii::$app->request->isPost) {
            $dataItem = $_POST['dataItem'];

            $model = Cart::find()->where([
                'kode_transaksi'=>$dataItem['kode_transaksi'],
                'departemen_stok_id' => $dataItem['departemen_stok_id']
            ])->one();

            if(!empty($model)){
                $model->qty += $dataItem['qty'];
            }

            else{
                $model = new Cart;
                $model->attributes = $dataItem;
            }
            
            
            // $model = new PenjualanItem;
            // $model->attributes = $dataItem;
            
            $result = [
                'code' => 'success',
                'message' => 'Data telah disimpan'
            ];
            if($model->validate())
            {
                $model->save();
            }

            else{

                $errors = '';
                foreach($model->getErrors() as $attribute){
                    foreach($attribute as $error){
                        $errors .= $error.' ';
                    }
                }
                        
                $result = [
                    'code' => 'danger',
                    'message' => $errors
                ];
                // print_r();exit;
            }

            $list_cart = Cart::find()->where(['kode_transaksi'=>$dataItem['kode_transaksi']])->all();
            $items = [];
            $total = 0;
            foreach($list_cart as $item){
                $subtotal = $item->departemenStok->barang->harga_jual * $item->qty;
                $items[] = [
                    'id' => $item->departemen_stok_id,
                    'qty' => $item->qty,
                    'kode' => $item->departemenStok->barang->kode_barang,
                    'nama' => $item->departemenStok->barang->nama_barang,
                    'harga' => MyHelper::formatRupiah($item->departemenStok->barang->harga_jual),
                    'subtotal' => MyHelper::formatRupiah($subtotal),
                    'kode_transaksi' => $item->kode_transaksi
                ];

                $total += $subtotal;
            }
            $result['items'] = $items;
            $result['total'] = MyHelper::formatRupiah($total);
            echo json_encode($result);
        }
    }

    /**
     * Lists all Penjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penjualan model.
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
     * Creates a new Penjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penjualan();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $query = Cart::find()->where(['kode_transaksi'=>$model->kode_transaksi]);
        $cart = $query->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'cart' => $cart
        ]);
    }

    /**
     * Deletes an existing Penjualan model.
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
     * Finds the Penjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
