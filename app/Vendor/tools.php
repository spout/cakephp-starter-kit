<?php
//http://be.php.net/manual/en/function.addcslashes.php#35975
function jsaddslashes($s){
	$o = '';
	$l = strlen($s);
	for($i =0 ; $i < $l; $i++){
		$c = $s[$i];
		switch($c){
		case '<': $o.='\\x3C'; break;
		case '>': $o.='\\x3E'; break;
		case '\'': $o.='\\\''; break;
		case '\\': $o.='\\\\'; break;
		case '"':  $o.='\\"'; break;
		case "\n": $o.='\\n'; break;
		case "\r": $o.='\\r'; break;
		default:
		$o.=$c;
		}
	}
	return $o;
}

function googl($url) {
	//http://www.vijayjoshi.org/2011/01/12/php-shorten-urls-using-google-url-shortener-api/
	$postData = array('longUrl' => $url, 'key' => Configure::read('Google.consoleAPIKey'));
	$jsonData = json_encode($postData);
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	
	$response = curl_exec($ch);
	$json = json_decode($response);
	
	curl_close($ch);
	
	$shortUrl = $json->id;
	
	return $shortUrl;
}

/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 * http://be.php.net/manual/fr/function.hexdec.php
 */                                                                                              
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}

function getMappyToken($login, $pwd) {

   $ACCESSOR_URL = 'http://axe.mappy.com/1v1/'; // Prod

   $timestamp = round(time(true));

   $hash = md5($login."@".$pwd."@".$timestamp);
   $preToken =  $login."@".$timestamp."@".$hash;

   $remoteAddr = urlencode($_SERVER["REMOTE_ADDR"]);

   $urlGetToken = $ACCESSOR_URL . 'token/generate.aspx?auth=' . urlencode($preToken) . '&ip=' . $remoteAddr;

   $fh = @fopen($urlGetToken, 'rb') ;
   if ($fh == false) {

      return false;
   }
   $token = '';
   while (!feof($fh)) {
     $token .= fread($fh, 8192);
   }
   fclose($fh);

   return $token;
}

//http://www.php.net/manual/fr/function.base64-encode.php#82506
function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input)
{
    return base64_decode(strtr($input, '-_,', '+/='));
}

//http://www.php.net/manual/fr/function.file-get-contents.php#82255
function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
        else return FALSE;
}

function getFaviconImage($url, $provider = 'g.etfv.co'){
	$providers = array(
		'g.etfv.co' => 'http://g.etfv.co/%s',
		'getfavicon.org' => 'http://www.getfavicon.org/?url=%s',
		'google.com' => 'http://www.google.com/s2/favicons?domain=%s'
	);
	
	return '<img src="'.sprintf($providers[$provider], urlencode($url)).'" alt="" width="16" height="16" />';
}

function descritpion_existe($description)
{
    $description = str_replace('"','',$description);
    $desc_cut=wordwrap(stripslashes($description),120,"<br />",1);
    $cut = explode('<br/>', $desc_cut);
    $cut = $cut[0] ;
	$url = 'http://www.google.fr/search?hl=fr&q="'. urlencode($cut).'"&filter=0';
	//echo $url  ;
    if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data=curl_exec ($ch);
            curl_close ($ch);
    } 
    else {
        $data= file_get_contents($url);
    }
	//echo $data ;
    $page = $data ;
	//	echo  $page ;
    $result = explode('aucun r', strtolower($page));
	if (isset($result[1])) 
	{	
		return false ;
	}
	else
	{	
		$result = explode('aucun document', strtolower($page));
		if (isset($result[1])) return false;
		else return true;
	}

	//$result1 = $result[1] ;
/*
    $result2 = explode('pour', $result1);
   if (!isset($result2[0]))	return false;
   $result3 = $result2[0] ;
    $result3 = trim(strip_tags(str_replace('&nbsp;', '', $result3)));
	//	echo $result3 ;
	//  If more than 5 results found, stop the process
	if ($result3 > 1)
	{
		return true;
		
	}
	else 
	{
	//	echo '  bbb  ' ;
		return false;
	}
	*/
}

# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license

function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
    $first_of_month = gmmktime(0,0,0,$month,1,$year);
    #remember that mktime will automatically correct if invalid dates are entered
    # for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
    # this provides a built in "rounding" feature to generate_calendar()

    $day_names = array(); #generate all the day names according to the current locale
    for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
        $day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

    list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
    $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
    //$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names
	$title   = ucfirst($month_name).'&nbsp;'.$year;//Spout fix

    #Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
    @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
    if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
    if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
    $calendar = '<table class="calendar">'."\n".
        '<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

    if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
        #if day_name_length is >3, the full name of the day will be printed
        foreach($day_names as $d)
            $calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
        $calendar .= "</tr>\n<tr>";
    }

    if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
    for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
        if($weekday == 7){
            $weekday   = 0; #start a new week
            $calendar .= "</tr>\n<tr>";
        }
        if(isset($days[$day]) and is_array($days[$day])){
            @list($link, $classes, $content) = $days[$day];
            if(is_null($content))  $content  = $day;
            $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
                ($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
        }
        else $calendar .= "<td>$day</td>";
    }
    if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

    return $calendar."</tr>\n</table>\n";
}

function contentSpinning($text) {

	if(!preg_match('/{/si', $text)) {
		return $text;
	}
	else {
		preg_match_all('/\{([^{}]*)\}/si', $text, $matches);
		$occur = count($matches[1]);
		for ($i=0; $i < $occur; $i++) {
			$word_spinning = explode("|",$matches[1][$i]);
			shuffle($word_spinning);
			$text = str_replace($matches[0][$i], $word_spinning[0], $text);
		}
		return contentSpinning($text);
	}

}

?>