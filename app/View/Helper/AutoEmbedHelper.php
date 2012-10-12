<?php
class AutoEmbedHelper extends AppHelper {
	function getCode($url, $attribs = array()) {
		App::import('Vendor', 'AutoEmbed', array('file' => 'AutoEmbed'.DS.'AutoEmbed.class.php'));
		$AutoEmbed = new AutoEmbed();
		$AutoEmbed->parseUrl($url);
		
		if (!empty($attribs)) {
			foreach ($attribs as $k => $v) {
				$AutoEmbed->setObjectAttrib($k, $v);
			}
		}
		
		$AutoEmbed->setParam('WMode', 'transparent');// Add transparent for lightboxes overlays
		
		return $AutoEmbed->getEmbedCode();
	}
}