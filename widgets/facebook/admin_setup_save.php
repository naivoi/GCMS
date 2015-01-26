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
		$config['facebook_width'] = max(100, (int)$_POST['facebook_width']);
		$config['facebook_height'] = max(100, (int)$_POST['facebook_height']);
		$config['facebook_user'] = $db->sql_trim_str(gcms::getVars($_POST, 'facebook_user', ''));
		$config['facebook_faces'] = gcms::getVars($_POST, 'facebook_faces', 0);
		$config['facebook_stream'] = gcms::getVars($_POST, 'facebook_stream', 0);
		$config['facebook_header'] = gcms::getVars($_POST, 'facebook_header', 0);
		$config['facebook_border'] = gcms::getVars($_POST, 'facebook_border', 0);
		// ตรวจสอบค่าที่ส่งมา
		if ($config['facebook_user'] == '' || !preg_match('/^[a-z\d.]{1,}$/i', $config['facebook_user'])) {
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