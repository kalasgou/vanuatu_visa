<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href=''/>
		<script type="text/javascript" src=""></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<div>
			<form id="" method="post" action="/user/register">
				<div>
					<h3>管理员注册</h3>
				</div>
				<div>
					<input type="hidden" name="user_type" value="administrator"/>
				</div>
				<div>
					请输入邮箱(将作为您的登录帐号):<br>
					<input type="text" name="email" placeholder="邮箱"/>
				</div>
				<div>
					设定登录密码(长度至少六位):<br>
					<input type="password" id="pswd_1" name="password" placeholder="密码"/>
				</div>
				<div>
					确认登录密码:<br>
					<input type="password" id="pswd_2" placeholder="确认密码"/>
				</div>
				<div>
					真实姓名:<br>
					<input type="text" name="realname" placeholder="姓名"/>
				</div>
				<div>
					管理员类型:<br>
					<select name="permission">
						<option value="2">领事馆</option>
						<option value="3">办事处</option>
					</select>
				</div>
				<div>
					所属办事处:<br>
					<select name="province_id">
						<option value="1">北京</option>
						<option value="2">广东</option>
						<option value="3">上海</option>
					</select>
				</div>
				<div>
					<button type="submit">注册</button>
					<a class="login" href="/admin_login" title="已有帐号？点此登录">已有帐号？点此登录</a>
				</div>
			</form>
		</div>
	</body>
</html>