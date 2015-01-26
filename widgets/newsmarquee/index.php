<?php
	// widgets/newsmarquee/index.php
	if (defined('MAIN_INIT')) {
		$speed = 50;
		$count = 10;
		$widget = array();
		$widget[] = '<div id=newsmarquee_containner><div id=newsmarquee_scroller><ul>';
		// query
		$sql = "SELECT Q.`id`,D.`topic`,Q.`alias`,M.`module`";
		$sql .= " FROM `".DB_INDEX."` AS Q";
		$sql .= " INNER JOIN `".DB_MODULES."` AS M ON M.`id`=Q.`module_id` AND M.`owner`='document'";
		$sql .= " INNER JOIN `".DB_INDEX_DETAIL."` AS D ON D.`id`=Q.`id` AND D.`module_id`=Q.`module_id` AND D.`language` IN ('".LANGUAGE."','')";
		$sql .= " WHERE Q.`published`='1' AND Q.`index`='0' ORDER BY Q.`last_update` DESC LIMIT $count";
		$datas = $cache->get($sql);
		if (!$datas) {
			$datas = $db->customQuery($sql);
			$cache->save($sql, $datas);
		}
		foreach ($datas AS $item) {
			if ($config['module_url'] == '1') {
				$url = gcms::getURL($item['module'], $item['alias']);
			} else {
				$url = gcms::getURL($item['module'], '', 0, $item['id']);
			}
			$widget[] = '<li class=icon-news><a href="'.$url.'">'.$item['topic'].'...</a></li>';
		}

		$widget[] = '</ul></div></div>';
		$widget[] = '<script>';
		$widget[] = 'new GScroll("newsmarquee_containner","newsmarquee_scroller").play({"scrollto":"left","speed":"'.$speed.'"});';
		$widget[] = '</script>';
		$widget = implode("\n", $widget);
	}
