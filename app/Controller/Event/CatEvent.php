<?php
App::uses('CrudBaseEvent', 'Crud.Controller/Event');

class CatEvent extends CrudBaseEvent {

	public $catIdFieldsMax = 3;

    public function init(CakeEvent $event) {
		if (isset($event->subject->model->Cat)) {
			$this->catModel =& $event->subject->model->Cat;
			$event->subject->controller->set('catModelClass', $this->catModel->alias);
		}
    }
	
	public function afterFind(CakeEvent $event) {
		if (isset($this->catModel) && is_object($this->catModel) && isset($event->subject->item[$this->catModel->alias]) && !empty($event->subject->item[$this->catModel->alias]) && isset($event->subject->item) && !empty($event->subject->item)) {
			if (isset($event->subject->model->hasAndBelongsToMany[$this->catModel->alias]) && isset($event->subject->item[$this->catModel->alias][0]['id'])) {
				// hasAndBelongsToMany
				$catId = $event->subject->item[$this->catModel->alias][0]['id'];
			} elseif (isset($event->subject->item[$this->catModel->alias]['id'])) {
				// belongsTo
				$catId = $event->subject->item[$this->catModel->alias]['id'];
			}
			
			if (isset($catId) && !empty($catId)) {
				$catPath = $this->catModel->getThreadedPath($catId);
				$event->subject->controller->set(compact('catPath'));
			}
		}
	}
	
	public function beforePaginate(CakeEvent $event) {
		if (isset($this->catModel) && is_object($this->catModel)) {
			if (isset($event->subject->request->params['cat_slug']) && !empty($event->subject->request->params['cat_slug'])) {
				$findBy = 'findBySlug'.ucfirst(TXT_LANG);
				$cat = $this->catModel->{$findBy}($event->subject->request->params['cat_slug']);
				if (empty($cat)) {
					throw new NotFoundException(__('Page non trouvée'));
				}
				
				$catId = $cat[$this->catModel->alias]['id'];
				$cats = $this->catModel->find('threaded', array('conditions' => array('parent_id' => $catId), 'order' => 'name_'.TXT_LANG));
				$catPath = $this->catModel->getThreadedPath($catId);
				
				$event->subject->controller->set(compact('cat', 'catPath'));
				
				$catIdsFields = range(1, $this->catIdFieldsMax);
				
				$paginateOrCond = array();
				foreach ($catIdsFields as $v) {
					$field = 'cat_id';
					$field .= ($v == 1) ? '' : '_'.$v;
					if ($event->subject->model->hasField($field)) {
						$paginateOrCond[$field] = $catId;
					}
				}
				
				if (!empty($paginateOrCond)) {
					$event->subject->controller->paginate['conditions']['or'] = $paginateOrCond;
				} else {
					$event->subject->controller->paginate['conditions']['cat_id'] = $catId;
				}
				
			} elseif (!isset($event->subject->request->params['country'])) {
				$cats = $this->catModel->find('threaded', array('order' => 'name_'.TXT_LANG));
			}
			
			$event->subject->controller->set(compact('cats'));
		}
    }
}