<?php
App::uses('CatEvent', 'Controller/Event');
// App::uses('CountryEvent', 'Controller/Event');

class LinksController extends AppController {
	public $paginate = array('limit' => 20, 'order' => array('Link.awards' => 'DESC', 'Link.created' => 'DESC') , 'conditions' => array('Link.active' => 1), 'contain' => array('Country', 'Cat'));
	
	public $presetVars = array(
		array('field' => 'query', 'type' => 'value'),
		array('field' => 'cat_id', 'type' => 'value'),
		array('field' => 'country', 'type' => 'value'),
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->getEventManager()->attach(new CatEvent());
		// $this->getEventManager()->attach(new CountryEvent());
		
		// $this->{$this->modelClass}->bindModel(array('hasOne' => array('CatRelationship' => array('foreignKey' => 'foreign_key'))), false);
		// $this->{$this->modelClass}->contain(array('CatRelationship'));
		
		// $params = array(
			// 'conditions' => array(
				// 'CatRelationship.cat_id' => array(42, 25)
			// ),
		// );
		
		// pr($this->{$this->modelClass}->find('count', $params));
		
		$this->Auth->allow('add', 'edit', 'thumbs');
	}
	
	public function search() {
		$this->Prg->commonProcess();
        $this->paginate['conditions'] = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
        $this->set('items', $this->paginate());
	} 
	
	/*public function view($id) {
		$this->helpers[] = 'AutoEmbed';
		$this->set('nearbyResults', $this->{$this->modelClass}->findAllByDistance(array('id' => $id)));
		
		$this->{$this->modelClass}->bindModel(array('hasMany' => array('Event' => array('conditions' => array('Event.date_end >=' => date('Y-m-d'))))));
		$this->{$this->modelClass}->contain('Event');
		//parent::view($id);
		
		if (isset($this->request->data[$this->modelClass]['ebay_store_name']) && !empty($this->request->data[$this->modelClass]['ebay_store_name'])) {
			$storeName = $this->request->data[$this->modelClass]['ebay_store_name'];
			$globalId = (isset($this->request->data[$this->modelClass]['ebay_global_id']) && !empty($this->request->data[$this->modelClass]['ebay_global_id'])) ? $this->request->data[$this->modelClass]['ebay_global_id'] : 'EBAY-FR';
			$this->loadModel('Shop');
			$shops = $this->Shop->find('all', array('conditions' => array('storeName' => $storeName, 'GLOBAL-ID' => $globalId), 'limit' => 5));
			$this->set(compact('storeName', 'shops'));
		}
	}*/
	
	/*public function form($id = null, $catId = null) {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->{$this->modelClass}->isSpam(getPreferedLang($this->request->data[$this->modelClass], 'title'))) {
				$this->flash(__("Vous avez été prévenu ! La proposition de la fiche a été ignorée. Si vous pensez qu'il s'agit d'une erreur, vous pouvez nous contacter."), 'Error');
				$this->redirect('/');
			}
		}
		parent::form($id, $catId);
	}*/
	
	/*public function accept($id) {
		//$this->checkRole(ROLE_ADMIN);
		
		$this->{$this->modelClass}->validate = array();
		
		$link = $this->{$this->modelClass}->find('first', array('conditions' => array($this->modelClass.'.id' => $id), 'contain' => array('User')));
		$this->set('link', $link);
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->{$this->modelClass}->set($this->request->data);
			
			if ($this->{$this->modelClass}->validates()) {
				$this->{$this->modelClass}->id = $id;
				$this->{$this->modelClass}->save(array($this->modelClass => array('active' => 1, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s'))));
				$this->flash(sprintf(__('L\'enregistrement #%s a été activé.'), $id), 'Success');
				
				CakeEmail::deliver($this->request->data[$this->modelClass]['email'], $this->request->data[$this->modelClass]['subject'], $this->request->data[$this->modelClass]['message']);
				
				$this->flash(__('Votre message a été envoyé avec succès.'), 'Success');
				$this->redirect(array('action' => 'view', 'id' => $id, 'slug' => slug(getPreferedLang($link[$this->modelClass], 'title'))));
			}
			else {
				$this->flash(__('Veuillez corriger les erreurs ci-dessous.'), 'Error');	
			}
		}
	}
	
	public function thumbs() {
		$this->paginate = array('conditions' => array('Link.active' => 1, 'Link.url !=' => ''), 'limit' => 50);
		$links = $this->paginate();
		$this->set(compact('links'));
	}*/
	
	/*public function browse($type = 'my') {
	    
	    switch($type){
	    	default:
		    case 'my':
				$conditions = array('Link.user_id' => $this->Auth->user('id'));
		    	break;
		    	
		    case 'top-sites':
				$conditions = array('Link.url !=' => '', 'Link.count_clicks >=' => 2, 'Link.active' => 1);
		    	$this->paginate['order'] = array('Link.count_clicks' => 'desc');
				break;
			case 'not-active':
				$conditions = array('Link.active !=' => 1);
				break;
				
			case 'thumbs':
				$conditions = array('Link.url !=' => '', 'Link.active' => 1);
				$this->paginate['limit'] = 50;
				break;
	    }
	    
	    $this->set('type', $type);
		
		$this->paginate['conditions'] = $conditions;
		$this->paginate['contain'] = array('Country');	
		
	    $this->set('links', $links = $this->paginate('Link'));
	}*/
}