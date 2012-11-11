<?php $this->set('title_for_layout', ($this->request->params['action'] == 'edit') ? __('Modifier une activité') : __('Proposer une activité'));?>

<?php echo $this->Form->create();?>
<?php if(isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])):?>
	<?php echo $this->Form->hidden('id', array('value' => $this->request->params['pass'][0]));?>
<?php else:?>
	<div class="alert alert-error" style="font-size: 20px;">
		<?php echo __("Si votre activité n'a aucun rapport avec l'équitation, c'est inutile de nous proposer votre site Web, la fiche serait supprimée sans notification.");?>
	</div>
<?php endif;?>

<?php //echo $this->element('generic/who-form');?>

<?php if(Auth::hasRole(ROLE_ADMIN)):?>
<?php 
$ebayGlobalIds = array(
	'EBAY-AT',
	'EBAY-AU',
	'EBAY-CH',
	'EBAY-DE',
	'EBAY-ENCA',
	'EBAY-ES',
	'EBAY-FR',
	'EBAY-FRBE',
	'EBAY-FRCA',
	'EBAY-GB',
	'EBAY-HK',
	'EBAY-IE',
	'EBAY-IN',
	'EBAY-IT',
	'EBAY-MOTOR',
	'EBAY-MY',
	'EBAY-NL',
	'EBAY-NLBE',
	'EBAY-PH',
	'EBAY-PL',
	'EBAY-SG',
	'EBAY-US',
);

$tmp = array();
foreach ($ebayGlobalIds as $v) {
	$tmp[$v] = $v;
}
$ebayGlobalIds = $tmp;
?>
<fieldset>
	<legend><?php echo __('Admin');?></legend>
	<fieldset>
		<legend>eBay</legend>
		<?php echo $this->Form->input('ebay_store_name', array('label' => __('Nom de la boutique')));?>
		<?php echo $this->Form->input('ebay_global_id', array('label' => __('Global ID'), 'options' => $ebayGlobalIds, 'empty' => '-'));?>
	</fieldset>
	<?php echo $this->Form->input('awards', array('label' => __('Points'), 'type' => 'text'));?>
</fieldset>
<?php endif;?>

<fieldset>
	<legend><?php echo __('L\'activité');?></legend>
	
	<?php /*echo $this->Form->input('Cat', array('label' => __('Catégorie'), 'size' => 10, 'escape' => false));?>
	
	<?php for($i = 1; $i <= 3; $i++):?>
		<?php echo $this->Form->input(($i == 1) ? 'cat_id' : 'cat_id_'.$i, array('label' => sprintf(__('Catégorie %d'), $i), 'options' => $cats, 'empty' => '-', 'default' => ($i == 1 && !empty($catId)) ? $catId : '', 'escape' => false));?>
	<?php endfor;*/?>
	
	<?php echo $this->Form->input('Category', array('label' => __('Catégories'), 'size' => 10));?>
	<?php /*echo $this->Form->input('category_id_2', array('label' => __('Catégorie %d', 2), 'options' => $categories, 'empty' => '-'));?>
	<?php echo $this->Form->input('category_id_3', array('label' => __('Catégorie %d', 3), 'options' => $categories, 'empty' => '-'));*/?>
	
	<div class="text-warning">
		<?php echo __('Indiquez un titre clair et précis, qui vous différencie des autres, tel que le nom de votre entreprise.<br />Exemples <strong>non-valables</strong>:<ul><li>Vente de chevaux</li><li>Construction de boxes</li></ul>Exemples <strong>valables</strong>:<ul><li>Dupont - Vente de chevaux</li><li>Dupond - Construction de boxes</li></ul>');?>
	</div>
	<?php
	$languages = Configure::read('Config.languages');
	echo $this->Form->input('title_'.TXT_LANG, array('label' => __('Titre').' '.strtolower($languages[TXT_LANG]['language']), 'size' => 60, 'maxlength' => 70));
	if (Auth::hasRole(ROLE_ADMIN)) {
		$otherLanguages = $languages;
		unset($otherLanguages[TXT_LANG]);
		foreach($otherLanguages as $k => $l){
			echo $this->Form->input('title_'.$k, array('label' => __('Titre').' '.strtolower($languages[$k]['language']), 'size' => 60, 'maxlength' => 70));
		}
	}
	?>
	<div class="text-warning">
		<?php echo __("Veuillez écrire une description <strong>unique et originale</strong>, évitez les copier/coller d'une description de votre site.");?>
	</div>
	<?php
	echo $this->Form->input('description_'.TXT_LANG, array('label' => __('Description').' '.strtolower($languages[TXT_LANG]['language']), 'rows' => 8, 'cols' => 60));
	if (Auth::hasRole(ROLE_ADMIN)) {
		$otherLanguages = $languages;
		unset($otherLanguages[TXT_LANG]);
		foreach($otherLanguages as $k => $l){
			echo $this->Form->input('description_'.$k, array('label' => __('Description').' '.strtolower($languages[$k]['language']), 'rows' => 8, 'cols' => 60));
		}
	}
	?>
	<fieldset>
		<legend><?php echo __('Liens');?></legend>
		<?php echo $this->Form->input('url', array('label' => __('Site Web'), 'size' => 45, 'default' => 'http://'));?>
		<div class="text-warning">
			<?php echo __('Pour la vidéo de présentation, vous pouvez indiquer un lien vidéo YouTube, Dailymotion, Vimeo, Metacafe,...');?>
		</div>
		<?php echo $this->Form->input('video', array('label' => __('Lien vidéo de présentation'), 'size' => 45, 'default' => 'http://'));?>
	</fieldset>
	<fieldset>
		<legend><?php echo __("Où se trouve l'activité ?");?></legend>
		<?php echo $this->Form->input('country', array('label' => __('Pays'), 'options' => $this->MyHtml->getAlphabetListArray($countries), 'empty' => '-'));?>
		<?php echo $this->Form->input('city', array('label' => __('Localité'), 'size' => 45));?>
		<?php echo $this->Form->input('address', array('label' => __('Adresse (rue, n<sup>o</sup>)'), 'size' => 45));?>
		<?php echo $this->Form->input('postcode', array('label' => __('Code postal'), 'size' => 5));?>
	</fieldset>
	<fieldset>
		<legend><?php echo __("Informations de contact");?></legend>
		<?php echo $this->Form->input('email_contact', array('label' => __('E-mail'), 'size' => 45));?>
		<div class="text-warning">
			<?php echo $this->element('generic/phone-info');?>
		</div>
		<?php echo $this->Form->input('phone', array('label' => __('Téléphone'), 'size' => 45));?>
		<?php echo $this->Form->input('phone_2', array('label' => __('Téléphone').' n<sup>o</sup> 2', 'size' => 45));?>
		<?php echo $this->Form->input('mobile', array('label' => __('Mobile'), 'size' => 45));?>
		<?php echo $this->Form->input('mobile_2', array('label' => __('Mobile').' n<sup>o</sup> 2', 'size' => 45));?>
		<?php echo $this->Form->input('fax', array('label' => __('Fax'), 'size' => 45));?>
		<?php echo $this->Form->input('skype', array('label' => __('Pseudo Skype'), 'size' => 45));?>
	</fieldset>
</fieldset>
<?php echo $this->MyHtml->captcha('captcha', false);?>

<?php echo $this->Form->end(($this->request->params['action'] == 'edit') ? __('Modifier') : __('Ajouter'));?>