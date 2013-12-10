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
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
			function submit_form() {
				return check_register_email() && check_password() && check_realname() && reshape_password();
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
						<h3>管理帐号注册</h3>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">请输入登录邮箱:</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email"/>
						<span id="email_correct" class="correct_tips">OK</span>
						<span id="email_error" class="error_tips">Email Not Correct</span>
						<span id="email_used" class="error_tips">Email is used thus not available</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">设定密码(长度至少六位):</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password"/>
						<span id="pswd_correct" class="correct_tips">OK</span>
						<span id="pswd_short" class="error_tips">Password Length less than 6</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">确定密码:</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password_confirm" id="inputPassword3" placeholder="Confirm Password"/>
						<span id="pswd_correct" class="correct_tips">OK</span>
						<span id="pswd_firm_short" class="error_tips">Password Length less than 6</span>
						<span id="pswd_different" class="error_tips">Password not the same</span>
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
					<label for="inputAdmin3" class="col-sm-2 control-label">管理员类型:</label>
					<div class="col-sm-10">
						<select class="form-control" name="permission">
							<option value="2">领事馆</option>
							<option value="3">办事处</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputAgency3" class="col-sm-2 control-label">所属办事处:</label>
					<div class="col-sm-10">
						<select class="form-control" name="province_id">
							<option value="1">北京</option>
							<option value="2">广东</option>
							<option value="3">上海</option>
						</select>
					</div>
				</div>
				<div>
					<input type="hidden" id="user_type" name="user_type" value="administrator"/>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit"  class="btn btn-default">注册</button>
						<a class="login" href="/admin_login" style="margin-left:12px;">已有帐号？点此登录</a>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>