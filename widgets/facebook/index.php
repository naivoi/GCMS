<?php
	// widgets/facebook/index.php
	if (defined('MAIN_INIT')) {
		$module = empty($module) ? $config['facebook_user'] : $module;
		if ($module == 'hidden') {
			$widget = '';
		} else {
			$div = '<div id=fb-root></div>';
			$div .= '<div>';
			$div .= '<div style="height:'.$config['facebook_height'].'px;" class=fb-like-box';
			$div .= ' data-href="https://www.facebook.com/'.$module.'"';
			$div .= ' data-width="'.$config['facebook_width'].'"';
			$div .= ' data-height="'.$config['facebook_height'].'"';
			$div .= ' data-show-faces="'.($config['facebook_faces'] == 1 ? 'true' : 'false').'"';
			$div .= ' data-show-border="'.($config['facebook_border'] == 1 ? 'true' : 'false').'"';
			$div .= ' data-stream="'.($config['facebook_stream'] == 1 ? 'true' : 'false').'"';
			$div .= ' data-header="'.($config['facebook_header'] == 1 ? 'true' : 'false').'"></div></div>';
			$widget = array($div);
			$widget[] = '<script>';
			$widget[] = '(function(d, id) {';
			$widget[] = 'if(!$E("fb-root")){';
			$widget[] = 'var div = d.createElement("div");';
			$widget[] = 'div.id="fb-root";';
			$widget[] = 'd.body.appendChild(div);';
			$widget[] = '}';
			$widget[] = 'var js = d.createElement("script");';
			$widget[] = 'js.id = id;';
			$widget[] = 'js.src = "//connect.facebook.net/th_TH/all.js#xfbml=1&appId='.(empty($config['facebook']['appId']) ? '' : $config['facebook']['appId']).'&version=v2.0";';
			$widget[] = 'd.getElementsByTagName("head")[0].appendChild(js);';
			$widget[] = '}(document, "facebook-jssdk"));';
			$widget[] = '</script>';
			$widget = implode("\n", $widget);
		}
	}