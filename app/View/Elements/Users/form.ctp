<?php $this->set('title_for_layout', ($this->request->params['action'] == 'register') ? __('Créer un compte membre') : __('Modifier mon compte'));?>
<?php echo $this->Form->create();?>
<fieldset>
	<legend><?php echo __('Informations de connexion');?></legend>
	<?php 
	$emailInputOptions = array('label' => __('E-mail'));
	if ($this->request->params['action'] == 'edit') {
		$emailInputOptions['readonly'] = 'readonly';
	}
	?>
	<?php echo $this->Form->input('email', $emailInputOptions);?>
	<?php echo $this->Form->input('password', array('label' => __('Mot de passe'), 'size' => 15, 'type' => 'password'));?>
	<?php echo $this->Form->input('password_verify', array('label' => __('Mot de passe (vérification)'), 'size' => 15, 'type' => 'password'));?>
</fieldset>
<fieldset>
	<legend><?php echo __('Informations personnelles');?></legend>
	<?php echo $this->Form->input('firstname', array('label' => __('Prénom'), 'size' => 20));?>
	<?php echo $this->Form->input('lastname', array('label' => __('Nom'), 'size' => 20));?>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha', $loginInfo = false);?>
<?php echo $this->Form->end(($this->request->params['action'] == 'register') ? __('Créer un compte') : __('Modifier'));?>