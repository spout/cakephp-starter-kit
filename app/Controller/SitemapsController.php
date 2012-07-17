<?php
class SitemapsController extends AppController {
	public $uses = array('Game');
	
	public function index() {
		$this->layout = 'sitemap';
		
		$games = $this->Game->find('all', array('conditions' => array('Game.active' => 1)));
		$gameCategories = $this->Game->Category->find('all');
		
		$this->set(compact('games', 'gameCategories'));
	}
}