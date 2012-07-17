<?php
$this->set('title_for_layout', __('Gestionnaire de fichiers'));

$elFinderPath = '/elFinder/';
$this->Html->css($elFinderPath.'css/elfinder.min', null, array('inline' => false));
$this->Html->script($elFinderPath.'js/elfinder.min.js', false);

$this->Html->script($elFinderPath.'js/i18n/elfinder.'.$this->request->params['lang'].'.js', false);
$connectorUrl = Router::url($elFinderPath.'php/my-connector.php', true);
$scriptBlock = <<<EOT
$(function(){
	var elf = $('#elfinder').elfinder({
		lang: '{$this->request->params['lang']}',
		url : '{$connectorUrl}'
	}).elfinder('instance');
});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<div id="elfinder"></div>

<?php /*
<?php 
$this->set('title_for_layout', __('Gestionnaire de fichiers'));
$types = array(
	'images' => __('Images'),
	'flash' => __('Flash'),
	'files' => __('Fichiers')
);

$kcFinderUrl = FULL_BASE_URL.$this->request->webroot.'kcfinder/browse.php';
$scriptBlock = <<<EOT
$(function(){
	loadKCF();
});

function loadKCF(){
    var lang = '{$this->request->params['lang']}';
    var type = $('input:radio[name=data[type]]:checked').val();
    
    $('#kcfinder').html('<iframe src="{$kcFinderUrl}?type=' + type + '&dir=' + type + '&lng=' + lang + '" frameborder="0" width="100%" height="400"><\/iframe>');
};
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));

echo $this->Form->create(false);
echo $this->Form->input('type', array('legend' => __('Type'), 'options' => $types, 'type' => 'radio', 'empty' => false, 'default' => 'images', 'onchange' => 'loadKCF();'));
echo $this->Form->end();
?>

<div id="kcfinder"></div>
*/?>