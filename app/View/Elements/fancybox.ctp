<?php 
$this->Html->script('jquery/jquery.fancybox.js', false);
$this->Html->css('fancybox/jquery.fancybox', null, array('inline' => false));

$scriptBlock = <<<EOT
	$(function(){
		$("a.fancybox").fancybox({
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});
	});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>