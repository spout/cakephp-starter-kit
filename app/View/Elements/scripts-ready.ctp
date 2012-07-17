<?php
$controller = isset($controller) ? $controller : 'links';
$autocompleteUrl = $this->Html->url(array('controller' => $controller, 'action' => 'autocomplete'));
$flagsPath = FULL_BASE_URL.$this->request->webroot.'img/flags/';
$scriptBlock = <<<EOT
$(function() {
	$("a.fancybox").fancybox({
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic'
		});
		
	$("#searchfield").autocomplete({
		source: "{$autocompleteUrl}",
		minLength: 2,
		select: function( event, ui ) {
			window.location.replace(ui.item.url);
		}
	}).data("autocomplete")._renderItem = function(ul, item){
			var appendContent = '<a>';
			if(typeof item.country != 'undefined'){
				appendContent += '<img src="{$flagsPath}' + item.country + '.gif" alt="" \/> ';
			}
			
			appendContent += item.label;
			
			if(typeof item.city != 'undefined'){
				appendContent += ' - ' + item.city;
			}
			
			appendContent += '<\/a>';
			
			return $("<li><\/li>")
				.data("item.autocomplete", item)
				.append(appendContent)
				.appendTo(ul);
		};
});
EOT;
echo $this->Html->scriptBlock($scriptBlock, array('inline' => true));
?>