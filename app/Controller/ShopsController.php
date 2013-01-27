<?php 
class ShopsController extends AppController {
	public $paginate = array('limit' => 20);
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('categories', $this->{$this->modelClass}->categories);
	}
	
	public function index($categorySlug = '') {
		if ($this->request->is('post')) {
			$urlRedirect = array('action' => 'index');
			
			$data = $this->request->data;
			
			if (isset($data[$this->modelClass]['categoryId']) && !empty($data[$this->modelClass]['categoryId'])) {
				$urlRedirect[] = $this->{$this->modelClass}->categories[$data[$this->modelClass]['categoryId']]['slug'];
			}
			
			if (isset($data[$this->modelClass]['id']) && !empty($data[$this->modelClass]['id'])) {
				$urlRedirect[$v] = $this->request->data[$this->modelClass]['id'];
			}

			if (isset($data[$this->modelClass]['keywords']) && !empty($data[$this->modelClass]['keywords'])) {
				$keywords = str_replace(':', ' ', $this->request->data[$this->modelClass][$v]);
				$urlRedirect[$v] = urlencode($keywords);
			}
		
			$this->redirect($urlRedirect);
			
		} else {
			$conditions = array();
			
			if (!empty($categorySlug)) {
				$categories = Hash::combine($this->{$this->modelClass}->categories, '{n}.slug', '{n}.id');
				if (isset($categories[$categorySlug])) {
					$categoryId = $categories[$categorySlug];
					$conditions['categoryId'] = $categoryId;
					$this->request->data[$this->modelClass]['categoryId'] = $categoryId;
				}
			}
			
			$named = $this->request->params['named'];
			
			if (isset($named['id']) && !empty($named['id'])) {
				$this->loadModel('Link');
				$link = $this->Link->findById($named['id']);
				if (isset($link['Link']['ebay_store_name']) && !empty($link['Link']['ebay_store_name'])) {
					$conditions['storeName'] = $link['Link']['ebay_store_name'];
				} else {
					$this->redirect(array('action' => 'index'));
				}
				
				$this->request->data[$this->modelClass]['id'] = $named['id'];

				$this->set(compact('link'));
			}
			
			if (isset($named['keywords']) && !empty($named['keywords'])) {
				$conditions['keywords'] = urldecode($named['keywords']);
				$this->request->data[$this->modelClass]['id'] = urldecode($named['keywords']);
			}
			
			if (empty($conditions)) {
				$categoryId = 115156;
				$conditions['categoryId'] = $categoryId;
				$this->request->data[$this->modelClass]['categoryId'] = $categoryId;
			}
		}
		
		$shops = $this->paginate($this->modelClass, $conditions);
		
		$this->set(compact('categorySlug', 'shops'));
	}
}