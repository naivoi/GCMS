<?php
	// widgets/tags/action.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// referer
	if (gcms::isReferer()) {
		// อัปเดทการคลิก
		list($action, $id) = explode('-', $_POST['id']);
		if ($action == 'tags') {
			$sql = "UPDATE `".DB_TAGS."` SET `count`=`count`+1 WHERE `id`=".(int)$id." LIMIT 1";
			$db->query($sql);
		}
	}
