<?php $this->set('title_for_layout', ($id) ? __('Modifier une annonce') : __('Placer une annonce'));?>
<?php echo $this->Form->create($modelClass, array('type' => 'file', 'novalidate' => true));?>
<?php if($id):?>
	<?php echo $this->Form->hidden('id', array('value' => $id));?>
<?php endif;?>

<?php
$customFieldsUrl = $this->Html->url(array('controller' => 'custom_fields', 'action' => 'inputs'));

$scriptBlock = <<<EOT
$(function() {
	$('#{$modelClass}Email').blur(function() {
		$('#{$modelClass}EmailContact').val($('#{$modelClass}Email').val());
	});
	
	/*$('#{$modelClass}CatId').change(function() {
		var postData = {model: '{$modelClass}Cat', foreign_key: $(this).val()};
		$('#customFields').load('{$customFieldsUrl}', postData, function() {
			
		});
	});*/
});

function price_type(){
	var priceTypeFixedChecked = $('#{$modelClass}PriceTypeFixed').prop('checked');
	var priceTypeTalkChecked = $('#{$modelClass}PriceTypeTalk').prop('checked');
	
	if (priceTypeFixedChecked || priceTypeTalkChecked) {
		$('#price-input').show();
	} else {
		$('#price-input').hide();
		$('input#{$modelClass}Price').val('');
	}
	
	if (priceTypeTalkChecked) {
		$('#price-type-talk-info').slideDown();
	} else {
		$('#price-type-talk-info').slideUp();
	}
}
EOT;

$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<?php echo $this->element('generic/who-form');?>

<fieldset>
	<legend><?php echo __("L'annonce");?></legend>
	
	<?php echo $this->Form->input('category_id', array('label' => __('Catégorie'), 'empty' => '-', 'escape' => false));?>
	<?php echo $this->Form->input('type', array('legend' => __('Type'), 'options' => array('offer' => __('J\'offre'), 'demand' => __('Je recherche')), 'default' => 'offer', 'type' => 'radio', 'class' => 'radio'));?>
	<?php echo $this->Form->input('title', array('label' => __('Titre'), 'size' => 60, 'maxlength' => 70));?>
	<?php echo $this->Form->input('description', array('label' => __('Description'), 'rows' => 8, 'cols' => 60));?>
	
	<?php /*if(Auth::hasRole(ROLE_ADMIN)):?>
		<div id="customFields"></div>
	<?php endif;*/?>
	
	<fieldset>
		<legend><?php echo __('Aspects financiers');?></legend>
		<?php echo $this->Form->input('price_type', array('legend' => __('Option du prix'), 'options' => $priceTypes, 'default' => 'fixed', 'type' => 'radio', 'onclick' => 'price_type();', 'class' => 'radio'));?>
		<p class="text-warning" id="price-type-talk-info" style="display:none;">
			<?php echo __('Pour l\'option du prix A discuter, le champ prix est à titre indicatif et n\'est pas obligatoire.');?>
		</p>

		<div id="price-input">
		<?php echo $this->Form->input('price', array('label' => __('Prix'), 'type' => 'text', 'size' => 8));?>
		</div>
	</fieldset>
	
	<fieldset>
		<legend><?php echo __("Où se trouve le bien de l'annonce ?");?></legend>
		<?php echo $this->element('google-maps-autocomplete');?>
		<?php //echo $this->element('jquery-addresspicker');?>
	</fieldset>
	
	<fieldset>
		<legend><?php echo __("Photos");?></legend>

		<div class="text-warning">
		<?php echo __('Les annonces avec photo sont les plus visitées.<br />Poids: 500 Ko par photo maximum.<br />La photo 1 est la photo qui sera affichée dans les résultats.');?>
		</div>
		<?php for($i = 1; $i <= 3; $i++):?>
			<div class="floatl">
			<?php echo $this->Form->input('photo_'.$i, array('type' => 'file', 'label' => sprintf(__('Photo %d'), $i)));?>
			</div>
			<?php if($id && isset($this->request->data[$modelClass]['photo_'.$i])):?>
				<div class="floatl">
					<?php echo $this->element('phpthumb', array('src' => 'files/annonces/photo_'.$i.'/'.$id.'/'.$this->request->data[$modelClass]['photo_'.$i], 'w' => 50, 'h' => 50, 'zc' => 1));?>
				</div>
			<?php endif;?>
			<div class="clear"></div>
		<?php endfor;?>
	</fieldset>
	
	<fieldset>
		<legend><?php echo __('Vidéo');?></legend>
		<div class="text-warning">
		<?php echo __('Vous pouvez indiquer un lien vidéo YouTube, Dailymotion, Vimeo, Metacafe,...');?>
		</div>
		<?php echo $this->Form->input('video', array('label' => __('Lien vidéo de présentation'), 'size' => 45, 'placeholder' => 'http://'));?>
	</fieldset>
	
	<fieldset>
		<legend><?php echo __("Informations de contact");?></legend>
		<?php echo $this->Form->input('email_contact', array('label' => __('E-mail'), 'size' => 45));?>

		<div class="text-warning">
		<?php echo $this->element('generic/phone-info');?>
		</div>

		<?php echo $this->Form->input('phone', array('label' => __('Téléphone'), 'size' => 45));?>
		<?php echo $this->Form->input('skype', array('label' => __('Pseudo Skype'), 'size' => 45));?>
	</fieldset>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha', false);?>

<?php echo $this->Form->end(($id) ? __('Modifier') : __('Ajouter'));?>