<?php

namespace app\modules\billing\controllers;

use yii\web\Controller;
use kartik\mpdf\Pdf;
/**
 * Default controller for the `billing` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListTagihan()
    {
    	$limit = $_POST['limit'];
    	$page = $_POST['page'];
    	$search = $_POST['search'];
        $by = $_POST['by'];
    	$billingModule = \Yii::$app->getModule('billing');

    	$result = $billingModule->listTagihan($search,$by, $limit, $page);

    	echo \yii\helpers\Json::encode($result);
    }

    public function actionView($id)
    {

    	$billingModule = \Yii::$app->getModule('billing');

    	$result = $billingModule->getTagihan($id);

    	return $this->render('view',[
    		'model' => (object)$result
    	]);
    }

    public function actionPrintBayar($id)
    {
        $billingModule = \Yii::$app->getModule('billing');
    	$tagihan = $billingModule->getTagihan($id);

        $pasien = $billingModule->getPasien($tagihan['custid']);

        $content = $this->renderPartial('_print', [
            'model' => (object)$tagihan,            
            'pasien' => $pasien
        ]);

        $pdf = new Pdf(['mode' => 'utf-8', 'format' => [215, 95],
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

    public function actionBayar($id, $kode)
    {
    	$billingModule = \Yii::$app->getModule('billing');
    	$tagihan = $billingModule->getTagihan($id);
    	$params = $tagihan;
    	
    	switch ($kode) {
    		case 1:
    			$params['terbayar'] = $tagihan['nilai'];
    			$params['status_bayar'] = 1;
    			break;

    		case 2:
    			$params['terbayar'] = $tagihan['terbayar'];
    			$params['status_bayar'] = 2;
    			break;
    		
    		default:
    			$params['terbayar'] = 0;
    			$params['status_bayar'] = 0;
    			break;
    	}
    	

    	$result = $billingModule->updateTagihan($params);

    	return $this->redirect(['/billing/default/view','id'=>$id]);
    }
}
