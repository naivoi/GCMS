<?php
	// widgets/facebook/index.php
	if (defined('MAIN_INIT')) {
		$module = empty($module) ? gcms::getVars($config, 'facebook_user', '') : $module;
		$config['facebook_width'] = gcms::getVars($config, 'facebook_width', 500);
		$config['facebook_height'] = gcms::getVars($config, 'facebook_height', 0);
		$config['facebook_show_facepile'] = gcms::getVars($config, 'facebook_show_facepile', 1);
		$config['facebook_show_posts'] = gcms::getVars($config, 'facebook_show_posts', 0);
		$config['facebook_hide_cover'] = gcms::getVars($config, 'facebook_hide_cover', 0);
		if ($module == 'hidden') {
			$widget = '';
		} else {
			$div = '<div id=fb-root></div>';
			$div .= '<div>';
			$div .= '<div class="fb-page"';
			$div .= ' data-href="https://www.facebook.com/'.$module.'"';
			if ($config['facebook_width'] > 0) {
				$div .= ' data-width="'.$config['facebook_width'].'"';
			}
			if ($config['facebook_height'] > 0) {
				$div .= ' data-height="'.$config['facebook_height'].'"';
			}
			$div .= ' data-show-facepile="'.($config['facebook_show_facepile'] == 1 ? 'true' : 'false').'"';
			$div .= ' data-show-posts="'.($config['facebook_show_posts'] == 1 ? 'true' : 'false').'"';
			$div .= ' data-hide-cover="'.($config['facebook_hide_cover'] == 1 ? 'false' : 'true').'"></div></div>';
			$widget = array($div);
			$widget[] = '<script>';
			$widget[] = '(function(d, id) {';
			$widget[] = 'if (d.getElementById(id)) return;';
			$widget[] = 'var js = d.createElement("script");';
			$widget[] = 'js.id = id;';
			$widget[] = 'js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&appId='.(empty($config['facebook']['appId']) ? '' : $config['facebook']['appId']).'&version=v2.3";';
			$widget[] = 'd.getElementsByTagName("head")[0].appendChild(js);';
			$widget[] = '}(document, "facebook-jssdk"));';
			$widget[] = '</script>';
			$widget = implode("\n", $widget);
		}
	}
