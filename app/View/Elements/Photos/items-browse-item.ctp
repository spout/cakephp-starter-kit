<?php 
$title = getPreferedLang(${$singularVar}[$modelClass], $displayField);
//$description = getPreferedLang(${$singularVar}[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">

	<p class="<?php echo $this->request->params['controller'];?>-browse-item-title">
		<?php echo $this->Html->link($title, array('action' => 'view', 'id' => ${$singularVar}[$modelClass][$primaryKey], 'slug' => slug($title)));?>
	</p>
	
	<?php echo $this->element('photos/gallery', array($singularVar => ${$singularVar}, 'num' => 1));?>
	
	<?php if(!empty(${$singularVar}[$modelClass]['date'])):?>
		<p><?php echo $this->MyHtml->niceDate(${$singularVar}[$modelClass]['date'], '%e %B %Y');?></p>
	<?php endif;?>
	
	
	<?php /*if(!empty($description)):?>
		<p><?php echo h($this->Text->truncate($description, 200, array('ending' => '...')));?></p>
	<?php endif;*/?>
	
	<div class="clear"></div>
</div>