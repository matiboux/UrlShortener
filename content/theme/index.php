<?php
if($_Oli->issetPostVars()) {
	if($_Oli->isEmptyPostVars('link')) $resultCode = 'D:You need to enter a link';
	else if(!preg_match('/(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $_Oli->getPostVars('link'))) $resultCode = 'D:Your link is invalid';
	else if($linkInfos = $_Oli->getInfosMySQL('urwebsit', ['link_key', 'banned'], array('link' => $_Oli->getPostVars('link')))) {
		if($linkInfos['banned']) $resultCode = 'D:This link has been reported and banned. Rip.';
		else {
			$resultCode = 'I:This link has been already shortened';
			$shortenedLink = $_Oli->getUrlParam(0) . $linkInfos['link_key'];
		}
	} else {
		do {
			$linkKey = $_Oli->keygen(6, true, false, true, false, true);
			$i++;
		} while($isExist = $_Oli->isExistInfosMySQL('urwebsit', array('link_key' => $linkKey)) AND $i < 5);
		
		if(!empty($linkKey) AND !$isExist) {
			if($_Oli->insertLineMySQL('urwebsit', array('id' => $_Oli->getLastInfoMySQL('urwebsit', 'id') + 1, 'link' => $_Oli->getPostVars('link'), 'link_key' => $linkKey, 'rating' => $_Oli->getPostVars('rating') ?: 'general', 'date' => date('Y-m-d H:i:s')))) {
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

<div id="main">
	<div class="container-fluid" style="max-width: 530px;">
		<h1 class="text-center text-uppercase"><b><?=$_Oli->getSetting('name')?></b></h1> <hr />
		
		<?php if(!empty($resultCode)) {
			list($prefix, $message) = explode(':', $resultCode, 2);
			if($prefix == 'P') $type = 'text-primary';
			else if($prefix == 'S') $type = 'text-success';
			else if($prefix == 'I') $type = 'text-info';
			else if($prefix == 'W') $type = 'text-warning';
			else if($prefix == 'D') $type = 'text-danger'; ?>
			<h4 class="<?php echo $type; ?>"><i class="fa fa-exclamation fa-fw"></i> <?=$message?></h4>
			<hr />
		<?php } ?>
		<?php if(!empty($shortenedLink)) { ?>
			<p>Your link is <b class="text-primary"><?=$shortenedLink?></b> – <a href="<?=$shortenedLink?>" class="btn btn-success btn-xs">Try it!</a></p>
			<hr />
		<?php } ?>
		
		<form action="<?=$_Oli->getUrlParam(0)?>form.php" class="form form-horizontal" method="post">
			<div class="form-group">
				<label class="col-sm-2 control-label">Link</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="link" placeholder="http://" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Infos</label>
				<div class="col-sm-10">
					<div class="radio">
						<label><input type="radio" name="rating" value="general" checked /> <span class="text-primary">General rated content</span></label> <br />
						<label><input type="radio" name="rating" value="mature" /> <span class="text-warning">Mature rated content</span></label> <br />
						<label><input type="radio" name="rating" value="adult" /> <span class="text-danger">Adult rated content</span></label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary"><i class="fa fa-link fa-fw"></i> Shorten it!</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</div>
		</form> <hr />
		
		<div class="btn-group btn-group-justified">
			<?php if(!$_Oli->verifyAuthKey()) { ?>
				<a href="<?=$_Oli->getShortcutLink('login')?>" class="btn btn-primary"><i class="fa fa-sign-in fa-fw"></i> Sign in</a>
			<?php } else { ?>
				<a href="<?=$_Oli->getShortcutLink('login')?>logout" class="btn btn-danger"><i class="fa fa-sign-out fa-fw"></i> Sign out</a>
			<?php } ?>
			<a href="<?=$_Oli->getUrlParam(0)?>manager" class="btn btn-<?php if(!$_Oli->verifyAuthKey()) { ?>default disabled<?php } else {?>primary<?php } ?>"><i class="fa fa-user fa-fw"></i> Manager</a>
			<a href="<?=$_Oli->getShortcutLink('legal')?>" class="btn btn-default">Legal</a>
			<a href="<?=$_Oli->getUrlParam(0)?>about" class="btn btn-default">About</a>
		</div> <hr />
		
		<p>
			<i class="fa fa-copyright fa-fw"></i> <?=$_Oli->getSetting('owner')?> – <?=(!empty($_Oli->getSetting('creation_date')) AND !empty($creationYear = date('Y', strtotime($_Oli->getSetting('creation_date'))))) ? ($creationYear < date('Y') ? $creationYear . '-' . date('Y') : ($creationYear > date('Y') ? date('Y') . '-' . $creationYear : $creationYear)) : date('Y')?>
		<?php if(!empty($_Oli->getSetting('version'))) { ?><br /> Version <?=$_Oli->getSetting('version')?><?php } ?>
		<?php if(!empty($_Oli->getSetting('creation_date'))) { ?><br /> Created on <?=date('F j, Y', strtotime($_Oli->getSetting('creation_date')))?><?php } ?>
		</p>
	</div>
</div>

<?php $_Oli->loadEndHtmlFiles(); ?>

</body>
</html>