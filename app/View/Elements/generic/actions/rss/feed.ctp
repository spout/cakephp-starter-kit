<?php
$titles = array(__('main_title'));
if (isset($moduleTitle)) {
	$titles[] = $moduleTitle;
}
$titles[] = __('RSS');

$this->set('title_for_layout', h(join(' : ', $titles)));

foreach ($items as $item) {
	$title = getPreferedLang($item[$modelClass], 'title');
	$description = $this->Text->truncate(getPreferedLang($item[$modelClass], 'description'), 200, array('ending' => '...', 'exact'  => true, 'html' => true));
	
	echo $this->Rss->item(array(), array(
		'title' => $title,
		'link'  => Router::url(array('lang' => TXT_LANG, 'action' => 'view', 'id' => $item[$modelClass]['id'], 'slug' => slug($title)), true),
		'description' => $description,
		'pubDate' => $item[$modelClass]['created']
	));
}