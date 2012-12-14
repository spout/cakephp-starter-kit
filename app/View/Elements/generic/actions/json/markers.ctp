<?php
$markers = array();
$json = array();
foreach($items as $k => $item){
	$markers[$item[$modelClass]['geo_lat'].'_'.$item[$modelClass]['geo_lon']][] = $item;
}

$count = 0;
foreach ($markers as $k => $m) {
	//$htmlCode = '<div style="max-height:150px;overflow-y:auto;">';
	$htmlCode = '';
	$htmlCode .= '<ul>';
	foreach ($m as $mChild) {
		$title = getPreferedLang($mChild[$modelClass], 'title');
		$htmlCode .= '<li>';
		$htmlCode .= '<p><strong><a href="'.Router::url(array('lang' => TXT_LANG, 'action' => 'view', 'id' => $mChild[$modelClass]['id'], 'slug' => slug($title)), true).'">'.$title.'</a></strong></p>';
		if (isset($mChild[$modelClass]['city']) && !empty($mChild[$modelClass]['city'])) {
			$htmlCode .= '<p>'.$mChild[$modelClass]['city'].'</p>';	
		}
		$htmlCode .= '<p>'.$this->Html->image('flags/'.$mChild['Country']['code'].'.gif').'&nbsp;'.$mChild['Country']['name_'.TXT_LANG].'</p>';
		$htmlCode .= '</li>';
		$lat = $mChild[$modelClass]['geo_lat'];
		$lon = $mChild[$modelClass]['geo_lon'];
	}
	$htmlCode .= '</ul>';
	//$htmlCode .= '</div>';

	//$htmlCode = h($htmlCode);
	
	$json[$count]['geo_lat'] = $lat;
	$json[$count]['geo_lon'] = $lon;
	$json[$count]['infoWindowContent'] = $htmlCode;
	$count++;
}

echo json_encode($json);
?>