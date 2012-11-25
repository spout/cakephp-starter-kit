<?php 
if (isset($item[$modelClass]['address_components']) && !empty($item[$modelClass]['address_components'])) {
	$addressComponents = unserialize($item[$modelClass]['address_components']);
	
	$order = array(
		//'country',
		'administrative_area_level_1',
		'administrative_area_level_2',
		'administrative_area_level_3',
		'colloquial_area',
		'locality',
		'sublocality',
		//'postal_code'
	);
	
	$tmp = array();
	foreach ($order as $o) {
		if (isset($addressComponents[$o])) {
			$tmp[] = $addressComponents[$o]['long_name'];
		}
	}
	$addressComponents = array_unique($tmp);
	
	echo implode(' <span class="divider">&rsaquo;</span> ', $addressComponents);
}