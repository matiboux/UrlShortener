<?php
if($linkInfos = $_Oli->getLinesMySQL('urlshortener', array('link_key' => $_Oli->getUrlParam(1)))) {
	if(!$linkInfos['disabled']) header('Refresh: 3; Url=' . $linkInfos['link']);
?>

<!DOCTYPE html>
<html>
<head>

<?php include THEMEPATH . 'head.php'; ?>
<title><?=$_Oli->getSetting('name')?></title>

</head>
<body>

<div id="main" class="container h-100 d-flex justify-content-center align-items-center">
	<div class="card d-block m-auto">
		<?php /*<img class="card-img-top" src="" alt="Preview" />*/ ?>
		<div class="card-header">
			Redirecting to <span class="text-primary"><?=$linkInfos['link']?></span> ...
		</div>
		<div class="card-body">
			<?php if(!$linkInfos['disabled']) { ?>
				<h5 class="card-title">You will be redirected in a few seconds.</h5>
				<p class="card-text">
					This helps <span class="text-info">protect you</span> from visiting malicious websites. <br />
					<b>If you do not trust the following link, please <span class="text-danger">quit this page</span></b>. <br />
					You can also contact administrators to report suspicious links.
				</p>
			<?php } else { ?>
				<h5 class="card-title">Sorry, redirection have been disabled for this link.</h5>
				<p class="card-text">
					You can still access it by clicking the button below. <br />
					<b>Be sure you know what you are doing</b>.
				</p>
			<?php } ?>
			
			<?php if($linkInfos['rating'] == 'mature') { ?>
				<p class="text-warning">This link has been tagged as <b>mature</b> content.</p>
			<?php } else if($linkInfos['rating'] == 'adult') { ?>
				<p class="text-warning">This link has been tagged as <b>adult</b> content.</p>
			<?php } ?>
			
			<a href="<?=$linkInfos['link']?>" class="btn btn-primary"><i class="fas fa-globe fa-fw"></i> Redirect now!</a>
			<a href="<?=$_Oli->getUrlParam(0) . 'report/' . $_Oli->getUrlParam(1) . '/'?>" class="btn btn-warning"><i class="fas fa-exclamation-triangle fa-fw"></i> Report</a>
			<a href="<?=$_Oli->getUrlParam(0) . 'abort/' . $_Oli->getUrlParam(1) . '/'?>" class="btn btn-danger"><i class="fas fa-times fa-fw"></i> Abort</a>
		</div>
		<div class="card-footer text-muted">
			<?php include THEMEPATH . 'footer.php'; ?>
		</div>
	</div>
</div>

<?php $_Oli->loadEndHtmlFiles(); ?>

</body>
</html>

<?php } else header('Location: ' . $_Oli->getUrlParam(0)); ?>