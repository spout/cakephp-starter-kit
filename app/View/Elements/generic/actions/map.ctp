<?php 
$this->set('title_for_layout', __('Recherche par carte'));
$this->Html->script('http://maps.google.com/maps/api/js?sensor=false', false);
$this->Html->script('markerclusterer.js', false);

$markersUrl = Router::url(array('lang' => TXT_LANG, 'action' => 'markers'), true);
$totalMarkersTxt = __('enregistrement(s) affiché(s) sur la carte pour cette recherche.');
$scriptBlock = <<<EOT
$(function() {
	$("#loading").hide();
	
	$("#loading").ajaxStart(function(){
		$(this).show();
		$('span#totalMarkers').hide();
	});
	
	$("#loading").ajaxStop(function(){
		$(this).hide();
		$('span#totalMarkers').show();
	});
	
	center = new google.maps.LatLng(50.4000000, 4.43333339);
	var options = {
	  'zoom': 2,
	  'center': center,
	  'mapTypeId': google.maps.MapTypeId.HYBRID,
	  scrollwheel: false,
	  disableDefaultUI: true,
      navigationControl: true,
	  navigationControlOptions: {style: google.maps.NavigationControlStyle.ZOOM_PAN}
	};
	
	map = new google.maps.Map(document.getElementById("gmap"), options);
	markerCluster = new MarkerClusterer(map);
	
	geocoder = new google.maps.Geocoder();
	
	getMarkers();
	
	$('#{$modelClass}CatId, #{$modelClass}Country').change(function() {
		updateMarkers();
	});
});

function getMarkers(){
	var catId = $("#{$modelClass}CatId").val();
	if(catId == '' || catId == null){
		catId = 0;
	}
	
	var countryCode = $("#{$modelClass}Country").val();
	if(countryCode == '' || countryCode == null){
		countryCode = 0;
	}
	
	if(countryCode != 0){
		geocoder.geocode({ 'address': $("#{$modelClass}Country :selected").text()}, function(results, status) {
			if(status == google.maps.GeocoderStatus.OK){
				map.fitBounds(results[0].geometry.viewport);
			} else {
				//alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
	
	var url = "$markersUrl" + "/" + catId + "/" + countryCode + ".json";
	
	$.getJSON(url,
        function(data){
          var markers = [];
          
          $.each(data, function(i,item){
			var marker = createMarker(item);
			markers.push(marker);
          });
          
          markerCluster.addMarkers(markers);
          $('span#totalMarkers').html("<strong>" + markers.length + "<\/strong>" + " $totalMarkersTxt");
        });
}

function createMarker(item){
	var latLng = new google.maps.LatLng(item.geo_lat, item.geo_lon);
	
	var marker = new google.maps.Marker({'position': latLng});
	
	var infowindow = new google.maps.InfoWindow({
		content:item.infoWindowContent
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map, marker);
	});

	return marker;
}

function updateMarkers(){
	markerCluster.clearMarkers();
	getMarkers();
	
	var countryCode = $("#{$modelClass}Country").val();
	if(countryCode == '' || countryCode == null){
		countryCode = 0;
	}
	
	if(countryCode == 0){
    	map.setCenter(center);
    	map.setZoom(2);//bug since new v3 API (feb 2011), zoom_changed listener  
    }
}

EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>
<?php echo $this->Form->create();?>
<fieldset>
<legend><?php echo __('Recherche par carte');?></legend>
<?php if(isset($catsList)):?>
	<div class="floatl">
	<?php echo $this->Form->input('cat_id', array('label' => __('Catégorie'), 'options' => $catsList, 'showParents' => true, 'empty' => __('Toutes les catégories'), 'escape' => false));?>
	</div>
<?php endif;?>
<div class="floatl">
<?php echo $this->Form->input('country', array('label' => __('Pays'), 'options' => $countriesOptions, 'default' => '', 'empty' => __('Tous les pays')));?>
</div>
<br class="clear" />
<div>
<span id="loading"><?php echo $this->Html->image('loading.gif', array('alt' => ''));?></span> <span id="totalMarkers"></span>
</div>
</fieldset>
<?php echo $this->Form->end();?>
<div id="gmap" style="width:600px;height:400px;"></div>