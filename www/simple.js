function tips_appear(tips) {
	$(tips).fadeIn();
	window.setTimeout(function() {
		$(tips).fadeOut();
	}, 3000);
}

function email_available(email) {
	var user_type = $('#user_type').val();
	var result = false;
	
	$.ajax({
		url: '/user/check_email',
		data: {user_type: user_type, email: email},
		async: false,
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			if (json.msg === 'success') {
				result = true;
			} 
		},
		error: function() {
			alert('Network Error');
		}
	});
	
	return result;
}

function nickname_available(nickname) {
	var user_type = $('#user_type').val();
	var result = false;
	
	$.ajax({
		url: '/user/check_nickname',
		data: {user_type: user_type, nickname: nickname},
		async: false,
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			if (json.msg === 'success') {
				result = true;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
	
	return result;
}

function check_password() {
	var password = $('#inputPassword3').val();
	var passwordConfirm = $('#inputPasswordConfirm3').val();
	if (password.length < 6) {
		tips_appear('#pswd_short');
		return false;
	} else if (passwordConfirm.length < 6) {
		tips_appear('#pswd_firm_short');
		return false;
	} else if (password != passwordConfirm) {
		tips_appear('#pswd_different');
		return false;
	}
	
	return true;
}

function check_register_email() {
	var email = $('#inputEmail3').val();
	var pattern = /^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	if (!pattern.test(email)) {
		tips_appear('#email_error');
		return false;
	} else if (email_available(email) === false) {
		tips_appear('#email_used');
		return false;
	}
	
	return true;
}

function check_nickname() {
	var nickname = $('#inputNickname3').val();
	
	if (nickname.length == 0) {
		tips_appear('#nickname_empty');
		return false;
	} else if (nickname_available(nickname) === false) {
		tips_appear('#nickname_used');
		return false;
	}
	
	return true;
}

function check_realname() {
	var realname = $('#inputRealname3').val();
	
	if (realname.length == 0) {
		tips_appear('#realname_empty');
		return false;
	}
	
	return true;
}
function check_phone() {
	var phone = $('#inputPhone3').val();
	var pattern = /(^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$)|(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/;
	if (!pattern.test(phone)) {
		tips_appear('#phone_error');
		return false; 
	} 
	
	return true; 
}

function reshape_password() {
	var password = $('#inputPassword3').val();
	if (password.length < 6) {
		tips_appear('#pswd_short');
		return false;
	}
	
	$('#inputPassword3').val(hex_md5(password));
	return true;
}


function check_login_email() {
	var email = $('#inputEmail3').val();
	var pattern = /^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
	if (!pattern.test(email)) {
		tips_appear('#email_error');
		return false;
	}
	
	return true;
}