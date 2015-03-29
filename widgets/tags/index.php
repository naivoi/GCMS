<?php
	// widgets/tags/index.php
	if (defined('MAIN_INIT')) {
		$widget_id = gcms::rndName(10);
		$keyword = array();
		$keyword[] = '<div id='.$widget_id.' class=widget-tags>';
		$sql = 'SELECT * FROM `'.DB_TAGS.'` ORDER BY `count` ASC';
		$tag_result = $cache->get($sql);
		if (!$tag_result) {
			$tag_result = $db->customQuery($sql);
			$cache->save($sql, $tag_result);
		}
		if (sizeof($tag_result) > 0) {
			$min = 1000000;
			$max = 0;
			$nmax = sizeof($tag_result) - 1;
			$min = isset($tag_result[1]) ? $tag_result[1]['count'] : 0;
			$max = isset($tag_result[$nmax - 1]) ? $tag_result[$nmax - 1]['count'] : 0;
			$step = ($max - $min > 0) ? ($max - $min) / 7 : 0.1;
			for ($i = $nmax; $i >= 0; $i--) {
				$value = $tag_result[$i]['count'];
				$key = $tag_result[$i]['tag'];
				$id = $tag_result[$i]['id'];
				if ($i == 0) {
					$classname = 'class0';
				} elseif ($i == $nmax) {
					$classname = 'class9';
				} else {
					$classname = 'class'.(floor(($value - $min) / $step) + 1);
				}
				if (empty($config['tag_owner']) || $config['tag_owner'] == 'document') {
					$url = gcms::getURL('tag', $key);
				} else {
					$url = gcms::getURL($config['tag_owner'], 'tag', 0, 0, 'tag='.rawurlencode($key));
				}
				$keyword[] = '<a href="'.$url.'" class='.$classname.' id=tags-'.$id.'>'.str_replace(' ', '&nbsp;', $key).'</a>';
			}
		}
		$keyword[] = '</div>';
		$keyword[] = '<script>';
		$content[] = '$G(window).Ready(function(){';
		$keyword[] = "inintTags('$widget_id', '".SKIN."');";
		$content[] = '});';
		$keyword[] = '</script>';
		$widget = implode("\n", $keyword);
	}
