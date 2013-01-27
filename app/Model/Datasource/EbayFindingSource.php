<?php
class EbayFindingSource extends DataSource {
	public $endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';
	public $query =  array(
		'SERVICE-VERSION' => '1.0.0',
		'GLOBAL-ID' => 'EBAY-FR',//default
		'affiliate.networkId' => 9, //9 = eBay Partner Network 
		'outputSelector' => 'GalleryInfo'
	);

	public function __construct($config) {
		parent::__construct($config);
		$this->query['SECURITY-APPNAME'] = $this->config['SECURITY-APPNAME'];
		$this->query['affiliate.trackingId'] = $this->config['affiliate.trackingId'];
	}
	
	public function describe(&$model) {
		return null;
	}
	
	public function listSources($data = null) {
        return array('ebayFindings');
    }
    
	public function calculate($model, $func, $params = array()) {
		return '__'.$func;
	}
    
    public function read(&$model, $queryData = array()) {
		$this->query['OPERATION-NAME'] = 'findItemsIneBayStores';
		
		if (isset($queryData['conditions']) && !empty($queryData['conditions'])) {
			foreach ($queryData['conditions'] as $k => $v) {
				$this->query[$k] = $v;
			}	
		}
		
		if (isset($queryData['page']) && !empty($queryData['page'])) {
			$this->query['paginationInput.pageNumber'] = $queryData['page'];
		}
		
		if (isset($queryData['limit']) && !empty($queryData['limit'])) {
			$this->query['paginationInput.entriesPerPage'] = $queryData['limit'];
		}
		
		if (isset($queryData['sort']) && !empty($queryData['sort'])) {
			switch ($queryData['sort']) {
				case 'time':
					$this->query['sortOrder'] = (isset($queryData['direction']) && $queryData['direction'] == 'desc') ? 'StartTimeNewest' : 'EndTimeSoonest';
					break;
					
				case 'price':
					$this->query['sortOrder'] = (isset($queryData['direction']) && $queryData['direction'] == 'desc') ? 'PricePlusShippingHighest' : 'PricePlusShippingLowest';
					break;	
					
				default:
					break;	
			}
		}
		
		$cacheFile = 'EbayFindingSource'.md5(serialize($this->query));
		if (($response = Cache::read($cacheFile)) === false) {
			$response = Xml::toArray(Xml::build($this->endpoint.'?'.http_build_query($this->query)));
			Cache::write($cacheFile, $response);
		}
		
		//debug($this->query);
		//pr($response);
		
		if ($response['findItemsIneBayStoresResponse']['ack'] == 'Success' && isset($response['findItemsIneBayStoresResponse']['searchResult']['item'])) {
			//return item count
			if (Set::extract($queryData, 'fields') == '__count' ) {
				return array(array($model->alias => array('count' => $response['findItemsIneBayStoresResponse']['paginationOutput']['totalEntries'])));
			}
			
			$items = $response['findItemsIneBayStoresResponse']['searchResult']['item'];
			
			$result = array();
			foreach($items as $item) {
				$result[] = array($model->alias => $item);
			}
			
			return $result;
		} else {
			return false;
		}
    }
}