<?php
	// widgets/personnel/index.php
	if (defined('MAIN_INIT') && preg_match('/([0-9]+)(_([a-z]+))?/', $module, $match)) {
		$sql = "SELECT `id`,`module` FROM `".DB_MODULES."` WHERE `owner`='personnel' LIMIT 1";
		$saved = $cache->get($sql);
		if (!$saved) {
			$saved = $db->customQuery($sql);
			$cache->save($sql, $saved);
		}
		if (sizeof($saved) == 1) {
			$module = $saved[0];
			// personnel
			$widget = array();
			$widget[] = '<div id=widget_personnel class=widget_personnel>';
			$sql = "SELECT * FROM `".DB_PERSONNEL."` WHERE `category_id`='$match[1]' AND `module_id`='$module[id]' ORDER BY `order`,`id`";
			$saved = $cache->get($sql);
			if (!$saved) {
				$saved = $db->customQuery($sql);
				$cache->save($sql, $saved);
			}
			if (sizeof($saved) > 0) {
				foreach ($saved AS $i => $item) {
					$url = gcms::getUrl($module['module'], '', 0, 0, "id=$item[id]");
					$picture = ($item['picture'] != '' && is_file(DATA_PATH."personnel/$item[picture]")) ? DATA_URL."personnel/$item[picture]" : WEB_URL.'/modules/personnel/img/noicon.jpg';
					$widget[] = '<div class='.($i == 0 ? 'currItem' : 'item').'>';
					$widget[] = '<a class=thumbnail href="'.$url.'"><img src='.$picture.' alt=personnel class=nozoom></a>';
					$widget[] = '<p class=detail>';
					$widget[] = '<a class=name href="'.$url.'">'.$item['name'].'</a>';
					$widget[] = '<a class=position href="'.gcms::getUrl($module['module'], '', 0, 0, "cat=$item[category_id]").'">'.$item['position'].'</a>';
					$widget[] = '</p>';
					$widget[] = '</div>';
				}
			}
			$widget[] = '</div>';
			// group
			if ($match[3] == 'menu') {
				$widget[] = '<nav class=sidemenu><ul>';
				$sql = "SELECT `category_id`,`topic` FROM `".DB_CATEGORY."` WHERE `module_id`='$module[id]' ORDER BY `category_id`";
				$saved = $cache->get($sql);
				if (!$saved) {
					$saved = $db->customQuery($sql);
					$cache->save($sql, $saved);
				}
				foreach ($saved AS $item) {
					$url = gcms::getURL($module['module'], '', 0, 0, "cat=$item[category_id]");
					$widget[] = '<li><a href="'.$url.'"><span>'.gcms::ser2Str($item, 'topic').'</span></a></li>';
				}
				$widget[] = '</ul></nav>';
			}
			$widget[] = '<script>';
			$widget[] = 'inintPersonnelWidget("widget_personnel");';
			$widget[] = '</script>';
			$widget = implode('', $widget);
		} else {
			$widget = '';
		}
	} else {
		$widget = '';
	}
