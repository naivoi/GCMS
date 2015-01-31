<?php
	// widgets/shoutbox/admin_save.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('../../bin/inint.php');
	// referer, admin
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
			$config['shoutbox_time'] = max(2, (int)$_POST['shoutbox_time']);
			$config['shoutbox_history'] = max(1, (int)$_POST['shoutbox_history']);
			$config['shoutbox_lines'] = max(10, (int)$_POST['shoutbox_lines']);
			// บันทึก config.php
			if (gcms::saveconfig(CONFIG, $config)) {
				$ret['shoutbox_time'] = $config['shoutbox_time'];
				$ret['shoutbox_history'] = $config['shoutbox_history'];
				$ret['shoutbox_lines'] = $config['shoutbox_lines'];
				$ret['error'] = 'SAVE_COMPLETE';
			} else {
				$ret['error'] = 'DO_NOT_SAVE';
			}
		}
		// คืนค่า JSON
		echo gcms::array2json($ret);
	}
