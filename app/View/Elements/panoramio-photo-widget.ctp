<?php 
$this->Html->script('http://www.panoramio.com/wapi/wapi.js?v=1&amp;hl='.TXT_LANG, false);
if(isset($disableDefaultEvents) && $disableDefaultEvents){
	$eventsOptions = "'disableDefaultEvents': [panoramio.events.EventType.PHOTO_CLICKED]";
$eventsFunc = <<<EOT
var panoramioPhotoClicked = function (event) {
	$(location).attr('href', locationHref);
}
	
panoramio.events.listen(widget, panoramio.events.EventType.PHOTO_CLICKED, panoramioPhotoClicked);	
EOT;
}
else{
	$eventsOptions = '';
	$eventsFunc = '';
}
$scriptBlock = <<<EOT
function getPanoramioWidget(element, userId, photoId, locationHref, width, height){
	width = (width == undefined) ? 200 : width;
	height = (height == undefined) ? 200 : height;
	
	var myOptions = {
		'width': width,
		'height': height,
		{$eventsOptions}
		};
	
	var myRequest = new panoramio.PhotoRequest({
	  'ids': [{'userId': userId, 'photoId': photoId}]
	});
	
	var widget = new panoramio.PhotoWidget(element, myRequest, myOptions);
	
	{$eventsFunc}
	
	widget.setPosition(0);
}
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>