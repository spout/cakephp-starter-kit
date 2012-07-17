<?php 
$this->set('title_for_layout', (!empty($id)) ? __('Modifier une catégorie') : __('Ajouter une catégorie'));

echo $this->Form->create();
if (!empty($id)) {
	echo $this->Form->hidden('id', array('value' => $id));
}

array_unshift($categoriesList, '-');// Add empty value with key 0

echo $this->Form->hidden('model', array('value' => $this->request->params['named']['model']));
echo $this->Form->input('parent_id', array('label' => __('Catégorie parente'), 'options' => $categoriesList));
$langs = Configure::read('Config.languages');
foreach ($langs as $k => $lang) {
	echo '<fieldset>';
	echo '<legend>'.$lang['language'].'</legend>';
	echo $this->Form->input('name_'.$k, array('label' => __('Nom (%s)', strtoupper($k))));
	echo $this->Form->input('slug_'.$k, array('label' => __('Permalien (%s)', strtoupper($k))));
	echo $this->Form->input('description_'.$k, array('label' => __('Description (%s)', strtoupper($k)), 'type' => 'textarea'));
	echo '</fieldset>';
}

echo $this->Form->end((!empty($id)) ? __('Modifier') : __('Ajouter'));
?>