<?php
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Sanitize', 'Utility');

abstract class AppController extends Controller {
    public $components = array(
        'Crud.Crud' => array(
            'actions' => array(
				'index',
				// 'add',
				// 'edit',
				'view',
				// 'delete',
				
				'admin_index',
				'admin_add',
				'admin_edit',
				'admin_view',
				'admin_delete'
			),
			'validateId' => 'integer',
			'relatedLists' => array('default' => false)
        ),
		'Auth',
		'RequestHandler',
		'Session',
		'Cookie',
		'Search.Prg' => array(
			'commonProcess' => array(
				'filterEmpty' => true
			)
		)
    );
	
	public $helpers = array(
		'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
		'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
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
		'Minify'
	);
	
	public $extraContentTypes = array(
		'kml' => 'application/vnd.google-earth.kml+xml'
	);
	
	public $displayFields = array('title', 'name');
	public $bannedFields = array('id', 'created', 'modified');
	
	public function beforeFilter() {
		$this->_setLanguage();
	
		// Multilanguage views (PagesController)
		if (isset($this->request->params['lang']) && !empty($this->request->params['lang']) && is_readable(APP.'View'.DS.$this->viewPath.DS.$this->request->params['lang'])) {
			$this->viewPath = $this->viewPath.DS.$this->request->params['lang'];
		}
		
		// Set custom response type
		if (isset($this->extraContentTypes[$this->RequestHandler->ext])) {
			$this->response->type(array($this->RequestHandler->ext => $this->extraContentTypes[$this->RequestHandler->ext]));
		}
		
		if (isset($this->Auth)) {
			$this->Auth->authenticate = array('Form' => array('fields' => array('username' => 'email', 'password' => 'password')));
			$this->Auth->authorize = array('Tools.Tiny');
			$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false);
			$this->Auth->loginRedirect = '/';
			$this->Auth->logoutRedirect = '/';
			$this->Auth->authError = __("Vous n'êtes pas autorisé à accéder à cette page.");
			$this->Auth->userModel = 'User';
			$this->Auth->scope = array('User.active' => 1);
			
			$this->Auth->allow(Configure::read('Config.publicActions'));
			
			if (Auth::hasRole(ROLE_ADMIN)) {
				$this->Auth->allow();
			}
			
			$this->restoreLoginFromCookie();
		}
		
		$this->set('moduleTitle', Inflector::humanize($this->request->params['controller']));// Default moduleTitle used in generic breadcrumbs and index
		
		$siteComponent = Inflector::classify(str_replace('.', '', env('HTTP_HOST')));
		$siteComponentClass = $siteComponent.'Component';
		if (file_exists(APP.'Controller'.DS.'Component'.DS.$siteComponentClass.'.php')) {
			$this->Components->load($siteComponent);
		}
		
		$this->loadModel($this->modelClass);
		if (class_exists($this->modelClass)) {
			$model =& $this->{$this->modelClass};
			
			$modelClass = $this->modelClass;
			$singularVar = Inflector::variable($modelClass);
			$pluralVar = Inflector::variable($this->name);
			$primaryKey = $model->primaryKey;
			$schema = $model->schema();
			$fields = (is_array($schema)) ? array_diff(array_keys($schema), $this->bannedFields) : array();
			$displayField = $model->displayField;
			
			$this->set(compact('modelClass', 'singularVar', 'pluralVar', 'primaryKey', 'fields', 'displayField'));
		}
		
		// Customize crud
		$this->Crud->mapActionView(array(
			'admin_index' => 'index',
			'admin_add' => 'form',
			'admin_edit' => 'form',
			'admin_view' => 'view',
		));
		
		$this->getEventManager()->attach(array($this, 'afterFindSlugEvent'), 'Crud.afterFind');
	}
	
	public function afterFindSlugEvent(CakeEvent $event) {
		if ($event->subject->action == 'view' && isset($event->subject->item) && isset($event->subject->request->params['pass'][0]) && isset($event->subject->request->params['slug'])) {
			$id = $event->subject->request->params['pass'][0];
			$expectedSlug = slug(getPreferedLang($event->subject->item[$event->subject->modelClass], $event->subject->model->displayField));
			if ($expectedSlug != $event->subject->request->params['slug']) {
				$event->subject->controller->redirect(array('action' => 'view', 'id' => $id, 'slug' => $expectedSlug));
			}
		}
	}
	
	public function beforeRender() {
		if (in_array($this->request->params['action'], array('add', 'edit', 'admin_add', 'admin_edit'))) {
			$id = (isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])) ? $this->request->params['pass'][0] : 0;
			$this->set(compact('id'));
		}
		
		if (in_array($this->request->params['action'], array('edit', 'delete', 'admin_edit', 'admin_delete'))) {
			$this->checkOwner($this->request->params['pass'][0]);
		}
		
		if (in_array($this->request->params['action'], array('add', 'edit', 'search', 'admin_add', 'admin_edit'))) {
			$this->_setAssociatedData();
		}
	}
	
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
		
		$locale = setlocale(LC_ALL, sprintf('%s_%s.%s', $lang, strtoupper($lang), Configure::read('App.encoding')));//fr_FR.UTF-8
	}
	
	public function restoreLoginFromCookie() {
		$this->Cookie->name = 'Users';
		$cookie = $this->Cookie->read('rememberMe');
		if (!empty($cookie) && !$this->Auth->user()) {
			$data['User'][$this->Auth->fields['username']] = $cookie[$this->Auth->fields['username']];
			$data['User'][$this->Auth->fields['password']] = $cookie[$this->Auth->fields['password']];
			$this->Auth->login($data);
		}
	}
	
	public function checkOwner($id, $redirect = '/') {
		if (Auth::hasRole(ROLE_ADMIN) || $this->{$this->modelClass}->isOwnedBy($id, Auth::id())) {
			return;
		} else {
			$this->Session->setFlash($this->Auth->authError, 'error');
			$this->redirect($redirect);
		}
	}
	
	/*public function checkOwner($data, $redirect = '/') {
		if (Auth::hasRole(ROLE_ADMIN) || (isset($data[$this->modelClass]['user_id']) && Auth::id() == $data[$this->modelClass]['user_id'])) {
			return;
		} else {
			$this->Session->setFlash($this->Auth->authError, 'error');
			$this->redirect($redirect);
		}
	}*/
	
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
		$this->disableCache();// FF6 cache redirect: http://forum.cakephp-fr.org/viewtopic.php?id=4027
		
		if (is_array($url)) {
			if (!isset($url['lang']) && isset($this->request->params['lang'])) {
				$url['lang'] = $this->request->params['lang'];
			}
			
			// if (!isset($url['admin'])) {
				// $url['admin'] = false;
			// }
		}
		
		$routerUrl = Router::url($url, true);
		if (substr($routerUrl, -1) != '/') {
			$routerUrl .= '/'; // Add trailing slash
		}
		
		parent::redirect($routerUrl, $status, $exit);
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
		$idsList = $this->{$this->modelClass}->find('list', array('order' => array('id' => 'ASC')));
		foreach ($idsList as $k => &$v) {
			$v = $k.' - '.$v;
		}
		$this->set(compact('idsList'));

		if ($this->request->is('post') || $this->request->is('put')) {
			$params = array('id', 'field', 'value');
			foreach ($params as $v) {
				if (is_null(${$v}) && isset($this->request->data[$this->modelClass][$v])) {
					${$v} = $this->request->data[$this->modelClass][$v];
				}
			}
		}
		
		if (!is_null($id) && !is_null($field) && !is_null($value) && $this->{$this->modelClass}->hasField($field)) {
			$this->{$this->modelClass}->id = $id;
			$this->{$this->modelClass}->saveField($field, $value);
			$this->Session->setFlash(sprintf(__('Le champ "%s" de l\'enregistrement #%s a été mis à la valeur "%s".'), $field, $id, $value), 'success');
			$this->redirect('/');
		}
	}
	
	public function search() {
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
		$this->set('items', $this->paginate());
		$this->set('_serialize', array('items'));// JSON and XML Views
	}
	
	public function feed() {
		$items = $this->paginate();
		
		$channel = array(
			'title' => 'RSS',
			'description' => 'RSS',
			'language' => $this->request->params['lang']
		);
 
		$this->set(compact('items', 'channel'));
		
		if (!is_file(APP.'View'.DS.$this->viewPath.DS.'feed.ctp')) {
			$this->render('/Elements/generic/actions/rss/feed');
		}
	}
	
	public function map() {
		$this->{$this->modelClass}->validate = array();
		
		$results = $this->{$this->modelClass}->find('all', array('contain' => array('Country')));
		
		$countriesOptions = array();
		foreach ($results as $r) {
			$countriesOptions[$r['Country']['code'].'-'.slug($r['Country']['name_'.TXT_LANG])] = $r['Country']['name_'.TXT_LANG];
		}
		
		asort($countriesOptions);
		
		$this->set(compact('countriesOptions'));
		
		if (isset($this->{$this->modelClass}->Category)) {
			$catsList = $this->{$this->modelClass}->Category->generateThreadedList(null, 'slug_'.TXT_LANG);
			$this->set(compact('catsList'));
		}
	}
	
	public function rating($id = null) {
		$this->autoRender = false;
		
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
				
				$saveData = array();
				$saveData[$this->modelClass]['rating_avg'] = $newRating;
				$saveData[$this->modelClass]['rating_count'] = $newCount;
				$saveData[$this->modelClass]['rating_last_ip'] = $ip;
				
				//Bayesian average
				$query = $this->{$this->modelClass}->find('first', array('fields' => array('AVG(rating_count) as avg_count', 'AVG(rating_avg) as avg_avg'), 'conditions' => array('rating_count >' => 0)));
				
				$avg_num_votes = $query[0]['avg_count'];
				$avg_rating = $query[0]['avg_avg'];
				
				$this_num_votes = $data[$this->modelClass]['rating_count'];
				$this_rating = $data[$this->modelClass]['rating_avg'];
				
				$bayesianAvg = (($avg_num_votes * $avg_rating) + ($this_num_votes * $this_rating)) / ($avg_num_votes + $this_num_votes);
				$bayesianAvg = round($bayesianAvg, 2);
				
				$saveData[$this->modelClass]['rating_bayesian'] = number_format($bayesianAvg, 2, '.', '');
			
				$cookieExpires = 7 * 24 * 60 * 60;//7 jours; 24 heures; 60 minutes; 60secondes
				$this->Cookie->write($cookieName, $cookieVar, true, $cookieExpires);
				
				$this->{$this->modelClass}->save($saveData, false);
				
				echo __('Votre note a été enregistrée');
			} else {
				echo __('Vous avez déjà noté cet enregistrement');
			}
		}
	}
}