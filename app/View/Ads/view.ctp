<?php 
$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $this->request->controller;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	
	<?php 
	$thumbnails = array();
	for ($i = 1; $i <= 3; $i++) {
		if (isset($item[$modelClass]['photo_'.$i]) && !empty($item[$modelClass]['photo_'.$i])) {
			$thumb = '<li class="span3">';
			$thumb .= '<a href="'.FULL_BASE_URL.$this->request->webroot.'files/annonces/photo_'.$i.'/'.$item[$modelClass]['id'].'/'.rawurlencode($item[$modelClass]['photo_'.$i]).'" class="thumbnail lightbox" rel="gallery">';
			$thumb .= $this->element('phpthumb', array('src' => 'files/annonces/photo_'.$i.'/'.$item[$modelClass]['id'].'/'.$item[$modelClass]['photo_'.$i], 'w' => 200, 'h' => 200));
			$thumb .= '</a>';
			$thumb .= '</li>';
			$thumbnails[] = $thumb;
		}
	}
	?>
	<?php if(!empty($thumbnails)):?>
		<ul class="thumbnails">
			<?php echo implode('', $thumbnails);?>
		</ul>
		<div class="clear"></div>
	<?php endif;?>
	
	<?php 
	$displayElements = array(
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
	
	echo $this->element('generic/view-display-elements', array('displayElements' => $displayElements));
	?>
	
	<?php echo $this->element('generic'.DS.'nearby');?>
	
	<?php if(!empty($item[$modelClass]['geo_lat']) && !empty($item[$modelClass]['geo_lon'])):?>
		<h2><?php echo __('Carte');?></h2>
		<?php echo $this->element('google-maps', array('lat' => $item[$modelClass]['geo_lat'], 'lon' => $item[$modelClass]['geo_lon']));?>
	<?php endif;?>
</div>