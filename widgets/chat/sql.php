<?php die('File not found !')?>
define("DB_CHAT", PREFIX."_chat");
DROP TABLE IF EXISTS `{prefix}_chat`;
CREATE TABLE IF NOT EXISTS `{prefix}_chat` (`id` int(11) unsigned NOT NULL auto_increment,`time` int(11) unsigned NOT NULL,`sender` varchar(20) collate utf8_unicode_ci NOT NULL,`text` text collate utf8_unicode_ci NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
DELETE FROM `{prefix}_language` WHERE `owner`='chat';
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT','text','chat','0','Chat Room');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_COLOR','text','chat','0','สีของห้องสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_HISTORY','text','chat','0','ประวัติการสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_HISTORY_COMMENT','text','chat','0','ช่วงเวลาที่เก็บข้อความสนทนาไว้ (วัน) ข้อความที่เก่ากว่านี้จะถูกลบออกโดยอัตโนมัติ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_LAW','text','chat','0','กฏการใช้งานห้องสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_LINE_COMMENT','text','chat','0','จำนวนบรรทัดแสดงผลในกรอบสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_SETUP','text','chat','0','ตั้งค่าห้องสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_SOUND','text','chat','0','เปิด-ปิด เสียงเมื่อมีข้อความสนทนา');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_TEXT_TITLE','text','chat','0','กด Enter หรือ คลิก Send เพื่อส่งข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_TIME','text','chat','0','อัปเดทข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_TIME_COMMENT','text','chat','0','ช่วงเวลาการอัปเดทข้อความ (วินาที)');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CHAT_USER_COLOR','text','chat','0','สีประจำตัวสมาชิก');