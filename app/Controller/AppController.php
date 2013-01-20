<?php
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Sanitize', 'Utility');

config('translations');

abstract class AppController extends Controller {
	public $components = array(
		'Crud.Crud' => array(
			'actions' => array(
				'index',
				'view',
				//'admin_index',
				'admin_add',
				'admin_edit',
				'admin_view',
				'admin_delete'
			),
			'validateId' => 'integer',
			'relatedLists' => array('default' => false),
		),
		'Auth' => array(
			'authenticate' => array('Form' => array('fields' => array('username' => 'email', 'password' => 'password'))),
			'authorize' => array('Tools.Tiny'),
			'loginAction' => array('controller' => 'users', 'action' => 'login', 'admin' => false),
			'loginRedirect' => '/',
			'logoutRedirect' => '/',
			'userModel' => 'User',
			'scope' => array('User.active' => 1),
		),
		'RequestHandler',
		'Session',
		'Cookie',
		'Search.Prg' => array(
			'commonProcess' => array(
				'filterEmpty' => true
			)
		),
	);
	
	public $helpers = array(
		'Form',
		'Paginator',
		'Html',
		'Js',
		'Time',
		'Text',
		'Session',
		'Rss',
		'Phpthumb',
		'MyHtml',
		'Utils.Tree',
		'Utils.Gravatar',
		'Minify',
		'DataTable.DataTable' => array(
			'js' => array(
				//'bJQueryUI' => true,
			),
		),
	);
	
	public $paginate = array('conditions' => array());
	
	public $displayFields = array('title', 'name');
	public $bannedFields = array('id', 'created', 'modified');
	
	/**
	* Dispatches the controller action.  Checks that the action exists and isn't private.
	*
	* If Cake raises MissingActionException we attempt to execute Crud
	*
	* @param CakeRequest $request
	* @return mixed The resulting response.
	* @throws PrivateActionException When actions are not public or prefixed by _
	* @throws MissingActionException When actions are not defined and scaffolding and CRUD is not enabled.
	*/
	public function invokeAction(CakeRequest $request) {
		try {
			return parent::invokeAction($request);
		} catch (MissingActionException $e) {
			// Check for any dispatch components
			if (!empty($this->dispatchComponents)) {
				// Iterate dispatchComponents
				foreach ($this->dispatchComponents as $component => $enabled) {
					// Skip them if they aren't enabled
					if (empty($enabled)) {
						continue;
					}

					// Skip if isActionMapped isn't defined in the Component
					if (!method_exists($this->{$component}, 'isActionMapped')) {
						continue;
					}

					// Skip if the action isn't mapped
					if (!$this->{$component}->isActionMapped($request->params['action'])) {
						continue;
					}

					// Skip if executeAction isn't defined in the Component
					if (!method_exists($this->{$component}, 'executeAction')) {
						continue;
					}

					// Execute the callback, should return CakeResponse object
					return $this->{$component}->executeAction();
				}
			}

			// No additional callbacks, re-throw the normal Cake exception
			throw $e;
		}
	}
	
	public function beforeFilter() {
		$this->_setLanguage();
		
		// Set custom response type
		if (isset($this->extraContentTypes[$this->RequestHandler->ext])) {
			$this->response->type(array($this->RequestHandler->ext => Configure::read('Config.extraContentTypes.'.$this->RequestHandler->ext)));
		}
		
		if (isset($this->Auth)) {
			$this->Auth->authError = __("Vous n'êtes pas autorisé à accéder à cette page.");
			
			$this->Auth->allow(Configure::read('Config.publicActions'));
			
			if (Auth::hasRole(ROLE_ADMIN)) {
				$this->Auth->allow();
			}
			
			$this->_restoreLoginFromCookie();
		}
		
		$this->loadModel($this->modelClass);
		if (class_exists($this->modelClass)) {
			$model =& $this->{$this->modelClass};
			
			$modelClass = $this->modelClass;
			$primaryKey = $model->primaryKey;
			$schema = $model->schema();
			$fields = (is_array($schema)) ? array_diff(array_keys($schema), $this->bannedFields) : array();
			$displayField = $model->displayField;
			
			$this->set(compact('modelClass', 'primaryKey', 'fields', 'displayField'));
		}
		
		if (isset($this->request->params['pass'][0]) && in_array($this->request->params['action'], array('edit', 'delete', 'admin_edit', 'admin_delete', 'save_field'))) {
			$this->checkOwner($this->request->params['pass'][0]);
		}
		
		$this->Crud->config('translations', Configure::read('Crud.translations'));
		
		// Customize crud
		$this->Crud->mapActionView(array(
			'add' => 'form',
			'edit' => 'form',
			'admin_index' => 'index',
			'admin_add' => 'form',
			'admin_edit' => 'form',
			'admin_view' => 'view',
		));
		
		$this->getEventManager()->attach(array($this, 'beforeRedirectEvent'), 'Crud.beforeRedirect');
	}

	public function beforeRedirectEvent(CakeEvent $event) {
		if (in_array($event->subject->action, array('add', 'edit', 'admin_add', 'admin_edit'))) {
			$event->subject->url = array('action' => 'view', 'id' => $event->subject->id, 'slug' => slug($event->subject->request->data[$event->subject->model->alias][$event->subject->model->displayField]));
		}
		
		if (in_array($event->subject->action, array('delete', 'admin_delete'))) {
			$event->subject->url = array('action' => 'index');
		}
	}
	
	public function beforeRender() {
		$this->theme = Configure::read('Config.theme');
		
		// Default moduleTitle used in generic breadcrumbs and index
		$moduleTitle = Configure::read('Modules.titles.'.$this->request->params['controller']);
		if (empty($moduleTitle)) {
			$moduleTitle = Inflector::humanize($this->request->params['controller']);
		}
		$this->set(compact('moduleTitle'));
		
		$viewFullPath = APP.'View'.DS.$this->name;
		// Multilanguage views (PagesController)
		if (isset($this->request->params['lang']) && !empty($this->request->params['lang']) && is_readable($viewFullPath.DS.$this->request->params['lang'])) {
			$this->viewPath = $this->viewPath.DS.$this->request->params['lang'];
		}
		
		$genericViewFullPath = APP.'View'.DS.'Elements'.DS.'generic'.DS.'actions';
		$extPath = (isset($this->request->params['ext']) && !empty($this->request->params['ext'])) ? DS.$this->request->params['ext'] : '';
		
		if (!is_readable($viewFullPath.$extPath.DS.$this->request->params['action'].'.ctp') && is_readable($genericViewFullPath.$extPath.DS.$this->request->params['action'].'.ctp')) {
			$this->viewPath = 'Elements'.DS.'generic'.DS.'actions';
			$this->viewPath .= ($this->viewClass != 'Json') ? $extPath : '';// JsonView set automaticaly the extension path /json
		}
		
		if (in_array($this->request->params['action'], array('add', 'edit', 'admin_add', 'admin_edit'))) {
			$id = (isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])) ? $this->request->params['pass'][0] : 0;
			$this->set(compact('id'));
		}
		
		if (in_array($this->request->params['action'], array('add', 'edit', 'search', 'admin_add', 'admin_edit'))) {
			$this->_setAssociatedData();
		}
	}
	
	/**
	* Set language and locale via the URL
	*/
	protected function _setLanguage() {
		if (!isset($this->request->params['lang']) || empty($this->request->params['lang'])) {
			$this->request->params['lang'] = Configure::read('Config.defaultLanguage');
		}
		
		if (!array_key_exists(Configure::read('Config.language'), Configure::read('Config.languages'))) {
			Configure::write('Config.language', Configure::read('Config.defaultLanguage'));
		}
		
		$lang = $this->request->params['lang'];

		if (!defined('TXT_LANG')) {
			define('TXT_LANG', $lang);
		}
		
		$locale = Configure::read('Config.languages.'.$lang.'.locale');
		$locales = $this->_getLocales($locale);
		setlocale(LC_ALL, $locales);
	}
	
	protected function _getLocales($lang) {
		// Loading the L10n object
		App::uses('L10n', 'I18n');
		$l10n = new L10n();

		// Iso2 lang code
		$iso2 = $l10n->map($lang);
		$catalog = $l10n->catalog($lang);
		
		$locales = array(
			$iso2.'_'.strtoupper($iso2).'.'.strtoupper(str_replace('-', '', $catalog['charset'])), // fr_FR.UTF8
			$iso2.'_'.strtoupper($iso2), // fr_FR
			$catalog['locale'], // fra
			$catalog['localeFallback'], // fra
			$iso2 // fr
		);
		return $locales;
	}
	
	protected function _restoreLoginFromCookie() {
		$this->Cookie->name = 'Users';
		$cookie = $this->Cookie->read('rememberMe');
		if (!empty($cookie) && !$this->Auth->user()) {
			$data['User'][$this->Auth->fields['username']] = $cookie[$this->Auth->fields['username']];
			$data['User'][$this->Auth->fields['password']] = $cookie[$this->Auth->fields['password']];
			$this->Auth->login($data);
		}
	}
	
	public function checkOwner($id, $redirect = '/') {
		if (Auth::hasRole(ROLE_ADMIN) || $this->{$this->modelClass}->isOwnedBy($id)) {
			return;
		} else {
			$this->Session->setFlash($this->Auth->authError, 'error');
			$this->redirect($redirect);
		}
	}
	
	public function checkRoles($roles, $redirect = '/') {
		if (Auth::hasRoles($roles)) {
			$this->Session->setFlash($this->Auth->authError, 'error');
			$this->redirect($redirect);
		}
	}
	
	public function checkRole($role, $redirect = '/') {
		$this->checkRoles($role, $redirect);
	}

	public function redirect($url, $status = 301, $exit = true) {
		$this->response->disableCache();// FF6 cache redirect: http://forum.cakephp-fr.org/viewtopic.php?id=4027
		
		if (is_array($url)) {
			if (!isset($url['lang']) && isset($this->request->params['lang'])) {
				$url['lang'] = $this->request->params['lang'];
			}
			
			if (!isset($url['admin'])) {
				$url['admin'] = false;
			}
		}
		parent::redirect($url, $status, $exit);
	}
	
	/**
	 * Sets all the Associated model data
	 *
	 * @access protected
	 */
	protected function _setAssociatedData() {
		foreach(array('belongsTo', 'hasAndBelongsToMany') as $association) {
			foreach ($this->{$this->modelClass}->{$association} as $alias => $values) {
				switch ($alias) {
					case 'Category':
						$list = $this->{$this->modelClass}->{$alias}->generateThreadedList(array('model' => $this->modelClass));
						break;
						
					case 'Country':
						$list = $this->{$this->modelClass}->{$alias}->find('list', array('fields' => array('code', 'name_'.TXT_LANG), 'order' => 'name_'.TXT_LANG));
						break;
						
					default:
						$list = $this->{$this->modelClass}->{$alias}->find('list');
						break;
				}
				$this->set(Inflector::variable(Inflector::pluralize($alias)), $list);
			}
		}
	}
	
	public function save_field($id = null, $field = null, $value = null) {
		
		if ($this->request->is('post') || $this->request->is('put')) {
			extract($this->request->data[$this->modelClass]);
		}
		
		if (!is_null($id) && !is_null($field) && !is_null($value) && $this->{$this->modelClass}->hasField($field)) {
			$this->{$this->modelClass}->id = $id;
			$this->{$this->modelClass}->saveField($field, $value);

			if (!$this->request->is('ajax')) {
				$this->Session->setFlash(__("L'enregistrement #%s a été modifié avec succès", $id), 'success');
				$this->redirect($this->referer());
			} else {
				$this->set(compact('id', 'field', 'value'));
			}
		}
	}
	
	public function admin_index() {
		$columns = array(
			$this->{$this->modelClass}->primaryKey => '#',
			$this->{$this->modelClass}->displayField => Inflector::humanize($this->{$this->modelClass}->displayField),
			'actions' => null,
		);

		$this->paginate = array('limit' => 50);
		$items = $this->paginate();
		
		$this->set(compact('items', 'columns'));
	}
	
	public function datatable() {
		$columns = array(
			$this->{$this->modelClass}->primaryKey => '#',
			$this->{$this->modelClass}->displayField => Inflector::humanize($this->{$this->modelClass}->displayField),
			'actions' => null
		);
		
		$this->set(compact('columns'));
		
		$this->DataTable = $this->Components->load('DataTable.DataTable', array(
			'columns' => $columns,
			'triggerAction' => array('datatable')
		));
		$this->DataTable->initialize($this);
		
		$this->DataTable->paginate = array($this->modelClass);
	}
	
	public function search() {
		$this->Prg->commonProcess();
		$conditions = array_merge($this->paginate['conditions'], $this->{$this->modelClass}->parseCriteria($this->passedArgs));
		$this->paginate['conditions'] = $conditions;
		$this->set('items', $this->paginate());
		$this->set('_serialize', array('items'));// JSON and XML Views
	}
	
	public function autocomplete() {
		if (isset($_GET['term']) && !empty($_GET['term'])) {
			$term = Sanitize::escape($_GET['term']);
			$languages = Configure::read('Config.languages');
			if (!empty($languages)) {
				$conditions = array();
				foreach ($languages as $lang => $v) {
					$field = 'title_'.$lang;
					if ($this->{$this->modelClass}->hasField($field)) {
						$conditions['or'][$field.' LIKE'] = '%'.$term.'%';
					}
				}
			} else {
				$conditions = array($this->{$this->modelClass}->displayField.' LIKE' => '%'.$term.'%');
			}
			
			$conditions = array_merge($this->paginate['conditions'], $conditions);
			
			$results = $this->{$this->modelClass}->find('all', array('conditions' => $conditions, 'limit' => 10));
			
			$items = array();
			foreach ($results as $k => $v) {
				$id = $v[$this->modelClass]['id'];
				$label = getPreferedLang($v[$this->modelClass], 'title');
				$url = Router::url(array('lang' => TXT_LANG, 'action' => 'view', 'id' => $id, 'slug' => slug($label)), true);
				
				$items[$k] = compact('id', 'label', 'url');
			}
			
			$this->set(compact('items'));
		}
	}
	
	public function feed() {
		$items = $this->paginate();
		
		$channel = array(
			'title' => 'RSS',
			'description' => 'RSS',
			'language' => $this->request->params['lang']
		);
 
		$this->set(compact('items', 'channel'));
	}
	
	public function map() {
		$this->{$this->modelClass}->validate = array();
		
		$results = $this->{$this->modelClass}->find('all', array('contain' => array('Country')));
		
		$countriesOptions = array();
		foreach ($results as $r) {
			//$countriesOptions[$r['Country']['code'].'-'.slug($r['Country']['name_'.TXT_LANG])] = $r['Country']['name_'.TXT_LANG];
			$countriesOptions[$r['Country']['code']] = getPreferedLang($r['Country'], 'name');
		}
		
		asort($countriesOptions);
		
		$this->set(compact('countriesOptions'));
		
		if (isset($this->{$this->modelClass}->Category)) {
			$categoriesList = $this->{$this->modelClass}->Category->generateThreadedList(null, 'slug_'.TXT_LANG);
			$this->set(compact('categoriesList'));
		}
	}
	
	public function markers() {
		$conditions = isset($this->paginate['conditions']) ? $this->paginate['conditions'] : array();
		$conditions['geo_lat !='] = NULL;
		$conditions['geo_lon !='] = NULL;
		if (isset($this->request->params['country']) && !empty($this->request->params['country'])) {
			$conditions['country'] = $this->request->params['country'];
		}
		$items = $this->{$this->modelClass}->find('all', array('contain' => array('Country'), 'conditions' => $conditions));
		$this->set(compact('items'));
	}
	
	public function rating($id = null) {
		if (!is_null($id) && ($this->request->is('post') || $this->request->is('put')) && isset($this->request->data[$this->modelClass]['rate'])) {
			$cookieName = $this->modelClass.'_rating_'.$id;
			$cookieName = md5($cookieName);// pretty cool
			$cookieVar = 'true';
			
			$cookieSet = $this->Cookie->read($cookieName);
			
			$submittedRating = $this->request->data[$this->modelClass]['rate'];
			
			$data = $this->{$this->modelClass}->read(null, $id);

			$ip = $this->request->clientIp();

			//check on cookieSet = already click
			if (empty($cookieSet) && $data[$this->modelClass]['rating_last_ip'] != $ip) {
				$newCount = $data[$this->modelClass]['rating_count'] + 1;
				$newRating = $data[$this->modelClass]['rating_avg'] * $data[$this->modelClass]['rating_count'];
				$newRating = ($submittedRating + $newRating) / $newCount;
				$newRating = number_format($newRating, 2, '.', '');

				$saveData = array(
					'rating_avg' => $newRating,
					'rating_count' => $newCount,
					'rating_last_ip' => $ip,
				);
				
				//Bayesian average
				$query = $this->{$this->modelClass}->find('first', array('fields' => array('AVG(rating_count) as avg_count', 'AVG(rating_avg) as avg_avg'), 'conditions' => array('rating_count >' => 0)));
				
				$avgNumVotes = $query[0]['avg_count'];
				$avgRating = $query[0]['avg_avg'];
				
				$thisNumVotes = $data[$this->modelClass]['rating_count'];
				$thisRating = $data[$this->modelClass]['rating_avg'];
				
				$bayesianAvg = (($avgNumVotes * $avgRating) + ($thisNumVotes * $thisRating)) / ($avgNumVotes + $thisNumVotes);
				$bayesianAvg = round($bayesianAvg, 2);
				
				$saveData['rating_bayesian'] = number_format($bayesianAvg, 2, '.', '');
			
				$cookieExpires = 7 * 24 * 60 * 60;//7 jours; 24 heures; 60 minutes; 60 secondes
				$this->Cookie->write($cookieName, $cookieVar, true, $cookieExpires);
				
				$this->{$this->modelClass}->save($saveData, false);
				
				$message = __('Votre note a été enregistrée');
			} else {
				$message = __('Vous avez déjà noté cet enregistrement');
			}
			
			$this->set(compact('message'));
		}
	}
}