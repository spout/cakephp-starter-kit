<?php
// echo $this->Form->input('tag', array('label' => __('Tags'), 'multiple' => false, 'empty' => '-'));
echo $this->Form->input('platform', array('label' => __('Plateforme'), 'options' => $platforms, 'empty' => '-'));
?>