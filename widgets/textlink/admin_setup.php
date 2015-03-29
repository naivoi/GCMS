<?php
	// widgets/textlink/admin_setup.php
	if (MAIN_INIT == 'admin' && $isAdmin && defined('DB_TEXTLINK')) {
		// ค่าที่ส่งมา
		$name = $db->sql_trim_str($_GET, 'name');
		// title
		$title = $lng['LNG_TEXTLINK_TITLE'];
		$a = array();
		$a[] = '<span class=icon-widgets>{LNG_WIDGETS}</span>';
		$a[] = '<a href="index.php?module=textlink-setup">{LNG_TEXTLINK}</a>';
		if ($name != '') {
			$a[] = $name;
		}
		// แสดงผล
		$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
		$content[] = '<section>';
		$content[] = '<header><h1 class=icon-ads>'.$title.'</h1></header>';
		$content[] = '<form class=table_nav method=get action=index.php>';
		// name
		$sql = "SELECT `name`,`type` FROM `".DB_TEXTLINK."` GROUP BY `name`";
		$content[] = '<fieldset>';
		$content[] = '<label>{LNG_TEXTLINK_TYPE} <select name="name">';
		$content[] = '<option value="">{LNG_VIEW_ALL}</option>';
		foreach ($db->customQuery($sql) AS $item) {
			$sel = $item['name'] == $name ? ' selected' : '';
			$content[] = '<option value='.$item['name'].$sel.'>'.$item['name'].' ('.$item['type'].')</option>';
		}
		$content[] = '</select></label>';
		$content[] = '</fieldset>';
		// submit
		$content[] = '<fieldset>';
		$content[] = '<input type=submit class="button go" value="{LNG_GO}">';
		$content[] = '<input type=hidden name=module value=textlink-setup>';
		$content[] = '</fieldset>';
		$content[] = '</form>';
		if ($name == '') {
			$sql = "SELECT * FROM `".DB_TEXTLINK."` ORDER BY `link_order`,`name`";
		} else {
			$sql = "SELECT * FROM `".DB_TEXTLINK."` WHERE `name`='$name' ORDER BY `link_order`";
		}
		$datas = $db->customQuery($sql);
		$patt2 = array('/{SEARCH}/', '/{COUNT}/', '/{PAGE}/', '/{TOTALPAGE}/', '/{START}/', '/{END}/');
		$replace2 = array('', sizeof($datas), 1, 1, 1, 1);
		// ตารางรายการ textlink
		$content[] = '<table id=tbl_list class="tbl_list fullwidth">';
		$content[] = '<caption>'.preg_replace($patt2, $replace2, $lng['ALL_ITEMS']).'</caption>';
		$content[] = '<thead>';
		$content[] = '<tr>';
		$content[] = '<th scope=col id=c0>{LNG_NAME}</th>';
		$content[] = '<th scope=col id=c1 class=check-column><a class="checkall icon-uncheck"></a></th>';
		$content[] = '<th scope=col id=c2 class=menu>&nbsp;</th>';
		$content[] = '<th scope=col id=c3 class=tablet>{LNG_DESCRIPTION} ({LNG_TYPE})</th>';
		$content[] = '<th scope=col id=c4 class=tablet>{LNG_URL}</th>';
		$content[] = '<th scope=col id=c5 class=tablet>{LNG_TEXT}</th>';
		$content[] = '<th scope=col id=c6 class="center tablet">{LNG_SIZE_OF} {LNG_IMAGE}</th>';
		$content[] = '<th scope=col id=c7 class="center mobile">{LNG_PUBLISHED_START}</th>';
		$content[] = '<th scope=col id=c8 class="center tablet">{LNG_PUBLISHED_END}</th>';
		$content[] = '<th scope=col id=c9 class=menu>&nbsp;</th>';
		$content[] = '</tr>';
		$content[] = '</thead>';
		$content[] = '<tbody>';
		foreach ($datas AS $item) {
			$id = $item['id'];
			$tr = '<tr id=user-'.$id.' class=sort>';
			$tr .= '<th headers=c0 scope=row id=r'.$id.'><a href="index.php?module=textlink-setup&amp;name='.$item['name'].'" title="'.$item['description'].'"'.($item['published'] == 0 ? ' class=ban' : '').'>'.$item['name'].'</a></th>';
			$tr .= '<td headers="r'.$id.' c1" class=check-column><a id=check_'.$id.' class=icon-uncheck></a></td>';
			$tr .= '<td headers="r'.$id.' c2"><a id=move_'.$id.' title="{LNG_DRAG_MOVE}" class=icon-move></a></td>';
			$tr .= '<td headers="r'.$id.' c3" class=tablet>'.$item['description'].' ('.$item['type'].')</td>';
			$tr .= '<td headers="r'.$id.' c4" class=tablet><a href="'.$item['url'].'" target=_blank>'.$item['url'].'</a></td>';
			$tr .= '<td headers="r'.$id.' c5" class=tablet>'.$item['text'].'</td>';
			$tr .= '<td headers="r'.$id.' c6" class="center tablet">'.$item['width'].' * '.$item['height'].'</td>';
			$tr .= '<td headers="r'.$id.' c7" class="date mobile">'.gcms::mktime2date($item['publish_start'], 'd M Y').'</td>';
			if ($item['publish_end'] == 0) {
				$tr .= '<td headers="r'.$id.' c8" class="date tablet">{LNG_DATELESS}</td>';
			} else {
				$tr .= '<td headers="r'.$id.' c8" class="date tablet'.($mmktime > $item['publish_end'] ? ' noactivate' : '').'">'.gcms::mktime2date($item['publish_end'], 'd M Y').'</td>';
			}
			$tr .= '<td headers="r'.$id.' c9"><a href="index.php?module=textlink-write&amp;id='.$id.'" title="{LNG_EDIT}" class=icon-edit></a></td>';
			$tr .= '</tr>';
			$content[] = $tr;
		}
		$content[] = '</tbody>';
		$content[] = '<tfoot>';
		$content[] = '<tr>';
		$content[] = '<td headers=c0>&nbsp;</td>';
		$content[] = '<td headers=c1 class=check-column><a class="checkall icon-uncheck"></a></td>';
		$content[] = '<td headers=c2 colspan=8></td>';
		$content[] = '</tr>';
		$content[] = '</tfoot>';
		$content[] = '</table>';
		$content[] = '<div class=table_nav>';
		// sel action
		$content[] = '<fieldset>';
		$sel = array();
		$sel[] = '<select id=sel_action>';
		// delete
		$sel[] = '<option value=delete>{LNG_DELETE}</option>';
		// published
		foreach ($lng['LNG_PUBLISHEDS'] AS $i => $item) {
			$sel[] = '<option value=published_0_'.$i.'>'.$item.'</option>';
		}
		$sel[] = '</select>';
		$content[] = str_replace('value='.$action.'>', 'value='.$action.' selected>', implode('', $sel));
		$content[] = '<label accesskey=e for=sel_action class="button go" id=btn_action><span>{LNG_SELECT_ACTION}</span></label>';
		$content[] = '</fieldset>';
		// add
		$content[] = '<fieldset>';
		$content[] = '<a class="button add" href="{URLQUERY?module=textlink-write&src=textlink-setup}"><span class=icon-plus>{LNG_ADD_NEW} {LNG_TEXTLINK}</span></a>';
		$content[] = '</fieldset>';
		$content[] = '</div>';
		$content[] = '</section>';
		$content[] = '<script>';
		$content[] = 'callAction("btn_action", function(){return $E("sel_action").value}, "tbl_list", "'.WEB_URL.'/widgets/textlink/admin_action.php");';
		$content[] = "doInintTextlink('tbl_list');";
		$content[] = '</script>';
		// หน้านี้
		$url_query['module'] = 'textlink-setup';
		$url_query['name'] = $name;
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
