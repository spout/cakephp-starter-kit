<?php 
$this->Html->script('/chosen/chosen.jquery.min.js', false);
$this->Html->css('/chosen/chosen.css', null, array('inline' => false));

if (isset($selectors) && !empty($selectors)) {
	$script = '';
	foreach ($selectors as $k => $v) {
		$chosenSelector = is_numeric($k) ? $v : $k;
		$chosenOptions = is_numeric($k) ? '' : json_encode($v);
		$script .= '$("'.$chosenSelector.'").chosen('.$chosenOptions.');'.PHP_EOL;
	}
} else {
	$script = '$(".chzn-select").chosen();';
}

$scriptBlock = <<<EOT
	$(function(){
		{$script}
	});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));