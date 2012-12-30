<?php 
class Ad extends AppModel {
	public $name = 'Ad';
	
	public $actsAs = array(
		'Containable',
		'Upload.Upload' => array(
			'photo_1' => array('path' => 'webroot{DS}files{DS}annonces{DS}{field}{DS}'),//default 'webroot{DS}files{DS}{model}{DS}{field}{DS}', "ad" is banned keyword by AdBlockPlus
			'photo_2' => array('path' => 'webroot{DS}files{DS}annonces{DS}{field}{DS}'),
			'photo_3' => array('path' => 'webroot{DS}files{DS}annonces{DS}{field}{DS}')
		),
		'Hitcount',
		'CategoryThreaded' => array(
			'relationshipType' => 'belongsTo'
		),
		'Search.Searchable',
	);
	
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
			'category_id' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	'type' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	'title' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	'description' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	'price_type' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	'price' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis')),
	    		'numeric' => array('rule' => 'numeric', 'message' => __('Le prix doit être numérique'))
	    	),
	    	'address' => array(
	    		'required' => array('rule' => 'notEmpty', 'required' => true, 'message' => __('Champ requis'))
	    	),
	    	// 'photo_1' => array(
	    		// 'size' => array('rule' => 'isUnderPhpSizeLimit', 'allowEmpty' => true, 'message' => __('Le poids du fichier est supérieur au maximum accepté')),
	    		// 'mime' => array('rule' => array('isValidMimeType', array('image/jpeg', 'image/pjpeg', 'image/png'), false), 'allowEmpty' => true, 'message' => __('Le type du fichier est invalide')),
	    	// ),
	    	// 'photo_2' => array(
	    		// 'size' => array('rule' => 'isUnderPhpSizeLimit', 'allowEmpty' => true, 'message' => __('Le poids du fichier est supérieur au maximum accepté')),
	    		// 'mime' => array('rule' => array('isValidMimeType', array('image/jpeg', 'image/pjpeg', 'image/png'), false), 'allowEmpty' => true, 'message' => __('Le type du fichier est invalide')),
	    	// ),
	    	// 'photo_3' => array(
	    		// 'size' => array('rule' => 'isUnderPhpSizeLimit', 'allowEmpty' => true, 'message' => __('Le poids du fichier est supérieur au maximum accepté')),
	    		// 'mime' => array('rule' => array('isValidMimeType', array('image/jpeg', 'image/pjpeg', 'image/png'), false), 'allowEmpty' => true, 'message' => __('Le type du fichier est invalide')),
	    	// ),
	    	'email_contact' => array(
				'email' => array('rule' => 'email', 'allowEmpty' => true, 'message' => __('E-mail non valide'))
			),
			'phone' => array(
				'valid' => array('rule' => '/^(\+)[0-9]{1,3}[\s][0-9]{1,3}[\s][0-9]{6,10}$/', 'allowEmpty' => true, 'message' => __('Le format du numéro n\'est pas valide'))
			),
	    	'captcha' => $this->validateCaptcha
	    );
		
		$this->priceTypes = array(
			'fixed' => __('Prix fixé'), 
			'talk' => __('A discuter'), 
			'na' => __('Non applicable'), 
			'free' => __('Gratuit'), 
			'exchange' => __('Echange'), 
			'nc' => __('Non communiqué'),
			//'bid' => __('Enchères')
		);
		
		$this->adsTypes = array(
			'offer' => __('Offre'),
			'demand' => __('Demande')
		);
	}
	
	public function beforeValidate() {
		parent::beforeValidate();
		
		switch($this->data[$this->alias]['price_type']){
    		case 'talk'://A discuter, prix non obligatoire, mais numerique
    			unset($this->validate['price']['required']);
    			if(!isset($this->data[$this->alias]['price']) || empty($this->data[$this->alias]['price'])){
					unset($this->validate['price']['numeric']);
				}
    			break;
    		case 'nc':	
    		case 'na':
    		case 'free':
    		case 'exchange':
    			unset($this->validate['price']);
    			break;
    		default:
    			break;
		}
		return true;	
	}
	
	public function beforeSave() {
		parent::beforeSave();
		
		$urlFields = array('video');
    	foreach($urlFields as $f){
    		if(isset($this->data[$this->alias][$f])){
    			$this->data[$this->alias][$f] = ($this->data[$this->alias][$f] == 'http://') ? '' : $this->data[$this->alias][$f];
    		}
    	}
    	
    	return true;
	}
	
	public function afterSave($created) {
		parent::afterSave($created);
		/*if (AuthComponent::user('role') == 'admin') {
			if (isset($this->data['CustomFieldValue']) && !empty($this->data['CustomFieldValue'])) {
				
				$foreignKey = $this->data[$this->alias]['id'];
				$customFields = array();
				foreach ($this->data['CustomFieldValue'] as $k => $v) {
					if (isset($v['value']) && !empty($v['value'])) {
						$value = $v['value'];
						$customFields[$k] = array(
							'custom_field_id' => $k,
							'foreign_key' => $foreignKey,
							'value' => $value,
						);
					}
				}
				
				//die(debug($customFields));
				
				ClassRegistry::init('CustomFieldValue')->saveAll($customFields);
				unset($this->data['CustomFieldValue']);
				return false;
			}
		}*/	
	}
}