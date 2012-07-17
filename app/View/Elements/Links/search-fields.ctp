<?php
echo $this->Form->input('cat_id', array('label' => __('Categorie'), 'escape' => false, 'empty' => '-'));
if (isset($countries) && !empty($countries)) {
	echo $this->Form->input('country', array('label' => __('Pays'), 'options' => $this->MyHtml->getAlphabetListArray($countries), 'empty' => '-'));
}