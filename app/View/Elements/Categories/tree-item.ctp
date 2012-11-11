<?php 
/**
* Element displaying a category item in a tree list
*
* @param array $data
* @param int $depth => $depth ? $depth : count($stack),
* @param boolean $hasChildren
* @param int $numberOfDirectChildren
* @param int $numberOfTotalChildren
* @param array $firstChild
* @param array $lastChild
* @param boolean $hasVisibleChildren
*/
$categoryModelClass = 'Category';
echo $this->Html->link($data[$categoryModelClass]['name_'.TXT_LANG], array('controller' => 'categories', 'action' => 'edit', $data[$categoryModelClass]['id'], 'model' => $this->request->params['named']['model'], 'admin' => true));

echo '<div class="btn-group">';
echo $this->Html->link('<i class="icon-edit"></i> '.__('Modifier'), array('action' => 'edit', $data[$categoryModelClass]['id'], 'model' => $this->request->params['named']['model'], 'admin' => true), array('class' => 'btn btn-mini', 'escape' => false));
echo '&nbsp;';
// echo $this->Form->create($modelClass, array('type' => 'delete', 'url' => array('action' => 'delete', $data[$categoryModelClass]['id'], 'admin' => true)));
// echo $this->Form->end(__('Supprimer'));
echo $this->Form->deleteLink('<i class="icon-trash"></i> '.__('Supprimer'), array('action' => 'delete', $data[$categoryModelClass]['id'], 'admin' => true), array('class' => 'btn btn-danger btn-mini', 'escape' => false), __('Vous êtes sur ?'));
echo '</div>';
?>