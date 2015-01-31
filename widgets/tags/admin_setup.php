<?php
	// widgets/tags/admin_setup.php
	if (MAIN_INIT == 'admin' && $isAdmin && defined('DB_TAGS')) {
		// รายการที่แก้ไข
		$id = gcms::getVars($_GET, 'id', 0);
		$tags = '';
		$tag = array('id' => 0, 'tag' => '');
		// query
		$sql = "SELECT * FROM ".DB_TAGS." ORDER BY `count` ASC, `id` DESC";
		foreach ($db->customQuery($sql) AS $item) {
			if ($id == $item['id']) {
				$tag = $item;
			}
			$tags .= '<tr id=L_'.$item['id'].'>';
			$tags .= '<th headers=c1 id=r'.$item['id'].' scope=row class=topic><a id=edit_'.$item['id'].' href="'.WEB_URL.'/admin/index.php?module=tags-setup&amp;id='.$item['id'].'">'.htmlspecialchars($item['tag']).'</a></th>';
			$tags .= '<td headers="r'.$item['id'].' c2" class=check-column><a id=check_'.$item['id'].' class=icon-uncheck></a></td>';
			$tags .= '<td headers="r'.$item['id'].' c3" class=visited>'.$item['count'].'</td>';
			$tags .= '</tr>';
		}
		// title
		$title = $lng['LNG_TAGS_TITLE'];
		$a = array();
		$a[] = '<span class=icon-widgets>{LNG_WIDGETS}</span>';
		$a[] = '{LNG_TAGS}';
		// แสดงผล
		$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
		$content[] = '<section>';
		$content[] = '<header><h1 class=icon-tags>'.$title.'</h1></header>';
		$content[] = '<div class=setup_frm>';
		$content[] = '<form id=setup_frm class=paper method=post action=index.php>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_TAGS}</span></legend>';
		// text
		$content[] = '<div class=item>';
		$content[] = '<label for=tags_tag>{LNG_TAGS}</label>';
		$content[] = '<span class="g-input icon-tags"><input type=text id=tags_tag name=tags_tag value="'.$tag['tag'].'" title="{LNG_TAGS_TEXT_COMMENT}" autofocus></span>';
		$content[] = '<div class=comment id=result_tags_tag>{LNG_TAGS_TEXT_COMMENT}</div>';
		$content[] = '</div>';
		$content[] = '</fieldset>';
		$content[] = '<fieldset class=submit>';
		$content[] = '<input type=submit class="button large save" value="{LNG_SAVE}">';
		$content[] = '&nbsp;<input type=button class="button large cancle" value="{LNG_CANCLE}" id=tags_reset>';
		$content[] = '<input type=hidden name=tags_id id=tags_id value='.(int)$tag['id'].'>';
		$content[] = '</fieldset>';
		$content[] = '</form>';
		// ตารางรายการ tags
		$content[] = '<table id=member class="tbl_list fullwidth">';
		$patt2 = array('/{SEARCH}/', '/{COUNT}/', '/{PAGE}/', '/{TOTALPAGE}/', '/{START}/', '/{END}/');
		$replace2 = array('', sizeof($tags), 1, 1, 1, sizeof($tags));
		$content[] = '<caption>'.preg_replace($patt2, $replace2, $lng['ALL_ITEMS']).'</caption>';
		$content[] = '<thead>';
		$content[] = '<tr>';
		$content[] = '<th scope=col id=c1>{LNG_TAGS}</th>';
		$content[] = '<th scope=col id=c2 class=check-column><a class="checkall icon-uncheck"></a></th>';
		$content[] = '<th scope=col id=c3 class=center>{LNG_VIEWS}</th>';
		$content[] = '</tr>';
		$content[] = '</thead>';
		$content[] = '<tbody>';
		$content[] = $tags;
		$content[] = '</tbody>';
		$content[] = '<tfoot>';
		$content[] = '<tr>';
		$content[] = '<td headers=c1></td>';
		$content[] = '<td headers=c2 class=check-column><a class="checkall icon-uncheck"></a></td>';
		$content[] = '<td headers=c3>&nbsp;</td>';
		$content[] = '</tr>';
		$content[] = '</tfoot>';
		$content[] = '</table>';
		$content[] = '<div class=table_nav>';
		// sel action
		$content[] = '<select id=sel_action><option value=delete>{LNG_DELETE}</option></select>';
		$content[] = '<label accesskey=e for=sel_action class="button go" id=btn_action><span>{LNG_SELECT_ACTION}</span></label>';
		$content[] = '</div>';
		$content[] = '</div>';
		$content[] = '</section>';
		$content[] = '<script>';
		$content[] = '$G(window).Ready(function(){';
		$content[] = 'new GForm("setup_frm", "'.WEB_URL.'/widgets/tags/admin_setup_save.php").onsubmit(doTagsSubmit);';
		$content[] = "inintCheck('member');";
		$content[] = "inintTR('member', /L_[0-9]+/);";
		$content[] = 'callAction("btn_action", function(){return $E("sel_action").value}, "member", "'.WEB_URL.'/widgets/tags/admin_action.php");';
		$content[] = 'inintList("member", "a", /edit_[0-9]+/, "'.WEB_URL.'/widgets/tags/admin_action.php", doFormSubmit);';
		$content[] = 'callClick("tags_reset", tagsReset);';
		$content[] = '});';
		$content[] = '</script>';
		// หน้านี้
		$url_query['module'] = 'tags-setup';
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
