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
		<script type="text/javascript" src=""/></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<div>
			<form id="" method="post" action="/user/register">
				<div>
					<h3>普通帐员注册</h3>
				</div>
				<div>
					<input type="hidden" name="user_type" value="applicant"/>
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
					确定登录密码:<br>
					<input type="password" id="pswd_2" placeholder="密码"/>
				</div>
				<div>
					帐户昵称:<br>
					<input type="text" name="nickname" placeholder="昵称"/>
				</div>
				<div>
					真实姓名:<br>
					<input type="text" name="realname" placeholder="姓名"/>
				</div>
				<div>
					联系电话:<br>
					<input type="text" name="phone" placeholder="号码"/>
				</div>
				<div>
					<input id="agreement" type="checkbox">
					<span>我已阅读并同意</span>
					<a id="agreement-link" href="">XXXXXXXX协议</a>
				</div>
				<div>
					<button type="submit">注册</button>
					<a class="login" href="/login" title="已有帐号？点此登录">已有帐号？点此登录</a>
				</div>
			</form>
		</div>
	</body>
</html>