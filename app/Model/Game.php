<?php 
class Game extends AppModel {
	public $name = 'Game';
	
	public $belongsTo = array('User');
	
	public $filterArgs = array(
		array('name' => 'query', 'type' => 'query', 'method' => 'matchQueryConditions'),
		// array('name' => 'tag', 'type' => 'subquery', 'method' => 'findByTags', 'field' => 'Game.id'),
		array('name' => 'platform', 'field' => 'platforms', 'type' => 'like'),
    );
	
    public $validate = array();
	
	public $serializedFields = array('langs', 'platforms');
    
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->validate = array(
			'Category' => array(
	    		'required' => array('rule' => array('multiple', array('min' => 1, 'max' => 3)), 'message' => __('Veuillez sélectionner 1 à 3 catégories'))
	    	),
			'title' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
			'slug' => array(
				'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
			),
	    	'description_fr' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    );
	}
	
	public function beforeSave() {
		parent::beforeSave();
		
		// $urlFields = array('url', 'facebook_url', 'rss_url', 'video');
    	// foreach($urlFields as $field){
    		// if(isset($this->data[$this->alias][$field])){
    			// $this->data[$this->alias][$field] = ($this->data[$this->alias][$field] == 'http://') ? '' : $this->data[$this->alias][$field];
    		// }
    	// }
		
		foreach ($this->serializedFields as $field) {
			if (isset($this->data[$this->alias][$field])) {
				$this->data[$this->alias][$field] = serialize($this->data[$this->alias][$field]);
			}
		}
    	
    	return true;
	}
	
	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			foreach ($this->serializedFields as $field) {
				if (isset($val[$this->alias][$field])) {
					$results[$key][$this->alias][$field] = unserialize($val[$this->alias][$field]);
				}
			}
			
		}
		return $results;
	}
	
	public function matchQueryConditions($data = array()) {
		$filter = $data['query'];
		
		$matchFields = array();
		$genericFields = array('title', 'description');
		
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
}