<?php 
$totalWidth = 16 * 5;
$percent = $item[$modelClass]['rating_avg'] / 5;
$width = $percent * $totalWidth;
$ratingTitle = __('%s/5.00 avec %d évaluation(s)', $item[$modelClass]['rating_avg'], $item[$modelClass]['rating_count']);
?>
<div class="star-rating">
	<div class="star-rating-value" style="width:<?php echo $width;?>px;" title="<?php echo $ratingTitle;?>"></div>
</div>