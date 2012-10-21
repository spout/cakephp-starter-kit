<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?php echo $this->Html->link(__('main_title'), '/', array('class' => 'brand', 'escape' => false));?>
			<div class="nav-collapse">
				<ul class="nav">
					<li class="dropdown">
						<?php echo $this->Html->link(__('Annuaire').' <b class="caret"></b>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false));?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link(__('Navigation par catégories'), array('controller' => 'links', 'action' => 'index', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Recherche par carte'), array('controller' => 'links', 'action' => 'map', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Proposer une activité'), array('controller' => 'links', 'action' => 'add', 'admin' => false));?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link(__('Annonces').' <b class="caret"></b>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false));?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link(__('Navigation par catégories'), array('controller' => 'ads', 'action' => 'index', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Recherche par carte'), array('controller' => 'ads', 'action' => 'map', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Placer une annonce'), array('controller' => 'ads', 'action' => 'add', 'admin' => false));?></li>
						</ul>
					</li>
					<li class="dropdown">
						<?php echo $this->Html->link(__('Agenda').' <b class="caret"></b>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false));?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link(__('Agenda %d', date('Y')), array('controller' => 'events', 'action' => 'index', 'country' => 0, 'year' => date('Y'), 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Calendrier'), array('controller' => 'events', 'action' => 'index', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Ajouter un événement'), array('controller' => 'events', 'action' => 'add', 'admin' => false));?></li>
						</ul>
					</li>
					<li><?php echo $this->Html->link(__('Boutique'), array('controller' => 'shops', 'action' => 'index', 'admin' => false));?></li>
					<li><?php echo $this->Html->link(__('Photos'), array('controller' => 'photos', 'action' => 'index', 'admin' => false));?></li>
					<li><?php echo $this->Html->link($this->Html->image('feed-icons/feed-icon-14x14.png', array('alt' => 'RSS')), array('controller' => 'links', 'action' => 'feed.rss'), array('escape' => false));?></li>
					<?php /*if(Auth::id()):?>
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<?php echo $this->Html->link(Auth::user('email').' <b class="caret"></b>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false));?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link(__('Mon compte'), array('controller' => 'users', 'action' => 'index', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Déconnexion'), array('controller' => 'users', 'action' => 'logout', 'admin' => false));?></li>
						</ul>
					</li>
					<?php endif;?>
					<?php if(Auth::hasRole(ROLE_ADMIN)):?>
					<li class="divider-vertical"></li>
					<li class="dropdown">
						<?php echo $this->Html->link(__('Admin').' <b class="caret"></b>', '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false));?>
						<ul class="dropdown-menu">
							<li><?php echo $this->Html->link(__('Gestionnaire de fichiers'), array('controller' => 'file_manager', 'action' => 'index', 'admin' => true));?></li>
							<li><?php echo $this->Html->link(__('Gestion des catégories'), array('controller' => 'categories', 'action' => 'index', 'admin' => true));?></li>
						</ul>	
					</li>	
					<?php endif;*/?>
				</ul>
				<?php echo $this->Form->create('Link', array('url' => array('controller' => 'links', 'action' => 'search'), 'class' => 'navbar-search pull-right', 'id' => 'LinkSearchFormLayout'));?>
				<?php echo $this->Form->text('Link.query', array('class' => 'search-query', 'id' => 'LinkQueryLayout', 'placeholder' => __('Recherche'), 'data-provide' => 'typeahead'));?>
				<?php echo $this->Form->end();?>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>