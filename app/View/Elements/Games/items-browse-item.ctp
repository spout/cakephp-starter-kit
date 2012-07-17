<?php 
$title = getPreferedLang($item[$modelClass], $displayField);
$description = getPreferedLang($item[$modelClass], 'description');
?>
<li class="span3">
	<div class="thumbnail">
		<p class="<?php echo $this->request->params['controller'];?>-browse-item-title"><?php echo $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => $item[$modelClass]['slug'], 'admin' => false));?></p>
		<?php 
		$fileNameExt = array('jpg','png','gif');
		$logoPath = WWW_ROOT.'uploads/images/games/'.$item[$modelClass]['slug'].'/';

		$logoTypes = array('screen', 'logo');

		foreach ($logoTypes as $l) {
			if (!isset($logo)) {
				foreach ($fileNameExt as $ext) {
					if (is_readable($logoPath.$l.'.'.$ext)) {
						$logo = $l.'.'.$ext;
						break;
					}
				}
			}
		}
		
		if (isset($logo)) {
			$thumb = $this->element('phpthumb', array('src' => 'uploads/images/games/'.$item[$modelClass]['slug'].'/'.$logo, 'w' => 260, 'h' => 180, 'zc' => 1, 'f' => 'png'));
			echo $this->Html->link($thumb, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => $item[$modelClass]['slug'], 'admin' => false), array('escape' => false));
		}	
		?>
		<div class="caption">
			
			<?php 
			if(isset($item['Category']) && !empty($item['Category'])) {
				$cats = array();
				foreach ($item['Category'] as $c) {
					$cats[] = '<span class="label">'.h($c['name_'.TXT_LANG]).'</span>';
				}
				echo '<p class="'.$this->request->params['controller'].'-browse-item-cats">';
				echo implode(' ', $cats);
				echo '</p>';
			}
			?>
			
			<?php if(!empty($item[$modelClass]['platforms'])):?>
				<p class="<?php echo $this->request->params['controller'];?>-browse-item-platforms">
					<?php foreach($item[$modelClass]['platforms'] as $platform):?>
						<?php echo $this->Html->image('gamesdir/os/'.$platform.'.png', array('alt' => $platforms[$platform], 'title' => $platforms[$platform]));?>
					<?php endforeach;?>
				</p>
			<?php endif;?>
			
			<?php echo $this->element('Games/item-rating-display', array('item' => $item));?>
			
			<?php /*
			$multiplayerLabel = ($item[$modelClass]['multiplayer'] == 'yes') ? 'label-success' : 'label-important';
			$multiplayerIcon = ($item[$modelClass]['multiplayer'] == 'yes') ? 'icon-ok' : 'icon-remove';
			$onlinePlayLabel = ($item[$modelClass]['online_play'] == 'yes') ? 'label-success' : 'label-important';
			$onlinePlayIcon = ($item[$modelClass]['online_play'] == 'yes') ? 'icon-ok' : 'icon-remove';
			*/
			?>
			<?php /*
			<p>
				<span class="label <?php echo $multiplayerLabel;?>"><i class="<?php echo $multiplayerIcon;?>"></i> <?php echo __('Multijoueurs');?></span>
				<span class="label <?php echo $onlinePlayLabel;?>"><i class="<?php echo $onlinePlayIcon;?>"></i> <?php echo __('Jouable en ligne');?></span>
			</p>*/
			?>
			
		</div>
	</div>
</li>