<?php 
class Payment extends AppModel {
	public function updateAwards($model, $id, $awards) {
		ClassRegistry::init($model)->updateAll(
			array(
				$model.'.awards' => "awards + $awards",
				//$model.'.awards_payment_date' => "'".date('Y-m-d H:i:s')."'",
				//$model.'.awards_bonus' => $awards * 0.1
			),
			array($model.'.id' => $id)
		);
	}
}
?>