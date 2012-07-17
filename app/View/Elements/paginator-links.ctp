<?php 
$paginatorParams = $this->Paginator->params();
if ($paginatorParams['pageCount'] > 1) {
	$paginatorLinks = '';
	$sep = '';
	
	$labels = array(
		'first' => array(
			// 'anchor' => '<i class="icon-fast-backward"></i>',
			'anchor' => '&lt;&lt;',
			'title' => __('Première page')
		),
		'prev' => array(
			// 'anchor' => '<i class="icon-backward"></i>',
			'anchor' => '&lt;',
			'title' => __('Page précédente')
		),
		'next' => array(
			// 'anchor' => '<i class="icon-forward"></i>',
			'anchor' => '&gt;',
			'title' => __('Page suivante')
		),
		'last' => array(
			// 'anchor' => '<i class="icon-fast-forward"></i>',
			'anchor' => '&gt;&gt;',
			'title' => __('Dernière page')
		)
	);

	$first = $this->Paginator->first($labels['first']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['first']['title']));
	if (!empty($first))
		$paginatorLinks .= $first.$sep;

	$prev = $this->Paginator->prev($labels['prev']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['prev']['title']));	
	if ($this->Paginator->hasPrev() && !empty($prev))
		$paginatorLinks .= $prev.$sep;

	$numbers = $this->Paginator->numbers(array('modulus' => 12 , 'separator' => $sep, 'tag' => 'li'));
	if (!empty($numbers))
		$paginatorLinks .= $numbers;

	$next = $this->Paginator->next($labels['next']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['next']['title']));
	if ($this->Paginator->hasNext() && !empty($next))
		$paginatorLinks .= $sep.$next;

	$last = $this->Paginator->last($labels['last']['anchor'], array('escape' => false, 'tag' => 'li', 'title' => $labels['last']['title']));
	if (!empty($last))
		$paginatorLinks .= $sep.$last;
	
	$paginatorLinks = str_replace('/page:1/"','"', $paginatorLinks);// remove /index/page:1 duplicate content
	$paginatorLinks = str_replace('/index"','"', $paginatorLinks);// remove /index duplicate content
?>
	<div class="pagination">
		<ul>
			<?php echo $paginatorLinks;?>
		</ul>
	</div>
<?php 
}
?>