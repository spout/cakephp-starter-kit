<?php
class SpoutbeComponent extends Component {
	public function beforeRender(Controller $controller) {
		/*$subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));
		if ($subdomain == 'm') {
			$this->theme = 'Mobile';
		}*/
		
		$modulesTitles = array(
			'users' => __('Membres'),
			'links' => __('Annuaire'),
			'photos' => __('Photos'),
			'games' => __('Jeux gratuits'),
			'categories' => __('Catégories'),
			'file_manager' => __('Gestionnaire de fichiers'),
			'contact' => __('Contact'),
		);
		
		if (array_key_exists($controller->request->params['controller'], $modulesTitles)) {
			$moduleTitle = $modulesTitles[$controller->request->params['controller']];
			$controller->set(compact('moduleTitle'));
		}
	}
}