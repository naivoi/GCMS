<?php
	// widgets/tags/view.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// referer
	if (gcms::isReferer()) {
		list($action, $id) = explode('-', $_POST['id']);
		$tag = $db->getRec(DB_TAGS, $id);
		if ($tag) {
			$patt = array('/{(LNG_[A-Z0-9_]+)}/e', '/{TAG}/', '/{COUNT}/');
			$replace = array();
			$replace[] = OLD_PHP ? '$lng[\'$1\']' : 'gcms::getLng';
			$replace[] = $tag['tag'];
			$replace[] = number_format($tag['count']);
			echo gcms::pregReplace($patt, $replace, gcms::loadfile('tags.tpl'));
		}
	}
