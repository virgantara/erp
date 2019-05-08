<?php

namespace app\modules\billing;

use app\helpers\MyHelper;
use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * billing module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\billing\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function updateTagihanObat($params)
    {
        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);

            $response = $client->post('/obat/tagihan/update', $params)->send();

            if ($response->isOk) {
                $result = $response->data['values'];   
            }
        }
        catch(\Exception $e)
        {
            $result = 'Error: '.$e->getMessage();
        }

        return $result;
    }

    public function getPasien($custid)
    {
        $api_baseurl = \Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);

        $response = $client->get('/pasien/rm', ['key' => $model->customer_id])->send();
        
        $out = [];


        
        if ($response->isOk) {
            $result = $response->data['values'];

            if(!empty($result))
            {
                foreach ($result as $d) {
                    $out[] = [
                        'id' => $d['NoMedrec'],
                        'label'=> $d['NAMA'],
                        'alamat' => $d['ALAMAT'],  
                    ];
                }
            }
        }

        return $out;
    }

    public function updateTagihan($params)
    {
        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);

            $response = $client->post('/tagihan/update', $params)->send();

            if ($response->isOk) {
                $result = $response->data['values'];   
            }
        }
        catch(\Exception $e)
        {
            $result = 'Error: '.$e->getMessage();
        }

        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $headers = [
                'client_id' => $params['origin'],

            ];
            $response = $client->createRequest()
                ->setMethod('POST')
                ->addHeaders($headers)
                ->setUrl('/tagihan/receiveClientMsg')
                ->setData($params)
                ->send();
            if ($response->isOk) {
                $result = $response->data['values'];   
            }
        }

        catch(\Exception $e)
        {
            $result = 'Error: '.$e->getMessage();
        }

        return $result;
    }

    public function getTagihan($id)
    {
        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);

            $response = $client->get('/tagihan/get', ['id'=>$id])->send();
            

            if ($response->isOk) {
                $result = $response->data['values'];   
            }
        }
        
        catch(\Exception $e)
        {
            $result = 'Error: '.$e->getMessage();
        }

        return $result;
    }

    public function insertTagihan($params)
    {
        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);
            $params['origin'] = 'integra';
            $response = $client->post('/tagihan/insert', $params)->send();

            
            
            if ($response->isOk) {
                $result = $response->data['values'];   
            }
        }
        catch(\Exception $e)
        {
            $result = 'Error: '.$e->getMessage();
        }

        return $result;
    }

    public function listTagihan($search, $by, $limit, $page)
    {
        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);

            $params = [
                'limit' => $limit,
                'page' => $page,
                'search' => $search,
                'by' => $by
            ];
            $response = $client->post('/tagihan/list', $params)->send();
             // print_r($response);exit;
            if ($response->isOk) {
                $result = $response->data['values'];   
            }

           
        }

        catch(\Exception $e)
        {
            $result = 'Error: '.$e->getMessage();
        }

        return $result;
    }

}
