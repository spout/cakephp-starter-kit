<?php 
class PostsController extends AppController {
	public $name = 'Posts';
	public $helpers = array('Shortcode');
	public $paginate = array('limit' => 10, 'order' => array('Post.created' => 'desc'));
}