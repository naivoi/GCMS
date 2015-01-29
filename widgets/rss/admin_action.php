<?php
	// widgets/rss/admin_action.php
	header("content-type: text/html; charset=UTF-8");
	// inint
	include '../../bin/inint.php';
	// referer, admin
	if (gcms::isReferer() && gcms::isAdmin()) {
		if (empty($_SESSION['login']['account']) || $_SESSION['login']['account'] != 'demo') {
			$ret = array();
			if (isset($_POST['data'])) {
				list($action, $id) = explode('_', $_POST['data']);
			} else {
				$action = gcms::getVars($_POST, 'action', '');
				$id = gcms::getVars($_POST, 'id', '');
				$value = gcms::getVars($_POST, 'value', 0);
			}
			if (isset($config['rss_tabs'])) {
				if ($action == 'delete') {
					// โหลด config ใหม่
					$config = array();
					if (is_file(CONFIG)) {
						include CONFIG;
					}
					$ids = explode(',', $id);
					$rss_tabs = $config['rss_tabs'];
					$config['rss_tabs'] = array();
					$n = 1;
					foreach ($rss_tabs AS $i => $item) {
						if (!in_array($i, $ids)) {
							$config['rss_tabs'][$n] = $item;
							$n++;
						}
					}
					gcms::saveconfig(CONFIG, $config);
				} elseif ($action == 'edit') {
					// เลือกเพื่อแก้ไข
					foreach ($config['rss_tabs'] AS $i => $item) {
						if ($i == $id) {
							$rss = $item;
						}
					}
					// คืนค่า
					if (is_array($rss)) {
						$ret['rss_url'] = rawurlencode($rss[0]);
						$ret['rss_topic'] = rawurlencode($rss[1]);
						$ret['rss_index'] = rawurlencode($rss[2]);
						$ret['rss_rows'] = (int)$rss[3];
						$ret['rss_cols'] = (int)$rss[4];
						$ret['rss_id'] = $id;
						$ret['input'] = 'rss_url';
					} else {
						$ret = array('error' => 'ACTION_ERROR');
					}
				} elseif ($_POST['action'] == 'move') {
					$rss_tabs = $config['rss_tabs'];
					$config['rss_tabs'] = array();
					$n = 1;
					foreach (explode(',',str_replace('L_','',$_POST['data'])) AS $id) {
						$config['rss_tabs'][$n] = $rss_tabs[$id];
						$n++;
					}
					gcms::saveconfig(CONFIG, $config);
				}
			} else {
				$ret = array('error' => 'ACTION_ERROR');
			}
			// คืนค่า JSON
			echo gcms::array2json($ret);
		}
	}
