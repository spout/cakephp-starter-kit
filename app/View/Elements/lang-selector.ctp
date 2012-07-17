<ul id="lang-selector">
	<?php foreach(Configure::read('Config.languages') as $k => $l):?>
		<li>
			<?php //echo $this->Html->link($this->Html->image('flags/'.$k.'.gif', array('alt' => $l['language'])).' '.h($l['language']), '/'.$k.'/', array('title' => $l['language'], 'escape' => false));?>
			<?php echo $this->Html->image('flags/'.$k.'.gif');?>&nbsp;<?php echo $this->Html->link($l['language'], '/'.$k.'/', array('title' => $l['language']));?>
		</li>
	<?php endforeach;?>
</ul>