<?php if(isset($platforms) && !empty($platforms)):?>
	<li class="nav-header"><i class="icon-cog"></i> <?php echo __('Plateformes');?></li>
	<?php if(isset($this->request->params['named']['platform'])):?>
		<?php 
		$linkUrl = array('controller' => 'games', 'action' => 'index', 'admin' => false);
		if (isset($category)) {
			$linkUrl[] = $category['Category']['slug_'.TXT_LANG];
		}
		?>
		<li><?php echo $this->Html->link(__('Toutes'), $linkUrl);?></li>
	<?php endif;?>
	
	<?php foreach($platforms as $k => $v):?>
		<?php 
		$linkUrl = array('controller' => 'games', 'action' => 'index', 'platform' => $k, 'admin' => false);
		if (isset($category)) {
			$linkUrl[] = $category['Category']['slug_'.TXT_LANG];
		}
		$class = (isset($this->request->params['named']['platform']) && $this->request->params['named']['platform'] == $k && $this->request->params['controller'] == 'games' && $this->request->params['action'] == 'index') ? ' class="active"' : '';
		?>
		<li<?php echo $class;?>><?php echo $this->Html->link($this->Html->image('gamesdir/os/'.$k.'.png').'&nbsp;'.$v, $linkUrl, array('escape' => false));?></li>
	<?php endforeach;?>
	<li class="divider"></li>
<?php endif;?>