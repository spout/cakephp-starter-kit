<?php $this->set('title_for_layout', ($id) ? __('Modifier un article') : __('Ajouter un article'));?>
<?php echo $this->Form->create($modelClass, array('type' => 'file'));?>
<?php if($id):?>
	<?php echo $this->Form->hidden('id', array('value' => $id));?>
<?php endif;?>

<?php
$contentSelector = '#PostDescription';
$this->element('ckeditor', array('selector' => $contentSelector));
?>

<?php
$scriptBlock = <<<EOT

$(function() {
	
});
EOT;

$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<?php echo $this->element('generic/who-form');?>

<fieldset>
	<legend><?php echo __("L'article");?></legend>
	
	<?php echo $this->Form->input('title', array('label' => __('Titre'), 'size' => 60));?>
	<?php echo $this->Form->input('h1', array('label' => __('Titre H1'), 'size' => 60));?>
	<?php echo $this->Form->input('description', array('label' => __('Description'), 'rows' => 8, 'cols' => 60));?>
</fieldset>

<?php echo $this->Form->end(($id) ? __('Modifier') : __('Ajouter'));?>