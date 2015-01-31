<?php die('File not found !')?>
DELETE FROM `{prefix}_language` WHERE `owner`='twitter';
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_BORDER_COLOR','text','twitter','0','สีกรอบ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER','text','twitter','0','ทวิตเตอร์');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_BORDER_COLOR_COMMENT','text','twitter','0','สีของกรอบของกล่องข้อความทวิตเตอร์');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_DETAILS','text','twitter','0','บัญชีทวิตเตอร์ที่ต้องการแสดงผล');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_ID','text','twitter','0','ทวิตเตอร์ไอดี');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_ID_COMMENT','text','twitter','0','เลขรหัสวิดเจ็ทของทวิตเตอร์ สามารถหาได้จาก Addressbar โดยเข้าไปที่การตั้งค่าวิดเจ็ท เช่น https://twitter.com/settings/widgets/<em>348368123554062336</em>/edit');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_LINK_COLOR_COMMENT','text','twitter','0','สีของลิงค์ภายในกล่องข้อความ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_NAME','text','twitter','0','ชื่อทวิตเตอร์');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_NAME_COMMENT','text','twitter','0','ระบุชื่อทวิตเตอร์ โดยเข้าเว็บไซต์และไปที่ Profile ของคุณในช่อง Address Bar จะปรากฏชื่อบัญชีทวิตเตอร์ของคุณ เช่น https://twitter.com/<em>goragod</em>');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_QUANTITY_COMMENT','text','twitter','0','กำหนดจำนวนข้อความสูงสุดที่ต้องการแสดงผล (กำหนดเป็น 0 จะแสดงผลแบบมี Scrollbar)');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_SIZE_COMMENT','text','twitter','0','ขนาดของกรอบแสดงผลทวิตเตอร์ที่ต้องการ');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_STYLE','text','twitter','0','รูปแบบของกล่องข้อความทวิตเตอร์');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_THEME','text','twitter','0','ธีม');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_TWITTER_THEME_COMMENT','text','twitter','0','รูปแบบเริ่มต้นของกล่องข้อความทวิตเตอร์');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('TWITTER_THEMES','array','twitter','0','a:2:{s:5:"light";s:15:"สว่าง";s:4:"dark";s:9:"มืด";}');