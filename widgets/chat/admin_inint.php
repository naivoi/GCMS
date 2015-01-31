<?php
	// widgets/chat/admin_inint.php
	if (defined('MAIN_INIT') && $isAdmin && (!defined('DB_CHAT') || empty($lng['LNG_CHAT']))) {
		// เมนูติดตั้ง
		$admin_menus['tools']['install']['chat'] = '<a href="index.php?module=install&amp;widgets=chat"><span>Chat Room</span></a>';
		unset($admin_menus['widgets']['chat']);
	}
