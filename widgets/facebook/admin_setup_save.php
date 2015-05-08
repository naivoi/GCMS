<?php
	// widgets/facebook/admin_save.php
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
		$config['facebook_width'] = (int)$_POST['facebook_width'];
		$config['facebook_height'] = (int)$_POST['facebook_height'];
		$config['facebook_user'] = $db->sql_trim_str($_POST, 'facebook_user');
		$config['facebook_show_facepile'] = gcms::getVars($_POST, 'facebook_show_facepile', 0);
		$config['facebook_show_posts'] = gcms::getVars($_POST, 'facebook_show_posts', 0);
		$config['facebook_hide_cover'] = gcms::getVars($_POST, 'facebook_hide_cover', 0);
		// ตรวจสอบค่าที่ส่งมา
		if (empty($config['facebook_user']) || !preg_match('/^[a-z\d.]{1,}$/i', $config['facebook_user'])) {
			$ret['error'] = 'FACEBOOK_INVALID_USERNAME';
			$ret['input'] = 'facebook_user';
			$ret['ret_facebook_user'] = 'FACEBOOK_INVALID_USERNAME';
		} else {
			// บันทึก config.php
			if (gcms::saveconfig(CONFIG, $config)) {
				$ret['error'] = 'SAVE_COMPLETE';
				$ret['location'] = 'reload';
			} else {
				$ret['error'] = 'DO_NOT_SAVE';
			}
		}
		// คืนค่า JSON
		echo gcms::array2json($ret);
	}
