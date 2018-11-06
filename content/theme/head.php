<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="<?php echo $_Oli->getSetting('owner'); ?>" />
<meta name="description" content="<?php echo $_Oli->getSetting('description'); ?>" />
<meta name="keywords" content="<?php echo implode(',', explode(' ', $_Oli->getSetting('name'))); ?>,<?php echo implode(',', explode(' ', $_Oli->getSetting('description'))); ?>",<?php echo $_Oli->getSetting('owner'); ?>" />

<?php
$_Oli->loadCdnStyle('css/bootstrap.min.css', true);
$_Oli->loadCdnStyle('css/font-awesome.min.css', true);
$_Oli->loadLocalStyle('style.css', true);

$_Oli->loadCdnScript('js/jquery-2.1.4.min.js', false);
$_Oli->loadCdnScript('js/bootstrap.min.js', false);
?>