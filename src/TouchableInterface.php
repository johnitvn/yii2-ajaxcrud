<?php 
namespace johnitvn\ajaxcrud;

/**
* The interface for Model with touch function
* @author John Martin <john.itvn@gmail.com>
* @since 1.0
*/
interface TouchableInterface{

	/**
	* 
    * @return array the list of fields can touch
    * example:
	* 	return ['block',active']
	*/
	public function getTouchableFields();	


	/**
	* @return array the list of touchable button 's label 
	* 
	* example:
	* 	return [
	*		'block'=>[
	*			'true'=>'Block',
	*			'false'=>'UnB\block',
	*		]
	* 	];
	*/
	public function getTouchableButtonLabels();

	/**
	* @param string $fieldName The name of field want to touch
	* @return boolean the value after touch
	*/
	public function touchField($fieldName);



}