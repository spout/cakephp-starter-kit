 <?php
	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib/teads.class.php';
	
	$teads = new Teads(
		'VOTRE_ID_PRODUIT', 
		'VOTRE_URL' // L'url où le client sera redirigé en cas de succés du processus
	);
	echo $teads->generateForm();
?>

<a href="#" onclick="javascript:document.getElementById('teads_form').submit()">your link here</a> 
