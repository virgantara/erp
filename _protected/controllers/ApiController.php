<?php

namespace app\controllers;

use Yii;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * PenjualanController implements the CRUD actions for Penjualan model.
 */
class ApiController extends Controller
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

    public function actionSyncStokDepartemen(){

        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);

        $dept_id = $_POST['dept_id'];

        $response = $client->post('/integra/generate/stok', ['dept_id'=>$dept_id])->send();

        $result = [];
        
        if ($response->isOk) {
            $result = $response->data['values'];   
        }

        echo \yii\helpers\Json::encode($result);
    }

    
    public function actionAjaxJenisRawat() {
        
        $data = [
            1 => 'Rawat Jalan',
            2 => 'Rawat Inap'
        ];
        foreach ($data as $q => $v) {
            $out[] = [
                'id' => $q,
                'label' => $v,
                
            ];
        }
        echo Json::encode($out);
    }

    public function actionAjaxAllRefUnit() {

        $tipe = $_POST['tipe'] == 1 ? 2 : 1;
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $response = $client->get('/m/unit/list', ['tipe'=>$tipe])->send();
        
        $out = [];
        
        if ($response->isOk) {
            $result = $response->data['values'];
            
            if(!empty($result))
            {
                foreach ($result as $d) {
                    $label = $d['unit_tipe'] == 2 ? 'Poli '.$d['NamaUnit'] : $d['NamaUnit'];
                    $out[] = [
                        'id' => $d['KodeUnit'],
                        'label'=> $label,
                       
                    ];
                }    
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Data tidak ditemukan',
                   
                ];
            }
            
        }

        echo \yii\helpers\Json::encode($out);

      
    }

    public function actionAjaxGetRefUnit() {

        $q = $_GET['term'];
        $tipe = $_GET['tipe'] == 1 ? 2 : 1;
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $response = $client->get('/m/unit', ['key' => $q,'tipe'=>$tipe])->send();
        
        $out = [];
        
        if ($response->isOk) {
            $result = $response->data['values'];
            
            if(!empty($result))
            {
                foreach ($result as $d) {
                    $label = $d['unit_tipe'] == 2 ? 'Poli '.$d['NamaUnit'] : $d['NamaUnit'];
                    $out[] = [
                        'id' => $d['KodeUnit'],
                        'label'=> $label,
                       
                    ];
                }    
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Data tidak ditemukan',
                   
                ];
            }
            
        }

        echo \yii\helpers\Json::encode($out);

      
    }

    public function actionAjaxGetDokter() {

        $q = $_GET['term'];
        
        // $list = Pasien::find()->addFilterWhere(['like',])
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $response = $client->get('/d/nama', ['key' => $q])->send();
        
        $out = [];
        
        if ($response->isOk) {
            $result = $response->data['values'];
            foreach ($result as $d) {
                $out[] = [
                    'id' => $d['id_dokter'],
                    'label'=> $d['nama_dokter'],
                   
                ];
            }
        }
        
        echo \yii\helpers\Json::encode($out);

      
    }

    public function actionAjaxPasienDaftar() {

        $q = $_GET['term'];
        
        // $list = Pasien::find()->addFilterWhere(['like',])
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $jenis_rawat = $_GET['jenis_rawat'];
        
        $response = $client->get('/p/daftar/rm', ['key' => $q,'jenis'=>$jenis_rawat])->send();
        
        $out = [];

        
        if ($response->isOk) {
            $result = $response->data['values'];

            if(!empty($result))
            {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['NoMedrec'],
                        'label'=> $d['NAMA'].' '.$d['NoMedrec'].' '.$d['NamaUnit'].' '.date('d/m/Y',strtotime($d['TGLDAFTAR'])),
                        'nodaftar'=> $d['NODAFTAR'],
                        'namapx' => $d['NAMA'],
                        'jenispx'=> $d['KodeGol'],
                        'namagol' => $d['NamaGol'],
                        'tgldaftar' => $d['TGLDAFTAR'],
                        'jamdaftar' => $d['JamDaftar'],
                        'kodeunit' => $d['KodeUnit'],
                        'id_rawat_inap' => !empty($d['id_rawat_inap']) ? $d['id_rawat_inap'] : '',
                        'namaunit' => $d['unit_tipe'] == 2 ? 'Poli '.$d['NamaUnit'] : $d['NamaUnit'],
                        'id_dokter' => !empty($d['id_dokter']) ? $d['id_dokter'] : '',
                        'nama_dokter' => !empty($d['nama_dokter']) ? $d['nama_dokter'] : '', 
                    ];
                }
            }

            else
            {
                $out[] = [
                    'id' => 0,
                    'label'=> 'Tidak ada data pasien dengan data '.$q.' yang sedang dirawat',
                   
                ];
            }
        }
        

        echo \yii\helpers\Json::encode($out);

      
    }

    public function actionAjaxPasien() {

        $q = $_GET['term'];
        
        // $list = Pasien::find()->addFilterWhere(['like',])
       
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        $response = $client->get('/pasien/nama', ['key' => $q])->send();
        
        $out = [];
        
        if ($response->isOk) {
            $result = $response->data['values'];
            foreach ($result as $d) {
                $out[] = [
                    'id' => $d['NoMedrec'],
                    'label'=> $d['NAMA'].' - '.$d['NoMedrec']
                ];
            }
        }
        
        echo \yii\helpers\Json::encode($out);

      
    }
    
}
