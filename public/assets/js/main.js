$(function() {

	/*
	* Status Comments
	*/

	$('.show_comments_button').on('click', function() {
		$(this).closest('.ui.item').find('.comments').toggle();
	});

	$('.show_reply_comments_button').on('click', function() {
		$(this).closest('.comment').find('.child-comments').toggle();
		$(this).closest('.bottom').find('.post-comment-reply').toggle();
		return false;
	});

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
			element.innerHTML = element.innerHTML.replace(/i/g, 'İ');    // replaces 'i' in tags too, regular expression should be extended if necessary
		}

		if (!element.childNodes || element.childNodes.length == 0) return;

		for (var n in element.childNodes) {
			replaceRecursive(element.childNodes[n]);
		}
	}

	window.onload = function() {    // as appropriate 'ondomready'
		replaceRecursive(document.getElementsByTagName('body')[0]);
	}

	/*
	* Fix Navigation
	*/

	/*$(window).on('load scroll', function() {
		var st = $(this).scrollTop();

		if (st > 100) {
			$('.breadcrumb').css({
				position: 'fixed',
				top: 0
			});

			$('nav').css({
				position: 'fixed',
				'margin-top': 0
			});
		} else {
			$('.breadcrumb').css({
				position: 'absolute',
				top: 100
			});

			$('nav').css({
				position: 'absolute',
				'margin-top': 100
			});
		}
	});*/

});