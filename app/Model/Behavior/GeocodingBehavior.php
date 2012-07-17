<?php
App::uses('HttpSocket', 'Network/Http');
class GeocodingBehavior extends ModelBehavior {
    public $settings = array(); 
    
    public $addressComponentsTypes = array(
				'street_address',
				//'route',
				//'interserction',
				//'political',
				'country',
				'administrative_area_level_1',
				'administrative_area_level_2',
				'administrative_area_level_3',
				'colloquial_area',
				'locality',
				'sublocality',
				//'neightborhood',
				//'premise',
				//'subpremise',
				'postal_code',
				//'natural_feature',
				//'airport',
				//'park',
			);

    public function setup(&$Model, $settings) {
		//default settings
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = array(
				'address' => 'address',
				'lat' => 'lat',
				'lng' => 'lng',
				'address_components' => 'address_components',
				'country' => 'country',
				'city' => 'city',
				'postcode' => 'postcode',
				'language' => Configure::read('Config.defaultLanguage')
			);
		}
		
		$this->settings[$Model->alias] = array_merge(
			$this->settings[$Model->alias], (array)$settings
		);		
		
		//Google API URL
		$this->google = 'http://maps.google.com/maps/api/geocode/json';
		$this->googleQuery = array('sensor' => 'false', 'language' => $this->settings[$Model->alias]['language']);
		
		//http socket
		$this->connect = new HttpSocket(array('timeout' => 6000000));
		
		//error
		$this->error = null;
	}	

	public function beforeSave(&$Model){
		if (isset($Model->data[$Model->alias][$this->settings[$Model->alias]['lat']]) && !empty($Model->data[$Model->alias][$this->settings[$Model->alias]['lat']]) &&
			isset($Model->data[$Model->alias][$this->settings[$Model->alias]['lng']]) && !empty($Model->data[$Model->alias][$this->settings[$Model->alias]['lng']])) {
			$this->googleQuery['latlng'] = sprintf('%s,%s', $Model->data[$Model->alias][$this->settings[$Model->alias]['lat']], $Model->data[$Model->alias][$this->settings[$Model->alias]['lng']]);
		}
		else {
			$address = array();
			$addressFields = array($this->settings[$Model->alias]['city'], $this->settings[$Model->alias]['postcode'], $this->settings[$Model->alias]['address'], $this->settings[$Model->alias]['country']);
			
			foreach ($addressFields as $f) {
				if (isset($Model->data[$Model->alias][$this->settings[$Model->alias][$f]]) && !empty($Model->data[$Model->alias][$this->settings[$Model->alias][$f]])) {
					$address[$f] = $Model->data[$Model->alias][$f];
				}
			}
			
			if (count($address) == 1 && isset($address[$this->settings[$Model->alias]['country']])) {
				$resetFields = array($this->settings[$Model->alias]['address_components'], $this->settings[$Model->alias]['lat'], $this->settings[$Model->alias]['lng']);
				
				foreach ($resetFields as $f) {
					$Model->data[$Model->alias][$f] = '';
				}
				
				return true;//only country is given as geocoding data, no accurate results
			}
			
			$this->googleQuery['address'] = urlencode(join(' ', $address));
		}
		
		$response = $this->connect->get($this->google, $this->googleQuery);
		$json = json_decode($response);
		
		//let s check the response by status code
		if ($this->_isOk($json->status)) {
			$addressComponents = $this->_addressComponents($json);
			
			$Model->data[$Model->alias][$this->settings[$Model->alias]['lat']] = $json->results[0]->geometry->location->lat;
			$Model->data[$Model->alias][$this->settings[$Model->alias]['lng']] = $json->results[0]->geometry->location->lng;
			$Model->data[$Model->alias][$this->settings[$Model->alias]['address_components']] = serialize($addressComponents);
			
			if (!isset($Model->data[$Model->alias][$this->settings[$Model->alias]['country']]) || empty($Model->data[$Model->alias][$this->settings[$Model->alias]['country']])) {
				$Model->data[$Model->alias][$this->settings[$Model->alias]['country']] = isset($addressComponents['country']['short_name']) ? strtolower($addressComponents['country']['short_name']) : '';
			}
			
			if (!isset($Model->data[$Model->alias][$this->settings[$Model->alias]['city']]) || empty($Model->data[$Model->alias][$this->settings[$Model->alias]['city']])) {
				$Model->data[$Model->alias][$this->settings[$Model->alias]['city']] = isset($addressComponents['locality']['long_name']) ? $addressComponents['locality']['long_name'] : '';
			}
			
			if (!isset($Model->data[$Model->alias][$this->settings[$Model->alias]['address']]) || empty($Model->data[$Model->alias][$this->settings[$Model->alias]['address']])) {
				//$Model->data[$Model->alias][$this->settings[$Model->alias]['address']] = $json->results[0]->formatted_address;
			}
			
			if (!isset($Model->data[$Model->alias][$this->settings[$Model->alias]['postcode']]) || empty($Model->data[$Model->alias][$this->settings[$Model->alias]['postcode']])) {
				$Model->data[$Model->alias][$this->settings[$Model->alias]['postcode']] = isset($addressComponents['postal_code']['long_name']) ? $addressComponents['postal_code']['long_name'] : '';
			}
			
			return true;
		} else {
			return true;
			//$Model->invalidate($this->settings[$Model->alias]['address'], $this->error);
			//return false;
		}
	}
	
	private function _isOk($status){
		switch($status){
				case 'OK':
					return true;
					break;
				case 'ZERO_RESULTS':
					$this->error = __('Non-existent address');
					return false;
					break;
				case 'OVER_QUERY_LIMIT':
					$this->error = __('Over requests');
					return false;
					break;
				case 'REQUEST_DENIED':
					$this->error = __('Request was denied');
					return false;
					break;
				case 'INVALID_REQUEST':
					$this->error = __('Address was missing');
					return false;
					break;
				default:
					$this->error = __('Unknown error');
					return false;
					break;
		}
	}
	
	/*
	http://code.google.com/intl/fr/apis/maps/documentation/javascript/services.html#GeocodingAddressTypes
	*/
	private function _addressComponents($json){
		if (isset($json->results[0]->address_components)) {
			$addressComponents = $json->results[0]->address_components;
			$tmp = array();
			foreach ($addressComponents as $a) {
				foreach ($a->types as $t) {
					if (in_array($t, $this->addressComponentsTypes)) {
						$tmp[$t] = (array)$a;
						unset($tmp[$t]['types']);
					}
				}
			}
			if (!empty($tmp)) {
				return $tmp;
			}
			else {
				return false;
			}
		}
		else return false;
	}
}
?>