<?php 
$title = getPreferedLang(${$singularVar}[$modelClass], $displayField);
$description = getPreferedLang(${$singularVar}[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">
	<p class="<?php echo $this->request->params['controller'];?>-browse-item-title"><?php echo $this->Html->link($title, array('action' => 'view', 'id' => ${$singularVar}[$modelClass][$primaryKey], 'slug' => slug($title)));?></p>
	<p class="<?php echo $this->request->params['controller'];?>-browse-item-date"><?php echo sprintf(__('Publié le %s'), $this->MyHtml->niceDate(${$singularVar}[$modelClass]['created']));?></p>
	
	<?php if(!empty($description)):?>
		<div class="<?php echo $this->request->params['controller'];?>-browse-item-description">
			<?php echo $this->Text->truncate($description, 400, array('ending' => '...', 'html' => true));?>
		</div>
	<?php endif;?>
</div>