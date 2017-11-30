//
//	e.js
//	A simple library full of functions that I find useful
//	Also a sort-of replacement for jquery
//	(please don't use them together or bad things will happen)
//
(function(window, undefined) {
	// Handle DOMContentLoaded event
	// ...
	var $ = function($selector) {
		return new elib($selector);
	};
	var elib = function($selector) {
		var dom = document.querySelectorAll($selector);
		this.length = dom.length;
		for (let i = 0; i < this.length; i++) {
			this[i] = dom[i];
		}
	};
	$.fn = elib.prototype = {
		each: function($callback) {
			for (var i = 0; i < this.length; i++) {
				$callback.call(this[i], this, i);
			}
			return this;
		},
		hide: function() {
			this.each(function() {
				this.style.display = "none";
			});
			return this;
		},
		show: function() {
			this.each(function() {
				this.style.display = 'block';
			});
			return this;
		},
		fadeOut: function($timeout) {
			this.each(function() {
				$timeout = $timeout || 400;
				let el = this;
				el.style.display = "inherit";
				el.style.opacity = 1;
				let last = +new Date();
				let tick = () => {
					el.style.opacity = +el.style.opacity - (new Date() - last) / $timeout;
					last = +new Date();
					if (+el.style.opacity > 0) {
						(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
					} else {
						el.style.display = "none";
					}
				};
				tick();
			});
			return this;
		},
		fadeIn: function($timeout) {
			this.each(function() {
				$timeout = $timeout || 400;
				let el = this;
				el.style.display = "inherit";
				el.style.opacity = 0;
				let last = +new Date();
				let tick = () => {
					el.style.opacity = +el.style.opacity + (new Date() - last) / $timeout;
					last = +new Date();
					if (+el.style.opacity < 1) {
						(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
					}
				};
				tick();
			});
			return this;
		},
		val: function() {
			var len = this.length;
			return this[--len].value;
		},
		html: function($value) {
			if ($value) {
				this.each(function() {
					this.innerHTML = $value;
				});
				return this;
			} else {
				var len = this.length;
				return this[--len].innerHTML;
			}
		},
		attr: function($attributename, $attributevalue) {
			this.each(function() {
				this.setAttribute($attributename, $attributevalue);
			});
			return this;
		},
		css: function($styles) {
			if ($styles) {
				this.each(function() {
					for (const property in $styles) {
						this.style[property] = $styles[property];
					}
				});
				return this;
			} else {
				var len = this.length;
				return this[--len].style;
			}
		},
		on: function($event, $callback) {
			this.each(function() {
				this.addEventListener($event, $callback, false)
			});
			return this;
		},
		click: function($callback) {
			this.each(function() {
				this.addEventListener("click", $callback, false)
			});
			return this;
		},
		change: function($callback) {
			this.each(function() {
				this.addEventListener("change", $callback, false)
			});
			return this;
		}
	};
	window.$ = $;
})(window);

function Get($url, $method, $callback, $json) {
	$json = $json || false;
	let xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if ($json) {
				$callback(JSON.parse(this.responseText));
			} else {
				$callback(this.responseText);
			}
		}
	}
	xmlhttp.open($method, $url, true);
	xmlhttp.send();
}
