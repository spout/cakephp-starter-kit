<?php 
if (isset($item[$modelClass]['license']) && !empty($item[$modelClass]['license'])) {
	echo h($item[$modelClass]['license']);
}
?>