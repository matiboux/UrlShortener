<?php
if(!$_Oli->isEmptyPostVars()) {
	if($_Oli->isEmptyPostVars('link')) $resultCode = 'D:You did not provide any link';
	else if(!preg_match('/(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $_Oli->getPostVars('link'))) $resultCode = 'D:Your link is invalid';
	else if(($linkOwner = $_Oli->getInfosMySQL('url_shortener_list', 'owner', array('link' => $_Oli->getPostVars('link')))) !== false) {
		if($_Oli->getAuthKeyOwner() == $linkOwner) {
			$resultCode = 'I:You have already shortened this link';
			$shortenedLink = $_Oli->getUrlParam(0) . $_Oli->getInfosMySQL('url_shortener_list', 'link_key', array('link' => $_Oli->getPostVars('link')));
		}
		else {
			$resultCode = 'I:This link has been already shortened';
			$shortenedLink = $_Oli->getUrlParam(0) . $_Oli->getInfosMySQL('url_shortener_list', 'link_key', array('link' => $_Oli->getPostVars('link')));
		}
	}
	else {
		$id = $_Oli->getLastInfoMySQL('url_shortener_list', 'id') + 1;
		$link = $_Oli->getPostVars('link');
		$rating = $_Oli->getPostVars('rating') ?: 'general';
		$owner = $_Oli->getAuthKeyOwner() ?: '';
		$date = date('Y-m-d H:i:s');
		
		do {
			$linkKey = $_Oli->keygen(5, true, false, true, false, true);
			$i++;
		} while($isExist = $_Oli->isExistInfosMySQL('url_shortener_list', array('link_key' => $linkKey)) AND $i < 5);
		
		if(!empty($linkKey) AND !$isExist) {
			if($_Oli->insertLineMySQL('url_shortener_list', array('id' => $id, 'link' => $link, 'rating' => $rating, 'owner' => $owner, 'date' => $date, 'link_key' => $linkKey))) {
				$resultCode = 'S:Your link has been successfully shortened!';
				$shortenedLink = $_Oli->getUrlParam(0) . $linkKey;
			}
			else $resultCode = 'D:An error occured while saving your shortened link';
		}
		else $resultCode = 'D:An error occured while generating the shortened link keygen';
	}
}
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
	<?php echo $_Oli->getSetting('description'); ?>
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
		<?php if(!empty($shortenedLink)) { ?>
			<div class="message message-success remain">
				Here's your shortened link:
				<b class="copyLink"><?php echo $shortenedLink; ?></b> <br />
				Just click on it to copy it!
			</div>
		<?php } ?>
		<div id="message" style="display: none;"></div>
		
		<div class="content-box transparent text-center">
			<h3>Create your own shortened link:</h3>
		</div>

		<div class="content-box">
			<form action="<?php echo $_Oli->getUrlParam(0); ?>form.php" class="form form-horizontal" method="post">
				<div class="form-group">
					<label class="col-md-2 control-label">Your link</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="link" placeholder="http://" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Content rating</label>
					<div class="col-md-10">
						<div class="radio">
							<label><input type="radio" name="rating" value="general" checked /> <span class="text-primary">General rated content</span></label> <br />
							<label><input type="radio" name="rating" value="mature" /> <span class="text-danger">Mature rated content</span></label> <br />
							<label><input type="radio" name="rating" value="adult" /> <span class="text-danger">Adult rated content</span></label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">ShortIt!</button>
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