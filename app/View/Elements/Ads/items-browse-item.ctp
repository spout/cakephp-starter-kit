<?php 
$title = getPreferedLang($item[$modelClass], $displayField);
$description = getPreferedLang($item[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">

	<p class="<?php echo $this->request->params['controller'];?>-browse-item-thumb">
		<?php 
		if (!empty($item[$modelClass]['photo_1'])) {
			$thumb = $this->element('phpthumb', array('src' => 'files/annonces/photo_1/'.$item[$modelClass]['id'].'/'.$item[$modelClass]['photo_1'], 'w' => 120, 'h' => 90, 'zc' => 1));
		}
		else {
			$thumb = $this->element('phpthumb', array('src' => 'img/equidir/thumb-default.png', 'w' => 120, 'h' => 90, 'zc' => 0, 'f' => 'png'));
		}
		
		echo $this->Html->link($thumb, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($title)), array('escape' => false));
		?>
	</p>
	
	<div>
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-title">
			<?php echo $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($title)));?>
		</p>
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-location">
			<?php echo $this->Html->image('flags/'.$item['Country']['code'].'.gif', array('alt' => $item['Country']['name_'.TXT_LANG], 'title' => $item['Country']['name_'.TXT_LANG]));?> <?php if(!empty($item[$modelClass]['city'])):?><?php echo h($item[$modelClass]['city']);?><?php else:?>&nbsp;<?php endif;?>
		</p>
		
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-description">
			<?php if(!empty($description)):?>
				<?php echo h($this->Text->truncate($description, 200, array('ending' => '...')));?>
			<?php else:?>
				&nbsp;
			<?php endif;?>
		</p>
		
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-details">
			<?php echo __('Type');?> : <?php if(isset($adsTypes[$item[$modelClass]['type']])):?><?php echo h($adsTypes[$item[$modelClass]['type']]);?><?php endif;?> - <?php echo __('Prix');?> : <?php echo $this->element('Ads/fields/price', array('item' => $item));?>
		</p>
	</div>
	
	<div class="clear"></div>
</div>