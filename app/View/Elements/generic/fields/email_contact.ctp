<?php 
if (isset($item[$modelClass]['email_contact']) && !empty($item[$modelClass]['email_contact'])) {
	echo $this->MyHtml->encodeEmail($item[$modelClass]['email_contact']);
	echo '<p>'.$this->Html->link(__('Envoyer un message'), array('action' => 'message', $item[$modelClass]['id']), array('rel' => 'nofollow', 'class' => 'fancybox')).'</p>';
}
?>