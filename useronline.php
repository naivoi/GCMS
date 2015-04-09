<?php
	// useronline.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include ('bin/inint.php');
	// referer
	if (gcms::isReferer()) {
		// บอกว่ายังไม่มีคนเปลี่ยนแปลงไว้ก่อน
		$validtime = $mmktime - COUNTER_GAP;
		// เวลาที่บอกว่า user logout ไปแล้ว
		$online = 0;
		// แอเรย์เก็บ id ที่ต้องการลบ
		$session_id = session_id();
		$login = gcms::getVars($_SESSION, 'login', array('id' => 0, 'status' => -1, 'displayname' => '', 'email' => '', 'password' => ''));
		// ตรวจสอบตัวเองออนไลน์
		$me = $db->basicSearch(DB_USERONLINE, 'session', $session_id);
		// ลบคนที่หมดเวลาและตัวเอง
		$db->query("DELETE FROM `".DB_USERONLINE."` WHERE `time`<$validtime AND `session`!='$session_id'");
		// แก้ไขหรือเพิ่มตัวเอง
		$save = array();
		$save['member_id'] = (int)$login['id'];
		$save['displayname'] = trim(gcms::cutstring(empty($login['displayname']) ? $login['email'] : $login['displayname'], 10));
		$save['icon'] = WEB_URL.'/modules/member/usericon.php?id='.$login['id'];
		$save['time'] = $mmktime;
		$save['session'] = $session_id;
		if ($me) {
			$db->edit(DB_USERONLINE, $me['id'], $save);
		} else {
			$db->add(DB_USERONLINE, $save);
		}
		// รายการคนออนไลน์
		$datas = array();
		foreach ($db->customQuery('SELECT * FROM `'.DB_USERONLINE.'`') AS $item) {
			$online++;
			if ($item['member_id'] > 0) {
				$datas[$item['member_id']] = array('id' => $item['member_id'], 'icon' => $item['icon'], 'displayname' => $item['displayname']);
			}
		}
		$useronline = array();
		foreach ($datas AS $item) {
			$useronline[] = $item;
		}
		// วันนี้
		$counter_day = date('Y-m-d', $mmktime);
		$sql = "SELECT * FROM `".DB_COUNTER."` WHERE `date`='$counter_day' LIMIT 1";
		$my_counter = $db->customQuery($sql);
		$my_counter = $my_counter[0];
		$ret['all'] = $my_counter['counter'];
		$ret['today'] = $my_counter['visited'];
		$ret['online'] = $online;
		$ret['pagesview'] = $my_counter['pages_view'];
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
