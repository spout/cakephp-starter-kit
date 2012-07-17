<?php 
class AdsController extends AppController {
	public $paginate = array('limit' => 20, 'order' => 'created DESC');
	
	public function beforeFilter() {
		parent::beforeFilter();
		
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
		
		$this->set('moduleTitle', __('Annonces équitation'));
	}
	
	public function view($id) {
		parent::view($id);
		$this->helpers[] = 'AutoEmbed';
		$this->{$this->modelClass}->hit($id);//Hitcount behavior
		$this->set('nearbyResults', $this->{$this->modelClass}->findAllByDistance(array('id' => $id)));
	}
}
?>