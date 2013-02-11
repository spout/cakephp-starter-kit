<p><?php echo __("Bonjour %s %s,", $userData['firstname'], $userData['lastname']);?></p>
<p>
	<?php echo __("Merci d'avoir créé un compte sur notre site");?> :
	<a href="<?php echo FULL_BASE_URL;?>"><?php echo FULL_BASE_URL;?></a>
</p>
<p>
	<?php echo __("Vous êtes à un pas de vous enregistrer et d'accéder à l'espace réservé aux membres.");?>
</p>
<p>
	<?php echo __("Pour activer votre compte, cliquez ici");?> :<br />
	<a href="<?php echo $activateUrl;?>"><?php echo $activateUrl;?></a>
</p>
<p>
	<?php echo __("Une fois que vous aurez activé votre compte, vous pourrez vous enregistrer avec les informations suivantes");?> :<br />
	<strong><?php echo __("E-mail");?> :</strong> <?php echo $userData['email'];?><br />
	<strong><?php echo __("Mot de passe");?> :</strong> <?php echo $userData['password'];?>
</p>
<p>
	<?php echo __("Le Webmaster");?>
</p>
<p>
	<?php echo __("Ceci est un message automatique, svp n'y répondez pas !");?>
</p>