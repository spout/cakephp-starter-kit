<?php 
$urlDisplay = !empty($item[$modelClass]['url_display']) ? $item[$modelClass]['url_display'] : $item[$modelClass]['url'];
if (!empty($urlDisplay)):
$countClickUrl = $this->Html->url(array('action' => 'count_clicks', $item[$modelClass]['id']));
$urlPath = parse_url($urlDisplay, PHP_URL_PATH);
?>
<a href="<?php echo $urlDisplay;?>" onclick="location='<?php echo $countClickUrl;?>';return false;" onmouseover="window.status='<?php echo $urlDisplay;?>';return true;" onmouseout="self.status='';return true;"><?php echo parse_url($urlDisplay, PHP_URL_HOST);?><?php if($urlPath != '/'):?><?php echo $urlPath;?><?php endif;?></a>&nbsp;<a href="<?php echo $urlDisplay;?>" onclick="window.open('<?php echo $countClickUrl;?>');return false;" onmouseover="window.status='<?php echo $urlDisplay;?>';return true;" onmouseout="self.status='';return true;" title="<?php echo __('Ouvrir dans une nouvelle fenêtre');?>"><?php echo $this->Html->image('new-window.gif', array('alt' => __('Ouvrir dans une nouvelle fenêtre')));?></a>
<br />
<strong><?php echo $item[$modelClass]['count_clicks'];?></strong> <?php if($item[$modelClass]['count_clicks'] > 1):?><?php echo __('visites');?><?php else:?><?php echo __('visite');?><?php endif;?>
<?php endif;?>