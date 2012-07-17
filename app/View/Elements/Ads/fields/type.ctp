<?php
if (isset(${$singularVar}[$modelClass]['type']) && !empty(${$singularVar}[$modelClass]['type']) && isset($adsTypes) && isset($adsTypes[${$singularVar}[$modelClass]['type']])) {
	echo $adsTypes[${$singularVar}[$modelClass]['type']];
}
?>