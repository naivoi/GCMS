<?php
	// widgets/map/index.php
	if (defined('MAIN_INIT')) {
		$widget = '<iframe src="'.WEB_URL.'/widgets/map/map.php?p='.rawurlencode($module).'" style="width:100%;height:'.$config['map_height'].'px"></iframe>';
	}
