<?php
	error_reporting(E_ALL);
	
	if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'teads.class.php')) {
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'teads.class.php';
	} else {
		die ('File not found: ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'teads.class.php');
	}
	
	$openSSL = function_exists('openssl_pkey_get_public')
		&& function_exists('openssl_seal')
		&& function_exists('openssl_public_encrypt')
		&& function_exists('openssl_public_decrypt')
		&& function_exists('openssl_verify');
?>
<html>
	<head>
		<title>Teads config checker</title>
	</head>
	<body>
		<div class="center">
			<hr />
			<h1>Teads config checker</h1>
			<hr />
			<table width="600" style="table-layout: fixed">
				<tr class="h">
					<th style="width: 100px">Feature</th>
					<th>Commentaire</th>
				</tr>
				<tr>
					<td class="e">openSSL</td>
					<td class="v">
						<?php if($openSSL):?>
						openssl_pkey_get_public, openssl_seal, openssl_public_encrypt, openssl_public_decrypt, openssl_verify
						<?php else:?>
						<span style="color:red;font-weight:bold">Echec. OpenSSL is not installed.</span><br />
						<br />
						To install it on an unix environment:<br />
						<ol>
							<li>login in SSH</li>
							<li>execute "sudo apt-get install openssl && sudo /etc/init.d/apache2 reload"</li>
						</ol>
						<?php endif;?>
					</td>
				</tr>
				<tr>
					<td class="e">Php version</td>
					<td class="v">
						<?php if (phpversion() > 4):?>
						<?php echo phpversion()?>
						<?php else:?>
						Votre version de PHP est trop ancienne (<?php echo phpversion()?>)
						<?php endif;?>
					</td>
				</tr>
				<?php if ($openSSL):?>
				<tr>
					<td class="e">Test encodage</td>
					<td class="v">
						<?php
							$teads = new Teads(1, 'http://www.teads.fr');
							$teads->setTemplate('<span style="word-wrap:break-word"><b>Data:</b><br />#data#<br /><br /><b>Sign:</b><br />#sign#</span>');
							$form = $teads->generateForm();
							echo $form;
						?>
					</td>
				</tr>
				<tr>
					<td class="e">Test decodage</td>
					<td class="v">
						<?php
							$teads = new Teads(1, 'http://www.teads.fr');
							$info = $teads->extractData(
								'CW/p9IxbQMNT6oRrHseZwDB17osCRTigDa3Ru6IBDJUuxr6ZjWIbfYuvtUmiiivAzkozqkwnTBehz/zk902eD8qI6ZPnHl5L3p6bQmpGGGG2KX4rf4ku9aAt/sSnz+JSyRzOx9QjxERlRfWAgDRaaLleYBgr8G8wiJVVHFpTcWqC/Y4ggCr/rjP/0N2ORCoz39BgS9VMynzyFG5iUEU3gyaKZ+J4eFWLTwJwh4e9oDzzPW4OQBq8t/mYpOFgwnOlMfLu/2rrnJD3XffyRxIVO7pNMRtTaQsUugJRLNzhX9LU+8f+Os85dOmjSx7K34EH2E66kYfr6FdzuubI/uhNRg==',
								'NXKT/SSiygvK2u1YKCAIZxHoBvBjDDUZKaMwgJhfAAT26JLacY4FXrNo5/yHYZ0rbd1v5ZOhEQj4Emc2HDNyAMvVjI3DtGzFKOfxrtzoSs+W8awv+M1K0NClzrdIzY+dCPhs9q6O+YvOTinaH481Bz4OrZKGvy1BB9wQfCJA/v/ydy0Lt1OCILvly/fLr96ySTr5ZA+ydkkqmuyKLvO9A+6oXbMgVBYWhBdljQeD+C+rppQQF5SrhUmGPIkVYMUcKeEFRvBb9UkI0GCzLhUQHy4SE4TU7y1s3C2qtPFIPASRYL32nyYK1LTsaLv+JIX+w56Rn0PeVDYMUUUI4virBw=='
							);
							if (empty($info)){
								echo $teads->getError();
							}else{
								var_dump($info);
							}
						?>
					</td>
				</tr>
				<?php endif?>
			</table>
			<br />
			<table width="600">
				<tr class="v">
					<td>
						<a href="http://www.teads.fr">
							<img src="http://www.teads.fr/images/logo_big.png" width="80">
						</a>
						End of teads checking. Below is phpinfo.<br />
						<a href="http://teads.fr/res/guide_implementation_latest.pdf">Documentation</a> | <a href="http://teads.fr/res/documentation_teads_latest.zip">Documentation + examples</a>
					</td>
				</tr>
			</table>
			<br /><br />
		</div>
		<?php phpinfo(); ?>
	</body>
</html>