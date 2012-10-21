<?php 
$title = getPreferedLang($item[$modelClass], $displayField);
$description = getPreferedLang($item[$modelClass], 'description');
?>
<div class="<?php echo $this->request->params['controller'];?>-browse-item <?php if($k%2):?>odd<?php else:?>even<?php endif;?>">
	<div class="row">
		<?php if($item[$modelClass]['user_id'] == Auth::id() || Auth::hasRole(ROLE_ADMIN)):?>
			<div class="span12">
				<div class="<?php echo $this->request->params['controller'];?>-browse-item-awards">
					<span class="underline"><?php echo __('Points');?></span> : <?php echo $item[$modelClass]['awards'];?>
				</div>
				<div class="clear"></div>
			</div>
		<?php endif;?>

		<div class="span2">
			<p class="<?php echo $this->request->params['controller'];?>-browse-item-thumb">
				<?php 
				if (!empty($item[$modelClass]['url'])) {
					$thumb = $this->element('website-screenshot', array('url' => $item[$modelClass]['url'], 'size' => 'sm'));
				} else {
					$thumb = $this->element('phpthumb', array('src' => 'img/thumb-default.png', 'w' => 120, 'h' => 90, 'zc' => 0, 'f' => 'png'));
				}
				echo $this->Html->link($thumb, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($title)), array('escape' => false));
				?>
			</p>
		</div>

		<div class="span6">
			<p class="<?php echo $this->request->params['controller'];?>-browse-item-title">
				<?php echo $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($title)));?>
			</p>
			<p class="<?php echo $this->request->params['controller'];?>-browse-item-location">
				<?php echo $this->Html->image('flags/'.$item['Country']['code'].'.gif', array('alt' => $item['Country']['name_'.TXT_LANG], 'title' => $item['Country']['name_'.TXT_LANG]));?> <?php if(!empty($item[$modelClass]['city'])):?><?php echo h($item[$modelClass]['city']);?><?php else:?>&nbsp;<?php endif;?>
			</p>

			<p class="<?php echo $this->request->params['controller'];?>-browse-item-description">
				<?php if(!empty($description)):?>
					<?php echo h($this->Text->truncate($description, 200, array('ending' => '...')));?>
				<?php else:?>
					&nbsp;
				<?php endif;?>
			</p>

			<?php if(!empty($item[$modelClass]['url'])):?>
				<?php 
				$urlDisplay = !empty($item[$modelClass]['url_display']) ? $item[$modelClass]['url_display'] : $item[$modelClass]['url'];
				$urlPath = parse_url($urlDisplay, PHP_URL_PATH);
				?>
				<p class="<?php echo $this->request->params['controller'];?>-browse-item-url"><?php echo parse_url($urlDisplay, PHP_URL_HOST);?><?php if($urlPath != '/'):?><?php echo $urlPath;?><?php endif;?></p>
			<?php endif;?>
		</div>
		<div class="clear"></div>
	
	</div>
</div>