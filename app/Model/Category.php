<?php 
class Category extends AppModel {
	public $name = 'Category';
	public $validate = array();
	
	public function __construct($id = FALSE, $table = NULL, $ds = NULL) {
		parent::__construct($id, $table, $ds);
		$this->displayField = 'name_'.TXT_LANG;
		
		$this->validate = array(
			'name_'.TXT_LANG => array(
				'required' => array('rule' => array('notEmpty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Champ requis'))
			),
			'slug_'.TXT_LANG => array(
				'required' => array('rule' => array('notEmpty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Champ requis'))
			)
		);
	}
	
	public function generateThreadedList($conditions = NULL, $keyPath = NULL, $valuePath = NULL, $spacer = '__') {
		$keyPath = empty($keyPath) ? $this->primaryKey : $keyPath;
		$valuePath = empty($valuePath) ? $this->displayField : $valuePath;
	
		$list = $this->find('threaded', array('conditions' => $conditions, 'order' => $this->displayField));
		$list = $this->threadedToList($list, $keyPath, $valuePath, $spacer);
		
		return $list;
	}
	
	/*public function threadedToList($data_array, $keyPath = 'id', $valuePath = 'name', $spacer = '__', $counter = 0) {
		$list = array();
		
		foreach ($data_array as $data) {
			if ($counter == 0) {
				if (empty($data['children'])) {
					$list[$data[$this->alias]['id']] = array('name' => $data[$this->alias][$valuePath], 'value' => $data[$this->alias][$keyPath], 'class' => 'select-option-level-'.$counter);
				} else {
					$list[h($data[$this->alias][$valuePath])] = $this->threadedToList($data['children'], $keyPath, $valuePath, $spacer, $counter + 1);
				}
			} else {
				$sep = str_repeat($spacer, $counter - 1);
				$sep = empty($sep) ? '' : $sep.' ';
				$list[$data[$this->alias]['id']] = array('name' => $sep.$data[$this->alias][$valuePath], 'value' => $data[$this->alias][$keyPath], 'class' => 'select-option-level-'.$counter); 
				if (!empty($data['children'])) {
					$listSub = $this->threadedToList($data['children'], $keyPath, $valuePath, $spacer, $counter + 1);
					foreach ($listSub as $sk => $sv) {
						$list[$sk] = $sv;
					}
				}
			}
		}
		
		return $list;
	}*/
	
	public function threadedToList($data_array, $keyPath = 'id', $valuePath = 'name', $spacer = '__', &$list = array(), $counter = 0) {
		if (!is_array($data_array)) {
			return array();
		}
		
		foreach ($data_array as $data) {
			$name = str_repeat($spacer, $counter).' '.$data[$this->alias][$valuePath];
			$list[$data[$this->alias]['id']] = array('name' => $name, 'value' => $data[$this->alias][$keyPath], 'class' => 'select-option-level-'.$counter);
			if (!empty($data['children'])) {
				$this->threadedToList($data['children'], $keyPath, $valuePath, $spacer, $list, $counter + 1);
			}
		}
		
		return $list;
	}
	
	public function getThreadedChildrenIds($id) {
		$childIds = $this->find('list', array('conditions' => array('parent_id' => $id), 'fields' => array('id')));
		
		if (empty($childIds)) {
			return array();
		}
	
		$childIdsTmp = array();
		foreach ($childIds as $key => $c) {
			$childIdsTmp = array_merge($childIdsTmp, $this->getThreadedChildrenIds($key));
		}
		
		$childIds = array_merge($childIds, $childIdsTmp);
		
		return $childIds;
	}

	public function getThreadedPath($id, $path = array()) {
		if ($id == 0) {
			if (!empty($path) || count($path) > 1) {
				$path = array_reverse($path);
			}
			return $path;
		}
	
		$row = $this->find('first', array('conditions' => array($this->name.'.id' => $id)));
	
		if (!$row) {
			return array();
		}

		$path[] = $row;
		$parent_id = $row[$this->name]['parent_id'];
	
		return $this->getThreadedPath($parent_id, $path);
	}
	
	public function getThreadedPathBySlug($slug) {
		$cacheFile = implode('_', array($this->alias, __FUNCTION__, $slug));
		$catPath = Cache::read($cacheFile);
		if (empty($catPath)) {
			$cat = $this->findBySlug($slug);
			$catPath = $this->getThreadedPath($cat['Cat']['id']);
			Cache::write($cacheFile, $catPath);
		}
		return $catPath;
	}
	
	public function findBySlug($slug) {
		$findBy = 'findBySlug'.ucfirst(TXT_LANG);
		return $this->{$findBy}($slug);
	}
}