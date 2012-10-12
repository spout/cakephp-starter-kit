<?php
class BookmarksController extends AppController {

	public $paginate = array('limit' => 1);

	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->Crud->enableAction('add');
		$this->Crud->enableAction('edit');

		$this->set('providers', $this->{$this->modelClass}->providers);
		
		if ($this->request->params['action'] == 'add') {
			if (isset($this->request->query['url']) && !empty($this->request->query['url']) && false !== filter_var($this->request->query['url'], FILTER_VALIDATE_URL)) {
				$url = $this->request->query['url'];
				
				$this->request->data[$this->modelClass]['url'] = $url;
				
				foreach ($this->{$this->modelClass}->providers as $k => $v) {
					if (preg_match($v['pattern'], $url, $matches)) {
						$this->request->data[$this->modelClass]['provider'] = $k;
						break;
					}
				}
				
				if (!isset($this->request->data[$this->modelClass]['provider']) || empty($this->request->data[$this->modelClass]['provider'])) {
					$this->{$this->modelClass}->invalidate('url', __('Fournisseur de service non supporté'));
				} else {
					$this->{$this->modelClass}->set($this->data);
					$oEmbed = json_decode($this->{$this->modelClass}->getOEmbed(), true);
					
					if (!empty($oEmbed)) {
						if (isset($oEmbed['title']) && !empty($oEmbed['title'])) {
							$this->request->data[$this->modelClass]['title'] = $oEmbed['title'];
						}
						
						if (isset($oEmbed['description']) && !empty($oEmbed['description'])) {
							$this->request->data[$this->modelClass]['description'] = $oEmbed['description'];
						}
					}
				}
			}
		}
	}
	
	/*public function index($videoId = null) {
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.APP.'Vendor'.DS);
		App::import('Vendor', 'Zend_Gdata_YouTube', array('file' => 'Zend/Gdata/YouTube.php'));
		
		$yt = new Zend_Gdata_YouTube();
		$videoEntry = $yt->getVideoEntry($videoId);
		
		$this->set(compact('videoId', 'videoEntry'));
	}*/
}