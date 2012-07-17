<?php $this->set('title_for_layout', 'Logiciels annexes');?>

<?php 
$items = array(
	'Teamspeak' => array(
		'url' => 'http://www.teamspeak.com/',
		'description' => 'Logiciel d\'audioconférence Internet (nécessite un serveur pour se connecter).'
	),
	'Mumble' => array(
		'url' => 'http://mumble.sourceforge.net/',
		'description' => 'Mumble est un logiciel libre de VoIP, principalement conçu pour les parties de jeux en réseau.'
	),
	'Xfire' => array(
		'url' => 'http://www.xfire.com/',
		'description' => 'Logiciel de messagerie instantanée spécialement adapté pour les jeux. Xfire permet de voir à quel jeu les amis jouent et de les rejoindre simplement (pour certains jeux).'
	)
);

?>
<?php foreach($items as $t => $i):?>
	<div class="well">
		<h2><?php echo $t;?></h2>
		<p>
			<?php echo $i['description'];?>
		</p>
		<p>
			<a href="<?php echo $i['url'];?>">
				<?php echo $this->element('website-screenshot', array('url' => $i['url'], 'alt' => $t));?>
			</a>
		</p>
		<p>
			<a href="<?php echo $i['url'];?>" rel="external"><?php echo $i['url'];?></a>
		</p>
	</div>
<?php endforeach;?>