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
$categoryModelClass = 'Category';
$linkAttribs = (isset($data[$categoryModelClass]['description_'.TXT_LANG]) && !empty($data[$categoryModelClass]['description_'.TXT_LANG])) ? array('title' => $data[$categoryModelClass]['description_'.TXT_LANG]) : array();
?>
<?php if(!empty($data[$categoryModelClass]['item_count'])):?><?php echo $this->Html->link($data[$categoryModelClass]['name_'.TXT_LANG], array('action' => 'index', 'cat_slug' => $data[$categoryModelClass]['slug_'.TXT_LANG]), $linkAttribs);?><?php else:?><?php echo h($data[$categoryModelClass]['name_'.TXT_LANG]);?><?php endif;?>&nbsp;<span class="item-count"><?php echo $data[$categoryModelClass]['item_count'];?></span>