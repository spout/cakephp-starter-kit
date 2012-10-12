<?php
if ($this->request->action == 'edit' && !empty($this->request->data['User'])) {
	$emailValue = $this->request->data['User']['email'];
	$firstnameValue = $this->request->data['User']['firstname'];
	$lastnameValue = $this->request->data['User']['lastname'];
} elseif (Auth::user('email')) {
	$emailValue = Auth::user('email');
	$firstnameValue = Auth::user('firstname');
	$lastnameValue = Auth::user('lastname');
} else {
	$emailValue = $firstnameValue = $lastnameValue = null;
}
?>

<?php if(Auth::id()):?>
	<?php echo $this->Form->hidden('email', array('value' => $emailValue)); ?>
	<?php echo $this->Form->hidden('firstname', array('value' => $firstnameValue)); ?>
	<?php echo $this->Form->hidden('lastname', array('value' => $lastnameValue)); ?>
<?php else:?>
	<fieldset>
	<legend><?php echo __('Qui êtes vous ?');?></legend>
	<div class="form-inputs-info">
		<?php echo sprintf(__('Si vous n\'avez jamais ajouté un enregistrement sur notre site, un compte utilisateur sera créé automatiquement dès l\'ajout de votre premier enregistrement. Vous recevrez par e-mail les informations de connexion. Le compte utilisateur vous servira à gérer les enregistrements que vous avez proposés. Si vous vous %s, vous ne devrez plus indiquer ces informations.<br /><strong>Ces informations ne seront pas affichées.</strong>'), $this->Html->link(__('connectez'), array('controller' => 'users', 'action' => 'login')));?>
	</div>
	<?php echo $this->Form->input('email', array('label' => __('E-mail'), 'size' => 45, 'default' => $emailValue));?>
	<?php echo $this->Form->input('firstname', array('label' => __('Prénom'), 'size' => 45, 'default' => $firstnameValue));?>
	<?php echo $this->Form->input('lastname', array('label' => __('Nom'), 'size' => 45, 'default' => $lastnameValue));?>
	</fieldset>
<?php endif;?>