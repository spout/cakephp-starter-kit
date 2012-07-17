<?php
	if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'teads.config.php')) {
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'teads.config.php';
	} else {
		die ('File not found: ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'teads.config.php');
	}
	
	class Teads {
	
		protected $certificat = "
-----BEGIN CERTIFICATE-----
MIIFGDCCBACgAwIBAgIRAK4ZFK92Fhr5hfCV5/bzW0QwDQYJKoZIhvcNAQEFBQAw
ZDELMAkGA1UEBhMCRlIxFjAUBgNVBAsTDUxvdyBBc3N1cmFuY2UxEDAOBgNVBAoT
B09WSCBTQVMxKzApBgNVBAMTIk9WSCBTZWN1cmUgQ2VydGlmaWNhdGlvbiBBdXRo
b3JpdHkwHhcNMTEwNDEzMDAwMDAwWhcNMTIwNDEyMjM1OTU5WjA9MSEwHwYDVQQL
ExhEb21haW4gQ29udHJvbCBWYWxpZGF0ZWQxGDAWBgNVBAMTD3NlY3VyZS50ZWFk
cy5mcjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALRrSJFdWwurdTtQ
IdmnvIgmQt63pzpMGAoiR3rZaLEHmFpP+dzSq8+Jc9yPC0SJOG4GYc4RrWGhSa2y
M3aDVgGAafJTvud0zvcQIvrRmOLd2db3BObxmXgmxZYoLI6ePkX90g2B/y1BJ7q0
ODWfGKA3PHl07IfUeDeKbOdCIfWjN+taZlwOAFHwObai3ajoqDJ5wZ+3H95pAVsa
waOfelwIMXXyLKNKLoS6uaQ+8Ed2ezVVW7gQWj0H/rsOdJxC88QLeLX0aZIR/F4y
S17K2a2VZISGFuMYbONnd2OprviIA53BXJisUKQRGsz2FW3i3mZ4+aoZy5KcFxsA
2S3qddsCAwEAAaOCAeowggHmMB8GA1UdIwQYMBaAFHWQbvJqgMt1MtnkjdZd1o8c
r33hMB0GA1UdDgQWBBR4WaNPdTYvP12lzJJ80shmbL7j5zAOBgNVHQ8BAf8EBAMC
BaAwDAYDVR0TAQH/BAIwADAdBgNVHSUEFjAUBggrBgEFBQcDAQYIKwYBBQUHAwIw
SwYDVR0gBEQwQjBABgsrBgEEAYHjHAEBATAxMC8GCCsGAQUFBwIBFiNodHRwOi8v
d3d3Lm92aC5jb20vZnIvbGVnYWwvY3BzLnBkZjB1BgNVHR8EbjBsMDSgMqAwhi5o
dHRwOi8vY3JsLm92aC5uZXQvT1ZITG93QXNzdXJhbmNlU2VjdXJlQ0EuY3JsMDSg
MqAwhi5odHRwOi8vY3JsLm92aC5jb20vT1ZITG93QXNzdXJhbmNlU2VjdXJlQ0Eu
Y3JsMIGGBggrBgEFBQcBAQR6MHgwOgYIKwYBBQUHMAKGLmh0dHA6Ly9jcnQub3Zo
Lm5ldC9PVkhMb3dBc3N1cmFuY2VTZWN1cmVDQS5jcnQwOgYIKwYBBQUHMAKGLmh0
dHA6Ly9jcnQub3ZoLmNvbS9PVkhMb3dBc3N1cmFuY2VTZWN1cmVDQS5jcnQwGgYD
VR0RBBMwEYIPc2VjdXJlLnRlYWRzLmZyMA0GCSqGSIb3DQEBBQUAA4IBAQAsOcMB
jnr6LBJQ7ADVV9fFZp4Rcr0rfhJjpNMhjjK3iQIKX2KL8NVSzz0Lw5ApQPaZLhr1
6vgVM7FeLbW8n6v+gQGNb1OJ6I2veM4EhqZgpGJmKQn3xUnEoUjIVnhjUVebq6n1
70Rak4Vl8qXb1segRDsYDgJqjgBljBkFAD6gueudZPjukluMht72P+cdz7Hss2d4
Ex4JvZ+8iq/wqnsLm93gYBgt0GLtkBZLFPxh0icimRgBhD9NYxohgvanQsm1/j6X
K7sxEZJacjfbdURtrOU6up264m2ejA+0iT/J+aG9R1k25/mV7C73vxkXmXUXfG6u
Yu/s2m+FTLp608eR
-----END CERTIFICATE-----";
	
		protected $template = '<form id="teads_form" action="http://secure.teads.fr" method="post"><input type="hidden" name="data" value="#data#" /><input type="hidden" name="sign" value="#sign#" /></form>';

		protected $info;
		protected $response;
		protected $lastException;
		protected $version = '2.0';
		
		private $mess = array(
			'010' => 'idWebsite - valeur manquante / mauvais format / client introuvable',
			'020' => 'key - valeur manquante / mauvais format / mauvaise clé',
			'040' => 'mode - valeur manquante / mauvais format / valeur incorrecte',
			'050' => 'version - valeur manquante / mauvais format / valeur incorrecte',
			'110' => 'idProduct - valeur manquante / mauvais format / produit inexistant / produit désactivé',
			'120' => 'preview - mauvais format',
			'131' => 'what - valeur incorrecte',
			'132' => 'name - valeur incorrecte',
			'133' => 'description - valeur incorrecte',
			'134' => 'type - valeur incorrecte',
			'135' => 'src - valeur incorrecte',
			'136' => 'href - valeur incorrecte',
			'210' => 'language - valeur incorrecte',
			'401' => 'aucune informations post',
			'510' => 'cust_id - mauvais format',
			'520' => 'cust_birthdate - mauvais format',
			'530' => 'cust_gender - mauvais format',
			'540' => 'cust_zip - mauvais format',
			'550' => 'cust_country - mauvais format',
			'620' => 'url_error - mauvais format',
			'630' => 'url_success - mauvais format',
			'640' => 'url_callback - mauvais format',
			'710' => 'nocapping - valeur interdite en mode production',
			'810' => 'Aucune publicité disponible'
		);
		
		private $ws_service = 'http://api.teads.fr/check/service';
		private $ws_transac = 'http://api.teads.fr/check/transaction/%s/%s/%s'; 
		
		/**
		 * Constructor
		 * 
		 */
		public function __construct($idProduct = null, $urlSuccess = null, $urlError = null) {
			$this->info = array(
				'idWebsite'      => TEADS_WEBSITE,
				'key'            => TEADS_KEY,
				'mode'           => TEADS_MODE,
				'version'        => TEADS_VERSION
			);
			
			if ($urlError == null) {
				$urlError = $urlSuccess;
			}
			if ($idProduct != null) {
				$this->info['idProduct'] = $idProduct;
			}
			if ($urlSuccess != null) {
				$this->info['url_success'] = $urlSuccess;
			}
			if ($urlError != null) {
				$this->info['url_error'] = $urlError;
			}
		}
		
		/**
		 * Generate a form based on template
		 * 
		 */
		public function generateForm($info = array()) {
			$info = json_encode(array_merge($this->info, $info));
			if (openssl_pkey_get_public($this->certificat) && openssl_seal($info, $data, $env_key, array($this->certificat))) {
				$sign = base64_encode($env_key[0]);		
				$data = base64_encode($data);
			} else {
				die('Cryptage impossible');
			}
			
			$result = preg_replace('/#data#/', $data, $this->template);
			$result = preg_replace('/#sign#/', $sign, $result);
			
			return $result;
		}
		/**
		 * Extract data
		 */
		public function extractData($data = null, $sign = null) {
			if (empty($data) || empty($sign)){
				$data = isset($_POST['data']) ? $_POST['data'] : array();
				$sign = isset($_POST['sign']) ? $_POST['sign'] : array();
			}
			
			try {
				if (empty($data) || empty($sign))
					throw new Exception('Réponse manquante');
				
				$data = base64_decode($data);
				$sign = base64_decode($sign);
				
				if (!openssl_pkey_get_public($this->certificat))
					throw new Exception('La clé public ne peut être extraite');
				if (!openssl_public_decrypt($data, $info, $this->certificat))
					throw new Exception('Décryptage impossible');
				if (!openssl_verify($info, $sign, $this->certificat))
					throw new Exception('La vérification est impossible');
				$this->response = json_decode($info);
				if ($this->response->returnCode == '00') {
					$this->status = 'error';
					$this->lastException = $this->response->errorCode;
				} else if ($this->response->returnCode == '10') {
					$this->status = 'cancel';
				} else if ($this->response->returnCode == '50') {
					if (TEADS_CHECK_METHOD == "REST" ) {
						$url = sprintf($this->ws_transac,
							$this->response->idTransac,
							$this->response->idWebsite,
							$this->response->key);
						
						$ctx = stream_context_create(array(
							'http' => array(
								'timeout' => 2
							)
						));
						$result = file_get_contents($url, 0, $ctx);
						$result = json_decode($result);
						if($result->response) {
							$this->status = 'success';
						} else {
							throw new Exception('Transaction déjà validée');
						}
					}
				}
			} catch(Exception $e) {
				$this->lastException = $e;
				$this->status = 'error';
			}
		}
		
		public function checkService()
		{
			$ctx = stream_context_create(array(
				'http' => array(
					'timeout' => 2
				)
			));
			$result = file_get_contents($this->ws_service, 0, $ctx);
			return $result == 'ok';
		}
		
		public function noAd() {
			return isset($this->response->errorCode) && $this->response->errorCode == '810';
		}
		
		/**
		 * Getters/Setters
		 */
		public function getError() {
			if (isset($this->response) && isset($this->response->errorCode) && in_array($this->response->errorCode, array_keys($this->mess))) {
				return $this->mess[$this->response->errorCode];
			}
			return $this->lastException->getMessage();
		}
		public function getInfo() { return $this->info; }
		public function getResponse() { return $this->response; }
		
		public function setTemplate($template) { $this->template = $template; }
		
		//status
		public function getStatus() {
			if ($this->noAd()) {
				return 'noAd';
			}
			return isset($this->status) ? $this->status : '';
		}
				
		//idWebsite
		public function getIdWebsite() { return $this->info['idWebsite']; }
		public function setIdWebsite($idWebsite) { $this->info['idWebsite'] = $idWebsite; }
		
		//key
		public function getKey() { return $this->info['key']; }
		public function setKey($key) { $this->info['key'] = $key; }
		
		//Mode
		public function getMode() { return $this->info['mode']; }
		public function setMode($mode) { $this->info['mode'] = $mode; }
		
		//Version
		public function getVersion() { return $this->info['version']; }
		public function setVersion($version) { $this->info['version'] = $version; }
		
		//idProduct
		public function getIdProduct() { return $this->info['mode']; }
		public function setIdProduct($idProduct) { $this->info['mode'] = $mode; }

		//urlSuccess
		public function getUrlSuccess() { return $this->info['url_success']; }
		public function setUrlSuccess($urlSuccess) { $this->info['url_success'] = $urlSuccess; }
		
		//urlError
		public function getUrlError() { return $this->info['url_error']; }
		public function setUrlError($urlError) { $this->info['url_error'] = $urlError; }
	}
?>