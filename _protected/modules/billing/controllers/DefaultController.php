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

    public function actionTest(){
         $billingModule = \Yii::$app->getModule('billing');

        $params = [
            'nama' => 'NANDA YUNITA ROHMAH, NN',
            'kode_trx' => 'APTRJ2019051730',
            'trx_date' => '20190517055505',
            'jenis_tagihan' => 'OBAT',
            'person_in_charge' => 'drg. Sri wahyuni',
            'custid' => '149028',
            'issued_by' => 'Apotik TImur',
            'keterangan' => 'Tagihan Resep : APTRJ2019051730',
            'nilai' => '41470',
            'jenis_customer' => 'UMUM',
            'status_bayar' => '1'
        ];



       $result =     $billingModule->updateTagihan($params);
       print_r($result);exit;
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
