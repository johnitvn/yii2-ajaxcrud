<?php

namespace johnitvn\ajaxcrud;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class BulkButtonWidget extends Widget {

	/**
	 * @inheritdoc
	 */
	public $headerOptions = [ 'class' => 'bulk-actions' ];

	/**
	 * @var string the ID of the controller that should handle the actions specified here.
	 * If not set, it will use the currently active controller. This property is mainly used by
	 * [[urlCreator]] to create URLs for different actions. The value of this property will be prefixed
	 * to each action name to form the route of the action.
	 */
	public $controller;

	/**
	 * @var string the template used for composing each cell in the action column.
	 * Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
	 * in the context of action column). They will be replaced by the corresponding button rendering callbacks
	 * specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
	 * the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
	 *
	 * @see buttons
	 */
	public $template = '{bulk-delete}';

	/**
	 * @var array button rendering callbacks. The array keys are the button names (without curly brackets),
	 * and the values are the corresponding button rendering callbacks. The callbacks should use the following
	 * signature:
	 *
	 * ```php
	 * function ($url) {
	 *     // return the button HTML code
	 * }
	 * ```
	 *
	 * where `$url` is the URL that the column creates for the button.
	 *
	 * ```php
	 * [
	 *     'update' => function ($url) {
	 *         return Html::a('Update', $url);
	 *     },
	 * ],
	 * ```
	 */
	public $buttons = [];

	/** @var array visibility conditions for each button. The array keys are the button names (without curly brackets),
	 * and the values are the boolean true/false or the anonymous function. When the button name is not specified in
	 * this array it will be shown by default.
	 * The callbacks must use the following signature:
	 *
	 * Pass a boolean value:
	 *
	 * ```php
	 * [
	 *     'update' => \Yii::$app->user->can('update'),
	 * ],
	 * ```
	 * @since 2.0.7
	 */

	public $visibleButtons = [];

	/**
	 * @var callable a callback that creates a button URL using the specified model information.
	 * The signature of the callback should be the same as that of [[createUrl()]]
	 * Since 2.0.10 it can accept additional parameter, which refers to the column instance itself:
	 *
	 * ```php
	 * function (string $action) {
	 *     //return string;
	 * }
	 * ```
	 *
	 * If this property is not set, button URLs will be created using [[createUrl()]].
	 */
	public $urlCreator;

	/**
	 * @var array html options to be applied to the [[initDefaultButton()|default button]].
	 * @since 2.0.4
	 */
	public $buttonOptions = [];


	public function init() {
		parent::init();
		$this->initDefaultButtons();
	}

	/**
	 * Initializes the default button rendering callbacks.
	 */
	protected function initDefaultButtons() {
		$this->initDefaultButton( 'bulk-delete', 'trash', [
			'class'                => 'btn btn-danger btn-xs',
			'role'                 => 'modal-remote-bulk',
			'data-confirm'         => false,
			'data-method'          => false,// for overide yii data api
			'data-request-method'  => 'post',
			'data-confirm-title'   => yii::t( 'app', 'Are you sure?' ),
			'data-confirm-message' => yii::t( 'app', 'Are you sure want to delete these items' ),
		] );
	}

	/**
	 * Initializes the default button rendering callback for single button
	 *
	 * @param string $name             Button name as it's written in template
	 * @param string $iconName         The part of Bootstrap glyphicon class that makes it unique
	 * @param array $additionalOptions Array of additional options
	 *
	 * @since 2.0.11
	 */
	protected function initDefaultButton( $name, $iconName, $additionalOptions = [] ) {
		if ( ! isset( $this->buttons[ $name ] ) && strpos( $this->template, '{' . $name . '}' ) !== false ) {
			$this->buttons[ $name ] = function ( $url ) use ( $name, $iconName, $additionalOptions ) {
				switch ( $name ) {
					case 'bulk-delete':
						$title = Yii::t( 'yii', 'Delete' );
						break;
					default:
						$title = ucfirst( $name );
				}
				$options = array_merge( [
					'title'      => $title,
					'aria-label' => $title,
				], $additionalOptions, $this->buttonOptions );
				$icon    = Html::tag( 'span', '', [ 'class' => "glyphicon glyphicon-$iconName" ] );

				return Html::a( $icon . '&nbsp;' . $title, $url, $options );
			};
		}
	}

	public function run() {
		$content = preg_replace_callback( '/\\{([\w\-\/]+)\\}/', function ( $matches ) {
			$name = $matches[1];

			if ( isset( $this->visibleButtons[ $name ] ) ) {
				$isVisible = $this->visibleButtons[ $name ] instanceof \Closure
					? call_user_func( $this->visibleButtons[ $name ] )
					: $this->visibleButtons[ $name ];
			} else {
				$isVisible = true;
			}

			if ( $isVisible && isset( $this->buttons[ $name ] ) ) {
				$url = $this->createUrl( $name );

				return call_user_func( $this->buttons[ $name ], $url );
			} else {
				return '';
			}
		}, $this->template );

		return ( ! empty( $content ) ?
			'<div class="pull-left">' .
			'<span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;' .
			Yii::t( 'app', 'With selected' ) . '&nbsp;&nbsp;' .
			$content .
			'</div><div class="clearfix"></div>' :
			''
		);
	}

	/**
	 * Creates a URL for the given action and model.
	 * This method is called for each button and each row.
	 *
	 * @param string $action the button name (or action ID)
	 *
	 * @return string the created URL
	 */
	public function createUrl( $action ) {
		if ( is_callable( $this->urlCreator ) ) {
			return call_user_func( $this->urlCreator, $action, $this );
		} else {
			$params = [ $this->controller ? $this->controller . '/' . $action : $action ];

			return Url::toRoute( $params );
		}
	}
}