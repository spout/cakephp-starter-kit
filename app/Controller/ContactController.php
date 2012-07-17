<?php
class ContactController extends AppController {
	public function index() {
		if ($this->request->is('post')) {
	        $this->Contact->set($this->request->data);
	        if ($this->Contact->validates()) {
				$email = new CakeEmail('default');
				$email->from($this->request->data[$this->modelClass]['email'])
					->subject($this->request->data[$this->modelClass]['subject'])
					->send($this->request->data[$this->modelClass]['message']);
				$this->Session->setFlash(__('Votre message a été envoyé avec succès.'), 'success');
	   			$this->redirect(array('lang' => TXT_LANG, 'controller' => 'contact', 'action' => 'index'));
   			} else {
				$this->Session->setFlash(__('Veuillez corriger les erreurs ci-dessous.'), 'error');
			}
        }
		
  	}
}