<?php 
$this->element('fancybox');

$title = getPreferedLang(${$singularVar}[$modelClass], 'title');
$description = getPreferedLang(${$singularVar}[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?><?php if(!empty(${$singularVar}[$modelClass]['date'])):?> - <?php echo $this->MyHtml->niceDate(${$singularVar}[$modelClass]['date'], '%e %B %Y');?><?php endif;?></h2>
	
	<?php if(!empty(${$singularVar}[$modelClass]['author'])):?>
		<p class="<?php echo $pluralVar;?>-view-author">
			<?php echo h(sprintf(__('Photos par %s'), ${$singularVar}[$modelClass]['author']));?>
		</p>
	<?php endif;?>
	
	<div class="<?php echo $pluralVar;?>-view-gallery">
		<?php 
		echo $this->element('photos/gallery');
		?>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->element('generic'.DS.'comments');?>
</div>