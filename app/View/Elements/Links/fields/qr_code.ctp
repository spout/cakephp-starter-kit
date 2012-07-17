<?php 
$endpoint = 'https://chart.googleapis.com/chart?';

$possibleFields = array(
	//'title' => '',
	'address' => __('Adresse'),
	'city' => __('Ville'),
	'postcode' => __('Code postal'),
	'country' => __('Pays'),
	'phone' => __('Téléphone'),
	'phone_2' => __('Téléphone').' n° 2',
	'mobile' => __('Mobile'),
	'mobile_2' => __('Mobile').' n° 2',
	'fax' => __('Fax'),
	'email_contact' => __('E-mail'),
	'url' => __('Site Web'),
	'skype' => __('Skype'),
	);

$chl = array();
$chl[] = getPreferedLang(${$singularVar}['Link'], 'title');
foreach ($possibleFields as $k => $v) {
	if (isset(${$singularVar}['Link'][$k]) && !empty(${$singularVar}['Link'][$k])) {
		switch ($k) {
			case 'country':
				$value = ${$singularVar}['Country']['name_'.TXT_LANG];
				break;
			default:
				$value = ${$singularVar}['Link'][$k];
				break;
		}
		
		$chl[] = $v.': '.$value;
	}
}

$chl = implode(PHP_EOL, $chl);

$query = array(
	'cht' => 'qr',
	'chs' => '200x200',
	'chl' => $chl,
	'chld' => 'L|0'
);

$imgUrl = $endpoint.http_build_query($query, '', '&amp;');

echo '<img src="'.$imgUrl.'" alt="QR code" />';
?>