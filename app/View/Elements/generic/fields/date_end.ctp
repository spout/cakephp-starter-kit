<?php 
if (isset($item[$modelClass]['date_end']) && !empty($item[$modelClass]['date_end'])) {
	echo $this->MyHtml->niceDate($item[$modelClass]['date_end'], '%A, %e %B %Y');
}
?>