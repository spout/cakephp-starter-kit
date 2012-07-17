<?php
class EventsController extends AppController {
	public $paginate = array('limit' => 10, 'order' => 'created DESC');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('fullcalendar');
		
		$this->paginate['conditions'] = array('date_end >=' => date('Y-m-d'));
		
		$this->set('moduleTitle', __('Agenda équestre'));
	}
		
	public function index() {
		if (isset($this->request->params['year']) && $this->request->params['year'] < date('Y')) {
			$this->redirect(array('action' => 'index'), 301);
		}
			
		if (isset($this->request->params['year']) && !isset($this->request->params['month'])) {
			$year = $this->request->params['year'];
			
			$start = mktime(0, 0, 0, 1, 1, $year);
			$end = mktime(0, 0, 0, 1, 0, $year + 1);
			
			$conditions = array('OR' => $this->{$this->modelClass}->getBetweenDatesConditions($start, $end));
							
			if (isset($this->request->params['country']) && !empty($this->request->params['country'])) {
				$country = substr($this->request->params['country'], 0, 2);
				$conditions['AND'] = array('Event.country' => $country);
			}
			
			$contain = isset($this->{$this->modelClass}->Country) ? 'Country' : null;			
							
			$events = $this->{$this->modelClass}->find('all', array('conditions' => $conditions, 'order' => array('date_start ASC'), 'contain' => $contain));
			
			$this->set(compact('events'));
		}
	}
	
	public function view($id = null) {
		parent::view($id);
		if ($this->request->data[$this->modelClass]['date_end'] < date('Y-m-d')) {//outdated event
			$this->flash(__('Cet événement a déjà eu lieu.'), 'Info');
			$this->redirect(array('action' => 'index'), 301);
		}
	}
	
	public function fullcalendar($country = null) {
		$start = isset($_POST['start']) ? $_POST['start'] : time();
		$end = isset($_POST['end']) ? $_POST['end'] : time();
		
		$conditions = array('OR' => $this->{$this->modelClass}->getBetweenDatesConditions($start, $end));
						
		if (!empty($country)) {
			$conditions['AND'] = array('Event.country' => $country);
		}
		
		$events = $this->{$this->modelClass}->find('all', array('conditions' => $conditions));
		$this->set(compact('events'));
	}
	
	public function feed() {
		$this->paginate['order'] = array('date_start ASC');
		$this->paginate['conditions'] = array('date_end >=' => date('Y-m-d'));
		parent::feed();
	}
}
?>