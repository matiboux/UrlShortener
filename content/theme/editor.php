<?php
if($_Oli->getUserRightLevel() < $_Oli->translateUserRight('OWNER')) header('Location: ' . $_Oli->getShortcutLink('login'));

if($_Oli->issetPostVars()) {
	if($_Oli->isEmptyPostVars('title') AND $_Oli->isEmptyPostVars('description')) $resultCode = 'D:You need to enter at least either the title or the description.';
	else if($_Oli->getUrlParam(2) == 'e' AND !empty($_Oli->getUrlParam(3))) {
		if($_Oli->updateInfosMySQL('career', array('title' => $_Oli->getPostVars('title'), 'description' => $_Oli->getPostVars('description') ?: '', 'tag' => strtolower($_Oli->getPostVars('tag')) ?: '', 'icon' => $_Oli->getPostVars('icon') ?: '', 'status' => $_Oli->getPostVars('status') ?: '', 'date' => $_Oli->getPostVars('date') ?: '', 'edited' => date('Y-m-d H:i:s')), array('id' => $_Oli->getUrlParam(3)))) header('Location: ' . $_Oli->getUrlParam(0) . '#item-' . $_Oli->getUrlParam(3));
		else $resultCode = 'D:An error occured.';
	} else {
		if($id = $_Oli->getPostVars('id')) {
			$items = $_Oli->getLinesMySQL('career', null, array('fromId' => $_Oli->getPostVars('id')), false, true);
			foreach($items as $eachItem) {
				$_Oli->deleteLinesMySQL('career', array('id' => $eachItem['id']));
			}
			foreach($items as $eachItem) {
				$_Oli->insertLineMySQL('career', array_merge($eachItem, array('id' => ++$id)));
			}
		}
		
		if($_Oli->insertLineMySQL('career', array('id' => $_Oli->getPostVars('id') ?: $_Oli->getLastInfoMySQL('career', 'id') + 1, 'title' => $_Oli->getPostVars('title') ?: '', 'description' => $_Oli->getPostVars('description') ?: '', 'tag' => strtolower($_Oli->getPostVars('tag')) ?: '', 'icon' => $_Oli->getPostVars('icon') ?: '', 'status' => $_Oli->getPostVars('status') ?: '', 'date' => $_Oli->getPostVars('date') ?: '', 'edited' => date('Y-m-d H:i:s')))) header('Location: ' . $_Oli->getUrlParam(0) . '#item-' . $_Oli->getPostVars('id') ?: $_Oli->getLastInfoMySQL('career', 'id') + 1);
		else $resultCode = 'D:An error occured.';
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

<?php include THEMEPATH . 'header.php'; ?>

<div id="main">
	<div class="container" style="max-width: 750px">
		<?php if($_Oli->getUrlParam(2) == 'e' AND !empty($_Oli->getUrlParam(3))) { ?><h2>Editing item #<?=$_Oli->getUrlParam(3)?></h2>
		<?php } else { ?><h2>New item!</h2><?php } ?>
		
		<?php if(isset($resultCode)) { ?>
			<?php
			list($prefix, $message) = explode(':', $resultCode, 2);
			if($prefix == 'P') $type = 'text-primary';
			else if($prefix == 'S') $type = 'text-success';
			else if($prefix == 'I') $type = 'text-info';
			else if($prefix == 'W') $type = 'text-warning';
			else if($prefix == 'D') $type = 'text-danger';
			?>
			<p class="<?php echo $type; ?>"><i class="fa fa-exclamation fa-fw"></i> <?php echo $message; ?></p>
		<?php } ?>
		
		<?php
		if(!empty($_Oli->getUrlParam(3))) {
			if($_Oli->getUrlParam(2) == 'e') $editingItem = $_Oli->getLinesMySQL('career', array('id' => $_Oli->getUrlParam(3)), array('limit' => 1), false);
			else if($_Oli->getUrlParam(2) == 'n') $newId = $_Oli->getUrlParam(3);
		}
		?>
		<form action="<?php echo $_Oli->getUrlParam(0); ?>form.php" class="form form-horizontal">
			<div class="form-group">
				<div class="input-group">
					<?php if($_Oli->getUrlParam(2) == 'e' AND !empty($_Oli->getUrlParam(3))) { ?><span class="input-group-addon">Editing #</span>
					<?php } else { ?><span class="input-group-addon">New #</span><?php } ?>
					<input class="form-control" type="text" name="id" placeholder="<?=$_Oli->getLastInfoMySQL('career', 'id') + 1?>" value="<?=htmlspecialchars($_Oli->getPostVars('id') ?: $editingItem['id'] ?: $newId)?>" <?php if($editingItem) { ?>disabled<?php } ?> />
				</div>
				<p class="help-block">Leave this empty for a small item.</p>
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="title" placeholder="Title" value="<?=htmlspecialchars($_Oli->getPostVars('title') ?: $editingItem['title'])?>" />
			</div>
			<div class="form-group">
				<textarea class="form-control" name="description" placeholder="Description" rows="3"><?=htmlspecialchars($_Oli->getPostVars('description') ?: $editingItem['description'])?></textarea>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
					<input class="form-control" type="text" name="tag" placeholder="Tag" value="<?=htmlspecialchars($_Oli->getPostVars('tag') ?: $editingItem['tag'])?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">-</span>
					<input class="form-control" type="text" name="icon" placeholder="Font Awesome Icon" value="<?=htmlspecialchars($_Oli->getPostVars('icon') ?: $editingItem['icon'])?>" />
				</div>
			</div>
			<div class="form-group">
				<div class="radio">
					<label><input type="radio" name="status" value="active" <?php if((!$_Oli->issetPostVars('status') AND !isset($editingItem['status'])) OR $_Oli->getPostVars('status') == 'active' OR $editingItem['status'] == 'active') { ?>checked<?php } ?> /> Active project</label> <br />
					<label><input type="radio" name="status" value="standby" <?php if($_Oli->getPostVars('status') == 'standby' OR $editingItem['status'] == 'standby') { ?>checked<?php } ?> /> Standby project</label> <br />
					<label><input type="radio" name="status" value="inactive" <?php if($_Oli->getPostVars('status') == 'inactive' OR $editingItem['status'] == 'inactive') { ?>checked<?php } ?> /> Inactive project</label> <br />
					<label><input type="radio" name="status" value="normal" <?php if($_Oli->getPostVars('status') == 'normal' OR $editingItem['status'] == 'normal') { ?>checked<?php } ?> /> Regular project / Other</label> <br />
					<label><input type="radio" name="status" value="replaced" <?php if($_Oli->getPostVars('status') == 'replaced' OR $editingItem['status'] == 'replaced') { ?>checked<?php } ?> /> Replaced project</label> <br />
					<label><input type="radio" name="status" value="left" <?php if($_Oli->getPostVars('status') == 'left' OR $editingItem['status'] == 'left') { ?>checked<?php } ?> /> Left project</label> <br />
					<label><input type="radio" name="status" value="dead" <?php if($_Oli->getPostVars('status') == 'dead' OR $editingItem['status'] == 'dead') { ?>checked<?php } ?> /> Dead project</label>
				</div>
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="date" placeholder="Showed date" value="<?=htmlspecialchars($_Oli->getPostVars('date') ?: $editingItem['date'])?>" />
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i> Sumbit</button>
				– <button type="reset" class="btn btn-danger btn-xs"><i class="fa fa-times fa-fw"></i> Reset</button>
			</div>
		</form>
	</div>
</div>

<?php $_Oli->loadEndHtmlFiles(); ?>

</body>
</html>