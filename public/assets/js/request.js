$(function() {

	/*
	* Friends
	*/

	$('#add_friend').on('click', function() {
		if ( !$(this).attr('clicked') ) {
			$(this).html('<i style="margin: 0 25px;" class="fa fa-circle-o-notch fa-spin"></i>').attr('clicked', true).css('cursor', 'text');

			$.ajax({
				type: 'PUT',
				url: url + '/oyuncu/' + player + '/add',
				data: {
					_token: token
				},
				success: function(respond) {
					if ( respond.error ) {
						swal("Hata!", respond.error, "error");
					} else {
						$('#add_friend').html('<i class="fa fa-check" style="margin-right: 5px;"></i> İstek gönderildi').addClass('blue').removeClass('red');
					}
				}
			});
		}
	});

	$('#accept_friend').on('click', function() {
		if ( !$(this).attr('clicked') ) {
			$(this).html('<i style="margin: 0 25px;" class="fa fa-circle-o-notch fa-spin"></i>').attr('clicked', true).css('cursor', 'text');

			$.ajax({
				type: 'PUT',
				url: url + '/oyuncu/' + player + '/accept',
				data: {
					_token: token
				},
				success: function(respond) {
					if ( respond.error ) {
						swal("Hata!", respond.error, "error");
					} else {
						$('#accept_friend').html('<i class="fa fa-check" style="margin-right: 5px;"></i> Kabul edildi').addClass('green').removeClass('yellow');
					}
				}
			});
		}
	});

	$('#delete_friend').on('click', function() {
		if ( !$(this).attr('clicked') ) {
			$(this).html('<i style="margin: 0 25px;" class="fa fa-circle-o-notch fa-spin"></i>').attr('clicked', true).css('cursor', 'text');

			$.ajax({
				type: 'PUT',
				url: url + '/oyuncu/' + player + '/delete',
				data: {
					_token: token
				},
				success: function(respond) {
					if ( respond.error ) {
						swal("Hata!", respond.error, "error");
					} else {
						$('#delete_friend').html('<i class="fa fa-check" style="margin-right: 5px;"></i> Arkadaşlıktan çıkartıldı').addClass('green').removeClass('red');
					}
				}
			});
		}
	});

	/*
	* Upgrade Groups
	*/

	$('.new-group-feature').on('submit', function () {
		var form = this;

		$.ajax({
			type: 'POST',
			url: url + '/group/new-feature',
			data: {
				id: $(this).data('id'),
				body: $(this).find('input').val(),
				_token: token
			},
			success: function(respond) {
				if ( respond.error ) {
					swal("Hata!", respond.error, "error");
				} else if (respond.validations) {
					if ( respond.validations.id ) {
						swal("Hata!", respond.validations.id, "error");
					} else if ( respond.validations.body ) {
						swal("Hata!", respond.validations.body, "error");
					}
				} else {
					$(form).find('input').val('');
					$(form).closest('.card').find('.custom-extra').append('<div class="extra content text-center" style="color: #616161;">' + respond.body + '</div>');
					$(form).closest('.card').find('.no-feature').remove();
				}
			}
		});

		return false;
	});

	$('#new_group').on('click', function () {
		$('#form_new_group').modal('show');
	});

	$('#form_new_group').on('submit', function () {
		var form = this;
		var title = $('#group_title input').val();
		var group = $('#group_group input').val();
		var money = $('#group_money input').val();
		var fields = ['group_title', 'group_group', 'group_money'];

		$(this).find('.loading-panel').addClass('active');

		$.ajax({
			type: 'POST',
			url: url + '/group/new',
			data: {
				title: title,
				group: group,
				money: money,
				_token: token
			},
			success: function(respond) {
				$.each(fields, function( index, value ) {
					$('#' + value).removeClass('error');
					$('#' + value + ' .error-p').text('');
				});

				if ( respond.errors ) {
					$.each(respond.errors, function( index, value ) {
						$('#group_' + index).addClass('error');
						$('#group_' + index + ' .error-p').text(value);
					});
				} else {
					$('.cards').append('<div class="card" style="float: left;"> <div class="content"> <div class="header titillium regular uppercase text-center" style="font-size: 20px;">' + title + '</div> </div> <div class="extra content text-center no-feature" style="color: #616161;"> Bu grubun hiç özelliği yok. </div> <div class="ui bottom attached button"> <i class="fa fa-shopping-cart" style="margin-right: 5px;"></i> Sayfayı Yenileyin </div> </div>');
					$.each(fields, function( index, value ) {
						$('#' + value + ' .ui.input .input').val('');
					});
					$('#form_new_group').modal('hide');
					$('#no-group-message').remove();
					swal("Tamam!", "Yeni grup listeye eklendi.", "success");
				}

				$(form).find('.loading-panel').removeClass('active');
			}
		});

		return false;
	});

});

var signIn = function (that) {

	var fields = ['username', 'password'];

	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/signin',
		data: {
			username: $(that).find('#username').val(),
			password: $(that).find('#password').val(),
			_token: token
		},
		success: function(respond) {
			$.each(fields, function( index, value ) {
				$('#' + value + '_group').removeClass('has-error');
				$('#' + value + '_group .help-block').text('');
			});

			$('#login-form-error').removeClass('active');

			if ( respond.error ) {
				$('#login-form-error').addClass('active').text(respond.error);
			} else if ( respond.validations ) {
				$.each(respond.validations, function( index, value ) {
					$('#' + index + '_group').addClass('has-error');
					$('#' + index + '_group .help-block').text(value);
				});
			} else {
				$('#login-form-error').addClass('active').css('background', '#21BA45').html('<i class="fa fa-check"></i>');
				$(that).addClass('loading-ok');
				window.location.href = url;
			}

			$(that).removeClass('loading');
		}
	});

	return false;

};

var signUp = function (that) {

	var fields = ['register_email', 'register_username', 'register_password'];

	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/signup',
		data: {
			register_username: $(that).find('#register_username').val(),
			register_email: $(that).find('#register_email').val(),
			register_password: $(that).find('#register_password').val(),
			_token: token
		},
		success: function(respond) {
			$.each(fields, function( index, value ) {
				$('#' + value + '_group').removeClass('has-error');
				$('#' + value + '_group .help-block').text('');
			});

			$('#register-form-error').removeClass('active');

			if ( respond.error ) {
				$('#register-form-error').addClass('active').text(respond.error);
			} else if ( respond.validations ) {
				$.each(respond.validations, function( index, value ) {
					$('#' + index + '_group').addClass('has-error');
					$('#' + index + '_group .help-block').text(value);
				});
			} else {
				$('#register-form-error').addClass('active').css('background', '#21BA45').html('<i class="fa fa-check"></i>');
				$(that).addClass('loading-ok');
				window.location.href = url;
			}

			$(that).removeClass('loading');
		}
	});

	return false;

};

var postComment = function (that, id, type) {

	/* Resource */
	var body = $(that).find('input');

	/* Start Loading */
	$(that).closest('.status-post-comment').addClass('loading');

	/* Start Ajax */
	$.ajax({
		type: 'POST',
		url: url + '/status/comment',
		data: {
			id: id,
			body: body.val(),
			type: type,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal('Hata!', respond.error, 'error');
			} else {
				body.val('');

				if ( type === 'status' ) {
					$(that).closest('.status-item').find('.status-comment-counter').text(respond.count);
					var comment_field = $(that).closest('.status-item').find('.status-comments');
				} else {
					$(that).closest('.content').find('.comment-reply-counter').text('(' + respond.count + ')');
					var comment_field = $(that).closest('.content').find('.sub-comments');
				}

				$(comment_field).prepend('<div class="comment-item"> <div class="avatar"> <img src="' + respond.avatar + '" alt="User Avatar"> </div> <div class="content"> <div class="comment"> <a href="' + respond.profile_link + '"> <strong>' + respond.display_name + '</strong> </a> <span>' + respond.body + '</span> </div> <ul class="meta clearfix"> <li> <i class="fa fa-refresh"></i> Tüm özellikleri için sayfayı yenileyin </li> <li>' + respond.created_at + '</li> </ul> </div> </div>');
			}

			/* Stop Loading */
			$(that).closest('.status-post-comment').removeClass('loading');
		}
	});

	return false;

};

var likeStatus = function (that, id) {
	
	$(that).html('<i class="fa fa-circle-o-notch fa-spin"></i> Beğen').addClass('loading');

	/* Start Ajax */
	$.ajax({
		type: 'POST',
		url: url + '/status/like',
		data: {
			id: id,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal('Hata!', respond.error, 'error');
				$(that).html('<i class="fa fa-thumbs-up"></i> Beğen');
			} else {
				if ( respond.liked ) {
					$(that).html('<i class="fa fa-thumbs-up"></i> Beğen').addClass('liked');
				} else {
					$(that).html('<i class="fa fa-thumbs-up"></i> Beğen').removeClass('liked');
				}

				$(that).closest('.status-item').find('.status-like-counter').text(respond.count);
			}

			$(that).removeClass('loading');
		}
	});

	return false;

};

var likeComment = function (that, id) {
	
	$(that).html('<i class="fa fa-circle-o-notch fa-spin"></i>');

	/* Start Ajax */
	$.ajax({
		type: 'POST',
		url: url + '/status/comment/like',
		data: {
			id: id,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal('Hata!', respond.error, 'error');
				$(that).text('Beğen');
			} else {
				if ( respond.liked ) {
					$(that).text('Beğenmekten Vazgeç');
				} else {
					$(that).text('Beğen');

					if ( respond.count == 0 ) {
						$(that).closest('.meta').find('.action-comment-like-counter').remove();
					}
				}

				if ( $(that).closest('.meta').find('.action-comment-like-counter').length ) {
					$(that).closest('.meta').find('.action-comment-like-counter > span').text(respond.count);
				} else {
					if ( respond.count > 0 ) {
						$(that).closest('.meta').find('.action-ago').before('<li class="action-comment-like-counter"> <i class="fa fa-thumbs-up"></i> <span>' + respond.count + '</span> </li>');
					}
				}
			}
		}
	});

	return false;

};

var showComments = function (that) {
	$(that).closest('.status-item').find('.status-comments, .status-post-comment:first').toggle();
	return false;
};

var showCommentReplies = function (that) {
	$(that).closest('.content').find('.sub-comments, .status-post-comment').toggle();
	return false;
};