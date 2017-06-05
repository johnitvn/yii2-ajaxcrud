<?php

namespace johnitvn\ajaxcrud;

use yii\base\Widget;
use yii\helpers\Html;

class BulkButtonWidget extends Widget {

    use TranslationTrait;

    public $buttons;

    public function init() {
        parent::init();
        $this->initI18N(__DIR__, 'ajaxcrud');
    }

    public function run() {
        $content = '<div class="pull-left">' .
                '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp;&nbsp;' . \Yii::t('ajaxcrud', 'With selected') . '&nbsp;&nbsp;' .
                $this->buttons .
                '</div>';
        return $content;
    }

}

?>
