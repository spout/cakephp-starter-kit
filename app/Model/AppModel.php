<?php
App::uses('Model', 'Model');
class AppModel extends Model {
	public $recursive = -1;
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validateCaptcha = array(
				'valid' => array('rule' => 'validateCaptcha', 'message' => __('Code de sécurité incorrect')),
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			);
	}
	
	public function beforeValidate() {
		// Trim whitespace from data
		$whitespace = create_function('&$value, &$key', '$key = trim($key); $value = trim($value);');
		array_walk_recursive($this->data, $whitespace);
		
		$solved = CakeSession::read('Captcha.solved');
		$userId = Auth::id();
		
		if (!empty($solved) || !empty($userId)) {
			unset($this->validate['captcha']);
		}
		
		// HABTM form validation: http://stackoverflow.com/a/3716020
		foreach ($this->hasAndBelongsToMany as $k => $v) {
			if (isset($this->data[$k][$k])) {
				$this->data[$this->alias][$k] = $this->data[$k][$k];
			}
		}
		
		return true;
	}
	
	public function afterSave() {
		Cache::clear();
	}
	
	public function afterDelete() {
		Cache::clear();
	}
	
	public function isOwnedBy($id, $userId) {
		return $this->field('id', array('id' => $id, 'user_id' => $userId)) === $id;
	}
	
	public function validateCaptcha($data) {
		$solved = CakeSession::read('Captcha.solved');
	
		if (!empty($solved)) {
			return true;
		} else {
			list($field, $value) = each($data);

			App::import('Vendor', 'Securimage', array('file' => 'securimage'.DS.'securimage.php'));

			$securimage = new Securimage();
			$check = $securimage->check($value);
			
			CakeSession::write('Captcha.solved', $check);
		
			return $check;
		}
	}
	
	public function compareFields($field1, $field2) {
		if (is_array($field1)) {
			$field1 = key($field1);
		}
		if (isset($this->data[$this->alias][$field1]) && isset($this->data[$this->alias][$field2]) &&
			$this->data[$this->alias][$field1] == $this->data[$this->alias][$field2]) {
			return true;
		}
		return false;
	}
	
	public function findAllByDistance($params = array()) {
		$defaultParams = array(
			'distance' => 20,
			'limit' => 10,
			'lat' => 'geo_lat',
			'lng' => 'geo_lon'
		);		
		$params = array_merge($defaultParams, $params);
		extract($params);
		
		if (!isset($id)) {
			trigger_error('Model::findAllByDistance: please provide id param.');
			return false;
		}
		
		$data = $this->read(null, $id);
		if (empty($data)) {
			return false;
		}
		
		$latVal = $data[$this->alias][$lat];
		$lngVal = $data[$this->alias][$lng];
		
		if (empty($latVal) || empty($lngVal)) {
			return false;	
		}
		
		$formula = "(6366*acos(cos(radians($latVal))*cos(radians(`$lat`))*cos(radians(`$lng`)-radians($lngVal))+sin(radians($latVal))*sin(radians(`$lat`))))";
		$results = $this->find('all', array('fields' => array('*', $formula.' AS distance'), 'conditions' => array('id !=' => $id, 'geo_lat !=' => NULL, 'geo_lon !=' => NULL, $formula.' <=' => $distance), 'limit' => $limit, 'order' => 'distance ASC', 'recursive' => -1));
		return $results;
	}
}