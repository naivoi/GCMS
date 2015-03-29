<?php
	// widgets/tags/admin_seup_save.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	$ret = array();
	// referer, admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		if (isset($_SESSION['login']['account']) && $_SESSION['login']['account'] == 'demo') {
			$ret['error'] = 'EX_MODE_ERROR';
		} else {
			$save = array();
			// ค่าที่ส่งมา
			$save['tag'] = $db->sql_trim_str($_POST, 'tags_tag');
			$id = gcms::getVars($_POST, 'tags_id', 0);
			if ($id > 0) {
				$tags = $db->getRec(DB_TAGS, $id);
			}
			if ($id > 0 && !$tags) {
				$ret['alert'] = $lng['LNG_TAGS_NOT_FOUND'];
			} elseif ($save['tag'] == '') {
				$ret['alert'] = $lng['LNG_TAGS_EMPTY'];
				$ret['input'] = 'tags_tag';
			} else {
				// ตรวจสอบรายการซ้ำ
				$search = $db->basicSearch(DB_TAGS, 'tag', $save['tag']);
				if ($search && ($id == 0 || ($id > 0 && $search['id'] != $id))) {
					$ret['alert'] = $lng['LNG_TAGS_EXISTS'];
					$ret['input'] = 'tags_tag';
				} else {
					if ($id == 0) {
						// ใหม่
						$save['count'] = 0;
						$id = $db->add(DB_TAGS, $save);
						// คืนค่ารายการใหม่
						$tr = '<tr id="L_'.$id.'">';
						$tr .= '<th headers="c1" id="r'.$id.'" scope="row" class="topic"><a id="edit_'.$id.'" href="'.WEB_URL.'/admin/index.php?module=tags-setup&amp;id='.$id.'">'.htmlspecialchars($save['tag']).'</a></th>';
						$tr .= '<td headers="r'.$id.' c2" class="check-column"><a id="check_'.$id.'" class="icon-uncheck"></a></td>';
						$tr .= '<td headers="r'.$id.' c3" class="visited">0</td>';
						$tr .= '</tr>';
						$ret['content'] = rawurlencode($tr);
					} else {
						// แก้ไข
						$db->edit(DB_TAGS, $id, $save);
						// คืนค่า
						$ret['tags_tag'] = rawurlencode($save['tag']);
					}
					$ret['id'] = $id;
					$ret['error'] = 'SAVE_COMPLETE';
				}
			}
		}
		// คืนค่า JSON
		echo gcms::array2json($ret);
	}
