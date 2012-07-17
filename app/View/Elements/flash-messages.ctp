<?php echo $this->Session->flash();?>
<?php if($this->Session->check('Message.auth')):?>
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert">&times;</button>
		<?php echo $this->Session->flash('auth');?>
	</div>
<?php endif;?>