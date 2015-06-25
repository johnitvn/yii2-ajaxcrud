<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\helpers\Url;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <button id="createNewModel" class="btn btn-sm btn-primary pull-right" data-url="<?php echo '<?=Url::to(["create"])?>' ?>"><span class="action-column glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;<?='Add <?=$this->title?>'?></button>
    <div id="dataTableWrapper" data-url="<?php echo '<?=Url::to(["datatable"])?>' ?>"></div>
</div>

<?php
    Modal::begin([       
        'id'=>'viewModal',
        'header' => '<h4 class="modal-title"></h4>',
    ]);
?>
    <p>Đang tải dữ liệu</p>
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>   

<?php Modal::end(); ?>

<?php
    Modal::begin([       
        'id'=>'deleteModal',
        'header' => '<h4 class="modal-title"></h4>',
    ]);
?>
    <p>Are you sure you want to delete this item?</p>

    <div class="modal-footer">
<?php
    echo Html::button('<i class="icon-user"></i> Delete',
        array(
            'class' => 'btn pull-left',
            'id'=> 'comfirm-delete'            
        ));

    echo Html::button('<i class="icon-user"></i> Cancel',
        array(
            'class' => 'btn btn-primary pull-right',
            'data-dismiss'=>"modal"
        ));
?>


<?php Modal::end(); ?>