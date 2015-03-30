<?php
	if (INSTALL_INIT == 'upgrade') {
		// upgrade language
		$dir = ROOT_PATH.'admin/install/language/';
		if (is_dir($dir)) {
			$patt = '/^var[\s]+([A-Z0-9_]+)[\s]{0,}=[\s]{0,}[\'"](.*)[\'"];$/';
			$f = opendir($dir);
			while (false !== ($text = readdir($f))) {
				if (preg_match('/([a-z]+)\.(php|js)/', $text, $match)) {
					if ($match[2] == 'php') {
						$lng = array();
						include ($dir.$text);
						foreach ($lng AS $key => $value) {
							if (is_array($value)) {
								$value = serialize($value);
								$array = true;
							} else {
								$array = false;
							}
							// ตรวจสอบ key
							$sql = "SELECT * FROM `".DB_LANGUAGE."` WHERE `js`='0' AND `key`='$key' LIMIT 1";
							$search = $db->customQuery($sql);
							if (sizeof($search) == 0) {
								$save = array();
								$save['js'] = 0;
								$save['owner'] = 'index';
								$save['key'] = $key;
								$save[$match[1]] = $value;
								$save['type'] = $array ? 'array' : 'text';
								$db->add(DB_LANGUAGE, $save);
							}
							// ตรวจสอบ value
							$sql = "SELECT * FROM `".DB_LANGUAGE."` WHERE `js`='0' AND `key`='$key' AND `$match[1]`!='".addslashes($value)."' LIMIT 1";
							$search = $db->customQuery($sql);
							if (sizeof($search) == 1) {
								$db->edit(DB_LANGUAGE, $search[0]['id'], array($match[1] => $value));
							}
						}
					} else {
						foreach (file($dir.$text) AS $item) {
							$item = trim($item);
							if ($item != '') {
								if (preg_match($patt, $item, $match2)) {
									// ตรวจสอบ key
									$sql = "SELECT * FROM `".DB_LANGUAGE."` WHERE `js`='1' AND `key`='$match2[1]' LIMIT 1";
									$search = $db->customQuery($sql);
									if (sizeof($search) == 0) {
										$save = array();
										$save['js'] = 1;
										$save['owner'] = 'index';
										$save['key'] = $match2[1];
										$save[$match[1]] = $match2[2];
										$save['type'] = 'text';
										$db->add(DB_LANGUAGE, $save);
									}
									// ตรวจสอบ value
									$value = addslashes($match2[2]);
									$sql = "SELECT * FROM `".DB_LANGUAGE."` WHERE `js`='1' AND `key`='$match2[1]' AND `$match[1]`!='$value' LIMIT 1";
									$search = $db->customQuery($sql);
									if (sizeof($search) == 1) {
										$db->edit(DB_LANGUAGE, $search[0]['id'], array($match[1] => $value));
									}
								}
							}
						}
					}
				}
			}
			closedir($f);
		}
		// บันทึกไฟล์ภาษา
		gcms::saveLanguage();
		echo '<li class=correct>Update <strong>languages</strong> <i>complete...</i></li>';
		ob_flush();
		flush();
	}