<?php
	// widgets/chat/admin_save.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('../../bin/inint.php');
	$ret = array();
	// referer, admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		if (isset($_SESSION['login']['account']) && $_SESSION['login']['account'] == 'demo') {
			$ret['error'] = 'EX_MODE_ERROR';
		} else {
			// โหลด config ใหม่
			$config = array();
			if (is_file(CONFIG)) {
				include CONFIG;
			}
			// ค่าที่ส่งมา
			$config['chat_time'] = max(2, (int)$_POST['chat_time']);
			$config['chat_history'] = max(1, (int)$_POST['chat_history']);
			$config['chat_lines'] = max(10, (int)$_POST['chat_lines']);
			// บันทึก config.php
			if (gcms::saveconfig(CONFIG, $config)) {
				$ret['chat_time'] = $config['chat_time'];
				$ret['chat_history'] = $config['chat_history'];
				$ret['chat_lines'] = $config['chat_lines'];
				$ret['error'] = 'SAVE_COMPLETE';
			} else {
				$ret['error'] = 'DO_NOT_SAVE';
			}
		}
		// คืนค่า JSON
		echo gcms::array2json($ret);
	}
