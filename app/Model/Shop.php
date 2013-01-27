<?php 
class Shop extends AppModel {
	public $useTable = false;
	public $useDbConfig = 'ebayFinding';
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->categories = array(
			115156 => array(
				'id' => 115156,
				'slug' => 'cheval-ecurie',
				'title' => __('Equipements du cheval et de l\'écurie')
			),
			115150 => array(
				'id' => 115150,
				'slug' => 'cavalier',
				'title' => __('Equipements du cavalier')
			),
		);
	}
}