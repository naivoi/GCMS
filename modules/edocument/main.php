<?php
	// modules/edocument/main.php
	if (defined('MAIN_INIT')) {
		// ตรวจสอบโมดูล
		$sql = "SELECT I.`module_id`,M.`module`,D.`detail`,D.`topic`,D.`description`,D.`keywords`";
		$sql .= " FROM `".DB_INDEX_DETAIL."` AS D";
		$sql .= " INNER JOIN `".DB_INDEX."` AS I ON I.`id`=D.`id` AND I.`module_id`=D.`module_id` AND I.`index`='1' AND I.`language`=D.`language`";
		$sql .= " INNER JOIN `".DB_MODULES."` AS M ON M.`id`=D.`module_id` AND M.`owner`='edocument'";
		$sql .= " WHERE D.`language` IN ('".LANGUAGE."','') LIMIT 1";
		$index = $cache->get($sql);
		if (!$index) {
			$index = $db->customQuery($sql);
			$cache->save($sql, $index);
		}
		if (sizeof($index) == 0) {
			$title = $lng['LNG_DATA_NOT_FOUND'];
			$content = '<div class=error>'.$title.'</div>';
		} else {
			$index = $index[0];
			// breadcrumbs
			$breadcrumb = gcms::loadtemplate($index['module'], '', 'breadcrumb');
			$breadcrumbs = array();
			// หน้าหลัก
			$canonical = WEB_URL.'/index.php';
			$breadcrumbs['HOME'] = gcms::breadcrumb('icon-home', $canonical, $install_modules[$module_list[0]]['menu_tooltip'], $install_modules[$module_list[0]]['menu_text'], $breadcrumb);
			// โมดูล
			if ($index['module'] != $module_list[0]) {
				if (isset($install_modules[$index['module']]['menu_text'])) {
					$m = $install_modules[$index['module']]['menu_text'];
					$t = $install_modules[$index['module']]['menu_tooltip'];
				} else {
					$m = ucwords($index['module']);
					$t = $m;
				}
				$canonical = gcms::getURL($index['module']);
				$breadcrumbs['MODULE'] = gcms::breadcrumb('', $canonical, $t, $m, $breadcrumb);
			}
			// login id (guest = -1)
			$status = $isMember ? $_SESSION['login']['status'] : -1;
			$login_id = isset($_SESSION['login']) ? (int)$_SESSION['login']['id'] : 0;
			// default query
			$where = " WHERE D.`module_id`='$index[module_id]' AND (D.`sender_id`='$login_id' OR D.`reciever` REGEXP '(^|,)$status($|,)')";
			// จำนวนทั้งหมด
			$sql = "SELECT COUNT(*) AS `count` FROM `".DB_EDOCUMENT."` AS D $where";
			$count = $cache->get($sql);
			if (!$count) {
				$count = $db->customQuery($sql);
				$count = $count[0];
				$cache->save($sql, $count);
			}
			if ($count['count'] == 0) {
				// ไม่มีรายการใดๆ
				$content = '<div class=error>'.$lng['LNG_LIST_EMPTY'].'</div>';
			} else {
				// หน้าที่เรียก
				$page = gcms::getVars($_REQUEST, 'page', 0);
				$totalpage = round($count['count'] / $config['edocument_listperpage']);
				$totalpage += ($totalpage * $config['edocument_listperpage'] < $count['count']) ? 1 : 0;
				$page = $page > $totalpage ? $totalpage : $page;
				$page = $page < 1 ? 1 : $page;
				$start = $config['edocument_listperpage'] * ($page - 1);
				// list รายการ
				$sql = "SELECT D.*,U.`fname`,U.`lname`,U.`email`,U.`status` FROM `".DB_EDOCUMENT."` AS D";
				$sql .= " INNER JOIN `".DB_USER."` AS U ON U.`id`=D.`sender_id`";
				$sql .= " $where ORDER BY D.`last_update` DESC LIMIT $start,$config[edocument_listperpage]";
				$datas = $cache->get($sql);
				if (!$datas) {
					$datas = $db->customQuery($sql);
					$cache->save($sql, $datas);
				}
				// ผู้ดุแล
				$moderator = $isAdmin || gcms::canConfig($config['edocument_moderator']);
				// อ่านรายการลงใน $list
				$list = array();
				$patt = array('/(edit\s{ID})/', '/(report\s{ID})/', '/(delete\s{ID})/', '/{ID}/', '/{NAME}/', '/{EXT}/',
					'/{ICON}/', '/{DETAIL}/', '/{LASTUPDATE}/', '/{NO}/', '/{SIZE}/', '/{SENDER}/', '/{STATUS}/', '/{UID}/');
				$listitem = gcms::loadtemplate($index['module'], 'edocument', 'listitem');
				foreach ($datas AS $item) {
					$replace = array();
					$replace[] = $moderator || $login_id == $item['sender_id'] ? '\\1' : 'hidden';
					$replace[] = $moderator || $login_id == $item['sender_id'] ? '\\1' : 'hidden';
					$replace[] = $moderator || $login_id == $item['sender_id'] ? '\\1' : 'hidden';
					$replace[] = $item['id'];
					$replace[] = $item['topic'];
					$replace[] = $item['ext'];
					$replace[] = WEB_URL.'/skin/ext/'.(is_file(ROOT_PATH."skin/ext/$item[ext].png") ? $item['ext'] : 'file').'.png';
					$replace[] = $item['detail'];
					$replace[] = gcms::mktime2date($item['last_update']);
					$replace[] = $item['document_no'];
					$replace[] = gcms::formatFileSize($item['size']);
					$sender = trim("$item[fname] $item[lname]");
					$replace[] = $sender == '' ? $item['email'] : $sender;
					$replace[] = $item['status'];
					$replace[] = $item['sender_id'];
					$list[] = preg_replace($patt, $replace, $listitem);
				}
				// แสดงผล list รายการ
				$patt = array('/{BREADCRUMS}/', '/{LIST}/', '/{TOPIC}/', '/{DETAIL}/', '/{SPLITPAGE}/',
					'/{MODULE}/', '/{WIDGET_([A-Z]+)(([\s_])(.*))?}/e', '/{(LNG_[A-Z0-9_]+)}/e');
				$replace = array();
				$replace[] = implode("\n", $breadcrumbs);
				$replace[] = implode("\n", $list);
				$replace[] = $index['topic'];
				$replace[] = $index['detail'];
				$replace[] = $splitpage;
				$replace[] = $index['module'];
				$replace[] = 'gcms::getWidgets';
				$replace[] = 'gcms::getLng';
				$content = gcms::pregReplace($patt, $replace, gcms::loadtemplate($index['module'], 'edocument', 'main'));
			}
			// title,keywords,description
			$title = $index['topic'];
			$keywords = $index['keywords'];
			$description = $index['description'];
		}
	}
