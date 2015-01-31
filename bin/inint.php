<?php
	// bin/inint.php
	// running mode
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
	// comment 3 บรรทัดด้านล่าง เมือต้องการใช้งานจริง (debug mode)
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(-1);
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
