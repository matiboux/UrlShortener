<?php
if(!empty($_)) {
	if(empty($_['link'])) $resultCode = 'D:You need to enter a link';
	else if(!preg_match('/(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $_['link'])) $resultCode = 'D:Your link is invalid';
	else if($linkInfos = $_Oli->getInfosMySQL('urlshortener', ['link_key', 'banned'], array('link' => $_['link']))) {
		if($linkInfos['banned']) $resultCode = 'D:This link has been reported and banned. Rip.';
		else {
			$resultCode = 'I:This link has been already shortened';
			$shortenedLink = $_Oli->getUrlParam(0) . $linkInfos['link_key'];
		}
	} else {
		do {
			$linkKey = $_Oli->keygen(6, true, false, true, false, true);
			$i++;
		} while($isExist = $_Oli->isExistInfosMySQL('urlshortener', array('link_key' => $linkKey)) AND $i < 5);
		
		if(!empty($linkKey) AND !$isExist) {
			if($_Oli->insertLineMySQL('urlshortener', array('link_key' => $linkKey, 'link' => $_['link'], 'rating' => $_Oli->getPostVars('rating') ?: 'general', 'author' => $_Oli->getLoggedUser() ?: null, 'date' => date('Y-m-d H:i:s')))) {
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

<?php include THEMEPATH . 'head.php'; ?>
<title><?=$_Oli->getSetting('name')?></title>

</head>
<body>

<div id="main" class="container d-flex flex-column justify-content-start align-items-center">
	<h1 class="text-uppercase"><b><?=$_Oli->getSetting('name')?></b></h1>
	<div class="card d-block m-auto">
		<?php /*<img class="card-img-top" src="" alt="Preview" />*/ ?>
		<div class="card-header">
			Create your own shortened link
		</div>
		<div class="card-body">
			<?php if(!empty($resultCode)) {
				list($prefix, $message) = explode(':', $resultCode, 2);
				if($prefix == 'P') $type = 'alert-primary';
				else if($prefix == 'S') $type = 'alert-success';
				else if($prefix == 'I') $type = 'alert-info';
				else if($prefix == 'W') $type = 'alert-warning';
				else if($prefix == 'D') $type = 'alert-danger'; ?>
				<div class="alert <?php echo $type; ?>"><?=$message?></div>
			<?php } ?>
			
			<?php if(!empty($shortenedLink)) { ?>
				<div class="alert alert-primary">
					Your link is <b class="text-primary"><?=$shortenedLink?></b> – <a href="<?=$shortenedLink?>" class="btn btn-success btn-xs">Try it!</a>
				</div>
			<?php } ?>
			
			<form action="" class="form form-horizontal" method="post">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Link</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="link" placeholder="https://" value="<?=$_['link']?>" />
						<small class="form-text text-muted">A valid URL starting with http://, https:// or ftp://.</small>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">Rating</label>
					<div class="col-sm-10">
						<div class="form-check">
							<input class="form-check-input" id="ratingGeneral" type="radio" name="rating" value="general" checked />
							<label class="form-check-label" for="ratingGeneral">
								<span class="text-primary">General rated content</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" id="ratingMature" type="radio" name="rating" value="mature" />
							<label class="form-check-label" for="ratingMature">
								<span class="text-warning">Mature rated content</span>
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" id="ratingAdult" type="radio" name="rating" value="adult" />
							<label class="form-check-label" for="ratingAdult">
								<span class="text-danger">Adult rated content</span>
							</label>
						</div>
					</div>
				</div>
				<?php if($name = $_Oli->getLoggedName()) { ?>
					<div class="form-group">
						<small class="form-text text-muted"><i class="fas fa-info fa-fw"></i> You are logged in as <b><?=$name?></b>.</small>
					</div>
				<?php } ?>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary"><i class="fa fa-link fa-fw"></i> Shorten it!</button>
						<button type="reset" class="btn btn-default"><i class="fa fa-undo fa-fw"></i> Reset</button>
					</div>
				</div>
			</form> <hr />
			
			<div class="btn-group d-flex">
				<?php if(!$_Oli->verifyAuthKey()) { ?>
					<a href="<?=$_Oli->getLoginUrl()?>" class="btn btn-primary w-100"><i class="fa fa-sign-in-alt fa-fw"></i> Sign in</a>
				<?php } else { ?>
					<a href="<?=$_Oli->getLoginUrl()?>logout" class="btn btn-danger w-100"><i class="fa fa-sign-out-alt fa-fw"></i> Sign out</a>
				<?php } ?>
				<a href="<?=$_Oli->getUrlParam(0)?>manager" class="btn btn-<?php if(!$_Oli->verifyAuthKey()) { ?>secondary disabled<?php } else {?>primary<?php } ?> w-100"><i class="fa fa-user fa-fw"></i> Manager</a>
				<a href="<?=$_Oli->getShortcutLink('legal')?>" class="btn btn-light w-100">Legal</a>
				<a href="<?=$_Oli->getUrlParam(0)?>about" class="btn btn-light w-100">About</a>
			</div>
		</div>
		<div class="card-footer text-muted">
			<?php include THEMEPATH . 'footer.php'; ?>
		</div>
	</div>
</div>

<?php $_Oli->loadEndHtmlFiles(); ?>

</body>
</html>