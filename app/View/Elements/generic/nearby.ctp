<?php if(isset($nearbyResults) & !empty($nearbyResults)):?>
<h2><?php echo __('A proximité');?></h2>
<ul>
<?php foreach($nearbyResults as $item):?>
<?php 
$title = getPreferedLang($item[$modelClass], $displayField);
?>
<li><?php if(isset($item[$modelClass]['country']) && !empty($item[$modelClass]['country'])):?><?php echo $this->Html->image('flags/'.$item[$modelClass]['country'].'.gif');?>&nbsp;<?php endif;?><?php echo $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass]['id'], 'slug' => slug($title)));?><?php if(isset($item[$modelClass]['city']) && !empty($item[$modelClass]['city'])):?> - <?php echo h($item[$modelClass]['city']);?><?php endif;?> - <em><?php echo round($item[0]['distance'], 1);?> km<?php if($item[0]['distance'] >= 2):?>s<?php endif;?></em></li>
<?php endforeach;?>
</ul>
<?php endif;?>