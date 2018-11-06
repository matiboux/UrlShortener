<?php
if($_Oli->getUserRightLevel() < $_Oli->translateUserRight('USER')) header('Location: ' . $_Oli->getShortcutLink('login'));
else if($_Oli->getUrlParam(1) == 'manager' AND $_Oli->getUserRightLevel() < $_Oli->translateUserRight('ADMIN')) header('Location: ' . $_Oli->getUrlParam(0) . 'overview/');

if($_Oli->getUrlParam(2) == 'delete' AND !empty($_Oli->getUrlParam(3))) {
	$paramData = urldecode($_Oli->getUrlParam(3));
	$selectedFiles = is_array($decoded = json_decode($paramData, true)) ? $decoded : [$paramData];
		
	$errorStatus = '';
	foreach($selectedFiles as $eachKey) {
		if(!$mediaInfos = $_Oli->getLinesMySQL('urlshortener', array('link_key' => $eachKey))) {
			$errorStatus = 'D:You tried to delete something that does not exist.';
			break;
		}
		else if($mediaInfos['author'] != $_Oli->getLoggedUser() AND $_Oli->getUserRightLevel() < $_Oli->translateUserRight('ADMIN')) {
			$errorStatus = 'D:You cannot a shortened link that is not yours.';
			break;
		}
	}
	
	if(!empty($errorStatus)) $scriptResult = $errorStatus;
	// else if($_Oli->getUrlParam(4) != 'confirmed') $scriptResult = 'S:Please <a href=""></a>';
	else {
		$status = [];
		foreach($selectedFiles as $eachKey) {
			$status[] = $_Oli->deleteLinesMySQL('urlshortener', array('link_key' => $eachKey));
		}
		
		if(!in_array(false, $status, true)) {
			if(count($selectedFiles) > 1) $scriptResult = 'S:All selected links were successfully deleted.';
			else $scriptResult = 'S:The selected link was successfully deleted.';
		} else $scriptResult = 'S:An error occurred.';
	}
}
?>

<!DOCTYPE html>
<html>
<head>

<?php include THEMEPATH . 'head.php'; ?>
<?php $_Oli->loadLocalScript('selector.js', false); ?>
<title><?php echo $_Oli->getOption('name'); ?></title>

</head>
<body>

<div id="main" class="container h-100 d-flex flex-column justify-content-center align-items-center">
	<h1 class="text-uppercase mt-3 mb-0">
		<?php if($_Oli->getUrlParam(1) != 'manager') { ?>
			Overview
		<?php } else { ?>
			Admin Manager
		<?php } ?>
	</h1>
	<div class="card d-block mw-100 m-auto">
		<?php
		$allLinks = $_Oli->getLinesMySQL('urlshortener', $_Oli->getUrlParam(1) != 'manager' ? array('author' => $_Oli->getLoggedUser()) : null, false, true);
		$totalLinks = count($allLinks);
		?>
		
		<?php /*<img class="card-img-top" src="" alt="Preview" />*/ ?>
		<div class="card-header">
			<i class="fas fa-user fa-fw mr-2"></i>
			<?php if($_Oli->getUserRightLevel() >= $_Oli->translateUserRight('VIP')) { ?>
				<span class="badge badge-pill badge-primary"><i class="fas fa-star fa-fw"></i> Premium Membership</span>
			<?php } else { ?>
				<span class="badge badge-pill badge-secondary"><i class="fas fa-star fa-fw"></i> Standard Membership</span>
			<?php } ?>
			<span class="badge badge-pill badge-light"><?=$totalLinks?> link shortened</span>
		</div>
		<div class="card-body">
			<?php if(isset($scriptResult)) {
				list($prefix, $message) = explode(':', $scriptResult, 2);
				if($prefix == 'P') $type = 'alert-primary';
				else if($prefix == 'S') $type = 'alert-success';
				else if($prefix == 'I') $type = 'alert-info';
				else if($prefix == 'W') $type = 'alert-warning';
				else if($prefix == 'D') $type = 'alert-danger'; ?>
				<div class="alert <?php echo $type; ?>"><?=$message?></div>
			<?php } ?>
			
			<?php if(!empty($allLinks)) { ?>
				<h2>
					<?php if($_Oli->getUrlParam(1) != 'manager') { ?>
						Your shortened links
					<?php } else { ?>
						All shortened links
					<?php } ?>
				</h2>
				<p class="text-muted"><i class="fa fa-sort-alpha-up fa-fw"></i> Sorted from newest to oldest</p>
				<table class="table table-hover table-responsive">
					<thead>
						<tr>
							<th class="selector-menu"><i class="fas fa-check fa-fw"></i></th>
							<th>Key</th>
							<th>Link</th>
							<th><i class="fas fa-star-half-alt fa-fw" data-toggle="tooltip" data-placement="top" title="Rating"></i></th>
							<th><i class="fas fa-battery-three-quarters fa-fw" data-toggle="tooltip" data-placement="top" title="Status"></i></th>
							<th><i class="far fa-eye fa-fw" data-toggle="tooltip" data-placement="top" title="Views"></i></th>
							<th>Date</th>
							<?php if($_Oli->getUrlParam(1) == 'manager') { ?><th>Author</th><?php } ?>
							<th></th>
							<th><a href="<?=$_Oli->getUrlParam(0) . $_Oli->getUrlParam(1)?>/delete/" class="deleteSelected btn btn-danger btn-sm"><span>Selected</span> <i class="fas fa-trash-alt fa-fw"></i></a></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($allLinks as $eachLink) { ?>
							<tr id="<?php echo $eachLink['link_key']; ?>">
								<?php if(!empty($selectedFiles) AND in_array($eachLink['link_key'], $selectedFiles)) { ?>
									<td class="selector checked">
										<i class="fas fa-check-square fa-fw"></i>
									</td>
								<?php } else { ?>
									<td class="selector">
										<i class="far fa-square fa-fw"></i>
									</td>
								<?php } ?>
								
								<td><span class="badge badge-pill badge-light"><?php echo $eachLink['link_key']; ?></span></td>
								<td>
									<?php if(!empty($eachLink['link'])) { ?>
										<i class="fas fa-link fa-fw" data-toggle="tooltip" data-placement="bottom" title="<?php echo $eachLink['link']; ?>"></i>
									<?php } else { ?>
										<i class="fas fa-unlink fa-fw"></i>
									<?php } ?>
								</td>
								<td>
									<?php if($eachLink['rating'] == 'adult') { ?>
										<i class="fas fa-skull-crossbones fa-fw" data-toggle="tooltip" data-placement="bottom" title="Adult"></i>
									<?php } else if($eachLink['banned'] == 'mature') { ?>
										<i class="fas fa-exclamation-triangle fa-fw" data-toggle="tooltip" data-placement="bottom" title="Mature"></i>
									<?php } else { ?>
										<i class="far fa-thumbs-up fa-fw" data-toggle="tooltip" data-placement="bottom" title="General"></i>
									<?php } ?>
								</td>
								<td>
									<?php if($eachLink['disabled']) { ?>
										<i class="fas fa-times fa-fw" data-toggle="tooltip" data-placement="bottom" title="Disabled"></i>
									<?php } else { ?>
										<i class="fas fa-check fa-fw" data-toggle="tooltip" data-placement="bottom" title="Enabled"></i>
									<?php } ?>
								</td>
								<td><span class="badge badge-pill badge-light"><?=$eachLink['views'] ?: 0?></span></td>
								<td><span data-toggle="tooltip" data-placement="bottom" title="<?=date('F j, Y \a\t H:i:s', strtotime($eachLink['date']))?>"><?=date('M j, Y', strtotime($eachLink['date']))?></span></td>
								<?php if($_Oli->getUrlParam(1) == 'manager') { ?><td><?=$_Oli->getName($eachLink['author'])?></td><?php } ?>
								<td><a href="<?=$_Oli->getUrlParam(0) . $eachLink['link_key']?>"  class="btn btn-success btn-sm">Visit <i class="far fa-eye fa-fw"></i></a></td>
								<td><a href="<?=$_Oli->getUrlParam(0) . $_Oli->getUrlParam(1)?>/delete/<?=$eachLink['link_key']?>"  class="delete btn btn-danger btn-sm"><span>Delete</span> <i class="fas fa-trash-alt fa-fw"></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="<?=$_Oli->getUrlParam(1) == 'manager' ? '8' : '7'?>">
								<a href="#selectAll" class="selectAll btn btn-primary btn-sm">Select All <i class="fas fa-check-square fa-fw"></i></a>
								<a href="#unselectAll" class="unselectAll btn btn-danger btn-sm">Unselect All <i class="far fa-square fa-fw"></i></a>
							</td>
							<td><?php echo $totalLinks; ?> <small>/ <?=$totalLinks?> link<?php if($totalLinks > 1) { ?>s<?php } ?></small></td>
							<td><a href="<?=$_Oli->getUrlParam(0) . $_Oli->getUrlParam(1)?>/delete/" class="deleteSelected btn btn-danger btn-sm"><span>Selected</span> <i class="fa fa-trash-alt fa-fw"></i></a></td>
						</tr>
					</tfoot>
				</table>
			<?php } else { ?>
				<span class="badge badge-danger">
					<?php if($_Oli->getUrlParam(1) != 'manager') { ?>
						You have no shortened link yet.
					<?php } else { ?>
						There is no shortened link yet.
					<?php } ?>
				</span>
			<?php } ?> <hr />
			
			<div class="btn-group d-flex">
				<a href="<?=$_Oli->getUrlParam(0)?>" class="btn btn-primary w-100"><i class="fas fa-home fa-fw"></i> Home</a>
				<?php if($_Oli->getUserRightLevel() >= $_Oli->translateUserRight('ADMIN')) { ?>
					<?php if($_Oli->getUrlParam(1) != 'manager') { ?>
						<a href="<?=$_Oli->getUrlParam(0)?>manager/" class="btn btn-info w-100">Access to the admin panel</a>
					<?php } else { ?>
						<a href="<?=$_Oli->getUrlParam(0)?>overview/" class="btn btn-info w-100">Manage your own shortened links</a>
					<?php } ?>
				<?php } ?>
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