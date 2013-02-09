<?php echo $this->Form->create();?>
<?php echo $this->Form->input('email', array('label' => __('E-mail')));?>
<?php echo $this->MyHtml->captcha();?>
<?php echo $this->Form->end(__('Inscription'));?>