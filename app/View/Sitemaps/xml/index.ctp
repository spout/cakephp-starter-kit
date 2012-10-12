<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/', true); ?></loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>
	<?php foreach($games as $game):?>
		<?php
		$title = getPreferedLang($game['Game'], 'title', array_keys(Configure::read('Config.languages')), TXT_LANG);
		?>
		<url>
			<loc><?php echo $this->Html->url(array('controller' => 'games', 'action' => 'view', 'id' => $game['Game']['id'], 'slug' => $game['Game']['slug']));?></loc>
			<lastmod><?php echo $this->Time->toAtom($game['Game']['modified']);?></lastmod>
			<priority>0.8</priority>
		</url>
	<?php endforeach;?>
	
	<?php foreach($gameCategories as $gameCategory):?>
		<url>
			<loc><?php echo $this->Html->url(array('controller' => 'games', 'action' => 'index', $gameCategory['Category']['slug_'.TXT_LANG]));?></loc>
			<changefreq>daily</changefreq>
			<priority>1</priority>
		</url>
	<?php endforeach;?>
</urlset>