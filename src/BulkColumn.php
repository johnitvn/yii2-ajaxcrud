<?php
namespace johnitvn\ajaxcrud;


class BulkColumn extends \yii\grid\Column
{
    /**
     * @inheritdoc
     */
    public $header = '';


    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
       return '<input class="bulk-selectable" value="'.$key.'" type="checkbox"/>';
    }
}
