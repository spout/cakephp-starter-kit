<?php if(isset($item[$modelClass]['hitcount']) && !empty($item[$modelClass]['hitcount'])):?>
<?php echo sprintf(__('<strong>%d</strong> fois'), $item[$modelClass]['hitcount']);?>
<?php endif;?>