<?php 
class PaymentsController extends AppController {
	public $paginate = array('limit' => 10, 'order' => array('Payment.created' => 'desc'));
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->set('moduleTitle', __('Paiements'));
		
		$this->Auth->allow('rentabiliweb', 'teads');
	}
	
	public function rentabiliweb() {
		$this->autoRender = false;
		
		$hashKey = Configure::read('Rentabiliweb.hashKey');
		
		$docId = intval($_GET['docId']);//docId : Identifiant de votre document
		$uid = $_GET['uid'];//uid : Identifiant de votre membre
		$awards = intval($_GET['awards']);//awards : Nombre de point(s) que le membre a gagné
		$trId = $_GET['trId'];//trId : Référence de la transaction
		$promoId = (isset($_GET['promoId'])) ? intval($_GET['promoId']) : 0;
		$hash = $_GET['hash'];//hash : Hash de sécurité calculé ainsi : md5(uid . awards . trId . hashKey)
		
		if (md5($uid.$awards.$trId.$hashKey) == $hash) {
			$count = $this->{$this->modelClass}->find('count', array('external_reference' => $trId));
			
			if ($count == 0) {
				$this->{$this->modelClass}->create();
				$data = array('doc_id' => $docId, 'foreign_key' => $uid, 'type' => __FUNCTION__, 'awards' => $awards, 'external_reference' => $trId, 'promo_id' => $promoId);
				$this->{$this->modelClass}->save($data, array('validate' => false));
				
				$this->{$this->modelClass}->updateAwards('Link', $uid, $awards);
			} else {
				$log = 'Transaction reference already added.';
				CakeLog::write(__FUNCTION__, $log);
				echo $log;
			}
		} else {
			$log = 'Hash error.';
			CakeLog::write(__FUNCTION__, $log);
			echo $log;
		}

	}
	
	public function teads($id = null) {
		if (empty($id)) {
			exit();
		}
		
		$this->autoRender = false;
		
		$this->loadModel('Link');
		$link = $this->Link->read(null, $id);
		if (empty($link)) {
			$this->redirect('/');
		}
		
		App::import('Vendor', 'Teads', array('file' => 'teads/lib/teads.class.php'));
		
		$teads = new Teads();
		$teads->extractData();
		
		switch($teads->getStatus()) {
			case 'error':
				$this->flash(__('Une erreur s\'est produite.'), 'Error');
				CakeLog::write(__FUNCTION__, $teads->getError());
				break;
			case 'success':
				$this->{$this->modelClass}->create();
				$data = array('foreign_key' => $id, 'type' => __FUNCTION__, 'awards' => 5);
				$this->{$this->modelClass}->save($data, array('validate' => false));
				
				$this->{$this->modelClass}->updateAwards('Link', $id, 5);
				
				$this->flash(__('%d points ajoutés avec succès !', 5), 'Success');
				break;
			case 'cancel' :
				$this->flash(__('Vous avez abandonné la procédure pour gagner des points.'), 'Info');
				break;
			case 'noAd':
				$this->flash(__('Il n\'y a aucune publicité pour le moment, veuillez réessayer plus tard.'), 'Info');
				break;
			default: 
				break;	
		}
		
		$this->redirect(array('controller' => 'links', 'action' => 'view', 'id' => $id, 'slug' => slug(getPreferedLang($link['Link'], 'title'))));
	}
}
?>