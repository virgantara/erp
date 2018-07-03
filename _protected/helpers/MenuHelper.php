<?php
namespace app\helpers;

use Yii;

/**
 * Css helper class.
 */
class MenuHelper
{
    public static function getMenuItems()
    {
        $menuItems = [];
		if(!Yii::$app->user->isGuest){

		     $menuItems[] = [
		        'label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Beranda </span>', 
		        'url' => ['site/index']];
		}

		if (Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang') || Yii::$app->user->can('adminSpbu') || Yii::$app->user->can('operatorApotik'))
	    {

	        $submenuPenjualan = [];

	        if(Yii::$app->user->can('adminSpbu'))
	        {
	            $submenuPenjualan = [
	                 ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Rekap'),'url' => ['bbm-jual/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['bbm-jual/create']],  
	            ];
	        }

	        else if(Yii::$app->user->can('admSalesCab'))
	        {
	            $submenuPenjualan = [
	                 ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-income/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['sales-income/create']],  
	            ];
	        }

	        else if(Yii::$app->user->can('operatorApotik'))
	        {   
	            $submenuPenjualan = [
	                 ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['departemen-jual/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['tr-rawat-inap/index']],  
	            ];
	        }

	        $menuItems[] = [
	            'label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Penjualan </span><i class="caret"></i>', 
	            'url' => '#',
	            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	            'visible' => Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('adminSpbu'),
	            'items'=>$submenuPenjualan
	        ];

	        $menuItems[] = [
	            'label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Pembelian </span><i class="caret"></i>', 
	            'url' => '#',
	             'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	            'visible' => Yii::$app->user->can('adminSpbu'),
	            'items' => [
	               
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['bbm-faktur/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['bbm-faktur/create']],
	                   ['label' => 'Dropping',  
	                    'url' => ['#'],
	                    'visible' => !Yii::$app->user->can('operatorApotik'),
	                    'items' => [

	                        ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['barang-datang/index']],
	                        ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['barang-datang/create']],
	                        // ['label' => Yii::t('app', 'Harga'),'url' => ['barang-harga/index']],
	                    ],
	                ],
	            ],
	        ];

	        
	    }

	    if(Yii::$app->user->can('admin') 
	    	||Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang'))
	    {
	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Request </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	        'items'=>[
	            ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['request-order/index']],
	            ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['request-order/create']],
	           
	        ]];
	    }
	    // we do not need to display About and Contact pages to employee+ roles
	    
	    // $menuItems[] = ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']];

	    
	    if (Yii::$app->user->can('admin') 
	    	|| Yii::$app->user->can('gudang') 
	        || Yii::$app->user->can('admSalesCab') 
	        || Yii::$app->user->can('adminSpbu')
	        || Yii::$app->user->can('operatorApotik')
	    )
	    {
	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Gudang </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	        'items'=>[
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Barang',  
	                'url' => ['#'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),
	                'items' => [

	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-master-barang/index']],
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['sales-master-barang/create']],
	                    // ['label' => Yii::t('app', 'Harga'),'url' => ['barang-harga/index']],
	                ],
	            ],
	           
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Stok Gudang',  
	                'url' => ['#'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),
	                'items' => [

	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['barang-stok/index']],
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['barang-stok/create']],
	            
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Rekap Barang'),'url' => ['barang-stok/rekap']],
	                ],
	            ],
	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Stok Opname',  
	                'url' => ['#'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),
	                'items' => [

	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['barang-stok-opname/index']],
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['barang-stok-opname/create']],
	                    // '<li class="divider"></li>',
	                    // ['label' => Yii::t('app', 'Rekap'),'url' => ['barang-stok/rekap']],
	                ],
	            ],
	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Loss',  
	                'url' => ['barang-loss/index'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),
	               
	            ],
	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Stok Cabang',  
	                'visible' => Yii::$app->user->can('operatorApotik'),
	                'url' => ['departemen-stok/index'],
	              
	            ],
	             
	            ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-gudang/index'],'visible' => !Yii::$app->user->can('operatorApotik'),],
	            ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['sales-gudang/create'],'visible' => !Yii::$app->user->can('operatorApotik'),]
	        ]];
	    }

	    if ((!Yii::$app->user->isGuest && !Yii::$app->user->can('operatorApotik')) || Yii::$app->user->can('admin')) {
	        $menuItems[] = [
	            'label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Keuangan </span><i class="caret"></i>', 
	            'url' => '#',
	             'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	            'items' => [
	                [
	                    'label' => '<i class="menu-icon fa fa-caret-right"></i> Kas <b class="arrow fa fa-angle-down"></b>',  
	                    'url' => ['#'],
	                    'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                    'items' => [
	                        [
	                            'label' => '<i class="menu-icon fa fa-caret-right"></i>Kas Kecil <b class="arrow fa fa-angle-down"></b>',  
	                            'url' => ['#'],
	                            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                            'items' => [

	                               ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kas/index','uk'=>'kecil']],
	                                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Masuk'),'url' => ['kas/masuk','uk'=>'kecil']],
	                                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Keluar'),'url' => ['kas/keluar','uk'=>'kecil']],
	                            ],
	                        ],
	                        [
	                            'label' => '<i class="menu-icon fa fa-caret-right"></i>Kas Besar <b class="arrow fa fa-angle-down"></b>',  
	                            'url' => ['#'],
	                            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                            'items' => [
	                                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kas/index','uk'=>'besar']],
	                                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Masuk'),'url' => ['kas/masuk','uk'=>'besar']],
	                                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Keluar'),'url' => ['kas/keluar','uk'=>'besar']],
	                            ],
	                        ],
	                    ],
	                ],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Piutang'),'url' => ['/piutang/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Saldo'),'url' => ['/saldo/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Neraca'),'url' => ['/neraca/index']],
	                ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Laba Rugi'),'url' => ['/keuangan/laba-rugi']],
	            ],
	        ];
	    }
	    // display Users to admin+ roles
	    if (Yii::$app->user->can('admin') || Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('adminSpbu') || Yii::$app->user->can('gudang')){

	        $menuItems[] = ['label' =>'<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Master </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	        'items'=>[
	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Cabang <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang'),
	                'url' => ['#'],
	                'items' => [

	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['departemen/index']],
	                     [
	                        'label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['departemen/create']]
	                ],
	            ],
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Perkiraan<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('adminSpbu'),
	                'items' => [

	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['perkiraan/index']],
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['perkiraan/create']],
	                ],
	            ],

	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Customer<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('adminSpbu'),
	                'items' => [

	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['customer/index']],
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['customer/create']],
	                ],
	            ],
	            
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Suplier<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'items' => [

	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-suplier/index']],
	                    ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['sales-suplier/create']],
	                ],
	            ],

	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Dispenser<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('adminSpbu'),
	                'items' => [

	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['bbm-dispenser/index']],
	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['bbm-dispenser/create']]
	                ],
	            ],
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Shift<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('adminSpbu'),
	                'items' => [

	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['shift/index']],
	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['shift/create']]
	                ],
	            ],
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Satuan<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                'items' => [

	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['satuan-barang/index']],
	                     ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['satuan-barang/create']]
	                ],
	            ],
	        ]];

	       
	    }

	    if (Yii::$app->user->can('theCreator')){
	         $menuItems[] = ['label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Perusahaan </span><i class="caret"></i>', 'url' => '#',
	          'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	         'items'=>[
	            ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['perusahaan/index']],
	            ['label' => Yii::t('app', '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['perusahaan/create']]
	        ]];


	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> Users </span>', 'url' => ['/user/index']];
	    }


		return $menuItems;
    }
}