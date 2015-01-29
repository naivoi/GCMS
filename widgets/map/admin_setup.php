<?php
	// widgets/map/admin_setup.php
	if (MAIN_INIT == 'admin' && $isAdmin) {
		// ตรวจสอบค่า default
		$config['map_latigude'] = gcms::getVars($config, 'map_latigude', '14.132081110519639');
		$config['map_lantigude'] = gcms::getVars($config, 'map_lantigude', '99.69822406768799');
		$config['map_info_latigude'] = gcms::getVars($config, 'map_info_latigude', '14.132081110519639');
		$config['map_info_lantigude'] = gcms::getVars($config, 'map_info_lantigude', '99.69822406768799');
		$config['map_zoom'] = gcms::getVars($config, 'map_zoom', 5);
		$config['map_height'] = gcms::getVars($config, 'map_height', 400);
		// title
		$title = $lng['LNG_WIDGETS_MAP_SETTINGS'];
		$a = array();
		$a[] = '<span class=icon-widgets>{LNG_WIDGETS}</span>';
		$a[] = '{LNG_WIDGETS_MAP}';
		// แสดงผล
		$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
		$content[] = '<section>';
		$content[] = '<header><h1 class=icon-map>'.$title.'</h1></header>';
		$content[] = '<div class=setup_frm>';
		$content[] = '<form id=setup_frm method=post action=index.php>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_WIDGETS_MAP_SETTINGS_SECTION}</span></legend>';
		// size
		$content[] = '<fieldset class=item>';
		$content[] = '<legend>{LNG_SIZE_OF} {LNG_WIDGETS_MAP}</legend>';
		$content[] = '<div class=input-groups-table>';
		$content[] = '<label class=width for=map_height>{LNG_HEIGHT}</label>';
		$content[] = '<span class="width g-input icon-height"><input type=number name=map_height id=map_height value="'.$config['map_height'].'" title="{LNG_WIDTH} {LNG_PX}"></span>';
		$content[] = '<span class="width label">{LNG_PX}</span>';
		$content[] = '</div>';
		$content[] = '<div class=comment>{LNG_MAP_SIZE_COMMENT}</div>';
		$content[] = '</fieldset>';
		// zoom
		$content[] = '<div class=item>';
		$content[] = '<label for=map_zoom>{LNG_MAP_ZOOM}</label>';
		$content[] = '<span class="g-input icon-search"><input type=text id=map_zoom name=map_zoom value="'.$config['map_zoom'].'" readonly></span>';
		$content[] = '<div class=comment>{LNG_MAP_ZOOM_COMMENT}</div>';
		$content[] = '</div>';
		// map position
		$content[] = '<fieldset class=item>';
		$content[] = '<legend>{LNG_MAP_POSITION}</legend>';
		$content[] = '<div class=input-groups-table>';
		$content[] = '<div class=width>';
		$content[] = '<label for=map_latigude>{LNG_LATIGUDE}</label>';
		$content[] = '<span class="g-input icon-location"><input type=text name=map_latigude id=map_latigude value="'.$config['map_latigude'].'"></span>';
		$content[] = '</div>';
		$content[] = '<div class=width>';
		$content[] = '<label for=map_lantigude>{LNG_LANTIGUDE}</label>';
		$content[] = '<span class="width g-input icon-location"><input type=text name=map_lantigude id=map_lantigude value="'.$config['map_lantigude'].'"></span>';
		$content[] = '</div>';
		$content[] = '<div class="width bottom"><a id=find_me class="button go icon-gps hidden" title="{LNG_FIND_ME}"></a></div>';
		$content[] = '<div class="width bottom"><a id=map_search class="button go icon-search" title="{LNG_SEARCH}"></a></div>';
		$content[] = '</div>';
		$content[] = '<div class=comment>{LNG_MAP_POSITION_COMMENT}</div>';
		$content[] = '<div id=map_canvas style="height:'.$config['map_height'].'px">Google Map</div>';
		$content[] = '</fieldset>';
		$content[] = '</fieldset>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_WIDGETS_MAP_INFO_SECTION}</span></legend>';
		// info
		$content[] = '<div class=item>';
		$content[] = '<label for=map_info>{LNG_GOOGLE_INFO}</label>';
		$content[] = '<span class="g-input icon-location"><textarea name=map_info id=map_info rows=3 title="{LNG_GOOGLE_INFO_COMMENT}">'.(empty($config['map_info']) ? '' : gcms::detail2TXT(str_replace(array('\r', '\n'), array("\r", "\n"), $config['map_info']))).'</textarea></span>';
		$content[] = '<div class=comment id=result_map_info>{LNG_GOOGLE_INFO_COMMENT}</div>';
		$content[] = '</div>';
		// info position
		$content[] = '<fieldset class=item>';
		$content[] = '<legend>{LNG_INFO_POSITION}</legend>';
		$content[] = '<div class=input-groups-table>';
		$content[] = '<div class=width>';
		$content[] = '<label for=info_latigude>{LNG_LATIGUDE}</label>';
		$content[] = '<span class="g-input icon-location"><input type=text name=info_latigude id=info_latigude value="'.$config['map_info_latigude'].'"></span>';
		$content[] = '</div>';
		$content[] = '<div class=width>';
		$content[] = '<label for=info_lantigude>{LNG_LANTIGUDE}</label>';
		$content[] = '<span class="g-input icon-location"><input type=text name=info_lantigude id=info_lantigude value="'.$config['map_info_lantigude'].'"></span>';
		$content[] = '</div>';
		$content[] = '</div>';
		$content[] = '</fieldset>';
		$content[] = '</fieldset>';
		// submit
		$content[] = '<fieldset class=submit>';
		$content[] = '<input type=submit class="button large save" value="{LNG_SAVE}">';
		$content[] = '</fieldset>';
		$content[] = '</form>';
		$content[] = '<aside class=message>{LNG_MAP_SETUP_COMMENT}</aside>';
		$content[] = '</div>';
		$content[] = '</section>';
		$content[] = '<script>';
		$content[] = 'new GForm("setup_frm","'.WEB_URL.'/widgets/map/admin_setup_save.php").onsubmit(doFormSubmit);';
		$content[] = 'inintMapDemo();';
		$content[] = '</script>';
		// หน้านี้
		$url_query['module'] = 'map-setup';
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
