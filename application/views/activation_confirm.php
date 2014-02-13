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
			
			function activate_account(decision) {
				switch(decision) {
					case 'yes': 
								location.href = '/user/activate/' + $('#activation_code').val();
								break;
					case 'no': 
								if (confirm('确定要取消本次验证与激活操作吗？')) {
									alert('你已取消本次帐号验证与激活操作。如需激活本帐号，可登录帐号后根据提示重新获取链接。点击“确认”页面将会自动关闭。');
								}
								window.close();
								break;
				}
			}
		</script>
		<style type="text/css">
		</style>
	</head>
	<body>
		<div>
			<form class="" >
				<input type="hidden" id="activation_code" value="<?php echo $hash_key;?>"/>
				<p>&nbsp;&nbsp;&nbsp;你现在要激活（验证）的帐户为：<b><?php echo $email;?></b></p>
				<p>&nbsp;&nbsp;&nbsp;<?php echo $tips;?></p>
				<p>
					&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-success btn-small" onclick="javascript:activate_account('yes');">激活</button>
					&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-warning btn-small" onclick="javascript:activate_account('no');">取消</button>
				</p>
			</form>
		</div>
	</body>
</html>