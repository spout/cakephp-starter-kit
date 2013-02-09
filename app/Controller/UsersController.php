<?php 
class UsersController extends AppController {
	public $components = array('Cookie');

	public function beforeFilter()	{
		parent::beforeFilter();
		$this->Auth->deny('index');
		$this->Auth->allow('activate', 'lost_password');
	}

	public function login() {
		if ($this->request->is('post')) {
			if (isset($this->request->data[$this->modelClass]['email']) && !empty($this->request->data[$this->modelClass]['email'])) {
				$user = $this->{$this->modelClass}->findByEmail($this->request->data[$this->modelClass]['email']);
				
				if (!empty($user) && $user[$this->modelClass]['active'] == 0) {
					$this->Session->setFlash(__('Cet e-mail a bien été trouvé dans notre base de données, mais le compte n\'est pas activé. Vérifiez votre courrier pour le lien d\'activation.'), 'error');
					$this->redirect(array('action' => 'login'));
				}
			}
			
			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_visit', date('Y-m-d H:i:s'));
				
				$this->_setCookie();
				
				$this->Session->setFlash(__('Vous êtes connecté avec succès.'), 'success');
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Combinaison e-mail / mot de passe incorrecte. Veuillez essayer à nouveau.'), 'error');
			}
		}
	}

	public function index() {
		
	}

	public function register()	{
		if ($this->request->is('post')) {
			$fieldList = array('email', 'password', 'password_verify', 'firstname', 'lastname');
			
			$this->request->data['User']['email'] = strtolower($this->request->data['User']['email']);
			$this->User->set($this->request->data);
			
			if ($this->User->save($this->request->data['User'], array('fieldList' => $fieldList))) {
				$activateUrl = Router::url(array('action' => 'activate', $this->User->getLastInsertID(), $this->Auth->password($this->request->data['User']['password'])), $full = true);
				
				$emailTemplate = __('Bonjour %s %s,<p>Merci d\'avoir créé un compte sur notre site:<br />%s</p><p>Vous êtes à un pas de vous enregistrer et d\'accéder à l\'espace réservé aux membres.<br />Pour activer votre compte, cliquez ici:</p><p>%s</p><p>Une fois que vous aurez activé votre compte, vous pourrez vous enregistrer avec les informations suivantes:<br /><strong>E-mail:</strong> %s<br /><strong>Mot de passe:</strong> %s</p><p>Merci!</p><p>Le Webmaster</p>Ceci est un message automatique, svp n\'y répondez pas !');
				$message = sprintf($emailTemplate,
									$this->request->data['User']['firstname'],
									$this->request->data['User']['lastname'],
									'<a href="'.FULL_BASE_URL.'">'.FULL_BASE_URL.'</a>',
									'<a href="'.$activateUrl.'">'.$activateUrl.'</a>',
									$this->request->data['User']['email'],
									$this->request->data['User']['password']
									);
									
				$email = new CakeEmail('default');
				$email->to($this->request->data[$this->modelClass]['email'])
					->subject(__('Activez votre compte membre'))
					->template('default', 'default')
					->emailFormat('html')
					->send($message);
				
				$this->Session->setFlash(__('Un e-mail contenant le lien d\'activation vous a été envoyé, vérifiez votre courrier.<br />Vous devez cliquer sur ce lien pour vérifier votre adresse e-mail avant de pouvoir vous enregistrer.'), 'success');
				
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('Veuillez corriger les erreurs ci-dessous.'), 'error');
			} 
		}
	}

	public function logout() {
		$this->Session->destroy();
		$this->Cookie->destroy();
		
		$this->Session->setFlash(__('Vous êtes maintenant déconnecté.'), 'success');
		$this->redirect($this->Auth->logout());
	}

	public function edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$fieldList = array('firstname', 'lastname');
			$this->User->set($this->request->data);
			
			if ($this->User->save($this->request->data['User'], array('fieldList' => $fieldList))) {
				$this->Session->setFlash(__('Vos informations ont été mises à jour.'), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Veuillez corriger les erreurs ci-dessous.'), 'error');	
			}
		} else {
			$this->User->id = $this->Auth->user('id');
			$this->request->data = $this->User->read();
		}
	}
	
	public function change_password() {
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
			if ($this->User->validates(array('fieldList' => array('password', 'password_verify')))) {
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('password', $this->request->data['User']['password']);
				$this->Session->setFlash(__('Votre mot de passe a été changé.'), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Veuillez corriger les erreurs ci-dessous.'), 'error');	
			}
		}
	}
	
	public function activate($userId = NULL, $password = NULL) {
		if (is_null($userId) && is_null($password) && $this->User->hasAny(array('User.id' => $userId, 'User.password' => $password))) {
			$this->User->id = $userId;
			$this->User->saveField('active', '1');
			$this->Session->setFlash(__('Votre compte a été activé, vous pouvez maintenant vous connecter.'), 'success');
		} else {
			$this->Session->setFlash(__('Erreur d\'activation du compte !'), 'error');
		}

		$this->redirect(array('action' => 'login'));
	}
	
	public function lost_password() {
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
			if ($this->User->validates(array('fieldList' => array('email', 'captcha')))) {
				if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {
					$user = $this->User->findByEmail($this->request->data['User']['email']);
					
					$newPassword = $this->User->generatePassword();
					
					$this->User->id = $user['User']['id'];
					$this->User->saveField('password', $newPassword);
					
					$loginUrl = Router::url(array('action' => 'login'), true);
					
					$emailTemplate = __('Bonjour %s %s,<br /><p>Nous avons changé votre mot de passe.</p><p>Voici vos informations de connexion:<br /><strong>E-mail:</strong> %s<br /><strong>Nouveau mot de passe:</strong> %s</p><p>Vous pouvez vous connecter ici:<br />%s</p><p>Le Webmaster</p>Ceci est un message automatique, svp n\'y répondez pas !');
					$message = sprintf($emailTemplate,
										$user['User']['firstname'],
										$user['User']['lastname'],
										$this->request->data['User']['email'],
										$newPassword,
										'<a href="'.$loginUrl.'">'.$loginUrl.'</a>'
										);
					
					$email = new CakeEmail('default');
					$email->to($this->request->data[$this->modelClass]['email'])
						->subject(__('Votre nouveau mot de passe'))
						->template('default', 'default')
						->emailFormat('html')
						->send($message);

					$this->Session->setFlash(__('Un e-mail contenant votre nouveau mot de passe vous a été envoyé, vérifiez votre courrier.'), 'success');
					$this->redirect(array('action' => 'login'));
					
				} else {
					$this->Session->setFlash(__('Cette adresse e-mail n\'a pas été trouvée dans notre base de donnée.'), 'error');
				}
			}
		}
	}
	
	protected function _setCookie($options = array(), $cookieKey = 'User') {
		if (empty($this->request->data[$this->modelClass]['remember_me'])) {
			$this->Cookie->delete($cookieKey);
		} else {
			$validProperties = array('domain', 'key', 'name', 'path', 'secure', 'time');
			$defaults = array('name' => 'rememberMe');

			$options = array_merge($defaults, $options);
			foreach ($options as $key => $value) {
				if (in_array($key, $validProperties)) {
					$this->Cookie->{$key} = $value;
				}
			}
			
			$usernameField = $this->Auth->authenticate['Form']['fields']['username'];
			$passwordField = $this->Auth->authenticate['Form']['fields']['password'];

			$cookieData = array();
			$cookieData[$usernameField] = $this->request->data[$this->modelClass][$usernameField];
			$cookieData[$passwordField] = $this->request->data[$this->modelClass][$passwordField];
			$this->Cookie->write($cookieKey, $cookieData, true, '1 Month');
		}
		unset($this->request->data[$this->modelClass]['remember_me']);
	}
}