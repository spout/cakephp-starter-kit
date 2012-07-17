<?php
//http://mark-story.com/posts/view/using-custom-route-classes-in-cakephp
App::uses('ClassRegistry', 'Utility');
class SlugRoute extends CakeRoute {
 
	function parse($url) {
		$params = parent::parse($url);
		if (empty($params)) {
			return false;
		}
		$slugs = Cache::read('content_slugs');
		if (empty($slugs)) {
			$Content = ClassRegistry::init('Content');
			$contents = $Content->find('all', array(
				'fields' => array('Content.slug'),
				'recursive' => -1
			));
			$slugs = array_flip(Set::extract('/Content/slug', $contents));
			Cache::write('content_slugs', $slugs);
		}
		if (isset($slugs[$params['slug']])) {
			return $params;
		}
		return false;
	}
 
}
?>