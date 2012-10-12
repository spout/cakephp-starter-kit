<?php
if (isset($item[$modelClass]['type']) && !empty($item[$modelClass]['type']) && isset($adsTypes) && isset($adsTypes[$item[$modelClass]['type']])) {
	echo $adsTypes[$item[$modelClass]['type']];
}