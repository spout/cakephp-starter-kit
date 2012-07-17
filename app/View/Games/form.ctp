<?php $this->set('title_for_layout', (!empty($id)) ? __('Modifier un jeu') : __('Ajouter un jeu'));?>

<?php echo $this->Form->create();?>
<?php if(!empty($id)):?>
	<?php echo $this->Form->hidden('id', array('value' => $id));?>
<?php endif;?>

<fieldset>
	<legend><?php echo __('Description');?></legend>
	<?php echo $this->Form->input('title', array('label' => __('Nom du jeu')));?>
	<?php echo $this->Form->input('slug', array('label' => __('Permalien')));?>
	<?php 
	// Update belongsTo Category => HABTM Category
	$defaultCategory = isset($this->request->data[$modelClass]['category_id']) ? $this->request->data[$modelClass]['category_id'] : '';
	?>
	<?php echo $this->Form->input('Category', array('label' => __('Catégories'), 'default' => $defaultCategory));?>
	<?php //echo $this->Form->input('category_id', array('label' => __('Catégorie')));?>
	<?php echo $this->Form->input('description_fr', array('label' => __('Description')));?>
	<?php echo $this->Form->input('release_date', array('label' => __('Date de sortie')));?>
	<?php echo $this->Form->input('langs', array('label' => __('Langues'), 'options' => $gamesLanguages, 'multiple' => true));?>
	<?php echo $this->Form->input('platforms', array('label' => __('Plateformes'), 'options' => $platforms, 'multiple' => true));?>
	<?php echo $this->Form->input('multiplayer', array('label' => __('Multijoueurs'), 'options' => $yesNo, 'empty' => '-'));?>
	<?php echo $this->Form->input('online_play', array('label' => __('Jouable en ligne'), 'options' => $yesNo, 'empty' => '-'));?>
</fieldset>

<fieldset>
	<legend><?php echo __('Classification');?></legend>
	<?php echo $this->Form->input('esrb', array('label' => __('ESRB'), 'options' => $esrbRatings, 'empty' => '-'));?>
	<?php echo $this->Form->input('pegi', array('label' => __('PEGI'), 'options' => $pegiRatings, 'empty' => '-'));?>
</fieldset>

<fieldset>
	<legend><?php echo __('Liens');?></legend>
	<?php echo $this->Form->input('website', array('label' => __('Site Web')));?>
	<?php echo $this->Form->input('download_url', array('label' => __('Page de téléchargement')));?>
	<?php echo $this->Form->input('feed_url', array('label' => __('Flux RSS')));?>
	
	<?php 
	if (isset($this->request->data[$modelClass]['youtube_video_ids']) && !empty($this->request->data[$modelClass]['youtube_video_ids'])) {
		$videos = explode("\n", $this->request->data[$modelClass]['youtube_video_ids']);
		$videosDefault = array();
		foreach ($videos as $v) {
			$videosDefault[] = 'http://www.youtube.com/watch?v='.$v;
		}
		$this->request->data[$modelClass]['videos'] = implode("\n", $videosDefault);
	}
	?>
	<?php echo $this->Form->input('videos', array('label' => __('Vidéos')));?>
</fieldset>

<fieldset>
	<legend><?php echo __('Développeurs');?></legend>
	<?php echo $this->Form->input('developers', array('label' => __('Développeurs')));?>
	<?php echo $this->Form->input('developers_url', array('label' => __('Site Web des développeurs')));?>
</fieldset>

<fieldset>
	<legend><?php echo __('Informations complémentaires');?></legend>
	<?php echo $this->Form->input('license', array('label' => __('Licence')));?>
	<?php echo $this->Form->input('system_requirements', array('label' => __('Configuration requise')));?>
</fieldset>	

<?php echo $this->Form->end((!empty($id)) ? __('Modifier') : __('Ajouter'));?>