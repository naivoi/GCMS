<?php
	// widgets/shoutbox/admin_setup.php
	if (MAIN_INIT == 'admin' && $isAdmin) {
		// default
		$config['shoutbox_time'] = gcms::getVars($config, 'shoutbox_time', 5);
		$config['shoutbox_history'] = gcms::getVars($config, 'shoutbox_history', 7);
		$config['shoutbox_lines'] = gcms::getVars($config, 'shoutbox_lines', 10);
		// title
		$title = $lng['LNG_SHOUTBOX_SETUP'];
		$a = array();
		$a[] = '<span class=icon-widgets>{LNG_WIDGETS}</span>';
		$a[] = '{LNG_SHOUTBOX}';
		// แสดงผล
		$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
		$content[] = '<section>';
		$content[] = '<header><h1 class=icon-chat>'.$title.'</h1></header>';
		$content[] = '<form id=setup_frm class=setup_frm method=post action=index.php>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_SHOUTBOX}</span></legend>';
		// shoutbox_time
		$content[] = '<div class=item>';
		$content[] = '<label for=shoutbox_time>{LNG_SHOUTBOX_TIME}</label>';
		$content[] = '<span class="g-input icon-clock"><input type=number id=shoutbox_time name=shoutbox_time title="{LNG_SHOUTBOX_TIME_COMMENT}" value='.$config['shoutbox_time'].'></span>';
		$content[] = '<div class=comment id=result_shoutbox_time>{LNG_SHOUTBOX_TIME_COMMENT}</div>';
		$content[] = '</div>';
		// shoutbox_history
		$content[] = '<div class=item>';
		$content[] = '<label for=shoutbox_history>{LNG_SHOUTBOX_HISTORY}</label>';
		$content[] = '<span class="g-input icon-history"><input type=number id=shoutbox_history name=shoutbox_history title="{LNG_SHOUTBOX_HISTORY_COMMENT}" value='.$config['shoutbox_history'].'></span>';
		$content[] = '<div class=comment id=result_shoutbox_history>{LNG_SHOUTBOX_HISTORY_COMMENT}</div>';
		$content[] = '</div>';
		// shoutbox_lines
		$content[] = '<div class=item>';
		$content[] = '<label for=shoutbox_lines>{LNG_DISPLAY}</label>';
		$content[] = '<span class="g-input icon-published1"><input type=number id=shoutbox_lines name=shoutbox_lines title="{LNG_SHOUTBOX_LINE_COMMENT}" value='.$config['shoutbox_lines'].'></span>';
		$content[] = '<div class=comment id=result_shoutbox_lines>{LNG_SHOUTBOX_LINE_COMMENT}</div>';
		$content[] = '</div>';
		// submit
		$content[] = '</fieldset>';
		$content[] = '<fieldset class=submit>';
		$content[] = '<input type=submit class="button large save" value="{LNG_SAVE}">';
		$content[] = '&nbsp;<a href="index.php?module=shoutbox-history" class="button large go"><span>{LNG_CHAT_HISTORY}</span></a>';
		$content[] = '</fieldset>';
		$content[] = '</form>';
		$content[] = '</section>';
		$content[] = '<script>';
		$content[] = '$G(window).Ready(function(){';
		$content[] = 'new GForm("setup_frm", "'.WEB_URL.'/widgets/shoutbox/admin_save.php").onsubmit(doFormSubmit);';
		$content[] = '});';
		$content[] = '</script>';
		// หน้านี้
		$url_query['module'] = 'shoutbox-setup';
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
