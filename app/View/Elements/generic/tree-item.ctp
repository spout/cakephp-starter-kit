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
$linkAttribs = (isset($data[$catModelClass]['description_'.TXT_LANG]) && !empty($data[$catModelClass]['description_'.TXT_LANG])) ? array('title' => $data[$catModelClass]['description_'.TXT_LANG]) : array();
?>
<?php if(!empty($data[$catModelClass]['item_count'])):?><?php echo $this->Html->link($data[$catModelClass]['name_'.TXT_LANG], array('action' => 'index', 'cat_slug' => $data[$catModelClass]['slug_'.TXT_LANG]), $linkAttribs);?><?php else:?><?php echo h($data[$catModelClass]['name_'.TXT_LANG]);?><?php endif;?>&nbsp;<span class="item-count">(<?php echo $data[$catModelClass]['item_count'];?>)</span>