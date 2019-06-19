<?php

namespace app\controllers;

use Yii;
use app\models\BarangOpname;
use app\models\BarangOpnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DepartemenStok;

/**
 * BarangOpnameController implements the CRUD actions for BarangOpname model.
 */
class BarangOpnameController extends Controller
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

    /**
     * Lists all BarangOpname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BarangOpnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BarangOpname model.
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

    public function actionAjaxLoadmore(){
        if (Yii::$app->request->isPost) {
            $page = !empty($_POST['page']) ? $_POST['page'] : 0;
            // $showLimit = 20;
            $offset = $showLimit * $page + 1;


            $date = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
            $dept_id = !empty($_POST['dept_id']) ? $_POST['dept_id'] : 0;
            $tanggal = date('d',strtotime($date));
            $bulan = date('m',strtotime($date));
            $tahun = date('Y',strtotime($date));

            $query = DepartemenStok::find();
            $query->where(['<>','barang.nama_barang','-']);
            $query->andWhere(['barang.is_hapus'=>0]);
            $query->andWhere(['departemen_id'=>$dept_id]);
            $query->joinWith(['barang as barang']);
            // $query->limit($showLimit);
            // $query->offset($offset);
            $query->orderBy(['barang.nama_barang'=>SORT_ASC]);
            $list = $query->all();
            $result = [];

            foreach($list as $q => $m)
            {

                $stokOp = BarangOpname::find()->where([
                    'departemen_stok_id' => $m->id,
                    'tahun' => $tahun.$bulan
                ])->one();



                $result[] = [
                    'id' => $m->id,
                    'kode' => $m->barang->kode_barang,
                    'nama' => $m->barang->nama_barang,
                    'satuan' => $m->barang->id_satuan,
                    'stok' => $m->stok,
                    'stok_riil' => !empty($stokOp) ? $stokOp->stok_riil : 0
                ];
            }

            $records = [
                'code' => 200,
                'message' => 'success',
                'items' => $result,
                'offset' => $offset,
                'empty' => count($list) < $showLimit
            ];
            echo json_encode($records);
        }
    }

    public function actionList(){

        $list = [];
        if(!empty($_POST['tanggal']) && !empty($_POST['btn-cari']))
        {

            $tanggal = date('d',strtotime($_POST['tanggal']));
            $bulan = date('m',strtotime($_POST['tanggal']));
            $tahun = date('Y',strtotime($_POST['tanggal']));

            $query = DepartemenStok::find();
            $query->where(['<>','barang.nama_barang','-']);
            $query->andWhere(['departemen_id'=>$_POST['dept_id']]);
            // $query->andWhere(['departemen_id'=>Yii::$app->user->identity->departemen]);
            // $query->andWhere(['tahun'=>$tahun.$bulan]);
            $query->andWhere(['barang.is_hapus'=>0]);
            $query->joinWith(['barang as barang']);
            $query->orderBy(['barang.nama_barang'=>SORT_ASC]);
            $list = $query->all();

        }

        return $this->render('create', [
            'list' => $list,
            'model' => $model,

        ]);
    }

    public function actionAjaxOpname()
    {
        if (Yii::$app->request->isAjax) 
        {
            $transaction = \Yii::$app->db->beginTransaction();

            try 
            {

                $dataPost = $_POST['dataPost'];
                $tanggal = date('d',strtotime($dataPost['tanggal']));
                $bulan = date('m',strtotime($dataPost['tanggal']));
                $tahun = date('Y',strtotime($dataPost['tanggal']));
                $stok_riil = $dataPost['stok_riil'] ?: 0;
                $stok_id = $dataPost['sid'];
                $barang_id = $dataPost['bid'];
                $stok = $dataPost['stok'];

                $model = BarangOpname::find()->where([
                    'departemen_stok_id' => $stok_id,
                    'bulan' => $bulan,
                    'tahun' => $tahun.$bulan
                ])->one();


                $opnameLalu = BarangOpname::find()->where([
                    'barang_id' => $barang_id,
                    'tahun' => $tahun_lalu.$bulan_lalu
                ])->one();

                if(empty($model))
                    $model = new BarangOpname;

                $model->barang_id = $barang_id;
                $model->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
                $model->departemen_stok_id = $stok_id;
                $model->stok = $stok;
                $model->stok_riil = $stok_riil;
                $model->stok_lalu = !empty($opnameLalu) ? $opnameLalu->stok_riil : 0;
                $model->bulan = $bulan;
                $model->tahun = $tahun.$bulan;
                $model->tanggal = date('Y-m-d');
                

                if($model->validate())
                {

                    $model->save();

                    $params = [
                        'barang_id' => $barang_id,
                        'status' => 1,
                        'kode_transaksi' => 'OPNAME_'.$model->id,
                        'qty' => $stok_riil,
                        'tanggal' => date('Y-m-01'),
                        'departemen_id' => $_POST['dept_id_pilih'],
                        'stok_id' => $stok_id,
                        'keterangan' => 'Opname Tahun '.date('Y').' bulan '.date('m'),
                    ];
                    $ks = \app\models\KartuStok::find()->where(['kode_transaksi'=>'OPNAME_'.$model->id])->one();
                        

                    if(empty($ks))
                        \app\models\KartuStok::createKartuStok($params);
                    else{
                        \app\models\KartuStok::updateKartuStok($params);
                    }
                }
                else{
                    
                    $errors = \app\helpers\MyHelper::logError($model);
                    $results = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => $errors
                    ];

                    echo json_encode($results);
                }
                    
                
                $transaction->commit();
                $results = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Data Tersimpan'
                ];

                echo json_encode($results);
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
     * Creates a new BarangOpname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $list = [];

        if(!empty($_POST['cari']))
        {
            $tanggal = date('d',strtotime($_POST['tanggal']));
            $bulan = date('m',strtotime($_POST['tanggal']));
            $tahun = date('Y',strtotime($_POST['tanggal']));

            $query = DepartemenStok::find();
            $query->where(['<>','barang.nama_barang','-']);
            $query->andWhere(['departemen_id'=>$_POST['dept_id']]);
            // $query->andWhere(['departemen_id'=>Yii::$app->user->identity->departemen]);
            // $query->andWhere(['tahun'=>$tahun.$bulan]);
            $query->andWhere(['barang.is_hapus'=>0]);
            $query->joinWith(['barang as barang']);
            $query->orderBy(['barang.nama_barang'=>SORT_ASC]);
            $list = $query->all();
        }

        if(!empty($_POST['simpan']))
        {

            $tanggal = date('d',strtotime($_POST['tanggal_pilih']));
            $bulan = date('m',strtotime($_POST['tanggal_pilih']));
            $tahun = date('Y',strtotime($_POST['tanggal_pilih']));
            

            $query = DepartemenStok::find();
            $query->where(['<>','barang.nama_barang','-']);
            $query->andWhere(['departemen_id'=>$_POST['dept_id_pilih']]);
            // $query->andWhere(['departemen_id'=>Yii::$app->user->identity->departemen]);
            $query->andWhere(['barang.is_hapus'=>0]);
            $query->joinWith(['barang as barang']);
            $query->orderBy(['barang.nama_barang'=>SORT_ASC]);
            $list = $query->all();

            // $date = date('Y-m-d',strtotime($_POST['tanggal_pilih']));
            $prev_month_ts = strtotime($tahun.'-'.$bulan.'-15 -1 month');
            $prev_month_ts = date('Y-m-d', $prev_month_ts); 
            $bulan_lalu = date('m',strtotime($prev_month_ts));
            $tahun_lalu = date('Y',strtotime($prev_month_ts));

            $transaction = \Yii::$app->db->beginTransaction();

            try 
            {

                foreach($list as $m)
                {
                    $stok_riil = $_POST['stok_riil_'.$m->id] ?: 0;

                    $model = BarangOpname::find()->where([
                        'departemen_stok_id' => $m->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun.$bulan
                    ])->one();


                    $opnameLalu = BarangOpname::find()->where([
                        'barang_id' => $m->barang_id,
                        'tahun' => $tahun_lalu.$bulan_lalu
                    ])->one();

                    if(empty($model))
                        $model = new BarangOpname;

                    $model->barang_id = $m->barang_id;
                    $model->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
                    $model->departemen_stok_id = $m->id;
                    $model->stok = $m->stok;
                    $model->stok_riil = $stok_riil;
                    $model->stok_lalu = !empty($opnameLalu) ? $opnameLalu->stok_riil : 0;
                    $model->bulan = $bulan;
                    $model->tahun = $tahun.$bulan;
                    $model->tanggal = date('Y-m-d');
                    

                    if($model->validate()){

                        $model->save();

                        $params = [
                            'barang_id' => $m->barang_id,
                            'status' => 1,
                            'kode_transaksi' => 'OPNAME_'.$model->id,
                            'qty' => $stok_riil,
                            'tanggal' => date('Y-m-01'),
                            'departemen_id' => $_POST['dept_id_pilih'],
                            'stok_id' => $m->id,
                            'keterangan' => 'Opname Tahun '.date('Y').' bulan '.date('m'),
                        ];
                        $ks = \app\models\KartuStok::find()->where(['kode_transaksi'=>'OPNAME_'.$model->id])->one();
                            

                        if(empty($ks))
                            \app\models\KartuStok::createKartuStok($params);
                        else{
                            \app\models\KartuStok::updateKartuStok($params);

                        }
                    }
                    else{
                        
                        // $errors = \app\helpers\MyHelper::logError($m);
                        return $this->render('create', [
                            'list' => $list,
                            'model' => $model,
                        ]);
                    }
                    
                }
                Yii::$app->session->setFlash('success', "Data tersimpan");

                $transaction->commit();
                return $this->redirect(['create']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                
                throw $e;
            }
        }
        // print_r(count($_POST['stok_riil']));exit;

        return $this->render('create', [
            'list' => $list,
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing BarangOpname model.
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
     * Deletes an existing BarangOpname model.
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
     * Finds the BarangOpname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BarangOpname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BarangOpname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
