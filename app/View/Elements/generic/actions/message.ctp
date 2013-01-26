<?php 
$this->set('title_for_layout', __('Envoyer un message'));
$title = getPreferedLang($item[$modelClass], 'title');
?>
<?php echo $this->Form->create($modelClass, array('url' => array('action' => 'message', $item[$modelClass]['id'])));?>
<fieldset>
<legend><?php echo __('Envoyer un message');?></legend>
<?php echo $this->Form->input('email', array('label' => __('Votre e-mail'), 'size' => 30, 'default' => Auth::user('email')));?>
<?php echo $this->Form->input('firstname', array('label' => __('Prénom'), 'size' => 30, 'default' => Auth::user('firstname')));?>
<?php echo $this->Form->input('lastname', array('label' => __('Nom'), 'size' => 30, 'default' => Auth::user('lastname')));?>
<?php echo $this->Form->input('subject', array('label' => __('Sujet'), 'size' => 50, 'default' => $title));?>
<?php echo $this->Form->input('message', array('label' => __('Message'), 'rows' => 6, 'cols' => 80));?>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha', false);?>
<?php echo $this->Form->end(__('Envoyer'));?>