$(function() {

	$('.buy_product').on('click', function() {
		var id = $(this).val();
		var piece = $('#piece_' + id).val();
		var balance = $(this).closest('tr').data('balance');
		var error = false;

		if ( piece <= 0 || piece > 100 || piece == '' ) {
			swal('Hata!', 'Adet, 1 den küçük ve 100 den büyük olamaz.', 'error');
			error = true;
		}

		if ( !error ) {
			swal({
			    title: "Satın alma işlemi",
			    text: "Önemli! Lütfen satın almadan önce oyunda olduğunuzdan emin olun.\nBu ürün için " + (balance * piece) + " kredi ödüyorsunuz.",
			    type: "warning",
			    showCancelButton: true,
			    confirmButtonColor: "#2185d0",
			    confirmButtonText: "Devam et",
			    cancelButtonText: "İptal",
			    closeOnConfirm: false
			}, function() {
			    $.ajax({
					type: 'POST',
					url: url + '/market/esyalar/buy',
					data: {
						id: id,
						piece: piece,
						_token: token
					},
					success: function(respond) {
						if ( respond.error ) {
							swal("Hata!", respond.error, "error");
						} else {
							swal("Tebrikler!", "Ürün başarıyla alındı.", "success");
						}
					}
				});
			});
		}
	});

	$('.buy_group').on('click', function() {	
		swal({
		    title: "Satın alma işlemi",
		    text: "Bu grup için " + balance + " TL (gerçek para) ödüyorsunuz.",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#2185d0",
		    confirmButtonText: "Devam et",
		    cancelButtonText: "İptal",
		    closeOnConfirm: false
		}, function() {
		    $.ajax({
				type: 'POST',
				url: url + '/market/gruplar/buy',
				data: {
					id: $(this).data('id'),
					_token: token
				},
				success: function(respond) {
					if ( respond.error ) {
						swal("Hata!", respond.error, "error");
					} else {
						swal("Tebrikler!", "Grup başarıyla satın alındı.", "success");
					}
				}
			});
		});
	});

	$('#add_product').on('click', function() {
		var title = $('#product_title input').val();
		var code = $('#product_code input').val();
		var balance = $('#product_balance input').val();
		var fields = ['product_title', 'product_code', 'product_balance'];

		$('#add_product_loading').addClass('active');

		$.ajax({
			type: 'POST',
			url: url + '/product/new/ajax',
			data: {
				title: title,
				code: code,
				balance: balance,
				_token: token
			},
			success: function(respond) {
				$.each(fields, function( index, value ) {
					$('#' + value + ' .ui.input').removeClass('error');
					$('#' + value + ' .error-p').text('');
				});

				if ( respond.errors ) {
					$.each(respond.errors, function( index, value ) {
						$('#product_' + index + ' .ui.input').addClass('error');
						$('#product_' + index + ' .error-p').text(value);
					});
				} else {
					$('.products tbody').prepend('<tr> <td> <img src="assets/images/minecraft-items/' + respond.code + '.png" alt="' + respond.title + '" style="vertical-align: middle; margin-right: 4px;">' + respond.title + '</td> <td style="width: 100px;">' + respond.balance + '</td> <td style="width: 50px;"> <div class="ui input block"> <input type="text" class="input" value="1"> </div> </td> <td style="width: 150px;"> <button type="submit" class="ui block button">Sayfayı Yenileyin</button> </td> </tr>');
					$.each(fields, function( index, value ) {
						$('#' + value + ' .ui.input .input').val('');
					});
					swal("Tamam!", "Yeni ürün listeye eklendi.", "success");
				}

				$('#add_product_loading').removeClass('active');
			}
		});
	});

	$('#add_group').on('click', function() {
		var title = $('#group_title input').val();
		var description = $('#group_description textarea').val();
		var group = $('#group_group input').val();
		var balance = $('#group_balance input').val();
		var game = $('#group_game input:checked').length > 0 ? 1 : 0;
		var fields = ['group_title', 'group_description', 'group_group', 'group_balance'];

		$('#add_group_loading').addClass('active');

		$.ajax({
			type: 'POST',
			url: url + '/group/new/ajax',
			data: {
				title: title,
				description: description,
				group: group,
				balance: balance,
				game: game,
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
					$('.cards').prepend('<div class="card"> <a href="#" class="image"> <img src="storage/image/group/1.jpg"> </a> <div class="content"> <div class="header">' + respond.title + '</div> <div class="description"> <strong>' + respond.title + '</strong> grubu, <strong>' + respond.balance + 'TRY</strong> dir.<hr> <p>' + respond.description + '</p> </div> </div> <a class="ui bottom attached button"> <i class="refresh icon"></i> Sayfayı Yenileyin </a> </div>');
					$.each(fields, function( index, value ) {
						$('#' + value + ' .ui.input .input').val('');
					});
					$('#new_group_form').modal('hide');
					$('#no-group-message').remove();
					swal("Tamam!", "Yeni grup listeye eklendi.", "success");
				}

				$('#add_group_loading').removeClass('active');
			}
		});
	});

	$('#add_group_modal').on('click', function() {
		$('#new_group_form').modal('show');
	});

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
						$(thiss).closest('.comment').find('.child-comments').prepend('<div class="comment"> <img src="' + respond.avatar_25 + '" alt="User Avatar"> <div class="comment-body"> <a class="user-link">' + respond.display_name + '</a> <span class="content">' + body.val() + '</span> </div> <div class="bottom"> <ul class="comment-actions clear-after"> <li>Yorum özellikleri için sayfayı yenileyin.</li> </ul> </div> </div>');
						$(thiss).closest('.comment').find('.show_reply_comments_button').text('Yanıtla (' + respond.comment_count + ')');
					} else {
						$(thiss).closest('.comments').find('.post-comment').after('<div class="comment"> <img src="' + respond.avatar_40 + '" alt="User Avatar"> <div class="comment-body"> <a class="user-link">' + respond.display_name + '</a> <span class="content">' + body.val() + '</span> </div> <div class="bottom"> <ul class="comment-actions clear-after"> <li>Yorum özellikleri için sayfayı yenileyin.</li> </ul> </div> </div>');
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