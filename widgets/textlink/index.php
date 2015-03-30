<?php
	// widgets/textlink/index.php
	$widget = '';
	if (defined('MAIN_INIT') && preg_match('/[a-z0-9]{1,11}/', $module)) {
		global $mmonth, $mtoday, $myear;
		// template
		include (ROOT_PATH.'widgets/textlink/styles.php');
		$patt = array('/{TITLE}/', '/{DESCRIPTION}/', '/{LOGO}/', '/{URL}/', '/{TARGET}/');
		// query
		$sql = "SELECT `id`,`name`,`text`,`type`,`url`,`target`,`logo`,`description`,`template`,`last_preview` FROM `".DB_TEXTLINK."`";
		$sql .= " WHERE `published`='1'AND `publish_start`<".mktime(23, 59, 59, $mmonth, $mtoday, $myear)." AND (`publish_end` =0 OR `publish_end`>".mktime(0, 0, 0, $mmonth, $mtoday, $myear).")";
		$sql .= " ORDER BY `link_order`";
		$datas = $cache->get($sql);
		if (!$datas) {
			$datas = $db->customQuery($sql);
			$cache->save($sql, $datas);
		}
		$textlinks = array();
		$type = '';
		$banner = array('last_preview' => $mmktime);
		foreach ($datas AS $item) {
			if ($item['name'] == $module) {
				$type = $type == '' ? $item['type'] : $type;
				if ($item['type'] == 'banner') {
					// แสดงแบนเนอร์เพียงอันเดียว
					if ($item['last_preview'] < $banner['last_preview']) {
						$banner = $item;
					}
				} else {
					if ($item['type'] == 'custom') {
						$textlinks[] = $item['template'];
					} elseif ($item['type'] == 'slideshow') {
						$row = '<figure>';
						$row .= '<img class=nozoom src="'.DATA_URL.'image/'.$item['logo'].'" alt="'.$item['text'].'">';
						$row .= '<figcaption><a'.(empty($item['url']) ? '' : ' href="'.$item['url'].'"').($item['target'] == '_blank' ? ' target=_blank' : '').' title="'.$item['text'].'">';
						$row .= $item['text'] == '' ? '' : '<span>'.$item['text'].'</span>';
						$row .= '</a></figcaption>';
						$row .= '</figure>';
						$textlinks[] = $row;
					} else {
						$replace = array();
						$replace[] = $item['text'];
						$replace[] = $item['description'];
						$replace[] = DATA_URL.'image/'.$item['logo'];
						$replace[] = $item['url'] == '' ? '' : ' href="'.$item['url'].'"';
						$replace[] = $item['target'] == '_blank' ? ' target=_blank' : '';
						$textlinks[] = preg_replace($patt, $replace, $textlink_typies[$item['type']]);
					}
				}
			}
		}
		if (in_array($type, array('custom', 'menu'))) {
			$widget = implode("\n", $textlinks);
		} elseif ($type == 'slideshow') {
			$id = 'textlinks-slideshow'.$module;
			$widget = array();
			$widget[] = '<div id='.$id.'>';
			$widget[] = implode("\n", $textlinks);
			$widget[] = '</div>';
			$widget[] = '<script>';
			$widget[] = 'new gBanner("'.$id.'").playSlideShow();';
			$widget[] = '</script>';
			$widget = implode("\n", $widget);
		} elseif ($type == 'banner') {
			// แสดงแบนเนอร์เพียงอันเดียว
			$replace = array();
			$replace[] = $banner['text'];
			$replace[] = $banner['description'];
			$replace[] = DATA_URL.'image/'.$banner['logo'];
			$replace[] = $banner['url'] == '' ? '' : ' href="'.$banner['url'].'"';
			$replace[] = $banner['target'] == '_blank' ? ' target=_blank' : '';
			$textlinks[] = preg_replace($patt, $replace, $textlink_typies['banner']);
			$widget = '<div class="widget_textlink '.$module.'">'.implode('', $textlinks).'</div>';
			// อัปเดทรายการว่าแสดงผลแล้ว
			$db->edit(DB_TEXTLINK, $banner['id'], array('last_preview' => $mmktime));
		} else {
			$widget = '<div class="widget_textlink '.$module.'">'.implode('', $textlinks).'</div>';
		}
	}
