<?php
App::uses('Helper', 'View');
class AppHelper extends Helper {
	
	public function url($url = null, $full = true) {
		if (is_array($url)) {
			if (!isset($url['lang']) && isset($this->request->params['lang'])) {
				$url['lang'] = $this->request->params['lang'];
			}
			
			if (!isset($url['admin'])) {
				$url['admin'] = false;
			}
		}
		
		return parent::url($url, $full);
	}
}