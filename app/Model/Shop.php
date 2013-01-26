<?php 
class Shop extends AppModel {
	public $useTable = false;
	public $useDbConfig = 'ebayFinding';
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->categories = array(
			115156 => __('Equipements du cheval et de l\'écurie'),
			115150 => __('Equipements du cavalier')
		);
	}
}