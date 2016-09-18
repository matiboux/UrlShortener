<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="<?php echo $_Oli->getSetting('owner'); ?>" />
<meta name="description" content="<?php echo $_Oli->getSetting('description'); ?>" />
<meta name="keywords" content="<?php echo implode(',', explode(' ', $_Oli->getSetting('name'))); ?>,<?php echo implode(',', explode(' ', $_Oli->getSetting('description'))); ?>,<?php echo $_Oli->getSetting('owner'); ?>" />

<?php $_Oli->loadCdnStyle('css/bootstrap.min.css', true); ?>
<?php $_Oli->loadCommonStyle('css/matioz.css', true); ?>

<?php $_Oli->loadScript('https://use.fontawesome.com/8ab94ac7f0.js', false); // Maybe you should use your own link here ?>
<?php $_Oli->loadCdnScript('js/jquery-3.1.0.min.js', false); ?>
<?php $_Oli->loadCdnScript('js/bootstrap.min.js', false); ?>
<?php $_Oli->loadCommonScript('js/message.js', false); ?>