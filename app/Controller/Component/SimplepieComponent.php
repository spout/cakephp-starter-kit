<?php
/*
 * SimplePie CakePHP Component
 * Copyright (c) 2007 Matt Curry
 * www.PseudoCoder.com
 *
 * Based on the work of Scott Sansoni (http://cakeforge.org/snippet/detail.php?type=snippet&id=53)
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     1.0
 * @license     MIT
 *
 */

class SimplepieComponent extends Component {
	public $cache;

	public function __construct() {
		$this->cache = CACHE . 'simplepie' . DS;
	}

	public function feed($feed_url) {
		//include the vendor class
		App::import('Vendor', 'SimplePie', array('file' => 'simplepie/simplepie.inc'));

		//setup SimplePie
		$feed = new SimplePie();
		$feed->set_feed_url($feed_url);
		$feed->set_cache_location($this->cache);

		//retrieve the feed
		$feed->init();

		return $feed;
	}
}