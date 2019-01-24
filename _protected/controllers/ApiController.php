<?php

namespace app\controllers;

use Yii;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\MyHelper;
use yii\httpclient\Client;


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
        $response = $client->get('/p/daftar', ['key' => $q,'jenis'=>$jenis_rawat])->send();
        
        $out = [];
        
        if ($response->isOk) {
            $result = $response->data['values'];
            foreach ($result as $d) {
                $out[] = [
                    'id' => $d['NoMedrec'],
                    'label'=> $d['NAMA'].' '.$d['NoMedrec'],
                    'nodaftar'=> $d['NODAFTAR'],
                    'jenispx'=> $d['KodeGol'],
                    'namagol' => $d['NamaGol'],
                    'tgldaftar' => $d['TGLDAFTAR'],
                    'jamdaftar' => $d['JamDaftar'],
                    'kodeunit' => $d['KodeUnit'],
                    'namaunit' => $d['unit_tipe'] == 2 ? 'Poli '.$d['NamaUnit'] : $d['NamaUnit']  
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
