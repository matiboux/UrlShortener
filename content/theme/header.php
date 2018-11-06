<header class="navbar navbar-static-top">
	<div class="container" style="max-width: 750px">
		<div class="navbar-header">
			<a href="<?=$_Oli->getUrlParam(0)?>" class="navbar-brand">
				<?=$_Oli->getSetting('name')?>
				<span class="hidden-xs small">– <?=$_Oli->getSetting('description')?></span>
			</a>
		</div>
		
		<nav class="collapse navbar-collapse bs-navbar-collapse">
			<?php /*<ul class="nav navbar-nav navbar-left">
				
			</ul>*/ ?>
			<?php /*<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?=$_Oli->getShortcutLink('home')?>">Matiboux.com <i class="fa fa-angle-right fa-fw"></i></a>
				</li>
			</ul>*/ ?>
		</nav>
	</div>
</header>