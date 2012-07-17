<?php 
App::import('Vendor', 'Teads', array('file' => 'teads/lib/teads.class.php'));

$urlSuccess = Router::url(array('controller' => 'payments', 'action' => 'teads', $item[$modelClass]['id']), true);
$teads = new Teads(16843, $urlSuccess);
echo $teads->generateForm();
?>
<a href="javascript:void(0)" onclick="document.getElementById('teads_form').submit()"><?php echo __('Gagner %d points pour cette fiche en regardant une publicité', 5);?></a>