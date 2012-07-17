<?php 
$labels = array();
if (isset($item[$modelClass]['esrb']) && !empty($item[$modelClass]['esrb'])) {
	$labels[] = '<span class="label label-inverse">'.__('ESRB').': '.h($esrbRatings[$item[$modelClass]['esrb']]).'</span>';
}

if (isset($item[$modelClass]['pegi']) && !empty($item[$modelClass]['pegi'])) {
	$labels[] = '<span class="label label-inverse">'.__('PEGI').': '.h($pegiRatings[$item[$modelClass]['pegi']]).'</span>';
}

if (!empty($labels)) {
	echo implode(' ', $labels);
}
?>