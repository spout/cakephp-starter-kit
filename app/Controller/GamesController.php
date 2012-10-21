<?php
class GamesController extends AppController {
	public $paginate = array('limit' => 15, 'order' => array('Game.created' => 'DESC') , 'conditions' => array('Game.active' => 1));
	
	public $presetVars = array(
		array('field' => 'query', 'type' => 'value'),
		array('field' => 'platforms', 'type' => 'value'),
	);
	
	public $esrbRatings = array(
		'EC' => 'EC - Early Childhood (à partir de 3 ans)',
		'E' => 'E - Everyone (à partir de 6 ans)',
		'E10+' => 'E10+ - Everyone 10+ (à partir de 10 ans)',
		'T' => 'T - Teen (à partir de 13 ans)',
		'M' => 'M - Mature (à partir de 17 ans)',
		'AO' => 'AO - Adults Only (à partir de 18 ans)',
		'RP' => 'RP - Rating Pending (en attente de classement)'
	);
	
	public $pegiRatings = array(
		'3' => '3+',
		'7' => '7+',
		'12' => '12+',
		'16' => '16+',
		'18' => '18+'
	);
	
	public $platforms = array(
		'win' => 'Windows',
		'macos' => 'Mac OS',
		'linux' => 'Linux',
		'bsd' => 'BSD',
		'solaris' => 'Solaris',
		'android' => 'Android',
		'ios' => 'iOS'
	);
	
	public $gamesLanguages = array(
		'fr' => 'Français',
		'en' => 'Anglais',
		'intl' => 'International'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->{$this->modelClass}->contain(array('Category'));
		
		$this->set('esrbRatings', $this->esrbRatings);
		$this->set('pegiRatings', $this->pegiRatings);
		$this->set('platforms', $this->platforms);
		$this->set('gamesLanguages', $this->gamesLanguages);
		$this->set('yesNo', array('yes' => __('Oui'), 'no' => __('Non')));
		
		$this->getEventManager()->attach(array($this, 'beforePaginateEvent'), 'Crud.beforePaginate');
		// $this->getEventManager()->attach(array($this, 'afterFindCategoryEvent'), 'Crud.afterFind');
		
		$sidebarCategories = $this->{$this->modelClass}->Category->find('threaded', array('conditions' => array('Category.item_count !=' => 0, 'Category.model' => 'Game'), 'order' => array($this->{$this->modelClass}->Category->alias.'.name_'.TXT_LANG.' ASC')));
		$this->set(compact('sidebarCategories'));
	}
	
	public function beforePaginateEvent(CakeEvent $event) {
		if (isset($event->subject->request->params['named']['platform']) && !empty($event->subject->request->params['named']['platform'])) {
			$event->subject->controller->paginate['conditions']['Game.platforms LIKE'] = '%'.$event->subject->request->params['named']['platform'].'%';
		}
		
		if (isset($event->subject->request->params['pass'][0]) && !empty($event->subject->request->params['pass'][0])) {
			$category = $event->subject->model->Category->findBySlug($event->subject->request->params['pass'][0]);
			if (empty($category)) {
				throw new NotFoundException(__('Page non trouvée'));
			}
			
			$catPath = $event->subject->model->Category->getThreadedPath($category['Category']['id']);
			
			$this->set(compact('category', 'catPath'));
			
			// HABTM pagination
			$event->subject->model->bindModel(array('hasOne' => array('Categorized' => array('foreignKey' => 'foreign_key'))), false);
			$event->subject->controller->paginate['contain'] = array('Categorized');
			$event->subject->controller->paginate['conditions']['Categorized.category_id'] = $category['Category']['id'];
			$event->subject->controller->paginate['conditions']['Categorized.model'] = $this->{$this->modelClass}->alias;
			
			// belongsTo
			// $event->subject->controller->paginate['conditions']['category_id'] = $category['Category']['id'];
		}
    }
	
	// public function afterFindCategoryEvent(CakeEvent $event) {
		// if (isset($event->subject->item['Category']) && !empty($event->subject->item['Category'])) {
			// $category = $event->subject->item['Category'][0];
			// $catPath = $event->subject->model->Category->getThreadedPath($category['id']);
			// $this->set(compact('catPath'));
		// }
	// }
	
	public function admin_upgrade_categories() {
		$this->autoRender = false;
		
		$games = $this->{$this->modelClass}->find('all');
		foreach ($games as $game) {
			$categorized = array(
				'category_id' => $game[$this->modelClass]['category_id'],
				'foreign_key' => $game[$this->modelClass]['id'],
				'model' => $this->modelClass
			);
			$this->{$this->modelClass}->Categorized->create();
			$this->{$this->modelClass}->Categorized->save($categorized);
		}
		
		$this->{$this->modelClass}->updateItemCount();
	}
}