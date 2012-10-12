<?php
class I18nRoute extends CakeRoute {

	public function match($url) {
		if (empty($url['lang'])) {
			$url['lang'] = Configure::read('Config.language');
		}
		return parent::match($url);
	}
	
	public function parse($url) {
		$params = parent::parse($url);
		
		if ($params !== false && array_key_exists('lang', $params)) {
			Configure::write('Config.language', $params['lang']);
			if (!defined('TXT_LANG')) {
				define('TXT_LANG', $params['lang']);
			}
		}
		
		return $params;
	}
}