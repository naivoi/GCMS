<?php die('File not found !')?>
DELETE FROM `{prefix}_language` WHERE `owner`='facebook';
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('FACEBOOK_INVALID_USERNAME','text','facebook','1','Username ของเฟซบุคไม่ถูกต้อง');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_LIKE_BOX','text','facebook','0','Facebook Page');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_SETTINGS','text','facebook','0','ตั้งค่าการทำงานของ Facebook Page');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_SHOW_FACES','text','facebook','0','รายชื่อเพื่อน');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_SHOW_HEADER','text','facebook','0','ภาพปก');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_SHOW_STREAM','text','facebook','0','โพสต์จาก Timeline');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_SIZE_COMMENT','text','facebook','0','ตั้งค่าขนาดการแสดงผลของกรอบ Facebook Page (สูงไม่น้อยกว่า 130 พิกเซล, กว้าง 280 ถึง 500 พิกเซล)');
INSERT INTO `{prefix}_language` (`key`, `type`, `owner`, `js`, `th`) VALUES ('LNG_FACEBOOK_USER_COMMENT','text','facebook','0','Username ของเฟซบุคของคุณ เช่น http://www.facebook.com/<em>username</em>');