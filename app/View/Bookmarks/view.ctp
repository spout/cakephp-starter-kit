<?php 
$this->element('fancybox');

$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	
	<?php 
	/*$displayElements = array(
		'video' => __('Vidéo de présentation'),
		'description' => __('Description'),
		'type' => __('Type'),
		'price' => __('Prix'),
		'city' => __('Ville'),
		'country' => __('Pays'),
		'address_components' => __('Localisation'),
		'geo' => __('Coordonnées GPS'),
		'email_contact' => __('E-mail'),
		'phone' => __('Téléphone'),
		'skype' => __('Skype'),
		'hitcount' => __('Consulté'),
	);
	
	echo $this->element('generic/view-display-elements', array('displayElements' => $displayElements));*/
	?>
	
	<?php if(isset($item[$modelClass]['oembed']['html'])):?>
		<?php echo $item[$modelClass]['oembed']['html'];?>
	<?php endif;?>
	
</div>