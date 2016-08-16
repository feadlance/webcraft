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
	* Status
	*/

	$('#submit_status').on('click', function() {
		var body = $('#status_body');
		$('#add_status_loading').addClass('active');

		$.ajax({
			type: 'POST',
			url: url + '/status',
			data: {
				body: body.val(),
				player: player,
				_token: token
			},
			success: function(respond) {
				if ( respond.error ) {
					swal("Hata!", respond.error, "error");
				} else {
					$('.posts').prepend('<div class="item ui"> <div class="header"> <div class="avatar"> <img src="' + respond.avatar + '" alt="User Avatar"> </div> <div class="title"> <a href="javascript:;">' + respond.display_name + '</a> </div> <div class="extra"> ' + respond.created_at + '</div> </div> <div class="content"> <p>' + respond.body + '</p> <div class="show_comments_button info"> <span>Tüm işlemler için sayfayı yenileyin.</span> </div> </div> </div>');
					body.val('');
				}

				$('#add_status_loading').removeClass('active');
			}
		});
	});

	$('.delete-post').on('click', function() {
		var thiss = this;

		swal({
		    title: "Bir post siliyorsunuz...",
		    text: "Bu postu silmek istiyor musunuz?",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#2185d0",
		    confirmButtonText: "Evet",
		    cancelButtonText: "Hayır",
		    closeOnConfirm: false
		}, function() {
		    $.ajax({
				type: 'PUT',
				url: url + '/status/' + $(thiss).closest('.ui.item').data('id') + '/delete',
				data: {
					_token: token
				},
				success: function(respond) {
					if ( respond.error ) {
						swal("Hata!", respond.error, "error");
					} else {
						swal("Bitti!", "Post başarıyla silindi.", "success")
						$(thiss).closest('.ui.item').remove();
					}
				}
			});
		});

		return false;
	});

	$('.likeable').on('click', function() {
		var thiss = this;
		var type = $(this).closest('.comments').data('type');

		if ( type == 'comment' ) {
			var likeable_new_url = '/comment/' + $(this).closest('.comment').data('id') + '/like';
			$(this).html('<i class="fa fa-circle-o-notch fa-spin"></i>').parent().find('.loading-panel').addClass('active');
		} else {
			var likeable_new_url = '/status/' + $(this).closest('.ui.item').data('id') + '/like';
			$(this).html('<i class="fa fa-circle-o-notch fa-spin"></i> Beğen').parent().find('.loading-panel').addClass('active');
		}

		$.ajax({
			type: 'PUT',
			url: url + likeable_new_url,
			data: {
				_token: token
			},
			success: function(respond) {
				if ( respond.error ) {
					swal("Hata!", respond.error, "error");
				} else {
					if ( type == 'comment' ) {
						if ( respond.liked ) {
							$(thiss).text('Beğenmekten Vazgeç');
						} else {
							$(thiss).text('Beğen');
						}

						$(thiss).closest('.comment-actions').find('.comment-likes').attr('data-likes', respond.like_count);
						$(thiss).closest('.comment-actions').find('.comment-likes span').text(respond.like_count);
					} else {
						if ( respond.liked ) {
							$(thiss).addClass('liked');
						} else {
							$(thiss).removeClass('liked');
						}

						$(thiss).html('<i class="fa fa-thumbs-up"></i> Beğen').parent().find('.loading-panel').removeClass('active');
						$(thiss).closest('.ui.item').find('.like-counter').text(respond.like_count);
					}
				}
			}
		});

		return false;
	});

	$('.post-comment, .post-comment-reply').on('submit', function() {
    	var thiss = this;
    	var body = $(this).find('.post-comment-text');
    	var reply = $(this).data('type') === 'reply' ? true : false;

    	if ( reply === true ) {
    		$(thiss).closest('.comment').find('.loading-reply.loading-panel').addClass('active');
    		var id = $(this).closest('.comment').data('id');
    	} else {
    		$(thiss).closest('.ui.item').find('.loading-comment.loading-panel').addClass('active');
    		var id = $(this).closest('.ui.item').data('id');
    	}

	    $.ajax({
			type: 'PUT',
			url: url + '/status/' + id + '/comment',
			data: {
				body: body.val(),
				reply: reply,
				_token: token
			},
			success: function(respond) {
				if ( respond.error ) {
					swal("Hata!", respond.error, "error");
				} else {
					if ( reply ) {
						$(thiss).closest('.comment').find('.child-comments').prepend('<div class="comment"> <img src="' + respond.avatar_25 + '" alt="User Avatar"> <div class="comment-body"> <a class="user-link">' + respond.display_name + '</a> <span class="content">' + body.val() + '</span> </div> <div class="bottom"> <ul class="comment-actions clearfix"> <li>Yorum özellikleri için sayfayı yenileyin.</li> </ul> </div> </div>');
						$(thiss).closest('.comment').find('.show_reply_comments_button').text('Yanıtla (' + respond.comment_count + ')');
					} else {
						$(thiss).closest('.comments').find('.post-comment').after('<div class="comment"> <img src="' + respond.avatar_40 + '" alt="User Avatar"> <div class="comment-body"> <a class="user-link">' + respond.display_name + '</a> <span class="content">' + body.val() + '</span> </div> <div class="bottom"> <ul class="comment-actions clearfix"> <li>Yorum özellikleri için sayfayı yenileyin.</li> </ul> </div> </div>');
						$(thiss).closest('.ui.item').find('.comment-counter').text(respond.comment_count);
					}

					$(body).val('');
				}

				if ( reply ) {
					$(thiss).closest('.comment').find('.loading-reply.loading-panel').removeClass('active');
				} else {
					$(thiss).closest('.ui.item').find('.loading-comment.loading-panel').removeClass('active');
				}
			}
		});

		return false;
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

	/*
	* Auth
	*/

	$('#signin_submit').on('click', function() {
		var fields = ['username', 'password'];
		$('#login_form').addClass('loading');

		$.ajax({
			type: 'POST',
			url: url + '/signin',
			data: {
				username: $(this).parent().find('#username').val(),
				password: $(this).parent().find('#password').val(),
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
					$('#login_form').addClass('loading-ok');
					window.location.href = url;
				}

				$('#login_form').removeClass('loading');
			}
		});
	});

	$('#signup_submit').on('click', function() {
		var fields = ['register_email', 'register_username', 'register_password'];
		$('#register_form').addClass('loading');

		$.ajax({
			type: 'POST',
			url: url + '/signup',
			data: {
				register_username: $(this).parent().find('#register_username').val(),
				register_email: $(this).parent().find('#register_email').val(),
				register_password: $(this).parent().find('#register_password').val(),
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
					$('#register_form').addClass('loading-ok');
					window.location.href = url;
				}

				$('#register_form').removeClass('loading');
			}
		});
	});

});