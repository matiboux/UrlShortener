<?php
if($linkInfos = $_Oli->getLinesMySQL('url_shortener_list', array('link_key' => $_Oli->getUrlParam(1)))) {
	$urlshortnerSettings = $_Oli->verifyAuthKey() ? $_Oli->getLinesMySQL('url_shortener_settings', array('username' => $_Oli->getAuthKeyOwner())) : false;
	
	if($urlshortnerSettings['rating'] == 'adult') $ratingSetting = 3;
	else if($urlshortnerSettings['rating'] == 'mature') $ratingSetting = 2;
	else $ratingSetting = 1;
	
	if($linkInfos['rating'] == 'adult') $linkRating = 3;
	else if($linkInfos['rating'] == 'mature') $linkRating = 2;
	else $linkRating = 1;
	
	if($linkRating <= $ratingSetting) {
		if($urlshortnerSettings['delay'] OR !$urlshortnerSettings) {
			header('Refresh: 5; Url=' . $linkInfos['link']);
			$redirectDelay = true;
		}
		else header('Location: ' . $linkInfos['link']);
	}
	else $confirmationNeeded = true;
}
else include COMMONPATH . '404.php';

if($redirectDelay OR $confirmationNeeded) {
?>

<!DOCTYPE html>
<html>
<head>

<?php include COMMONPATH . 'head.php'; ?>
<?php $_Oli->loadLocalScript('js/copyLink.js', false); ?>
<title><?php echo $_Oli->getSetting('name'); ?></title>

</head>
<body>

<?php include THEMEPATH . 'header.php'; ?>

<div class="title-banner">
	<?php
	if($redirectDelay) echo 'Waiting for the redirection...';
	else echo 'Redirection confirmation';
	?>
</div>

<div class="page-content">
	<div class="container">
		<div id="message" style="display: none;"></div>
		
		<div class="content-box transparent text-center">
			<?php if($redirectDelay) { ?>
				<h2>Please wait, you will be redirected in 5 seconds...</h2>
				<p>
					This helps protect you from visit malicious links by showing you the link before redirecting you. <br />
					<b>If you do not trust the folowing link, please <span class="text-danger">quit this page</span></b>.
				</p>
				<h3>
					You'll be redirected to <span class="text-primary"><?php echo $linkInfos['link']; ?></span>
				</h3>
				<p>
					You can contact administrators to report suspisious links.
				</p>
			<?php } else { ?>
				<h2>Content rating warning! <span class="text-danger">#NSFW</span></h2>
				<p>
					<?php if($linkRating == 2) { ?>
						<b>This link has been flagged as <span class="text-danger">MATURE</span> rated content</b> <br />
						<span class="text-danger">It means it might contains mild violence or nudity</span>
					<?php } else if($linkRating == 3) { ?>
						<b>This link has been flagged as <span class="text-danger">ADULT</span> rated content</b> <br />
						<span class="text-danger">It means it might contains sex or strong violence</span>
					<?php } ?> <br /> <br />
					<b>If you don't want to visit the link, please <span class="text-danger">quit this page</span></b>.
				</p>
				<h3>
					The link is <span class="text-primary"><?php echo $linkInfos['link']; ?></span>
				</h3>
				<p>
					You can contact administrators to report suspisious links.
				</p>
				<p>
					<a href="<?php echo $linkInfos['link']; ?>" class="btn btn-primary">I want to visit this link</a>
					<?php if($_SERVER['HTTP_REFERER']) { ?>
						<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default">Go back to previous page</a>
					<?php } ?>
				</p>
			<?php } ?>
		</div>
	</div>
</div>

<?php include COMMONPATH . 'footer.php'; ?>

</body>
</html>

<?php } ?>