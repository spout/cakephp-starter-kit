<?php 
if (isset($item[$modelClass]['videos']) && !empty($item[$modelClass]['videos'])) {
	$videos = explode("\n", $item[$modelClass]['videos']);
	
	if (!empty($videos)) {
		echo '<ul class="thumbnails">';
		foreach ($videos as $url) {
			echo '<li>';
			echo '<div class="thumbnail">';
			echo $this->AutoEmbed->getCode($url, array('width' => 260, 'height' => 180));
			echo '</div>';
			echo '</li>';
		}
		echo '</ul>';
	}
}
?>