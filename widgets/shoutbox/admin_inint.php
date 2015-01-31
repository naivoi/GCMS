<?php
	// widgets/shoutbox/admin_inint.php
	if (defined('MAIN_INIT') && $isAdmin && (!defined('DB_SHOUTBOX') || empty($lng['LNG_SHOUTBOX']))) {
		// เมนูติดตั้ง
		$admin_menus['tools']['install']['shoutbox'] = '<a href="index.php?module=install&amp;widgets=shoutbox"><span>Shout Box</span></a>';
		unset($admin_menus['widgets']['shoutbox']);
	}
