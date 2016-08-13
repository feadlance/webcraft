$(function() {

	/*
	* Search Form
	*/

	$('#open-search-form').on('click', function() {
		$('header .container .page-title, .header .container .user-control, .header .container #open-search-form').hide();
		$('header .container .search-form').show();
	});

	$('#close-search-form').on('click', function() {
		$('header .container .page-title, .header .container .user-control, .header .container #open-search-form').show();
		$('header .container .search-form').hide();
	});

	/*
	* Post Comments
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
	* Fix Navigation
	*/

	$(window).on('load scroll', function() {
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
	});

});