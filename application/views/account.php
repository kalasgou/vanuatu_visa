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
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
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
						<h3>帐号资料信息</h3>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">注册邮箱:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $email;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputNickname3" class="col-sm-2 control-label">帐户姓名:</label>
					<div class="col-sm-10">
						<!--<input type="text" class="form-control" name="nickname" id="inputNickname3" value="" placeholder="Nickname">-->
						<p class="form-control-static"><?php echo $nickname;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputProvince3" class="col-sm-2 control-label">所属省份:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $province_str;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCity3" class="col-sm-2 control-label">所属城市:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $city_str;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputAgency3" class="col-sm-2 control-label">所属机构:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $agency;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPhone3" class="col-sm-2 control-label">联系电话:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $telephone;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPermission3" class="col-sm-2 control-label">帐户类型:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $permission_str;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputRegtime3" class="col-sm-2 control-label">注册时间:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $reg_time;?></p>
					</div>
				</div>
				<div class="form-group">
					<label for="inputStatus3" class="col-sm-2 control-label">帐户状态:</label>
					<div class="col-sm-10">
						<p class="form-control-static"><?php echo $status_str;?></p>
					</div>
				</div>
				<!--<?php if ($permission == 10000) { ?>
				<div>
					<input type="hidden" name="user_type" value="applicant"/>
				</div>
				<?php } else if ($permission == 1 || $permission == 2 || $permission == 3) { ?>
				<div>
					<input type="hidden" name="user_type" value="administrator"/>
				</div>
				<?php } ?>
				<div class="form-group">
					<label for="inputCaptcha3" class="col-sm-2 control-label">验证码:</label>
					<div class="col-sm-10">
						<input type="captcha" class="form-control" name="captcha" id="inputCaptcha3" placeholder="Captcha"/><br>
						<span id="captcha"><?php echo $captcha;?></span> <a href="javascript:void(0);" onclick="refresh_captcha();">换过另一张</a>
					</div>
				</div>-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<!--<button type="button" class="btn btn-default" onclick="javascript:update_info();">更新资料</button>&nbsp;&nbsp;&nbsp;-->
						<button type="button" class="btn btn-info" onclick="javascript:history.go(-1);">返回上一页</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>