<?php 
if (isset($selectors) && !empty($selectors)) {
	$this->Html->script('/select2/select2.min.js', false);
	$this->Html->css('/select2/select2.css', null, array('inline' => false));

	$script = '';
	foreach ($selectors as $k => $v) {
		$select2Selector = is_numeric($k) ? $v : $k;
		$select2Options = is_numeric($k) ? '' : json_encode($v);
		$script .= '$("'.$select2Selector.'").select2('.$select2Options.');'.PHP_EOL;
	}


$scriptBlock = <<<EOT
	$(function(){
		{$script}
	});
EOT;

	$this->Html->scriptBlock($scriptBlock, array('inline' => false));
}