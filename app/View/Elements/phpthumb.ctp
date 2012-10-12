<?php
$w = isset($w) ? $w : 100;
$h = isset($h) ? $h : 100;
$q = isset($q) ? $q : 80;
$zc = isset($zc) ? $zc : 1;
$f = isset($f) ? $f : 'jpeg';//f = output image format ("jpeg", "png", or "gif")

$thumbnail = $this->Phpthumb->generate(array(
	'save_path' => WWW_ROOT.'thumbs',
	'display_path' => '/thumbs',
	'error_image_path' => '/img/phpthumb-error.jpg',
	'src' => WWW_ROOT.$src,
	'w' => $w, 
	'h' => $h,
	'q' => $q,
	'zc' => $zc,
	'f' => $f
));

if ($thumbnail['error'] == 0) {
	echo $this->Html->image($thumbnail['src'], array('width' => $thumbnail['w'], 'height' => $thumbnail['h']));
}
?>