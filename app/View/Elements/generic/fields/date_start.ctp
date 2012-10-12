<?php 
if (isset($item[$modelClass]['date_start']) && !empty($item[$modelClass]['date_start'])) {
	echo $this->MyHtml->niceDate($item[$modelClass]['date_start'], '%A, %e %B %Y');
}
?>