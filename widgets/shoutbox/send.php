<?php
	// widgets/shoutbox/send.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('../../bin/inint.php');
	// referer
	if (gcms::isReferer()) {
		// ค่าที่ส่งมา
		$save = array();
		$save['text'] = $db->sql_trim_str($_POST, 'val');
		$save['time'] = gcms::getVars($_POST, 'time', 0);
		$save['sender'] = $db->sql_trim_str($_POST, 'sender');
		// save message
		$db->add(DB_SHOUTBOX, $save);
	}
