<?php if(isset($sidebarCategories) && !empty($sidebarCategories)):?>
	<?php //echo $this->Tree->generate($sidebarCategories, array('element' => 'Games/tree-item', 'model' => 'Category', 'class' => 'nav nav-list'));?>
	<li class="nav-header"><i class="icon-folder-close"></i> <?php echo __('Catégories');?></li>
	<?php foreach($sidebarCategories as $k => $v):?>
		<?php
		$linkAttribs = array('escape' => false);
		if (isset($v['Category']['description_'.TXT_LANG]) && !empty($v['Category']['description_'.TXT_LANG])) {
			$linkAttribs['title'] = $v['Category']['description_'.TXT_LANG];
		}

		$counter = '<span class="badge">'.$v['Category']['item_count'].'</span>';

		$linkUrl = array('controller' => 'games', 'action' => 'index', $v['Category']['slug_'.TXT_LANG], 'admin' => false);
		if (isset($this->request->params['named']['platform']) && !empty($this->request->params['named']['platform'])) {
			$linkUrl['platform'] = $this->request->params['named']['platform'];
		}
		$class = (isset($category) && $category['Category']['id'] == $v['Category']['id']) ? ' class="active"': '';
		?>
		<li<?php echo $class;?>><?php echo $this->Html->link($v['Category']['name_'.TXT_LANG].' '.$counter, $linkUrl, $linkAttribs);?></li>
	<?php endforeach;?>	
	<li class="divider"></li>
<?php endif;?>