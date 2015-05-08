<?php
	// widgets/facebook/facebook.php
	// inint
	include '../../bin/inint.php';
	// ตรวจสอบค่า default
	$config['facebook_width'] = gcms::getVars($config, 'facebook_width', 0);
	$config['facebook_height'] = gcms::getVars($config, 'facebook_height', 0);
	$config['facebook_user'] = gcms::getVars($config, 'facebook_user', 'gcmscms');
	$config['facebook_show_facepile'] = gcms::getVars($config, 'facebook_show_facepile', 1);
	$config['facebook_show_posts'] = gcms::getVars($config, 'facebook_show_posts', 0);
	$config['facebook_hide_cover'] = gcms::getVars($config, 'facebook_hide_cover', 0);
	// หน้าเว็บ Facebook
	$facebook = array();
	$facebook[] = '<!DOCTYPE html>';
	$facebook[] = '<html lang='.LANGUAGE.' dir=ltr>';
	$facebook[] = '<head>';
	$facebook[] = '<title>Facebook</title>';
	$facebook[] = '<meta charset=utf-8>';
	$facebook[] = '<style>';
	$facebook[] = '#fb-root{display: none}';
	$facebook[] = '.fb_iframe_widget, .fb_iframe_widget span, .fb_iframe_widget span iframe[style] {width: 100% !important;}';
	$facebook[] = '</style>';
	$facebook[] = '</head>';
	$facebook[] = '<body>';
	$facebook[] = '<div id=fb-root></div>';
	$facebook[] = '<div class="fb-page"';
	$facebook[] = ' data-href="https://www.facebook.com/'.$config['facebook_user'].'"';
	if ($config['facebook_width'] > 0) {
		$facebook[] = ' data-width="'.$config['facebook_width'].'"';
	}
	if ($config['facebook_height'] > 0) {
		$facebook[] = ' data-height="'.$config['facebook_height'].'"';
	}
	$facebook[] = ' data-show-facepile="'.($config['facebook_show_facepile'] == 1 ? 'true' : 'false').'"';
	$facebook[] = ' data-show-posts="'.($config['facebook_show_posts'] == 1 ? 'true' : 'false').'"';
	$facebook[] = ' data-hide-cover="'.($config['facebook_hide_cover'] == 1 ? 'false' : 'true').'"></div>';
	$facebook[] = '<script>';
	$facebook[] = '(function(d, id) {';
	$facebook[] = 'var js = d.createElement("script");';
	$facebook[] = 'js.id = id;';
	$facebook[] = 'js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&appId='.(empty($config['facebook']['appId']) ? '' : $config['facebook']['appId']).'&version=v2.3";';
	$facebook[] = 'd.getElementsByTagName("head")[0].appendChild(js);';
	$facebook[] = '}(document, "facebook-jssdk"));';
	$facebook[] = '</script>';
	$facebook[] = '</body>';
	$facebook[] = '</html>';
	echo implode("\n", $facebook);
