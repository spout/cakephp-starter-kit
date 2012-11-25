<?php
App::uses('CrudBaseEvent', 'Crud.Controller/Event');

class GenericEvent extends CrudBaseEvent {
	
	public function init(CakeEvent $event) {
		$event->subject->model->contain(array('Country' , 'Category'));
		
		if (isset($event->subject->model->Category)) {
			$this->categoryModel =& $event->subject->model->Category;
			$event->subject->controller->set('categoryModelClass', $this->categoryModel->alias);
		}
    }
	
	public function afterFind(CakeEvent $event) {
		
		if ($event->subject->action == 'view' && isset($event->subject->item) && isset($event->subject->request->params['pass'][0]) && isset($event->subject->request->params['slug'])) {
			$id = $event->subject->request->params['pass'][0];
			$expectedSlug = slug(getPreferedLang($event->subject->item[$event->subject->modelClass], $event->subject->model->displayField));
			if ($expectedSlug != $event->subject->request->params['slug']) {
				$event->subject->controller->redirect(array('action' => 'view', 'id' => $id, 'slug' => $expectedSlug));
			}
		}
		
		if (isset($this->categoryModel) && is_object($this->categoryModel) && isset($event->subject->item[$this->categoryModel->alias]) && !empty($event->subject->item[$this->categoryModel->alias]) && isset($event->subject->item) && !empty($event->subject->item)) {
			if (isset($event->subject->model->hasAndBelongsToMany[$this->categoryModel->alias]) && isset($event->subject->item[$this->categoryModel->alias][0]['id'])) {
				// hasAndBelongsToMany
				$catId = $event->subject->item[$this->categoryModel->alias][0]['id'];// First category
			} elseif (isset($event->subject->item[$this->categoryModel->alias]['id'])) {
				// belongsTo
				$catId = $event->subject->item[$this->categoryModel->alias]['id'];
			}
			
			if (isset($catId) && !empty($catId)) {
				$categoryPath = $this->categoryModel->getThreadedPath($catId);
				$event->subject->controller->set(compact('categoryPath'));
			}
		}
	}
	
	public function beforePaginate(CakeEvent $event) {
		$event->subject->controller->paginate['contain'] = array();
		
		if (isset($this->categoryModel) && is_object($this->categoryModel)) {
			if (isset($event->subject->request->params['cat_slug']) && !empty($event->subject->request->params['cat_slug'])) {
				$findBy = 'findBySlug'.ucfirst(TXT_LANG);
				$category = $this->categoryModel->{$findBy}($event->subject->request->params['cat_slug']);
				if (empty($category)) {
					throw new NotFoundException(__('Page non trouvée'));
				}
				
				$categoryId = $category[$this->categoryModel->alias]['id'];
				$categoryPath = $this->categoryModel->getThreadedPath($categoryId);
				$childrenIds = $this->categoryModel->getThreadedChildrenIds($categoryId);
				$subCategories = $this->categoryModel->find('threaded', array('conditions' => array('parent_id' => $categoryId, 'model' => $event->subject->model->alias), 'order' => 'name_'.TXT_LANG));
				
				if (isset($event->subject->model->hasAndBelongsToMany[$this->categoryModel->alias])) {
					// HABTM
					$event->subject->model->bindModel(array('hasOne' => array('Categorized' => array('foreignKey' => 'foreign_key'))), false);
					$event->subject->controller->paginate['contain'][] = 'Categorized';
					
					$event->subject->controller->paginate['conditions']['Categorized.category_id'] = array_merge($childrenIds, array($categoryId));
					$event->subject->controller->paginate['conditions']['Categorized.model'] = $event->subject->model->alias;
					
				} elseif (isset($event->subject->model->belongsTo[$this->categoryModel->alias])) {
					// belongsTo
					$event->subject->controller->paginate['conditions']['category_id'] = array_merge($childrenIds, array($categoryId));
				}
				
				$event->subject->controller->set(compact('category', 'categoryId', 'categoryPath', 'subCategories'));
			}
			
			$categories = $this->categoryModel->find('threaded', array('conditions' => array('model' => $event->subject->model->alias), 'order' => 'name_'.TXT_LANG));
			
			$event->subject->controller->set(compact('categories'));
		}
		
		if (isset($event->subject->model->Country)) {
			$event->subject->controller->paginate['contain'][] = 'Country';
			
			$countryModel =& $event->subject->model->Country;
			
			if (isset($event->subject->request->params['country']) && !empty($event->subject->request->params['country'])) {
				$countryCode = $event->subject->request->params['country'];
				if (strlen($countryCode) > 2) {
					$countryCode = substr($countryCode, 0, 2);	
				}
				
				$country = $countryModel->findByCode($countryCode);
				if ($event->subject->request->action == 'index') {
					$expectedSlug = $countryCode.'-'.slug($country[$countryModel->alias]['name_'.TXT_LANG]);
					if ($expectedSlug != $event->subject->request->params['country']) {
						// old country slug redirect
						if (isset($event->subject->request->params['cat_slug'])) {
							$event->subject->controller->redirect(array('cat_slug' => $event->subject->request->params['cat_slug'], 'country' => $expectedSlug));
						} else {
							$event->subject->controller->redirect(array('cat_slug' => 0, 'country' => $expectedSlug));
						}
					}
				}
				
				$event->subject->controller->set(compact('country'));
				$event->subject->controller->paginate['conditions']['country'] = $countryCode;
			}
			
			if (isset($event->subject->request->params['cat_slug']) && !isset($event->subject->request->params['country'])) {
				$cacheFile = $event->subject->modelClass.'_index_countries_filters_'.md5($event->subject->request->here);
				if (($countriesFilters = Cache::read($cacheFile)) === false) {
					$results = $event->subject->model->find('all', array('conditions' => $event->subject->controller->paginate['conditions'], 'contain' => $event->subject->controller->paginate['contain']));
					
					$countriesFilters = array();
					foreach ($results as $r) {
						$countriesFilters[$r['Country']['code']]['name_'.TXT_LANG] = $r['Country']['name_'.TXT_LANG];
						$countriesFilters[$r['Country']['code']]['count'] = isset($countriesFilters[$r['Country']['code']]['count']) ? $countriesFilters[$r['Country']['code']]['count'] + 1 : 1;
					}
					Cache::write($cacheFile, $countriesFilters);
				}
					
				$event->subject->controller->set(compact('countriesFilters'));
			}
		}
    }
}