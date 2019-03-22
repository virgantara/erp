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


        $params['Penjualan']['tanggal_awal'] = $tanggal_awal;
        $params['Penjualan']['tanggal_akhir'] = $tanggal_akhir;
        $params['customer_id'] = $customer_id;

        $model = new \app\models\PenjualanSearch;
        $searchModel = $model->searchTanggal($params, 1, SORT_DESC);
        $rows = $searchModel->getModels();
  
        $items=[];

        $total_all = 0;
        foreach($rows as $q => $parent)
        {

        	$total = 0;
        	foreach($parent->penjualanItems as $key => $row)
            {
                
            	$subtotal_bulat = round($row->harga) * ceil($row->qty);
              	$total += $subtotal_bulat;
                $no_resep = $key == 0 ? $parent->kode_penjualan : '';
                $tgl_resep = $key == 0 ? $parent->tanggal : '';
                $counter = $key == 0 ? ($q+1) : '';
                $pasien_id = $key == 0 ? $parent->penjualanResep->pasien_id : '';
                $pasien_nama = $key == 0 ? $parent->penjualanResep->pasien_nama : '';
                $dokter = $key == 0 ? $parent->penjualanResep->dokter_nama : '';
                $unit_nama = $key == 0 ? $parent->penjualanResep->unit_nama : '';
                $jenis_resep = $key == 0 ? $parent->penjualanResep->jenis_resep_id : '';
                $total_label = $key == (count($parent->penjualanItems) - 1) ? \app\helpers\MyHelper::formatRupiah($total,$is_separated) : '';
              

                $results = [
                    'id' => $row->id,
                    'counter' => $counter,
                    'kode_barang' => $row->stok->barang->kode_barang,
                    'nama_barang' => $row->stok->barang->nama_barang,
                    'harga_jual' => \app\helpers\MyHelper::formatRupiah($row->stok->barang->harga_jual,$is_separated),
                    'harga_beli' => \app\helpers\MyHelper::formatRupiah($row->stok->barang->harga_beli,$is_separated),
                    'harga' => \app\helpers\MyHelper::formatRupiah($row->harga,$is_separated),
                    'subtotal' => \app\helpers\MyHelper::formatRupiah($row->subtotal,$is_separated),
                    'subtotal_bulat' => \app\helpers\MyHelper::formatRupiah($subtotal_bulat,$is_separated),
                    'signa1' =>$row->signa1,
                    'signa2' =>$row->signa2,
                    'is_racikan' =>$row->is_racikan,
                    'dosis_minta' =>$row->dosis_minta,
                    'qty' =>$row->qty,
                    'qty_bulat' => ceil($row->qty),
                    'no_resep' => $no_resep,
                    'tgl_resep' => $tgl_resep,
                    'dokter' => $dokter,
                    'unit_nama' => $unit_nama,
                    'jenis_resep' => $jenis_resep,
                    'pasien_id' => $pasien_id,
                    'pasien_nama' => $pasien_nama, 
                    'total_label' => $total_label,

                ];

                $items[] = $results;

                
            }

            $total_all += $total;

        } 

        $result = [
            'code' => 200,
            'message' => 'success',
            'items' => $items,
            'total_all' => \app\helpers\MyHelper::formatRupiah($total_all,$is_separated)
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
		return $is_separated == 1 ? number_format($value, $decimal,',','.') : round($value);
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