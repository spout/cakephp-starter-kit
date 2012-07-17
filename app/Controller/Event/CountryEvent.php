<?php
App::uses('CrudBaseEvent', 'Crud.Controller/Event');

class CountryEvent extends CrudBaseEvent {

    /*public function init(CakeEvent $event) {
		if (isset($event->subject->model->Country)) {
			if (isset($event->subject->request->params['country']) && !empty($event->subject->request->params['country'])) {
				$countryModel =& $event->subject->model->Country;
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
		}
		
		if ((!isset($event->subject->model->{$event->subject->modelClass.'Cat'}) || isset($event->subject->request->params['cat_slug'])) && isset($event->subject->model->Country) && !isset($event->subject->request->params['country'])) {
			$cacheFile = $event->subject->modelClass.'_index_countries_filters_'.md5($event->subject->request->here);
			if (($countriesFilters = Cache::read($cacheFile)) === false) {
				$results = $event->subject->model->find('all', array('conditions' => isset($event->subject->controller->paginate['conditions']) ? $event->subject->controller->paginate['conditions'] : null));
				$countriesFilters = array();
				foreach ($results as $r) {
					$countriesFilters[$r['Country']['code']]['name_'.TXT_LANG] = $r['Country']['name_'.TXT_LANG];
					$countriesFilters[$r['Country']['code']]['count'] = isset($countriesFilters[$r['Country']['code']]['count']) ? $countriesFilters[$r['Country']['code']]['count'] + 1 : 1;
				}
				Cache::write($cacheFile, $countriesFilters);
			}
			
			$event->subject->controller->set(compact('countriesFilters'));
		}
    }*/
	
	public function beforeFind(CakeEvent $event) {
		$event->subject->model->contain('Country');
	}
	
	public function beforePaginate(CakeEvent $event) {
		if (isset($event->subject->model->Country)) {
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
				// if (($countriesFilters = Cache::read($cacheFile)) === false) {
					// $results = $event->subject->model->find('all', array('conditions' => isset($event->subject->controller->paginate['conditions']) ? $event->subject->controller->paginate['conditions'] : null));
					// $results = $event->subject->model->find('all', array('conditions' => $event->subject->controller->paginate['conditions'], 'contain' => 'Country'));
					
					// $countriesFilters = array();
					// foreach ($results as $r) {
						// $countriesFilters[$r['Country']['code']]['name_'.TXT_LANG] = $r['Country']['name_'.TXT_LANG];
						// $countriesFilters[$r['Country']['code']]['count'] = isset($countriesFilters[$r['Country']['code']]['count']) ? $countriesFilters[$r['Country']['code']]['count'] + 1 : 1;
					// }
					// Cache::write($cacheFile, $countriesFilters);
				// }
				
				// $event->subject->controller->set(compact('countriesFilters'));
			}
			
			$event->subject->model->contain('Country');
		}
    }
}