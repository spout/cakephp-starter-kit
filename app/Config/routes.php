<?php
App::import('Lib', 'Routing/Route/I18nRoute');

Router::parseExtensions('rss', 'json', 'kml', 'xml', 'js');

// Router::connect('/', array('controller' => 'bookmarks', 'action' => 'index'), array('routeClass' => 'I18nRoute'));
// Router::connect('/:lang', array('controller' => 'bookmarks', 'action' => 'index'), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

Router::connect('/', array('controller' => 'homepages', 'action' => 'index'), array('routeClass' => 'I18nRoute'));
Router::connect('/:lang/', array('controller' => 'homepages', 'action' => 'index'), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

Router::connect('/:lang/logiciels', array('controller' => 'pages', 'action' => 'display', 'logiciels'), array('routeClass' => 'I18nRoute'));

Router::connect('/:lang/pages/*', array('controller' => 'pages', 'action' => 'display'), array('routeClass' => 'I18nRoute'));

$routesAliases = array(
	'links' => array('fr' => 'annuaire', 'en' => 'directory'),
	'ads' => array('fr' => 'annonces', 'en' => 'ads'),
	'places' => array('fr' => 'sources', 'en' => 'springs'),
	'posts' => array('fr' => 'blog', 'en' => 'blog'),
);

$genericActionsRoutes = 'view|add|edit|delete|feed|markers|map|count_clicks|message|autocomplete|comment|search|save_field|accept|rating|browse|filemanager|sponsor|datatable|ajax_pagination';

foreach ($routesAliases as $controller => $aliases) {
	foreach ($aliases as $lang => $alias) {
		Router::connect('/:lang/:prefix/'.$alias, array('controller' => $controller, 'action' => 'index', 'prefix' => 'admin', 'admin' => true), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
		Router::connect('/:lang/:prefix/'.$alias.'/*', array('controller' => $controller, 'prefix' => 'admin', 'admin' => true), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
		
		Router::connect('/:lang/'.$alias.'/:id-:slug', array('controller' => $controller, 'action' => 'view'), array('lang' => $lang, 'id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-_]+', 'pass' => array('id'), 'routeClass' => 'I18nRoute'));
		
		Router::connect('/:lang/'.$alias, array('controller' => $controller, 'action' => 'index'), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
		
		Router::connect('/:lang/'.$alias.'/:action/:cat_slug/:country/*', array('controller' => $controller), array('lang' => $lang, 'action' => 'feed|markers', 'cat_slug' => '[a-zA-Z0-9\-_]+', 'country' => '[a-zA-Z0-9\-_]+', 'routeClass' => 'I18nRoute'));
		Router::connect('/:lang/'.$alias.'/:action/:cat_slug/*', array('controller' => $controller), array('lang' => $lang, 'action' => 'feed|markers', 'cat_slug' => '[a-zA-Z0-9\-_]+', 'routeClass' => 'I18nRoute'));
		
		Router::connect('/:lang/'.$alias.'/:action/*', array('controller' => $controller), array('lang' => $lang, 'action' => $genericActionsRoutes, 'routeClass' => 'I18nRoute'));
		Router::connect('/:lang/'.$alias.'/:cat_slug/:country/*', array('controller' => $controller, 'action' => 'index'), array('lang' => $lang, 'cat_slug' => '[a-zA-Z0-9\-_]+', 'country' => '[a-zA-Z0-9\-_\,]+', 'routeClass' => 'I18nRoute'));
		Router::connect('/:lang/'.$alias.'/:cat_slug/*', array('controller' => $controller, 'action' => 'index'), array('lang' => $lang, 'cat_slug' => '[a-zA-Z0-9\-_]+', 'routeClass' => 'I18nRoute'));
		Router::connect('/:lang/'.$alias.'/*', array('controller' => $controller, 'action' => 'index'), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
	}
}

$routesAliases = array('fr' => 'agenda', 'en' => 'calendar');
foreach ($routesAliases as $lang => $alias) {
	Router::connect('/:lang/'.$alias.'/:id-:slug', array('controller' => 'events', 'action' => 'view'), array('lang' => $lang, 'id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-_]+', 'pass' => array('id'), 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias.'/:action/*', array('controller' => 'events'), array('lang' => $lang, 'action' => $genericActionsRoutes.'|fullcalendar', 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias.'/:country/:year/:month/*', array('controller' => 'events', 'action' => 'index'), array('lang' => $lang, 'country' => '[a-zA-Z0-9\-_\,]+', 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias.'/:country/:year/*', array('controller' => 'events', 'action' => 'index'), array('lang' => $lang, 'country' => '[a-zA-Z0-9\-_\,]+', 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias.'/:country', array('controller' => 'events', 'action' => 'index'), array('lang' => $lang, 'country' => '[a-zA-Z0-9\-_\,]+', 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias, array('controller' => 'events', 'action' => 'index'), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
}

$routesAliases = array('fr' => 'boutique', 'en' => 'shop');
foreach ($routesAliases as $lang => $alias) {
	Router::connect('/:lang/'.$alias.'/*', array('controller' => 'shops', 'action' => 'index'), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
}


Router::connect('/:lang/:controller/:id-:slug/*', array('action' => 'view'), array('lang' => '[a-z]{2}', 'id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-_]+', 'pass' => array('id', 'slug'), 'routeClass' => 'I18nRoute'));
Router::connect('/:lang/sitemap', array('controller' => 'sitemaps', 'action' => 'index'), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

// Admin i18n routes
Router::connect('/:lang/admin/:controller', array('action' => 'index', 'admin' => true), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));
Router::connect('/:lang/admin/:controller/:action/*', array('admin' => true), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

Router::connect('/:lang/:controller', array('action' => 'index'), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));
Router::connect('/:lang/:controller/:action/*', array(), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';