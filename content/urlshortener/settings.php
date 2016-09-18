<?php
if($_Oli->getUserRightLevel() < $_Oli->translateUserRight('USER')) header('Location: ' . $_Oli->getShortcutLink('login'));

if(!$_Oli->isEmptyPostVars()) {
	$delay = $_Oli->getPostVars('delay') ? true : false;
	$rating = $_Oli->getPostVars('rating') ?: 'general';
	
	if(!$_Oli->isExistInfosMySQL('url_shortener_settings', array('username' => $_Oli->getAuthKeyOwner()))
	AND $_Oli->insertLineMySQL('url_shortener_settings', array('id' => $_Oli->getLastInfoMySQL('url_shortener_settings', 'id') + 1, 'username' => $_Oli->getAuthKeyOwner(), 'delay' => $delay, 'rating' => $rating)))
		$resultCode = 'S:Your settings have been successfully saved!';
	else if($_Oli->updateInfosMySQL('url_shortener_settings', array('delay' => $delay, 'rating' => $rating), array('username' => $_Oli->getAuthKeyOwner())))
		$resultCode = 'S:Your settings have been successfully updated!';
	else $resultCode = 'D:An error occured while updating your settings'; 
}
?>

<!DOCTYPE html>
<html>
<head>

<?php include COMMONPATH . 'head.php'; ?>
<title>Settings - <?php echo $_Oli->getOption('name'); ?></title>

</head>
<body>

<?php include THEMEPATH . 'header.php'; ?>

<div class="title-banner">
	Preferences and content settings
</div>

<div class="page-content">
	<div class="container">
		<?php if(isset($resultCode)) { ?>
			<?php
			list($prefix, $message) = explode(':', $resultCode, 2);
			if($prefix == 'P') $type = 'message-primary';
			else if($prefix == 'S') $type = 'message-success';
			else if($prefix == 'I') $type = 'message-info';
			else if($prefix == 'W') $type = 'message-warning';
			else if($prefix == 'D') $type = 'message-danger';
			?>
			
			<div class="message <?php echo $type; ?>">
				<?php echo $message; ?>
			</div>
		<?php } ?>
		<div id="message" style="display: none;"></div>
		
		<div class="content-box transparent text-center">
			<h3>Here are all your links:</h3>
		</div>
		
		<div class="content-box">
			<form action="<?php echo $_Oli->getUrlParam(0); ?>form.php" class="form form-horizontal" method="post">
				<?php $urlshortnerSettings = $_Oli->getLinesMySQL('url_shortener_settings', array('username' => $_Oli->getAuthKeyOwner())); ?>
				
				<h2><i class="fa fa-gear fa-fw"></i> Preferences</h2>
				<div class="form-group">
					<label class="col-sm-2 control-label">Delay</label>
					<div class="col-sm-10">
						<div class="checkbox">
							<label><input type="checkbox" name="delay" <?php if($urlshortnerSettings['delay'] OR !$urlshortnerSettings) { ?>checked<?php } ?> /> Wait for the 5 seconds delay before redirecting me</label>
							<p class="help-block">
								<i class="fa fa-eye fa-fw"></i> Helps protect you from visit malicious links by showing you the link for 5 seconds before redirecting you.
							</p>
						</div>
					</div>
				</div> <hr />
				
				<h2><i class="fa fa-lock fa-fw"></i> Content ratings</h2>
				<p>
					Choose the maximum content rating that you want to visit instantly, without any confirmation.
				</p>
				<div class="form-group">
					<label class="col-md-2 control-label hidden-xs hidden-sm">General</label>
					<div class="col-md-10">
						<div class="radio">
							<label><input type="radio" name="rating" value="general" <?php if($urlshortnerSettings['rating'] == 'general' OR !$urlshortnerSettings) { ?>checked<?php } ?> /> General rated content</label> <br />
						</div>
						<p class="help-block">
							<span class="text-success">Contains no violence and no nudity #SFW</span>
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label hidden-xs hidden-sm">Mature</label>
					<div class="col-md-10">
						<div class="radio">
							<label><input type="radio" name="rating" value="mature" <?php if($urlshortnerSettings['rating'] == 'mature') { ?>checked<?php } ?> /> Mature rated content</label> <br />
						</div>
						<p class="help-block">
							<span class="text-danger">Contains mild violence or nudity</span> <br />
							Nonsexual nudity exposing breasts or genitals (should not show arousal) <br />
							Mild violence
						</p>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label hidden-xs hidden-sm">Adult</label>
					<div class="col-md-10">
						<div class="radio">
							<label><input type="radio" name="rating" value="adult" <?php if($urlshortnerSettings['rating'] == 'adult') { ?>checked<?php } ?> /> Adult rated content</label> <br />
						</div>
						<p class="help-block">
							<span class="text-danger">Contains sex or strong violence</span> <br />
							Erotic imagery, sexual activity or arousal <br />
							Strong violence, blood, serious injury or death
						</p>
					</div>
				</div> <hr />
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Update</button>
						<button type="reset" class="btn btn-default">Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include COMMONPATH . 'footer.php'; ?>

</body>
</html>