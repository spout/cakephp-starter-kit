<?php
$description = getPreferedLang($item[$modelClass], 'description');
if (!empty($description)) {
	//echo nl2br(h($description));
	echo nl2br($this->Text->autoLink($description, array('onclick' => 'window.open(this.href);return false;', 'rel' => 'nofollow')));
}
?>