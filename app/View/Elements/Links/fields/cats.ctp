<?php 
for ($i = 1; $i <= 3; $i++) {
	$catPathVar = ($i == 1) ? 'catPath': 'catPath'.$i;
	
	if (isset(${$catPathVar})) {
		//$this->MyHtml->addCrumb(__('main_title'), '/'.TXT_LANG.'/');
		//$this->MyHtml->addCrumb($moduleTitle, array('action' => 'index'));
		
		foreach (${$catPathVar} as $c) {
			$this->MyHtml->addCrumb($c[$catModelClass]['name_'.TXT_LANG], array('action' => 'index', 'cat_slug' => $c[$catModelClass]['slug_'.TXT_LANG]));
		}
		
		echo '<p>'.$this->MyHtml->getCrumbs().'</p>';
	}
}
?>