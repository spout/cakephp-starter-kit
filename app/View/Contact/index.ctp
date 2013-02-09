<?php $this->set('title_for_layout', __('Contactez-nous'));?>
<?php echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Contactez-nous');?></legend>
<?php echo $this->Form->input('email', array('label' => __('Votre e-mail'), 'size' => 45, 'default' => Auth::user('email')));?>
<?php echo $this->Form->input('subject', array('label' => __('Sujet'), 'size' => 45, 'default' => $this->request->query('subject')));?>
<?php echo $this->Form->input('message', array('label' => __('Message'), 'rows' => 10, 'cols' => 50));?>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha');?>
<?php echo $this->Form->end(__('Envoyer'));?>