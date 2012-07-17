<?php
class Photo extends AppModel {
	public $name = 'Photo';
	public $validate = array();
	
	public $hasMany = array(
		'Comment' => array(
			'foreignKey' => 'foreign_key'
		)
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validate = array(
			'title' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	/*'description' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),*/
	    );
	}
}
?>