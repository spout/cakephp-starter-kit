<?php

class Newsletter extends AppModel {
	
	public $displayField = 'email';
	public $validate = array(
		'email' => array(
				'valid' => array('rule' => 'email',	'required' => true,	'message' => 'Veuillez entrer une adresse e-mail valide'),
				'unique' => array('rule' => array('isUnique', 'email'),	'on' => 'create', 'message' => 'Cet e-mail est déjà inscrit')
			)
	);
}