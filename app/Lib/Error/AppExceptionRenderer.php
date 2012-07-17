<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {
    public function __construct(Exception $exception) {
		parent::__construct($exception);
		
		$this->controller->beforeFilter();
		
		$code = $exception->getCode();
		if ($code == '404') {
			//$this->controller->flash(__('Page non trouvée.'), 'Error');
			//$this->controller->redirect('/');
		}
	}
}
?>