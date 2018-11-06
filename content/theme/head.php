<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="<?php echo $_Oli->getSetting('owner'); ?>" />
<meta name="description" content="<?php echo $_Oli->getSetting('description'); ?>" />

<?php
$_Oli->loadStyle('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', 'integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"', true);
$_Oli->loadStyle('https://use.fontawesome.com/releases/v5.5.0/css/all.css', 'integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"', true);
$_Oli->loadLocalStyle('style.css', true);

// $_Oli->loadCdnScript('js/jquery-2.1.4.min.js', false);
// $_Oli->loadCdnScript('js/bootstrap.min.js', false);
?>