<?php 
if (!empty($item[$modelClass]['geo_lat']) && !empty($item[$modelClass]['geo_lon'])) {
	echo friendlyGPSCoords($item[$modelClass]['geo_lat'], $item[$modelClass]['geo_lon']);
}
?>