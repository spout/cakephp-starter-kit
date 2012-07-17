<?php 
/***
* Cakephp view helper to interface with http://code.google.com/p/minify/ project.
* Minify: Combines, minifies, and caches JavaScript and CSS files on demand to speed up page loads.
* @author: Ketan Shah - ketan.shah@gmail.com - http://www.innovatechnologies.in
* Requirements: An entry in core.php - "MinifyAsset" - value of which is either set 'true' or 'false'. False would be usually set during development and/or debugging. True should be set in production mode.
*/

class MinifyHelper extends AppHelper {

	var $helpers = array('Html'); //used for seamless degradation when MinifyAsset is set to false;
	
	function script($assets) {
		if (Configure::read('MinifyAsset')) {
			echo sprintf('<script type="text/javascript" src="%s"></script>', $this->_path($assets, 'js'));
		} else {
			echo $this->Html->script($assets);
		}
	}
	
	function css($assets) {
		if (Configure::read('MinifyAsset')) {
			echo sprintf('<link type="text/css" rel="stylesheet" href="%s" />', $this->_path($assets, 'css'));
		} else {
			echo $this->Html->css($assets);
		}
	}
	
	function _path($assets, $ext) {
		if (!is_array($assets)) {
			$assets = array($assets);
		}
		
		$path = $this->webroot . "min/f=";
		$sep = ',';
		foreach ($assets as $asset) {
			$path .= $this->webroot."app/webroot/".$ext."/"; 
			if ($ext == 'js' && strpos($asset, '.js') !== false) {
				$path .= ($asset.$sep);
			} else {
				$path .= ($asset.".$ext".$sep);
			}
			
		}
		return rtrim($path, $sep);
	}
}