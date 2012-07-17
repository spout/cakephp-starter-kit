<?php 
if(isset($number) && !empty($number)){
	$number = explode(' ', $number);
	if(count($number) == 3){
		list($cc, $ac, $sn) = $number;//Country code / Area code / Subcriber number
		$sn = str_split($sn);
		$offset = (!(count($sn)%2)) ? 2 : 3;
		
		$snOut = implode('', array_splice($sn, 0, $offset));
		
		foreach($sn as $k => $v){
			$snOut .= (!($k%2)) ? ' ' : '';
			$snOut .= $v;
		}
		$phoneDisplay = implode(' ', array($cc, $ac, $snOut));
		//echo $phoneDisplay;
		echo '<a href="callto:'.str_replace(' ','', $phoneDisplay).'">'.$phoneDisplay.'</a>';
	}
}
?>