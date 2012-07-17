<?php if(isset($item[$modelClass]['website']) && !empty($item[$modelClass]['website'])):?>
	<a href="<?php echo h($item[$modelClass]['website']);?>"><?php echo h($item[$modelClass]['website']);?></a>
<?php endif;?>