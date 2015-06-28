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
use yii\widgets\Pjax;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div id="ajaxCrudDatatable">
        <?="<?php\nPjax::begin();\necho"?>
        <?php 
        if ($generator->indexWidgetType === 'grid'): ?>
         GridView::widget([
                'dataProvider' => $dataProvider,
                <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n            'columns' => [\n" : "'columns' => [\n"; ?>
                   ['class'=>'johnitvn\ajaxcrud\BulkColumn'],
                   ['class' => 'yii\grid\SerialColumn'],
            
        <?php
        $count = 0;
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                if($name==='id'||$name=='create_at'||$name=='update_at'){
                    echo "         // '" . $name . "',\n";
                }else if (++$count < 6) {
                    echo "           '" . $name . "',\n";
                } else {
                    echo "         // '" . $name . "',\n";
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {        
                $format = $generator->generateColumnFormat($column);    
                if($column->name==='id'||$column->name=='create_at'||$column->name=='update_at'){
                    echo "           // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }else if (++$count < 6) {
                    echo "           '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                } else {
                    echo "           // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
        }
        ?>

                    ['class' => 'johnitvn\ajaxcrud\AjaxCrudActionColumn'],
                ],
            ]); 
        <?php else: ?>
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                    },
                ])
        <?php endif;?>
        <?="\nPjax::end() ;?>"?>
    </div>
    <div class="form-inline pull-left">
        <div class="checkbox">
            <label>
              <input id="select-all" type="checkbox"> Select All 
            </label>
        </div>        
        <button id="createNewModel" class="btn btn-sm btn-primary" data-url="<?php echo '<?=Url::to(["create"])?>' ?>"><span class="action-column glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;<?='Add <?=$this->title?>'?></button>
    </div>
    <button id="createNewModel" class="btn btn-sm btn-primary pull-right" data-url="<?php echo '<?=Url::to(["create"])?>' ?>"><span class="action-column glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;<?='Add <?=$this->title?>'?></button>   
</div>



<?php
    Modal::begin([       
        'id'=>'ajaxCrubModal',
        'header' => '<h4 class="modal-title"></h4>',
    ]);
?>
    <p>Đang tải dữ liệu</p>
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>   

<?php Modal::end(); ?>

