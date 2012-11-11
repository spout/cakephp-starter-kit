<?php
if (isset($displayElements) && !empty($displayElements)) {
	$wrapperTag = isset($wrapperTag) ? $wrapperTag : 'dl';
	$titleTag = isset($titleTag) ? $titleTag : 'dt';
	$itemTag = isset($itemTag) ? $itemTag : 'dd';
	
	$wrapperClass = isset($wrapperClass) ? $wrapperClass : 'dl-horizontal';
	$titleClass = isset($titleClass) ? $titleClass : '';
	$itemClass = isset($itemClass) ? $itemClass : '';
	
	echo '<'.$wrapperTag.' class="'.$wrapperClass.'">'.PHP_EOL;
	foreach ($displayElements as $e => $t) {
		$possibleElements = array(
			$this->name.DS.'fields'.DS.$e,									//Elements/Examples/fields/title_fr.ctp
			$this->name.DS.'fields'.DS.str_replace('_'.TXT_LANG, '', $e),	//Elements/Examples/fields/title.ctp
			'generic'.DS.'fields'.DS.$e,									//Elements/generic/fields/title_fr.ctp
			'generic'.DS.'fields'.DS.str_replace('_'.TXT_LANG, '', $e),		//Elements/generic/fields/title.ctp
		);
		
		$displayElement = '';
		foreach ($possibleElements as $p) {
			if (is_readable(APP.'View'.DS.'Elements'.DS.$p.$this->ext)) {
				$displayElement = $this->element($p);
				break;
			}
		}
		
		if (!empty($displayElement)) {
			echo '<'.$titleTag.' class="'.$titleClass.'">'.$t.'</'.$titleTag.'>'.PHP_EOL;
			echo '<'.$itemTag.' class="'.$itemClass.'">'.PHP_EOL;
			echo $displayElement.PHP_EOL;
			echo '</'.$itemTag.'>'.PHP_EOL;
		}
	}
	echo '</'.$wrapperTag.'>'.PHP_EOL;
	echo '<div class="clear"></div>';
}
else {
	echo 'No displayElements';	
}
?>