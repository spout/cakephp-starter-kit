<?php 
class Country extends AppModel {
	public $name = 'Country';
	public $primaryKey = 'code';
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->displayField = 'name_'.TXT_LANG;
	}
}