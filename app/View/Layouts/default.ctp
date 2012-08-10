<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset();?>
		<title><?php echo $title_for_layout;?> - <?php echo __('main_title');?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php if(isset($metaDescription) && !empty($metaDescription)):?>
			<meta name="description" content="<?php echo h($this->Text->truncate(strip_tags(removeLineBreaks($metaDescription)), 200, array('ending' => '...', 'exact' => false)));?>" />
		<?php endif;?>
		<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('/bootstrap/css/bootstrap.min.css');
		// echo $this->Html->css('gamesdir.css');
		echo $this->Html->css('/bootstrap/css/bootstrap-responsive.css');
		
		$jquery = array('version' => '1.7.2');
		$jqueryUI = array('version' => '1.8.18', 'theme' => 'smoothness');

		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/'.$jquery['version'].'/jquery.min.js');
		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryUI['version'].'/jquery-ui.min.js');
		echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryUI['version'].'/themes/'.$jqueryUI['theme'].'/jquery-ui.css', 'stylesheet', array('media' => 'screen'));
		
		echo $this->Html->script('jquery/jquery.prettyPhoto.js');
		echo $this->Html->css('prettyPhoto/css/prettyPhoto.css', 'stylesheet', array('media' => 'screen'));
		
		$this->Html->scriptStart();
		?>
		$(function(){
			$("a.lightbox").prettyPhoto({
				social_tools: ''
			});
		});
		<?php
		echo $this->Html->scriptEnd();
			
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		?>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<?php echo $this->Html->link($this->Html->image('gamesdir/logo-small.png', array('alt' => __('main_title'))), '/', array('class' => 'brand', 'escape' => false));?>
					<div class="nav-collapse">
						<ul class="nav">
							<li><?php echo $this->Html->link(__('Jeux'), array('controller' => 'games', 'action' => 'index', 'admin' => false));?></li>
							<li><?php echo $this->Html->link(__('Logiciels annexes'), array('controller' => 'pages', 'action' => 'display', 'logiciels'));?></li>
							<li><?php echo $this->Html->link($this->Html->image('feed-icons/feed-icon-14x14.png').' RSS', array('controller' => 'games', 'action' => 'feed.rss'), array('escape' => false));?></li>
							<li><?php echo $this->Html->link(__('Contact'), array('controller' => 'contact', 'action' => 'index', 'admin' => false));?></li>
							<?php if(Auth::id()):?>
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
									<li><?php echo $this->Html->link(__('Ajouter un jeu'), array('controller' => 'games', 'action' => 'add', 'admin' => true));?></li>
									<li><?php echo $this->Html->link(__('Gestionnaire de fichiers'), array('controller' => 'file_manager', 'action' => 'index', 'admin' => true));?></li>
									<li><?php echo $this->Html->link(__('Gestion des catégories'), array('controller' => 'categories', 'action' => 'index', 'admin' => true));?></li>
								</ul>	
							<?php endif;?>
						</ul>
						<?php echo $this->Form->create('Game', array('url' => array('controller' => 'games', 'action' => 'search'), 'class' => 'navbar-search pull-right', 'id' => 'GameSearchFormLayout'));?>
						<?php echo $this->Form->text('Game.query', array('class' => 'search-query', 'id' => 'GameQueryLayout', 'placeholder' => __('Recherche')));?>
						<?php echo $this->Form->end();?>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<div class="container">
			<h1><?php if(isset($h1_for_layout) && !empty($h1_for_layout)):?><?php echo $h1_for_layout;?><?php else:?><?php echo $title_for_layout;?><?php endif;?></h1>
			<p id="slogan"><?php echo __('Sélection des meilleurs jeux complets gratuits pour PC (Windows, Mac OS X et Linux) et smartphones');?></p>
		</div>
		<div class="container" id="wrapper">
			<div class="row">
				<?php 
				$hasSidebar = (isset($sidebarCategories) || isset($platforms)) ? true : false;
				?>
				<div class="<?php if($hasSidebar):?>span9<?php else:?>span12<?php endif;?>">
					<?php echo $this->element('flash-messages');?>
					<?php if(empty($this->request->params['isAjax'])):?>
						<?php echo $this->element('generic/breadcrumbs');?>
					<?php endif;?>
					<?php echo $this->fetch('content');?>
				</div>
				
				<?php if($hasSidebar):?>
				<div class="span3">
					<div id="sidebar">
						<ul class="nav nav-list">
							<?php echo $this->element('sidebar-categories');?>
							<?php echo $this->element('sidebar-platforms');?>
							<?php echo $this->element('sidebar-partners');?>
						</ul>	
					</div>
				</div>
				<?php endif;?>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="span12">
					<div id="footer">
						&copy; <?php echo date('Y');?> - <?php echo __('main_title');?> v2.0 - <?php echo $this->Html->link(__('Mentions légales'), array('controller' => 'pages', 'action' => 'display', 'legal'));?>
					</div>
				</div>
			</div>
		</div>
		
		<?php echo $this->Html->script('/bootstrap/js/bootstrap-dropdown.js');?>
		<?php echo $this->Html->script('/bootstrap/js/bootstrap-alert.js');?>
		<?php echo $this->Html->script('/bootstrap/js/bootstrap-collapse.js');?>

		<?php echo $this->element('sql_dump');?>
	</body>
</html>