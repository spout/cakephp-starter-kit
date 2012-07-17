<?php $this->set('title_for_layout', __('Modifier le mot de passe'));?>
<?php echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Modifier le mot de passe');?></legend>
<?php echo $this->Form->input('password', array('label' => __('Nouveau mot de passe'), 'size' => 15));?>
<?php echo $this->Form->input('password_verify', array('label' => __('Nouveau mot de passe (vérification)'), 'size' => 15, 'type' => 'password'));?>
</fieldset>
<?php echo $this->Form->end(__('Modifier'));?>
