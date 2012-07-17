<?php echo $this->Form->create('Comment', array('url' => $this->Html->url(array('action' => 'comment', ${$singularVar}[$modelClass]['id']))));?>
<fieldset id="post-comment">
<legend><?php echo __('Poster un commentaire');?></legend>
<?php echo $this->Form->input('Comment.name', array('label' => __('Nom'), 'size' => 30));?>
<?php echo $this->Form->input('Comment.email', array('label' => __('E-mail'), 'size' => 30));?>
<?php //echo $this->Form->input('Comment.website', array('label' => __('Site Web'), 'size' => 25));?>
<?php echo $this->Form->input('Comment.comment', array('label' => __('Commentaire'), 'rows' => 6, 'cols' => 70));?>
<?php echo $this->MyHtml->captcha('Comment.captcha', $loginInfo = false);?>
<?php echo $this->Form->submit(__('Poster un commentaire'));?>
</fieldset>		
<?php echo $this->Form->end();?>