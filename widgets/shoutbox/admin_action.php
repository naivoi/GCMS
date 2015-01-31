<?php
	// widgets/shoutbox/admin_action.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('../../bin/inint.php');
	// referer, admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		if (empty($_SESSION['login']['account']) || $_SESSION['login']['account'] != 'demo') {
			// ค่าที่ส่งมา
			$action = gcms::getVars($_POST, 'action', '');
			$id = gcms::getVars($_POST, 'id', '');
			if ($action == 'delete') {
				$db->query("DELETE FROM `".DB_SHOUTBOX."` WHERE `id` IN ($id)");
			}
		}
	}
