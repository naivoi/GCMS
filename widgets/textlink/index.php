<?php
	// widgets/textlink/index.php
	$widget = '';
	if (defined('MAIN_INIT') && preg_match('/[a-z0-9]{1,11}/', $module)) {
		// query
		$sql = "SELECT `id`,`text`,`type`,`url`,`target`,`logo`,`description`,`template` FROM `".DB_TEXTLINK."`";
		$sql .= " WHERE `name`='$module' AND `published`='1'";
		$sql .= " AND `publish_start` < $mmktime AND (`publish_end` > $mmktime OR `publish_end` =0)";
		$sql .= " ORDER BY `last_preview`,`link_order`";
		$textlinks = $db->customQuery($sql);
		if (sizeof($textlinks) > 0) {
			// ประเภทของลิงค์จากรายการแรกที่พบ
			$type = $textlinks[0]['type'];
			if (in_array($type, array('custom', 'banner'))) {
				// แสดงแค่รายการเดียว
				$textlinks = array($textlinks[0]);
				// อัปเดทรายการที่แสดงผลแล้ว
				$db->edit(DB_TEXTLINK, $textlinks[0]['id'], array('last_preview' => $mmktime));
			}
			if ($type == 'custom') {
				// adsense, custom
				$widget = $textlinks[0]['template'];
			} elseif ($type == 'slideshow') {
				$id = 'textlinks-slideshow'.$module;
				$widget = array();
				$widget[] = '<div id='.$id.'>';
				foreach ($textlinks AS $item) {
					$row = '<figure>';
					$row .= '<img class=nozoom src="'.DATA_URL.'image/'.$item['logo'].'" alt="'.$item['text'].'">';
					$row .= '<figcaption><a'.(empty($item['url']) ? '' : ' href="'.$item['url'].'"').($item['target'] == '_blank' ? ' target=_blank' : '').' title="'.$item['text'].'">';
					$row .= $item['text'] == '' ? '' : '<span>'.$item['text'].'</span>';
					$row .= '</a></figcaption>';
					$row .= '</figure>';
					$widget[] = $row;
				}
				$widget[] = '</div>';
				$widget[] = '<script>';
				$widget[] = 'new gBanner("'.$id.'").playSlideShow();';
				$widget[] = '</script>';
				$widget = implode("\n", $widget);
			} else {
				// template
				include (ROOT_PATH.'widgets/textlink/styles.php');
				$patt = array('/{TITLE}/', '/{DESCRIPTION}/', '/{LOGO}/', '/{URL}/', '/{TARGET}/');
				$widget = array();
				foreach ($textlinks AS $i => $item) {
					$replace = array();
					$replace[] = $item['text'];
					$replace[] = $item['description'];
					$replace[] = DATA_URL.'image/'.$item['logo'];
					$replace[] = $item['url'] == '' ? '' : ' href="'.$item['url'].'"';
					$replace[] = $item['target'] == '_blank' ? ' target=_blank' : '';
					$widget[] = preg_replace($patt, $replace, $textlink_typies[$type]);
				}
				if ($type == 'menu') {
					$widget = implode('', $widget);
				} else {
					$widget = '<div class="widget_textlink '.$module.'">'.implode('', $widget).'</div>';
				}
			}
		}
	}
