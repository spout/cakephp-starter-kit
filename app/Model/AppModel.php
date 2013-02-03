<?php
App::uses('Model', 'Model');
class AppModel extends Model {
	public $recursive = -1;
	public $actsAs = array(
		'Containable',
		'Search.Searchable',
	);
	public $validate = array();
	public $filterArgs = array(
		array('name' => 'query', 'type' => 'query', 'method' => 'matchQueryConditions'),
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validateCaptcha = array(
			'valid' => array('rule' => 'validateCaptcha', 'message' => __('Code de sécurité incorrect')),
			'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
		);
		
		$this->validatePhone = array(
			'valid' => array('rule' => '/^(\+)[0-9]{1,3}[\s][0-9]{1,3}[\s][0-9]{6,10}$/', 'allowEmpty' => true, 'message' => __("Le format du numéro n'est pas valide"))
		);
		
		$this->validateUrl = array(
			'valid' => array('rule' => array('url', true), 'allowEmpty' => true, 'message' => __("Lien non correct"))
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
		
		return true;
	}
	
	public function afterSave() {
		Cache::clear();
	}
	
	public function afterDelete() {
		Cache::clear();
	}
	
	public function isOwnedBy($id, $userId = null) {
		$userId = empty($userId) ? Auth::id() : $userId;
		return $this->field('id', array('id' => $id, 'user_id' => $userId)) === $id;
	}
	
	public function validateCaptcha($check) {
		$solved = CakeSession::read('Captcha.solved');
	
		if (!empty($solved)) {
			return true;
		} else {
			list($field, $value) = each($check);

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
	
	public function matchQueryConditions($data = array()) {
		$filter = $data['query'];
		
		$matchFields = array();
		$genericFields = array('title', 'description', 'city', 'postcode', 'address_components');
		
		foreach ($genericFields as $f) {
			if ($this->hasField($f)) {
				$matchFields[] = $this->alias.'.'.$f;
			}
		}
		
		foreach (Configure::read('Config.languages') as $lang => $v) {
			if ($this->hasField('title_'.$lang)) {
				$matchFields[] = $this->alias.'.'.'title_'.$lang;
			}
			
			if ($this->hasField('description_'.$lang)) {
				$matchFields[] = $this->alias.'.'.'description_'.$lang;
			}
			
		}
				
		$condition = "MATCH (".join(',', $matchFields).") AGAINST ('{$filter}' IN BOOLEAN MODE)";

		return $condition;
	}
	
	public function findAllByDistance($params = array()) {
		$defaultParams = array(
			'distance' => 20,
			'limit' => 10,
		);		
		$params = array_merge($defaultParams, $params);
		extract($params);
		
		if (!isset($id)) {
			if (isset($this->id) && !empty($this->id)) {
				$id = $this->id;
			} else {
				trigger_error('Model::findAllByDistance: please provide id param.');
				return false;
			}
		}
		
		if (!isset($latitude) || !isset($longitude)) {
			trigger_error('Model::findAllByDistance: please provide latitude and longitude param.');
			return false;
		}
		
		$formula = "(6366*acos(cos(radians($latitude))*cos(radians(`geo_lat`))*cos(radians(`geo_lon`)-radians($longitude))+sin(radians($latitude))*sin(radians(`geo_lat`))))";
		$results = $this->find('all', array('fields' => array('*', $formula.' AS distance'), 'conditions' => array('id !=' => $id, 'geo_lat !=' => NULL, 'geo_lon !=' => NULL, $formula.' <=' => $distance), 'limit' => $limit, 'order' => 'distance ASC', 'recursive' => -1));
		return $results;
	}
}