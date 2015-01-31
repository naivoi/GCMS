<?php
	// widgets/shoutbox/admin_install.php
	if (MAIN_INIT == 'installing') {
		// install sql
		gcms::install(ROOT_PATH.'widgets/shoutbox/sql.php');
		// โหลด config ใหม่
		$config = array();
		if (is_file(CONFIG)) {
			include CONFIG;
		}
		// โหลด config ของโมดูล
		include (ROOT_PATH.'widgets/shoutbox/default.config.php');
		$config = array_merge($config, $newconfig['shoutbox']);
		// save config
		if (gcms::saveconfig(CONFIG, $config)) {
			$content[] = '<li class=valid>Add <strong>configs</strong> complete.</li>';
		} else {
			$content[] = '<li class=invalid>'.sprintf($lng['ERROR_FILE_READ_ONLY'], 'bin/config.php').'</li>';
		}
		// add vars
		if (sizeof($defines) > 0) {
			if ($ftp->fwrite(ROOT_PATH.'bin/vars.php', 'ab', "\n\t// Widget Shoutbox\n\t".implode("\n\t", $defines))) {
				$content[] = '<li class=valid>Add <strong>vars</strong> complete.</li>';
			} else {
				$content[] = '<li class=invalid>'.sprintf($lng['ERROR_FILE_READ_ONLY'], 'bin/vars.php').'</li>';
			}
		}
		// บันทึกภาษา
		gcms::saveLanguage();
		$content[] = '<li class=valid>Add <strong>Language</strong> complete.</li>';
	}
