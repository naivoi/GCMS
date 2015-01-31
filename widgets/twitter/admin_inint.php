<?php
	// widgets/twitter/admin_inint.php
	if (defined('MAIN_INIT') && $isAdmin) {
		unset($admin_menus['widgets']['twitter']);
		if (empty($lng['LNG_TWITTER'])) {
			$admin_menus['tools']['install']['twitter'] = '<a href="index.php?module=install&amp;widgets=twitter"><span>Twitter</span></a>';
		} else {
			$admin_menus['widgets']['twitter'] = '<a href="'.WEB_URL.'/admin/index.php?module=twitter-setup" title="{LNG_TWITTER}"><span>{LNG_TWITTER}</span></a>';
		}
	}
