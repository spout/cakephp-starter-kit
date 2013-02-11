<?php
class User extends AppModel {	
	public $name = 'User';

	public $validate = array();
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'email' => array(
				'valid' => array('rule' => 'email',	'required' => true,	'message' => __('Veuillez entrer une adresse e-mail valide')),
				'unique' => array('rule' => array('isUnique', 'email'),	'on' => 'create', 'message' => __('Cet e-mail est déjà inscrit'))
			),
			'password' => array(
				'length' => array('rule' => array('minLength', '6'), 'message' => __('Le mot de passe doit être de 6 caractères minimum')),
				'required' => array('rule' => 'notEmpty', 'required' => 'create', 'message' => __('Veuillez entrer un mot de passe'))
			),
			'password_verify' => array(
				'same' => array('rule' => array('compareFields', 'password', 'password_verify'), 'required' => 'create', 'message' => __('Les mots de passe ne correspondent pas')),
			),	
			'firstname' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'lastname' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'captcha' => $this->validateCaptcha
		);
	}
	
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		
		if (isset($this->data['User']['email']) && !empty($this->data['User']['email'])) {
			$this->data['User']['email'] = strtolower($this->data['User']['email']);
		}
		
		if (isset($this->data['User']['password']) && !empty($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);	
		}
        
        return true;
    }
	
	public function generatePassword($length = 10) {
		srand((double)microtime()*1000000);
	
		$vowels = array("a", "e", "i", "o", "u");
		$cons = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr", "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl");
		
		$num_vowels = count($vowels);
		$num_cons = count($cons);
	
		$password = '';
		for ($i = 0; $i < $length; $i++) {
			$password .= $cons[rand(0, $num_cons - 1)] . $vowels[rand(0, $num_vowels - 1)];
		}
	
		return substr($password, 0, $length);
	}	
}
