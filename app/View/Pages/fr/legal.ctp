<?php $this->set('title_for_layout', 'Mentions légales du site '.__('main_title'));?>

<h2>Editeur du site</h2>
<p><?php echo __('main_title');?> est le site Web de Stéphane Reynders</p>
<dl>
	<dt>Adresse postale:</dt>
	<dd>
		<strong>Stéphane Reynders</strong>
		<br />
		Rue des Deux-Rys, 49-1
		<br />
		6960 Manhay
		<br />
		Belgique
	</dd>
	<dt>Numéro d'entreprise ou de TVA:</dt>
	<dd>BE0872130067</dd>
	<dt>E-mail:</dt>
	<dd>
		<?php 
		//debug(CakeEmail::config());
		$email = $this->request->is('ajax') ? Configure::read('Email.to') : $this->MyHtml->encodeEmail(Configure::read('Email.to'));
		?>
		<?php echo $email;?> ou via le <?php echo $this->Html->link('formulaire de contact', array('controller' => 'contact'));?>
	</dd>
	<dt>Téléphone:</dt>
	<dd>+32 (0)86 34 52 32</dd>
	<dt><acronym title="Global System for Mobile communications">GSM</acronym>:</dt>
	<dd>+32 (0)498 39 49 46</dd>
</dl>

<h2>Hébergement du site</h2>
<p><?php echo __('main_title');?> est hébergé par <a href="http://www.ovh.com/" rel="external nofollow">OVH</a></p>
<dl>
	<dt>Adresse postale:</dt>
	<dd>
		<strong>OVH</strong>
		<br />
		rue Kellermann, 2
		<br />
		59100 Roubaix
		<br />
		France
	</dd>
</dl>	

<h2>Avertissement Google Analytics</h2>
<p>
« Ce site utilise Google Analytics, un service d'analyse de site internet fourni par Google Inc. (« Google »). Google Analytics utilise des cookies, qui sont des fichiers texte placés sur votre ordinateur, pour aider le site internet à analyser l'utilisation du site par ses utilisateurs. Les données générées par les cookies concernant votre utilisation du site (y compris votre adresse IP) seront transmises et stockées par Google sur des serveurs situés aux Etats-Unis. Google utilisera cette information dans le but d'évaluer votre utilisation du site, de compiler des rapports sur l'activité du site à destination de son éditeur et de fournir d'autres services relatifs à l'activité du site et à l'utilisation d'Internet. Google est susceptible de communiquer ces données à des tiers en cas d'obligation légale ou lorsque ces tiers traitent ces données pour le compte de Google, y compris notamment l'éditeur de ce site. Google ne recoupera pas votre adresse IP avec toute autre donnée détenue par Google. Vous pouvez désactiver l'utilisation de cookies en sélectionnant les paramètres appropriés de votre navigateur. Cependant, une telle désactivation pourrait empêcher l'utilisation de certaines fonctionnalités de ce site. En utilisant ce site internet, vous consentez expressément au traitement de vos données nominatives par Google dans les conditions et pour les finalités décrites ci-dessus.
</p>

<h2>Cookie publicitaire et règles de confidentialité Google Adsense</h2>
<p>
En tant que prestataire tiers, Google utilise des cookies pour diffuser des annonces sur <?php echo __('main_title');?>.
Grâce au cookie DART, Google adapte les annonces diffusées aux visieurs et membres de <?php echo __('main_title');?> en fonction de leur navigation sur <?php echo __('main_title');?> ou d'autres sites.
Les visiteurs et membres du site <?php echo __('main_title');?> peuvent désactiver l'utilisation du cookie DART en se rendant sur la page des <a href="http://www.google.com/privacy/ads/" rel="external nofollow">règles de confidentialité</a> s'appliquant au réseau de contenu et aux annonces Google.
</p>

<?php /*
Ceci est le site web de Stéphane Reynders
<br /><br />
Notre adresse postale est<br />Rue des Deux-Rys, 49-1
<br />
6960 Manhay
<br />Notre numéro d&#39;entreprise ou de TVA est BE0872.130.067
<br />

<h2>Vos données personnelles, notre responsabilité</h2>
Sur ce site web, nous collectons vos données personnelles. Ces données sont gérées par notre entreprise.
<br /><br />
Nous conservons les informations suivantes lors de votre visite sur note site:
<br />
- votre &#39;domain name&#39; (adresse IP) lorsque vous visitez notre page web
<br />
- votre adresse e-mail lorsque vous envoyez des messages/questions sur ce site
<br />
- votre adresse e-mail lorsque vous communiquez avec nous par e-mail
<br />
- l&#39;ensemble des informations concernant les pages d&#39;autres sites par l&#39;intermédiaire desquelles vous avez accédé à notre site<br />- l&#39;ensemble de l&#39;information concernant les pages que vous avez consultées sur notre site
<br />
- toute information que vous nous avez donnée volontairement (par exemple dans le cadre d&#39;enquêtes d&#39;informations et/ou des inscriptions sur site)
<br /><br />
Ces informations sont utilisées pour:
<br />
- un usage interne et sont ensuite abandonnées
<br />
- améliorer le contenu de notre site web
<br />
- personnaliser le contenu et le lay-out de nos pages pour chaque visiteur individuel
<br />
- vous informer des mises à jour de notre site
<br />

<h2>Utilisation de &#39;cookies&#39;</h2>
Nous n&#39;utilisons pas de cookies sur ce site. (pour rappel, un cookie est un petit fichier envoyé par un serveur Internet, qui s&#39;enregistre sur le disque dur de votre ordinateur. Il garde la trace du site Internet visité et contient un certain nombre d&#39;informations sur cette visite).
<br />

<h2>Sécurité</h2>
Nous utilisons toujours les technologies de cryptage qui sont reconnues comme les standards industriels au sein du secteur IT quand nous transférons ou recevons vos données sur notre site.
<br />

<h2>Comment nous contacter concernant notre police vie privée?</h2>
<p>
Vous souhaitez réagir à l&#39;une des pratiques décrites ci-dessous, vous pouvez nous contacter:
</p>
<ul>
<li>par e-mail: <a href="mailto:stephane@favimmo.be" target="_blank">stephane@favimmo.be</a></li>
<li>par téléphone: +3286345232</li>
<li>par courrier: Rue des Deux-Rys, 49-1, 6960 Manhay</li>
</ul>

<p>Si vous nous communiquez votre adresse postale via le web, vous pourriez recevoir des mailings périodiques de notre part, avec des informations sur des produits et services ou des événements à venir. Si vous ne souhaitez plus recevoir de tels mailings, contactez-nous à l&#39;adresse mentionnée ci-dessus.</p>
<p>Si vous nous communiquez votre numéro de téléphone via le web, vous pourriez recevoir un appel téléphonique de notre société afin de vous communiquer des informations sur nos produits, services ou événements à venir. Si vous ne souhaitez plus recevoir de tels appels téléphoniques, contactez-nous à l&#39;adresse mentionnée ci-dessus.</p>
<p>Si vous nous communiquez votre numéro GSM via le web, vous pouvez recevoir un message (SMS/MMS/ed) de notre société afin de vous communiquer des informations sur nos produits, services ou événements à venir (dans un but de marketing direct), à la condition que vous y ayez expressément consenti ou que vous soyez déjà client chez nous et que vous nous ayez communiqué votre numéro de GSM. Si vous ne souhaitez plus recevoir de tels messages (SMS/MMS/ed), contactez-nous à l&#39;adresse mentionnée ci-dessus.</p>
<p>Si vous nous communiquez votre adresse e-mail via le web, vous pouvez recevoir des e-mails de notre société afin de vous communiquer des informations sur nos produits, services ou événements à venir (dans un but de marketing direct), à la condition que vous y ayez expressément consenti ou que vous soyez déjà client chez nous et que vous nous ayez communiqué votre adresse e-mail. Si vous ne souhaitez plus recevoir de tels e-mails, contactez-nous à l&#39;adresse mentionnée ci-dessus.</p>
<p>Si vous ne souhaitez plus recevoir de mailings ou des appels téléphoniques de la part d&#39;aucune société, vous pouvez contacter le service Robinson de l&#39;Association Belge du Marketing Direct (<a href="http://www.robinsonlist.be" onclick="window.open(this.href);return false;">www.robinsonlist.be</a>, numéro de téléphone gratuit: 0800-91 887, par courrier: ABMD, Liste Robinson, Buro &amp; Design Center, Esplanade du Heysel B46, 1020 Bruxelles)</p>
<p>Notre société pourrait utiliser les informations des consommateurs pour de nouvelles utilisations qui ne sont pas encore prévues dans notre police &quot;vie privée&quot;. Dans ce cas, nous vous contacterons avant d&#39;utiliser vos données pour ces nouvelles utilisations, afin de vous faire savoir les changements de notre règlement de protection des données à caractère personnel et vous donner la possibilité de refuser de participer à ces nouveaux usages.</p>
<p>Sur requête, nous procurons aux visiteurs de notre site un accès à toutes les informations les concernant. Si vous souhaitez accéder à ces informations, contactez-nous à l&#39;adresse mentionnée ci-dessus.</p>
<p>Sur requête, nous offrons aux visiteurs la possibilité de corriger toutes les informations inexactes les concernant. Si vous souhaitez corriger des informations vous concernant, contactez-nous à l&#39;adresse mentionnée ci-dessus.</p>
<p>Si vous estimez que notre site ne respecte pas notre police vie privée telle qu&#39;elle est décrite, veuillez prendre contact avec notre société elle-même à l&#39;adresse mentionnée ci-dessus</p>
*/?>
