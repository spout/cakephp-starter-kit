<?php
//http://mark-story.com/posts/view/using-custom-route-classes-in-cakephp
App::uses('I18nRoute', 'Routing/Route');
App::uses('ClassRegistry', 'Utility');
class I18nCatRoute extends I18nRoute {
 
	protected $_Cat = null;
	
	public function __construct($template, $defaults = array(), $options = array()) {
		parent::__construct($template, $defaults, $options);
		$this->_Cat = ClassRegistry::init('Cat');
	}
	
	public function match($url) {
		if (isset($url['cat_slug'])) {
			$catsSlugs = array_reverse(explode('/', $url['cat_slug']));
			$catPath = $this->_Cat->getThreadedPathBySlug($catsSlugs[0]);

			$catsSlugs = array();
			foreach ($catPath as $c) {
				$catsSlugs[] = $c['Cat']['slug_'.$url['lang']];
			}
			
			$url['cat_slug'] = implode('/', $catsSlugs);
		}
		
		return parent::match($url);
	}
	
	public function parse($url) {
		$params = parent::parse($url);
		
		if (empty($params)) {
			return false;
		}
		
		if (isset($params['cat_slug'])) {
			$catsSlugs = array_merge(array($params['cat_slug']), $params['pass']);
			$currentCatSlug = array_shift(array_reverse($catsSlugs));
			
			$catPath = $this->_Cat->getThreadedPathBySlug($currentCatSlug);
			
			$catsExpectedSlugs = array();
			foreach ($catPath as $c) {
				$catsExpectedSlugs[] = $c['Cat']['slug_'.$params['lang']];
			}
			
			if (empty($catsExpectedSlugs)) {
				return false;
			}
			
			$diff = array_diff($catsExpectedSlugs, $catsSlugs);
			
			if (empty($diff)) {
				$params['cat_slug'] = $currentCatSlug;
				return $params;
			}
		}
		
		return false;
	}
 
}