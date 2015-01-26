<?php
	// widgets/textlink/styles.php
	$textlink_typies = array();
	$textlink_typies['custom'] = '';
	$textlink_typies['list'] = '<p><a title="{TITLE}"{URL}{TARGET}><img alt="{TITLE}" src="{LOGO}"></a></p>';
	$textlink_typies['row'] = '<a title="{TITLE}"{URL}{TARGET}>{TITLE}</a>';
	$textlink_typies['image'] = '<a class=animate title="{TITLE}"{URL}{TARGET}><img alt="{TITLE}" src="{LOGO}"></a>';
	$textlink_typies['menu'] = '<li><a title="{TITLE}"{URL}{TARGET}><span>{TITLE}</span></a></li>';
	$textlink_typies['banner'] = '<a title="{TITLE}"{URL}{TARGET}><img alt="{TITLE}" src="{LOGO}"></a>';
	$textlink_typies['slideshow'] = '';
