<?php 
$paginatorParams = $this->Paginator->params();
if ($paginatorParams['pageCount'] > 1) {
	$paginatorLinks = '';
	$sep = '';
	
	$labels = array(
		'first' => array(
			'anchor' => '&lt;&lt;',
			'title' => __('Première page')
		),
		'prev' => array(
			'anchor' => '&lt;',
			'title' => __('Page précédente')
		),
		'next' => array(
			'anchor' => '&gt;',
			'title' => __('Page suivante')
		),
		'last' => array(
			'anchor' => '&gt;&gt;',
			'title' => __('Dernière page')
		)
	);

	$first = $this->Paginator->first($labels['first']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['first']['title']));
	$prev = $this->Paginator->prev($labels['prev']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['prev']['title']));
	$numbers = $this->Paginator->numbers(array('modulus' => 8, 'separator' => $sep, 'tag' => 'li'));
	$next = $this->Paginator->next($labels['next']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['next']['title']));
	$last = $this->Paginator->last($labels['last']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['last']['title']));
	
	if (!empty($first)) {
		$paginatorLinks .= $first.$sep;
	}
	
	if ($this->Paginator->hasPrev() && !empty($prev)) {
		$paginatorLinks .= $prev.$sep;
	}
	
	if (!empty($numbers)) {
		$paginatorLinks .= $numbers;
	}
	
	if ($this->Paginator->hasNext() && !empty($next)) {
		$paginatorLinks .= $sep.$next;
	}
	
	if (!empty($last)) {
		$paginatorLinks .= $sep.$last;
	}
	
	$paginatorLinks = str_replace('/page:1"','"', $paginatorLinks);// remove /index/page:1 duplicate content
	$paginatorLinks = str_replace('/index"','"', $paginatorLinks);// remove /index duplicate content
	
	// $this->Html->meta('prev', 'http:://example.com', array('rel' => 'prev', 'type' => null, 'title' => null), array('inline' => false));
?>
	<div class="pagination">
		<ul>
			<?php echo $paginatorLinks;?>
		</ul>
	</div>
<?php 
}
?>