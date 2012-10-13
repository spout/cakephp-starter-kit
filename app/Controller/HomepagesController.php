<?php 
class HomepagesController extends AppController {
	public $uses = array('Link', 'Ad', 'Event');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('test');
	}
	
	public function index() {
		$links = $this->Link->find('all', array('conditions' => array('active' => 1), 'order' => 'created DESC', 'limit' => 10));
		$ads = $this->Ad->find('all', array('conditions' => array('photo_1 !=' => ''), 'order' => 'created DESC', 'limit' => 6));
		$events = $this->Event->find('all', array('conditions' => array('date_end >=' => date('Y-m-d')), 'order' => 'date_start ASC', 'limit' => 10));
		
		$this->set(compact('links', 'ads', 'events'));
		
		//$this->set('topSitesLinks', $this->Link->find('all', array('conditions' => $this->topSitesCondition.' AND '.$this->activeCondition, 'order' => 'Link.count_clicks DESC', 'limit' => 10)));
		$this->set('linksCount', $this->Link->find('count', array('conditions' => array('Link.active' => 1))));
		$this->set('linksUrlsCount', $this->Link->find('count', array('conditions' => array('Link.active' => 1, 'Link.url !=' => ''))));
			
		//$query = $this->Link->query("SELECT SUM(count_clicks) AS sum_count_clicks FROM links WHERE active = 1 AND url != ''");
		//$this->set('linksTotalCountClicks', $query[0][0]['sum_count_clicks']);
	}
}