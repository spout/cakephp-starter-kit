<?php $this->set('title_for_layout', __('Gestion des champs'));?>

<?php echo $this->Form->create($modelClass, array('type' => 'file'));?>

<div class="form-inputs-info">
<?php echo __('Options traduisibles');?> : <?php echo $this->Text->toList($translatableOptions, __('et'));?>.
</div>
<?php 
$jsonFields = array();
$count = 1;
foreach($this->request->data['CustomField'] as $key => $customField) {
	echo '<fieldset>';
	echo '<legend>'.__('Champ personnalisé').' '.$count.'</legend>';
	if (isset($customField['id'])) {
		echo $this->Form->hidden('CustomField.'.$key.'.id');
	}
	
	echo $this->Form->hidden('CustomField.'.$key.'.model', array('value' => $model));
	echo $this->Form->hidden('CustomField.'.$key.'.foreign_key', array('value' => $foreignKey));
	
	echo $this->Form->input('CustomField.'.$key.'.options', array('label' => 'Input options'));
	$jsonFields[] = $this->Form->domId(null, 'CustomField.'.$key.'.options');
	echo $this->Form->input('CustomField.'.$key.'.position', array('label' => 'Position', 'type' => 'text', 'size' => 2));
		
	echo '</fieldset>';
	
	$count++;
}

?>
<?php echo $this->Form->end(__('Enregistrer'));?>

<?php 
$this->Html->script('codemirror/lib/codemirror.js', false);
$this->Html->script('codemirror/mode/yaml/yaml.js', false);

$this->Html->css('codemirror/codemirror.css', null, array('inline' => false));

$previewUrl = $this->Html->url(array('action' => 'inputs', $model, $foreignKey));

$codemirrorJs = '';
foreach ($jsonFields as $domId) {
$codemirrorJs .= <<<EOT
	CodeMirror.fromTextArea(document.getElementById("{$domId}"), { lineNumbers: true });
EOT;
}

$scriptBlock = <<<EOT
$(function(){
	$codemirrorJs
	
	$('#preview').load("{$previewUrl}");
});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<h2><?php echo __('Prévisualisation');?></h2>
<div id="preview"></div>