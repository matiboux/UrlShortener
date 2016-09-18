<?php /*<li>
	<a href="<?php if($_Oli->verifyAuthKey()) { ?><?php echo $_Oli->getShortcutLink('manager'); ?>main-infos/<?php } else { ?>#<?php } ?>">
		<?php echo strtoupper($_Oli->getCurrentLanguage()); ?>
	</a>
</li>*/ ?>
<?php if($_Oli->verifyAuthKey()) { ?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
			<?php echo $_Oli->getAuthKeyOwner(); ?> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="<?php echo $_Oli->getShortcutLink('projects'); ?>"><i class="fa fa-paw fa-fw"></i> Projects</a>
			</li>
			<li>
				<a href="<?php echo $_Oli->getShortcutLink('accounts'); ?>"><i class="fa fa-user fa-fw"></i> Your account</a>
			</li>
			<li>
				<a href="<?php echo $_Oli->getShortcutLink('admin'); ?>"><i class="fa fa-gear fa-fw"></i> Admin panel</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="<?php echo $_Oli->getShortcutLink('login'); ?>logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
			</li>
		</ul>
	</li>
<?php } else { ?>
	<li>
		<a href="<?php echo $_Oli->getShortcutLink('login'); ?>"><i class="fa fa-sign-in fa-fw"></i> Login</a>
	</li>
<?php } ?>