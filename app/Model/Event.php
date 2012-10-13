<?php
class Event extends AppModel {
	public $name = 'Event';
	public $recursive = -1;
	
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
		'Country' => array(
			'foreignKey' => 'country'
		),
		'User'
	);
	
	public $validate = array();
		
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validate = array(
			'email' => array(
				'email' => array('rule' => 'email', 'message' => __('E-mail non valide')),
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'firstname' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'lastname' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'title' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'description' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'date_start' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'), 'last' => true),
				'valid' => array('rule' => 'date', 'message' => __('Date non valide'))
			),
			'date_end' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'), 'last' => true),
				'valid' => array('rule' => 'date', 'message' => __('Date non valide'))
			),
			'address' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
	    	//'captcha' => $this->validateCaptcha
	    );
	}
	
	public function getBetweenDatesConditions($dateStart, $dateEnd) {
		//http://pcaboche.developpez.com/article/mysql/fonctions-date-heure/?page=2_1#Lpb_hotel_requete
		
		$mysqlDateStart = date('Y-m-d', $dateStart);
		$mysqlDateEnd = date('Y-m-d', $dateEnd);
		
		return array(
					"'$mysqlDateStart' BETWEEN date_start AND date_end",
					"'$mysqlDateEnd' BETWEEN date_start AND date_end",
					'Event.date_start BETWEEN ? AND ?' => array($mysqlDateStart, $mysqlDateEnd),
					'Event.date_end BETWEEN ? AND ?' => array($mysqlDateStart, $mysqlDateEnd),
				);
	}
}