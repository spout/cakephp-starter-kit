<?php
class Comment extends AppModel {
	public $name = 'Comment';
	public $validate = array();
    
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validate = array(
			'name' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'email' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis')),
				'email' => array('rule' => array('email'), 'required' => true, 'message' => __('E-mail non valide'))
			),
			'comment' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
	    	'captcha' => $this->validateCaptcha
	    );
	}
}