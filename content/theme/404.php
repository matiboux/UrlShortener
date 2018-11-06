<?php
if($linkInfos = $_Oli->getLinesMySQL('urwebsit', array('link_key' => $_Oli->getUrlParam(1)))) {
	if(!$linkInfos['banned']) header('Refresh: 2; Url=' . $linkInfos['link']);
?>

<!DOCTYPE html>
<html>
<head>

<?php include THEMEPATH . 'head.php'; ?>
<title><?=$_Oli->getSetting('name')?></title>

</head>
<body>

<?php include THEMEPATH . 'header.php'; ?>

<div id="main">
	<div class="container" style="max-width: 750px">
		
		<?php if($linkInfos['banned']) { ?>
			<h2>(Not) redirecting..</h2>
			<h4 class="text-danger">The link <b class="text-danger"><?=$linkInfos['link']?></b> has been banned. Rip.</h4>
		<?php } else { ?>
			<h2>Redirecting...</h2>
			<h4>You'll be redirected to <b class="text-primary"><?=$linkInfos['link']?></b> in a few seconds.</h4>
		<?php } ?>
		
		<?php if($linkInfos['rating'] == 'mature') { ?>
			<p class="text-warning">This shortened link have been tagged as redirecting to <b>mature</b> content.</p>
		<?php } else if($linkInfos['rating'] == 'adult') { ?>
			<p class="text-danger">This shortened link have been tagged as redirecting to <b>adult</b> content.</p>
		<?php } ?>
		
	</div>
</div>

<?php $_Oli->loadEndHtmlFiles(); ?>

</body>
</html>

<?php } else header('Location: ' . $_Oli->getUrlParam(0)); ?>