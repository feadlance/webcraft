$(function() {

	/*
	* Active Tooltip
	*/

	$('[data-toggle="tooltip"]').tooltip();

	/*
	* Mobile Nav
	*/

	$('#mobileMenu').on('click', function(e) {
		e.stopPropagation();

		$('nav').css('right', 0);
		$('body').addClass('dark');
	});

	$('nav').on('click', function(e) {
		e.stopPropagation();
	});

	$(window).on('click', function() {
		$('nav').css('right', -300);
		$('body').removeClass('dark');
	});

	/*
	* Selected Comment
	*/

	setTimeout(function() {
		$('#statuses .status-item > .status-comments .comment-item.selected').delay(2000).css('background', 'transparent');
	}, 1000);

	/*
	* Turkish Character
	*/

	function getStyle(element, style) {
		var result;

		if (document.defaultView && document.defaultView.getComputedStyle) {
			result = document.defaultView.getComputedStyle(element, '').getPropertyValue(style);
		} else if(element.currentStyle) {
			style = style.replace(/\-(\w)/g, function (strMatch, p1) {
				return p1.toUpperCase();
			});
			result = element.currentStyle[style];
		}
		return result;
	}

	function replaceRecursive(element) {
		if (element && element.style && getStyle(element, 'text-transform') == 'uppercase') {
			element.innerHTML = element.innerHTML.replace(/ı/g, 'I');
			element.innerHTML = element.innerHTML.replace(/i/g, 'İ');
		}

		if (!element.childNodes || element.childNodes.length == 0) return;

		for (var n in element.childNodes) {
			replaceRecursive(element.childNodes[n]);
		}
	}

	window.onload = function() {
		replaceRecursive(document.getElementsByTagName('body')[0]);
	}

});