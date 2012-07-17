<?php 
class Country extends AppModel {
	public $name = 'Country';
	public $primaryKey = 'code';
	
	public function beforeFind() {
		$this->displayField = 'name_'.TXT_LANG;
		return true;
	}
}