/*
 Shout Box System
 27 มิย. 56
 */
var GShoutBox = GClass.create();
GShoutBox.prototype = {
	initialize : function(o) {
		var shoutbox_time = 0;
		var shoutbox_interval = o.interval || 3;
		var shoutbox_lines = o.lines || 10;
		var shoutbox_smiles = new Array();
		var shoutbox_id = 0;
		var shoutbox_text = '';
		var autohide = 0;
		var content = $E('shoutbox_list');
		var text = $E('shoutbox_txt');
		var sender = $E('shoutbox_sender');
		var _onmouseout = function() {
			autohide = window.setTimeout(function() {
				$E('shoutbox_emoticon').style.display = 'none';
			}, 300);
		};
		var _onmouseover = function() {
			if (autohide > 0) {
				window.clearTimeout(autohide);
				autohide = 0;
			}
			$E('shoutbox_emoticon').style.display = 'block';
		};
		forEach($E('shoutbox_div').getElementsByTagName('img'), function() {
			var tag = this.tagName.toLowerCase();
			var c = this.className;
			if (tag == 'img' && this.alt == 'emoticon') {
				this.style.cursor = 'pointer';
				$G(this).addEvent('mouseover', _onmouseover).addEvent('mouseout', _onmouseout);
			} else if (tag == 'img') {
				shoutbox_smiles.push(new RegExp(':(' + this.alt + '):', 'g'));
				callClick(this, function() {
					var txt = $E('shoutbox_txt');
					txt.value = txt.value + ':' + this.alt + ':';
					txt.focus();
				});
			}
		});
		$G('shoutbox_emoticon').addEvent('mouseover', _onmouseover).addEvent('mouseout', _onmouseout);
		function limitContent() {
			for (var i = content.childNodes.length - shoutbox_lines - 1; i >= 0; i--) {
				content.removeChild(content.childNodes[i]);
			};
		}
		function entityify(s) {
			return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
		}
		var row = '';
		function addMessage(time, name, text) {
			shoutbox_id = time;
			// link http(s),fttp,file
			text = text.replace(/(^|\s)((http(s)?|ftp|file):\/\/([^\s<>\"\']+))/gim, '$1<a href="$2" target="_blank">$2</a>');
			// www.
			text = text.replace(/(^|\s)(www([^\s<>\"\']+))/gim, '$1<a href="http://$2" target="_blank">$2</a>');
			// smile
			for (var i = 0; i < shoutbox_smiles.length; i++) {
				text = text.replace(shoutbox_smiles[i], '<img src="' + WEB_URL + 'widgets/shoutbox/smile/$1.gif" alt="$1" />');
			}
			// ข้อความ
			row = row == 'bg1' ? 'bg2' : 'bg1';
			var result = '<dd class="' + row + '" id="shoutbox_' + time + '"><p class="head">';
			result += '<span class="sender cuttext">' + name + '</span>';
			result += '<span class="time">' + mktimeToDate(time).dateFormat('d M H:I') + '</span></p>';
			result += '<p class="detail">' + text + '</p></dd>';
			content.appendChild(result.toDOM());
		}
		var _doSend = function() {
			if (text.value != '' && text.value != shoutbox_text && sender.value != '') {
				shoutbox_text = text.value;
				addMessage(shoutbox_time, entityify(sender.value), entityify(shoutbox_text));
				var q = 'val=' + encodeURIComponent(shoutbox_text);
				q += '&sender=' + encodeURIComponent(sender.value);
				q += '&time=' + shoutbox_time;
				new GAjax().send(WEB_URL + 'widgets/shoutbox/send.php', q, emptyFunction);
				text.value = '';
				content.scrollTop = content.scrollHeight;
				text.focus();
			}
			return false;
		};
		$E('shoutbox_frm').onsubmit = _doSend;
		var _getChat = function() {
			return 'id=' + shoutbox_id;
		};
		new GAjax().autoupdate(WEB_URL + 'widgets/shoutbox/chat.php', shoutbox_interval, _getChat, function(xhr) {
			var ds = xhr.responseText.toJSON();
			if (ds) {
				if (ds[0]['user']) {
					sender.value = ds[0]['user'];
				}
				if (ds[0]['time']) {
					shoutbox_time = ds[0]['time'].toInt();
				}
				if (ds[0]['id']) {
					shoutbox_id = ds[0]['id'].toInt();
				}
				if (ds[0]['content']) {
					var hs = decodeURIComponent(ds[0]['content']).split(/\n/g);
					for (var i = hs.length - 1; i >= 0; i--) {
						var ds = hs[i].split(/\t/g);
						addMessage(ds[2], ds[1], ds[0]);
					}
					limitContent();
					content.scrollTop = content.scrollHeight;
				}
			} else if (xhr.responseText != '') {
				alert(xhr.responseText);
			}
		});
		// time
		window.setInterval(function () {
			shoutbox_time++;
		}, 1000);
	}
};