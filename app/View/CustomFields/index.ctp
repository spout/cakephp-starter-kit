<?php if(isset($items) && !empty($items)):?>
	<?php echo $this->element('paginator-counter');?>
	
	<?php
	$tableFields = array('model', 'foreign_key', 'type');
	?>
	<table class="<?php echo $this->request->params['controller'];?>-browse" summary="<?php echo h($moduleTitle);?>">
		<tr>
		<?php foreach($tableFields as $f):?>
			<th>
				<?php echo $this->MyHtml->paginatorSort($f, ucfirst($f));?>
			</th>
		<?php endforeach;?>
		</tr>
		<?php foreach($items as $k => $item):?>
			<tr>
				<?php foreach($tableFields as $f):?>
				<td>
					<?php if(isset($item[$modelClass][$f]) && !empty($item[$modelClass][$f])):?>
						<?php echo h($item[$modelClass][$f]);?>
					<?php else:?>
						&nbsp;
					<?php endif;?>
				</td>
				<?php endforeach;?>
			</tr>
		<?php endforeach;?>
	</table>
	<?php echo $this->element('paginator-links');?>
<?php endif;?>