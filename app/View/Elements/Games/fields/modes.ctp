<?php 
$multiplayerLabel = ($item[$modelClass]['multiplayer'] == 'yes') ? 'label-success' : 'label-important';
$multiplayerIcon = ($item[$modelClass]['multiplayer'] == 'yes') ? 'icon-ok' : 'icon-remove';
$onlinePlayLabel = ($item[$modelClass]['online_play'] == 'yes') ? 'label-success' : 'label-important';
$onlinePlayIcon = ($item[$modelClass]['online_play'] == 'yes') ? 'icon-ok' : 'icon-remove';
?>
<p>
	<span class="label <?php echo $multiplayerLabel;?>"><i class="<?php echo $multiplayerIcon;?>"></i> <?php echo __('Multijoueurs');?></span>
	<span class="label <?php echo $onlinePlayLabel;?>"><i class="<?php echo $onlinePlayIcon;?>"></i> <?php echo __('Jouable en ligne');?></span>
</p>