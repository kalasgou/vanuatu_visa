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
				province_list();
			});
			
			function submit_form() {
				return check_register_email() && check_password() && check_nickname() && check_province_city_agency() && check_phone() && reshape_password();
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
						<h3>Vanuatu签证系统帐号注册</h3>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">请输入登录邮箱:</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email"/>
						<span id="email_error" class="error_tips">电子邮箱格式不正确</span>
						<span id="email_used" class="error_tips">该电子邮箱已被注册，请选择另一个有效的邮箱地址</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">设定密码(长度至少六位):</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password"/>
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
					<label for="inputNickname3" class="col-sm-2 control-label">用户姓名:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nickname" id="inputNickname3" placeholder="Name"/>
						<span id="nickname_empty" class="error_tips">请填写用户姓名</span>
						<span id="nickname_used" class="error_tips">该用户姓名已被使用，请选择另一个</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPermission3" class="col-sm-2 control-label">帐号类型:</label>
					<div class="col-sm-10">
						<select class="form-control" id="permissions" name="permission" onchange="agency_list();">
							<option value="<?php echo RESERVATION_USER;?>">预约用户</option>
							<option value="<?php echo OFFICE_ADMIN;?>">办事处</option>
							<option value="<?php echo EMBASSY_ADMIN;?>">领事馆</option>
							<option value="<?php echo CUSTOMER_SERVICE;?>">客服员</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputProvince3" class="col-sm-2 control-label">所属省份:</label>
					<div class="col-sm-10">
						<select class="form-control" id="provinces" name="province_id" onchange="city_list();">
							<option value="0">加载中</option>
						</select>
						<span id="province_empty" class="error_tips">请选择有效的省份</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputCity3" class="col-sm-2 control-label">所属城市:</label>
					<div class="col-sm-10">
						<select class="form-control" id="cities" name="city_id" onchange="agency_list();">
							<option value="0">加载中</option>
						</select>
						<span id="city_empty" class="error_tips">请选择有效的城市</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputAgency3" class="col-sm-2 control-label">所属机构:</label>
					<div class="col-sm-10">
						<select class="form-control" id="agencies" name="agency_id" onchange="">
							<option value="0">加载中</option>
						</select>
						<input id="agency_text" name="agency" type="hidden" value=""/>
						<span id="agency_empty" class="error_tips">请选择有效的机构</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPhone3" class="col-sm-2 control-label">联系电话(区号-固话或手机):</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" name="telephone" id="inputPhone3" placeholder="Code-Number / Mobile"/>
						<span id="phone_error" class="error_tips">请填写有效的联系电话号码（固话需加区号-）</span>
					</div>
				</div>
				<!--<div class="form-group">
					<label for="inputCaptcha3" class="col-sm-2 control-label">验证码:</label>
					<div class="col-sm-10">
						<input type="captcha" class="form-control" name="captcha" id="inputCaptcha3" placeholder="Captcha"/><br>
						<span id="captcha"><?php echo $captcha;?></span> <a href="javascript:void(0);" onclick="refresh_captcha();">换过另一张</a>
					</div>
				</div>
				<div>
					<input type="hidden" id="user_type" name="user_type" value="applicant"/>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input id="agreement" type="checkbox"/>
						<span>我已阅读并同意</span>
						<a id="agreement-link" href="/agreement">XXXXXXXX协议</a>
					</div>
				</div>-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-success">注册</button>&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-default" onclick="javascript:location.href = '/admin/account';">返回上一页</button>
						<!--<a class="login" href="/login" style="margin-left:12px;">已有帐号？点此登录</a>-->
					</div>
				</div>
			</form>
			<div>注：除客服员外，其余帐户类型务必要选择省份、城市和相应机构，否则无法正常工作。</div>
		</div>
	</body>
</html>