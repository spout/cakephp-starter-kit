<?php echo $this->Form->create($modelClass);?>
<?php echo $this->Form->input('id', array('options' => $idsList));?>
<?php echo $this->Form->input('field', array('options' => array_combine($fields, $fields), 'empty' => '-'));?>
<?php echo $this->Form->input('value', array('type' => 'textarea'));?>
<?php echo $this->Form->end(__('Envoyer'));?>