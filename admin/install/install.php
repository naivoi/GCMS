<?php
	if (INSTALL_INIT == 'install') {
		echo '<form method=post action=index.php autocomplete=off>';
		echo '<h2>ยินดีต้อนรับสู่การติดตั้ง GCMS เวอร์ชั่น '.$version.'</h2>';
		echo '<p><em>เราไม่พบไฟล์ config.php บนระบบ หรือไฟล์ config.php ของคุณอาจไม่ถูกต้อง</em> ซึ่งอาจเป็นไปได้ว่าคุณเพิ่งติดตั้ง GCMS เป็นครั้งแรก</p>';
		echo '<p>คุณสามารถเริ่มต้นติดตั้ง GCMS ได้ง่ายๆโดยการตอบคำถามไม่กี่ข้อ เพื่อที่คุณจะได้เป็นเจ้าของ Ajax CMS ที่สมบูรณ์แบบ ที่สร้างสรรค์โดยคนไทยทั้งระบบ</p>';
		echo '<p>ก่อนอื่น คุณต้องเลือกประเภทของเว็บไซต์ที่คุณต้องการติดตั้ง (เว็บไซต์ทั้งสองแบบเหมือนกันทุกประการ แต่เว็บไซต์โรงเรียนจะมีการติดตั้งโมดูลและข้อมูลตัวอย่างเพิ่มเติมจากเว็บไซต์ปกติ ซึ่งคุณสามารถแก้ไขได้เองในภายหลัง)</p>';
		echo '<p><select name=typ>';
		foreach ($database_typies AS $k => $v) {
			echo '<option value='.$k.($_SESSION['typ'] == $k ? ' selected' : '').'>'.$v.'</option>';
		}
		echo '</select></p>';
		echo '<input type=hidden name=step value=1>';
		echo '<p><input class=button type=submit value="ติดตั้ง !"></p>';
		echo '</form>';
	}
