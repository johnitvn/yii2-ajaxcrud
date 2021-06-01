<?php

namespace johnitvn\ajaxcrud;

use yii\web\AssetBundle;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0
 */
class CrudAsset extends AssetBundle
{
    public $sourcePath = '@ajaxcrud/assets';

    public $css = [
        'ajaxcrud.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'kartik\grid\GridViewAsset',
    ];

   public function init() {
       // In dev mode use non-minified javascripts
       $this->js = YII_DEBUG ? [
           'ModalRemote.js',
           'ajaxcrud.js',
       ]:[
           'ModalRemote.min.js',
           'ajaxcrud.min.js',
       ];

       parent::init();
   }
}
