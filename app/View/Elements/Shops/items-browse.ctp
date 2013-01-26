<?php 
/*$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/masonry/2.1.05/jquery.masonry.min.js', array('inline' => false));
$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/2.1.0/jquery.imagesloaded.min.js', array('inline' => false));

$scriptBlock = <<<EOT
	$(function(){
		var container = $('#shops-browse');
		container.imagesLoaded(function(){
			container.masonry({
				itemSelector : '.shops-browse-item',
				columnWidth : 240
			});
		});
	});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));*/
?>
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
		$gallerySize = 'Large';
		$galleryKey = array_search($gallerySize, $gallerySizes); 
		
		$onclick = 'window.open(this.href);return false;';
	?>
	<div id="shops-browse">
		<?php if($this->request->params['action'] != 'view'):?>
			<?php echo $this->MyHtml->paginatorSort('price', __('Trier par prix'));?>
		<?php endif;?>
		<ul class="thumbnails">
		<?php foreach($shops as $k => $shop):?>
			<li class="span3">
				<div class="thumbnail <?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">
					<?php if(isset($shop['Shop']['galleryInfoContainer']['galleryURL'][$galleryKey]['@'])):?>
						<a href="<?php echo h($shop['Shop']['viewItemURL']);?>" onclick="<?php echo $onclick;?>" rel="nofollow"><img src="<?php echo h($shop['Shop']['galleryInfoContainer']['galleryURL'][$galleryKey]['@']);?>" alt="" /></a>
						<div class="caption">
							<p>
								<a href="<?php echo h($shop['Shop']['viewItemURL']);?>" onclick="<?php echo $onclick;?>" rel="nofollow"><?php echo h($shop['Shop']['title']);?></a>
							</p>
							<p>
								<span class="label"><?php echo number_format($shop['Shop']['sellingStatus']['currentPrice']['@'], 2, ',', ' ');?> <?php echo $shop['Shop']['sellingStatus']['currentPrice']['@currencyId'];?></span>
							</p>
							<?php /*
							<p>
								<?php echo __('Fin: %s', $this->MyHtml->niceDate($shop['Shop']['listingInfo']['endTime']));?>
							</p>
							<p>
								<?php echo getPrettyTimeFromEbayTime($shop['Shop']['sellingStatus']['timeLeft']);?>
							</p>
							*/?>
						</div>
					<?php endif;?>

				</div>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
	<?php if($this->request->params['action'] == 'view'):?>
		<p><?php echo $this->Html->link(__('Voir tous les produits'), array('controller' => 'shops', 'action' => 'index', 'id' => $item[$modelClass]['id']));?></p>
	<?php endif;?>
<?php endif;?>