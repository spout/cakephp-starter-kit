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

		echo $this->Html->css('/bootstrap/css/bootstrap.css');
		echo $this->Html->css('equidir.css');
		echo $this->Html->css('/bootstrap/css/bootstrap-responsive.css');
		
		$jquery = array('version' => '1.8.2');
		$jqueryUI = array('version' => '1.8.23', 'theme' => 'humanity');

		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/'.$jquery['version'].'/jquery.min.js');
		echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryUI['version'].'/jquery-ui.min.js');
		echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryUI['version'].'/themes/'.$jqueryUI['theme'].'/jquery-ui.css', 'stylesheet', array('media' => 'screen'));
		
		echo $this->Html->script('/bootstrap/js/bootstrap.min.js');
		
		//echo $this->Html->script('jquery/jquery.prettyPhoto.js');
		//echo $this->Html->css('prettyPhoto/css/prettyPhoto.css', 'stylesheet', array('media' => 'screen'));
		
		$this->Html->scriptStart();
		
		$autocompleteUrl = $this->Html->url(array('controller' => 'links', 'action' => 'autocomplete.json'));
		?>
		$(function(){
			/*$("a.lightbox").prettyPhoto({
				social_tools: ''
			});*/
			
			//$('.alert').delay(5000).slideUp();
			
			$("#LinkQueryLayout").autocomplete({
				source: "<?php echo $autocompleteUrl;?>",
				minLength: 2,
				select: function( event, ui ) {
					window.location.replace(ui.item.url);
				}
			});
			
			<?php /*
			var labels, mapped;
			
			$("#LinkQueryLayout").typeahead({
				minLength: 2,
				items: 10,
				source: function (query, process) {
					$.get('<?php echo $autocompleteUrl;?>', { term: query }, function (data) {
						labels = [];
						mapped = {};

						$.each(data, function (i, item) {
							mapped[item.label] = item.url;
							labels.push(item.label);
						});

						process(labels);
					});
				},
				updater: function(item) {
					window.location.replace(mapped[item]);
					return;
				}
			});
			*/?>
		});
		<?php
		echo $this->Html->scriptEnd();

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('dataTableSettings');
		echo $this->fetch('script');
		?>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php echo $this->element('navbar');?>
		
		<div class="container">
			<div class="row">
				<div class="span2">
					<div id="logo">
						<?php echo $this->Html->link($this->Html->image('logo-equidir-web.png', array('alt' => __('main_title'))), '/'.TXT_LANG.'/', array('escape' => false));?>
					</div>
					<p id="slogan"><?php echo __("Le portail de l'équitation");?></p>
				</div>
				<div class="span10">
					<h1><?php if(isset($h1_for_layout) && !empty($h1_for_layout)):?><?php echo $h1_for_layout;?><?php else:?><?php echo $title_for_layout;?><?php endif;?></h1>
				</div>	
			</div>
		</div>
		<div class="container" id="content-wrapper">
			<div class="row">
				<?php 
				$hasSidebar = (isset($sidebarCategories) || isset($platforms)) ? true : false;
				?>
				<div class="<?php if($hasSidebar):?>span9<?php else:?>span12<?php endif;?>">
					<?php if(empty($this->request->params['isAjax'])):?>
						<?php echo $this->element('generic/breadcrumbs');?>
					<?php endif;?>
					
					<?php echo $this->element('flash-messages');?>
					
					<?php //debug(Router::currentRoute());?>
					
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
		
		<div class="container" id="footer">
			<div class="row">
				<div class="span12">
					&copy; <?php echo date('Y');?> - <?php echo __('main_title');?> v2.5 - <?php echo $this->Html->link(__('Mentions légales'), array('controller' => 'pages', 'action' => 'display', 'legal'));?> - <?php echo $this->Html->link(__('Contact'), array('controller' => 'contact', 'action' => 'index', 'admin' => false));?>
				</div>
			</div>
		</div>

		<?php echo $this->element('sql_dump');?>
	</body>
</html>