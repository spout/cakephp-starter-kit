<?php
class SitemapsController extends AppController {
	public $uses = array();
	
	public function index() {
		$this->layout = 'sitemap';
		
		$models = Configure::read('Sitemaps.models');
		
		if (!empty($models)) {
			$items = array();
			$categories = array();
			foreach ($models as $model) {
				$this->loadModel($model);
				$params = array();
				if ($this->{$model}->hasField('active')) {
					$params['conditions'] = array($model.'.active' => 1);
				}
				$all = $this->{$model}->find('all', $params);
				$items[$model] = Hash::extract($all, '{n}.'.$model);

				if ($this->{$model}->Category instanceof Category) {
					$allCats = $this->{$model}->Category->find('all', array('conditions' => array('model' => $model)));
					$categories[$model] = Hash::extract($allCats, '{n}.Category');
				}
			}

			$this->set(compact('items', 'categories'));
		}
	}
}