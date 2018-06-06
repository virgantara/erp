<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\nav\NavX;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', Yii::$app->name),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);


  // print_r(Yii::$app->user->identity);exit;
    // everyone can see Home page
    $menuItems[] = ['label' => Yii::t('app', 'Home'), 'url' => ['site/index']];

    if (Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang') || Yii::$app->user->can('adminSpbu') || Yii::$app->user->can('operatorApotik'))
    {

        $submenuPenjualan = [];

        if(Yii::$app->user->can('adminSpbu'))
        {
            $submenuPenjualan = [
                 ['label' => Yii::t('app', 'Manage'),'url' => ['bbm-jual/index']],
                ['label' => Yii::t('app', 'Baru'),'url' => ['bbm-jual/create']],  
            ];
        }

        else if(Yii::$app->user->can('admSalesCab'))
        {
            $submenuPenjualan = [
                 ['label' => Yii::t('app', 'Manage'),'url' => ['sales-income/index']],
                ['label' => Yii::t('app', 'Baru'),'url' => ['sales-income/create']],  
            ];
        }

        else if(Yii::$app->user->can('operatorApotik'))
        {   
            $submenuPenjualan = [
                 ['label' => Yii::t('app', 'Manage'),'url' => ['departemen-jual/index']],
                ['label' => Yii::t('app', 'Data Pasien'),'url' => ['tr-rawat-inap/index']],  
            ];
        }

        $menuItems[] = [
            'label' => Yii::t('app', 'Penjualan'), 
            'url' => '#',
            'visible' => Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('adminSpbu'),
            'items'=>$submenuPenjualan
        ];

        $menuItems[] = [
            'label' => Yii::t('app', 'Pembelian'), 
            'url' => '#',
            'visible' => Yii::$app->user->can('adminSpbu'),
            'items' => [

                ['label' => Yii::t('app', 'Manage'),'url' => ['bbm-faktur/index']],
                ['label' => Yii::t('app', 'Baru'),'url' => ['bbm-faktur/create']],
            ],
        ];

        
    }

    // print_r(Yii::$app->user);exit;

    if(Yii::$app->user->can('operatorApotik') || Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang'))
    {
        $menuItems[] = ['label' => Yii::t('app', 'Request'), 'url' => '#',
        'items'=>[
            ['label' => Yii::t('app', 'Manage'),'url' => ['request-order/index']],
            ['label' => Yii::t('app', 'Baru'),'url' => ['request-order/create']],
           
        ]];
    }
    // we do not need to display About and Contact pages to employee+ roles
    
    // $menuItems[] = ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']];

    
    if (Yii::$app->user->can('gudang') 
        || Yii::$app->user->can('admSalesCab') 
        || Yii::$app->user->can('adminSpbu')
        || Yii::$app->user->can('operatorApotik')
    )
    {
        $menuItems[] = ['label' => Yii::t('app', 'Gudang'), 'url' => '#','items'=>[
            ['label' => 'Barang',  
                'url' => ['#'],
                'visible' => !Yii::$app->user->can('operatorApotik'),
                'items' => [

                    ['label' => Yii::t('app', 'Manage'),'url' => ['sales-barang/index']],
                    ['label' => Yii::t('app', 'Baru'),'url' => ['sales-barang/create']],
                    // ['label' => Yii::t('app', 'Harga'),'url' => ['barang-harga/index']],
                ],
            ],
            ['label' => 'Stok Gudang',  
                'url' => ['#'],
                'visible' => !Yii::$app->user->can('operatorApotik'),
                'items' => [

                    ['label' => Yii::t('app', 'Manage'),'url' => ['barang-stok/index']],
                    ['label' => Yii::t('app', 'Baru'),'url' => ['barang-stok/create']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Rekap'),'url' => ['barang-stok/rekap']],
                ],
            ],
            [
                'label' => 'Stok Cabang',  
                'visible' => Yii::$app->user->can('operatorApotik'),
                'url' => ['departemen-stok/index'],
              
            ],
             
            '<li class="divider"></li>',
            ['label' => Yii::t('app', 'Manage'),'url' => ['sales-gudang/index'],'visible' => !Yii::$app->user->can('operatorApotik'),],
            ['label' => Yii::t('app', 'Tambah'),'url' => ['sales-gudang/create'],'visible' => !Yii::$app->user->can('operatorApotik'),]
        ]];
    }

    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => Yii::t('app', 'Keuangan'), 
            'url' => '#',
            'items' => [
                [
                    'label' => 'Kas',  
                    'url' => ['#'],
                    'items' => [
                        [
                            'label' => 'Kas Kecil',  
                            'url' => ['#'],
                            'items' => [
                               ['label' => Yii::t('app', 'Manage'),'url' => ['kas/index','uk'=>'kecil']],
                                ['label' => Yii::t('app', 'Masuk'),'url' => ['kas/masuk','uk'=>'kecil']],
                                ['label' => Yii::t('app', 'Keluar'),'url' => ['kas/keluar','uk'=>'kecil']],
                            ],
                        ],
                        [
                            'label' => 'Kas Besar',  
                            'url' => ['#'],
                            'items' => [
                                ['label' => Yii::t('app', 'Manage'),'url' => ['kas/index','uk'=>'besar']],
                                ['label' => Yii::t('app', 'Masuk'),'url' => ['kas/masuk','uk'=>'besar']],
                                ['label' => Yii::t('app', 'Keluar'),'url' => ['kas/keluar','uk'=>'besar']],
                            ],
                        ],
                    ],
                ],
                ['label' => Yii::t('app', 'Saldo'),'url' => ['/saldo/index']],
                ['label' => Yii::t('app', 'Neraca'),'url' => ['/neraca/index']],
            ],
        ];
    }
    // display Users to admin+ roles
    if (Yii::$app->user->can('admin') || Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('adminSpbu') || Yii::$app->user->can('gudang')){

        $menuItems[] = ['label' => Yii::t('app', 'Master'), 'url' => '#','items'=>[
            [
                'label' => 'Cabang',  
                'visible' => Yii::$app->user->can('admSalesCab') || Yii::$app->user->can('gudang'),
                'url' => ['#'],
                'items' => [

                     ['label' => Yii::t('app', 'Manage'),'url' => ['departemen/index']],
                     [
                        'label' => Yii::t('app', 'Tambah'),
                        'visible' => Yii::$app->user->can('admin'),
                        'url' => ['departemen/create']]
                ],
            ],
            ['label' => 'Perkiraan',  
                'url' => ['#'],
                'visible' => Yii::$app->user->can('admin'),
                'items' => [

                    ['label' => Yii::t('app', 'Manage'),'url' => ['perkiraan/index']],
                    ['label' => Yii::t('app', 'Baru'),'url' => ['perkiraan/create']],
                ],
            ],
             '<li class="divider"></li>',
            ['label' => 'Suplier',  
                'url' => ['#'],
                'visible' => Yii::$app->user->can('admin'),
                'items' => [

                    ['label' => Yii::t('app', 'Manage'),'url' => ['sales-suplier/index']],
                    ['label' => Yii::t('app', 'Baru'),'url' => ['sales-suplier/create']],
                ],
            ],

             ['label' => 'Dispenser',  
                'url' => ['#'],
                'visible' => Yii::$app->user->can('adminSpbu'),
                'items' => [

                     ['label' => Yii::t('app', 'Manage'),'url' => ['bbm-dispenser/index']],
                     ['label' => Yii::t('app', 'Tambah'),'url' => ['bbm-dispenser/create']]
                ],
            ],
            ['label' => 'Shift',  
                'url' => ['#'],
                'visible' => Yii::$app->user->can('admin'),
                'items' => [

                     ['label' => Yii::t('app', 'Manage'),'url' => ['shift/index']],
                     ['label' => Yii::t('app', 'Tambah'),'url' => ['shift/create']]
                ],
            ],
            '<li class="divider"></li>',
            ['label' => 'Satuan',  
                'url' => ['#'],
                'visible' => Yii::$app->user->can('admin'),
                'items' => [

                     ['label' => Yii::t('app', 'Manage'),'url' => ['satuan-barang/index']],
                     ['label' => Yii::t('app', 'Tambah'),'url' => ['satuan-barang/create']]
                ],
            ],
        ]];

       
    }

    if (Yii::$app->user->can('theCreator')){
         $menuItems[] = ['label' => Yii::t('app', 'Perusahaan'), 'url' => '#','items'=>[
            ['label' => Yii::t('app', 'Manage'),'url' => ['perusahaan/index']],
            ['label' => Yii::t('app', 'Tambah'),'url' => ['perusahaan/create']]
        ]];


        $menuItems[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
    }


    
    // display Logout to logged in users
    if (!Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    // display Signup and Login pages to guests of the site
    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    }

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right '],
        'items' => $menuItems,
        'encodeLabels' =>false
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Trisna Group <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <!-- <p class="pull-right"></p> -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
