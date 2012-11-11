<?php 
if (!isset($google_ad_client)) {
	$google_ad_client = 'pub-2543171833542907';
}
if (!isset($google_ad_slot)) {
	$google_ad_slot = '9141195829';
}
if (!isset($google_ad_width)) {
	$google_ad_width = 300;
}
if (!isset($google_ad_height)) {
	$google_ad_height = 250;
}
?>
<script type="text/javascript">
<!--
google_ad_client = "<?php echo $google_ad_client;?>";
google_ad_slot = "<?php echo $google_ad_slot;?>";
google_ad_width = <?php echo $google_ad_width;?>;
google_ad_height = <?php echo $google_ad_height;?>;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>