<?php 
$this->element('fancybox');

$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
if (isset($item[$modelClass]['h1']) && !empty($item[$modelClass]['h1'])) {
	$this->set('h1_for_layout', h($item[$modelClass]['h1']));
}
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	<p class="<?php echo $pluralVar;?>-view-date"><?php echo sprintf(__('Publié le %s'), $this->MyHtml->niceDate($item[$modelClass]['created']));?></p>
	
	<div class="<?php echo $pluralVar;?>-view-description">
		<?php echo $description;?>
	</div>
	
	<?php echo $this->element('generic'.DS.'comments');?>
</div>