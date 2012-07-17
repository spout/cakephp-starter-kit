<?php 
$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<?php /*
	<h2><?php echo h($title);?></h2>
	*/?>
	
	<?php 
	$displayElements = array(
		'description' => __('Description'),
		'rating' => __('Evaluations'),
		'modes' => __('Modes de jeu'),
		'langs' => __('Langues du jeu'),
		'videos' => __('Vidéos'),
		'screenshots' => __('Captures d\'écran'),
		'platforms' => __('Plateformes'),
		'classification' => __('Classification'),
		'license' => __('Licence'),
		'website' => __('Site Web'),
		'download_url' => __('Page de téléchargement'),
		'developers' => __('Développeurs'),
	);
	
	echo $this->element('generic/view-display-elements', array('displayElements' => $displayElements, 'wrapperTag' => 'div', 'titleTag' => 'h3', 'itemTag' => 'div'));
	?>
	
	<?php echo $this->element('generic'.DS.'comments');?>
	<?php echo $this->element('generic'.DS.'created-modified');?>
</div>