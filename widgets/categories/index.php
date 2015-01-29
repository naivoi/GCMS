<?php
	// widgets/categories/index.php
	if (defined('MAIN_INIT') && preg_match('/^[a-z]{4,}$/', $module) && is_array($install_modules[$module])) {
		$index = $install_modules[$module];
		$sql = "SELECT `category_id`,`topic` FROM `".DB_CATEGORY."` WHERE `module_id`='$index[module_id]' ORDER BY `category_id` DESC";
		$datas = $cache->get($sql);
		if (!$datas) {
			$datas = $db->customQuery($sql);
			$cache->save($sql, $datas);
		}
		foreach ($datas AS $item) {
			$widget[] = '<li><a href="'.gcms::getURL($index['module'], '', $item['category_id']).'">'.gcms::ser2Str($item, 'topic').'</a></li>';
		}
	}
	if (sizeof($widget) > 0) {
		$widget = '<ul>'.implode("\n", $widget).'</ul>';
	} else {
		$widget = '';
	}
