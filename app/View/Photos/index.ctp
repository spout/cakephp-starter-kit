<?php echo $this->element('generic/actions/index');?>

<?php /*
<?php $this->set('title_for_layout', 'Photos chevaux');?>
<?php if(!empty($photos)):?>
<?php echo $this->element('paginator-counter');?>
<?php foreach($photos as $photo):?>
	<?php 
	$photoInfo = $flickr->photos_getInfo($photo['Photo']['photo_id']);
	?>
	<a href="<?php echo $this->Html->url(array('controller' => 'photos', 'action' => 'view', 'id' => $photo['Photo']['id'], 'slug' => slug($photo['Photo']['photo_id'])));?>"><img src="<?php echo $flickr->buildPhotoURL($photoInfo['photo'], 'thumbnail');?>" alt="" /></a>
<?php endforeach;?>
<?php echo $this->element('paginator-links');?>
<?php else:?>
	<p><?php echo __('Aucune photo.');?></p>
<?php endif;?>

<p id="flickr-attribution"><?php echo __('Ce produit utilise l\'API Flickr mais n\'est pas approuvé ni certifié par Flickr.');?></p>
*/?>