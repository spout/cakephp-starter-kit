<?php
if (isset($selector)) {
	$this->Html->script('ckeditor/ckeditor.js', false);
	$this->Html->script('ckeditor/adapters/jquery.js', false);
$scriptBlock = <<<EOT
$(function(){
	$('{$selector}').ckeditor();
});
EOT;
	$this->Html->scriptBlock($scriptBlock, array('inline' => false));
}
?>