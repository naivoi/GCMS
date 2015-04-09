<?php
	// widgets/textlink/styles.php
	$textlink_typies = array();
	$textlink_typies['custom'] = '';
	$textlink_typies['text'] = '<a title="{TITLE}"{URL}{TARGET}>{TITLE}</a>';
	$textlink_typies['menu'] = '<li><a title="{TITLE}"{URL}{TARGET}><span>{TITLE}</span></a></li>';
	$textlink_typies['image'] = '<a title="{TITLE}"{URL}{TARGET}><img class="nozoom" alt="{TITLE}" src="{LOGO}"></a>';
	$textlink_typies['banner'] = '<a title="{TITLE}"{URL}{TARGET}><img class="nozoom" alt="{TITLE}" src="{LOGO}"></a>';
	$textlink_typies['slideshow'] = '';
