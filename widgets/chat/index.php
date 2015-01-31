<?php
	// widgets/chat/index.php
	if (defined('MAIN_INIT')) {
		// default
		$config['chat_time'] = gcms::getVars($config, 'chat_time', 5);
		$config['chat_lines'] = gcms::getVars($config, 'chat_lines', 10);
		// chat window
		$widget = array();
		$widget[] = '<div id=gchat_div >';
		$widget[] = '<div id=gchat_body>';
		$widget[] = '<dl id=gchat_content></dl>';
		$widget[] = '<p id=gchat_smile>';
		$f = @opendir(ROOT_PATH.'widgets/chat/smile/');
		if ($f) {
			while (false !== ($text = readdir($f))) {
				if ($text != '.' && $text != '..') {
					if (preg_match('/(.*).gif/', $text, $match)) {
						$widget[] = '<img src='.WEB_URL.'/widgets/chat/smile/'.$match[1].'.gif alt='.$match[1].' class=nozoom>';
					}
				}
			}
			closedir($f);
		}
		$widget[] = '</p>';
		$widget[] = '<form id=gchat_frm method=post action='.WEB_URL.'>';
		$widget[] = '<label><input type=text id=gchat_text size=40 maxlength=50 disabled title="{LNG_CHAT_TEXT_TITLE}"></label>';
		$widget[] = '<input type=submit class="button send" id=gchat_send value="{LNG_SEND_MESSAGE}">';
		$widget[] = '<span id=gchat_sound class=soundon title="{LNG_CHAT_SOUND}">&nbsp;</span>';
		$widget[] = '</form>';
		$widget[] = '</div>';
		$widget[] = '</div>';
		$widget[] = '<script>';
		$widget[] = 'new GChat({';
		$widget[] = 'interval:'.max(1, $config['chat_time']).',';
		$widget[] = 'lines:'.max(1, $config['chat_lines']);
		$widget[] = '});';
		$widget[] = '</script>';
		$widget = implode("\n", $widget);
	}
