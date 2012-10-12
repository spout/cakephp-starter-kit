<?php 
$json = array();
foreach ($events as $k => $event) {
	$details = '';
	if (isset($event[$modelClass]['city']) && !empty($event[$modelClass]['city'])) {
		$details .= '<p>'.$this->Html->image('flags/'.$event[$modelClass]['country'].'.gif').'&nbsp;'.h($event[$modelClass]['city']).'</p>';
	}
	$details .= '<p><span class="underline">'.__('Du').'</span>: '.$this->MyHtml->niceDate($event[$modelClass]['date_start'], '%A, %e %B %Y').'</p>';
	$details .= '<p><span class="underline">'.__('Au').'</span>: '.$this->MyHtml->niceDate($event[$modelClass]['date_end'], '%A, %e %B %Y').'</p>';
	
	$url = ($event[$modelClass]['date_end'] >= date('Y-m-d')) ? Router::url(array('action' => 'view', 'id' => $event[$modelClass]['id'], 'slug' => slug($event[$modelClass]['title']))) : '';
	$expired = ($event[$modelClass]['date_end'] >= date('Y-m-d')) ? '' : ' ('.__('expiré').')';
	
	$json[] = array(
			'title' => $event[$modelClass]['title'].$expired,
			'start' => $event[$modelClass]['date_start'],
			'end' => $event[$modelClass]['date_end'],
			'color' => '#'.$event[$modelClass]['color'],
			'textColor' => '#'.getContrastColor($event[$modelClass]['color']),
			'url' => $url,
			'details' => $details
		);
}
echo json_encode($json);
?>