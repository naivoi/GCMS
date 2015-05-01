<?php
	// widgets/download/index.php
	if (defined('MAIN_INIT')) {
		$id = gcms::rndname(10);
		$widget = array();
		$widget[] = '<div id=widget_'.$id.' class="document-list download"><div class="row listview">';
		$sql = "SELECT * FROM `".DB_DOWNLOAD."` WHERE `module_id`=(SELECT `id` FROM `".DB_MODULES."` WHERE `owner`='download' LIMIT 1)";
		if (!empty($cat)) {
			$sql .= ' AND `category_id`='.(int)$cat;
		}
		$sql .= " ORDER BY `last_update` DESC LIMIT $config[download_news_count]";
		$list = $cache->get($sql);
		if (!$list) {
			$list = $db->customQuery($sql);
			$cache->save($sql, $list);
		}
		// template
		$skin = gcms::loadtemplate($module, 'download', 'widgetitem');
		$patt = array('/{BG}/', '/{NAME}/', '/{EXT}/', '/{DETAIL}/', '/{DATE}/', '/{ICON}/', '/{ID}/', '/{DOWNLOADS}/');
		$bg = 'bg2';
		foreach ($list AS $item) {
			$bg = $bg == 'bg1' ? 'bg2' : 'bg1';
			$replace = array();
			$replace[] = "$bg background".rand(0, 5);
			$replace[] = $item['name'];
			$replace[] = $item['ext'];
			$replace[] = $item['detail'];
			$replace[] = gcms::mktime2date($item['last_update'], 'd M Y');
			$replace[] = WEB_URL.'/skin/ext/'.(is_file(ROOT_PATH."skin/ext/$item[ext].png") ? $item['ext'] : 'file').'.png';
			$replace[] = $item['id'];
			$replace[] = $item['downloads'];
			$widget[] = preg_replace($patt, $replace, $skin);
		}
		$widget[] = '</div></div>';
		$widget[] = '<script>';
		$widget[] = '$G(window).Ready(function(){';
		$widget[] = 'inintDownloadList("widget_'.$id.'");';
		$widget[] = '});';
		$widget[] = '</script>';
		$widget = implode("\n", $widget);
	}
