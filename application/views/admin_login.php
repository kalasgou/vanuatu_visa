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
			<form id="" method="post" action="/user/login">
				<div>
					<h3>管理员登录</h3>
				</div>
				<div>
					<input type="hidden" name="user_type" value="administrator"/>
				</div>
				<table>
					<tr>
						<td>邮箱：</td>
						<td><input type="text" name="email" placeholder="注册邮箱"/></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td><input type="password" name="password" placeholder="密码"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="登录"/></td>
					</tr>
				</table>
			</form>
			<div>
				<a class="register" href="/admin_register">点此注册新用户</a>
			</div>
		</div>
	</body>
</html>