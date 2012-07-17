<?php if(isset($item) && !empty($item)):?>
<?php
$docId = 119691;
$siteId = 399912;
$uid = $item[$modelClass]['id'];

$endpoint = 'http://payment.rentabiliweb.com/form/vc/';
$query = http_build_query(array('docId' => $docId, 'siteId' => $siteId, 'cnIso' => 'geoip', 'uid' => $uid));

$url = $endpoint.'?'.$query;

$lightboxTitle = __('Achetez des points');

$scriptBlock = <<<EOT
$(function() {
	$(".rentabiliweb-vc-form").fancybox({
		'width'	: '75%',
		'height' : '75%',
	    'autoScale' : false,
	    'transitionIn' : 'none',
		'transitionOut' : 'none',
		'type' : 'iframe',
		'title': "{$lightboxTitle}"
	});
});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>
<?php echo $this->Html->image('icons/silk/coins_add.png');?> <a class="rentabiliweb-vc-form" href="<?php echo h($url);?>"><?php echo __('Achetez des points');?></a>

<?php /*
<iframe src="<?php echo $url;?>" width="700" height="1300" frameborder="0" scrolling="auto"></iframe>
*/?>
<?php else:?>
	$uid not defined or empty !
<?php endif;?>