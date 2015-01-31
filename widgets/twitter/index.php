<?php
	// widgets/twitter/index.php
	if (defined('MAIN_INIT')) {
		$module = empty($module) ? $config['twitter_id'] : $module;
		if ($module == 'hidden') {
			$widget = '';
		} else {
			// default value
			$config['twitter_id'] = gcms::getVars($config, 'twitter_id', '348368123554062336');
			$config['twitter_name'] = gcms::getVars($config, 'twitter_name', 'goragod');
			$config['twitter_height'] = gcms::getVars($config, 'twitter_height', 250);
			$config['twitter_theme'] = gcms::getVars($config, 'twitter_theme', 'light');
			$config['twitter_border_color'] = gcms::getVars($config, 'twitter_border_color', '');
			$config['twitter_link_color'] = gcms::getVars($config, 'twitter_link_color', '');
			$config['twitter_count'] = gcms::getVars($config, 'twitter_count', 0);
			// หน้าเว็บ twitter
			$twitter = array();
			$twitter[] = '<a class="twitter-timeline"';
			$twitter[] = 'href="https://twitter.com/'.$config['twitter_name'].'"';
			$twitter[] = 'data-widget-id="'.$module.'"';
			$twitter[] = 'data-link-color="'.$config['twitter_link_color'].'"';
			$twitter[] = 'data-border-color="'.$config['twitter_border_color'].'"';
			$twitter[] = 'data-theme="'.$config['twitter_theme'].'"';
			$twitter[] = 'height="'.$config['twitter_height'].'"';
			if ($config['twitter_count'] > 0) {
				$twitter[] = 'data-tweet-limit="'.$config['twitter_count'].'"';
			}
			$twitter[] = '>Tweets by @'.$config['twitter_name'].'</a>';
			$twitter[] = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";';
			$twitter[] = 'if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}';
			$twitter[] = '}(document,"script","twitter-wjs");</script>';
			$widget = implode(' ', $twitter);
		}
	}
