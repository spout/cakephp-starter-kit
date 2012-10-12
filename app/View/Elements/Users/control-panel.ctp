<?php 
$controls = array(
	// __('Annuaire') => array(
		// __('Gérer mes activités') => array('controller' => 'links', 'action' => 'browse')
	// ),
	// __('Annonces') => array(
		// __('Gérer mes annonces') => array('controller' => 'ads', 'action' => 'browse')
	// ),
	// __('Agenda') => array(
		// __('Gérer mes événements') => array('controller' => 'events', 'action' => 'browse')
	// )
);
?>
<?php if(isset($controls) && !empty($controls)):?>
	<?php foreach($controls as $k => $v):?>
		<h2><?php echo $k;?></h2>
		<ul>
		<?php foreach($v as $kl => $vl):?>
			<li><?php echo $this->Html->link($kl, $vl);?></li>
		<?php endforeach;?>
		</ul>
	<?php endforeach;?>
<?php endif;?>