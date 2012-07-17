<?php if(isset($links) && !empty($links)):?>
	<?php echo $this->element('paginator-count');?>
	<?php echo $this->element('paginator-links');?>
	<ul>
	<?php foreach($links as $link):?>
		<?php 
		$thumbUrl = 'http://thumbs.toolki.com/?url='.urlencode($link['Link']['url']);
		?>
		<li class="inline">
			<a href="<?php echo $thumbUrl;?>" onclick="window.open(this.href);return false;"><img src="<?php echo $thumbUrl;?>" alt="" style="margin: 5px;" /></a>
		</li>
	<?php endforeach;?>
	</ul>
	<?php echo $this->element('paginator-links');?>
<?php endif;?>