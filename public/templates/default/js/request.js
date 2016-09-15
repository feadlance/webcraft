/*
* Auth
*/

var signIn = function (that) {

	var fields = ['username', 'password'];
	var data = $('.form-bottom').serialize() + '&_token=' + token;

	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/signin',
		data: data,
		success: function(respond) {
			$.each(fields, function( index, value ) {
				$('#' + value + '_group').removeClass('has-danger');
				$('#' + value + '_group input').removeClass('form-control-danger');
				$('#' + value + '_group .form-control-feedback').text('');
			});

			$('#login-form-error').removeClass('active');

			if ( respond.error ) {
				$('#login-form-error').addClass('active').text(respond.error);
			} else if ( respond.validations ) {
				$.each(respond.validations, function( index, value ) {
					$('#' + index + '_group').addClass('has-danger');
					$('#' + index + '_group input').addClass('form-control-danger');
					$('#' + index + '_group .form-control-feedback').text(value);
				});
			} else if ( respond.email_field ) {
				if ( !$('#email_group').length ) {
					$('#password_group').after('<div id="email_group" class="form-group"> <label class="sr-only" for="email">Hesabınızın bir e-postası olmalı</label> <input type="text" placeholder="e-Posta..." class="form-email form-control" name="email" id="email"> <span class="form-control-feedback">Hesabınızın bir e-posta adresi olmalı</span> </div>');
					$('#login-form-error').removeClass('active').text('');
					$('#email_group').find('input').focus();
				}
			} else {
				$('#login-form-error').addClass('active').css('background', '#21BA45').html('<i class="fa fa-check"></i>');
				$(that).addClass('loading-ok');
				
				if ( respond.data && respond.data.redirect ) {
					window.location.href = respond.data.redirect;
				} else {
					window.location.href = url;
				}
			}

			$(that).removeClass('loading');
		}
	});

	return false;

};

var signUp = function (that) {

	var fields = ['register_email', 'register_username', 'register_password', 'register_password_confirm'];

	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/signup',
		data: {
			register_username: $(that).find('#register_username').val(),
			register_email: $(that).find('#register_email').val(),
			register_password: $(that).find('#register_password').val(),
			register_password_confirm: $(that).find('#register_password_confirm').val(),
			register_captcha: grecaptcha.getResponse(),
			_token: token
		},
		success: function(respond) {
			$.each(fields, function( index, value ) {
				$('#' + value + '_group').removeClass('has-danger');
				$('#' + value + '_group input').removeClass('form-control-danger');
				$('#' + value + '_group .form-control-feedback').text('');
			});

			$('#register-form-error').removeClass('active');

			if ( respond.error ) {
				$('#register-form-error').addClass('active').text(respond.error);
			} else if ( respond.validations ) {
				$.each(respond.validations, function( index, value ) {
					$('#' + index + '_group').addClass('has-danger');
					$('#' + index + '_group input').addClass('form-control-danger');
					$('#' + index + '_group .form-control-feedback').text(value);
				});
			} else {
				$('#register-form-error').addClass('active').css('background', '#21BA45').html('<i class="fa fa-check"></i>');
				$(that).addClass('loading-ok');
				window.location.href = respond.data.redirect;
			}

			$(that).removeClass('loading');
		}
	});

	return false;

};

var forgotPassword = function (that) {

	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/sifremi-unuttum',
		data: {
			email: $(that).find('input').val(),
			_token: token
		},
		success: function(respond) {
			$('#email_group').removeClass('has-danger');
			$('#email_group input').removeClass('form-control-danger');
			$('#email_group .form-control-feedback').text('');
			
			$('#forgot-form-error').removeClass('active');

			if ( respond.error ) {
				$('#forgot-form-error').addClass('active').text(respond.error);
			} else if ( respond.validations ) {
				$('#email_group').addClass('has-danger');
				$('#email_group input').addClass('form-control-danger');
				$('#email_group .form-control-feedback').text(respond.validations.email);
			} else {
				$('#forgot-form-error').addClass('active').css('background', '#21BA45').html('<i class="fa fa-check"></i>');
				swal('Hey!', 'Girdiğiniz e-posta doğruysa, yeni şifrenizi bu mail adresine gönderdik.', 'info');
			}

			$(that).removeClass('loading');
		}
	});

	return false;
};

var forgotNewPassword = function (that) {

	var fields = ['password', 'password_confirm'];

	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/sifremi-unuttum/yeni',
		data: {
			password: $(that).find('#password').val(),
			password_confirm: $(that).find('#password_confirm').val(),
			email: $(that).find('#email').val(),
			token: $(that).find('#token').val(),
			_token: token
		},
		success: function(respond) {
			$.each(fields, function( index, value ) {
				$('#' + value + '_group').removeClass('has-danger');
				$('#' + value + '_group input').removeClass('form-control-danger');
				$('#' + value + '_group .form-control-feedback').text('');
			});

			$('#forgot-form-error').removeClass('active');

			if ( respond.error ) {
				$('#forgot-form-error').addClass('active').text(respond.error);
			} else if ( respond.validations ) {
				$.each(respond.validations, function( index, value ) {
					$('#' + index + '_group').addClass('has-danger');
					$('#' + index + '_group input').addClass('form-control-danger');
					$('#' + index + '_group .form-control-feedback').text(value);
				});
			} else {
				$('#forgot-form-error').addClass('active').css('background', '#21BA45').html('<i class="fa fa-check"></i>');
				window.location.href = url;
			}

			$(that).removeClass('loading');
		}
	});

	return false;
};

/*
* Status
*/

var postStatus = function (that) {
	$(that).addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/status',
		data: {
			player: player,
			body: $(that).find('textarea').val(),
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal('Hata!', respond.error, 'error');
			} else {
				$(that).find('textarea').val('');
				$('#statuses').prepend('<div class="status-item"> <div class="status-info clearfix"> <div class="avatar"> <img src="' + respond.data.avatar + '" alt="User Avatar"> </div> <div class="body"> <a href="' + respond.data.profile_link + '"> <strong>' + respond.data.display_name + '</strong> </a> <ul class="status-meta clearfix"> <li> <a href="#">' + respond.data.created_at + '</a> </li> </ul> </div> </div> <div class="status-body clearfix"> ' + respond.data.body + '</div> <div class="status-footer"> <ul class="status-meta clearfix"> <li> <span class="status-like-counter">0</span> beğeni </li> <li> <span class="status-comment-counter">0</span> yorum </li> </ul> <ul class="status-actions clearfix"> <li> <button class="btn btn-default" onclick="return likeStatus(this, ' + respond.data.id + ');"> <i class="fa fa-thumbs-up"></i> Beğen </button> </li> <li> <button class="btn btn-default" onclick="return showComments(this);"> <i class="fa fa-comments"></i> Yorum Yap </button> </li> </ul> </div> <div class="status-post-comment clearfix"> <div class="avatar"> <img src="' + avatar + '" alt="User Avatar"> </div> <div class="comment"> <form onsubmit="return postComment(this, ' + respond.data.id + ', \'status\');"> <input type="text" placeholder="Yorumunuzu yazın..." class="form-control"> </form> </div> </div> <div class="status-comments"></div> </div>');
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
					$(that).closest('.status-item').find('.status-comment-counter').text(respond.data.count);
					var comment_field = $(that).closest('.status-item').find('.status-comments');
				} else {
					$(that).closest('.content').find('.comment-reply-counter').text('(' + respond.data.count + ')');
					var comment_field = $(that).closest('.content').find('.sub-comments');
				}

				$(comment_field).prepend('<div class="comment-item"> <div class="avatar"> <img src="' + respond.data.avatar + '" alt="User Avatar"> </div> <div class="content"> <div class="comment"> <a href="' + respond.data.profile_link + '"> <strong>' + respond.data.display_name + '</strong> </a> <span>' + respond.data.body + '</span> </div> <ul class="meta clearfix"> <li class="action-comment-like"><a href="#" onclick="return likeComment(this, ' + respond.data.id + ');">Beğen</a></li> <li class="action-ago">' + respond.data.created_at + '</li> </ul> </div> </div>');
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
					$(that).html('<i class="fa fa-thumbs-up"></i> Beğen').addClass('btn-primary').removeClass('btn-default');
				} else {
					$(that).html('<i class="fa fa-thumbs-up"></i> Beğen').removeClass('btn-primary').addClass('btn-default');
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

/*
* Friend
*/

var addFriend = function (that, id) {
	$.ajax({
		type: 'POST',
		url: url + '/oyuncu/arkadas/ekle',
		data: {
			id: id,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
			} else {
				$(that).before('<div class="btn-group"> <button class="btn btn-secondary"> <i class="fa fa-check"></i> İstek Gönderildi </button> <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="sr-only">Toggle Dropdown</span> </button> <div class="dropdown-menu"> <a href="#" onclick="return deleteFriend(this, ' + id + ');" class="dropdown-item">İsteği İptal Et</a> </div> </div>');
				$(that).remove();
			}
		}
	});

	return false;
};

var deleteFriend = function (that, id) {
	$.ajax({
		type: 'POST',
		url: url + '/oyuncu/arkadas/sil',
		data: {
			id: id,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
			} else {
				$(that).closest('.btn-group').before('<button class="btn btn-secondary" onclick="return addFriend(this, ' + id + ');"> <i class="fa fa-user-plus"></i> Arkadaşlık İsteği Gönder </button>');
				$(that).closest('.btn-group').remove();
			}
		}
	});

	return false;
};

var acceptFriend = function (that, id) {
	$.ajax({
		type: 'POST',
		url: url + '/oyuncu/arkadas/kabul-et',
		data: {
			id: id,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
			} else {
				$(that).before('<div class="btn-group"> <button class="btn btn-secondary"> <i class="fa fa-check"></i> Arkadaşsınız </button> <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="sr-only">Toggle Dropdown</span> </button> <div class="dropdown-menu"> <a href="#" onclick="return deleteFriend(this, ' + id + ');" class="dropdown-item">Arkadaşlıktan Çıkart</a> </div> </div>');
				$(that).remove();
			}
		}
	});

	return false;
};

/*
* Group
*/

$('#newGroupModal').on('show.bs.modal', function (event) {
	var modal = $(this);
	var button = $(event.relatedTarget);

	var id = button.closest('.col-lg-4').data('id');	

	if ( id ) {
		modal.find('.modal-header').text('Grubu Düzenle');

		$.ajax({
			type: 'POST',
			url: url + '/group/info',
			data: {
				id: id,
				_token: token
			},
			success: function(respond) {
				if ( respond.error ) {
					modal.find('.modal-body').text(respond.error);
				} else {
					modal.find('#group_id').val(id);
					modal.find('#group_title').val(respond.group.title);
					modal.find('#group_money').val(respond.group.money);

					var commands = [];

					$.each(respond.group.commands, function (key, value) {
						commands.push(value.command);
					});

					modal.find('#group_commands').val(commands.join("\n"));
				}
			}
		});
	} else {
		modal.find('.modal-header').text('Yeni Grup');
		modal.find('#group_id').val('');
		modal.find('#group_title').val('');
		modal.find('#group_money').val('');
		modal.find('#group_commands').val('');
	}
});

$('#buyGroupModal').on('show.bs.modal', function (event) {
	var modal = $(this);
	var button = $(event.relatedTarget);

	var id = button.closest('.col-lg-4').data('id');	

	if ( !id ) {
		modal.find('.modal-body').text('Grup bulunamadı.');
	} else {
		$.ajax({
			type: 'POST',
			url: url + '/group/info',
			data: {
				id: id,
				_token: token
			},
			success: function(respond) {
				if ( respond.error ) {
					modal.find('.modal-body').text(respond.error);
				} else {
					modal.find('.modal-header').text(respond.group.title);

					if ( !respond.group.features.length ) {
						modal.find('#group_modal_features').hide();
					} else {
						$.each(respond.group.features, function (index, value) {
							modal.find('#group_modal_features ul').append('<li>' + value.body + '</li>');
						});
					}

					if ( !respond.group.commands.length ) {
						modal.find('#group_modal_commands').hide();
					} else {
						$.each(respond.group.commands, function (index, value) {
							modal.find('#group_modal_commands ul').append('<li>' + value.command + '</li>');
						});
					}
				}
			}
		});
	}
});

var buyGroup = function (that) {
	//
};

var addGroup = function (that) {

	var fields = ['title', 'money', 'commands'];

	var id = $(that).closest('#newGroupModal').find('#group_id');
	var title = $(that).closest('.modal-body').find('#group_title');
	var money = $(that).closest('.modal-body').find('#group_money');
	var commands = $(that).closest('.modal-body').find('#group_commands');

	$(that).closest('.modal-body').addClass('loading');

	$.ajax({
		type: 'POST',
		url: url + '/group/new',
		data: {
			id: id.val(),
			title: title.val(),
			money: money.val(),
			commands: commands.val(),
			_token: token
		},
		success: function(respond) {
			$.each(fields, function( index, value ) {
				$(that).closest('.modal-body').find('#group_' + value).removeClass('form-control-danger');
				$(that).closest('.modal-body').find('#group_' + value).parent().removeClass('has-danger');
				$(that).closest('.modal-body').find('#group_' + value).parent().find('.form-control-feedback').text('');
			});

			if ( respond.errors ) {
				$.each(respond.errors, function( index, value ) {
					$(that).closest('.modal-body').find('#group_' + index).addClass('form-control-danger');
					$(that).closest('.modal-body').find('#group_' + index).parent().addClass('has-danger');
					$(that).closest('.modal-body').find('#group_' + index).parent().find('.form-control-feedback').text(value);
				});
			} else {
				$('#newGroupModal').modal('hide');
				$('#groupCards').find('.alert').remove();
				$(that).closest('.modal-body').find('input').val('');
				
				if ( respond.data.new ) {
					$('#groupCards').append(respond.data.layout);
				} else {
					$('#group_card_' + id.val()).parent().html(respond.data.layout);
				}
			}

			$(that).closest('.modal-body').removeClass('loading');
		},
		error: function (r) {
			$('html').html(r.responseText);
		}
	});

	return false;

};

var deleteGroup = function(that, id) {
	swal({
	    title: "Grubu siliyorsun...",
	    text: "Emin misin?",
	    type: "warning",
	    showCancelButton: true,
	    confirmButtonColor: "#DD6B55",
	    confirmButtonText: "Evet, eminim.",
	    cancelButtonText: "İptal",
	    closeOnConfirm: true
	}, function() {
		$(that).closest('.card').addClass('loading');

	    $.getJSON(url + '/group/delete/' + id, function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
				$(that).closest('.card').removeClass('loading');
			} else {
				$(that).closest('.col-lg-4').remove();
			}
		});
	});
	
	return false;
};

var addGroupFeature = function(that, id) {
	$.ajax({
		type: 'POST',
		url: url + '/group/new/feature',
		data: {
			id: id,
			body: $(that).find('input').val(),
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
				$(that).find('input').val('');
				$(that).closest('.list-group').find('.list-group-item:last').before(respond.data.layout);
			}
		}
	});

	return false;
};

var deleteGroupFeature = function(that, id) {
	swal({
	    title: "Özellik siliniyor..",
	    text: "Emin misin?",
	    type: "warning",
	    showCancelButton: true,
	    confirmButtonColor: "#DD6B55",
	    confirmButtonText: "Evet, eminim.",
	    cancelButtonText: "İptal",
	    closeOnConfirm: true
	}, function() {
		$(that).closest('.list-group-item').addClass('loading');

	    $.getJSON(url + '/group/delete/feature/' + id, function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
				$(that).closest('.list-group-item').removeClass('loading');
			} else {
				$(that).closest('.list-group-item').remove();
			}
		});
	});
	
	return false;
};

var addGroupCommand = function(that, id) {
	$.ajax({
		type: 'POST',
		url: url + '/group/new/command',
		data: {
			id: id,
			command: $(that).find('input').val(),
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
			} else if (respond.validations) {
				if ( respond.validations.id ) {
					swal("Hata!", respond.validations.id, "error");
				} else if ( respond.validations.command ) {
					swal("Hata!", respond.validations.command, "error");
				}
			} else {
				$(that).find('input').val('');
				//$(that).closest('.list-group').find('.list-group-item:last').before('<li class="list-group-item"> ' + respond.data.body + '<div class="pull-right"> <a href="' + respond.data.delete_link + '" class="text-danger"> <i class="fa fa-times"></i> </a> </div> </li>');	
			}
		}
	});

	return false;
};

$('#itemModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var that = this;

	$(this).find('#item_piece').removeAttr('readonly').val('');
	
	$.ajax({
		type: 'POST',
		url: url + '/oyuncu/' + player + '/chest/sell_modal',
		data: {
			item: button.data('item'),
			number: button.data('number'),
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				$(that).find('.modal-body').text(respond.error);
			} else {
				$(that).find('#item_order').attr('value', button.data('item'));
				$(that).find('#chest_number').attr('value', button.data('number'));

				if ( respond.chest.inventory[button.data('item')][4] == 1 ) {
					$(that).find('#item_piece').attr('readonly', 'true').val(1);
				}
			}
		}
	});
});

var sellInventoryItem = function (that) {

	var order = $(that).find('#item_order').val();
	var number = $(that).find('#chest_number').val();
	var price = $(that).find('#item_price').val();
	var piece = $(that).find('#item_piece').val();

	$.ajax({
		type: 'POST',
		url: url + '/oyuncu/' + player + '/chest/sell',
		data: {
			order: order,
			number: number,
			price: price,
			piece: piece,
			_token: token
		},
		success: function(respond) {
			if ( respond.error ) {
				swal("Hata!", respond.error, "error");
			} else if (respond.validations) {
				if ( respond.validations.piece ) {
					swal("Hata!", respond.validations.piece, "error");
				} else if ( respond.validations.price ) {
					swal("Hata!", respond.validations.price, "error");
				}
			} else {
				if ( respond.chest.inventory[order] ) {
					$('#inv_item_' + number + '_' + order + ' .inv-piece').text(respond.chest.inventory[order][4]);
				} else {
					$('#inv_item_' + number + '_' + order).parent().html('<img src="global/images/minecraft/items/0-0.png" alt="Inventory Block">').removeAttr('style');
				}

				swal('Tamamdır!', 'Ürünün artık topluluk pazarında!');
				
				$('#itemModal').modal('hide');
				$(that).find('input').val('');
			}
		}
	});

	return false;

};