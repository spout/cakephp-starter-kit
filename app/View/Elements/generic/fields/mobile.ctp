<?php 
$phones = array();
if (!empty($item[$modelClass]['mobile'])) {
	$phones[] = $this->element('generic/phone', array('number' => $item[$modelClass]['mobile']));
}
if (!empty($item[$modelClass]['mobile_2'])) {
	$phones[] = $this->element('generic/phone', array('number' => $item[$modelClass]['mobile_2']));
}
echo join('<br />', $phones);
?>