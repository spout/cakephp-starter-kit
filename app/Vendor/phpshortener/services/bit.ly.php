<?php
/**
 * bit.ly adapter
 *
 * @author Guillermo Rauch
 * @version $Id$
 * @copyright Devthought, 24 April, 2009
 * @package phpshortener
 **/

class PHPShortenerBitLy extends PHPShortenerService {
	
	var $service = 'bit.ly';
	
	var $login = 'spout';
	
	var $apikey = 'R_f9ad196c7ef5f6491d4d4f4649ea6afc';
	
	/**
	 * Encode function
	 *
	 * @param string $url URL to encode
	 * @return mixed Encoded URL or false (if failed)
	 * @author Guillermo Rauch
	 */
	function encode($url){
		$url = sprintf('http://api.bit.ly/shorten?version=%s&longUrl=%s&login=%s&apiKey=%s&format=%s', '2.0.1', urlencode($url), $this->login, $this->apikey, 'xml');
		$response = $this->fetch($url);
		if (preg_match('/<shortUrl>([^<]*)/', $response, $results)) return $results[1];
		return false;
	}
	
}
?>