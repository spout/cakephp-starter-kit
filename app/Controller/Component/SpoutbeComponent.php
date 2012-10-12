<?php
class SpoutbeComponent extends Component {
	public function beforeRender(Controller $controller) {
		$controller->theme = 'Equidir';

		$modulesTitles = array(
			'users' => __('Membres'),
			'links' => __('Annuaire'),
			'ads' => __('Annonces'),
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