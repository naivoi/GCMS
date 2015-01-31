<?php
	// widgets/shoutbox/index.php
	if (defined('MAIN_INIT')) {
		// default
		$config['shoutbox_time'] = gcms::getVars($config, 'shoutbox_time', 5);
		$config['shoutbox_lines'] = gcms::getVars($config, 'shoutbox_lines', 10);
		$emoticon_dir = WEB_URL.'/widgets/shoutbox/smile';
		$shoutbox = array();
		$shoutbox[] = '<div id=shoutbox_div>';
		$shoutbox[] = '<dl id=shoutbox_list></dl>';
		$shoutbox[] = '<form id=shoutbox_frm method=post action='.WEB_URL.'>';
		$shoutbox[] = '<fieldset>';
		$shoutbox[] = '<p><label for=shoutbox_sender>{LNG_FNAME}:</label><span><input type=text id=shoutbox_sender name=shoutbox_sender maxlength=20 size=15></span></p>';
		$shoutbox[] = '<p><label for=shoutbox_txt>{LNG_SHOUTBOX_MESSAGE}:</label><span><input type=text id=shoutbox_txt name=shoutbox_txt maxlength=100 size=15 title="{LNG_SHOUTBOX_TEXT_TITLE}"></span></p>';
		$shoutbox[] = '<p><label for=shoutbox_submit>&nbsp;</label><span><input class="button send" id=shoutbox_submit type=submit value="{LNG_SHOUTBOX_SEND}"><img src='.$emoticon_dir.'/0.gif alt=emoticon class=nozoom></span></p>';
		$shoutbox[] = '</fieldset>';
		$shoutbox[] = '<p id=shoutbox_emoticon>';
		$f = @opendir(ROOT_PATH.'widgets/shoutbox/smile/');
		if ($f) {
			while (false !== ($text = readdir($f))) {
				if (preg_match('/^([0-9]+)\.gif$/', $text, $match)) {
					$shoutbox[] = "<img src=$emoticon_dir/$match[1].gif alt=$match[1] class=nozoom>";
				}
			}
			closedir($f);
		}
		$shoutbox[] = '</p>';
		$shoutbox[] = '</form>';
		$shoutbox[] = '</div>';
		$shoutbox[] = '<script>';
		$shoutbox[] = 'new GShoutBox({';
		$shoutbox[] = 'interval:'.max(1, $config['shoutbox_time']).',';
		$shoutbox[] = 'lines:'.max(1, $config['shoutbox_lines']);
		$shoutbox[] = '});';
		$shoutbox[] = '</script>';
		$widget = implode("\n", $shoutbox);
	}
