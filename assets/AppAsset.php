<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    /*public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/

    public $sourcePath = '@vendor/almasaeed2010/';
    public $css = ['adminlte/dist/css/AdminLTE.min.css', 'adminlte/dist/css/skins/skin-blue.css'];
    public $js = ['adminlte/dist/js/app.js', 'adminlte/plugins/slimScroll/jquery.slimscroll.min.js', 'adminlte/plugins/fastclick/fastclick.min.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
