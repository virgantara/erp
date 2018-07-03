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
	                 ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Rekap'),'url' => ['bbm-jual/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['bbm-jual/create']],  
	            ];
	        }

	        else if(Yii::$app->user->can('admSalesCab'))
	        {
	            $submenuPenjualan = [
	                 ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-income/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['sales-income/create']],  
	            ];
	        }

	        else if(Yii::$app->user->can('operatorApotik'))
	        {   
	            $submenuPenjualan = [
	                 ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['departemen-jual/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['tr-rawat-inap/index']],  
	            ];
	        }

	        $menuItems[] = [
	            'label' => '<i class="menu-icon fa fa-bar-chart-o"></i><span class="menu-text"> Penjualan </span><i class="caret"></i>', 
	            'url' => '#',
	            'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	            'visible' => Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('adminSpbu'),
	            'items'=>$submenuPenjualan
	        ];

	        $menuItems[] = [
	            'label' => '<i class="menu-icon fa fa-shopping-cart"></i><span class="menu-text"> Pembelian </span><i class="caret"></i>', 
	            'url' => '#',
	            'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	             'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	            'visible' => Yii::$app->user->can('adminSpbu'),
	            'items' => [
	               
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['bbm-faktur/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['bbm-faktur/create']],
	                   ['label' => '<i class="menu-icon fa fa-caret-right"></i>Dropping<b class="arrow fa fa-angle-down"></b>',  
	                    'url' => ['#'],
	                    'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                    'visible' => !Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('theCreator'),
	                    'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                    'items' => [

	                        ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['barang-datang/index']],
	                        ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['barang-datang/create']],
	                        // ['label' => ( 'Harga'),'url' => ['barang-harga/index']],
	                    ],
	                ],
	            ],
	        ];

	        
	    }

	    if(Yii::$app->user->can('admin') 
	    	||Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang'))
	    {
	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-tasks"></i><span class="menu-text"> Request </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	        'items'=>[
	            ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['request-order/index']],
	            ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['request-order/create']],
	           
	        ]];
	    }
	    // we do not need to display About and Contact pages to employee+ roles
	    
	    // $menuItems[] = ['label' => ( 'About'), 'url' => ['/site/about']];

	    
	    if (Yii::$app->user->can('theCreator') ||
	    	Yii::$app->user->can('admin') 
	    	|| Yii::$app->user->can('gudang') 
	        || Yii::$app->user->can('admSalesCab') 
	        || Yii::$app->user->can('adminSpbu')
	        || Yii::$app->user->can('operatorApotik')
	    )
	    {
	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-archive"></i><span class="menu-text"> Gudang </span><i class="caret"></i>', 'url' => '#',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	        'items'=>[
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Barang',  
	                'url' => ['#'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),

	                'items' => [

	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-master-barang/index']],
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['sales-master-barang/create']],
	                    // ['label' => ( 'Harga'),'url' => ['barang-harga/index']],
	                ],
	            ],
	           
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Stok Gudang',  
	                'url' => ['#'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),
	                'items' => [

	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['barang-stok/index']],
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['barang-stok/create']],
	            
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Rekap Barang'),'url' => ['barang-stok/rekap']],
	                ],
	            ],
	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Stok Opname',  
	                'url' => ['#'],
	                'visible' => !Yii::$app->user->can('operatorApotik'),
	                'items' => [

	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['barang-stok-opname/index']],
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['barang-stok-opname/create']],
	                    // '<li class="divider"></li>',
	                    // ['label' => ( 'Rekap'),'url' => ['barang-stok/rekap']],
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
	             
	            ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-gudang/index'],'visible' => !Yii::$app->user->can('operatorApotik'),],
	            ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['sales-gudang/create'],'visible' => !Yii::$app->user->can('operatorApotik'),]
	        ]];
	    }

	    if ((!Yii::$app->user->isGuest && !Yii::$app->user->can('operatorApotik')) || Yii::$app->user->can('admin')) {
	        $menuItems[] = [
	            'label' => '<i class="menu-icon fa fa-money"></i><span class="menu-text"> Keuangan </span><i class="caret"></i>', 
	             'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	            'url' => '#',
	             'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	            'items' => [
	                [
	                    'label' => '<i class="menu-icon fa fa-caret-right"></i> Kas <b class="arrow fa fa-angle-down"></b>',  
	                    'url' => ['#'],
	                     'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                    'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                    'items' => [
	                        [
	                            'label' => '<i class="menu-icon fa fa-caret-right"></i>Kas Kecil <b class="arrow fa fa-angle-down"></b>',  
	                            'url' => ['#'],
	                             'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                            'items' => [

	                               ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kas/index','uk'=>'kecil']],
	                                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Masuk'),'url' => ['kas/masuk','uk'=>'kecil']],
	                                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Keluar'),'url' => ['kas/keluar','uk'=>'kecil']],
	                            ],
	                        ],
	                        [
	                            'label' => '<i class="menu-icon fa fa-caret-right"></i>Kas Besar <b class="arrow fa fa-angle-down"></b>',  
	                            'url' => ['#'],
	                             'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                            'items' => [
	                                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['kas/index','uk'=>'besar']],
	                                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Masuk'),'url' => ['kas/masuk','uk'=>'besar']],
	                                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Keluar'),'url' => ['kas/keluar','uk'=>'besar']],
	                            ],
	                        ],
	                    ],
	                ],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Piutang'),'url' => ['/piutang/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Saldo'),'url' => ['/saldo/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Neraca'),'url' => ['/neraca/index']],
	                ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Laba Rugi'),'url' => ['/keuangan/laba-rugi']],
	            ],
	        ];
	    }
	    // display Users to admin+ roles
	    if (Yii::$app->user->can('admin') || Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('adminSpbu') || Yii::$app->user->can('gudang')){

	        $menuItems[] = ['label' =>'<i class="menu-icon fa fa-book"></i><span class="menu-text"> Master </span><i class="caret"></i>', 'url' => '#',
	         'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	         'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	        'items'=>[
	            [
	                'label' => '<i class="menu-icon fa fa-caret-right"></i>Cabang <b class="arrow fa fa-angle-down"></b>',  
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang'),
	                'url' => ['#'],
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['departemen/index']],
	                     [
	                        'label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),
	                        'visible' => Yii::$app->user->can('admin'),
	                        'url' => ['departemen/create']]
	                ],
	            ],
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Perkiraan<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('adminSpbu'),
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['perkiraan/index']],
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['perkiraan/create']],
	                ],
	            ],

	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Customer<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('adminSpbu'),
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['customer/index']],
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['customer/create']],
	                ],
	            ],
	            
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Suplier<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'visible' => Yii::$app->user->can('admin'),
	                'items' => [

	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['sales-suplier/index']],
	                    ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Baru'),'url' => ['sales-suplier/create']],
	                ],
	            ],

	             ['label' => '<i class="menu-icon fa fa-caret-right"></i>Dispenser<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('adminSpbu'),
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['bbm-dispenser/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['bbm-dispenser/create']]
	                ],
	            ],
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Shift<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('adminSpbu'),
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['shift/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['shift/create']]
	                ],
	            ],
	            ['label' => '<i class="menu-icon fa fa-caret-right"></i>Satuan<b class="arrow fa fa-angle-down"></b>',  
	                'url' => ['#'],
	                'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	                'visible' => Yii::$app->user->can('admin'),
	                 'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	                'items' => [

	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['satuan-barang/index']],
	                     ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['satuan-barang/create']]
	                ],
	            ],
	        ]];

	       
	    }

	    if (Yii::$app->user->can('theCreator')){
	         $menuItems[] = ['label' => '<i class="menu-icon fa fa-building"></i><span class="menu-text"> Perusahaan </span><i class="caret"></i>', 'url' => '#',
	          'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
	           'template' => '<a href="{url}" class="dropdown-toggle">{label}</a>',
	         'items'=>[
	            ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Manage'),'url' => ['perusahaan/index']],
	            ['label' => ( '<i class="menu-icon fa fa-caret-right"></i>Tambah'),'url' => ['perusahaan/create']]
	        ]];


	        $menuItems[] = ['label' => '<i class="menu-icon fa fa-users"></i><span class="menu-text"> Users </span>', 'url' => ['/user/index']];
	    }


		return $menuItems;
    }
}