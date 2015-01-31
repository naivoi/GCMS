<?php
	// widgets/twitter/admin_setup.php
	if (MAIN_INIT == 'admin' && $isAdmin) {
		// default value
		$config['twitter_id'] = gcms::getVars($config, 'twitter_id', '348368123554062336');
		$config['twitter_name'] = gcms::getVars($config, 'twitter_name', 'goragod');
		$config['twitter_height'] = gcms::getVars($config, 'twitter_height', 250);
		$config['twitter_theme'] = gcms::getVars($config, 'twitter_theme', 'light');
		$config['twitter_border_color'] = gcms::getVars($config, 'twitter_border_color', '');
		$config['twitter_link_color'] = gcms::getVars($config, 'twitter_link_color', '');
		$config['twitter_count'] = gcms::getVars($config, 'twitter_count', 0);
		// title
		$title = $lng['LNG_TWITTER'];
		$a = array();
		$a[] = '<span class=icon-widgets>{LNG_WIDGETS}</span>';
		$a[] = '{LNG_TWITTER}';
		// แสดงผล
		$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
		$content[] = '<section>';
		$content[] = '<header><h1 class=icon-twitter>'.$title.'</h1></header>';
		$content[] = '<div class=setup_frm>';
		$content[] = '<form id=setup_frm class=paper method=post action=index.php>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_TWITTER_DETAILS}</span></legend>';
		// twitter_id
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_id>{LNG_TWITTER_ID}</label>';
		$content[] = '<span class="g-input icon-password"><input type=text id=twitter_id name=twitter_id value="'.$config['twitter_id'].'" title="{LNG_TWITTER_ID_COMMENT}"></span>';
		$content[] = '<div class=comment id=result_twitter_id>{LNG_TWITTER_ID_COMMENT}</div>';
		$content[] = '</div>';
		// twitter_name
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_name>{LNG_TWITTER_NAME}</label>';
		$content[] = '<span class="g-input icon-twitteruser"><input type=text id=twitter_name name=twitter_name value="'.$config['twitter_name'].'" title="{LNG_TWITTER_NAME_COMMENT}"></span>';
		$content[] = '<div class=comment id=result_twitter_name>{LNG_TWITTER_NAME_COMMENT}</div>';
		$content[] = '</div>';
		$content[] = '</fieldset>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_TWITTER_STYLE}</span></legend>';
		// twitter_height
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_height>{LNG_HEIGHT} ({LNG_PX})</label>';
		$content[] = '<span class="g-input icon-height"><input type=number name=twitter_height id=twitter_height value="'.$config['twitter_height'].'" title="{LNG_TWITTER_SIZE_IFRAME_HEIGHT_TITLE}"></span>';
		$content[] = '<div class=comment>{LNG_TWITTER_SIZE_COMMENT}</div>';
		$content[] = '</div>';
		// twitter_count
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_count>{LNG_QUANTITY}</label>';
		$content[] = '<span class="g-input icon-config"><select id=twitter_count name=twitter_count title="{LNG_TWITTER_QUANTITY_COMMENT}">';
		for ($i = 0; $i < 21; $i++) {
			$sel = $i == $config['twitter_count'] ? ' selected' : '';
			$content[] = '<option value='.$i.$sel.'>'.$i.'</option>';
		}
		$content[] = '</select></span>';
		$content[] = '<div class=comment id=result_twitter_count>{LNG_TWITTER_QUANTITY_COMMENT}</div>';
		$content[] = '</div>';
		// twitter_theme
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_theme>{LNG_TWITTER_THEME}</label>';
		$content[] = '<span class="g-input icon-template"><select id=twitter_theme name=twitter_theme title="{LNG_TWITTER_THEME_COMMENT}">';
		foreach ($lng['TWITTER_THEMES'] AS $key => $value) {
			$sel = $key == $config['twitter_theme'] ? ' selected' : '';
			$content[] = '<option value='.$key.$sel.'>'.$value.'</option>';
		}
		$content[] = '</select></span>';
		$content[] = '<div class=comment id=result_twitter_theme>{LNG_TWITTER_THEME_COMMENT}</div>';
		$content[] = '</div>';
		// twitter_border_color
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_border_color>{LNG_BORDER_COLOR}</label>';
		$content[] = '<span class="g-input icon-color"><input type=text class=color id=twitter_border_color name=twitter_border_color value="'.$config['twitter_border_color'].'" title="{LNG_TWITTER_BORDER_COLOR_COMMENT}"></span>';
		$content[] = '<div class=comment id=result_twitter_tweets_color>{LNG_TWITTER_BORDER_COLOR_COMMENT}</div>';
		$content[] = '</div>';
		// twitter_link_color
		$content[] = '<div class=item>';
		$content[] = '<label for=twitter_link_color>{LNG_LINK_COLOR}</label>';
		$content[] = '<span class="g-input icon-color"><input type=text class=color id=twitter_link_color name=twitter_link_color value="'.$config['twitter_link_color'].'" title="{LNG_TWITTER_LINK_COLOR_COMMENT}"></span>';
		$content[] = '<div class=comment id=result_twitter_link_color>{LNG_TWITTER_LINK_COLOR_COMMENT}</div>';
		$content[] = '</div>';
		$content[] = '</fieldset>';
		// submit
		$content[] = '<fieldset class=submit>';
		$content[] = '<input type=submit class="button large save" value="{LNG_SAVE}">';
		$content[] = '</fieldset>';
		$content[] = '</form>';
		$module = '';
		include (ROOT_PATH.'widgets/twitter/index.php');
		$content[] = '<div class=twitter-demo>'.$widget.'</div>';
		$content[] = '</div>';
		$content[] = '</section>';
		$content[] = '<script>';
		$content[] = '$G(window).Ready(function(){';
		$content[] = 'new GForm("setup_frm", "'.WEB_URL.'/widgets/twitter/admin_setup_save.php").onsubmit(doFormSubmit);';
		$content[] = '});';
		$content[] = '</script>';
		// หน้านี้
		$url_query['module'] = 'twitter-setup';
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
