<?php 
$path = $photosBasePath.$item[$modelClass]['dir'].'/';
$files = array_values(array_diff(scandir(WWW_ROOT.$path), array('.', '..')));

if (isset($num)) {
	$files = array_slice($files, 0, $num);	
}

foreach ($files as $k => $f) {

	echo '<div class="">';
	$element = $this->element('phpthumb', array('src' => $path.$f, 'h' => 150, 'w' => 150));
	if ($this->request->params['action'] === 'view') {
		echo $this->Html->link($element, '/'.$path.$f, array('escape' => false, 'class' => 'fancybox', 'rel' => 'fancybox'));
	}
	else {
		echo $this->Html->link($element, array('action' => 'view', 'id' => $item[$modelClass]['id'], 'slug' => slug(getPreferedLang($item[$modelClass]))), array('escape' => false));
	}
	
	echo '</div>';
}
?>