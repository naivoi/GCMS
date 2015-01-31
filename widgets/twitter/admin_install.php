<?php
	// widgets/twitter/admin_install.php
	if (MAIN_INIT == 'installing') {
		// install sql
		gcms::install(ROOT_PATH.'widgets/twitter/sql.php');
		// บันทึกภาษา
		gcms::saveLanguage();
		$content[] = '<li class=valid>Add <strong>Language</strong> complete.</li>';
	}
