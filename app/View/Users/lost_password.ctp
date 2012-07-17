<?php $this->set('title_for_layout', __('Mot de passe oublié'));?>
<?php echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Mot de passe oublié');?></legend>
<?php echo $this->Form->input('email', array('label' => __('E-mail'), 'size' => 25));?>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha', $loginInfo = false);?>
<?php echo $this->Form->end(__('Récupérer un nouveau mot de passe'));?>
