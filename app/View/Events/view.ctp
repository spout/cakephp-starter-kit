<?php 
$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);
?>

<div class="<?php echo $pluralVar;?>-view">
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	
	<?php for($i = 1; $i <= 3; $i++):?>
		<?php if(isset($item[$modelClass]['photo_'.$i]) && !empty($item[$modelClass]['photo_'.$i])):?>
			<p class="floatl">
				<a href="<?php echo $this->request->webroot;?>uploads/ad/photo_<?php echo $i;?>/<?php echo $item[$modelClass]['photo_'.$i];?>" class="fancybox" rel="fancybox">
					<?php echo $this->element('phpthumb', array('src' => 'uploads/ad/photo_'.$i.'/'.$item[$modelClass]['photo_'.$i], 'w' => 200, 'h' => 200));?>
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
	
	<?php if(!empty($item[$modelClass]['geo_lat']) && !empty($item[$modelClass]['geo_lon'])):?>
		<h2><?php echo __('Carte');?></h2>
		<?php echo $this->element('google-maps', array('lat' => $item[$modelClass]['geo_lat'], 'lon' => $item[$modelClass]['geo_lon']));?>
	<?php endif;?>
</div>