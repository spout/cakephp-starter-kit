<?php 
if (isset($item[$modelClass]['download_url']) && !empty($item[$modelClass]['download_url'])) {
	echo '<a href="'.h($item[$modelClass]['download_url']).'">'.h($item[$modelClass]['download_url']).'</a>';
}
?>