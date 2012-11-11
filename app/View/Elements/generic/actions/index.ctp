<?php 
$titles = array();
$h1_for_layout = array();

if (isset($categoryPath) && !empty($categoryPath)) {
	$categoryPath = array_reverse($categoryPath);
	foreach ($categoryPath as $k => $c) {
		$titles[] = h($c[$categoryModelClass]['name_'.TXT_LANG]);
		if ($k === 0 && isset($this->request->params['country']) && isset($country)) {
			$titles[] = h($country['Country']['name_'.TXT_LANG]);
		}
	}
	
	$h1_for_layout[] = $category[$categoryModelClass]['name_'.TXT_LANG];
} elseif (!isset($categoryModelClass) && (!isset($this->request->params['cat_slug']) || !isset($this->request->params['country']))) {
	$h1_for_layout[] = $moduleTitle;
}

if (isset($this->request->params['country']) && isset($country)) {
	if (!isset($categoryPath) || empty($categoryPath)) {
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
	if (isset($this->request->params['country']) && !isset($categoryPath)) {
		array_unshift($h1_for_layout, $moduleTitle);
	}
	$this->set('h1_for_layout', join(' - ', h($h1_for_layout)));
}

if (isset($categoryModelClass) && isset($cat[$categoryModelClass]['description_'.TXT_LANG]) && !empty($cat[$categoryModelClass]['description_'.TXT_LANG])) {
	$metaDescription = array();
	$metaDescription[] = $cat[$categoryModelClass]['description_'.TXT_LANG];
	if (isset($categories) && !empty($categories)) {
		$descroCats = array();
		foreach ($categories as $c) {
			$descroCats[] = $c[$categoryModelClass]['name_'.TXT_LANG];
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
		<?php if (isset($subCategories) && !empty($subCategories)):?>
			<div class="<?php echo $this->request->params['controller'];?>-subcats">
				<?php echo $this->Tree->generate($subCategories, array('element' => 'generic/tree-item', 'model' => $categoryModelClass));?>
				<div class="clear"></div>
			</div>
		<?php elseif(isset($countriesFilters) && !empty($countriesFilters)):?>
			<div class="<?php echo $this->request->params['controller'];?>-countries-filters">
				<h2><?php echo __('Filtrer les résultats par pays');?></h2>
				<ul>
				<?php foreach($countriesFilters as $k => $c):?>
					<li><?php echo $this->Html->image('flags/'.$k.'.gif');?>&nbsp;<?php echo $this->Html->link($c['name_'.TXT_LANG], array('cat_slug' => isset($this->request->params['cat_slug']) ? $this->request->params['cat_slug'] : 0, 'country' => $k.'-'.slug($c['name_'.TXT_LANG])));?>&nbsp;<span class="item-count"><?php echo $c['count'];?></span></li>
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
		
		<?php if(isset($items) && !empty($items) && isset($categoryModelClass) && isset($category[$categoryModelClass]['description_'.TXT_LANG]) && !empty($category[$categoryModelClass]['description_'.TXT_LANG])):?>
			<h2 id="<?php echo $this->request->params['controller'];?>-cat-description"><?php echo h($category[$categoryModelClass]['description_'.TXT_LANG]);?><?php if(isset($this->request->params['country']) && isset($country)):?> - <?php echo h($country['Country']['name_'.TXT_LANG]);?><?php endif;?></h2>
		<?php endif;?>
		<?php echo $this->element('generic/items-browse');?>
	</div>	 

	<div class="span4">
		<?php if(isset($categories) && !empty($categories)):?>
			<div class="<?php echo $this->request->params['controller'];?>-cats">
				<?php echo $this->Tree->generate($categories, array('element' => 'generic/tree-item', 'model' => $categoryModelClass));?>
				<div class="clear"></div>
			</div>
		<?php endif;?>
	</div>
</div>