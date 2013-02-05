<?php

class NewslettersController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('subscribe', 'unsubscribe');
	}
	
	public function subscribe() {
		if ($this->request->is('post')) {
			if ($this->{$this->modelClass}->save($this->request->data)) {
				$this->Session->setFlash(__('Votre e-mail a été ajouté à la liste de diffusion de notre newsletter.'), 'success');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('Veuillez corriger les erreurs ci-dessous.'), 'error');
			}
		}
	}
	
	public function unsubscribe() {
		if ($this->request->is('post')) {
			unset($this->{$this->modelClass}->validate['email']['unique']);
			$this->{$this->modelClass}->set($this->request->data);
			if ($this->{$this->modelClass}->validates()) {
				$item = $this->{$this->modelClass}->findByEmail($this->request->data($this->modelClass.'.email'));
				if (!empty($item)) {
					$this->{$this->modelClass}->delete($item[$this->modelClass]['id']);
					$this->Session->setFlash(__('Votre e-mail a été supprimé de la liste de diffusion de notre newsletter.'), 'success');
					$this->redirect('/');
				} else {
					$this->Session->setFlash(__("Cet e-mail n'a pas été trouvé dans notre base de données."), 'error');
				}
			} else {
				$this->Session->setFlash(__('Veuillez corriger les erreurs ci-dessous.'), 'error');
			}
		}
	}
}