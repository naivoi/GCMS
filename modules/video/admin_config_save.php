<?php
	// modules/video/admin_config_save.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// referer, admin
	if (gcms::isReferer() && gcms::canConfig($config['video_can_config'])) {
		if (isset($_SESSION['login']['account']) && $_SESSION['login']['account'] == 'demo') {
			$ret = array('error' => 'EX_MODE_ERROR');
		} else {
			// โหลด config ใหม่
			$config = array();
			if (is_file(CONFIG)) {
				include CONFIG;
			}
			// ค่าที่ส่งมา
			$config['video_cols'] = gcms::getVars($_POST, 'config_cols', 0);
			$config['video_rows'] = gcms::getVars($_POST, 'config_rows', 0);
			$config['video_can_write'] = isset($_POST['config_can_write']) ? $_POST['config_can_write'] : array();
			$config['video_can_write'][] = 1;
			$config['video_can_config'] = isset($_POST['config_can_config']) ? $_POST['config_can_config'] : array();
			$config['video_can_config'][] = 1;
			// บันทึก config.php
			if (gcms::saveconfig(CONFIG, $config)) {
				$ret = array('error' => 'SAVE_COMPLETE', 'location' => 'reload');
			} else {
				$ret = array('error' => 'DO_NOT_SAVE');
			}
		}
	} else {
		$ret = array('error' => 'ACTION_ERROR');
	}
	// คืนค่าเป็น JSON
	echo gcms::array2json($ret);
