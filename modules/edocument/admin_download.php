<?php
	// modules/edocument/admin_download.php
	session_cache_limiter('none');
	session_start();
	// inint
	include '../../bin/inint.php';
	// referer
	if (gcms::isReferer() && gcms::canConfig($config, 'edocument_moderator')) {
		// ตรวจสอบไฟล์ดาวน์โหลด
		$file = $db->getRec(DB_EDOCUMENT, $_GET['id']);
		if ($file) {
			$file_path = DATA_PATH."edocument/$file[file]";
			if (is_file($file_path)) {
				// ดาวน์โหลดไฟล์
				header('Cache-Control: private');
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header('Content-Disposition: attachment; filename="'.iconv('UTF-8', 'TIS-620', "$file[topic].$file[ext]")).'"';
				header('Content-Transfer-Encoding: binary');
				header('Accept-Ranges: bytes');
				set_time_limit(0);
				readfile($file_path);
			} else {
				header("HTTP/1.0 404 Not Found");
			}
		} else {
			header("HTTP/1.0 404 Not Found");
		}
	} else {
		header("HTTP/1.0 404 Not Found");
	}
