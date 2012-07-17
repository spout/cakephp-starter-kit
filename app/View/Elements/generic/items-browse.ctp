<?php if(isset($items) && !empty($items)):?>
	<?php // echo $this->element('paginator-counter');?>
	<?php // echo $this->element('paginator-links');?>
	<div class="<?php echo $this->request->params['controller'];?>-browse">
		<?php if(isset($itemsBrowseBefore)):?>
			<?php echo $itemsBrowseBefore;?>
		<?php endif;?>
		
		<?php foreach($items as $k => $item):?>
			<?php echo $this->element($this->name.'/items-browse-item', array('item' => $item, 'k' => $k));?>
		<?php endforeach;?>
		
		<?php if(isset($itemsBrowseAfter)):?>
			<?php echo $itemsBrowseAfter;?>
		<?php endif;?>
	</div>
	<?php echo $this->element('paginator-links');?>
<?php endif;?>

<?php if(isset($items) && empty($items)):?>
	<div class="alert no-results">
		<?php echo __('Aucun résultat');?>
	</div>
<?php endif;?>