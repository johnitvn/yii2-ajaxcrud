<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";
?>
use yii\helpers\Url;
use yii\widgets\Pjax;
use johnitvn\ajaxcrud\GridView;
use yii\helpers\Html;
use <?=$generator->controllerClass?>; 

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */


?>


<?="<?php\n"?>

/**
* Grid toolbar config
*/
$gridToolbar = [
    ['content'=>
        Html::a('<i class="glyphicon glyphicon-plus"></i>',['create'],['data-modal-title'=>'Create new <?=$modelClass?>','class'=>'create-action-button btn btn-default']).
        Html::a('<i class="glyphicon glyphicon-repeat"></i>',['index'],['data-pjax'=>1,'class'=>'btn btn-default']).
        '{toogleDataNoContainer}'.
        Html::a('<i class="fa fa-expand"></i>','#',['class'=>'btn-toggle-fullscreen btn btn-default'])
    ],
    '{export}', 
];

$bulkDeleteButton = Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All Selected',
                                 ["bulk-delete"] ,
                                 [
                                     "class"=>"btn-bulk-delete btn btn-danger",
                                     "data-method"=>"post",
                                     "title"=>"Delete All Selected",
                                     "data-confirm-message"=>"Are you sure to delete all this items?"
                                 ]);

/**
* Grid toogle config 
*/
$toggleDataOptions = [
    'all' => [
        'icon' => 'option-vertical',
        'label' => 'All',
        'class' => 'btn btn-default',
        'title' => 'Show all data',
    ],
    'page' => [
        'icon' => 'option-horizontal',
        'label' => 'Page',
        'class' => 'btn btn-default',
        'title' => 'Show first page data',
    ],      
];

/**
* Grid column config
*/
$gridColumns = [
    <?php if($generator->gridWidgetBulkAction){ ?>
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    <?php } ?>
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
<?php
$count = 0;
foreach ($generator->getColumnNames() as $name) {   
    if ($name=='id'||$name=='created_at'||$name=='updated_at'){
        echo "  // [\n";
        echo "      // 'class'=>'\kartik\grid\DataColumn',\n";
        echo "      // 'attribute'=>'" . $name . "',\n";
        echo "  // ],\n";
    } else if (++$count < 6) {
        echo "  [\n";
        echo "      'class'=>'\kartik\grid\DataColumn',\n";
        echo "      'attribute'=>'" . $name . "',\n";
        echo "  ],\n";
    } else {
        echo "  // [\n";
        echo "      // 'class'=>'\kartik\grid\DataColumn',\n";
        echo "      // 'attribute'=>'" . $name . "',\n";
        echo "  // ],\n";
    }
}
?>

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => <?=$generator->gridWidgetActionButton==='dropdown'?'true':'false'?>,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'<?=substr($actionParams,1)?>'=>$key]);
        },
        'viewOptions'=>['class'=>'view-action-button','title'=>'View', 'data-toggle'=>'tooltip','data-modal-title'=>'View <?=$modelClass?>'],
        'updateOptions'=>['class'=>'update-action-button','title'=>'Update', 'data-toggle'=>'tooltip','data-modal-title'=>'Update <?=$modelClass?>'],
        'deleteOptions'=>['class'=>'delete-action-button','title'=>'Delete', 'data-toggle'=>'tooltip','data-confirm-message'=>'Are you sure to delete this item?'], 
    ],

];   

echo GridView::widget([
    'id'=>'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'toolbar' =>  $gridToolbar,
    <?php if(!empty($generator->gridWidgetCaption)){ ?>
    'caption' =>  '<?=$generator->gridWidgetCaption?>',
    <?php } ?>
    'bordered' => <?=$generator->gridWidgetBodered?"true":"false"?>,
    'striped' => <?=$generator->gridWidgetStriped?"true":"false"?>,
    'condensed' => <?=$generator->gridWidgetCondensed?"true":"false"?>,
    'responsive' =><?=$generator->gridWidgetResponsive?"true":"false"?>,
    'responsiveWrap' => <?=$generator->gridWidgetResponsiveWrap?"true":"false"?>,
    'hover' => <?=$generator->gridWidgetHover?"true":"false"?>,
    'showPageSummary' => <?=$generator->gridWidgetPageSummary?"true":"false"?>,        
    'pjax' => true,  
    'toggleDataOptions'=>$toggleDataOptions,
    'panel' => [
        'type' => '<?=$generator->gridWidgetPanelType?>', 
        'heading' => <?=empty($generator->gridWidgetPanelHeading)?'false':"'".$generator->gridWidgetPanelHeading."'"?>,
        'before' => '<?=empty($generator->gridWidgetContentBeforeGrid)?'false':$generator->gridWidgetContentBeforeGrid?>',
        <?php if($generator->gridWidgetBulkAction){ ?>
        'after' =>  '<div class="pull-left"><?=empty($generator->gridWidgetContentAfterGrid)?'false':$generator->gridWidgetContentAfterGrid?></div>'.
                    '<div class="pull-right">'.$bulkDeleteButton.'</div>'.
                    '<div class="clearfix"></div>',
        <?php } else{ ?>
        'after' => '<?=empty($generator->gridWidgetContentAfterGrid)?'false':$generator->gridWidgetContentAfterGrid?>',
        <?php } ?>
    ],    

]);
<?="\n?>"?>


   
  
