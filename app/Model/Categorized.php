<?php
class Categorized extends AppModel {
	public $name = 'Categorized';
	public $useTable = 'categorized';
	public $belongsTo = array('Category');
}