<?php 
if (isset($customFields) && !empty($customFields)) {
	$asIsFields = array('empty', 'before', 'between', 'after', 'multiple', 'cols', 'rows', 'size', 'default', 'escape');
	foreach($customFields as $customField) {

		$inputOptions = array();
		
		$inputOptions['type'] = (!empty($customField['CustomField']['type'])) ? $customField['CustomField']['type'] : 'text';
		
		$label = getPreferedLang($customField['CustomField'], 'label');
		if ($customField['CustomField']['type'] == 'radio') {
			$inputOptions['legend'] = $label;
		} else {
			$inputOptions['label'] = $label;
		}	
		
		$options = getPreferedLang($customField['CustomField'], 'options');
		if (!empty($options)) {
			$inputOptions['options'] = explode('|', $options);
		}
		
		foreach ($asIsFields as $v) {
			$inputOptions[$v] = $customField['CustomField'][$v];	
		}
		
		echo $this->Form->input('CustomFieldValue.custom_field_'.$customField['CustomField']['id'], $inputOptions);
	}
}
?>