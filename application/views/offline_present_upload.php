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
		<script type="text/javascript" src=""></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
		<style type="text/css">
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>您好，办事处管理员 <?php echo $user['nickname'];?>！</h5>
			</div>
			<div id="menu">
				<a href="/admin/audit">审核申请</a> / 
				<a href="/admin/audit_trace">审核记录</a> / 
				<a style="color:#1100FF;">线下申请</a> / 
				<a href="/account">帐户信息</a> / 
				<a href="/password">密码修改</a> / 
				<a href="/logout">安全登出</a>
			</div>
		</nav>
		<div id="filling_info" style="top:0px; left:0px;">
			<form id="basic_form" method="POST" action="/admin/upload_scan_file" enctype="multipart/form-data">
				<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
				<p>上传护照扫描件:</p>
				<p>
					<input type="file" name="passport"/>
				</p>
				<p><img src="<?php echo $passport_pic;?>" alt="护照" style="width:822px;"/></P>
				<p id="notice">注意：请限制文件大小在3MB以内避免上传时间过长或无法上传；分辨率不小于800×600像素。</p>
				<button id="next_step" type="button" class="btn btn-success" onclick="javascript:location.href='/admin/audit?orderby=5';">确定</button>
				<button id="next_step" type="submit" class="btn btn-primary" style="margin-right:12px;">上传</button>
			</form>
		</div>
		<br>
	</body>
</html>