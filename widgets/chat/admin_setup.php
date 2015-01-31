<?php
	// widgets/chat/admin_setup.php
	if (MAIN_INIT == 'admin' && $isAdmin) {
		// default
		$config['chat_time'] = gcms::getVars($config, 'chat_time', 5);
		$config['chat_history'] = gcms::getVars($config, 'chat_history', 7);
		$config['chat_lines'] = gcms::getVars($config, 'chat_lines', 10);
		// title
		$title = $lng['LNG_CHAT_SETUP'];
		$a = array();
		$a[] = '<span class=icon-widgets>{LNG_WIDGETS}</span>';
		$a[] = '{LNG_CHAT}';
		// แสดงผล
		$content[] = '<div class=breadcrumbs><ul><li>'.implode('</li><li>', $a).'</li></ul></div>';
		$content[] = '<section>';
		$content[] = '<header><h1 class=icon-chat>'.$title.'</h1></header>';
		$content[] = '<form id=setup_frm class=setup_frm method=post action=index.php>';
		$content[] = '<fieldset>';
		$content[] = '<legend><span>{LNG_CHAT}</span></legend>';
		// chat_time
		$content[] = '<div class=item>';
		$content[] = '<label for=chat_time>{LNG_CHAT_TIME}</label>';
		$content[] = '<span class="g-input icon-clock"><input type=number id=chat_time name=chat_time title="{LNG_CHAT_TIME_COMMENT}" value='.$config['chat_time'].'></span>';
		$content[] = '<div class=comment id=result_chat_time>{LNG_CHAT_TIME_COMMENT}</div>';
		$content[] = '</div>';
		// chat_history
		$content[] = '<div class=item>';
		$content[] = '<label for=chat_history>{LNG_CHAT_HISTORY}</label>';
		$content[] = '<span class="g-input icon-history"><input type=number id=chat_history name=chat_history title="{LNG_CHAT_HISTORY_COMMENT}" value='.$config['chat_history'].'></span>';
		$content[] = '<div class=comment id=result_chat_history>{LNG_CHAT_HISTORY_COMMENT}</div>';
		$content[] = '</div>';
		// chat_lines
		$content[] = '<div class=item>';
		$content[] = '<label for=chat_lines>{LNG_DISPLAY}</label>';
		$content[] = '<span class="g-input icon-published1"><input type=number id=chat_lines name=chat_lines title="{LNG_CHAT_LINE_COMMENT}" value='.$config['chat_lines'].'></span>';
		$content[] = '<div class=comment id=result_chat_lines>{LNG_CHAT_LINE_COMMENT}</div>';
		$content[] = '</div>';
		// submit
		$content[] = '</fieldset>';
		$content[] = '<fieldset class=submit>';
		$content[] = '<input type=submit class="button large save" value="{LNG_SAVE}">';
		$content[] = '&nbsp;<a href="index.php?module=chat-history" class="button large go"><span>{LNG_CHAT_HISTORY}</span></a>';
		$content[] = '</fieldset>';
		$content[] = '</form>';
		$content[] = '</section>';
		$content[] = '<script>';
		$content[] = '$G(window).Ready(function(){';
		$content[] = 'new GForm("setup_frm", "'.WEB_URL.'/widgets/chat/admin_save.php").onsubmit(doFormSubmit);';
		$content[] = '});';
		$content[] = '</script>';
		// หน้านี้
		$url_query['module'] = 'chat-setup';
	} else {
		$title = $lng['LNG_DATA_NOT_FOUND'];
		$content[] = '<aside class=error>'.$title.'</aside>';
	}
