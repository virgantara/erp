<?php
namespace app\helpers;

use Yii;


use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * Css helper class.
 */
class MyHelper
{

	public static function ajaxSyncObatInap($params){
        
        $api_baseurl = Yii::$app->params['api_baseurl'];
        $client = new Client(['baseUrl' => $api_baseurl]);
        
        $response = $client->createRequest()
        	->setMethod('POST')
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setUrl('/p/obat/inap')
            ->setData($params)
            ->send();
        
        $out = [];
        if ($response->isOk) {
            
            $out[] = $response->data;
            
            
        }

        return $out;

    }


	public static function loadHistoryItems($customer_id, $tanggal_awal, $tanggal_akhir, $is_separated=1)
    {


        $params['PenjualanItem']['tanggal_awal'] = $tanggal_awal;
        $params['PenjualanItem']['tanggal_akhir'] = $tanggal_akhir;
        $params['customer_id'] = $customer_id;

        $model = new \app\models\PenjualanItemSearch;
        $rows = $model->searchTanggal($params, 1, SORT_DESC,100);
        // $rows = $searchModel->getModels();
  
        $items=[];

        $total_all = 0;
        $listRx = [];

        foreach($rows as $key => $row)
        {

        	$parent = $row->penjualan;
        	
        	$total = 0;
        	// foreach($parent->penjualanItems as $key => $row)
         //    {
                
            $subtotal_bulat = round($row->harga) * ceil($row->qty);
          	$total += $subtotal_bulat;
            $no_resep = $parent->kode_penjualan;
            $tgl_resep = $parent->tanggal;
            // $counter = $key == 0 ? ($q+1) : '';
            $pasien_id = $key == 0 ? $parent->penjualanResep->pasien_id : '';
            $pasien_nama = $key == 0 ? $parent->penjualanResep->pasien_nama : '';
            $dokter = $key == 0 ? $parent->penjualanResep->dokter_nama : '';
            $unit_nama = $key == 0 ? $parent->penjualanResep->unit_nama : '';
            $jenis_resep = $parent->penjualanResep->jenis_resep_id;
            $total_label = \app\helpers\MyHelper::formatRupiah($total,2,$is_separated);

            $results = [
                'id' => $row->id,
                // 'counter' => $counter,
                'kd' => $row->stok->barang->kode_barang,
                'nm' => $row->stok->barang->nama_barang,
                // 'hj' => \app\helpers\MyHelper::formatRupiah($row->stok->barang->harga_jual,2,$is_separated),
                'hb' => \app\helpers\MyHelper::formatRupiah($row->stok->barang->harga_beli,2,$is_separated),
                'hj' => \app\helpers\MyHelper::formatRupiah($row->harga,2,$is_separated),
                'sb' => \app\helpers\MyHelper::formatRupiah($row->subtotal,2,$is_separated),
                'sb_blt' => \app\helpers\MyHelper::formatRupiah($subtotal_bulat,2,$is_separated),
                'sig1' =>$row->signa1,
                'sig2' =>$row->signa2,
                'is_r' =>$row->is_racikan,
                // 'dosis_minta' =>$row->dosis_minta,
                'qty' =>$row->qty,
                'qty_bulat' => ceil($row->qty),
                'no_rx' => !in_array($no_resep, $listRx) ? $no_resep : '',
                'tgl' => !in_array($no_resep, $listRx) ? $tgl_resep : '',
                'd' => $dokter,
                'un' => $unit_nama,
                'jns' => $jenis_resep,
                'px_id' => $pasien_id,
                'px_nm' => $pasien_nama, 
                'tot_lbl' => $total_label,

            ];
            if(!in_array($no_resep, $listRx))
          		$listRx[] = $no_resep;
          		       	
            $items[] = $results;

                
            // }

            $total_all += $total;

        } 

        $result = [
            'code' => 200,
            'message' => 'success',
            'items' => $items,
            'total_all' => \app\helpers\MyHelper::formatRupiah($total_all,2,$is_separated)
        ];
        return $result;
    }

	public static function terbilang($bilangan) {

	  $angka = array('0','0','0','0','0','0','0','0','0','0',
	                 '0','0','0','0','0','0');
	  $kata = array('','satu','dua','tiga','empat','lima',
	                'enam','tujuh','delapan','sembilan');
	  $tingkat = array('','ribu','juta','milyar','triliun');

	  $panjang_bilangan = strlen($bilangan);

	  /* pengujian panjang bilangan */
	  if ($panjang_bilangan > 15) {
	    $kalimat = "Diluar Batas";
	    return $kalimat;
	  }

	  /* mengambil angka-angka yang ada dalam bilangan,
	     dimasukkan ke dalam array */
	  for ($i = 1; $i <= $panjang_bilangan; $i++) {
	    $angka[$i] = substr($bilangan,-($i),1);
	  }

	  $i = 1;
	  $j = 0;
	  $kalimat = "";


	  /* mulai proses iterasi terhadap array angka */
	  while ($i <= $panjang_bilangan) {

	    $subkalimat = "";
	    $kata1 = "";
	    $kata2 = "";
	    $kata3 = "";

	    /* untuk ratusan */
	    if ($angka[$i+2] != "0") {
	      if ($angka[$i+2] == "1") {
	        $kata1 = "seratus";
	      } else {
	        $kata1 = $kata[$angka[$i+2]] . " ratus";
	      }
	    }

	    /* untuk puluhan atau belasan */
	    if ($angka[$i+1] != "0") {
	      if ($angka[$i+1] == "1") {
	        if ($angka[$i] == "0") {
	          $kata2 = "sepuluh";
	        } elseif ($angka[$i] == "1") {
	          $kata2 = "sebelas";
	        } else {
	          $kata2 = $kata[$angka[$i]] . " belas";
	        }
	      } else {
	        $kata2 = $kata[$angka[$i+1]] . " puluh";
	      }
	    }

	    /* untuk satuan */
	    if ($angka[$i] != "0") {
	      if ($angka[$i+1] != "1") {
	        $kata3 = $kata[$angka[$i]];
	      }
	    }

	    /* pengujian angka apakah tidak nol semua,
	       lalu ditambahkan tingkat */
	    if (($angka[$i] != "0") OR ($angka[$i+1] != "0") OR
	        ($angka[$i+2] != "0")) {
	      $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
	    }

	    /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
	       ke variabel kalimat */
	    $kalimat = $subkalimat . $kalimat;
	    $i = $i + 3;
	    $j = $j + 1;

	  }

	  /* mengganti satu ribu jadi seribu jika diperlukan */
	  if (($angka[5] == "0") AND ($angka[6] == "0")) {
	    $kalimat = str_replace("satu ribu","seribu",$kalimat);
	  }

	  return trim($kalimat).' rupiah';

	} 


	public static function appendZeros($str, $charlength=6)
	{

		return str_pad($str, $charlength, '0', STR_PAD_LEFT);
	}

	public static function logError($model)
	{
		$errors = '';
        foreach($model->getErrors() as $attribute){
            foreach($attribute as $error){
                $errors .= $error.' ';
            }
        }

        return $errors;
	}

	public static function formatRupiah($value,$decimal=0,$is_separated=1){
		return $is_separated == 1 ? number_format($value, $decimal,',','.') : round($value,$decimal);
	}

    public static function getSelisihHariInap($old, $new)
    {
        $date1 = strtotime($old);
        $date2 = strtotime($new);
        $interval = $date2 - $date1;
        return round($interval / (60 * 60 * 24)) + 1; 

    }

    function getRandomString($minlength=12, $maxlength=12, $useupper=true, $usespecial=false, $usenumbers=true)
	{

	    $charset = "abcdefghijklmnopqrstuvwxyz";

	    if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	    if ($usenumbers) $charset .= "0123456789";

	    if ($usespecial) $charset .= "~@#$%^*()_±={}|][";

	    for ($i=0; $i<$maxlength; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];

	    return $key;

	}
}