<?php
App::import('Lib', 'Routing/Route/I18nRoute');

Router::parseExtensions('rss', 'json', 'kml', 'xml', 'js');

Router::connect('/', array('controller' => 'games', 'action' => 'index'), array('routeClass' => 'I18nRoute'));
Router::connect('/:lang', array('controller' => 'games', 'action' => 'index'), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

// Admin i18n routes
Router::connect('/:lang/admin/:controller', array('action' => 'index', 'admin' => true), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));
Router::connect('/:lang/admin/:controller/:action/*', array('admin' => true), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

Router::connect('/:lang/logiciels', array('controller' => 'pages', 'action' => 'display', 'logiciels'), array('routeClass' => 'I18nRoute'));

Router::connect('/:lang/pages/*', array('controller' => 'pages', 'action' => 'display'), array('routeClass' => 'I18nRoute'));

$routesAliases = array('fr' => 'jeux-gratuits', 'en' => 'free-games');
foreach ($routesAliases as $lang => $alias) {
	Router::connect('/:lang/'.$alias.'/:id-:slug/*', array('controller' => 'games', 'action' => 'view'), array('lang' => $lang, 'id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-_]+', 'pass' => array('id'), 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias, array('controller' => 'games', 'action' => 'index'), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias.'/:action/*', array('controller' => 'games'), array('action' => 'feed|search', 'lang' => $lang, 'routeClass' => 'I18nRoute'));
	Router::connect('/:lang/'.$alias.'/*', array('controller' => 'games', 'action' => 'index'), array('lang' => $lang, 'routeClass' => 'I18nRoute'));
}

Router::connect('/:lang/:controller/:id-:slug/*', array('action' => 'view'), array('lang' => '[a-z]{2}', 'id' => '[0-9]+', 'slug' => '[a-zA-Z0-9\-_]+', 'pass' => array('id', 'slug'), 'routeClass' => 'I18nRoute'));
Router::connect('/:lang/sitemap', array('controller' => 'sitemaps', 'action' => 'index'), array('lang' => '[a-z]{2}', 'routeClass' => 'I18nRoute'));

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