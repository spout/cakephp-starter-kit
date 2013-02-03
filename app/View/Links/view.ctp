<?php 
$title = getPreferedLang($item[$modelClass], 'title');
$description = getPreferedLang($item[$modelClass], 'description');
$this->set('title_for_layout', h($title));
$this->set('metaDescription', $description);

/*
$this->Html->script('jquery/jquery.jeditable.mini.js', array('inline' => false));

$editableUrl = $this->Html->url(array('action' => 'save_field'));

$this->Html->scriptStart(array('inline' => false));
?>
$(function(){
	$('.editable').editable('<?php echo $editableUrl;?>', {
		id: 'data[<?php echo $modelClass;?>][id]',
		name: 'data[<?php echo $modelClass;?>][value]',
		submitdata : {
			'data[<?php echo $modelClass;?>][field]': 'description_fr'
		},
		submit: '<?php echo __('OK');?>',
		cancel: '<?php echo __('Annuler');?>',
		type: 'textarea'
	});
});
<?php
$this->Html->scriptEnd();
*/
?>

<div class="<?php echo $this->request->controller;?>-view">
	<?php /*if(Auth::hasRole(ROLE_ADMIN)):?>
		<?php echo $this->element('Links/rentabiliweb-form-vc');?>
		<?php echo $this->element('Links/teads');?>
	<?php endif;*/?>
	
	<?php echo $this->element('generic/actions-links');?>
	
	<h2><?php echo h($title);?></h2>
	
	<div class="media">
		<div class="pull-left">
			<?php if(!empty($item[$modelClass]['url'])):?>
				<?php
				$urlDisplay = !empty($item[$modelClass]['url_display']) ? $item[$modelClass]['url_display'] : $item[$modelClass]['url'];
				if (!empty($urlDisplay)) {
					$countClickUrl = $this->Html->url(array('action' => 'count_clicks', $item[$modelClass]['id']));
				?>
				<p class="<?php echo $this->request->controller;?>-view-thumb">
					<a href="<?php echo $urlDisplay;?>" onclick="location='<?php echo $countClickUrl;?>';return false;" onmouseover="window.status='<?php echo $urlDisplay;?>';return true;" onmouseout="self.status='';return true;">
						<?php echo $this->element('website-screenshot', array('url' => $item[$modelClass]['url'], 'size' => '200x150'));?>
					</a>
				</p>
				<?php }?>
			<?php else:?>
				&nbsp;
			<?php endif;?>
		</div>

		<div class="media-body">
			<?php if(!empty($description)):?>
				<div class="editable" id="<?php echo $item[$modelClass]['id'];?>"><?php echo h($description);?></div>
			<?php endif;?>
		</div>
	</div>
	
	<?php 
	$displayElements = array(
		'url' => __('Site Web'),
		'categories' => __('Catégories'),
		'address' => __('Adresse'),
		'address_components' => __('Localisation'),
		'geo' => __('Coordonnées GPS'),
		'rating' => __('Evaluation'),
		'email_contact' => __('E-mail'),
		'phone' => __('Téléphone'),
		'mobile' => __('Mobile'),
		'fax' => __('Fax'),
		'skype' => __('Skype'),
		'video' => __('Vidéo de présentation'),
		'qr_code' => __('QR Code')
	);
	
	echo $this->element('generic/view-display-elements', array('displayElements' => $displayElements));
	?>
	
	<p class="<?php echo $this->request->controller;?>-bug-report"><?php echo $this->Html->image('icons/silk/bug.png');?>&nbsp;<?php echo $this->Html->link(__('Signaler une erreur ou une modification'), array('controller' => 'contact', '?' => 'subject='.$this->Html->url(array('action' => 'view', 'id' => $item[$modelClass]['id'], 'slug' => slug($title)))), array('rel' => 'nofollow', 'class' => 'fancybox'));?></p>
	
	<?php echo $this->element('Shops'.DS.'items-browse');?>
	
	<?php if(isset($events) && !empty($events)):?>
		<h2><?php echo __('Evénements associés');?></h2>
		<ul>
		<?php foreach($events as $event):?>
			<?php 
			$event = $event['Event'];
			$title = getPreferedLang($event);
			?>
			<li><?php echo $this->Html->link($title, array('controller' => 'events', 'action' => 'view', 'id' => $event['id'], 'slug' => slug($title)));?> - <span class="underline"><?php echo __('Du');?></span>: <?php echo $this->MyHtml->niceDate($event['date_start'], '%e %B %Y');?> - <span class="underline"><?php echo __('Au');?></span>: <?php echo $this->MyHtml->niceDate($event['date_end'], '%e %B %Y');?></li>
		<?php endforeach;?>
		</ul>
	<?php endif;?>
	
	<?php echo $this->element('generic'.DS.'nearby');?>
	
	<?php if(!empty($item[$modelClass]['geo_lat']) && !empty($item[$modelClass]['geo_lon'])):?>
		<h2><?php echo __('Carte');?></h2>
		<?php echo $this->element('google-maps', array('lat' => $item[$modelClass]['geo_lat'], 'lon' => $item[$modelClass]['geo_lon']));?>
	<?php endif;?>
	
	<?php //echo $this->element('generic'.DS.'comments');?>

	<?php echo $this->element('generic'.DS.'created-modified');?>
</div>