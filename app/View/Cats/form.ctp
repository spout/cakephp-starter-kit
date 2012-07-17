<?php $this->set('title_for_layout', ($id) ? __('Modifier une catégorie') : __('Ajouter une catégorie'));?>
<?php echo $this->Form->create($modelClass, array('type' => 'file'));?>
<?php if($id):?>
	<?php echo $this->Form->hidden('id', array('value' => $id));?>
<?php endif;?>

<fieldset>
	<?php echo $this->Form->input('parent_id', array('label' => __('Catégorie parente'), 'options' => $catsList, 'empty' => '-', 'escape' => false));?>
	<?php foreach(Configure::read('Config.languages') as $k => $l):?>
		<?php echo $this->Form->input('name_'.$k, array('label' => __('Nom %s', $l['language']), 'size' => 60));?>
		<?php echo $this->Form->input('slug_'.$k, array('label' => __('Permalien %s', $l['language']), 'size' => 60));?>
	<?php endforeach;?>
</fieldset>

<?php 

$types = array(
	'text' => 'text',
	'select' => 'select',
	'radio' => 'radio'
);

$formFields = array(
	'label' => array('label' => 'Label'),
	'type' => array('legend' => 'Type', 'options' => $types, 'type' => 'radio'),
	'options' => array('label' => 'Options'),
	'empty' => array('label' => 'Empty'),
	'before' => array('label' => 'Before'),
	'between' => array('label' => 'Between'),
	'after' => array('label' => 'After'),
	'default' => array('label' => 'Default'),
	'multiple' => array('label' => 'Multiple'),
	'size' => array('label' => 'Size'),
	'rows' => array('label' => 'Rows'),
	'cols' => array('label' => 'Cols'),
);
$translatedFields = array('label', 'options');

$customFieldNew = array('CustomField' => array());
if (!isset($customFields) || empty($customFields)) {
	$customFields = array(0 => $customFieldNew);
} else {
	array_push($customFields, $customFieldNew);
}


foreach($customFields as $key => $customField) {
	echo '<fieldset>';
	echo '<legend>'.__('Champ personnalisé').'</legend>';
	if (isset($customField['CustomField']['id'])) {
		echo $this->Form->hidden('CustomField.'.$key.'.id');
	}
	echo $this->Form->hidden('CustomField.'.$key.'.model', array('value' => $modelClass));
	foreach ($formFields as $fieldName => $options) {
		if (in_array($fieldName, $translatedFields)) {
			foreach (Configure::read('Config.languages') as $k => $l) {
				$optionsWithLang = array_merge($options, array('label' => $options['label'].' '.h($l['language'])));
				echo '<div class="floatl">';
				echo $this->Form->input('CustomField.'.$key.'.'.$fieldName.'_'.$k, $optionsWithLang);
				echo '</div>';
			}
			echo '<div class="clear"></div>';
		} else {
			echo $this->Form->input('CustomField.'.$key.'.'.$fieldName, $options);
		}
	}
	echo '</fieldset>';
}
?>	

<?php echo $this->Form->end(($id) ? __('Modifier') : __('Ajouter'));?>