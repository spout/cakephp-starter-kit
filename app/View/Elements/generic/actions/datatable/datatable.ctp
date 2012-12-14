<?php
foreach ($dtResults as $result) {
	$aaData = array();
	foreach ($columns as $k => $col) {
		switch ($k) {
			case 'actions':
				$actions = array(
					'['.$this->Html->link(__('Modifier'), array('action' => 'edit', $result[$modelClass][$primaryKey])).']',
					'['.$this->Html->link(__('Supprimer'), array('action' => 'delete', $result[$modelClass][$primaryKey], 'admin' => true), null,  __('Vous êtes sur ?')).']'
				);
				
				$aaData[] = implode('', $actions);
				break;
				
			case $displayField:
				$aaData[] = $this->Html->link(getPreferedLang($result[$modelClass], 'title'), array('action' => 'view', 'id' => $result[$modelClass][$primaryKey], 'slug' => slug($result[$modelClass][$k])));
				break;
			
			default:
				$aaData[] = $result[$modelClass][$k];
				break;
		}
	}
	
	$this->dtResponse['aaData'][] = $aaData;
	
	/*
    $this->dtResponse['aaData'][] = array(
        $result['User']['id'],
        $result['User']['username'],
        $result['User']['email'],
        'actions',
    );*/
}