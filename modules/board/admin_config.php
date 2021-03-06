<?php
	// modules/board/admin_config.php
	if (MAIN_INIT == 'admin' && $isMember) {
		// ตรวจสอบโมดูลที่เรียก
		$sql = "SELECT `id`,`module`,`config` FROM `".DB_MODULES."` WHERE `id`=".(int)$_GET['id']." AND `owner`='board' LIMIT 1";
		$index = $db->customQuery($sql);
		$index = sizeof($index) == 1 ? $index[0] : false;
		if ($index) {
			// อ่าน config ของโมดูล
			gcms::r2config($index['config'], $index);
			// ตรวจสอบสถานะที่สามารถเข้าหน้านี้ได้
			if (!gcms::canConfig($index, 'can_config')) {
				$index = false;
			}
		}
		if (!$index) {
			$title = $lng['LNG_DATA_NOT_FOUND'];
			$content[] = '<aside class=error>'.$title.'</aside>';
		} else {
			// title
			$m = ucwords($index['module']);
			$title = "$lng[LNG_CONFIG] $m";
			$a = array();
			$a[] = '<span class=icon-board>{LNG_MODULES}</span>';
			$a[] = $m;
			$a[] = '{LNG_CONFIG}';
			// แสดงผล
			$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
			$content[] = '<section>';
			$content[] = '<header><h1 class=icon-config>'.$title.'</h1></header>';
			// form
			$content[] = '<form id=setup_frm class=setup_frm method=post action=index.php>';
			// thumbnail
			$content[] = '<fieldset>';
			$content[] = '<legend><span>{LNG_THUMBNAIL}</span></legend>';
			// icon_width,icon_height
			$content[] = '<div class=item>';
			$content[] = '<span class=label>{LNG_ICON_WIDTH} ({LNG_PX})</span>';
			$content[] = '<div class=input-groups-table>';
			$content[] = '<label class=width for=config_icon_width>{LNG_WIDTH}&nbsp;</label>';
			$content[] = '<span class="width g-input icon-width"><input type=number min=50 name=config_icon_width id=config_icon_width value="'.$index['icon_width'].'"></span>';
			$content[] = '<label class=width for=config_icon_height>&nbsp;{LNG_HEIGHT}&nbsp;</label>';
			$content[] = '<span class="width g-input icon-height"><input type=number min=50 name=config_icon_height id=config_icon_height value="'.$index['icon_height'].'"></span>';
			$content[] = '</div>';
			$content[] = '<div class=comment>{LNG_THUMB_WIDTH_COMMENT}</div>';
			$content[] = '</div>';
			// icon_category_type
			$content[] = '<div class=item>';
			$content[] = '<label for=config_icon_category_type>{LNG_IMAGE_FILE_TYPIES}</label>';
			$content[] = '<div>';
			$icon_category_typies = explode(',', $index['icon_category_type']);
			foreach (array('jpg', 'gif', 'png') AS $i => $item) {
				$chk = in_array($item, $icon_category_typies) ? ' checked' : '';
				$d = $item == 'jpg' ? ' id=config_icon_category_type' : '';
				$content[] = '<label><input type=checkbox'.$chk.$d.' name=config_icon_category_type[] value='.$item.' title="{LNG_IMAGE_UPLOAD_TYPE_COMMENT}"> '.$item.'</label>';
			}
			$content[] = '</div>';
			$content[] = '<div class=comment id=result_config_icon_category_type>{LNG_IMAGE_UPLOAD_TYPE_COMMENT}</div>';
			$content[] = '</div>';
			// default_icon
			$content[] = '<div class=item>';
			$content[] = '<div class=usericon><span><img id=img_default_icon src="'.WEB_URL.'/'.$index['default_icon'].'" alt=default_icon></span></div>';
			$content[] = '<label for=config_default_icon>{LNG_BROWSE_FILE}</label>';
			$content[] = '<span class="g-input icon-upload"><input type=file class=g-file id=config_default_icon name=config_default_icon title="{LNG_DEFAULT_ICON_COMMENT}" accept="'.gcms::getEccept(array('jpg', 'png', 'gif')).'" data-preview=img_default_icon></span>';
			$content[] = '<div class=comment id=result_config_default_icon>{LNG_DEFAULT_ICON_COMMENT}</div>';
			$content[] = '</div>';
			$content[] = '</fieldset>';
			// การแสดงผล
			$content[] = '<fieldset>';
			$content[] = '<legend><span>{LNG_DISPLAY}</span></legend>';
			// list_per_page
			$content[] = '<div class=item>';
			$content[] = '<label for=config_list_per_page>{LNG_QUANTITY}</label>';
			$content[] = '<span class="g-input icon-published1"><input type=number name=config_list_per_page id=config_list_per_page value="'.$index['list_per_page'].'" title="{LNG_LIST_PER_PAGE_COMMENT}"></span>';
			$content[] = '<div class=comment>{LNG_LIST_PER_PAGE_COMMENT}</div>';
			$content[] = '</div>';
			// new_date
			$content[] = '<div class=item>';
			$new_date = $index['new_date'] / 86400;
			$content[] = '<label for=config_new_date>{LNG_NEW_DATE}</label>';
			$content[] = '<span class="g-input icon-clock"><select name=config_new_date id=config_new_date title="{LNG_NEW_DATE_COMMENT}">';
			for ($i = 0; $i < 31; $i++) {
				$sel = $i == $new_date ? ' selected' : '';
				$content[] = '<option value='.$i.$sel.'>'.$i.' {LNG_DAYS}</option>';
			}
			$content[] = '</select></span>';
			$content[] = '<div class=comment id=result_config_new_date>{LNG_NEW_DATE_COMMENT}</div>';
			$content[] = '</div>';
			// viewing
			$content[] = '<div class=item>';
			$content[] = '<label for=config_viewing>{LNG_VIEWING}</label>';
			$content[] = '<span class="g-input icon-config"><select name=config_viewing id=config_viewing title="{LNG_MEMBER_ONLY_COMMENT}">';
			foreach ($lng['LNG_MEMBER_ONLY_LIST'] AS $i => $item) {
				$sel = $index['viewing'] == $i ? ' selected' : '';
				$content[] = '<option value='.$i.$sel.'>'.$item.'</option>';
			}
			$content[] = '</select></span>';
			$content[] = '<div class=comment id=result_config_viewing>{LNG_VIEWING_COMMENT}</div>';
			$content[] = '</div>';
			// category_display
			$content[] = '<div class=item>';
			$content[] = '<label for=config_category_display>{LNG_CATEGORY_DISPLAY}</label>';
			$content[] = '<span class="g-input icon-category"><select name=config_category_display id=config_category_display title="{LNG_CATEGORY_DISPLAY_COMMENT}">';
			foreach ($lng['OPEN_CLOSE'] AS $i => $item) {
				$sel = $index['category_display'] == $i ? ' selected' : '';
				$content[] = '<option value='.$i.$sel.'>'.$item.'</option>';
			}
			$content[] = '</select></span>';
			$content[] = '<div class=comment id=result_config_category_display>{LNG_CATEGORY_DISPLAY_COMMENT}</div>';
			$content[] = '</div>';
			$content[] = '</fieldset>';
			$content[] = '<fieldset>';
			$content[] = '<legend><span>{LNG_NEWS_COUNT}</span></legend>';
			// news_count
			$content[] = '<div class=item>';
			$content[] = '<label for=config_news_count>{LNG_QUANTITY}</label>';
			$content[] = '<span class="g-input icon-published1"><input type=number name=config_news_count id=config_news_count value="'.$index['news_count'].'" title="{LNG_NEWS_COUNT_COMMENT}"></span>';
			$content[] = '<div class=comment id=result_config_news_count>{LNG_NEWS_COUNT_COMMENT}</div>';
			$content[] = '</div>';
			$content[] = '</fieldset>';
			$content[] = '<fieldset>';
			$content[] = '<legend><span>{LNG_UPLOADING}</span></legend>';
			// img_upload_type
			$content[] = '<div class=item>';
			$content[] = '<label for=config_img_upload_type_jpg>{LNG_UPLOAD_FILE_TYPIES}</label>';
			$img_upload_typies = explode(',', $index['img_upload_type']);
			$content[] = '<div>';
			foreach (array('jpg', 'gif', 'png') AS $item) {
				$chk = in_array($item, $img_upload_typies) ? ' checked' : '';
				$content[] = '<label><input type=checkbox'.$chk.' id=config_img_upload_type_'.$item.' name=config_img_upload_type[] value='.$item.' title="{LNG_UPLOAD_FILE_TYPE_COMMENT}"> '.$item.'</label>';
			}
			$content[] = '</div>';
			$content[] = '<div class=comment>{LNG_UPLOAD_FILE_TYPE_COMMENT}</div>';
			$content[] = '</div>';
			// img_upload_size
			$content[] = '<div class=item>';
			$content[] = '<label for=config_img_upload_size>{LNG_UPLOAD_FILE_SIZE}</label>';
			$content[] = '<span class="g-input icon-config"><select name=config_img_upload_size id=config_img_upload_size title="{LNG_UPLOAD_FILE_SIZE_COMMENT}">';
			foreach (array(100, 200, 300, 400, 500, 600, 700, 800, 900, 1024, 2048) AS $item) {
				$sel = $item == $index['img_upload_size'] ? ' selected' : '';
				$content[] = '<option value='.$item.$sel.'>'.$item.' kb</option>';
			}
			$content[] = '</select></span>';
			$content[] = '<div class=comment id=result_config_img_upload_size>{LNG_UPLOAD_FILE_SIZE_COMMENT}</div>';
			$content[] = '</div>';
			// thumb_width
			$content[] = '<div class=item>';
			$t = str_replace('{TYPE}', 'jpg', $lng['LNG_THUMBNAIL_COMMENT']);
			$content[] = '<label for=config_thumb_width>{LNG_THUMBNAIL}</label>';
			$content[] = '<span class="g-input icon-thumbnail"><select name=config_thumb_width id=config_thumb_width title="'.$t.'">';
			foreach (array(16, 32, 50, 60, 75, 100, 150) AS $item) {
				$sel = $item == $index['thumb_width'] ? ' selected' : '';
				$content[] = '<option value='.$item.$sel.'>'.$item.' {LNG_PX}</option>';
			}
			$content[] = '</select></span>';
			$content[] = '<div class=comment id=result_config_thumb_width>'.$t.'</div>';
			$content[] = '</div>';
			// img_law
			$content[] = '<div class=item>';
			$content[] = '<label for=config_img_law>{LNG_BOARD_IMG_LAW}</label>';
			$content[] = '<span class="g-input icon-config"><select name=config_img_law id=config_img_law title="{LNG_BOARD_IMG_LAW_COMMENT}">';
			foreach ($lng['BOARD_IMG_LAWS'] AS $i => $item) {
				$sel = $i == $index['img_law'] ? ' selected' : '';
				$content[] = '<option value='.$i.$sel.'>'.$item.'</option>';
			}
			$content[] = '</select></span>';
			$content[] = '<div class=comment id=result_config_img_law>{LNG_BOARD_IMG_LAW_COMMENT}</div>';
			$content[] = '</div>';
			$content[] = '</fieldset>';
			// กำหนดความสามารถของสมาชิกแต่ละระดับ
			$content[] = '<fieldset>';
			$content[] = '<legend><span>{LNG_MEMBER_ROLE_SETTINGS}</span></legend>';
			$content[] = '<div class=item>';
			$content[] = '<table class="responsive config_table">';
			$content[] = '<thead>';
			$content[] = '<tr>';
			$content[] = '<th>&nbsp;</th>';
			$content[] = '<th scope=col>{LNG_BOARD_CAN_POST}</th>';
			$content[] = '<th scope=col>{LNG_CAN_VIEW}</th>';
			$content[] = '<th scope=col>{LNG_CAN_REPLY}</th>';
			$content[] = '<th scope=col>{LNG_MODERATOR}</th>';
			$content[] = '<th scope=col>{LNG_CAN_CONFIG}</th>';
			$content[] = '</tr>';
			$content[] = '</thead>';
			$content[] = '<tbody>';
			// สถานะสมาชิก
			$status = array();
			$status[-1] = '{LNG_GUEST}';
			foreach ($config['member_status'] AS $i => $item) {
				$status[$i] = $item;
			}
			$bg = 'bg2';
			foreach ($status AS $i => $item) {
				if ($i != 1) {
					$bg = $bg == 'bg1' ? 'bg2' : 'bg1';
					$content[] = '<tr class="'.$bg.' status'.$i.'">';
					$content[] = '<th>'.$item.'</th>';
					// can_post
					$content[] = '<td><label data-text="{LNG_BOARD_CAN_POST}"><input type=checkbox name=config_can_post[]'.(in_array($i, explode(',', $index['can_post'])) ? ' checked' : '').' value='.$i.' title="{LNG_BOARD_CAN_POST_COMMENT}"></label></td>';
					// can_view
					$content[] = '<td><label data-text="{LNG_CAN_VIEW}"><input type=checkbox name=config_can_view[]'.(in_array($i, explode(',', $index['can_view'])) ? ' checked' : '').' value='.$i.' title="{LNG_CAN_VIEW_COMMENT}"></label></td>';
					// can_reply
					$content[] = '<td><label data-text="{LNG_CAN_REPLY}"><input type=checkbox name=config_can_reply[]'.(in_array($i, explode(',', $index['can_reply'])) ? ' checked' : '').' value='.$i.' title="{LNG_CAN_REPLY_COMMENT}"></label></td>';
					if ($i > 1) {
						// moderator
						$content[] = '<td><label data-text="{LNG_MODERATOR}"><input type=checkbox name=config_moderator[]'.(in_array($i, explode(',', $index['moderator'])) ? ' checked' : '').' value='.$i.' title="{LNG_BOARD_MODERATOR_COMMENT}"></label></td>';
						// can_config
						$content[] = '<td><label data-text="{LNG_CAN_CONFIG}"><input type=checkbox name=config_can_config[]'.(in_array($i, explode(',', $index['can_config'])) ? ' checked' : '').' value='.$i.' title="{LNG_CAN_CONFIG_COMMENT}"></label></td>';
					} else {
						$content[] = '<td colspan=2></td>';
					}
					$content[] = '</tr>';
				}
			}
			$content[] = '</tbody>';
			$content[] = '</table>';
			$content[] = '</div>';
			$content[] = '</fieldset>';
			// submit
			$content[] = '<fieldset class=submit>';
			$content[] = '<input type=submit class="button large save" value="{LNG_SAVE}">';
			$content[] = '<input type=hidden name=config_id value='.$index['id'].'>';
			$content[] = '</fieldset>';
			$content[] = '</form>';
			$content[] = '</section>';
			$content[] = '<script>';
			$content[] = '$G(window).Ready(function(){';
			$content[] = 'new GForm("setup_frm", "'.WEB_URL.'/modules/board/admin_config_save.php").onsubmit(doFormSubmit);';
			$content[] = '});';
			$content[] = '</script>';
			// หน้านี้
			$url_query['module'] = 'board-config';
		}
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
