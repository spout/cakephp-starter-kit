<?php 
$address = array();
if (isset($item[$modelClass]['address']) && !empty($item[$modelClass]['address'])) {
	$address[] = $item[$modelClass]['address'];
}

if (isset($item[$modelClass]['city']) && !empty($item[$modelClass]['city'])) {
	$address[] = (isset($item[$modelClass]['postcode']) && !empty($item[$modelClass]['postcode'])) ? $item[$modelClass]['postcode'].' '.$item[$modelClass]['city'] : $item[$modelClass]['city'];
}

if (isset($item['Country']['name_'.TXT_LANG]) && !empty($item['Country']['name_'.TXT_LANG])) {
	$address[] = $this->Html->image('flags/'.$item['Country']['code'].'.gif').'&nbsp;'.$this->Html->link($item['Country']['name_'.TXT_LANG], array('action' => 'index', 'cat_slug' => 0, 'country' => $item['Country']['code'].'-'.slug($item['Country']['name_'.TXT_LANG])));
} elseif (!empty($item[$modelClass]['country'])) {
	$address[] = $this->Html->image('flags/'.$item['Country']['code'].'.gif').'&nbsp;'.$this->Html->link($item[$modelClass]['country'], array('action' => 'index', 'cat_slug' => 0, 'country' => $item['Country']['code'].'-'.slug($item[$modelClass]['country'])));
}
echo join('<br />', $address);
?>