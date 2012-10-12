<h3 id="comments"><?php echo __('Commentaires');?></h3>

<?php echo $this->element('disqus');?>

<?php /*
<?php if(!empty(${$singularVar}['Comment'])):?>
	<p><a href="#post-comment"><?php echo __('Poster un commentaire');?></a></p>
	<div class="comments-list">
		<?php foreach(${$singularVar}['Comment'] as $comment):?>
			<div id="comment-<?php echo $comment['id'];?>" class="comments-list-item">
				<div class="comments-list-meta">
					<div class="comments-list-avatar">
						<?php echo $this->Gravatar->image($comment['email'], array('default' => 'wavatar', 'size' => 32));?>
					</div>
					<div class="comments-list-name">
					<?php echo h($comment['name']);?>
					</div>
					<div class="comments-list-date">
						<a href="#comment-<?php echo $comment['id'];?>"><?php echo $this->MyHtml->niceDate($comment['created']);?></a>
					</div>
					<div class="clear"></div>
				</div>
				<div class="comments-list-comment">
					<?php echo nl2br(h($comment['comment']));?>
				</div>
			</div>
		<?php endforeach;?>
	</div>
<?php else:?>
	<p><?php echo __('Aucun commentaire. Soyez le premier à donner votre avis.');?></p>
<?php endif;?>

<?php echo $this->element('generic/comments-form');?>
*/?>