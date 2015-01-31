<?php die('File not found !')?>
define("DB_TAGS", PREFIX."_tags");
DROP TABLE IF EXISTS `{prefix}_tags`;
CREATE TABLE IF NOT EXISTS `{prefix}_tags` (`id` int(11) NOT NULL auto_increment,`tag` text collate utf8_unicode_ci NOT NULL,`count` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
INSERT INTO `{prefix}_tags` (`tag`, `count`) VALUES ('GCMS','1');
DELETE FROM `{prefix}_language` WHERE `owner`='tags';
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_CLICK','text','tags','0','คลิก');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TAGS_EMPTY','text','tags','0','กรุณากรอกป้ายกำกับที่ต้องการ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TAGS_EXISTS','text','tags','0','มีป้ายกำกับนี้อยู่แล้ว กรุณาเปลี่ยนเป็นชื่ออื่น');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TAGS_NOT_FOUND','text','tags','0','ไม่พบป้ายกำกับที่ต้องการ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TAGS_TEXT_COMMENT','text','tags','0','ระบุป้ายกำกับที่ต้องการ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TAGS_TITLE','text','tags','0','สร้าง - แก้ไข ป้ายกำกับของเรื่อง (ในโมดูล document)');