<?php
function removeLineBreaks($string, $replaceBy = " ") {
	return preg_replace("/(\r\n|\n|\r)/", $replaceBy, $string);
}

function removeAccents($string) { 
	return strtr($string, 
		utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"),
		utf8_decode("aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn")
		);
}

function redirect($url) {
	header("Status: 301 Moved Permanently");
	header("Location: ".$url);
	exit();
}

function slug($string, $replacement = '-') {
	return strtolower(Inflector::slug($string, $replacement));
}

//http://www.php.net/manual/fr/function.hexdec.php#74092
function getContrastColor($color) {
    return (hexdec($color) > 0xffffff/2) ? '000000' : 'ffffff';
}

function getPreferedLang($data, $field = 'title', $prefered = TXT_LANG, $langs = array()) {
	$fieldPrefix = $field.'_';
	
	if (isset($data[$fieldPrefix.$prefered]) && !empty($data[$fieldPrefix.$prefered])) {
		return $data[$fieldPrefix.$prefered];
	}
	
	if (empty($langs)) {
		$langs = array_keys(Configure::read('Config.languages'));
	}
	
	foreach ($langs as $lang) {
		if (isset($data[$fieldPrefix.$lang]) && !empty($data[$fieldPrefix.$lang])) {
			return $data[$fieldPrefix.$lang];
		}
	}
	
	if (isset($data[$field]) && !empty($data[$field])) {
		return $data[$field];
	}
}

function truncate($string, $max, $rep = '...') {
	$stringlength = strlen($string);
	$string = $string." ";
	$string = substr($string,0,$max);
	$string = substr($string,0,strrpos($string,' '));
	if ($stringlength > $max)
	 $string = $string.$rep;
	
	return $string;
}
	
function return_bytes($val) {
//http://be2.php.net/manual/en/function.ini-get.php
   $val = trim($val);
   $last = strtolower($val{strlen($val)-1});
   switch($last) {
       // The 'G' modifier is available since PHP 5.1.0
       case 'g':
           $val *= 1024;
       case 'm':
           $val *= 1024;
       case 'k':
           $val *= 1024;
   }

   return $val;
}

function parse_csv_file($file, $columnheadings = false, $delimiter = ',', $enclosure = "\"") {
	$row = 1;
	$rows = array();
	$handle = fopen($file, 'r');
	
	while (($data = fgetcsv($handle, 1000, $delimiter, $enclosure )) !== FALSE) {
		if (!($columnheadings == false) && ($row == 1)) {
			$headingTexts = $data;
		} elseif (!($columnheadings == false)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$headingTexts[$key]] = $value;
			}
			$rows[] = $data;
		} else {
			$rows[] = $data;
		}
		$row++;
	}
	
	fclose($handle);
	return $rows;
}
/*****************************************************************************/
/* GPS                                                                      */
/*****************************************************************************/
function getGPSDistance($long1, $lat1, $long2, $lat2) {
	$earth_radius = 6367000;   // Terre = sphère de 6367km de rayon
	$rlo1 = deg2rad($long1);
	$rla1 = deg2rad($lat1);
	$rlo2 = deg2rad($long2);
	$rla2 = deg2rad($lat2);

	$dlo = ($rlo2 - $rlo1) / 2;
	$dla = ($rla2 - $rla1) / 2;
	$a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
	$d = 2 * atan2(sqrt($a), sqrt(1 - $a));

	return ($earth_radius * $d);
} 

function friendlyGPSCoord($coord) {
	//thanks to http://en.wikipedia.org/wiki/Geographic_coordinate_conversion
	return sprintf("%0.0f&#176; %2.3f'",
		floor(abs($coord)),
		60*(abs($coord)-floor(abs($coord))));
}

function friendlyGPSCoords($latitude, $longitude) {
	//thanks to http://en.wikipedia.org/wiki/Geographic_coordinate_conversion
	return sprintf("%s %s, %s %s",
		($latitude>0)?"N":"S",  friendlyGPSCoord($latitude),
		($longitude>0)?"E":"W", friendlyGPSCoord($longitude));
}

function decimalToDMS($dec, $returnArray = false) {
	// Converts decimal longitude / latitude to DMS
	// ( Degrees / minutes / seconds )
	// This is the piece of code which may appear to
	// be inefficient, but to avoid issues with floating
	// point math we extract the integer part and the float
	// part by using a string function.

	$vars = explode(".", $dec);
	$deg = $vars[0];
	$tempma = "0." . $vars[1];

	$tempma = $tempma * 3600;
	$min = floor($tempma / 60);
	$sec = $tempma - ($min * 60);

	if ($returnArray) {
		return array("deg" => $deg, "min" => $min, "sec" => round($sec));
	} else {
		$html = $deg . '&#176;&nbsp;' . $min . '\'&nbsp;' . $sec . '&#34;';
		return $html;
	}
}

function DMSToDecimal($deg,$min,$sec) {
	// Converts DMS ( Degrees / minutes / seconds )
	// to decimal format longitude / latitude
	return $deg+((($min*60)+($sec))/3600);
}