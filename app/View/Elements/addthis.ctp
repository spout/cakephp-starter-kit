<?php 
if(!isset($buttons)){
	$buttons = array(
	'facebook_like',
	'tweet',
	'google_plusone',
	'email',
	'compact',
	//'delicious',
	//'facebook_like',
	);
}
?>
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<?php foreach($buttons as $b):?>
	<?php if($b == 'separator'):?>
		<span class="addthis_separator">&nbsp;</span>
	<?php else:?>
		<a class="addthis_button_<?php echo $b;?>"></a>
	<?php endif;?>
<?php endforeach;?>
<?php /*
<a class="addthis_counter addthis_bubble_style"></a>
*/?>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c40cde93532a0db"></script>