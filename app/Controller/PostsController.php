<?php 
class PostsController extends AppController {
	public $helpers = array('Shortcode');
	public $paginate = array('limit' => 10, 'order' => array('Post.created' => 'desc'));
	
	public function beforeFilter() {
		parent::beforeFilter();
	
		$this->Crud->enableAction('add');
	}
}