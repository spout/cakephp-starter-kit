<?php 
$title = getPreferedLang($item[$modelClass], $displayField);
$description = getPreferedLang($item[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">
	<p class="<?php echo $this->request->params['controller'];?>-browse-item-title"><?php echo $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($title)));?></p>
	<p class="<?php echo $this->request->params['controller'];?>-browse-item-date"><?php echo sprintf(__('Publié le %s'), $this->MyHtml->niceDate($item[$modelClass]['created']));?></p>
	
	<?php if(!empty($description)):?>
		<div class="<?php echo $this->request->params['controller'];?>-browse-item-description">
			<?php echo $this->Text->truncate($description, 400, array('ending' => '...', 'html' => true));?>
		</div>
	<?php endif;?>
</div>