<?php $this->set('title_for_layout', __('Panneau de contrôle'));?>
<h2><?php echo __('Mon compte membre');?></h2>
<ul>
	<li><?php echo $this->Html->link(__('Modifier mon compte'), array('action' => 'edit'));?></li>
	<li><?php echo $this->Html->link(__('Modifier le mot de passe'), array('action' => 'change_password'));?></li>
</ul>

<?php 
if (is_readable(APP.'View'.DS.'Elements'.DS.'Users'.DS.'control-panel.ctp')) {
	echo $this->element('Users'.DS.'control-panel');
}
?>