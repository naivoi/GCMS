/*
 GZoom
 Image Zomm In-Out
 design by http://www.goragod.com (goragod wiriya)
 16-6-55
 */
GZoom = GClass.create();
GZoom.prototype = {
	initialize : function(img, options) {
		this.options = {
			objParent : document.body,
			graphicPath : 'widgets/zoom/img/',
			zoomInCursor : 'zoomin.cur',
			zoomOutCursor : 'zoomout.cur',
			zoomInTitle : 'Click to view large',
			zoomOutTitle : 'Click to close image',
			zoomClass : 'zoom',
			divClass : 'gslide_div',
			divOffset : 15,
			duration : 2,
			speed : 1,
			fitdoc : true
		};
		for (var property in options) {
			this.options[property] = options[property];
		}
		this.id = G_FxZooms.length;
		G_FxZooms[this.id] = this;
		this.options.offset = this.options.divOffset * 2;
		this.thumbnail = $G(img);
		this.width = parseFloat(this.thumbnail.width);
		this.height = parseFloat(this.thumbnail.height);
		var Hinstance = this;
		var temp = new Image();
		temp.src = this.thumbnail.src;
		new preload(temp, function() {
			if (this.width > Hinstance.width) {
				$E(Hinstance.thumbnail).addClass(Hinstance.options.zoomClass);
				Hinstance.orginal_width = this.width;
				Hinstance.orginal_height = this.height;
				var pos = $G(Hinstance.thumbnail).viewportOffset();
				Hinstance.top = pos.top;
				Hinstance.left = pos.left;
				Hinstance.thumbnail.style.cursor = 'url(' + Hinstance.options.graphicPath + Hinstance.options.zoomInCursor + '),pointer';
				Hinstance.thumbnail.onclick = Hinstance.zoomIn.bind(Hinstance);
				Hinstance.thumbnail.title = Hinstance.options.zoomInTitle;
				Hinstance._createZoom();
			}
		});
		var _autoHide = function() {
			for (var i = 0; i < G_FxZooms.length; i++) {
				if ($E(G_FxZooms[i].zoomImg) && G_FxZooms[i].zoomImg.className == 'GZoomShow') {
					G_FxZooms[i].zoomOut();
				}
			}
		};
		var checkESCkey = function (e) {
			if (GEvent.keyCode(e) == 27) {
				_autoHide();
			}
		};
		var doc = $G(document);
		doc.addEvent('keypress', checkESCkey);
		doc.addEvent('keydown', checkESCkey);
		doc.addEvent('click', _autoHide);
	},
	_createZoom : function() {
		this.zoom = $G(document.createElement('div'));
		this.options.objParent.appendChild(this.zoom);
		this.zoom.style.display = 'block';
		this.zoom.style.overflow = 'hidden';
		this.zoom.style.position = 'absolute';
		this.zoom.style.width = this.width + 'px';
		this.zoom.style.height = this.height + 'px';
		this.zoom.style.top = '-10000px';
		this.zoom.style.left = '-10000px';
		this.zoom.className = this.options.divClass;
		this.zoomImg = document.createElement('img');
		this.zoomImg.src = this.thumbnail.src;
		this.zoom.appendChild(this.zoomImg);
	},
	zoomIn : function() {
		var temp = this;
		this.thumbnail.style.visibility = 'hidden';
		this.zoom.style.top = (this.top - this.options.divOffset) + 'px';
		this.zoom.style.left = (this.left - this.options.divOffset) + 'px';
		this.zoom.style.width = this.width + 'px';
		this.zoom.style.height = this.height + 'px';
		this.options.onComplete = function() {
			temp.zoomImg.className = 'GZoomShow';
			temp.zoomImg.style.cursor = 'url(' + this.options.graphicPath + this.options.zoomOutCursor + '),pointer';
			temp.zoomImg.title = temp.options.zoomOutTitle;
			temp.zoomImg.onclick = temp.zoomOut.bind(temp);
		};
		this.options.onResize = function() {
			temp.zoomImg.style.width = this.w + 'px';
			temp.zoomImg.style.height = this.h + 'px';
		};
		new GFxZoom(this.zoom, this.options).play(this.orginal_width, this.orginal_height, null, null);
	},
	zoomOut : function() {
		var temp = this;
		this.options.onComplete = function() {
			temp.zoom.style.left = '-10000px';
			temp.zoom.style.left = '-10000px';
			temp.zoomImg.onclick = null;
			temp.thumbnail.style.visibility = 'visible';
			temp.zoomImg.className = 'GZoomHide';
		};
		this.options.onResize = function() {
			temp.zoomImg.style.width = this.w + 'px';
			temp.zoomImg.style.height = this.h + 'px';
		};
		new GFxZoom(this.zoom, this.options).play(this.width, this.height, this.left, this.top);
	}
};