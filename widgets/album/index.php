<?php
	// widgets/album/index.php
	if (defined('MAIN_INIT')) {
		// ค่าที่ส่งมา
		if (preg_match('/^([0-9]+)_([0-9]+)$/', $module, $match)) {
			$rows = $match[2];
			$cols = $match[1];
		}
		$cols = isset($cols) ? max(1, (int)$cols) : 3;
		$rows = isset($rows) ? max(1, (int)$rows) : 2;
		// query
		$sql = "SELECT C.`id`,C.`topic`,G.`image`,M.`module`";
		$sql .= " FROM `".DB_GALLERY_ALBUM."` AS C";
		$sql .= " INNER JOIN `".DB_GALLERY."` AS G ON G.`album_id`=C.`id` AND G.`module_id`=C.`module_id` AND G.`count`='0'";
		$sql .= " INNER JOIN `".DB_MODULES."` AS M ON M.`owner`='gallery' AND M.`id`=C.`module_id`";
		$sql .= " ORDER BY C.`id` DESC LIMIT ".($rows * $cols);
		$datas = $cache->get($sql);
		if (!$datas) {
			$datas = $db->customQuery($sql);
			$cache->save($sql, $datas);
		}
		foreach ($datas AS $item) {
			$img = is_file(DATA_PATH."gallery/$item[id]/thumb_$item[image]") ? DATA_URL."gallery/$item[id]/thumb_$item[image]" : WEB_URL.'/'.SKIN.'gallery/img/nopicture.png';
			$url = gcms::getURL($item['module'], '', 0, 0, "id=$item[id]");
			$widget[] = '<div class=col'.$cols.'><div class=figure>';
			$widget[] = '<a href="'.$url.'"><img src="'.$img.'" class=nozoom alt="'.$item['topic'].'"></a>';
			$widget[] = '<a class=figcaption href="'.$url.'"><span>'.$item['topic'].'</span></a>';
			$widget[] = '</div></div>';
		}
	}
	if (sizeof($widget) > 0) {
		$widget = '<div class="widget-album ggrid margin-box">'.implode('', $widget).'</div>';
	} else {
		$widget = '';
	}
