<?php $this->set('title_for_layout', __('Catégories'));?>
<?php if(isset($this->request->params['named']['model'])):?>
	<p><?php echo $this->Html->link(__('Ajouter une catégorie'), array('controller' => 'categories', 'action' => 'add', 'model' => $this->request->params['named']['model'], 'admin' => true), array('class' => 'btn btn-primary'));?></p>
<?php endif;?>

<?php if(isset($categoriesModels) && !empty($categoriesModels)):?>
	<h2><?php echo __('Sélectionner le type de catégories à gérer');?></h2>
	<ul>
		<?php foreach($categoriesModels as $k => $category):?>
			<li><?php echo $this->Html->link($category[$modelClass]['model'], array('controller' => 'categories', 'action' => 'index', 'admin' => true, 'model' => $category[$modelClass]['model']));?></li>
		<?php endforeach;?>
	</ul>
<?php endif;?>

<?php if(isset($categories) && !empty($categories)):?>
	<?php echo $this->Tree->generate($categories, array('element' => 'Categories/tree-item', 'model' => 'Category'));?>
<?php endif;?>