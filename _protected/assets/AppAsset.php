<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Nenad Zivkovic <nenad@freetuts.org>
 * 
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';

    public $css = [
        'css/bootstrap.min.css',
        'font-awesome/4.5.0/css/font-awesome.min.css',
        'css/ace.min.css',
        'css/fonts.googleapis.com.css',
        'css/ace-skins.min.css',
        'css/ace-rtl.min.css',
        'css/jquery.datetextentry.css'
    ];

    public $js = [
        'js/ace-extra.min.js',
        'js/bootstrap.min.js',
        'js/ace-elements.min.js',
        'js/ace.min.js',
        'js/jquery.mobile.custom.min.js',
        'js/jquery-ui.min.js',
        'js/jquery.datetextentry.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',

    ];
}
