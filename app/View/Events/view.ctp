<?php 
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
			<p class="floatl">
				<a href="<?php echo $this->request->webroot;?>uploads/ad/photo_<?php echo $i;?>/<?php echo ${$singularVar}[$modelClass]['photo_'.$i];?>" class="fancybox" rel="fancybox">
					<?php echo $this->element('phpthumb', array('src' => 'uploads/ad/photo_'.$i.'/'.${$singularVar}[$modelClass]['photo_'.$i], 'w' => 200, 'h' => 200));?>
				</a>
			</p>
		<?php endif;?>
	<?php endfor;?>
	<div class="clear"></div>
	
	<?php 
	$displayElements = array(
		'description' => __('Description'),
		'date_start' => __('Du'),
		'date_end' => __('Au'),
		'city' => __('Ville'),
		'country' => __('Pays'),
		'address_components' => __('Localisation'),
		//'email_contact' => __('E-mail'),
	);
	
	echo $this->element('generic/view-display-elements', array('displayElements' => $displayElements));
	?>
	
	<?php echo $this->element('generic'.DS.'nearby');?>
	
	<?php if(!empty(${$singularVar}[$modelClass]['geo_lat']) && !empty(${$singularVar}[$modelClass]['geo_lon'])):?>
		<h2><?php echo __('Carte');?></h2>
		<?php echo $this->element('google-maps', array('lat' => ${$singularVar}[$modelClass]['geo_lat'], 'lon' => ${$singularVar}[$modelClass]['geo_lon']));?>
	<?php endif;?>
</div>