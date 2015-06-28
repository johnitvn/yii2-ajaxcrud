<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace johnitvn\ajaxcrud;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CrudAsset extends AssetBundle
{
    public $sourcePath = '@vendor/johnitvn/yii2-ajaxcrud/assets';
  public $publishOptions = [
    'forceCopy' => true,
];
    public $css = [
        'ajaxcrud.css',
    ];
    public $js = [
        'ajaxcrud.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
