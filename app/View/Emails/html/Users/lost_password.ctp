<p><?php echo __("Bonjour %s %s,", $userData['firstname'], $userData['lastname']);?></p>
<p>
	<?php echo __("Nous avons changé votre mot de passe.");?>
</p>
<p>
	<?php echo __("Voici vos informations de connexion");?> :<br />
	<strong><?php echo __("E-mail");?> :</strong> <?php echo $userData['email'];?><br />
	<strong><?php echo __("Nouveau mot de passe");?> :</strong> <?php echo $newPassword;?>
</p>
<p>
	<?php echo __("Vous pouvez vous connecter ici");?> :<br />
	<a href="<?php echo $loginUrl;?>"><?php echo $loginUrl;?></a>
</p>
<p>
	<?php echo __("Le Webmaster");?>
</p>
<p>
	<?php echo __("Ceci est un message automatique, svp n'y répondez pas !");?>
</p>