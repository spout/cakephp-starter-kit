<?php 
class PhotosController extends AppController {
	public $paginate = array(
		'Photo' => array('limit' => 10, 'order' => array('Photo.created' => 'desc'))
	);
	
	public $photosBasePath = 'uploads/images/photos/';
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->set('photosBasePath', $this->photosBasePath);
	}
}
?>