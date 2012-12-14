<?php 
$ajaxUrl = $this->Html->url(array('action' => 'index', 'admin' => true));

$scriptBlock = <<<EOT
	$(function() { 
		loadPiece("{$ajaxUrl}", "#itemList"); 
	}); 

	function loadPiece(href,divName) {     
		$(divName).load(href, {}, function(){ 
			var divPaginationLinks = divName+" #pagination a"; 
			$(divPaginationLinks).click(function() {      
				var thisHref = $(this).attr("href"); 
				loadPiece(thisHref,divName); 
				return false; 
			});
		}); 
	}
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));

$this->Paginator->options(array('url' => array('admin' => true)));
?>
<?php if(isset($items) && !empty($items)):?>
	<?php if(!$this->request->is('ajax')):?>
		<div id="itemList"></div>
	<?php else:?>
		<div id="pagination"> 
			<?php echo $this->element('paginator-counter');?>
			<?php echo $this->element('paginator-links');?>
		</div>
		<table>
		<?php foreach($columns as $colk => $colv):?>
			<th><?php echo h($colv);?></th>
		<?php endforeach;?>
		<?php foreach($items as $k => $item):?>
			<tr>
				<?php foreach($columns as $colk => $colv):?>
					<?php 
					switch ($colk) {
						case 'actions':
						$actions = array(
							'['.$this->Html->link(__('Modifier'), array('action' => 'edit', $item[$modelClass][$primaryKey])).']',
							'['.$this->Html->link(__('Supprimer'), array('action' => 'delete', $item[$modelClass][$primaryKey], 'admin' => true), null,  __('Vous êtes sur ?')).']'
						);
							
						$output = implode('', $actions);
						break;

					case $displayField:
						$title = getPreferedLang($item[$modelClass], 'title');
						$output = $this->Html->link($title, array('action' => 'view', 'id' => $item[$modelClass][$primaryKey], 'slug' => slug($title)));
						break;

					default:
						$output = $item[$modelClass][$colk];
						break;
					}
					?>
					<td>
						<?php echo $output;?>
					</td>
				<?php endforeach;?>
				
			</tr>
		<?php endforeach;?>
		</table>
	<?php endif;?>
<?php endif;?>