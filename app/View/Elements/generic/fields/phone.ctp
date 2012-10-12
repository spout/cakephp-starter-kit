<?php 
$phones = array();
if (!empty($item[$modelClass]['phone'])) {
	$phones[] = $this->element('generic/phone', array('number' => $item[$modelClass]['phone']));
}
if (!empty($item[$modelClass]['phone_2'])) {
	$phones[] = $this->element('generic/phone', array('number' => $item[$modelClass]['phone_2']));
}
echo join('<br />', $phones);
?>