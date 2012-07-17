<?php 
if (isset($item[$modelClass]['developers']) && !empty($item[$modelClass]['developers'])) {
	if (isset($item[$modelClass]['developers_url']) && !empty($item[$modelClass]['developers_url'])) {
		echo '<a href="'.h($item[$modelClass]['developers_url']).'">';
	}
	
	echo h($item[$modelClass]['developers']);
	
	if (isset($item[$modelClass]['developers_url']) && !empty($item[$modelClass]['developers_url'])) {
		echo '</a>';
	}
}
?>