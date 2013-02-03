<?php if(isset($nearbyItems) & !empty($nearbyItems)):?>
	<h2><?php echo __('A proximité');?></h2>
	<ul>
		<?php foreach($nearbyItems as $i):?>
			<?php 
			$title = getPreferedLang($i[$modelClass], $displayField);
			?>
			<li><?php if(isset($i[$modelClass]['country']) && !empty($i[$modelClass]['country'])):?><?php echo $this->Html->image('flags/'.$i[$modelClass]['country'].'.gif');?>&nbsp;<?php endif;?><?php echo $this->Html->link($title, array('action' => 'view', 'id' => $i[$modelClass]['id'], 'slug' => slug($title)));?><?php if(isset($i[$modelClass]['city']) && !empty($i[$modelClass]['city'])):?> - <?php echo h($i[$modelClass]['city']);?><?php endif;?> - <em><?php echo round($i[0]['distance'], 1);?> km<?php if($i[0]['distance'] >= 2):?>s<?php endif;?></em></li>
		<?php endforeach;?>
	</ul>
<?php endif;?>