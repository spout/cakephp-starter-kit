<?php 
class CategoriesController extends AppController {
	public $name = 'Categories';
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		if (isset($this->request->params['named']['model']) && !empty($this->request->params['named']['model'])) {
			$model = $this->request->params['named']['model'];
			$categories = $this->{$this->modelClass}->find('threaded', array('conditions' => array($this->{$this->modelClass}->alias.'.model' => $model), 'order' => array('name_'.TXT_LANG.' ASC')));
			$categoriesList = $this->{$this->modelClass}->generateThreadedList(array('model' => $model));
			$this->set(compact('categories', 'categoriesList'));
		} else {
			$categoriesModels = $this->{$this->modelClass}->find('all', array('fields' => array('DISTINCT model'), 'conditions' => array('model !=' => NULL)));
			$this->set(compact('categoriesModels'));
		}
	}
}