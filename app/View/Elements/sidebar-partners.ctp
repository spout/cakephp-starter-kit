<?php 
$partners = array(
	array(
		'url' => 'http://www.xeno-tactic.com',
		'anchor' => 'Jeu Xeno Tactic',
		'title' => 'Jouer à Xeno Tactic',
	),
	array(
		'url' => 'http://www.jeux-flash.ch/',
		'anchor' => 'Jeux flash',
		'title' => 'Jeux flash',
	),
	array(
		'url' => 'http://www.blogjeux.org/',
		'anchor' => 'Guide Jeux',
		'title' => 'Guide Jeux',
	)
);
?>
<li class="nav-header"><i class="icon-heart"></i> <?php echo __('Sites ami');?></li>
<?php foreach($partners as $k => $v):?>
	<li><a href="<?php echo $v['url'];?>" title="<?php echo $v['title'];?>" onclick="window.open(this.href);return false;"><?php echo $v['anchor'];?></a></li>
<?php endforeach;?>