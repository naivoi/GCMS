<?php
	// widgets/calendar/index.php
	if (defined('MAIN_INIT')) {
		$widget[] = '<div id=widget-calendar-'.$module.'></div>';
		$widget[] = '<script>';
		$widget[] = 'inintCalendar("widget-calendar-'.$module.'", false);';
		$widget[] = '</script>';
		$widget = implode("\n", $widget);
	}
