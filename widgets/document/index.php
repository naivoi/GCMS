<?php
	// widgets/document/index.php
	$widget = '';
	if (defined('MAIN_INIT') && preg_match('/^[a-z0-9]{4,}$/', $module) && is_array($install_modules[$module])) {
		// module
		$index = $install_modules[$module];
		// อ่าน config
		gcms::r2config($index['config'], $index);
		// ค่าที่ส่งมา
		$id = $index['module_id'];
		$cat = isset($cat) ? (int)$cat : 0;
		$new_date = (int)$index['new_date'];
		$interval = isset($interval) ? (int)$interval : 0;
		$cols = isset($cols) ? (int)$cols : 0;
		$rows = isset($rows) ? (int)$rows : 0;
		if ($rows > 0 && $cols > 0) {
			$count = $rows * $cols;
		} else {
			$count = isset($count) ? (int)$count : 0;
			$count = $count == 0 ? $index['news_count'] : $count;
			$cols = 1;
		}
		$sort = isset($sort) ? (int)$sort : $index['news_sort'];
		if ($count > 0) {
			$styles = isset($styles) && in_array($styles, array('list', 'icon', 'thumb')) ? $styles : 'list';
			// แสดงผล
			$patt = array('/{ID}/', '/{DETAIL}/', '/{MODULE}/');
			$replace = array();
			$replace[0] = "widget_".(empty($index['module']) ? '' : $index['module'])."_{$id}_{$cat}_{$count}_{$new_date}_{$sort}_{$cols}_{$styles}";
			$replace[1] = "<script>getWidgetNews('$replace[0]', 'document', $interval);</script>";
			$replace[2] = $index['module'];
			$widget = preg_replace($patt, $replace, gcms::loadtemplate($index['module'], 'document', 'widget'));
		}
	}
