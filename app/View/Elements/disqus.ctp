<?php 
$disqus_shortname = 'gamesdir';
$disqus_identifier = md5($this->request->params['controller'].$this->request->params['action'].$item[$modelClass]['id']);
?>

<div id="disqus_thread"></div>
<script type="text/javascript">
    var disqus_shortname = '<?php echo $disqus_shortname;?>';
	var disqus_identifier = '<?php echo $disqus_identifier;?>';

    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<?php /*
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
*/?>