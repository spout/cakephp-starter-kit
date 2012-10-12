<?php 
if (!empty($item[$modelClass]['geo_lon'])) {
	echo friendlyGPSCoord($item[$modelClass]['geo_lon']);
}
?>