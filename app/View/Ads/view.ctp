<?php 
$this->element('fancybox');

$title = getPreferedLang(${$singularVar}[$modelClass], 'title');
$description = getPreferedLang(${$singularVar}[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	
	<?php for($i = 1; $i <= 3; $i++):?>
		<?php if(isset(${$singularVar}[$modelClass]['photo_'.$i]) && !empty(${$singularVar}[$modelClass]['photo_'.$i])):?>
			<p class="<?php echo $pluralVar;?>-view-photo">
				<a href="<?php echo FULL_BASE_URL.$this->request->webroot;?>files/annonces/photo_<?php echo $i;?>/<?php echo ${$singularVar}[$modelClass]['id'];?>/<?php echo rawurlencode(${$singularVar}[$modelClass]['photo_'.$i]);?>" class="fancybox" rel="fancybox">
					<?php echo $this->element('phpthumb', array('src' => 'files/annonces/photo_'.$i.'/'.${$singularVar}[$modelClass]['id'].'/'.${$singularVar}[$modelClass]['photo_'.$i], 'w' => 200, 'h' => 200));?>
				</a>
			</p>
		<?php endif;?>
	<?php endfor;?>
	<div class="clear"></div>
	
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
	
	<?php if(!empty(${$singularVar}[$modelClass]['geo_lat']) && !empty(${$singularVar}[$modelClass]['geo_lon'])):?>
		<h2><?php echo __('Carte');?></h2>
		<?php echo $this->element('google-maps', array('lat' => ${$singularVar}[$modelClass]['geo_lat'], 'lon' => ${$singularVar}[$modelClass]['geo_lon']));?>
	<?php endif;?>
</div>