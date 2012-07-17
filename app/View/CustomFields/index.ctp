<?php if(isset(${$pluralVar}) && !empty(${$pluralVar})):?>
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
		<?php foreach(${$pluralVar} as $k => ${$singularVar}):?>
			<tr>
				<?php foreach($tableFields as $f):?>
				<td>
					<?php if(isset(${$singularVar}[$modelClass][$f]) && !empty(${$singularVar}[$modelClass][$f])):?>
						<?php echo h(${$singularVar}[$modelClass][$f]);?>
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