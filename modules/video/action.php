<?php
	// modules/video/action.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// referer, member
	if (gcms::isReferer() && preg_match('/^youtube_([0-9]+)_([a-zA-Z0-9\-_]{11,11})$/', $_POST['id'], $match)) {
		$mv = $db->getRec(DB_VIDEO, $match[1]);
		// get video info
		if (function_exists('curl_init') && $ch = @curl_init()) {
			curl_setopt($ch, CURLOPT_URL, 'http://gdata.youtube.com/feeds/api/videos/'.$mv['youtube'].'?v=2');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$feed = curl_exec($ch);
			curl_close($ch);
		} else {
			$feed = file_get_contents('http://gdata.youtube.com/feeds/api/videos/'.$mv['youtube'].'?v=2');
		}
		if ($feed != '') {
			$xml = simplexml_load_string($feed);
			$yt = $xml->children('http://gdata.youtube.com/schemas/2007');
			$attrs = $yt->statistics->attributes();
			$views = (int)$attrs['viewCount'];
			if ($views != $mv['views']) {
				$db->edit(DB_VIDEO, $mv['id'], array('views' => $views));
			}
		}
		echo '<figure class=mv>';
		echo '<div class=youtube><iframe width=560 height=315 src="//www.youtube.com/embed/'.$mv['youtube'].'?wmode=transparent" frameborder=0></iframe></div>';
		echo '<figcaption>'.$mv['topic'].'</figcaption>';
		echo '</figure>';
	}
