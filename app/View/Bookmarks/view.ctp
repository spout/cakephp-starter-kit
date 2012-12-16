<?php 
$this->element('fancybox');

$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $this->request->controller;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	
	<?php 
	$displayElements = array(
		'video' => __('Vidéo de présentation'),
	);
	
	echo $this->element('generic/view-display-elements', array('displayElements' => $displayElements));
	?>
	
	<?php if(isset($item[$modelClass]['oembed']['html'])):?>
		<?php echo $item[$modelClass]['oembed']['html'];?>
	<?php endif;?>
	
</div>