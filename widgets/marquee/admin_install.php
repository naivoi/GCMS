<?php
	// widgets/marquee/admin_install.php
	if (MAIN_INIT == 'installing') {
		// install sql
		gcms::install(ROOT_PATH.'widgets/marquee/sql.php');
		// บันทึกภาษา
		gcms::saveLanguage();
		$content[] = '<li class=valid>Add <strong>Language</strong> complete.</li>';
	}
