<?php
App::uses('Helper', 'View');
class AppHelper extends Helper {
	
	public function url($url = null, $full = true) {
		if (is_array($url)) {
			if (!isset($url['lang']) && isset($this->request->params['lang'])) {
				$url['lang'] = $this->request->params['lang'];
			}
			
			// if (!isset($url['admin'])) {
				// $url['admin'] = false;
			// }
		}
		
		$routerUrl = Router::url($url, $full); 
        if (!preg_match('/\\.(rss|html|js|json|css|jpeg|jpg|gif|png|xml?)$/', strtolower($routerUrl)) && $routerUrl != '#' && substr($routerUrl, -1) != '/') { 
            $routerUrl .= '/'; 
        } 
        return $routerUrl; 
	}
	
}