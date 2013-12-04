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
		<style type="text/css">
		</style>
	</head>
	<body>
		<div>
			<h4>Hello, <?php echo $realname;?>!</h4>
		</div>
		<div id="step_menu" style="display:inline;">
			<a href="/admin/approve">审批签证</a>
			<a href="/admin/approve_records">审批记录</a>
			<a href="/admin/account">帐户信息</a>
			<a href="/admin/password">密码修改</a>
			<a href="/user/logout">退出登录</a>
		</div>
	</body>
</html>