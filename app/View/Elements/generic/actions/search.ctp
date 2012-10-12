<?php
$title_for_layout = __('Recherche');
$title_for_layout .= (!empty($query)) ? ' "'.h($query).'"' : '';
$this->set('title_for_layout', $title_for_layout);

echo $this->Form->create($modelClass, array('url' => array('action' => 'search')));
echo $this->Form->input('query', array('label' => __('Mot(s) clé(s)'), 'size' => 40));

if (is_readable(APP.'View'.DS.'Elements'.DS.$this->name.DS.'search-fields'.$this->ext)) {
	echo $this->element($this->name.DS.'search-fields');
}
echo $this->Form->end(__('Recherche'));

if (isset($items) && !empty($items)) {
	$paginatorUrl = array_merge(array('action' => 'search'), $this->params['named']);
	
	$itemsBrowseBefore = isset($itemsBrowseBefore) ? $itemsBrowseBefore : '';
	$itemsBrowseAfter = isset($itemsBrowseAfter) ? $itemsBrowseAfter : '';
	
	$this->Paginator->options(array('url' => $paginatorUrl));
	echo $this->element('generic/items-browse', array('itemsBrowseBefore' => $itemsBrowseBefore, 'itemsBrowseAfter' => $itemsBrowseAfter));
} elseif (empty($items)) {
	echo '<div class="no-results">';
	echo __('Aucun enregistrement trouvé. Veuillez essayer une autre recherche.');
	echo '</div>';
}
?>