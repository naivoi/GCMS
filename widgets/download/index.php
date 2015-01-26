<?php
	// widgets/download/index.php
	if (defined('MAIN_INIT')) {
		$module = $module == '' ? 'download' : $module;
		$widget = array();
		$widget[] = '<div id=widget_'.$module.' class="document-list download"><div class="row listview">';
		$sql = "SELECT * FROM `".DB_DOWNLOAD."` WHERE `module_id`=(SELECT `id` FROM `".DB_MODULES."` WHERE `owner`='download' LIMIT 1)";
		$sql .= " ORDER BY `last_update` DESC LIMIT $config[download_news_count]";
		$list = $cache->get($sql);
		if (!$list) {
			$list = $db->customQuery($sql);
			$cache->save($sql, $list);
		}
		// template
		$skin = gcms::loadtemplate($module, 'download', 'widgetitem');
		$patt = array('/{BG}/', '/{NAME}/', '/{EXT}/', '/{DETAIL(-([0-9]+))?}/e', '/{DATE}/', '/{ICON}/', '/{ID}/', '/{DOWNLOADS}/');
		$bg = 'bg2';
		foreach ($list AS $item) {
			$bg = $bg == 'bg1' ? 'bg2' : 'bg1';
			$replace = array();
			$replace[] = "$bg background".rand(0, 5);
			$replace[] = $item['name'];
			$replace[] = $item['ext'];
			$replace[] = create_function('$matches', 'return gcms::cutstring("'.$item['detail'].'",isset($matches[2]) ? (int)$matches[2] : 0);');
			$replace[] = gcms::mktime2date($item['last_update'], 'd M Y');
			$replace[] = WEB_URL.'/skin/ext/'.(is_file(ROOT_PATH."skin/ext/$item[ext].png") ? $item['ext'] : 'file').'.png';
			$replace[] = $item['id'];
			$replace[] = $item['downloads'];
			$widget[] = gcms::pregReplace($patt, $replace, $skin);
		}
		$widget[] = '</div></div>';
		$widget[] = '<script>';
		$widget[] = '$G(window).Ready(function(){';
		$widget[] = 'inintDownloadList("widget_'.$module.'");';
		$widget[] = '});';
		$widget[] = '</script>';
		$widget = implode("\n", $widget);
	}
