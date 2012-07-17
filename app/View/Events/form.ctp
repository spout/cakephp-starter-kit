<?php $this->set('title_for_layout', ($id) ? __('Modifier un événement') : __('Ajouter un événement'));?>
<?php echo $this->Form->create($modelClass);?>
<?php if($id):?>
	<?php echo $this->Form->hidden('id', array('value' => $id));?>
<?php endif;?>

<?php 
$this->Html->script('jquery/ui/i18n/jquery.ui.datepicker-'.TXT_LANG.'.js', false);
$randomColor = sprintf("%02X%02X%02X", mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));

$minDateY = date('Y');
$minDateM = date('m');
$minDateD = date('d');

$buttonImage = FULL_BASE_URL.$this->request->webroot.'img/calendar.png';

$scriptBlock = <<<EOT
$(function(){
	$.datepicker.regional['{$this->request->params['lang']}'];
	$('input#{$modelClass}DateStart').datepicker({onSelect: dateSelected, dateFormat: 'yy-mm-dd', minDate: new Date($minDateY, $minDateM - 1, $minDateD), showOn: 'both', buttonImage: '{$buttonImage}', buttonImageOnly: true, altField: '#EventDateStartAlt', altFormat: 'DD, d MM, yy', changeMonth: true, changeYear: true});
	$('input#{$modelClass}DateEnd').datepicker({onSelect: dateSelected, dateFormat: 'yy-mm-dd', minDate: new Date($minDateY, $minDateM - 1, $minDateD), showOn: 'both', buttonImage: '{$buttonImage}', buttonImageOnly: true, altField: '#EventDateEndAlt', altFormat: 'DD, d MM, yy', changeMonth: true, changeYear: true});
});

dateSelected = function(dateText, inst){
	$('#' + inst['id'] + 'Alt').show();
	$('input#{$modelClass}DateEnd').datepicker("option", "minDate", new Date(inst.currentYear, inst.currentMonth, inst.currentDay) );
}

EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<?php echo $this->element('generic/who-form');?>

<fieldset>
	<legend><?php echo __("L'événement");?></legend>
	
	<?php echo $this->Form->input('title', array('label' => __('Titre'), 'size' => 60, 'maxlength' => 70));?>
	<p class="form-inputs-info">
	<?php echo __('Entrez la date au format YYYY-MM-DD');?>
	</p>
	<?php 
	$dateAltInput = '<input type="text" value="" id="%sAlt" size="30" style="display:none;border:0;background-color:transparent;" />';
	?>
	<?php echo $this->Form->input('date_start', array('label' => __('Date de début'), 'type' => 'text', 'size' => 10, 'after' => sprintf($dateAltInput, $modelClass.'DateStart')));?>
	<?php echo $this->Form->input('date_end', array('label' => __('Date de fin'), 'type' => 'text', 'size' => 10, 'after' => sprintf($dateAltInput, $modelClass.'DateEnd')));?>
	<?php echo $this->Form->input('description', array('label' => __('Description'), 'rows' => 8, 'cols' => 35));?>
	
	<fieldset>
	<legend><?php echo __("Où se déroule l'événement ?");?></legend>
	<?php echo $this->element('google-maps-autocomplete');?>
	</fieldset>
	
	<?php if($this->Auth->isAdmin()):?>
		<?php $this->Html->script('jscolor/jscolor.js', false);?>
		<fieldset>
		<legend>Admin</legend>
		<?php echo $this->Form->input('color', array('label' => __('Couleur'), 'type' => 'text', 'size' => 6, 'default' => $randomColor, 'class' => 'color', 'style' => 'background-image: none;'));?>
		<?php echo $this->Form->input('link_id', array('label' => __('Link ID'), 'type' => 'text', 'size' => 5));?>
		</fieldset>
	<?php else:?>
		<?php echo $this->Form->hidden('color', array('value' => $randomColor));?>
	<?php endif;?>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha', false);?>

<?php echo $this->Form->end(($id) ? __('Modifier') : __('Ajouter'));?>