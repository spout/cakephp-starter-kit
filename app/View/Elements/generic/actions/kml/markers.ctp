<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>

<kml xmlns="http://www.opengis.net/kml/2.2">
	<Document>
	<?php
	$markers = array();
	foreach(${$pluralVar} as $k => ${$singularVar}){
		$markers[${$singularVar}[$modelClass]['geo_lat'].'_'.${$singularVar}[$modelClass]['geo_lon']][] = ${$singularVar};
	}
	
	foreach ($markers as $k => $m) {
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
	?>
	
		<Placemark>
			<name><?php echo h($title);?></name>
			<description>
				<![CDATA[
				
				<?php echo $htmlCode;?>
				
				]]>
			</description>
			<Point>
				<coordinates><?php echo $lon;?>,<?php echo $lat;?></coordinates>
			</Point>
		</Placemark>
	<?php	
	}
	?>
	</Document>
</kml>