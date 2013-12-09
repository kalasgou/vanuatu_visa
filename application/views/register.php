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
		<script type="text/javascript" src="/jshash/md5.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
			function disappear(tips) {
				window.setTimeout(function() {
					$(info).fadeOut();
				}, 2000);
			}
			
			function check_password() {
				
			}
			
			function check_email() {
				var pattern = /^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
				if (!pattern.test($('#inputEmail3').val())) {
					//$("#area_2").fadeIn();
					//disappear("#area_2");
					return false;
				} else {
					retrun true;
				}
			}
			
			function check_phone() {
			}
			
			function submit_form() {
				return reshape_password();
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
						<span id="email_correct" class="correct_tips">123123321</span>
						<span id="email_error" class="error_tips">123123321</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">设定登录密码(长度至少六位):</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">确定登录密码:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password_confirm" id="inputPasswordConfirm3" placeholder="Confirm Password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="inputNickname3" class="col-sm-2 control-label">帐户昵称:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nickname" id="inputNickname3" placeholder="Nickname"/>
					</div>
				</div>
				<div class="form-group">
					<label for="inputRealname3" class="col-sm-2 control-label">真实姓名:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="realname" id="inputRealname3" placeholder="Real Name"/>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPhone3" class="col-sm-2 control-label">联系电话:</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" name="phone" id="inputPhone3" placeholder="Telephone"/>
					</div>
				</div>
				<div>
					<input type="hidden" name="user_type" value="applicant"/>
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
						<button type="submit"  class="btn btn-default">注册</button>
						<a class="login" href="/login" style="margin-left:12px;">已有帐号？点此登录</a>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>