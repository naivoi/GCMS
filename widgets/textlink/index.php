<?php
	// widgets/textlink/index.php
	if (defined('MAIN_INIT')) {
		$widget = array();
		// แสดงผล
		if (preg_match('/([0-9]{1,2})_([_a-z1-9]+)/', $module, $match)) {
			// {WIDGET_TEXTLINK_col_type1_type2_type3}
			$sql = "SELECT `text`,`url`,`target`,`logo` FROM `".DB_TEXTLINK."`";
			$sql .= " WHERE `type` IN ('".str_replace('_', "','", $match[2])."')";
			$sql .= " AND `publish_start` < $mmktime AND (`publish_end` > $mmktime OR `publish_end` =0)";
			$sql .= " AND `logo`!='' AND `published`='1' ORDER BY `link_order` ASC";
			$widget[] = '<div>';
			foreach ($db->customQuery($sql) AS $i => $item) {
				$a = '<a'.(empty($item['url']) ? '' : ' href="'.$item['url'].'"').($item['target'] == '_blank' ? ' target=_blank' : '').' title="'.$item['text'].'">';
				if ($i > 0 && $i % $match[1] == 0) {
					$widget[] = '</div><div>';
				}
				$row = '<div>';
				$row .= $a.'<img alt="'.$item['text'].'" src="'.DATA_URL.'image/'.$item['logo'].'"></a>';
				$row .= $a.$item['text'].'</a>';
				$row .= '</div>';
				$widget[] = $row;
			}
			$widget[] = '</div>';
			$widget = implode("\n", $widget);
		} elseif (preg_match('/^slideshow([1-9]){0,}/', $module, $match)) {
			// {WIDGET_TEXTLINK_slideshow}
			$sql = "SELECT `text`,`url`,`target`,`logo` FROM `".DB_TEXTLINK."`";
			$sql .= " WHERE `type`='$match[0]' AND `published`='1' AND `logo`!=''";
			$sql .= " AND `publish_start` < $mmktime AND (`publish_end` > $mmktime OR `publish_end` =0)";
			$sql .= " ORDER BY `link_order` ASC";
			$datas = $db->customQuery($sql);
			$id = 'textlinks-slideshow'.($module != '' ? "-$module" : '');
			$widget[] = '<div id='.$id.'>';
			foreach ($datas AS $item) {
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
		} elseif (preg_match('/^(custom|banner)([1-9]{0,})/', $module, $match)) {
			// {WIDGET_TEXTLINK_banner}
			// แสดงแบนเนอร์ ครั้งละ 1 รูป วนจนครบ
			$sql = "SELECT `id`,`text`,`url`,`target`,`logo`,`template` FROM `".DB_TEXTLINK."`";
			$sql .= " WHERE `type`='$match[0]' AND `published`='1'";
			$sql .= " AND `publish_start`<$mmktime AND (`publish_end`>$mmktime OR `publish_end`=0)";
			$sql .= " ORDER BY `last_preview` LIMIT 1";
			$item = $db->customQuery($sql);
			if (sizeof($item) > 0) {
				$item = $item[0];
				if ($match[1] == 'custom') {
					$widget = $item['template'];
				} else {
					$widget = '<a'.(empty($item['url']) ? '' : ' href="'.$item['url'].'"').($item['target'] == '_blank' ? ' target=_blank' : '').' title="'.$item['text'].'"><img alt="'.$item['text'].'" src="'.DATA_URL.'image/'.$item['logo'].'"></a>';
				}
				$db->edit(DB_TEXTLINK, $item['id'], array('last_preview' => $mmktime));
			} else {
				$widget = '';
			}
		} elseif (preg_match('/([a-z]+)([1-9]){0,}/', $module, $match)) {
			// {WIDGET_TEXTLINK_type}
			include (ROOT_PATH.'widgets/textlink/styles.php');
			// query
			$patt = array('/{TITLE}/', '/{DESCRIPTION}/', '/{LOGO}/', '/{URL}/', '/{TARGET}/');
			$sql = "SELECT `text`,`url`,`target`,`logo`,`description` FROM `".DB_TEXTLINK."`";
			$sql .= " WHERE `type`='$match[0]' AND `published`='1'";
			$sql .= " AND `publish_start` < $mmktime AND (`publish_end` > $mmktime OR `publish_end` =0)";
			$sql .= " ORDER BY `link_order`";
			foreach ($db->customQuery($sql) AS $i => $item) {
				$replace = array();
				$replace[] = $item['text'];
				$replace[] = $item['description'];
				$replace[] = DATA_URL.'image/'.$item['logo'];
				$replace[] = $item['url'] == '' ? '' : ' href="'.$item['url'].'"';
				$replace[] = $item['target'] == '_blank' ? ' target=_blank' : '';
				$widget[] = preg_replace($patt, $replace, $textlink_typies[$match[1]]);
			}
			$widget = '<div class="widget_textlink '.$module.'">'.implode('', $widget).'</div>';
		}
	}
