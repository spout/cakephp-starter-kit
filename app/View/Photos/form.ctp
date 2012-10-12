<?php $this->set('title_for_layout', empty($id) ? __('Ajouter une galerie de photos') : __('Modifier une galerie de photos'));?>

<p>
<?php echo $this->Html->link(__('Gestionnaire de fichiers'), array('controller' => 'pages', 'action' => 'display', 'filemanager'));?>
</p>

<?php 
$this->Html->script('jquery/ui/i18n/jquery.ui.datepicker-'.TXT_LANG.'.js', false);
$randomColor = sprintf("%02X%02X%02X", mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));

$buttonImage = FULL_BASE_URL.$this->request->webroot.'img/calendar.png';

$scriptBlock = <<<EOT
$(function(){
	$.datepicker.regional['{$this->request->params['lang']}'];
	$('input#{$modelClass}Date').datepicker({onSelect: dateSelected, dateFormat: 'yy-mm-dd', showOn: 'both', buttonImage: '{$buttonImage}', buttonImageOnly: true, altField: '#PhotoDateAlt', altFormat: 'DD, d MM, yy', changeMonth: true, changeYear: true});
});

dateSelected = function(dateText, inst){
	$('#' + inst['id'] + 'Alt').show();
}

EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));

$photosPath = WWW_ROOT.$photosBasePath;
$dirs = array_values(array_diff(scandir($photosPath), array('.', '..')));

$paths = array();
foreach ($dirs as $d) {
	$paths[$d] = $d;
}
?>

<?php echo $this->Form->create();?>
<?php if(!empty($id)):?>
	<?php echo $this->Form->hidden('id');?>
<?php endif;?>

<?php echo $this->Form->input('title', array('label' => __('Titre'), 'size' => 60, 'maxlength' => 70));?>
<?php 
$dateAltInput = '<input type="text" value="" id="%sAlt" size="30" style="display:none;border:0;background-color:transparent;" />';
?>
<?php echo $this->Form->input('date', array('label' => __('Date'), 'type' => 'text', 'size' => 10, 'after' => sprintf($dateAltInput, $modelClass.'Date')));?>
<?php echo $this->Form->input('description', array('label' => __('Description'), 'rows' => 8, 'cols' => 60));?>
<?php echo $this->Form->input('author', array('label' => __('Auteur des photos'), 'size' => 60));?>
<?php echo $this->Form->input('dir', array('label' => __('Chemin'), 'options' => $paths, 'empty' => '-'));?>

<?php echo $this->Form->submit(empty($id) ? __('Ajouter') : __('Modifier'));?>
<?php echo $this->Form->end();?>