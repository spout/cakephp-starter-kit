<?php 
$screenshotsDir = 'uploads/images/games/'.$item[$modelClass]['slug'].'/screenshots/';

if (is_dir($screenshotsDir)) {
	$screenshots = glob(WWW_ROOT.$screenshotsDir.'*');
	
	if (!empty($screenshots)) {
		echo '<ul class="thumbnails">';
		foreach ($screenshots as $screenshot) {
			$basename = basename($screenshot);
			$thumb = $this->element('phpthumb', array('src' => $screenshotsDir.$basename, 'w' => 260, 'h' => 180));
			echo '<li class="span3">';
			echo $this->Html->link($thumb, '/'.$screenshotsDir.$basename, array('escape' => false, 'class' => 'thumbnail lightbox', 'rel' => 'prettyPhoto[screenshots]'));
			echo '</li>';
		}
		echo '</ul>';
	}
}
?>