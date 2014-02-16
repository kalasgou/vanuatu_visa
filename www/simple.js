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
	}/* else if (nickname_available(nickname) === false) {
		tips_appear('#nickname_used');
		return false;
	}*/
	
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

function change_account_status(user_type, userid, opt, this_a) {
	$.ajax({
		url: '/admin/activate_account',
		data: {user_type: user_type, userid: userid, activate: opt},
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			switch (json.msg) {
				case 'success': alert('对ID: ' + userid + ' 用户帐户操作成功！');  this_a.innerHTML = '已更新'; this_a.style.color = '#DDDDDD'; break;
				case 'fail': alert('出错了'); break;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function pass_or_not(uuid, opt) {
	var message = $('#message').val();
	if (opt === 'pass' && message === '') {
		message = '你的申请顺利通过办事处的审核，请在15天内前往办事处办理余下签证事务。';
	}
	
	$.ajax({
		url: '/admin/auditing/' + uuid + '/' + opt,
		data: {message: message},
		type: 'POST',
		dataType: 'json',
		success: function (json) {
			switch (json.msg) {
				case 'success': alert('对申请号 ' + uuid + ' 审核操作成功！'); break;
				case 'fail': alert('出错了'); break;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function visa_or_not(uuid, opt) {
	$.ajax({
		url: '/admin/approving/' + uuid + '/' + opt,
		data: {},
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			switch (json.msg) {
				case 'success': alert('对申请号 ' + uuid + ' 审批操作成功！'); break;
				case 'fail': alert('出错了'); break;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function pass_for_fee(uuid, opt, this_a) {
	var message = '你的申请顺利通过办事处的审核，请在15天内前往办事处办理余下签证事务。';
	
	$.ajax({
		url: '/admin/auditing/' + uuid + '/' + opt,
		data: {message: message},
		type: 'POST',
		dataType: 'json',
		success: function (json) {
			switch (json.msg) {
				case 'success': alert('对申请号 ' + uuid + ' 审核操作成功！'); this_a.innerHTML = '已审核'; this_a.style.color = '#DDDDDD'; break;
				case 'fail': alert('出错了'); break;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function visa_it(uuid, opt, this_a) {
	$.ajax({
		url: '/admin/approving/' + uuid + '/' + opt,
		data: {},
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			switch (json.msg) {
				case 'success': alert('对申请号 ' + uuid + ' 审批操作成功！'); this_a.innerHTML = '签证成功'; this_a.style.color = '#DDDDDD'; break;
				case 'invalid': alert('申请号 ' + uuid + ' 记录不存在，请检查流水号正确与否！');
				case 'fail': alert('出错了'); break;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function pay_for_visa(uuid, this_a) {
	var fee = parseInt(prompt('请输入签证费用，单位：人民币'));
	if (isNaN(fee)) {
		alert('请输入正整数！');
		return;
	}
	var message = '签证申请流水号 ' + uuid + ' 已缴款RMB' + fee + '，请等待签证通过！';
	$.ajax({
		url: '/admin/auditing/' + uuid + '/paid',
		data: {message: message, fee: fee},
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			switch(json.msg) {
				case 'success': alert('缴费成功！请上传证明扫描文件。'); this_a.innerHTML = '已缴费'; this_a.style.color = '#DDDDDD'; break;
				case 'fail': alert('缴费失败！请稍后再试或联系网站管理员。'); break;
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function download_excel() {
	location.href = '/admin/download_excel?start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val();
}

function refresh_captcha() {
	$.ajax({
		url: '/refresh_captcha',
		date: {},
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			if (json.msg === 'success') {
				$('#captcha').html(json.captcha);
			} else if (json.msg === 'fail') {
				alert('请不要频繁刷新验证码！');
			}
		},
		error: function() {
			alert('Network Error');
		}
	});
}