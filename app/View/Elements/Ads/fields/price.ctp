<?php
$price = $item[$modelClass]['price'];
if (!isset($currencySymbol)){
	$currencySymbol = '&euro;';
}

$fullPriceTypeDisplay = true;

$priceType = $item[$modelClass]['price_type'];
	
switch($priceType){
	default:
	case 'fixed':
		echo number_format($price, 2, ',', ' ').' '.$currencySymbol;
		break;
		
	case 'talk';
		$separator = (!isset($separator)) ? ' - ' : $separator;
			
		if (!empty($price) && $price != 0.00) {
			echo number_format($price, 2, ',', ' ').' '.$currencySymbol;
			echo $separator;	
		}
		
		echo __('A discuter');
		break;
	
	case 'nc':
		if (isset($fullPriceTypeDisplay)) {
			echo __('Non communiqué');
		}
		break;
		
	case 'na':
		if (isset($fullPriceTypeDisplay)) {
			echo __('Non applicable');
		}
		break;
		
	case 'free':
		echo __('Gratuit');
		break;
		
	case 'exchange':
		echo __('Echange');
		break;
}