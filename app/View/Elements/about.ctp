<?php if(TXT_LANG == 'fr'):?>
	<h2>Bienvenue sur le portail équestre <?php echo __('main_title');?></h2>
	<div>
		<h3>L'annuaire</h3>
		<p>Retrouvez les professionnels du domaine équestre dans notre annuaire classé par catégories et par pays.</p>
		<p>Entreprises du monde de l'équitation : améliorez votre visibilité sur le Web en proposant votre activité dans l'<?php echo $this->Html->link('annuaire du cheval', array('controller' => 'links', 'action' => 'form'));?>.</p>
	</div>
		
	<div>
		<h3>Les annonces</h3>
		<p>Place de marché pour l'achat et la vente de chevaux ainsi que le matériel et les services liés à l'équitation.</p>
		<p><?php echo $this->Html->link('Placez votre annonce', array('controller' => 'ads', 'action' => 'form'));?> et ajoutez-y jusqu'à 3 photos et 1 vidéo.</p>
	</div>

	<div>
		<h3>L'agenda</h3>
		<p>Retrouvez-y tous les stages, concours d'équitation et autres événements.</p>
		<p>Vous voulez faire la promotion d'un événement équestre ? <?php echo $this->Html->link('Ajoutez-le dans notre agenda', array('controller' => 'events', 'action' => 'form'));?>.</p>
	</div>

	<div>
		<h3>Nous sommes à votre écoute</h3>
		<p>Si vous avez des remarques ou des suggestions, n'hésitez pas à <?php echo $this->Html->link('nous contacter', array('controller' => 'contact', 'action' => 'index'), array('rel' => 'nofollow', 'class' => 'fancybox'));?>.</p>
	</div>
<?php elseif(TXT_LANG == 'en'):?>
	<h2>Welcome on the equestrian portal <?php echo __('main_title');?></h2>
	<div>
		<h3>The directory</h3>
		<p>Find equestrian professionals in our directory classified by categories and countries.</p>
		<p>Equestrian compagnies : improve your visibility on the Web by submitting your business in the <?php echo $this->Html->link('equestrian directory', array('controller' => 'links', 'action' => 'form'));?>.</p>
	</div>
		
	<div>
		<h3>The classified ads</h3>
		<p>Marketplace for buying and selling horses or equipment and services related to horse riding.</p>
		<p><?php echo $this->Html->link('Place an ad', array('controller' => 'ads', 'action' => 'form'));?> you can add 3 photos and 1 video.</p>
	</div>

	<div>
		<h3>The calendar</h3>
		<p>Find it all internships, competitions and other equestrian events.</p>
		<p>You want to promote an equestrian event ? <?php echo $this->Html->link('Add it to our calendar', array('controller' => 'events', 'action' => 'form'));?>.</p>
	</div>

	<div>
		<h3>We're listening</h3>
		<p>If you have any comments or suggestions, please <?php echo $this->Html->link('contact us', array('controller' => 'contact', 'action' => 'index'), array('rel' => 'nofollow', 'class' => 'fancybox'));?>.</p>
	</div>
<?php endif;?>