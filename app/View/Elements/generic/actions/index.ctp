<?php 
$titles = array();
$h1_for_layout = array();

if (isset($catPath) && !empty($catPath)) {
	$catPath = array_reverse($catPath);
	foreach ($catPath as $k => $c) {
		$titles[] = h($c[$catModelClass]['name_'.TXT_LANG]);
		if ($k === 0 && isset($this->request->params['country']) && isset($country)) {
			$titles[] = h($country['Country']['name_'.TXT_LANG]);
		}
	}
	
	$h1_for_layout[] = $cat[$catModelClass]['name_'.TXT_LANG];
} elseif (!isset($catModelClass) && (!isset($this->request->params['cat_slug']) || !isset($this->request->params['country']))) {
	$h1_for_layout[] = $moduleTitle;
}

if (isset($this->request->params['country']) && isset($country)) {
	if (!isset($catPath) || empty($catPath)) {
		$titles[] = h($country['Country']['name_'.TXT_LANG]);
	}
	$h1_for_layout[] = h($country['Country']['name_'.TXT_LANG]);
}

$titles[] = $moduleTitle;

if (isset($this->request->params['named']['page']) && $this->request->params['named']['page'] > 1) {
	$titles[] = sprintf(__('Page %d'), $this->request->params['named']['page']);
	$h1_for_layout[] = sprintf(__('Page %d'), $this->request->params['named']['page']);
}

$this->set('title_for_layout', join(' - ', $titles));

if (!empty($h1_for_layout)) {
	if (isset($this->request->params['country']) && !isset($catPath)) {
		array_unshift($h1_for_layout, $moduleTitle);
	}
	$this->set('h1_for_layout', join(' - ', h($h1_for_layout)));
}

if (isset($catModelClass) && isset($cat[$catModelClass]['description_'.TXT_LANG]) && !empty($cat[$catModelClass]['description_'.TXT_LANG])) {
	$metaDescription = array();
	$metaDescription[] = $cat[$catModelClass]['description_'.TXT_LANG];
	if (isset($cats) && !empty($cats)) {
		$descroCats = array();
		foreach ($cats as $c) {
			$descroCats[] = $c[$catModelClass]['name_'.TXT_LANG];
		}
		$metaDescription[] = $this->Text->toList($descroCats, __('et'));
	}
	elseif (isset($this->request->params['country']) && isset($country)) {
		$metaDescription[] = h($country['Country']['name_'.TXT_LANG]);
	} elseif (isset($countriesFilters) && !empty($countriesFilters)) {
		$descroCountries = array();
		foreach($countriesFilters as $k => $c) {
			$descroCountries[] = $c['name_'.TXT_LANG];
		}
		$metaDescription[] = $this->Text->toList($descroCountries, __('et'));
	}
	
	
	$this->set('metaDescription', join(' - ', $metaDescription));
}
?>
<div class="row">
	<div class="span8">
		<?php if(isset($subCats) && !empty($subCats)):?>
			<?php echo $this->Tree->generate($subCats, array('element' => 'generic/tree-item', 'model' => $catModelClass));?>
		<?php endif;?>
		
		<?php if(isset($items) && !empty($items) && isset($catModelClass) && isset($cat[$catModelClass]['description_'.TXT_LANG]) && !empty($cat[$catModelClass]['description_'.TXT_LANG])):?>
			<h2 id="<?php echo $this->request->params['controller'];?>-cat-description"><?php echo h($cat[$catModelClass]['description_'.TXT_LANG]);?><?php if(isset($this->request->params['country']) && isset($country)):?> - <?php echo h($country['Country']['name_'.TXT_LANG]);?><?php endif;?></h2>
		<?php endif;?>
		<?php echo $this->element('generic/items-browse');?>
	</div>	 

	<div class="span4">
		<?php if(isset($cats) && !empty($cats)):?>
			<div class="<?php echo $this->request->params['controller'];?>-cats">
				<?php echo $this->Tree->generate($cats, array('element' => 'generic/tree-item', 'model' => $catModelClass));?>
				<div class="clear"></div>
			</div>
		<?php elseif(isset($countriesFilters) && !empty($countriesFilters)):?>
			<div class="<?php echo $this->request->params['controller'];?>-countries-filters">
				<h2><?php echo __('Filtrer les résultats par pays');?></h2>
				<ul>
				<?php foreach($countriesFilters as $k => $c):?>
					<li><?php echo $this->Html->image('flags/'.$k.'.gif');?>&nbsp;<?php echo $this->Html->link($c['name_'.TXT_LANG], array('cat_slug' => isset($this->request->params['cat_slug']) ? $this->request->params['cat_slug'] : 0, 'country' => $k.'-'.slug($c['name_'.TXT_LANG])));?>&nbsp;<span class="item-count">(<?php echo $c['count'];?>)</span></li>
				<?php endforeach;?>
				</ul>
				<div class="clear"></div>
			</div>
		<?php elseif(isset($catsListFilters) && !empty($catsListFilters)):?>
			<div class="<?php echo $this->request->params['controller'];?>-cats-filters">
		<?php
		$selectId = $modelClass.'CatId';
		$scriptBlock = <<<EOT
		$(function(){
			$('#{$selectId}').change(function() {
				window.location = $(this).val();
			});	
		});
EOT;
		$this->Html->scriptBlock($scriptBlock, array('inline' => false));
		?>
				<?php echo $this->Form->create($modelClass, array('url' => '/redir.php'));?>
				<fieldset>
				<legend><?php echo __('Filtrer les résultats par catégories');?></legend>
				<?php echo $this->Form->select('url', $catsListFilters, array('escape' => false, 'id' => $selectId, 'name' => 'url', 'empty' => '-'));?>
				<?php echo $this->Form->submit(__('Go'), array('div' => false));?>
				</fieldset>
				<?php echo $this->Form->end();?>
			</div>
		<?php endif;?>
	</div>
</div>