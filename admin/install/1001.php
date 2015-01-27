<?php
	if (INSTALL_INIT == 'upgrade') {
		$current_version = '10.0.1';
		if (defined('DB_TEXTLINK')) {
			$db->query('ALTER TABLE `'.DB_TEXTLINK.'` ADD `target` VARCHAR( 6 ) NOT NULL');
			echo '<li class=correct>Update database <strong>'.DB_TEXTLINK.'</strong> <i>complete...</i></li>';
			ob_flush();
			flush();
		}
	}