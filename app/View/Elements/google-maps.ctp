<?php if(isset($lat) && isset($lon)):?>
<?php
$infoWindowContent = (isset(${$singularVar}[$modelClass]) && !empty(${$singularVar}[$modelClass])) ? h(getPreferedLang(${$singularVar}[$modelClass], 'title')) : '';
$this->Html->script('http://maps.google.com/maps/api/js?sensor=false', false);
$zoom = isset($zoom) ? $zoom : 15;
$gmapId = isset($gmapId) ? $gmapId : 'gmap';
$gmapOverviewId = isset($gmapOverviewId) ? $gmapOverviewId : 'gmap_overview';
$gmapStyle = isset($gmapStyle) ? $gmapStyle : 'width:50%;height:370px;float:left;';
$gmapOverviewStyle = isset($gmapOverviewStyle) ? $gmapOverviewStyle : 'width:50%;height:370px;float:right;';

$scriptBlock = <<<EOT
	$(function(){
		var myLatlng = new google.maps.LatLng($lat,$lon);
		var myOptions = {
			zoom: $zoom,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.HYBRID,
			scrollwheel: false
		}
		var map = new google.maps.Map(document.getElementById("gmap"), myOptions);
		
		var infowindow = new google.maps.InfoWindow({
			content:'{$infoWindowContent}'
		});
		
		var marker = new google.maps.Marker({
			position: myLatlng, 
			map: map
		});
		
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
		
		var myOptions_overview = {
			zoom: 5,
			center: myLatlng,
			navigationControl: true,
			mapTypeControl: false,
			scaleControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false
		}
		
		var map_overview = new google.maps.Map(document.getElementById("gmap_overview"), myOptions_overview);
		
		var marker_overview = new google.maps.Marker({
			position: myLatlng, 
			map: map_overview
		});
	});   
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>
<div id="<?php echo $gmapId;?>" style="<?php echo $gmapStyle;?>"></div>
<div id="<?php echo $gmapOverviewId;?>" style="<?php echo $gmapOverviewStyle;?>"></div>
<div class="clear"></div>
<?php endif;?>