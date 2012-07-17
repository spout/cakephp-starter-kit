<?php $this->set('title_for_layout', __('Faire un lien vers %s', __('main_title')));?>
<?php 
//$linkTitle = __('main_title');
$linkTitle = __('Portail de l\'équitation');
$linkPattern = '<a href="'.FULL_BASE_URL.$this->request->webroot.'" title="'.__('main_title').'">%s</a>';
$link = sprintf($linkPattern, $linkTitle);
?>
<h2><?php echo __('Lien texte simple');?></h2>
<p><?php echo $link;?></p>
<code>
<?php echo h($link);?>
</code>

<h2><?php echo __('Lien avec logo');?></h2>

<?php 
$logos = array('200x100-brown', '200x100-orange', '100x50-brown', '100x50-orange');
?>
<?php foreach($logos as $logo):?>
	<?php 
	$img = '<img src="'.FULL_BASE_URL.$this->request->webroot.'img/logos/%s.png" alt="'.$linkTitle.'" />';
	$link = sprintf($linkPattern, sprintf($img, $logo));
	list($width, $height, $type, $attr) = getimagesize(IMAGES.'logos/'.$logo.'.png');
	?>
	<h3>Format <?php echo $width;?>x<?php echo $height;?>px</h3>
	<p>
	<?php echo $link;?>
	</p>
	<code>
	<?php echo h($link);?>
	</code>
<?php endforeach;?>

