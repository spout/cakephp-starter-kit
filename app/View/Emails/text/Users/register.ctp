<?php 
echo __("Bonjour %s %s,", $userData['firstname'], $userData['lastname']).PHP_EOL;
echo PHP_EOL;
echo __("Merci d'avoir créé un compte sur notre site").' :'.PHP_EOL;
echo FULL_BASE_URL.PHP_EOL;
echo PHP_EOL;
echo __("Vous êtes à un pas de vous enregistrer et d'accéder à l'espace réservé aux membres.").PHP_EOL;
echo PHP_EOL;
echo __("Pour activer votre compte, cliquez ici").PHP_EOL;
echo $activateUrl.PHP_EOL;
echo PHP_EOL;
echo __("Une fois que vous aurez activé votre compte, vous pourrez vous enregistrer avec les informations suivantes").' :'.PHP_EOL;
echo __("E-mail").' : '.$userData['email'].PHP_EOL;
echo __("Mot de passe").' : '.$userData['password'].PHP_EOL;
echo PHP_EOL;
echo __("Le Webmaster").PHP_EOL;
echo PHP_EOL;
echo __("Ceci est un message automatique, svp n'y répondez pas !").PHP_EOL;