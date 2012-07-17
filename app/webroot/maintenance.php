<?php
//http://googlewebmastercentral.blogspot.com/2011/01/how-to-deal-with-planned-site-downtime.html
//http://www.gatellier.be/blog/bonnes-pratiques-status-503-maintenance/ 
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Retry-After: '.gmdate('D, d M Y H:i:s', strtotime('+1 hour')).' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_SERVER['HTTP_HOST'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
* {
	padding:0;margin:0;
}

body {
	font-family: Verdana, Geneva, sans-serif;
}

#wrapper {
	text-align:center;
}
</style>
</head>
<body>
	<div id="wrapper">
		<p>Nous sommes en train de mettre à jour <?php echo $_SERVER['HTTP_HOST'];?>.</p>
		<p>Veuillez réessayer plus tard.</p>
		<p>Merci pour votre compréhension.</p>
	</div>
</body>
</html>