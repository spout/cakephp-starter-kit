<?php 
if (isset(${$singularVar}[$modelClass]['email_contact']) && !empty(${$singularVar}[$modelClass]['email_contact'])) {
	
	$email = ${$singularVar}[$modelClass]['email_contact'];
	$mailto = 'mailto:';
	foreach (str_split($email) as $letter) {
		$mailto .= '&#'.ord($letter).';';
	}
	
	echo '<a href="'.$mailto.'">'.__('E-mail').'</a>';
	echo '<p>'.$this->Html->link(__('Envoyer un message'), array('action' => 'message', ${$singularVar}[$modelClass]['id']), array('rel' => 'nofollow', 'class' => 'fancybox')).'</p>';
}
?>