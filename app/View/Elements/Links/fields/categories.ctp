<?php 
if (isset($item[$categoryModelClass]) && !empty($item[$categoryModelClass])) {
	$links = array();
	foreach ($item[$categoryModelClass] as $c) {
		$links[] = $this->Html->link($c['name_'.TXT_LANG], array('action' => 'index', 'cat_slug' => $c['slug_'.TXT_LANG]));
	}
	echo implode(' - ', $links);
}