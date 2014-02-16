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
			
			function change_password() {
				var old_pswd = '', new_pswd = '', user_type = '', captcha = '';
				if (check_password()) {
					user_type = $('#user_type').val();
					captcha = $('#inputCaptcha3').val();
					
					old_pswd = hex_md5($('#inputOriginalPassword3').val());
					new_pswd = hex_md5($('#inputPassword3').val());
					
					$.ajax({
						url: '/user/change_password',
						data: {user_type: user_type, captcha: captcha, old_password: old_pswd, new_password: new_pswd},
						type: 'POST',
						dataType: 'json',
						success: function(json) {
							var jump_to = user_type === 'applicant' ? '/login' : '/admin_login';
							switch(json.msg) {
								case 'captcha': alert('验证码错误！'); location.reload(); break;
								case 'success': alert('密码修改成功，请重新登录！'); location.href = jump_to; break;
								case 'fail': alert('密码修改失败，请稍后再试！'); location.reload(); break;
								case 'different': alert('输入的旧密码不匹配！'); location.reload(); break;
								default : alert('非法操作！');
							}
						}, 
						error: function() {
							alert('Network Error!');
						}
					});
				}
			}
		</script>
		<style type="text/css">
			.form-control {width:224px;}
		</style>
	</head>
	<body>
		<div>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<h3>帐号密码修改</h3>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">原密码:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="old_password" id="inputOriginalPassword3" placeholder="Original Password"/>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">重设密码:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="inputPassword3" placeholder="New Password"/>
						<span id="pswd_short" class="error_tips">密码不得少于六位字符</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">确定密码:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password_confirm" id="inputPasswordConfirm3" placeholder="Confirm Password"/>
						<span id="pswd_firm_short" class="error_tips">密码不得少于六位字符</span>
						<span id="pswd_different" class="error_tips">两次输入的密码不相同</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCaptcha3" class="col-sm-2 control-label">验证码:</label>
					<div class="col-sm-10">
						<input type="captcha" class="form-control" name="captcha" id="inputCaptcha3" placeholder="Captcha"/><br>
						<span id="captcha"><?php echo $captcha;?></span> <a href="javascript:void(0);" onclick="refresh_captcha();">换过另一张</a>
					</div>
				</div>
				<?php if ($permission == 10000) { ?>
				<div>
					<input type="hidden" id="user_type" value="applicant"/>
				</div>
				<?php } else if ($permission == 1 || $permission == 2 || $permission == 3) { ?>
				<div>
					<input type="hidden" id="user_type" value="administrator"/>
				</div>
				<?php } ?>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-success" onclick="javascript:change_password();">确定修改</button>&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-info" onclick="javascript:history.go(-1);">返回上一页</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>