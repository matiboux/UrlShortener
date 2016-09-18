<div class="footer">
	<?php /*<div class="social">
		<li><a href="https://twitter.com/Matiboux" class="fa fa-twitter icon"><span class="sr-only">Twitter</span></a></li> 
		<li><a href="https://www.facebook.com/pages/Matiboux/186196714888132" class="fa fa-facebook icon"><span class="sr-only">Facebook</span></a></li>
		<li><a href="https://plus.google.com/110660516774094928388" class="fa fa-google-plus icon"><span class="sr-only">Google+</span></a></li>
		<li><a href="http://steamcommunity.com/id/matiboux/" class="fa fa-steam icon"><span class="sr-only">Steam</span></a></li>
		<li><a href="https://www.youtube.com/matiboux/" class="fa fa-youtube icon"><span class="sr-only">YouTube</span></a></li>
		<li><a href="http://www.twitch.tv/matiboux" class="fa fa-twitch icon"><span class="sr-only">Twitch</span></a></li>
	</div>*/ ?>
	
	<div class="copyright">
		<?php $creationDate = $_Oli->getSetting('creation_date'); ?>
		<?php $projectsYear = date('Y', strtotime($creationDate)); ?>
		
		<li>
			<i class="fa fa-copyright"></i> <?php echo $_Oli->getSetting('owner'); ?>
			<?php if(!empty($creationDate)) { ?>
				<?php if(date('Y', strtotime($creationDate)) < date('Y')) { ?>
					<?php echo date('Y', strtotime($creationDate)); ?>-<?php echo date('Y'); ?>
				<?php } else echo date('Y', strtotime($creationDate)); ?>
			<?php } ?>
		</li>
		
		<?php if(!empty($projectsVersion = $_Oli->getSetting('version'))) { ?>
			<li>
				Version <?php echo $_Oli->getSetting('version'); ?>
			</li>
		<?php } ?>
	</div>
	
	<p class="xsmall">
		<?php
		echo $_Oli->getSetting('name');
		if(!empty($creationDate)) {
		?>, created on
			<?php
			switch(date('n', strtotime($creationDate))) {
				case 1: echo 'January'; break;
				case 2: echo 'February'; break;
				case 3: echo 'March'; break;
				case 4: echo 'April'; break;
				case 5: echo 'May'; break;
				case 6: echo 'June'; break;
				case 7: echo 'July'; break;
				case 8: echo 'August'; break;
				case 9: echo 'September'; break;
				case 10: echo 'October'; break;
				case 11: echo 'November'; break;
				case 12: echo 'December'; break;
			}
			?> <?php
			echo $creationDay = date('j', strtotime($creationDate));
			if(substr($creationDay, 0, 1) != 1 AND substr($creationDay, 1, 1) == 1) echo 'st';
			else if(substr($creationDay, 0, 1) != 1 AND substr($creationDay, 1, 1) == 2) echo 'nd';
			else if(substr($creationDay, 0, 1) != 1 AND substr($creationDay, 1, 1) == 3) echo 'rd';
			else echo 'th';
			?>, <?php echo date('Y', strtotime($creationDate)); ?>
		<?php } ?>
		
	</p>
</div>

<?php $_Oli->loadEndHtmlFiles(); ?>

<!-- Script executed with Oli PHP Framework in <?php echo $_Oli->getExecuteDelay() * 1000; ?> ms -->
<!-- Request executed with Oli PHP Framework in <?php echo $_Oli->getExecuteDelay(true) * 1000; ?> ms -->