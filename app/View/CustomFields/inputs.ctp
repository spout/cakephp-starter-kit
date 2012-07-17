<?php 
$this->set('title_for_layout', __('Affichage des champs'));

if (Auth::hasRole(ROLE_ADMIN)) {
	echo '<p>'.$this->Html->link(__('Modifier les champs personnalisés'), array('action' => 'form', $model, $foreignKey)).'</p>';
}

App::import('Vendor', 'Spyc', array('file' => 'spyc/spyc.php'));

if (isset($customFields) && !empty($customFields)) {
	echo '<fieldset>';
	echo '<legend>'.__('Détails supplémentaires').'</legend>';
	foreach($customFields as $customField) {
		//$inputOptions = json_decode($customField['CustomField']['options'], true);
		$inputOptions = spyc_load($customField['CustomField']['options']);
		if (!empty($inputOptions)) {
			foreach ($translatableOptions as $attrib) {
				$preferedLang = getPreferedLang($inputOptions, $attrib);
				
				if (!empty($preferedLang)) {
					$inputOptions[$attrib] = $preferedLang;
					foreach (Configure::read('Config.languages') as $klang => $l) {
						unset($inputOptions[$attrib.'_'.$klang]);
					}
				}
			}
			
			if (isset($inputOptions['options'])) {
				sort($inputOptions['options']);
			}
		
			echo $this->Form->input('CustomFieldValue.'.$customField['CustomField']['id'].'.value', $inputOptions);
		}
	}
	echo '</fieldset>';
}
?>