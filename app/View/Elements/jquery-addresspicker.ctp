<?php
$this->Html->script('http://maps.google.com/maps/api/js?sensor=false', false);
$this->Html->script('jquery/jquery.ui.addresspicker.js', false);

$mapCenter = array(
	'lat' => '48.816781223573514',
	'lon' => '2.3076171875'
);

$scriptBlock = <<<EOT
$(function() {
	//override _findInfo because we want short_name for country
	$.ui.addresspicker.prototype._findInfo = function(result, type) {
		for (var i = 0; i < result.address_components.length; i++) {
			var component = result.address_components[i];
			if (component.types.indexOf(type) !=-1) {
				if (type == 'country') {
					return component.short_name.toLowerCase();
				} else {
					return component.long_name;
				}
			}
		}
		//return false;
	};
  
	var addresspickerMap = $("#{$modelClass}Address").addresspicker({
		mapOptions: {
			center: new google.maps.LatLng({$mapCenter['lat']}, {$mapCenter['lon']})
		},
		elements: {
			map:			"#gmap",
			lat:			"#{$modelClass}GeoLat",
			lng:			"#{$modelClass}GeoLon",
			locality:		"#{$modelClass}City",
			country:		"#{$modelClass}Country",
			postal_code:	"#{$modelClass}Postcode"
		}
	});
	var gmarker = addresspickerMap.addresspicker("marker");
	gmarker.setVisible(true);
	addresspickerMap.addresspicker("updatePosition");
});

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
			//echo $this->Form->hidden($k);
			echo $this->Form->input($k , array('label' => $v, 'type' => 'text', 'default' => ''));
		}
		?>
	</div>
	<div class="span6">
		<div id="gmap" style="width:100%;height:250px;"></div>
	</div>
</div>