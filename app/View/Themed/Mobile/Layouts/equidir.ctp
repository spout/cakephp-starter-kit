<?php echo $this->Html->docType('html5');?>
<html> 
	<head> 
	<title><?php echo $title_for_layout;?> - <?php echo __('main_title');?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	
	echo $this->Html->css('mobile');
	
	$jquery = array('version' => '1.6.4');
	$jqueryUI = array('version' => '1.8.14', 'theme' => 'pepper-grinder');
	
	echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/'.$jquery['version'].'/jquery.min.js');
	echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryUI['version'].'/jquery-ui.min.js');
	echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/'.$jqueryUI['version'].'/themes/'.$jqueryUI['theme'].'/jquery-ui.css', 'stylesheet', array('media' => 'screen'));
	
	echo $this->Html->script('http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js');
	
	echo $this->Html->css('http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css', 'stylesheet', array('media' => 'screen'));
	//echo $this->Html->script('http://jeromeetienne.github.com/jquery-mobile-960/css/jquery-mobile-960.min.css');
	
	echo $this->Html->script('jquery/jquery.fancybox.js');
	echo $this->Html->css('fancybox/jquery.fancybox');
	
	echo $scripts_for_layout;
	
	$dataTheme = 'data-theme="d"';
	
	?>
</head> 
<body> 
<div data-role="page" <?php echo $dataTheme;?>>

	<div data-role="header" <?php echo $dataTheme;?>>
		<h1><?php if(isset($h1_for_layout) && !empty($h1_for_layout)):?><?php echo $h1_for_layout;?><?php else:?><?php echo $title_for_layout;?><?php endif;?></h1>
	</div>

	<div data-role="content" <?php echo $dataTheme;?>>
		<?php echo $this->element('flash-messages');?>
		<?php echo $this->element('generic/breadcrumbs');?>
		<?php echo $content_for_layout;?>
	</div>
	
	<div data-role="footer" <?php echo $dataTheme;?>>
		<h4>&copy; <?php echo date('Y');?> <?php echo __('main_title');?></h4>
	</div>
	
</div>

</body>
</html>