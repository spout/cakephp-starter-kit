<?php if(isset($items) && !empty($items)):?>
	<?php 
		$paginatorUrl = array('action' => $this->request->params['action']);
		
		if ($this->request->params['action'] === 'search' && isset($query) && !empty($query)) {
			$paginatorUrl[] = $query;	
		}
		
		if ($this->request->params['action'] === 'index') {
			if (isset($this->request->params['cat_slug'])) {
				$paginatorUrl['cat_slug'] = $this->request->params['cat_slug'];
			}
			
			if (isset($this->request->params['country']) && !empty($this->request->params['country'])) {
				$paginatorUrl['country'] = $this->request->params['country'];
			}
		}
		$this->Paginator->options(array('url' => $paginatorUrl));
		
		$displayPaginator = ($this->request->params['action'] === 'search' || (!isset($catModelClass) || isset($this->request->params['cat_slug'])) || isset($this->request->params['country'])) ? true : false;
	?>
	<?php echo $this->element('paginator-counter');?>
	<?php echo $this->element('paginator-links');?>
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

<?php if(isset($items) && empty($items) && !isset($cats)):?>
	<div class="alert no-results">
		<?php echo __('Aucun résultat');?>
	</div>
<?php endif;?>