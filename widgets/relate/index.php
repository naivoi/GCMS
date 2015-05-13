<?php
	// widgets/relate/index.php
	$widget = '';
	if (defined('MAIN_INIT') && preg_match('/^[0-9]+$/', $id)) {
		// ค่าที่ส่งมา
		$id = (int)$id;
		if ($id > 0) {
			$cols = isset($cols) ? (int)$cols : 1;
			$rows = isset($rows) ? (int)$rows : 1;
			$sort = isset($sort) ? (int)$sort : 1;
			if ($cols * $cols > 0) {
				$styles = isset($styles) && in_array($styles, array('list', 'icon', 'thumb')) ? $styles : 'list';
				// แสดงผล
				$patt = array('/{ID}/', '/{DETAIL}/');
				$replace = array();
				$replace[0] = "widget_{$id}_{$cols}_{$rows}_{$sort}_{$styles}";
				$replace[1] = "<script>getWidgetNews('$replace[0]', 'relate', 0);</script>";
				$widget = preg_replace($patt, $replace, gcms::loadfile(ROOT_PATH.'widgets/relate/widget.html'));
			}
		}
	}
