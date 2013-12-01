<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href='/common.css'>
		<script type="text/javascript" src=""/>
		<script type="text/javascript" src=""/>
		<script type="text/javascript" src=""/>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<div id="step_menu" style="display:inline;">
			<a href="/apply/agencies/<?php echo $uuid;?>">选择办事处</a>
			<a href="/apply/basic_info/<?php echo $uuid;?>">基本个人信息</a>
			<a href="/apply/passport_info/<?php echo $uuid;?>">护照信息</a>
			<a href="/apply/travel_info/<?php echo $uuid;?>">行程信息</a>
			<a href="/apply/complement_info/<?php echo $uuid;?>">其他补充信息</a>
			<a href="/apply/confirm_info/<?php echo $uuid;?>">所填信息确认</a>
		</div>
		<p></p>
		<div id="filling_info">
			<form id="passport_form" method="POST" action="/apply/update_passport_info">
				<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
				<p>10、Passport 护照:<br>
				(a) Number 护照号<input type="text" name="passport_number" value="<?php echo $passport_number;?>"/>
				(b) Place of Issue 发照地<input type="text" name="passport_place" value="<?php echo $passport_place;?>"/><br>
				(c) Date of Issue发照日期<input type="text" name="passport_date" value="<?php echo $passport_date;?>"/>
				(d) Expiry Date 有效日期至<input type="text" name="passport_expiry" value="<?php echo $passport_expiry;?>"/></P>
				<button type="submit">保存并下一步</button>
			</form>
		</div>
	</body>
</html>