<?php 
$this->set('title_for_layout', __('Connexion'));
echo $this->Form->create();
?>
<fieldset>
<legend><?php echo __('Connexion');?></legend>
<?php
echo $this->Form->input('email', array('label' => __('E-mail')));
echo $this->Form->input('password', array('label' => __('Mot de passe')));
?>
<p>
	<?php echo $this->Html->link(__('Mot de passe oublié ?'), array('action' => 'lost_password'));?>
</p>
<?php echo $this->Form->input('remember_me', array('label' => __('Connexion automatique'), 'type' => 'checkbox'));?>
</fieldset>
<?php echo $this->Form->end(__('Connexion'));?>