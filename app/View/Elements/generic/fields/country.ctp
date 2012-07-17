<?php 
if(isset($item['Country']['name_'.TXT_LANG]) && !empty($item['Country']['name_'.TXT_LANG])){
	echo $this->Html->image('flags/'.$item['Country']['code'].'.gif').'&nbsp;'.$item['Country']['name_'.TXT_LANG];
}
elseif (!empty($item[$modelClass]['country'])) {
	echo $this->Html->image('flags/'.$item[$modelClass]['country'].'.gif');
}
?>