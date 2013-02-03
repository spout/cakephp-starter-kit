<?php
App::uses('GenericEvent', 'Controller/Event');

class LinksController extends AppController {
	public $paginate = array('limit' => 15, 'order' => array('Link.created' => 'DESC') , 'contain' => array('Country', 'Category'), 'conditions' => array('Link.active' => 1));
	
	public $presetVars = array(
		array('field' => 'query', 'type' => 'value'),
		array('field' => 'cat_id', 'type' => 'value'),
		array('field' => 'country', 'type' => 'value'),
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->getEventManager()->attach(new GenericEvent());
		
		$this->Crud->enableAction('add');
		$this->Crud->enableAction('edit');

		$this->Auth->allow('add');
		
		//$this->{$this->modelClass}->updateItemCount();
		//$this->_update_categorized();
		
		if ($this->request->params['action'] == 'view' && isset($this->request->params['pass'][0])) {
			$this->Crud->on('Crud.afterFind', array($this, 'viewAfterFindEvent'));
		}
	}
	
	public function viewAfterFindEvent(CakeEvent $event) {
		$item = $event->subject->item[$event->subject->modelClass];
		
		$event->subject->controller->loadModel('Event');
		$events = $event->subject->controller->Event->find('all', array('conditions' => array('link_id' => $item['id'], 'Event.date_end >=' => date('Y-m-d'))));
		$this->set(compact('events'));
		
		if (isset($item['ebay_store_name']) && !empty($item['ebay_store_name'])) {
			$storeName = $item['ebay_store_name'];
			$globalId = (isset($item['ebay_global_id']) && !empty($item['ebay_global_id'])) ? $item['ebay_global_id'] : 'EBAY-FR';
			$event->subject->controller->loadModel('Shop');
			$shops = $event->subject->controller->Shop->find('all', array('conditions' => array('storeName' => $storeName, 'GLOBAL-ID' => $globalId), 'limit' => 5));
			
			$event->subject->controller->set(compact('storeName', 'shops'));
		}
		
		if (isset($item['geo_lat']) && !empty($item['geo_lat']) && isset($item['geo_lon']) && !empty($item['geo_lon'])) {
			$this->set('nearbyItems', $this->{$this->modelClass}->findAllByDistance(array('id' => $item['id'], 'latitude' => $item['geo_lat'], 'longitude' => $item['geo_lon'])));
		}
    }
	
	protected function _update_categorized() {
		$items = $this->{$this->modelClass}->find('all');
		$catIdFields = array('cat_id', 'cat_id_2', 'cat_id_3');
		
		foreach ($items as $item) {
			foreach ($catIdFields as $catIdField) {
				if (!empty($item[$this->modelClass][$catIdField])) {
					$catId = $item[$this->modelClass][$catIdField];
					$this->{$this->modelClass}->Categorized->create();
					$dataSave = array(
						'category_id' => $catId,
						'foreign_key' => $item[$this->modelClass]['id'],
						'model' => $this->modelClass
					);
					$this->{$this->modelClass}->Categorized->save($dataSave);
				}
			}
		}
	}
	
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
	*/
}