<?php
	// useronline.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('bin/inint.php');
	// referer
	if (gcms::isReferer()) {
		$onlinechanged = false;
		// บอกว่ายังไม่มีคนเปลี่ยนแปลงไว้ก่อน
		$validtime = $mmktime - COUNTER_GAP;
		// เวลาที่บอกว่า user logout ไปแล้ว
		$online = 0;
		// ตัวเอง online อยู่
		$useronline = array();
		// แอเร์ยเก็บชื่อคน online
		$deleteid = array();
		// แอเรย์เก็บ id ที่ต้องการลบ
		$session_id = session_id();
		$updateid = 0;
		$onlinechanged = false;
		$userupdate = false;
		$login = gcms::getVars($_SESSION, 'login', array('id' => 0, 'status' => -1, 'displayname' => '', 'email' => '', 'password' => ''));
		// เพิ่มตัวเอง online
		$my['member_id'] = (int)$login['id'];
		$my['displayname'] = trim(gcms::cutstring(empty($login['displayname']) ? $login['email'] : $login['displayname'], 10));
		$my['icon'] = WEB_URL.'/modules/member/usericon.php?id='.$login['id'];
		$my['time'] = $mmktime;
		$my['session'] = $session_id;
		// ลบคนที่หมดเวลาและตัวเอง
		$db->query("DELETE FROM `".DB_USERONLINE."` WHERE `session`='$session_id' OR `time`<$validtime");
		// บันทึกตัวเองออนไลน์
		$db->add(DB_USERONLINE, $my);
		// รายการคนออนไลน์
		foreach ($db->customQuery('SELECT * FROM `'.DB_USERONLINE.'`') AS $item) {
			$online++;
			if ($item['member_id'] > 0) {
				$useronline[] = array('id' => $item['member_id'], 'icon' => $item['icon'], 'displayname' => $item['displayname']);
			}
		}
		// ลบคนที่หมดเวลาออกจาก db
		if (count($deleteid) > 0) {
			$db->query('DELETE FROM `'.DB_USERONLINE.'` WHERE `id` IN('.implode(',', $deleteid).')');
		}
		// บันทึกตัวเองลงบน db
		if ($updateid > 0) {
			$db->edit(DB_USERONLINE, $updateid, $my);
		} else {
			$db->add(DB_USERONLINE, $my);
			$onlinechanged = true;
		}
		// วันนี้
		$counter_day = date('Y-m-d', $mmktime);
		$sql = "SELECT * FROM `".DB_COUNTER."` WHERE `date`='$counter_day' LIMIT 1";
		$my_counter = $db->customQuery($sql);
		$my_counter = $my_counter[0];
		$c = gcms::getVars($_POST, 'counter', 0);
		$my_counter['time'] = ($userupdate || $c == 0) ? $mmktime : $my_counter['time'];
		$db->edit(DB_COUNTER, $my_counter['id'], $my_counter);
		$ret['all'] = $my_counter['counter'];
		$ret['today'] = $my_counter['visited'];
		$ret['online'] = $online;
		$ret['pagesview'] = $my_counter['pages_view'];
		$ret['count'] = $my_counter['time'];
		$ret['useronline'] = $useronline;
		// include ไฟล์อื่นๆที่ต้องการประมวลผล
		if (isset($config['useronline_include'])) {
			foreach ($config['useronline_include'] AS $item) {
				include ROOT_PATH.$item;
			}
		}
		// คืนค่า JSON
		echo json_encode($ret);
	}
