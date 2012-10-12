<?php 
class Bookmark extends AppModel {
	public $name = 'Bookmark';
	
	public $belongsTo = array('User');
    public $validate = array();
	
	public $providers = array();
    
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		
		$this->providers = array(
			'youtube' => array(
				'name' => __('YouTube'),
				'pattern' => '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x',
				'oembed' => 'http://www.youtube.com/oembed?url=%s'
			),
			'soundcloud' => array(
				'name' => __('SoundCloud'),
				'pattern' => '/^http\:\/\/soundcloud.com\/.*/',
				'oembed' => 'http://soundcloud.com/oembed?format=json&url=%s'
			),
			/*'dailymotion' => array(
				'name' => __('DailyMotion'),
				'pattern' => 'dailymotion.com'
			),
			'vimeo' => array(
				'name' => __('Vimeo'),
				'pattern' => 'vimeo.com'
			),
			'mixcloud' => array(
				'name' => __('MixCloud'),
				'pattern' => 'mixcloud.com'
			),*/
		);
		
		/*$this->validate = array(
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
	    );*/
	}
	
	public function beforeSave() {
		parent::beforeSave();
		
		if (isset($this->data[$this->alias]['url'])) {
			// $this->data[$this->alias]['provider'] = 'youtube';
			$this->data[$this->alias]['oembed'] = $this->getOEmbed();
		}
		
    	return true;
	}
	
	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			if (isset($val[$this->alias]['oembed'])) {
				$results[$key][$this->alias]['oembed'] = json_decode($val[$this->alias]['oembed'], true);
			}
		}
		return $results;
	}
	
	public function getOEmbed() {
		if (isset($this->data[$this->alias]['provider']) && isset($this->providers[$this->data[$this->alias]['provider']]['oembed'])) {
			$oEmbedUrl = sprintf($this->providers[$this->data[$this->alias]['provider']]['oembed'], $this->data[$this->alias]['url']);
			
			App::uses('HttpSocket', 'Network/Http');
			$http = new HttpSocket();
			$response = $http->get($oEmbedUrl);
			
			if ($response->isOk()) {
				return $response->body();
			}
		}
	}
	
	// public function findByTags($data = array()) {
        // $this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
        // $this->Tagged->Behaviors->attach('Search.Searchable');

        // $query = $this->Tagged->getQuery('all', array(
            // 'conditions' => array('Tag.name'  => $data['tag']),
            // 'fields' => array('foreign_key'),
            // 'contain' => array('Tag')
        // ));
        // return $query;
    // }
}