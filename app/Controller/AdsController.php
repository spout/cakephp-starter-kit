<?php 
App::uses('CategoryEvent', 'Controller/Event');
App::uses('CountryEvent', 'Controller/Event');

class AdsController extends AppController {
	public $paginate = array('limit' => 20, 'order' => 'created DESC');
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->getEventManager()->attach(new CategoryEvent());
		$this->getEventManager()->attach(new CountryEvent());
		
		$this->Crud->enableAction('add');
		$this->Crud->enableAction('edit');
		
		$priceTypes = array(
			'fixed' => __('Prix fixé'), 
			'talk' => __('A discuter'), 
			'na' => __('Non applicable'), 
			'free' => __('Gratuit'), 
			'exchange' => __('Echange'), 
			'nc' => __('Non communiqué'),
			//'bid' => __('Enchères')
		);
		
		$adsTypes = array(
			'offer' => __('Offre'),
			'demand' => __('Demande')
		);
		
		$this->set(compact('priceTypes', 'adsTypes'));
		
		// $this->set('moduleTitle', __('Annonces équitation'));
		
		// $this->{$this->modelClass}->updateItemCount();
		
		// $items = $this->{$this->modelClass}->find('all');
		
		// foreach ($items as $item) {
			// $this->{$this->modelClass}->Categorized->create();
			
			// $dataSave = array(
				// 'category_id' => $item[$this->modelClass]['category_id'],
				// 'foreign_key' => $item[$this->modelClass]['id'],
				// 'model' => $this->modelClass
			// );
			// $this->{$this->modelClass}->Categorized->save($dataSave);
		// }
	}
}