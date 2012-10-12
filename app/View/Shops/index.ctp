<?php
$titles = array();

if (!isset($this->request->params['named']['id']) && !isset($this->request->params['named']['keywords']) && !isset($this->request->params['named']['categoryId'])) {
	$titles[] = __('Boutique en ligne - Matériel d\'équitation pour le cavalier et le cheval');		
} else {
	$titles[] = $moduleTitle;
	if (isset($this->request->params['named']['id']) && isset($link)) {
		$titles[] = getPreferedLang($link['Link'], 'title');
	}
	
	if (isset($this->request->params['named']['categoryId'])) {
		$titles[] = $categories[$this->request->params['named']['categoryId']];
	}
	
	if (isset($this->request->params['named']['keywords'])) {
		$titles[] = urldecode($this->request->params['named']['keywords']);
	}
}

$this->set('title_for_layout', h(join(' - ', $titles)));
?>

<?php echo $this->Form->create();?>
<fieldset>
<div class="floatl">
<?php echo $this->Form->input('keywords', array('label' => __('Mot(s) clé(s)'), 'size' => 40, 'after' => '<br />'.__('Selle, tapis, guêtres, étriers, bridon, couverture, ...')));?>
</div>
<div class="floatl">
<?php echo $this->Form->input('categoryId', array('label' => __('Catégorie'), 'options' => $categories, 'empty' => '-'));?>
</div>
<div class="clear"></div>
<?php if(isset($this->request->params['named']['id']) && !empty($this->request->params['named']['id'])):?>
	<?php echo $this->Form->hidden('id', array('value' => $this->request->params['named']['id']));?>
<?php endif;?>
</fieldset>
<?php echo $this->Form->end(__('Recherche'));?>
<?php if(isset($shops) && !empty($shops)):?>
	<?php echo $this->element('paginator-counter');?>
	<?php echo $this->element('Shops'.DS.'items-browse');?>
	<?php echo $this->element('paginator-links');?>
<?php endif;?>