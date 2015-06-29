<?php
namespace johnitvn\ajaxcrud;

use kartik\grid\GridView as BaseGridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class GridView extends BaseGridView{


	/**
     * Renders the toggle data button
     *
     * @return string
     */
    public function renderToggleData()
    {
        if (!$this->toggleData) {
            return '';
        }
        
        $tag = $this->_isShowAll ? 'page' : 'all';
        $label = $this->toggleDataOptions[$tag]['label'];
        $url = Url::current([$this->_toggleDataKey => $tag]);
        Html::addCssClass($this->toggleDataContainer, 'btn-group');
        return Html::tag('div', Html::a($label, $url, $this->toggleDataOptions[$tag]), $this->toggleDataContainer);
    }


	
	/**
     * Renders the toggle data button
     *
     * @return string
     */
    public function renderToggleDataNoContainer()
    {
        if (!$this->toggleData) {
            return '';
        }        
        $tag = $this->_isShowAll ? 'page' : 'all';       
        $url = Url::current([$this->_toggleDataKey => $tag]);      
        $label = $this->toggleDataOptions[$tag]['label'];
        return Html::a($label, $url, $this->toggleDataOptions[$tag]);
    }


    /**
     * Initialize toggle data button options
     */
    protected function initToggleData()
    {
        if (!$this->toggleData) {
            return;
        }
        $defaultOptions = [
            'all' => [
                'icon' => 'resize-full',
                'label' => 'All',
                'class' => 'btn btn-default',
                'title' => 'Show all data',
            ],
            'page' => [
                'icon' => 'resize-small',
                'label' => 'Page',
                'class' => 'btn btn-default',
                'title' => 'Show first page data',
            ],
        ];
        if (empty($this->toggleDataOptions['page'])) {
            $this->toggleDataOptions['page'] = $defaultOptions['page'];
        }
        if (empty($this->toggleDataOptions['all'])) {
            $this->toggleDataOptions['all'] = $defaultOptions['all'];
        }
        $tag = $this->_isShowAll ? 'page' : 'all';
        $options = $this->toggleDataOptions[$tag];


        $icon = ArrayHelper::remove($this->toggleDataOptions[$tag], 'icon', ''); 
        $label = !isset($options['label']) ? $defaultOptions[$tag]['label'] : $options['label'];      
        if (!empty($icon)) {  
        	$label =  '<i class="glyphicon glyphicon-'.$icon.'"></i> '.$label; 
        } 
        $this->toggleDataOptions[$tag]['label'] = $label;
        if (!isset($this->toggleDataOptions[$tag]['title'])) {
            $this->toggleDataOptions[$tag]['title'] = $defaultOptions[$tag]['title'];
        }        
        $this->toggleDataOptions[$tag]['data-pjax'] = $this->pjax ? "true" : false;
    }




    /**
     * Initalize grid layout
     */
    protected function initLayout()
    {
        Html::addCssClass($this->filterRowOptions, 'skip-export');
        if ($this->resizableColumns && $this->persistResize) {
            $key = empty($this->resizeStorageKey) ? Yii::$app->user->id : $this->resizeStorageKey;
            $gridId = empty($this->options['id']) ? $this->getId() : $this->options['id'];
            $this->containerOptions['data-resizable-columns-id'] = (empty($key) ? "kv-{$gridId}" : "kv-{$key}-{$gridId}");
        }
        $export = $this->renderExport();
        $toggleData = $this->renderToggleData();
        $toggleDataNoContainer = $this->renderToggleDataNoContainer();
        $toolbar = strtr(
            $this->renderToolbar(),
            [
                '{export}' => $export,
                '{toggleData}' => $toggleData,
                '{toogleDataNoContainer}' => $toggleDataNoContainer,
            ]
        );
        $replace = ['{toolbar}' => $toolbar];
        if (strpos($this->layout, '{export}') > 0) {
            $replace['{export}'] = $export;
        }
        if (strpos($this->layout, '{toggleData}') > 0) {
            $replace['{toggleData}'] = $toggleData;
        }
        if (strpos($this->layout, '{toogleDataNoContainer}') > 0) {
            $replace['{toogleDataNoContainer}'] = $toggleDataNoContainer;
        }
        $this->layout = strtr($this->layout, $replace);
        $this->layout = str_replace('{items}', Html::tag('div', '{items}', $this->containerOptions), $this->layout);
        if (is_array($this->replaceTags) && !empty($this->replaceTags)) {
            foreach ($this->replaceTags as $key => $value) {
                if ($value instanceof \Closure) {
                    $value = call_user_func($value, $this);
                }
                $this->layout = str_replace($key, $value, $this->layout);
            }
        }
    }

}
