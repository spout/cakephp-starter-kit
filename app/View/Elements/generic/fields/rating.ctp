<?php 
$id = $item[$modelClass]['id'];
$numStars = isset($numStars) ? $numStars : 5;
$this->Html->script('jquery/jquery.rating.pack.js', false);
$this->Html->css('jquery.rating/jquery.rating', null, array('inline' => false));

$ratingFormId = $modelClass.'Ratings';

$ratingUrl = $this->Html->url(array('action' => 'rating', $id));
$scriptBlock = <<<EOT
	$(function(){
		$(".star-rating").rating({
			callback: function(value, link){
				$.post(
					"{$ratingUrl}", 
					{'data[{$modelClass}][rate]': value}, 
					function(data) {
						$("#stars-cap").html(data);
						$(".star-rating").rating('disable');
					}
				);
			}
		});
		
		$("#{$ratingFormId} label").hide();
	});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));
?>

<?php echo $this->Form->create($modelClass, array('id' => $ratingFormId, 'url' => array('action' => 'rating', $id)));?>
<fieldset>
<?php
$inputs = array();
for($i = 1; $i <= $numStars; $i++) {
	$ratingTitle = __('Donner une note de %s', sprintf('%01.2F/5.00', $i));
	$domId = $modelClass.'Rate'.$i;
	$checked = ($i == round($item[$modelClass]['rating_avg'])) ? ' checked=""' : '';
	$inputs[] = '<input type="radio" name="data['.$modelClass.'][rate]" value="'.$i.'" title="'.$ratingTitle.'" class="star-rating" id="'.$domId.'"'.$checked.' /> <label for="'.$domId.'">'.$i.'</label>';
}

echo join(PHP_EOL, $inputs);
?>
</fieldset>
<?php echo $this->Form->end();?>
<div class="clear"></div>
<span id="stars-cap">&nbsp;</span>
<p>
	<?php echo __('Note moyenne: %01.2F/5.00 avec %d évaluation(s)', $item[$modelClass]['rating_avg'], $item[$modelClass]['rating_count']);?>
</p>