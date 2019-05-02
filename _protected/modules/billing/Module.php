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

    public function insertTagihan($params)
    {
        $result = [];
        try {
            $api_baseurl = \Yii::$app->params['api_baseurl'];
            $client = new Client(['baseUrl' => $api_baseurl]);

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

}
