<?php if(isset($item[$modelClass])):?>
	<?php 
	$actions = array();
	if ((isset($item[$modelClass]['user_id']) && Auth::id() == $item[$modelClass]['user_id']) || Auth::hasRole(ROLE_ADMIN)) {
		if (Auth::hasRole(ROLE_ADMIN) && isset($item[$modelClass]['active']) && empty($item[$modelClass]['active'])) {
			$actions[] = $this->Html->link('<i class="icon-ok"></i> '.__('Accepter'), array('action' => 'save_field', $item[$modelClass]['id'], 'active', 1), array('class' => 'btn btn-success btn-mini', 'escape' => false));	
		}
		
		$actions[] = $this->Html->link('<i class="icon-edit"></i> '.__('Modifier'), array('action' => 'edit', $item[$modelClass]['id']), array('class' => 'btn btn-mini', 'escape' => false));
		
		if (Auth::hasRole(ROLE_ADMIN)) {
			// $actions[] = $this->Html->link(__('Supprimer'), array('action' => 'delete', $item[$modelClass]['id']), array('class' => 'action-delete'), __('Vous êtes sur ?'));
			$actions[] = $this->Form->deleteLink('<i class="icon-trash"></i> '.__('Supprimer'), array('action' => 'delete', $item[$modelClass]['id'], 'admin' => true), array('class' => 'btn btn-danger btn-mini', 'escape' => false), __('Vous êtes sur ?'));
		}
	}
	?>
	<?php if(!empty($actions)):?>
		<div class="btn-group">
			<?php echo implode(' ', $actions);?>
		</div>
	<?php endif;?>
<?php endif;?>