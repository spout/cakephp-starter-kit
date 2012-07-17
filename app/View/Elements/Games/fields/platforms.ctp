<?php 
if (isset($item[$modelClass]['platforms']) && !empty($item[$modelClass]['platforms'])) {
	echo '<ul>';
	foreach ($item[$modelClass]['platforms'] as $v) {
		echo '<li>';
		echo $this->Html->Image('gamesdir/os/'.$v.'.png').' '.h($platforms[$v]);
		echo '</li>';
	}
	echo '</ul>';
}
?>