<?php 
$this->element('fancybox');

$title = getPreferedLang(${$singularVar}[$modelClass], 'title');
$description = getPreferedLang(${$singularVar}[$modelClass], 'description');
$this->set('title_for_layout', h($title));
if (isset(${$singularVar}[$modelClass]['h1']) && !empty(${$singularVar}[$modelClass]['h1'])) {
	$this->set('h1_for_layout', h(${$singularVar}[$modelClass]['h1']));
}
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	<p class="<?php echo $pluralVar;?>-view-date"><?php echo sprintf(__('Publié le %s'), $this->MyHtml->niceDate(${$singularVar}[$modelClass]['created']));?></p>
	
	<div class="<?php echo $pluralVar;?>-view-description">
		<?php echo $description;?>
	</div>
	
	<?php echo $this->element('generic'.DS.'comments');?>
</div>