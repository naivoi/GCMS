<?php
	// widgets/chat/admin_action.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('../../bin/inint.php');
	// referer, admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		// ค่าที่ส่งมา
		$action = gcms::getVars($_POST, 'action', '');
		$id = gcms::getVars($_POST, 'id', '');
		if ($action == 'delete') {
			$db->query("DELETE FROM `".DB_CHAT."` WHERE `id` IN ($id)");
		}
	}
