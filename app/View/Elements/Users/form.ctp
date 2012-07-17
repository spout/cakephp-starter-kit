<?php $this->set('title_for_layout', ($this->request->params['action'] == 'register') ? __('Créer un compte membre') : __('Modifier mon compte'));?>

<?php echo $this->Form->create('User', array('type' => 'post'));?>
<?php if($this->request->params['action'] == 'edit'):?>
	<?php echo $this->Form->hidden('id'); ?>
<?php endif;?>

<fieldset>
	<legend><?php echo __('Informations de connexion');?></legend>
	<?php if($this->request->params['action'] == 'edit'):?>
		<?php echo $this->Form->hidden('email', array('value' => $this->request->data['User']['email']));?>
		<dl>
			<dt><?php echo __('E-mail');?></dt>
			<dd><?php echo $this->request->data['User']['email'];?></dd>
			<dt><?php echo __('Mot de passe');?></dt>
			<dd>******** <?php echo $this->Html->link(__('Modifier le mot de passe'), array('action' => 'change_password'));?></dd>
		</dl>
	<?php else:?>
		<?php echo $this->Form->input('email', array('label' => __('E-mail'), 'size' => 25));?>
		<?php echo $this->Form->input('password', array('label' => __('Mot de passe'), 'size' => 15, 'type' => 'password'));?>
		<?php echo $this->Form->input('password_verify', array('label' => __('Mot de passe (vérification)'), 'size' => 15, 'type' => 'password'));?>
	<?php endif;?>
</fieldset>
<fieldset>
	<legend><?php echo __('Informations personnelles');?></legend>
	<?php echo $this->Form->input('firstname', array('label' => __('Prénom'), 'size' => 20));?>
	<?php echo $this->Form->input('lastname', array('label' => __('Nom'), 'size' => 20));?>
</fieldset>

<?php echo $this->MyHtml->captcha('captcha', $loginInfo = false);?>

<?php echo $this->Form->end(($this->request->params['action'] == 'register') ? __('Créer un compte') : __('Modifier'));?>