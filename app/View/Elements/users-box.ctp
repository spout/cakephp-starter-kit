<ul id="users-box">
<?php if($this->Auth->sessionValid()):?>
	<li><?php if($this->Auth->isAdmin()):?><?php echo $this->Html->image('icons/silk/user_godAdmin.png');?><?php else:?><?php echo $this->Html->image('icons/silk/user.png');?><?php endif;?>&nbsp;<?php echo $this->Html->link($this->Auth->user('email'), array('controller' => 'users', 'action' => 'index'));?></li>
	<li><?php echo $this->Html->image('icons/silk/disconnect.png');?>&nbsp;<?php echo $this->Html->link(__('Déconnexion'), array('controller' => 'users', 'action' => 'logout'));?></li>
<?php else:?>
	<li><?php echo $this->Html->link(__('Inscription'), array('controller' => 'users', 'action' => 'register'));?></li>
	<li><?php echo $this->Html->link(__('Connexion'), array('controller' => 'users', 'action' => 'login'));?></li>
<?php endif;?>
</ul>