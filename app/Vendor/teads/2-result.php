<?php
	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib/teads.class.php';
	
	$teads = new Teads();
	$teads->extractData();
	switch($teads->getStatus()) {
		case 'error':
			//Action à effectuer en cas de erreur. Le message d'erreur peut être récupérer grâce à la méthode $teads->getError()
		break;
		case 'success':
			//Action à effectuer en cas de succès du nano-paiement
		break;
		case 'cancel' :
			//Action à effectuer en cas d'abandon du processus par l'utilisateur
		break;
		case 'noAd':
			//Action à effectuer si aucune publicité n'est disponible
		break;
	}
	