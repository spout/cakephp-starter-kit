<?php 
if (!empty($item[$modelClass]['geo_lat'])) {
	echo friendlyGPSCoord($item[$modelClass]['geo_lat']);	
}
?>