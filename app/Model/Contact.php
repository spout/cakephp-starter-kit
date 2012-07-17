<?php
class Contact extends AppModel {
	public $name = 'Contact';
	public $validate = array();
    
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validate = array(
			'email' => array(
				'email' => array('rule' => 'email', 'message' => __('E-mail non valide')),
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis')),
			),
			'subject' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'message' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'captcha' => $this->validateCaptcha
	    );
	}

}