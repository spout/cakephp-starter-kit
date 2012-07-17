<?php $this->set('title_for_layout', $name);?>
<p class="error">
	<strong><?php echo __('Erreur'); ?>: </strong>
	<?php printf(
		__('La page demandée %s n\'a pas été trouvée sur ce serveur.'),
		"<strong>'{$url}'</strong>"
	); ?>
</p>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
