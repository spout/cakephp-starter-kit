<?php 
App::uses('GenericEvent', 'Controller/Event');

class AdsController extends AppController {
	public $paginate = array('limit' => 20, 'order' => array('Ad.created' => 'DESC'));
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->getEventManager()->attach(new GenericEvent());
		
		$this->Crud->enableAction('add');
		$this->Crud->enableAction('edit');
		
		$this->Auth->allow('add');
		
		$this->set('priceTypes', $this->{$this->modelClass}->priceTypes);
		$this->set('adsTypes', $this->{$this->modelClass}->adsTypes);
		
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