<?php
$this->Html->script('http://maps.google.com/maps/api/js?v=3.3&amp;sensor=false', false);

$lat = (!empty($this->request->data[$modelClass]['geo_lat'])) ? $this->request->data[$modelClass]['geo_lat'] : '50.3419478';
$lon = (!empty($this->request->data[$modelClass]['geo_lon'])) ? $this->request->data[$modelClass]['geo_lon'] : '5.608199';

$initMarkerPosition = (!empty($this->request->data[$modelClass]['geo_lat']) && !empty($this->request->data[$modelClass]['geo_lon'])) ? 'position: latlng,' : '';

$scriptBlock = <<<EOT

var geocoder;
var map;
var marker;

$(function() {
	initialize();
	$("#{$modelClass}Address").autocomplete({
		//This bit uses the geocoder to fetch address values
		source: function(request, response) {
			geocoder.geocode( {'address': request.term }, function(results, status) {
				response($.map(results, function(item) {
				return {
					label:  item.formatted_address,
					value: item.formatted_address,
					latitude: item.geometry.location.lat(),
					longitude: item.geometry.location.lng(),
					results: results
				}
				}));
			})
		},
		//This bit is executed upon selection of an address
		select: function(event, ui) {
			map.setZoom(16);
			update_fields(ui.item.latitude, ui.item.longitude, ui.item.results);
			
			var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
			marker.setPosition(location);
			map.setCenter(location);
		}
	});
});

function initialize(){
  //MAP
  var latlng = new google.maps.LatLng($lat,$lon);
  var options = {
    zoom: 4,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.HYBRID,
    scrollwheel: false
  };
       
  map = new google.maps.Map(document.getElementById("gmap"), options);
  
  //GEOCODER
  geocoder = new google.maps.Geocoder();
       
  marker = new google.maps.Marker({
    map: map,
    $initMarkerPosition
    draggable: true,
    cursor: 'move',
    animation: google.maps.Animation.DROP
  });
  
  google.maps.event.addListener(marker, 'drag',  function() {
    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          $('#{$modelClass}Address').val(results[0].formatted_address);
		  update_fields(marker.getPosition().lat(), marker.getPosition().lng(), results);
        }
      }
    });
  });
}

function address_component(results, address_type, name_type){
	var address_type = (address_type == null) ? 'country' : address_type;
	var name_type = (name_type == null) ? 'long_name' : name_type;

	if(results.length>0){
		var res = results[0];
		for(i=0; i<res.address_components.length; i++){
			for(j=0; j<res.address_components[i].types.length; j++){
				if(res.address_components[i].types[j] == address_type){
					if(res.address_components[i][name_type]){
						return res.address_components[i][name_type];
					}
				}
			}
		}
	}
}

function update_fields(latitude, longitude, results){
	$('#{$modelClass}GeoLat').val(latitude);
	$('#{$modelClass}GeoLon').val(longitude);
		
	var country = address_component(results, 'country', 'short_name');
	if (country) {
		$('#{$modelClass}Country').val(country.toLowerCase());
	}
	
	var sublocality = address_component(results, 'sublocality', 'long_name');
	if (sublocality) {
		 $('#{$modelClass}City').val(sublocality);
	} else {
		var locality = address_component(results, 'locality', 'long_name');
		if(locality) $('#{$modelClass}City').val(locality);	
	}
	
	var postcode = address_component(results, 'postal_code', 'short_name');
	if (postcode) {
		$('#{$modelClass}Postcode').val(postcode);
	}
}

EOT;

$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>
<div class="row">
	<div class="span6">
		<div class="form-inputs-info">
			<?php echo __("Entrez le lieu 'Adresse, ville, code postal/département'. Au fur et à mesure que vous tapez le lieu, des suggestions apparaissent. Une fois que vous aurez cliqué sur une des suggestions, le marqueur apparaîtra sur la carte. Vous pourrez ensuite le déplacer à l'endroit exact où se situe l'enregistrement.");?>
		</div>
		<?php echo $this->Form->input('address', array('label' => __('Lieu'), 'size' => 60));?>
		<?php 
		$hiddenFields = array(
			'geo_lat' => __('Latitude'),
			'geo_lon' => __('Longitude'),
			'country' => __('Pays'),
			'city' => __('Localité'),
			'postcode' => __('Code postal'),
		);

		foreach ($hiddenFields as $k => $v) {
			echo $this->Form->hidden($k);
			//echo $this->Form->input($k , array('label' => $v, 'type' => 'text', 'default' => ''));
		}
		?>
	</div>
	<div class="span6">
		<div id="gmap" style="width:100%;height:250px;"></div>
	</div>
</div>