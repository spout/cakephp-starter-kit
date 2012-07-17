<?php 
if (!empty($item[$modelClass]['fax'])) {
	echo $this->element('generic/phone', array('number' => $item[$modelClass]['fax']));
}
?>