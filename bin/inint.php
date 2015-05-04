<?php
	// bin/inint.php
	// session, cookie
	session_start();
	if (!ob_get_status()) {
		if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
			// เปิดใช้งานการบีบอัดหน้าเว็บไซต์
			ob_start('ob_gzhandler');
		} else {
			ob_start();
		}
	}
	// load
	include dirname(__FILE__).'/load.php';
