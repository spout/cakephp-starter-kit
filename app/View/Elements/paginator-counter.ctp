<div class="paginator-counter">
<?php 
echo $this->Paginator->counter(array(
	'format' => __('Total: <strong>%count%</strong> - Résultats: <strong>%start%</strong> - <strong>%end%</strong> - Page: <strong>%page%</strong> sur <strong>%pages%</strong>')
)); 
?>
</div>