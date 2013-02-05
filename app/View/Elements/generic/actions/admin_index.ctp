<?php 
$this->set('title_for_layout', __('Admin'));
/*$ajaxUrl = $this->Html->url(array('action' => 'index', 'admin' => true));

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
$this->Html->scriptBlock($scriptBlock, array('inline' => false));*/

$this->Paginator->options(array('url' => array('admin' => true)));
?>
<?php if(isset($items) && !empty($items)):?>
	<?php echo $this->element('paginator-counter');?>
	<?php echo $this->element('paginator-links');?>
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
						$this->Html->link('<i class="icon-edit"></i> '.__('Modifier'), array('action' => 'edit', $item[$modelClass]['id']), array('class' => 'btn btn-mini', 'escape' => false)),
						$this->Form->postLink('<i class="icon-trash"></i> '.__('Supprimer'), array('action' => 'delete', $item[$modelClass]['id'], 'admin' => true), array('method' => 'DELETE', 'class' => 'btn btn-danger btn-mini', 'escape' => false), __('Vous êtes sur ?'))
					);
					if (isset($item[$modelClass]['active']) && empty($item[$modelClass]['active'])) {
						$actions[] = $this->Html->link('<i class="icon-ok"></i> '.__('Accepter'), array('action' => 'save_field', $item[$modelClass]['id'], 'active', 1), array('class' => 'btn btn-success btn-mini', 'escape' => false));	
					}
					
					$output = '<div class="btn-group">'.implode('', $actions).'</div>';
					break;

				case $displayField:
					$title = getPreferedLang($item[$modelClass], $displayField);
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
	<?php echo $this->element('paginator-links');?>
<?php endif;?>