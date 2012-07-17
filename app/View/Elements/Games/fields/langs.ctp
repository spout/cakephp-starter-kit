<?php 
if (isset($item[$modelClass]['langs']) && !empty($item[$modelClass]['langs'])) {
	echo '<ul>';
	foreach ($item[$modelClass]['langs'] as $v) {
		echo '<li>';
		echo h($gamesLanguages[$v]);
		echo '</li>';
	}
	echo '</ul>';
}
?>