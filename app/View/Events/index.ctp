<?php 
$year = isset($this->request->params['year']) ? $this->request->params['year'] : date('Y');
$titles = array(__('Agenda équestre'));

if (isset($this->request->params['month'])) {
	$titles[] = strftime('%B', mktime(0, 0, 0, $this->request->params['month'], 1, $year));
}

$titles[] = $year;
$this->set('title_for_layout', join(' ', $titles));
?>
<?php if(isset($items) && !empty($items)):?>
	<div class="<?php echo $this->request->params['controller'];?>-browse">
	<?php 
	for ($m = 1; $m <= 12; $m++) {
		$m = sprintf('%02s', $m);
		$monthStart = mktime(0, 0, 0, $m, 1, $year);
		$monthEnd = mktime(0, 0, 0, $m + 1, 0, $year);//Le dernier jour d'un mois peut être décrit comme le jour "0" du mois suivant
		
		$outMonth = '';
		if (date('Ym') <= $year.$m) {//outdated month
			foreach ($items as $k => $item) {
				if(	($monthStart >= strtotime($item[$modelClass]['date_start']) && $monthStart <= strtotime($item[$modelClass]['date_end']))
					||
					($monthEnd >= strtotime($item[$modelClass]['date_start']) && $monthEnd <= strtotime($item[$modelClass]['date_end']))
					||
					(strtotime($item[$modelClass]['date_start']) >= $monthStart && strtotime($item[$modelClass]['date_start']) <= $monthEnd)
					||
					(strtotime($item[$modelClass]['date_end']) >= $monthStart && strtotime($item[$modelClass]['date_end']) <= $monthEnd)
					) {
					$outMonth .= $this->element($this->request->controller.'/items-browse-item', array('item' => $item, 'k' => $k));
				}
			}
		}
		if (!empty($outMonth)) {
			echo '<h2>'.$this->Html->link(ucfirst(strftime('%B %Y', $monthStart)), array('country' => 0, 'year' => $year, 'month' => $m)).'</h2>';
			echo $outMonth;
		}
	}
	?>	
	</div>
<?php endif;?>

<?php if((isset($this->request->params['year']) && isset($this->request->params['month'])) || !isset($this->request->params['year'])):?>
<?php
$this->Html->script('fullcalendar/fullcalendar.min.js', false);
$this->Html->css('fullcalendar/fullcalendar', null, array('inline' => false));

$this->Html->script('jquery/jquery.qtip.min.js', false);
$this->Html->css('qtip/jquery.qtip', null, array('inline' => false));

$monthNames = $monthNamesShort = array();
for ($m = 1; $m <= 12; $m++) {
	$time = mktime(0, 0, 0, $m, 1, date('Y'));
	$monthNames[] = ucfirst(strftime('%B', $time));
	$monthNamesShort[] = ucfirst(strftime('%b', $time));
}

$dayNames = $dayNamesShort = array();
for ($d = 1; $d <= 7; $d++) {
	$time = mktime(0, 0, 0, 8, 6 + $d, 2011);//2011-08-07 was sunday
	$dayNames[] = ucfirst(strftime('%A', $time));
	$dayNamesShort[] = ucfirst(strftime('%a', $time));
}

$dayNames = json_encode($dayNames);
$dayNamesShort = json_encode($dayNamesShort);
$monthNames = json_encode($monthNames);
$monthNamesShort = json_encode($monthNamesShort);
$buttonTextToday = __('Aujourd\'hui');
$buttonTextMonth = __('Mois');
$buttonTextWeek = __('Semaine');
$buttonTextDay = __('Jour');
$allDayText = __('Toute la journée');
$eventsUrl = Router::url(array('action' => 'fullcalendar.json'), true);
//$eventsUrl = Router::url(array('action' => 'fullcalendar', 'ma.json'), true);

$year = (isset($this->request->params['year'])) ? $this->request->params['year'] : date('Y');
$month = (isset($this->request->params['month'])) ? $this->request->params['month'] : date('m');
$month = $month - 1;

$scriptBlock = <<<EOT
	$(function(){
		$('#calendar').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			year:{$year},
			month:{$month},
			firstDay:1,
			dayNames:{$dayNames},
		    dayNamesShort:{$dayNamesShort},
		    monthNames:{$monthNames},
		    monthNamesShort:{$monthNamesShort},
		    timeFormat:'H(:mm)',
		    axisFormat:'HH(:mm)',
		    titleFormat:{
			    month: 'MMMM yyyy',                             // September 2009
			    week: "MMMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}", // Sep 7 - 13 2009
			    day: 'dddd, d MMMM, yyyy'                  // Tuesday, Sep 8, 2009
			},
		    columnFormat:{
			    month: 'ddd',    // Mon
			    week: 'ddd d/M', // Mon 9/7
			    day: 'dddd d MMMM'  // Monday 9/7
			},
			allDayText:"{$allDayText}",
		    weekMode:'liquid',
		    buttonText:{
			    prev:     '&nbsp;&#9668;&nbsp;',  // left triangle
			    next:     '&nbsp;&#9658;&nbsp;',  // right triangle
			    prevYear: '&nbsp;&lt;&lt;&nbsp;', // <<
			    nextYear: '&nbsp;&gt;&gt;&nbsp;', // >>
			    today:    "{$buttonTextToday}",
			    month:    "{$buttonTextMonth}",
			    week:     "{$buttonTextWeek}",
			    day:      "{$buttonTextDay}"
			},
			eventSources: [
					{
						url: '{$eventsUrl}',
						type: 'POST',
					}
		    ],
			eventRender: function(event, element) {
				element.qtip({
					//content: event.details,
					content: {
						text: event.details,
						title: {
							text: event.title
						}
					},
					position: {
						target: 'mouse',
						adjust: {
							x: 10,  y: 10
						}
					},
					style: {
						classes: 'ui-tooltip-shadow',
						tip: 'left top',
						widget: true,
						width: 400
					},
				});
			}
	    });	
	});   
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<div id="calendar"></div>
<?php endif;?>