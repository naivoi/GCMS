<?php
	// widgets/marquee/admin_inint.php
	if (defined('MAIN_INIT') && $isAdmin) {
		unset($admin_menus['widgets']['marquee']);
		if (empty($lng['LNG_WIDGETS_MARQUEE'])) {
			$admin_menus['tools']['install']['marquee'] = '<a href="index.php?module=install&amp;widgets=marquee"><span>Marquee</span></a>';
		} else {
			$admin_menus['widgets']['marquee'] = '<a href="index.php?module=marquee-setup"><span>{LNG_WIDGETS_MARQUEE}</span></a>';
		}
	}
