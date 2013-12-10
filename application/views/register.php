<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href="/dist/css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="/common.css"/>
		<script type="text/javascript" src="/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/jshash/md5-min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
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
			
			function check_email() {
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
				var realname = $('#inputRealname3').val();
				
				if (realname.length == 0) {
					tips_appear('#realname_empty');
					return false;
				}
				
				return true;
			}
			
			function reshape_password() {
				var password = $('#inputPassword3').val();
				if (password.length < 6) {
					return false;
				} else {
					$('#inputPassword3').val(hex_md5(password));
					return true;
				}
			}
			
			function submit_form() {
				return check_email() && check_password() && check_nickname() && check_realname() && reshape_password();
			}
		</script>
		<style type="text/css">
			.form-control {width:256px;}
		</style>
	</head>
	<body>
		<div>
			<form class="form-horizontal" role="form" method="post" action="/user/register" onsubmit="return submit_form();">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<h3>普通帐号注册</h3>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">请输入邮箱(将作为您的登录帐号):</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email"/>
						<span id="email_correct" class="correct_tips">OK</span>
						<span id="email_error" class="error_tips">Email Not Correct</span>
						<span id="email_used" class="error_tips">Email is used thus not available</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">设定登录密码(长度至少六位):</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password"/>
						<span id="pswd_correct" class="correct_tips">OK</span>
						<span id="pswd_short" class="error_tips">Password Length less than 6</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">确定登录密码:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password_confirm" id="inputPasswordConfirm3" placeholder="Confirm Password"/>
						<span id="pswd_correct" class="correct_tips">OK</span>
						<span id="pswd_firm_short" class="error_tips">Password Length less than 6</span>
						<span id="pswd_different" class="error_tips">Password not the same</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputNickname3" class="col-sm-2 control-label">帐户昵称:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nickname" id="inputNickname3" placeholder="Nickname"/>
						<span id="nickname_correct" class="correct_tips">OK</span>
						<span id="nickname_empty" class="error_tips">Nickname should not be empty</span>
						<span id="nickname_used" class="error_tips">Nickname is used thus not available</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputRealname3" class="col-sm-2 control-label">真实姓名:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="realname" id="inputRealname3" placeholder="Real Name"/>
						<span id="realname_correct" class="correct_tips">OK</span>
						<span id="realname_empty" class="error_tips">Realname should not be empty</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPhone3" class="col-sm-2 control-label">联系电话:</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" name="phone" id="inputPhone3" placeholder="Telephone"/>
						<span id="phone_correct" class="correct_tips">OK</span>
						<span id="phone_error" class="error_tips">Phone Error</span>
					</div>
				</div>
				<div>
					<input type="hidden" id="user_type" name="user_type" value="applicant"/>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input id="agreement" type="checkbox"/>
						<span>我已阅读并同意</span>
						<a id="agreement-link" href="">XXXXXXXX协议</a>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-default">注册</button>
						<a class="login" href="/login" style="margin-left:12px;">已有帐号？点此登录</a>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>