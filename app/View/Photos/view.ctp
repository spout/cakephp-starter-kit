<?php 
$this->element('fancybox');

$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $this->request->controller;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?><?php if(!empty($item[$modelClass]['date'])):?> - <?php echo $this->MyHtml->niceDate($item[$modelClass]['date'], '%e %B %Y');?><?php endif;?></h2>
	
	<?php if(!empty($item[$modelClass]['author'])):?>
		<p class="<?php echo $this->request->controller;?>-view-author">
			<?php echo h(sprintf(__('Photos par %s'), $item[$modelClass]['author']));?>
		</p>
	<?php endif;?>
	
	<div class="<?php echo $this->request->controller;?>-view-gallery">
		<?php echo $this->element('Photos/gallery');?>
		<div class="clear"></div>
	</div>
	
	<?php echo $this->element('generic'.DS.'comments');?>
</div>