<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="<?php echo $_Oli->getSetting('owner'); ?>" />
<meta name="description" content="<?php echo $_Oli->getSetting('description'); ?>" />

<?php
$_Oli->loadStyle('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', 'integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"', true);
$_Oli->loadStyle('https://use.fontawesome.com/releases/v5.5.0/css/all.css', 'integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"', true);
$_Oli->loadLocalStyle('style.css', true);

$_Oli->loadScript('https://code.jquery.com/jquery-3.3.1.slim.min.js', 'integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"', false);
$_Oli->loadScript('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', 'integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"', false);
$_Oli->loadScript('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', 'integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"', false);
$_Oli->loadLocalScript('script.js', false);
?>