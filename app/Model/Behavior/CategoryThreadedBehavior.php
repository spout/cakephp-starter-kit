<?php
class CategoryThreadedBehavior extends ModelBehavior {
	public function setup(Model $Model, $settings = array()) {
		$Model->hasAndBelongsToMany['Category'] = array(
            'className' => 'Category',
            'foreignKey' => 'foreign_key',
            'associationForeignKey' => 'category_id',
            'with' => 'Categorized',
			'conditions' => array('Category.model' => $Model->alias),
			'unique' => true
        );
	}
	
	public function beforeSave(Model $Model) {
		$Model->unbindModel(array('hasAndBelongsToMany' => array('Category')));
		return true;
	}
	
	public function afterSave(Model $Model) {
		if (isset($Model->data['Category']['Category'])) {
			$categories = $Model->Categorized->find('list', array('fields' => array('id', 'id'), 'conditions' => array('Categorized.foreign_key' => $Model->id, 'Categorized.model' => $Model->alias)));
			$Model->Categorized->deleteAll(array('Categorized.id' => $categories , 'Categorized.foreign_key' => $Model->id, 'Categorized.model' => $Model->alias));
			
			if (!is_array($Model->data['Category']['Category'])) {
				$Model->data['Category']['Category'] = array($Model->data['Category']['Category']);
			}
			
			foreach ($Model->data['Category']['Category'] as $catId) {
				$Model->Categorized->create();
				$Model->Categorized->save(array('category_id' => $catId, 'foreign_key' => $Model->id, 'model' => $Model->alias));
			}
		}
		
		$this->updateItemCount($Model);
	}
	
	public function afterDelete(Model $Model) {
		$this->updateItemCount($Model);
	}
	
	public function updateItemCount(Model $Model) {
		$categories = $Model->Category->find('list', array('fields' => array('id', 'id'), 'conditions' => array('Category.model' => $Model->alias)));
		if (!empty($categories)) {
			if (isset($Model->hasAndBelongsToMany['Category'])) {
				$Model->bindModel(array('hasOne' => array('Categorized' => array('foreignKey' => 'foreign_key'))), false);
			}
			
			foreach ($categories as $catId) {
				$childIds = array_merge(array($catId), $Model->Category->getThreadedChildrenIds($catId));
				
				$activeCond = ($Model->hasField('active')) ? array($Model->alias.'.active' => 1) : array();
				
				if (isset($Model->hasAndBelongsToMany['Category'])) { // HABTM
					$conditions = array('Categorized.category_id' => $childIds, 'Categorized.model' => $Model->alias) + $activeCond;
					$itemCount = $Model->find('count', array('contain' => array('Categorized'), 'conditions' => $conditions));
				} /*elseif (isset($Model->belongsTo['Category'])) { // belongsTo
					$conditions = array($Model->alias.'.category_id' => $childIds) + $activeCond;
					$itemCount = $Model->find('count', array('conditions' => $conditions));
				}*/
				
				// if (isset($itemCount)) {
					$Model->Category->id = $catId;
					$Model->Category->saveField('item_count', $itemCount);
				// }
			}
		}
	}
}