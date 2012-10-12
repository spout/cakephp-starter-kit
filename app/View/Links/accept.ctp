<?php 
$this->set('title_for_layout', __('Valider une fiche'));
$title = getPreferedLang(${$singularVar}[$modelClass], 'title');
?>
<?php echo $this->Form->create($modelClass, array('url' => array('action' => 'accept', ${$singularVar}[$modelClass]['id'])));?>
<fieldset>
<legend><?php echo h($title);?></legend>
<?php 
$urlView = $this->Html->url(array('controller' => 'links', 'action' => 'view', 'id' => ${$singularVar}[$modelClass]['id'], 'slug' => slug($title)));
//$fullBaseUrl = FULL_BASE_URL;
$urlLinkToUs = $this->Html->url(array('controller' => 'pages', 'action' => 'display', 'faire-un-lien'));
$message = <<<EOT
Bonjour {${$singularVar}['User']['firstname']} {${$singularVar}['User']['lastname']},

L'activité "{$title}" que vous avez proposé vient d'être acceptée dans notre annuaire:
$urlView

Si vous appréciez le service, vous pouvez faire un lien:
$urlLinkToUs

Bien à vous
Le Webmaster
EOT;
?>
<?php echo $this->Form->input('email', array('label' => __('A'), 'size' => 30, 'default' => ${$singularVar}['User']['email']));?>
<?php echo $this->Form->input('subject', array('label' => __('Sujet'), 'size' => 50, 'default' => $title));?>
<?php echo $this->Form->input('message', array('label' => __('Message'), 'rows' => 6, 'cols' => 80, 'default' => $message));?>
</fieldset>
<?php echo $this->Form->end(__('Envoyer'));?>