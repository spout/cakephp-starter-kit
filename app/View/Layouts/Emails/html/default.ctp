<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?php echo $title_for_layout;?></title>
</head>
<body>
	<?php echo $content_for_layout;?>
	<p><?php echo __("Cet e-mail a été envoyé depuis %s, si vous pensez qu'il s'agit d'un spam, veuillez nous contacter.", env('HTTP_HOST'));?></p>
</body>
</html>