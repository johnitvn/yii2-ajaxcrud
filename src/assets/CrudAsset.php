<?php
namespace johnitvn\ajaxcrud\assets;

use yii\web\AssetBundle;

/**
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0
 */
class CrudAsset extends AssetBundle
{
    public $sourcePath = '@vendor/johnitvn/yii2-ajaxcrud/assets';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
    ];
    public $js = [
        //'ajaxcrud.js',
        'ajaxcrud.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'kartik\grid\GridViewAsset',
    ];

}
