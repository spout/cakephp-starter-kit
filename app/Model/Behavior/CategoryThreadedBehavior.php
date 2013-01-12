<?php
class CategoryThreadedBehavior extends ModelBehavior {
	
	public function setup(Model $Model, $settings = array()) {
		switch($settings['relationshipType']) {
			case 'belongsTo':
				$Model->belongsTo['Category'] = array(
					'className' => 'Category',
					'foreignKey' => 'category_id',
					'conditions' => array('Category.model' => $Model->alias),
				);
				break;
			
			case 'hasAndBelongsToMany':
				$Model->hasAndBelongsToMany['Category'] = array(
					'className' => 'Category',
					'foreignKey' => 'foreign_key',
					'associationForeignKey' => 'category_id',
					'with' => 'Categorized',
					'conditions' => array(
						'Category.model' => $Model->alias,
						'Categorized.model' => $Model->alias
					),
					'unique' => true
				);
				
				break;
			
			default:
				throw new Exception('Invalid or undefined relationType setting');
				break;
		}
	}
	
	public function afterSave(Model $Model) {
		if (isset($Model->data[$Model->alias]['Category']) && is_array($Model->data[$Model->alias]['Category'])) {
			$Model->bindModel(array('hasMany' => array('Categorized' => array('foreignKey' => 'foreign_key'))), false);
			
			$categories = $Model->Categorized->find('list', array('fields' => array('id', 'id'), 'conditions' => array('Categorized.foreign_key' => $Model->id, 'Categorized.model' => $Model->alias)));
			$Model->Categorized->deleteAll(array('Categorized.id' => $categories , 'Categorized.foreign_key' => $Model->id, 'Categorized.model' => $Model->alias));
			
			foreach ($Model->data[$Model->alias]['Category'] as $catId) {
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
				
				$conditions = array();
				if ($Model->hasField('active')) {
					$conditions[$Model->alias.'.active'] = 1;
				}
				
				if (isset($Model->hasAndBelongsToMany['Category'])) {
					$conditions['Categorized.category_id'] = $childIds;
					$conditions['Categorized.model'] = $Model->alias;
					
					$itemCount = $Model->find('count', array('contain' => array('Categorized'), 'conditions' => $conditions));
				} elseif (isset($Model->belongsTo['Category'])) {
					$conditions[$Model->alias.'.category_id'] = $childIds;
					
					$itemCount = $Model->find('count', array('conditions' => $conditions));
				}

				if (isset($itemCount)) {
					$Model->Category->id = $catId;
					$Model->Category->saveField('item_count', $itemCount);
				}
				
				unset($itemCount);
			}
		}
	}
}