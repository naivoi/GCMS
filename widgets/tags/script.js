// widgets/tags/script.js
function inintTags(id, skin) {
	var patt = /tags-([0-9]+)/;
	forEach($E(id).getElementsByTagName('a'), function (item) {
		if (patt.exec(item.id)) {
			$G(item).addEvent('mouseover', function () {
				mTooltipShow(this.id, WEB_URL + 'widgets/tags/view.php', this);
			});
			$G(item).addEvent('click', function () {
				send(WEB_URL + 'widgets/tags/action.php', 'id=' + this.id);
			});
		}
	});
}