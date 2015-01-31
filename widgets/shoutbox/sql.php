<?php die('File not found !')?>
define("DB_SHOUTBOX", PREFIX."_shoutbox");
DROP TABLE IF EXISTS `{prefix}_shoutbox`;
CREATE TABLE IF NOT EXISTS `{prefix}_shoutbox` (`id` int(11) unsigned NOT NULL auto_increment,`time` int(11) unsigned NOT NULL,`sender` varchar(20) collate utf8_unicode_ci NOT NULL,`text` text collate utf8_unicode_ci NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
DELETE FROM `{prefix}_language` WHERE `owner`='shoutbox';
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX','text','shoutbox','0','กล่องฝากข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_HISTORY','text','shoutbox','0','ประวัติการสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_HISTORY_COMMENT','text','shoutbox','0','ช่วงเวลาที่เก็บข้อความสนทนาไว้ (วัน) ข้อความที่เก่ากว่านี้จะถูกลบออกโดยอัตโนมัติ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_LINE_COMMENT','text','shoutbox','0','จำนวนบรรทัดแสดงผลในกรอบสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_LINES','text','shoutbox','0','การแสดงผล');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_MESSAGE','text','shoutbox','0','ข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_SEND','text','shoutbox','0','Shout!');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_SETUP','text','shoutbox','0','ตั้งค่ากล่องฝากข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_TEXT_TITLE','text','shoutbox','0','กด Enter หรือ คลิก Shout! เพื่อส่งข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_TIME','text','shoutbox','0','อัปเดทข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_SHOUTBOX_TIME_COMMENT','text','shoutbox','0','ช่วงเวลาการอัปเดทข้อความ (วินาที)');