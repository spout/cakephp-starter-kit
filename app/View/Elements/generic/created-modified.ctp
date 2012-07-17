<p>
	<?php if(Auth::hasRole(ROLE_ADMIN) && isset($item['User'])):?>
		<small><span class="underline"><?php echo __('Ajouté par');?></span>: <?php echo $item['User']['firstname'];?> <?php echo $item['User']['lastname'];?> - <?php echo $item['User']['email'];?></small><br />
	<?php endif;?>
	<?php if(!empty($item[$modelClass]['created'])):?>
		<small><span class="underline"><?php echo __('Ajouté');?></span>: <?php echo $this->MyHtml->niceDate($item[$modelClass]['created']);?></small><br />
	<?php endif;?>
	<?php if(!empty($item[$modelClass]['modified'])):?>
		<small><span class="underline"><?php echo __('Dernière modification');?></span>: <?php echo $this->MyHtml->niceDate($item[$modelClass]['modified']);?></small>
	<?php endif;?>
</p>