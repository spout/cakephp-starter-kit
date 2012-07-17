<?php if(isset($shops) && !empty($shops)):?>
	<?php 
	if(!function_exists('getPrettyTimeFromEbayTime')) {
		function getPrettyTimeFromEbayTime($eBayTimeString){
			// Input is of form 'PT12M25S'
			$matchAry = array(); // null out array which will be filled
			$pattern = "#P([0-9]{0,3}D)?T([0-9]?[0-9]H)?([0-9]?[0-9]M)?([0-9]?[0-9]S)#msiU";
			preg_match($pattern, $eBayTimeString, $matchAry);
			
			$days  = (int) $matchAry[1];
			$hours = (int) $matchAry[2];
			$min   = (int) $matchAry[3];  // $matchAry[3] is of form 55M - cast to int 
			$sec   = (int) $matchAry[4];
			
			$ret = array();
			if ($days) {$ret[] = $days.'d';}
			if ($hours) {$ret[] = $hours.'h';}
			if ($min) {$ret[] = $min.'m';}
			if ($sec) {$ret[] = $sec.'s';}
			
			return implode(' ', $ret);
		}
	}
	
	?>
	<?php //debug($shops);?>
	<?php if($this->request->params['action'] == 'view'):?>
		<h2><?php echo __('Produits en vente');?></h2>
	<?php endif;?>
	<?php
		$gallerySizes = array('Large', 'Medium', 'Small');
		$gallerySize = 'Small';
		$galleryKey = array_search($gallerySize, $gallerySizes); 
		
		$onclick = 'window.open(this.href);return false;';
	?>
	<table class="shops-browse">
	<?php if($this->request->params['action'] != 'view'):?>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $this->MyHtml->paginatorSort('price', __('Prix'));?></th>
			<th><?php echo __('Temps restant');?></th>
		</tr>		
	<?php endif;?>
	<?php foreach($shops as $shop):?>
		<tr>
			<td class="shops-browse-item-image">
				<?php if(isset($shop['Shop']['galleryInfoContainer']['galleryURL'][$galleryKey]['@'])):?>
					<a href="<?php echo h($shop['Shop']['viewItemURL']);?>" onclick="<?php echo $onclick;?>" rel="nofollow"><img src="<?php echo h($shop['Shop']['galleryInfoContainer']['galleryURL'][$galleryKey]['@']);?>" alt="" /></a>
				<?php else:?>
					&nbsp;
				<?php endif;?>
			</td>
			<td class="shops-browse-item-description">
				<p>
					<a href="<?php echo h($shop['Shop']['viewItemURL']);?>" onclick="<?php echo $onclick;?>" rel="nofollow"><?php echo h($shop['Shop']['title']);?></a>
				</p>
				<p>
					<?php echo h($shop['Shop']['primaryCategory']['categoryName']);?>
				</p>
				<p>
					<?php echo __('Fin: %s', $this->MyHtml->niceDate($shop['Shop']['listingInfo']['endTime']));?>
				</p>
			</td>
			<td class="shops-browse-item-price">
				<?php echo number_format($shop['Shop']['sellingStatus']['currentPrice']['@'], 2, ',', ' ');?> <?php echo $shop['Shop']['sellingStatus']['currentPrice']['@currencyId'];?>
			</td>
			<td>
			<?php echo getPrettyTimeFromEbayTime($shop['Shop']['sellingStatus']['timeLeft']);?>
			</td>
		</tr>
	<?php endforeach;?>
	</table>
	
	<?php if($this->request->params['action'] == 'view'):?>
		<p><?php echo $this->Html->link(__('Voir tous les produits'), array('controller' => 'shops', 'action' => 'index', 'id' => ${$singularVar}[$modelClass]['id']));?></p>
	<?php endif;?>
<?php endif;?>