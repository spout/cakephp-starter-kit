<?php if(!empty($item[$modelClass]['skype'])):?>
<?php /*<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>*/?>
<a href="skype:<?php echo $item[$modelClass]['skype'];?>?call"><img src="http://download.skype.com/share/skypebuttons/buttons/call_green_transparent_70x23.png" alt="Skype Me!" /></a>
<?php endif;?>