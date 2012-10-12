<?php 
/**
* Element displaying a category item in a tree list
*
* @param array $data
* @param int $depth => $depth ? $depth : count($stack),
* @param boolean $hasChildren
* @param int $numberOfDirectChildren
* @param int $numberOfTotalChildren
* @param array $firstChild
* @param array $lastChild
* @param boolean $hasVisibleChildren
*/
$catModelClass = 'Category';
$linkAttribs = array('escape' => false);
if (isset($data[$catModelClass]['description_'.TXT_LANG]) && !empty($data[$catModelClass]['description_'.TXT_LANG])) {
	$linkAttribs['title'] = $data[$catModelClass]['description_'.TXT_LANG];
}

$counter = '<span class="badge">'.$data[$catModelClass]['item_count'].'</span>';
// $counter = '<span class="item-count">('.$data[$catModelClass]['item_count'].')</span>';

$linkUrl = array('controller' => 'games', 'action' => 'index', $data[$catModelClass]['slug_'.TXT_LANG]);
if (isset($this->request->params['named']['platform']) && !empty($this->request->params['named']['platform'])) {
	$linkUrl['platform'] = $this->request->params['named']['platform'];
}

echo $this->Html->link($data[$catModelClass]['name_'.TXT_LANG].' '.$counter, $linkUrl, $linkAttribs);
?>