<?php
	// widgets/tags/admin_action.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// referer, admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		$ret = array();
		if (empty($_SESSION['login']['account']) || $_SESSION['login']['account'] != 'demo') {
			// ค่าที่ส่งมา
			if (isset($_POST['data'])) {
				list($action, $id) = explode('_', $_POST['data']);
			} else {
				$action = gcms::getVars($_POST, 'action', '');
				$id = gcms::getVars($_POST, 'id', '');
				$value = gcms::getVars($_POST, 'value', 0);
			}
			if ($action == 'delete') {
				// ลบ
				$sql = "DELETE FROM `".DB_TAGS."` WHERE `id` IN($id)";
				$db->query($sql);
			} elseif ($action == 'edit') {
				// เลือกเพื่อแก้ไข
				$tags = $db->getRec(DB_TAGS, $id);
				// คืนค่า
				if (!$tags) {
					$ret['error'] = 'ACTION_ERROR';
				} else {
					$ret['tags_tag'] = rawurlencode($tags['tag']);
					$ret['tags_id'] = $tags['id'];
					$ret['input'] = 'tags_tag';
				}
			}
		}
		// คืนค่าเป็น JSON
		echo gcms::array2json($ret);
	}
