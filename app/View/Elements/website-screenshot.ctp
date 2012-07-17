<?php 
if (isset($url)) {
	
	if (!isset($alt)) {
		$alt = '';
	}
	
	if (!isset($provider)) {
		$provider = 'shrinktheweb';
	}
	
	switch($provider) {
		case 'thumbalizr':
			//http://api1.thumbalizr.com/
			$apiKey = '5076283f34d9704a07da19a82a76b313';
			
			if (!isset($width)) {
				$width = '120';//1-1280
			}
			
			$thumbUrl = 'http://api.thumbalizr.com/?api_key=%s&url=%s&width=%d';
			$thumbUrl = h(sprintf($thumbUrl, $apiKey, $url, $width));
			
			echo '<img src="'.$thumbUrl.'" alt="'.$alt.'" />';
			
			break;
		
		default:	
		case 'pagepeeker':
			//http://pagepeeker.com/free_thumbnails
			
			if (!isset($size)) {
				$size = 's';//t - Tiny (90x68px), s - Small (120x90px), m - Medium (200x150px), l - Large (400x300px), x - eXtra large (480x380px)
			}
			
			$thumbUrl = 'http://pagepeeker.com/t/%s/%s';
			$thumbUrl = h(sprintf($thumbUrl, $size, $url));
			
			echo '<img src="'.$thumbUrl.'" alt="'.$alt.'" />';
			
			break;
			
		case 'shrinktheweb':
			$accessKeyId = '4c9ee42ceee182a';
			
			if (!isset($size)) {
				$size = 'sm';//mcr 75x56, tny 90x75, vsm 100x75, sm 120x90, lg 200x150, xlg 320x240,
			}
	
			$thumbUrl = 'http://images.shrinktheweb.com/xino.php?stwembed=1&stwaccesskeyid='.$accessKeyId.'&stwsize='.$size.'&stwurl='.$url;
			$thumbUrl = h($thumbUrl);
			echo '<img src="'.$thumbUrl.'" alt="'.$alt.'" />';
			
			//$this->Html->script('http://www.shrinktheweb.com/scripts/pagepix.js', array('inline' => false));
			//echo $this->Html->scriptBlock("stw_pagepix('$url', '$accessKeyId', '$size', 0);");
			
			break;

	}
}
?>