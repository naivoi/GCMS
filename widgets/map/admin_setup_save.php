<?php
	// widgets/map/admin_setup_save.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// ตรวจสอบ referer และ admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		if (isset($_SESSION['login']['account']) && $_SESSION['login']['account'] == 'demo') {
			$ret = array('error' => 'EX_MODE_ERROR');
		} else {
			// โหลด config ใหม่
			$config = array();
			if (is_file(CONFIG)) {
				include CONFIG;
			}
			// ค่าที่ส่งมา
			$config['map_height'] = max(100, (int)$_POST['map_height']);
			$config['map_info'] = $db->sql_trim($_POST, 'map_info');
			$config['map_zoom'] = gcms::getVars($_POST, 'map_zoom', 0);
			$config['map_latigude'] = trim(gcms::getVars($_POST, 'map_latigude', ''));
			$config['map_lantigude'] = trim(gcms::getVars($_POST, 'map_lantigude', ''));
			$config['map_info_latigude'] = trim(gcms::getVars($_POST, 'info_latigude', ''));
			$config['map_info_lantigude'] = trim(gcms::getVars($_POST, 'info_lantigude', ''));
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
