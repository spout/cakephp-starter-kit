<?php
App::import('Vendor', 'functions');

/**
 * Set include_path for PEAR
 */
// define('PEAR', APP.'Vendor'.DS.'Pear'.DS);
// ini_set('include_path', PEAR.PATH_SEPARATOR.ini_get('include_path'));

/**
 * MinifyAsset plugin
 */
// Configure::write('MinifyAsset', true);

/**
 * Theme
 */
Configure::write('Config.theme', 'Equidir');

/**
 * Load plugins
 */
CakePlugin::loadAll();
// CakePlugin::load('TwitterBootstrap', array('bootstrap' => false));

/**
 * Configures exception renderer
 */
Configure::write('Exception.renderer', 'AppExceptionRenderer');

/**
 * Configures languages
 */
Configure::write('Config.defaultLanguage', 'fr');
Configure::write('Config.languages', array(
		'fr' => array(
			'language' => 'Français',
			'locale' => 'fre',
			'localeFallback' => 'eng',
			'charset' => 'utf-8'
		),
		'en' => array(
			'language' => 'English',
			'locale' => 'eng',
			'localeFallback' => 'fre',
			'charset' => 'utf-8'
		),
	)
);

/**
 * Configures AppController public controller actions
 */
Configure::write('Config.publicActions', 
	array(
		'login',
		'logout',
		'register',
		'display',
		'index',
		'view',
		'feed',
		'markers',
		'map',
		'count_clicks',
		'message',
		'autocomplete',
		'comment',
		'search',
		'rating',
		'datatable',
	)
);

/**
 * Extra content types
 */
Configure::write('Config.extraContentTypes', array(
	'kml' => 'application/vnd.google-earth.kml+xml'
));

/**
 * http://www.dereuromark.de/2012/04/07/auth-inline-authorization-the-easy-way/
 */
define('USER_ROLE_KEY', 'role_id');
$roles = array(
	'admin' => 1,
	'editor' => 2,
	'contributor' => 3,
	'user' => 4,
);

foreach ($roles as $role => $roleId) {
	define('ROLE_'.strtoupper($role),  $roleId);
}

Configure::write('Role', $roles);
App::uses('Auth', 'Tools.Lib');

/**
 * 
 */
Configure::write('Sitemaps.models', array('Link', 'Ad', 'Event'));

/**
 * Configures default cache engine
 */
Cache::config('default', array('engine' => 'File'));

/**
 * Configures dispatcher filters
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));