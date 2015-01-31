<?php die('File not found !')?>
DELETE FROM `{prefix}_language` WHERE `owner`='marquee';
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_MARQUEE_DETAILS','text','marquee','0','ข้อความวิ่ง สามารถแทรกไอคอนหรือรูปภาพขนาดเล็ได้เล็กๆได้ (16*16 พิกเซล)');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_MARQUEE_SPEED','text','marquee','0','ความเร็ว');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_MARQUEE_SPEED_COMMENT','text','marquee','0','ความเร็วของข้อความวิ่ง 1-100 (เลขน้อยเร็วที่สุด)');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_WIDGETS_MARQUEE','text','marquee','0','Marquee');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_WIDGETS_MARQUEE_SETTINGS','text','marquee','0','ตั้งค่าข้อความ Maraquee (ข้อความวิ่ง)');