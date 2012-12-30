<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
	<loc><?php echo Router::url('/', true); ?></loc>
	<changefreq>daily</changefreq>
	<priority>1.0</priority>
</url>
<?php if(isset($items) && !empty($items)):?>
<?php foreach($items as $model => $modelItems):?>
<?php foreach($modelItems as $i):?>
<url>
	<loc><?php echo $this->Html->url(array('controller' => Inflector::tableize($model), 'action' => 'view', 'id' => $i['id'], 'slug' => slug(getPreferedLang($i, 'title'))));?></loc>
	<lastmod><?php echo $this->Time->toAtom($i['modified']);?></lastmod>
</url>
<?php endforeach;?>
<?php endforeach;?>
<?php endif;?>
<?php if(isset($categories) && !empty($categories)):?>
<?php foreach($categories as $model => $modelItems):?>
<?php foreach($modelItems as $i):?>
<url>
	<loc><?php echo $this->Html->url(array('controller' => Inflector::tableize($model), 'action' => 'index', 'cat_slug' => $i['slug_'.TXT_LANG]));?></loc>
</url>
<?php endforeach;?>
<?php endforeach;?>
<?php endif;?>
</urlset>