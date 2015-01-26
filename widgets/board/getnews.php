<?php
	// widgets/board/getnews.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('../../bin/inint.php');
	// ตรวจสอบ referer
	if (gcms::isReferer() && preg_match('/^widget_([a-z0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)_([0-9]+)$/', $_POST['id'], $match)) {
		// อ่านโมดูล
		$sql = "SELECT `id`,`config`,`module` FROM `".DB_MODULES."` WHERE `id`=".(int)$match[2]." LIMIT 1";
		$index = $cache->get($sql);
		if (!$index) {
			$index = $db->customQuery($sql);
			if (sizeof($index) == 1) {
				$index = $index[0];
				// อ่าน config
				gcms::r2config($index['config'], $index);
				unset($index['config']);
				// save cached
				$cache->save($sql, $index);
			} else {
				$index = false;
			}
		}
		if ($index && $match[4] > 0) {
			// query
			$sql = "SELECT Q.`id`,Q.`topic`,Q.`picture`,Q.`last_update`,Q.`comment_date`,Q.`create_date`,Q.`detail`,U.`status`,U.`id` AS `member_id`";
			$sql .= ",(CASE WHEN ISNULL(U.`id`) THEN (CASE WHEN Q.`comment_date`>0 THEN Q.`commentator` ELSE Q.`email` END) ELSE (CASE WHEN U.`displayname`='' THEN U.`email` ELSE U.`displayname` END) END) AS `displayname`";
			$sql .= " FROM `".DB_BOARD_Q."` AS Q";
			$sql .= " LEFT JOIN `".DB_USER."` AS U ON U.`id`=(CASE WHEN Q.`comment_date`>0 THEN Q.`commentator_id` ELSE Q.`member_id` END)";
			$sql .= " WHERE Q.`module_id`=$index[id]";
			if ($match[3] > 0) {
				$sql .= " AND Q.`category_id`=$match[3]";
			}
			$sql .= " ORDER BY Q.`last_update` DESC LIMIT $match[4]";
			$datas = $cache->get($sql);
			if (!$datas) {
				$datas = $db->customQuery($sql);
				$cache->save($sql, $datas);
			}
			// เครื่องหมาย new
			$valid_date = $mmktime - $match[5];
			// template
			$skin = gcms::loadtemplate($index['module'], 'board', 'widgetitem');
			$patt = array('/{BG}/', '/{URL}/', '/{TOPIC}/', '/{LASTUPDATE}/', '/{UID}/', '/{SENDER}/', '/{STATUS}/', '/{THUMB}/', '/{ICON}/');
			$widget = array();
			$bg = 'bg2';
			foreach ($datas AS $item) {
				$bg = $bg == 'bg1' ? 'bg2' : 'bg1';
				$replace = array();
				$replace[] = "$bg background".rand(0, 5);
				$replace[] = gcms::getURL($index['module'], '', 0, 0, "wbid=$item[id]");
				$replace[] = $item['topic'];
				$replace[] = gcms::mktime2date($item['comment_date'] > 0 ? $item['comment_date'] : $item['last_update']);
				$replace[] = $item['member_id'];
				$replace[] = $item['displayname'];
				$replace[] = $item['status'];
				if ($item['picture'] != '' && is_file(DATA_PATH."board/thumb-$item[picture]")) {
					$replace[] = DATA_URL."board/thumb-$item[picture]";
				} else {
					$replace[] = WEB_URL."/$index[default_icon]";
				}
				if ($item['create_date'] > $valid_date && $item['comment_date'] == 0) {
					$replace[] = 'new';
				} elseif ($item['last_update'] > $valid_date || $item['comment_date'] > $valid_date) {
					$replace[] = 'update';
				} else {
					$replace[] = '';
				}
				$widget[] = preg_replace($patt, $replace, $skin);
			}
			if (sizeof($widget) > 0) {
				$patt = array('/{COLS}/', '/{(LNG_[A-Z0-9_]+)}/e');
				$replace = array();
				$replace[] = $match[7];
				$replace[] = 'gcms::getLng';
				echo gcms::pregReplace($patt, $replace, '<div class="row listview">'.implode('', $widget).'</div>');
			}
		}
	}
