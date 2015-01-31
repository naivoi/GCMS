<?php
	// widgets/twitter/admin_setup_save.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// ตรวจสอบ referer และ admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		// โหลด config ใหม่
		$config = array();
		if (is_file(CONFIG)) {
			include CONFIG;
		}
		// ค่าที่ส่งมา
		$config['twitter_height'] = max(100, gcms::getVars($_POST, 'twitter_height', 0));
		$config['twitter_id'] = $db->sql_trim_str($_POST, 'twitter_id');
		$config['twitter_name'] = $db->sql_trim_str($_POST, 'twitter_name');
		$config['twitter_theme'] = $db->sql_trim_str($_POST, 'twitter_theme');
		$config['twitter_border_color'] = strtoupper(trim($_POST['twitter_border_color']));
		$config['twitter_link_color'] = strtoupper(trim($_POST['twitter_link_color']));
		$config['twitter_count'] = gcms::getVars($_POST, 'twitter_count', 0);
		// บันทึก config.php
		if (gcms::saveconfig(CONFIG, $config)) {
			$ret['error'] = 'SAVE_COMPLETE';
			$ret['location'] = 'reload';
		} else {
			$ret['error'] = 'DO_NOT_SAVE';
		}
		// คืนค่า JSON
		echo gcms::array2json($ret);
	}
