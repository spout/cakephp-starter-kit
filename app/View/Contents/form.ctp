<?php 
echo $this->Form->create();
if (!empty($id)) {
	echo $this->Form->hidden('id', array('value' => $id));
}

echo $this->Form->input('url', array('label' => __('Lien')));
echo $this->Form->input('title', array('label' => __('Titre')));
echo $this->Form->input('description', array('label' => __('Description')));
echo $this->Form->input('tags', array('label' => __('Tags')));

echo $this->Form->end(!empty($id) ? __('Modifier') : __('Ajouter'));
?>