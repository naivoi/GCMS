// widgets/tags/admin.js
var doTagsSubmit = function (xhr) {
	var prop, val, el, tag;
	var datas = xhr.responseText.toJSON();
	if (datas) {
		for (prop in datas[0]) {
			val = datas[0][prop];
			if (prop == 'error') {
				alert(eval(val));
			} else if (prop == 'alert') {
				alert(decodeURIComponent(val));
			} else if (prop == 'input') {
				$G(val).highlight().focus();
			} else if (prop == 'content') {
				// เพิ่มข้อมูลใหม่
				var tbody = $E('member').getElementsByTagName('tbody')[0];
				var trs = tbody.getElementsByTagName('tr');
				// insert
				$G(tbody).insertBefore(decodeURIComponent(val).toDOM(), trs[0]);
				// re inint
				inintCheck('member');
				inintTR('member', /L_[0-9]+/);
				inintList("member", "a", /edit_[0-9]+/, '../widgets/tags/admin_action.php', doFormSubmit);
				// เคลียร์ form
				tagsReset();
				// highlight
				$G('L_' + datas[0].id).highlight();
			} else if (prop == 'tags_tag') {
				var tr = $E('L_' + datas[0].id);
				if (tr) {
					var tds = tr.getElementsByTagName('td');
					var as = tr.getElementsByTagName('a');
					as[0].innerHTML = decodeURIComponent(val);
					// highlight
					tr.highlight();
				}
				// เคลียร์ form
				tagsReset();
			}
		}
	} else if (xhr.responseText != '') {
		alert(xhr.responseText);
	}
};
var tagsReset = function (e) {
	$E('tags_id').value = 0;
	$E('tags_tag').value = '';
};