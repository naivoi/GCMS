<?php
	// widgets/tags/admin_inint.php
	if (defined('MAIN_INIT') && $isAdmin && !defined('DB_TAGS')) {
		// เมนูติดตั้ง
		$admin_menus['tools']['install']['tags'] = '<a href="index.php?module=install&amp;widgets=tags"><span>{LNG_TAGS}</span></a>';
		unset($admin_menus['widgets']['tags']);
	}
