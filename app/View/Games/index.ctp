<?php //echo $this->element('generic/actions/index');?>
<?php 
$title_for_layout = array();
if (isset($category)) {
	$title_for_layout[] = __('Jeux à télécharger');
	$title_for_layout[] = $category['Category']['name_'.TXT_LANG];
} else {
	$title_for_layout[] = __('Jeux PC à télécharger');
}

if (isset($this->request->params['named']['platform']) && isset($platforms[$this->request->params['named']['platform']])) {
	$title_for_layout[] = $platforms[$this->request->params['named']['platform']];
}

$this->set('title_for_layout', join(' - ', $title_for_layout));
?>
<?php echo $this->element('generic/items-browse', array('itemsBrowseBefore' => '<ul class="thumbnails">', 'itemsBrowseAfter' => '</ul>'));?>