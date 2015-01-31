<?php
	// widgets/marquee/admin_save.php
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
		$config['marquee_speed'] = (int)$_POST['marquee_speed'];
		$config['marquee_text'] = preg_replace('/[\r\n\t\\\\]/isu', '', trim($_POST['marquee_text']));
		// บันทึก config.php
		if (gcms::saveconfig(CONFIG, $config)) {
			$ret['error'] = 'SAVE_COMPLETE';
			$ret['eval'] = rawurlencode('window.location.reload()');
		} else {
			$ret['error'] = 'DO_NOT_SAVE';
		}
		// คืนค่า JSON
		echo gcms::array2json($ret);
	}
