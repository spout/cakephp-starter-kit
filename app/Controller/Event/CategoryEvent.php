<?php
App::uses('CrudBaseEvent', 'Crud.Controller/Event');

class CategoryEvent extends CrudBaseEvent {
	
	public function init(CakeEvent $event) {
		if (isset($event->subject->model->Category)) {
			$this->catModel =& $event->subject->model->Category;
			$event->subject->controller->set('catModelClass', $this->catModel->alias);
		}
    }

    /*public function init(CakeEvent $event) {
		if (isset($event->subject->model->Category)) {
			$this->catModel =& $event->subject->model->Category;
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
				$catPath = $this->catModel->getThreadedPath($catId);
				$childrenIds = $this->catModel->getThreadedChildrenIds($catId);
				$subCats = $this->catModel->find('threaded', array('conditions' => array('parent_id' => $catId, 'model' => $event->subject->model->alias), 'order' => 'name_'.TXT_LANG));
				
				if (isset($event->subject->model->hasAndBelongsToMany[$this->catModel->alias])) {
					// HABTM
					$event->subject->model->bindModel(array('hasOne' => array('Categorized' => array('foreignKey' => 'foreign_key'))), false);
					$event->subject->controller->paginate['contain'][] = 'Categorized';
					
					$event->subject->controller->paginate['conditions']['Categorized.category_id'] = array_merge($childrenIds, array($catId));
					$event->subject->controller->paginate['conditions']['Categorized.model'] = $event->subject->model->alias;
					
				} elseif (isset($event->subject->model->belongsTo[$this->catModel->alias])) {
					// belongsTo
					$event->subject->controller->paginate['conditions']['category_id'] = array_merge($childrenIds, array($catId));
				}
				
				$event->subject->controller->set(compact('cat', 'catId', 'catPath', 'subCats'));
			}
			
			$cats = $this->catModel->find('threaded', array('conditions' => array('model' => $event->subject->model->alias), 'order' => 'name_'.TXT_LANG));
			
			$event->subject->controller->set(compact('cats'));
		}
    }*/
}