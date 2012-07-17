<?php
if (isset($item[$modelClass]['video']) && !empty($item[$modelClass]['video'])) {
	echo $this->AutoEmbed->getCode($item[$modelClass]['video'], array('width' => 400, 'height' => 300));
}
?>