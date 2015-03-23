function province_list(selection) {
	$.ajax({
		url: '/admin/province_list',
		data: {},
		async: false,
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			if (json.msg === 'success') {
				var options = '';
				var len = json.provinces.length;
				if (selection === 'all') {
					options += '<option value="0">全部</option>';
				}
				if (selection === 'new') {
					options += '<option value="0">请选择省份</option>';
				}
				for (var i = 0; i < len; i ++) {
					options += '<option value="' + json.provinces[i].id + '">' + json.provinces[i].province_cn + '</option>';
				}
				$('#provinces').empty();
				$('#provinces').append(options);
				city_list(selection);
			} else {
				alert('Permission Error');
			}
		},
		error: function() {
			alert('Networking Error');
		}
	});
}

function city_list(selection) {
	var province_id = $('#provinces').val();
	$.ajax({
		url: '/admin/city_list/' + province_id,
		data: {},
		async: false,
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			if (json.msg === 'success') {
				var options = '';
				var len = json.cities.length;
				if (selection === 'all') {
					options += '<option value="0">全部</option>';
				}
				if (selection === 'new') {
					options += '<option value="0">请选择城市</option>';
				}
				for (var i = 0; i < len; i ++) {
					options += '<option value="' + json.cities[i].id + '">' + json.cities[i].city_cn + '</option>';
				}
				$('#cities').empty();
				$('#cities').append(options);
				agency_list(selection);
			} else {
				alert('Permission Error');
			}
		},
		error: function() {
			alert('Networking Error');
		}
	});
}

function agency_list(selection) {
	var city_id = $('#cities').val();
	var permission = $('#permissions').val();
	$.ajax({
		url: '/admin/agency_list',
		data: {city_id: city_id, permission: permission},
		async: false,
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			if (json.msg === 'success') {
				var options = '';
				var len = json.agencies.length;
				if (selection === 'all') {
					options += '<option value="0">全部</option>';
				}
				if (selection === 'new') {
					options += '<option value="0">请选择机构</option>';
				}
				if (len === 0) {
					options += '<option value="0">暂无</option>';
				}
				for (var i = 0; i < len; i ++) {
					options += '<option value="' + json.agencies[i].id + '">' + json.agencies[i].name_cn + '</option>';
				}
				$('#agencies').empty();
				$('#agencies').append(options);
			} else {
				alert('Permission Error');
			}
		},
		error: function() {
			alert('Networking Error');
		}
	});
}

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

function check_province_city_agency() {
	var permission = $('#permissions').val();
	if (permission !== '2048') {
		var agency = $('#agencies').val();
		if (agency === '0') {
			tips_appear('#agency_empty');
			return false;
		}
		var province = $('#provinces').val();
		if (province === '0') {
			tips_appear('#province_empty');
			return false;
		}
		var city = $('#cities').val();
		if (city === '0') {
			tips_appear('#city_empty');
			return false;
		}
	}
	$('#agency_text').val($('#agencies').find('option:selected').text());
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

function change_account_status(userid, opt, this_a) {
	if (confirm('确定更新该帐户的可用状态吗？')) {
		$.ajax({
			url: '/admin/activate_account',
			data: {userid: userid, activate: opt},
			type: 'POST',
			dataType: 'json',
			success: function(json) {
				switch (json.msg) {
					case 'success': alert('对ID: ' + userid + ' 用户帐户操作成功！');  this_a.innerHTML = '已更新'; this_a.style.color = '#DDDDDD'; break;
					case 'forbidden': alert('无此操作权限'); break;
					case 'fail': alert('出错了'); break;
				}
				return;
			},
			error: function() {
				alert('Network Error');
			}
		});
	}
}

function update_account_superior(userid, original_superior_id, this_a) {
	var superior_id = $('#charge_' + userid).val();
	
	$.ajax({
		url: '/admin/update_superior',
		data: {userid: userid, superior_id: superior_id, original_superior_id: original_superior_id},
		type: 'POST',
		dataType: 'json',
		success: function(json) {
			switch (json.msg) {
				case 'success': alert('对ID: ' + userid + ' 用户帐户操作成功！');  this_a.innerHTML = '已更新'; this_a.style.color = '#DDDDDD'; break;
				case 'forbidden': alert('无此操作权限'); break;
				case 'fail': alert('出错了'); break;
			}
			return;
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function pass_or_not(uuid, opt) {
	var message = $('#message').val();
	if (message === '' && opt === 'pass') {
		message = '你的申请已通过办事处的初步审核，请等待大使馆的签证审核。';
	} else if (message === '') {
		alert('请详细填写申请没能通过审核的原因。');
		return ;
	}
	
	$.ajax({
		url: '/admin/auditing/' + uuid + '/' + opt,
		data: {message: message},
		type: 'POST',
		dataType: 'json',
		success: function (json) {
			switch (json.msg) {
				case 'success': alert('对申请号 ' + uuid + ' 审核操作成功！'); break;
				case 'invalid': alert('申请号 ' + uuid + ' 记录不存在，请检查流水号正确与否！'); break;
				case 'fail': alert('出错了'); break;
			}
			return;
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function visa_or_not(uuid, opt) {
	if (confirm('确定更新该申请的状态吗？')) {
		$.ajax({
			url: '/admin/approving/' + uuid + '/' + opt,
			data: {},
			type: 'POST',
			dataType: 'json',
			success: function(json) {
				switch (json.msg) {
					case 'success': alert('对申请号 ' + uuid + ' 审批操作成功！'); break;
					case 'invalid': alert('申请号 ' + uuid + ' 记录不存在，请检查流水号正确与否！'); break;
					case 'fail': alert('出错了'); break;
				}
				return;
			},
			error: function() {
				alert('Network Error');
			}
		});
	}
}

function pass_for_fee(uuid, opt, this_a) {
	//var message = '你的申请顺利通过办事处的审核，请在15天内前往办事处办理余下签证事务。';
	var message = '你的申请已通过办事处的初步审核，请等待大使馆的签证审核。';
	
	$.ajax({
		url: '/admin/auditing/' + uuid + '/' + opt,
		data: {message: message},
		type: 'POST',
		dataType: 'json',
		success: function (json) {
			switch (json.msg) {
				case 'success': alert('对申请号 ' + uuid + ' 审核操作成功！'); this_a.innerHTML = '已审核'; this_a.style.color = '#DDDDDD'; break;
				case 'invalid': alert('申请号 ' + uuid + ' 记录不存在，请检查流水号正确与否！'); break;
				case 'fail': alert('出错了'); break;
			}
			return;
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function visa_it(uuid, opt, this_a) {
	if (confirm('确定更新该申请的状态吗？')) {
		$.ajax({
			url: '/admin/approving/' + uuid + '/' + opt,
			data: {},
			type: 'POST',
			dataType: 'json',
			success: function(json) {
				switch (json.msg) {
					case 'success': alert('对申请号 ' + uuid + ' 审批操作成功！'); this_a.innerHTML = '已更新'; this_a.style.color = '#DDDDDD'; break;
					case 'invalid': alert('申请号 ' + uuid + ' 记录不存在，请检查流水号正确与否！'); break;
					case 'fail': alert('出错了'); break;
				}
				return;
			},
			error: function() {
				alert('Network Error');
			}
		});
	}
}

function trash_application(uuid, this_a) {
	if (confirm('确定删除流水号为“' + uuid + '”的申请记录吗？')) {
		$.ajax({
			url: '/apply/trash/' + uuid,
			data: {},
			type: 'POST',
			dataType: 'json',
			success: function(json) {
				switch (json.msg) {
					case 'success': this_a.parentNode.parentNode.style.display = 'none'; break;
					case 'forbidden': alert('无此操作权限'); break;
					case 'fail': alert('出错了'); break;
				}
				return;
			},
			error: function() {
				alert('Network Error');
			}
		});
	}
}

/*function pay_for_visa(uuid, this_a) {
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
}*/

function download_excel($user_type) {
	switch ($user_type) {
		case 'admin': location.href = '/admin/download_excel?start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val(); break;
		case 'user': location.href = '/apply/download_excel?start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val(); break;
	}
}

function refresh_captcha() {
	$.ajax({
		url: '/refresh_captcha',
		date: {},
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			switch (json.msg) {
				case 'success': $('#captcha').html(json.captcha); break;
				case 'fail': alert('请不要频繁刷新验证码！'); break;
			}
			return;
		},
		error: function() {
			alert('Network Error');
		}
	});
}

function disable_refresh_tuner() {
	clearInterval(refresh_tuner);
}

function auto_visa_switch(option) {
	$.ajax({
		url: '/admin/auto_visa/' + option,
		data: {},
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			location.reload();
		},
		error: function() {
			alert('Network Error');
		}
	});
}