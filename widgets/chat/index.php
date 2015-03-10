<?php
	// widgets/chat/index.php
	if (defined('MAIN_INIT')) {
		// default
		$config['chat_time'] = gcms::getVars($config, 'chat_time', 5);
		$config['chat_lines'] = gcms::getVars($config, 'chat_lines', 10);
		// chat window
		$widget = array();
		$widget[] = '<div id=gchat_div>';
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
		$t = gcms::isMember() ? 'LNG_CHAT_TEXT_TITLE' : 'LNG_CHAT_INVALID_LOGIN';
		$widget[] = '</p>';
		$widget[] = '<form id=gchat_frm class=input-groups method=post action='.WEB_URL.'/index.php>';
		$widget[] = '<label class="width g-input"><input type=text id=gchat_text maxlength=50 disabled placeholder="{'.$t.'}"></label>';
		$widget[] = '<label class=width><input type=submit class="button wide send" value="Send"></label>';
		$widget[] = '<span class=width><a id=gchat_sound class=icon-vol-up title="{LNG_CHAT_SOUND}"></a></span>';
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
