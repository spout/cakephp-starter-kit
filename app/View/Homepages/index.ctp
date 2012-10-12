<?php 
$this->set('title_for_layout', __('Annuaire du cheval, petites annonces équitation et agenda équestre'));
$this->set('h1_for_layout', __('Le portail du cheval et de l\'équitation'));
$this->set('metaDescription', __('Portail équestre international: Equidir vous propose toute l\'information sur le monde des chevaux à travers son annuaire du cheval, ses annonces sur l\'équitation et son agenda équestre.'));
?>
<?php 
/*$this->Html->script('jquery/jquery.mousewheel.js', false);
$this->Html->script('jquery/jquery.jscrollpane.min.js', false);

$scriptBlock = <<<EOT
$(function(){
	$('.homepages-scroll-pane').jScrollPane();
});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));*/

$sliderDir = 'slider/';
$sliderPath = App::themePath($this->theme).'webroot/img/'.$sliderDir;

$sliderFiles = glob($sliderPath.'*');

$sliderAppendJs = '';
if (!empty($sliderFiles)) {
	shuffle($sliderFiles);
	$sliderFiles = array_slice($sliderFiles, 0, 3);
	$oneSlider = array_shift($sliderFiles);
	
	if (!empty($sliderFiles)) {
		$sliderAppendJs = '';
		foreach ($sliderFiles as $filename) {
			$sliderAppendJs .= $this->Js->escape('<li>'.$this->Html->image($sliderDir.basename($filename)).'</li>');
		}
		
		$sliderAppendJs = (!empty($sliderAppendJs)) ? '$("#slider").append("'.$sliderAppendJs.'")' : '';
	}
}

$carouselId = 'homepage-carousel';

$scriptBlock = <<<EOT
$(function(){
	$('#{$carouselId}').carousel();
});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));

/*$this->Html->script('jquery/jquery.carouFredSel-5.5.0-packed.js', false);

$scriptBlock = <<<EOT
$(function(){
	{$sliderAppendJs}
	$("#slider").carouFredSel({
		circular: true,
		infinite: true,
		
		auto: {
			pauseOnHover: true,
			pauseDuration: 4000
		},
		scroll	: {
			items : 1,
			easing : "swing",
			fx : "crossfade"
		},
		prev	: {	
			button	: "#slider-prev",
			key		: "left"
		},
		next	: { 
			button	: "#slider-next",
			key		: "right"
		},
		pagination	: "#slider-pagination"
	});
});
EOT;
$this->Html->scriptBlock($scriptBlock, array('inline' => false));*/
?>

<div id="<?php echo $carouselId;?>" class="carousel slide">
	<div class="carousel-inner">
		<?php foreach ($sliderFiles as $k => $filename):?>
			<div class="item<?php if($k == 0):?> active<?php endif;?>">
				<?php echo $this->Html->image($sliderDir.basename($filename));?>
			</div>
		<?php endforeach;?>
	</div>
	
	<a class="carousel-control left" href="#<?php echo $carouselId;?>" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#<?php echo $carouselId;?>" data-slide="next">&rsaquo;</a>
</div>

<?php /*if(isset($sliderDir) && isset($oneSlider) && !empty($oneSlider)):?>
	<div id="homepages-slider">
		<ul id="slider">
			<li><?php echo $this->Html->image($sliderDir.basename($oneSlider));?></li>
		</ul>
		<div class="clear"></div>
		<div id="slider-bottom"></div>
	
		<a id="slider-prev" href="javascript:void(0)"><span>prev</span></a>
		<a id="slider-next" href="javascript:void(0)"><span>next</span></a>
		<div id="slider-pagination"></div>
	</div>
<?php endif;*/?>

<div class="grid_12 alpha">
	<div class="homepages-about">
		<?php echo $this->element('about');?>
	</div>
	
	<?php 
	$fbLike = '<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fequidir&amp;width=470&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23FAFAF5&amp;stream=false&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:470px; height:290px;" allowTransparency="true"></iframe>';
	echo $this->Html->scriptBlock('document.write("'.$this->Js->escape($fbLike).'");');
	?>
</div>

<div class="grid_12 omega">
	<?php if(isset($links) && !empty($links)):?>
		<div class="homepages-links">
			<h2><?php echo $this->Html->link(__('Annuaire'), array('controller' => 'links', 'action' => 'index'));?> <?php echo $this->Html->link($this->Html->image('icons/silk/feed.png', array('alt' => 'RSS')), array('controller' => 'links', 'action' => 'feed.rss'), array('escape' => false, 'title' => __('RSS')));?></h2>
			<ul>
			<?php foreach($links as $link):?>
				<?php 
				$title = getPreferedLang($link['Link'], 'title');
				?>
				<li><?php echo $this->Html->image('flags/'.$link['Link']['country'].'.gif');?>&nbsp;<?php echo $this->Html->link($title, array('controller' => 'links', 'action' => 'view', 'id' => $link['Link']['id'], 'slug' => slug($title)));?><?php /*if(!empty($link['Link']['city'])):?> - <?php echo h($link['Link']['city']);?><?php endif;*/?></li>
			<?php endforeach;?>
			</ul>
			<div class="clear"></div>
			<p id="homepages-links-stats">
				<?php echo __('L\'annuaire référence <strong>%d</strong> activités équestres dont <strong>%d</strong> liens.', $linksCount, $linksUrlsCount);?>
			</p>
		</div>
	<?php endif;?>
	
	<?php if(isset($ads) && !empty($ads)):?>
		<div class="homepages-ads">
			<h2><?php echo $this->Html->link(__('Annonces'), array('controller' => 'ads', 'action' => 'index'));?> <?php echo $this->Html->link($this->Html->image('icons/silk/feed.png', array('alt' => 'RSS')), array('controller' => 'ads', 'action' => 'feed.rss'), array('escape' => false, 'title' => __('RSS')));?></h2>
			<ul>
			<?php foreach($ads as $ad):?>
				<?php 
				$title = getPreferedLang($ad['Ad'], 'title');
				$thumb = $this->element('phpthumb', array('src' => 'files/annonces/photo_1/'.$ad['Ad']['id'].'/'.$ad['Ad']['photo_1'], 'w' => 120, 'h' => 100, 'zc' => 1));
				?>
				<li>
					<p><?php echo $this->Html->link($thumb, array('controller' => 'ads', 'action' => 'view', 'id' => $ad['Ad']['id'], 'slug' => slug($title)), array('escape' => false));?></p>
					<p><?php /*<?php echo $this->Html->image('flags/'.$ad['Ad']['country'].'.gif');?>&nbsp;*/?><?php echo $this->Html->link($title, array('controller' => 'ads', 'action' => 'view', 'id' => $ad['Ad']['id'], 'slug' => slug($title)));?><?php /*if(!empty($ad['Ad']['city'])):?> - <?php echo h($ad['Ad']['city']);?><?php endif;*/?></p>
				</li>
			<?php endforeach;?>
			</ul>
			<div class="clear"></div>
		</div>
	<?php endif;?>
	<?php if(isset($events) && !empty($events)):?>
		<div class="homepages-events">
			<h2><?php echo $this->Html->link(__('Agenda'), array('controller' => 'events', 'action' => 'index'));?> <?php echo $this->Html->link($this->Html->image('icons/silk/feed.png', array('alt' => 'RSS')), array('controller' => 'events', 'action' => 'feed.rss'), array('escape' => false, 'title' => __('RSS')));?></h2>
			<ul>
			<?php foreach($events as $event):?>
				<?php 
				$title = getPreferedLang($event['Event'], 'title');
				?>
				<li>
					<p><?php echo $this->Html->image('flags/'.$event['Event']['country'].'.gif');?>&nbsp;<?php echo $this->Html->link($title, array('controller' => 'events', 'action' => 'view', 'id' => $event['Event']['id'], 'slug' => slug($title)));?></p>
					<p><span class="underline"><?php echo __('Du');?></span>: <?php echo $this->MyHtml->niceDate($event['Event']['date_start'], '%e %B %Y');?> - <span class="underline"><?php echo __('Au');?></span>: <?php echo $this->MyHtml->niceDate($event['Event']['date_end'], '%e %B %Y');?></p>
				</li>
			<?php endforeach;?>
			</ul>
			<div class="clear"></div>
		</div>
	<?php endif;?>
</div>
<div class="clear"></div>