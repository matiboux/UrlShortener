<?php
if($_Oli->getUserRightLevel() < $_Oli->translateUserRight('USER')) header('Location: ' . $_Oli->getShortcutLink('login'));

if($_Oli->getUrlParam(2) == 'change-sensitive' AND !empty($_Oli->getUrlParam(3))) {
	if(!$_Oli->isExistInfosMySQL('url_shortener_list', array('id' => $_Oli->getUrlParam(3))))
		$resultCode = 'UNKNOWN_LINK';
	else if($_Oli->getInfosMySQL('url_shortener_list', 'owner', array('id' => $_Oli->getUrlParam(3))) == $_Oli->getAuthKeyOwner()) {
		$newSensitiveLink = ($_Oli->getInfosMySQL('url_shortener_list', 'sensitive_link', array('id' => $_Oli->getUrlParam(3)))) ? false : true;
		$updatedLinkKey = $_Oli->getUrlParam(3);
		
		$_Oli->updateInfosMySQL('url_shortener_list', array('sensitive_link' => $newSensitiveLink), array('id' => $_Oli->getUrlParam(3)));
		$resultCode = 'LINK_UPDATED';
	}
	else
		$resultCode = 'NOT_YOUR_LINK';
}
else if($_Oli->getUrlParam(2) == 'delete' AND !empty($_Oli->getUrlParam(3))) {
	$paramData = urldecode($_Oli->getUrlParam(3));
	$selectedLinks = !is_array($paramData) ? (is_array(json_decode($paramData, true)) ? json_decode($paramData, true) : [$paramData]) : $paramData;
	
	foreach($selectedLinks as $eachKey) {
		if(!$linkInfos = $_Oli->getLinesMySQL('url_shortener_list', array('id' => $eachKey))) $errorStatus = 'D:You tried to deleted a shortened link which not exists';
		else if($linkInfos['owner'] != $_Oli->getAuthKeyOwner()) $errorStatus = 'D:You tried to deleted a shortened link which not belongs to you';
		
		if(isset($errorStatus)) break;
	}
	
	if(!empty($errorStatus)) $resultCode = $errorStatus;
	else if($_Oli->getUrlParam(4) != 'confirmed') {
		$resultCode = 'P:Please confirm your action below (just click "Confirm all")';
		$confirmationNeeded = true;
	}
	else {
		foreach($selectedLinks as $eachKey) {
			if(!$_Oli->deleteLinesMySQL('url_shortener_list', array('id' => $eachKey))) {
				$deleteFailed = true;
				break;
			}
		}
		
		if(!$deleteFailed) $resultCode = 'S:The selected shortened links have been successfully deleted';
		else $resultCode = 'D:An error occured while deleting your shortened links'; 
	}
}
?>

<!DOCTYPE html>
<html>
<head>

<?php include COMMONPATH . 'head.php'; ?>
<?php $_Oli->loadCommonScript('js/selector.js', false); ?>
<?php $_Oli->loadLocalScript('copyLink.js', false); ?>
<title>Your links - <?php echo $_Oli->getSetting('name'); ?></title>

</head>
<body>

<?php include THEMEPATH . 'header.php'; ?>

<div class="title-banner">
	Your links management page
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
			<?php $yourLinks = $_Oli->getLinesMySQL('url_shortener_list', array('owner' => $_Oli->getAuthKeyOwner()), true, true); ?>
			<?php if(!empty($yourLinks)) { ?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="selector-menu"><i class="fa fa-check fa-fw"></i></th>
							<th>Link</th>
							<th>Key</th>
							<th>Rating</th>
							<th>Created</th>
							<?php if(isset($selectedLinks) AND $confirmationNeeded) { ?>
								<th colspan="2"></th>
								<th>
									<a href="<?php echo $_Oli->getUrlParam(0) . $_Oli->getUrlParam(1); ?>/delete/<?php echo urlencode($_Oli->getUrlParam(3)); ?>/confirmed" class="btn btn-warning btn-xs">
										Confirm all <i class="fa fa-trash fa-fw"></i>
									</a>
								</th>
							<?php } else { ?>
								<th colspan="3"></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php $countLinks = count($yourLinks); ?>
						<?php foreach($yourLinks as $eachLink) { ?>
							<tr id="<?php echo $eachLink['id']; ?>">
								<?php if(!empty($selectedLinks) AND in_array($eachLink['id'], $selectedLinks)) { ?>
									<td class="selector checked">
										<i class="fa fa-check-square fa-fw"></i>
									</td>
								<?php } else { ?>
									<td class="selector">
										<i class="fa fa-square-o fa-fw"></i>
									</td>
								<?php } ?>
								
								<td><?php echo $eachLink['link']; ?></td>
								<td><?php echo $eachLink['link_key']; ?></td>
								<td>
									<?php if($eachLink['rating'] == 'mature') { ?>
										<span class="text-danger">General</span>
									<?php } else if($eachLink['rating'] == 'adult') { ?>
										<span class="text-danger">Adult</span>
									<?php } else { ?>
										<span class="text-primary">General</span>
									<?php } ?>
								</td>
								<td>
									<?php $timeOutput = []; ?>
									<?php foreach($_Oli->dateDifference($eachLink['date'], time(), true) as $eachUnit => $eachTime) { ?>
										<?php if(count($timeOutput) < 2) { ?>
											<?php if($eachTime > 0) { ?>
												<?php if($eachUnit == 'years') { ?>
													<?php $timeOutput[] = $eachTime . ' year' . (($eachTime > 1) ? 's' : ''); ?>
												<?php } else if($eachUnit == 'days') { ?>
													<?php $timeOutput[] = $eachTime . ' day' . (($eachTime > 1) ? 's' : ''); ?>
												<?php } else if($eachUnit == 'hours') { ?>
													<?php $timeOutput[] = $eachTime . ' hour' . (($eachTime > 1) ? 's' : ''); ?>
												<?php } else if($eachUnit == 'minutes') { ?>
													<?php $timeOutput[] = $eachTime . ' minute' . (($eachTime > 1) ? 's' : ''); ?>
												<?php } else if($eachUnit == 'seconds') { ?>
													<?php $timeOutput[] = $eachTime . ' second' . (($eachTime > 1) ? 's' : ''); ?>
												<?php } ?>
											<?php } ?>
										<?php } else break; ?>
									<?php } ?>
									
									<?php $timeOutputCount = count($timeOutput); ?>
									<?php if(!empty($timeOutput)) { ?>
										<?php echo $timeOutput[0]; ?><?php if($timeOutputCount > 2) { ?>,<?php } ?>
										<?php if($timeOutputCount > 1) { ?>
											<small>
												<?php if($timeOutputCount > 2) { ?>
													<?php echo implode(', ', array_splice($timeOutput, 1, $timeOutputCount)); ?>
												<?php } ?>
												and <?php echo $timeOutput[$timeOutputCount - 1]; ?>
											</small>
										<?php } ?> ago
									<?php } else { ?>
										Now!
									<?php } ?>
								</td>
								<td>
									<a href="<?php echo $_Oli->getUrlParam(0) . $eachLink['link_key']; ?>" class="btn btn-success btn-xs">
										Go <i class="fa fa-angle-double-right fa-fw"></i>
									</a>
								</td>
								<td>
									<a href="<?php echo $_Oli->getUrlParam(0) . $eachLink['link_key']; ?>" class="copyLink btn btn-info btn-xs">
										Copy <i class="fa fa-clipboard fa-fw"></i>
									</a>
								</td>
								<td>
									<?php if(isset($selectedLinks) AND in_array($eachLink['id'], $selectedLinks) AND $confirmationNeeded) { ?>
										<a href="<?php echo $_Oli->getUrlParam(0) . $_Oli->getUrlParam(1); ?>/delete/<?php echo $eachLink['id']; ?>/confirmed" class="btn btn-warning btn-xs">
											Confirm <i class="fa fa-trash fa-fw"></i>
										</a>
									<?php } else { ?>
										<a href="<?php echo $_Oli->getUrlParam(0) . $_Oli->getUrlParam(1); ?>/delete/<?php echo $eachLink['id']; ?>" class="btn btn-danger btn-xs">
											Delete <i class="fa fa-trash fa-fw"></i>
										</a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<a href="#selectAll" class="selectAll btn btn-primary btn-xs">
									Select All <i class="fa fa-check-square fa-fw"></i>
								</a>
								<a href="#unselectAll" class="unselectAll btn btn-danger btn-xs">
									Unselect All <i class="fa fa-square-o fa-fw"></i>
								</a>
							</td>
							<td colspan="2"><?php echo $countLinks; ?> <small>link<?php if($countLinks > 1) { ?>s<?php } ?></small></td>
							<td>
								<a href="<?php echo $_Oli->getUrlParam(0) . $_Oli->getUrlParam(1); ?>/delete/" class="deleteSelected btn btn-danger btn-xs">
									Selected <i class="fa fa-trash fa-fw"></i>
								</a>
							</td>
						</tr>
					</tfoot>
				</table>
				
				<?php /*if($_Oli->getUserRightLevel(array('username' => $_Oli->getAuthKeyOwner())) >= $_Oli->translateUserRight('MODERATOR')) { ?>
					<a href="<?php echo $_Oli->getUrlParam(0); ?>admin" class="btn btn-primary disabled">Accéder au panel de modération</a>
				<?php }*/ ?>
			<?php } else { ?>
				<h3>You don't have any shortened link saved.</h3>
			<?php } ?>
		</div>
	</div>
</div>

<?php include COMMONPATH . 'footer.php'; ?>

</body>
</html>