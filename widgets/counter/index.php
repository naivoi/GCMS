<?php
	// widgets/counter/index.php
	if (defined('MAIN_INIT')) {
		$sql = "SELECT COUNT(*) FROM `".DB_USERONLINE."`";
		$sql = "SELECT *,($sql) AS `useronline` FROM `".DB_COUNTER."` ORDER BY `id` DESC LIMIT 1";
		$counter = $db->customQuery($sql);
		$counter = sizeof($counter) == 1 ? $counter[0] : array('counter' => 0, 'visited' => 0, 'pages_view' => 0, 'useronline' => 0);
		$fmt = "%0$config[counter_digit]d";
		// กรอบ counter
		$widget[] = '<div id=counter-box>';
		$widget[] = '<p class=counter-detail><span class=col>{LNG_COUNTER_ALL}</span><span id=counter>'.sprintf($fmt, $counter['counter']).'</span></p>';
		$widget[] = '<p class=counter-detail><span class=col>{LNG_COUNTER_TODAY}</span><span id=counter-today>'.sprintf($fmt, $counter['visited']).'</span></p>';
		$widget[] = '<p class=counter-detail><span class=col>{LNG_COUNTER_PAGES_VIEW}</span><span id=pages-view>'.sprintf($fmt, $counter['pages_view']).'</span></p>';
		$widget[] = '<p class=counter-detail><span class=col>{LNG_COUNTER_ONLINE}</span><span id=useronline>'.sprintf($fmt, $counter['useronline']).'</span></p>';
		$widget[] = '</div>';
		$widget[] = '<ul id=counter-online></ul>';
		$widget = implode("\n", $widget);
	}
