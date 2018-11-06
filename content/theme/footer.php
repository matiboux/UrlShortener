<i class="fa fa-copyright fa-fw"></i> <?=$_Oli->getSetting('owner')?> – <?=(!empty($_Oli->getSetting('creation_date')) AND !empty($creationYear = date('Y', strtotime($_Oli->getSetting('creation_date'))))) ? ($creationYear < date('Y') ? $creationYear . '-' . date('Y') : ($creationYear > date('Y') ? date('Y') . '-' . $creationYear : $creationYear)) : date('Y')?> <br />

<?php $isCreationDate = !empty($_Oli->getSetting('creation_date')); ?>
<?php $isVersion = !empty($_Oli->getSetting('version')); ?>
<?php if($isCreationDate OR $isVersion) { ?>
	<?php if($isCreationDate) { ?>Created on <?=date('F j, Y', strtotime($_Oli->getSetting('creation_date')))?><?php } ?>
	<?php if($isCreationDate AND $isVersion) { ?>–<?php } ?>
	<?php if($isVersion) { ?>Version <?=$_Oli->getSetting('version')?><?php } ?>
	<br />
<?php } ?>

<span class="text text-danger"><i class="fas fa-heart fa-fw"></i></span> Powered by <b>Url Shortener</b>, an <a href="https://github.com/matiboux/UrlShortener">open-source project</a> created by Matiboux.