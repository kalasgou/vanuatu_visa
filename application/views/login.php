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
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
			function submit_form() {
				return check_login_email() && reshape_password();
			}
		</script>
		<style type="text/css">
			.form-control {width:224px;}
		</style>
	</head>
	<body>
		<div>
			<form id="login_form" class="form-horizontal" role="form" method="post" action="/user/login" onsubmit="return submit_form();">
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
						<h3>瓦努阿图驻华大使馆旅行证件申请系统</h3>
						<h3>Vanuatu Embassy Travel Certification Application Online</h3>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">邮箱 / Email:</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email"/>
						<span id="email_error" class="error_tips">电子邮箱格式不正确</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">密码 / Password:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password"/>
						<span id="pswd_short" class="error_tips">密码应不少于六位字符</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCaptcha3" class="col-sm-2 control-label">验证码 / Captcha:</label>
					<div class="col-sm-10">
						<input type="captcha" class="form-control" name="captcha" id="inputCaptcha3" placeholder="Captcha"/><br>
						<span id="captcha"><?php echo $captcha;?></span> <a href="javascript:void(0);" onclick="refresh_captcha();">刷新 / Refresh</a>
					</div>
				</div>
				<!--<div>
					<input type="hidden" name="user_type" value="applicant"/>
				</div>-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success">登录 / Login</button>
						<!--<a class="register" href="/register" style="margin-left:12px;">点此注册新用户</a>-->
					</div>
				</div>
			</form>
		</div>
	</body>
</html>