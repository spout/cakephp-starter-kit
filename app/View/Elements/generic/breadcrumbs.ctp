<?php 
if (rtrim(str_replace(TXT_LANG, '', $this->request->url), '/') !== '') {

	$moduleTitle = isset($moduleTitle) ? $moduleTitle : $title_for_layout;	
	
	$crumbs = array();
	
	$crumbs[__('main_title')] = '/';
	if (!in_array($this->request->params['controller'], array('pages', 'users'))) {
		$crumbs[$moduleTitle] = array('action' => 'index');
	} else {
		$crumbs[$title_for_layout] = '';
	}
	
	if (isset($catPath) && !empty($catPath)) {
		foreach ($catPath as $k => $c) {
			$crumbs[$c['Category']['name_'.TXT_LANG]] = array('action' => 'index', $c['Category']['slug_'.TXT_LANG]);
		}
	}
	
	if(!in_array($this->request->params['action'], array('index'))) {
		$crumbs[$title_for_layout] = null;
	}
	
	$lastKey = end(array_keys($crumbs));
	
	foreach ($crumbs as $k => $v) {
		if ($k === $lastKey && $this->request->params['action'] != 'view') {
			$this->Html->addCrumb(h($k));
		} else {
			$this->Html->addCrumb($k, $v);
		}
	}
	
	$breadcrumbs = $this->Html->getCrumbs('<span class="divider">&rsaquo;</span>');
}
?>
<?php if(isset($breadcrumbs) && !empty($breadcrumbs)):?>
<div class="breadcrumb">
	<?php echo $breadcrumbs;?>
</div>
<?php endif;?>