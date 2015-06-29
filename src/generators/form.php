<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator johnitvn\ajaxcrud\generators\Generator */

echo '<h3>General Configuration</h2>';
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');

echo '<br><br><h3>Grid Wiget Configuration</h2>';

echo '<br><h4>Table Setting</h4>';
echo $form->field($generator, 'gridWidgetBodered')->checkbox();
echo $form->field($generator, 'gridWidgetStriped')->checkbox();
echo $form->field($generator, 'gridWidgetCondensed')->checkbox();
echo $form->field($generator, 'gridWidgetResponsive')->checkbox();
echo $form->field($generator, 'gridWidgetResponsiveWrap')->checkbox();
echo $form->field($generator, 'gridWidgetHover')->checkbox();
echo $form->field($generator, 'gridWidgetPageSummary')->checkbox();



echo '<br><h4>Panel Setting</h4>';
echo $form->field($generator, 'gridWidgetPanelType')->dropDownList([
    'default' => 'Default',
    'primary' => 'Primary',
    'success' => 'Success',
    'info' => 'Info',
    'danger' => 'Danger',
    'warning' => 'Warning',
]);
echo $form->field($generator, 'gridWidgetShowFooter')->checkbox();
echo $form->field($generator, 'gridWidgetCaption');
echo $form->field($generator, 'gridWidgetExport')->checkbox();
echo '<div class="row">';
echo '<div class="col-sm-4">'.$form->field($generator, 'gridWidgetExportHtml')->checkbox().'</div>';
echo '<div class="col-sm-4">'.$form->field($generator, 'gridWidgetExportCsv')->checkbox().'</div>';
echo '<div class="col-sm-4">'.$form->field($generator, 'gridWidgetExportExcel')->checkbox().'</div>';
echo '<div class="col-sm-4">'.$form->field($generator, 'gridWidgetExportText')->checkbox().'</div>';
echo '<div class="col-sm-4">'.$form->field($generator, 'gridWidgetExportJson')->checkbox().'</div>';
echo '<div class="col-sm-4">'.$form->field($generator, 'gridWidgetExportPdf')->checkbox().'</div>';
echo '</div>';



echo '<br><h4>Panel Content</h4>';
echo $form->field($generator, 'gridWidgetBulkAction')->checkbox();
echo $form->field($generator, 'gridWidgetActionButton')->dropDownList([
    'dropdown' => 'As Dropdonw Menu',
    'button' => 'As Icon Button',
]);
echo $form->field($generator, 'gridWidgetPanelHeading');
echo $form->field($generator, 'gridWidgetContentBeforeGrid');
echo $form->field($generator, 'gridWidgetContentAfterGrid');


echo '<br><br><h2>Others</h2>';