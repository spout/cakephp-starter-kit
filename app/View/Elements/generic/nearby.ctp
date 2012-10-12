<?php if(isset($nearbyResults) & !empty($nearbyResults)):?>
<h2><?php echo __('A proximité');?></h2>
<ul>
<?php foreach($nearbyResults as ${$singularVar}):?>
<?php 
$title = getPreferedLang(${$singularVar}[$modelClass], $displayField);
?>
<li><?php if(isset(${$singularVar}[$modelClass]['country']) && !empty(${$singularVar}[$modelClass]['country'])):?><?php echo $this->Html->image('flags/'.${$singularVar}[$modelClass]['country'].'.gif');?>&nbsp;<?php endif;?><?php echo $this->Html->link($title, array('action' => 'view', 'id' => ${$singularVar}[$modelClass]['id'], 'slug' => slug($title)));?><?php if(isset(${$singularVar}[$modelClass]['city']) && !empty(${$singularVar}[$modelClass]['city'])):?> - <?php echo h(${$singularVar}[$modelClass]['city']);?><?php endif;?> - <em><?php echo round(${$singularVar}[0]['distance'], 1);?> km<?php if(${$singularVar}[0]['distance'] >= 2):?>s<?php endif;?></em></li>
<?php endforeach;?>
</ul>
<?php endif;?>