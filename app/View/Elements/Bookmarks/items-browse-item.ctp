<?php 
$title = getPreferedLang($item[$modelClass], $displayField);
$description = getPreferedLang($item[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">
	<p class="<?php echo $this->request->params['controller'];?>-browse-item-title">
		<?php echo $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($item[$modelClass]['title']), 'admin' => false));?>
	</p>
	<?php if(isset($item[$modelClass]['oembed']['thumbnail_url'])):?>
		<div>
			<img src="<?php echo $item[$modelClass]['oembed']['thumbnail_url'];?>" alt="" />
		</div>
	<?php endif;?>
</div>