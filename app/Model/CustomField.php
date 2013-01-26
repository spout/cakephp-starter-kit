<?php 
class CustomField extends AppModel {
	public $name = 'CustomField';
	
	public function beforeValidate() {
		if (isset($this->data[$this->name]['id']) && !empty($this->data[$this->name]['id']) && empty($this->data[$this->name]['options'])) {
			$this->delete($this->data[$this->name]['id']);
		}
		
		if (empty($this->data[$this->name]['options'])) {
			$this->data = array();//dont save when empty options
		}
		
		return true;
	}
	
	public function validateJson($data) {
		list($field, $value) = each($data);
		
		if (empty($value)) {
			return true;
		}
		
		$jsonDecode = json_decode($value, true);
		
		if (empty($jsonDecode)) {
			return false;
		} else {
			return true;	
		}
	}
}