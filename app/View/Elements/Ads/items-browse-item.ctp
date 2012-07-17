<?php 
$title = getPreferedLang(${$singularVar}[$modelClass], $displayField);
$description = getPreferedLang(${$singularVar}[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">

	<p class="<?php echo $this->request->params['controller'];?>-browse-item-thumb">
		<?php 
		if (!empty(${$singularVar}[$modelClass]['photo_1'])) {
			$thumb = $this->element('phpthumb', array('src' => 'files/annonces/photo_1/'.${$singularVar}[$modelClass]['id'].'/'.${$singularVar}[$modelClass]['photo_1'], 'w' => 120, 'h' => 90, 'zc' => 1));
		}
		else {
			$thumb = $this->element('phpthumb', array('src' => 'img/equidir/thumb-default.png', 'w' => 120, 'h' => 90, 'zc' => 0, 'f' => 'png'));
		}
		
		echo $this->Html->link($thumb, array('action' => 'view', 'id' => ${$singularVar}[$modelClass][$primaryKey], 'slug' => slug($title)), array('escape' => false));
		?>
	</p>
	
	<div>
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-title">
			<?php echo $this->Html->link($title, array('action' => 'view', 'id' => ${$singularVar}[$modelClass][$primaryKey], 'slug' => slug($title)));?>
		</p>
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-location">
			<?php echo $this->Html->image('flags/'.${$singularVar}['Country']['code'].'.gif', array('alt' => ${$singularVar}['Country']['name_'.TXT_LANG], 'title' => ${$singularVar}['Country']['name_'.TXT_LANG]));?> <?php if(!empty(${$singularVar}[$modelClass]['city'])):?><?php echo h(${$singularVar}[$modelClass]['city']);?><?php else:?>&nbsp;<?php endif;?>
		</p>
		
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-description">
			<?php if(!empty($description)):?>
				<?php echo h($this->Text->truncate($description, 200, array('ending' => '...')));?>
			<?php else:?>
				&nbsp;
			<?php endif;?>
		</p>
		
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-details">
			<?php echo __('Type');?> : <?php echo h($adsTypes[${$singularVar}[$modelClass]['type']]);?> - <?php echo __('Prix');?> : <?php echo $this->element('ads/fields/price', array($singularVar => ${$singularVar}));?>
		</p>
	</div>
	
	<div class="clear"></div>
</div>