<?php
class CustomFieldsController extends AppController {
	public $name = 'CustomFields';
	public $paginate = array('limit' => 10);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->set('moduleTitle', __('Champs personnalisés'));
		
		$translatableOptions = array('options', 'label', 'legend', 'before', 'between', 'after', 'empty');
		
		$this->set(compact('translatableOptions'));
		
		$this->Auth->allow('inputs', 'form');
	}
	
	public function index($model = null, $foreignKey = null) {
		
		$this->paginate['conditions'] = array();
		if (!empty($model)) {
			$this->paginate['conditions']['model'] = $model;
		}
		
		if (!empty($foreignKey)) {
			$this->paginate['conditions']['foreign_key'] = $foreignKey;
		}
		
		parent::index();
	}
	
	public function form($model, $foreignKey = null) {
		if (empty($this->request->data)) {
			$customFields = $this->{$this->modelClass}->find('all', array('conditions' => array('model' => $model, 'foreign_key' => $foreignKey), 'order' => 'position ASC'));
			$this->request->data['CustomField'] = Set::combine($customFields, '{n}.CustomField.id', '{n}.CustomField');
			$this->request->data['CustomField'][0] = array();//add empty for new record
		} else {
			//die(debug($this->request->data));
			$this->{$this->modelClass}->set($this->request->data);
			if ($this->{$this->modelClass}->saveAll($this->request->data['CustomField'])) {
				$this->flash(__('Les données ont été enregistrées.'), 'Success');
				$redirectUrl = array('action' => 'form', $model, $foreignKey);
				$this->redirect($redirectUrl);
			} else {
				$this->flash(__('Veuillez corriger les erreurs ci-dessous.'), 'Error');
			}
		}
		
		$this->set(compact('model', 'foreignKey'));
	}
	
	public function inputs($model = null, $foreignKey = null) {
		header("Cache-Control: no-cache");
		
		if (empty($model) && isset($this->request->data['model'])) {
			$model = $this->request->data['model'];
		}
		
		if (empty($foreignKey) && isset($this->request->data['foreign_key'])) {
			$foreignKey = $this->request->data['foreign_key'];
		}
		
		$customFields = $this->{$this->modelClass}->find('all', array('conditions' => array('model' => $model, 'foreign_key' => $foreignKey), 'order' => 'position ASC'));
		$this->set(compact('model', 'foreignKey', 'customFields'));
	}
}
?>