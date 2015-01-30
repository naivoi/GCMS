<?php
	// modules/event/admin_inint.php
	if (MAIN_INIT == 'admin' && $isAdmin && ((isset($install_modules['event']) && $install_modules['event']['owner'] != 'event') || !defined('DB_EVENTCALENDAR'))) {
		// เมนูติดตั้ง
		$admin_menus['tools']['install']['event'] = '<a href="index.php?module=install&amp;modules=event"><span>Event Calendar</span></a>';
	} else {
		// เมนูแอดมิน
		if (!gcms::canConfig($config, 'event_can_config')) {
			unset($admin_menus['modules']['event']['config']);
		}
		if (isset($config['event_can_write']) && gcms::canConfig($config, 'event_can_write')) {
			$admin_menus['modules']['event']['setup'] = '<a href="index.php?module=event-setup"><span>{LNG_EVENT_LIST}</span></a>';
		} else {
			unset($admin_menus['modules']['event']['setup']);
		}
	}
