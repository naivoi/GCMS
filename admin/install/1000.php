<?php
	if (INSTALL_INIT == 'upgrade') {
		$current_version = '10.0.0';
		// update db_province
		$db->query("ALTER TABLE `".DB_PROVINCE."` CHANGE `id` `id` SMALLINT( 3 ) UNSIGNED NOT NULL");
		$db->query("ALTER TABLE `".DB_PROVINCE."` ADD PRIMARY KEY ( `id` ) ;");
		echo '<li class=correct>Update database <strong>'.DB_PROVINCE.'</strong> <i>complete...</i></li>';
		ob_flush();
		flush();
		// ubdate db_menus
		$db->query("ALTER TABLE `".DB_MENUS."` CHANGE `published` `published` ENUM('0', '1', '2','3') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'");
		echo '<li class=correct>Update database <strong>'.DB_MENUS.'</strong> <i>complete...</i></li>';
		ob_flush();
		flush();
		$db->query("UPDATE `".DB_USER."` SET `address2`=CONCAT(`address2`,' ',`tambon`,' ',`district`)");
		$db->query("ALTER TABLE `".DB_USER."` DROP `tambon`,DROP `district`,DROP `tambonID`,DROP `districtID`,DROP `introduce`");
		$db->query("ALTER TABLE `".DB_USER."` ADD `pname` VARCHAR( 50 ) NULL AFTER `password`");
		$db->query("ALTER TABLE `".DB_USER."` ADD `admin_access` ENUM('0','1') NOT NULL DEFAULT '0';");
		$db->query("UPDATE `".DB_USER."` SET `admin_access`='1' WHERE `id` IN (SELECT * FROM (SELECT `id` FROM `".DB_USER."` WHERE `status` IN (".implode(',', $config['admin_access']).")) AS Z);");
		echo '<li class=correct>Update database <strong>'.DB_USER.'</strong> <i>complete...</i></li>';
		ob_flush();
		flush();
		$db->query("UPDATE `".DB_BOARD_Q."` SET `create_date`=`last_update` WHERE `create_date`=0");
		echo '<li class=correct>Update database <strong>'.DB_BOARD_Q.'</strong> <i>complete...</i></li>';
		ob_flush();
		flush();
	}
