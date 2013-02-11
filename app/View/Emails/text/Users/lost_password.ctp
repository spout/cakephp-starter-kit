<?php 
echo __("Bonjour %s %s,", $userData['firstname'], $userData['lastname']).PHP_EOL;
echo PHP_EOL;
echo __("Nous avons changé votre mot de passe.").PHP_EOL;
echo PHP_EOL;
echo __("Voici vos informations de connexion").' :'.PHP_EOL;
echo __("E-mail").' : '.$userData['email'].PHP_EOL;
echo __("Nouveau mot de passe").' : '.$newPassword.PHP_EOL;
echo PHP_EOL;
echo __("Vous pouvez vous connecter ici").' :'.PHP_EOL;
echo $loginUrl.PHP_EOL;
echo PHP_EOL;
echo __("Le Webmaster").PHP_EOL;
echo PHP_EOL;
echo __("Ceci est un message automatique, svp n'y répondez pas !").PHP_EOL;