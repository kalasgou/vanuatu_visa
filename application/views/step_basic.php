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
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>您好，<?php echo $user['realname'];?>！</h5>
			</div>
			<div id="menu">
				<a href="/apply">申请记录</a> / 
				<a style="color:#1100FF;">签证申请</a> / 
				<a href="/account">帐户信息</a> / 
				<a href="/password">密码修改</a> / 
				<a href="/logout">安全登出</a>
			</div>
		</nav>
		<div id="step_box">
			<div id="procedure" class="list_group">
				<a class="list-group-item" href="/apply/agencies/<?php echo $uuid;?>">选择办事处</a>
				<a class="list-group-item active">基本个人信息</a>
				<a class="list-group-item" href="/apply/passport_info/<?php echo $uuid;?>">护照信息</a>
				<a class="list-group-item" href="/apply/travel_info/<?php echo $uuid;?>">行程信息</a>
				<a class="list-group-item" href="/apply/complement_info/<?php echo $uuid;?>">其他补充信息</a>
				<a class="list-group-item" href="/apply/scan_file/<?php echo $uuid;?>">证明文件上传</a>
				<a class="list-group-item" href="/apply/fee_payment/<?php echo $uuid;?>">费用交纳</a>
				<a class="list-group-item" href="/apply/confirm_info/<?php echo $uuid;?>">所填信息确认</a>
			</div>
			<p></p>
			<div id="filling_info">
				<form id="basic_form" method="POST" action="/apply/update_basic_info">
					<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
					<p>1、Full name 姓名:
					(English英文)<input type="text" name="name_en" value="<?php echo $name_en;?>"/>
					(Chinese中文)<input type="text" name="name_cn" value="<?php echo $name_cn;?>"/></p>
					<!--<input type="checkbox" name="gender" checked="checked" disabled="disabled"/>
					<input type="checkbox" name="gender" disabled="disabled"/>
					<input type="checkbox" name="gender" disabled="disabled"/>-->
					<p>2、Mr.先生<input type="radio" name="gender" value="1" <?php echo ($gender == 1 ? 'checked="checked"' : '')?>/>&nbsp;/
					Mrs.女士<input type="radio" name="gender" value="2" <?php echo ($gender == 2 ? 'checked="checked"' : '')?>/>&nbsp;/
					Miss小姐<input type="radio" name="gender" value="3" <?php echo ($gender == 3 ? 'checked="checked"' : '')?>/></p>
					<p>3、Nationality 国籍:
					<input type="text" name="nationality" value="<?php echo $nationality;?>"/></p>
					<p>4、Date of Birth 出生日期:
					Day 日<input type="text" name="birth_day" style="width:100px;" placeholder="dd" value="<?php echo $birth_day;?>"/>&nbsp;/&nbsp;
					Month 月<input type="text" name="birth_month" style="width:100px;" placeholder="mm" value="<?php echo $birth_month;?>"/>&nbsp;/&nbsp;
					Year 年<input type="text" name="birth_year" style="width:100px;" placeholder="yyyy" value="<?php echo $birth_year;?>"/></p>
					<p>5、Place of birth 出生地点:
					<input type="text" name="birth_place" value="<?php echo $birth_place;?>"/></p>
					<p>6、Family Situation 婚姻状况:
					Married已婚<input type="radio" name="family" value="4" <?php echo ($family == 4 ? 'checked="checked"' : '')?>/>
					Single单身<input type="radio" name="family" value="5" <?php echo ($family == 5 ? 'checked="checked"' : '')?>/>
					Widowed丧偶<input type="radio" name="family" value="6" <?php echo ($family == 6 ? 'checked="checked"' : '')?>/>
					Divorced离异<input type="radio" name="family" value="7" <?php echo ($family == 7 ? 'checked="checked"' : '')?>/></p>
					<p>7、Occupation 职业:
					<input type="text" name="occupation" value="<?php echo $occupation_info['occupation'];?>"/></p>
					<p>8、(a) Employer 就业单位:
					<input type="text" name="employer" style="width:300px;" value="<?php echo $occupation_info['employer'];?>"/>
					Tel No.电话:
					<input type="text" name="employer_tel" style="width:150px;" value="<?php echo $occupation_info['employer_tel'];?>"/><br>
					(b) Address 单位地址:
					<input type="text" name="employer_addr" style="width:400px;" value="<?php echo $occupation_info['employer_addr'];?>"/></p>
					<p>9、Home Address 家庭住址:
					<input type="text" name="home_addr" style="width:400px;" value="<?php echo $home_info['home_addr'];?>"/><br>
					Tel No.电话:
					<input type="text" name="home_tel" style="width:150px;" value="<?php echo $home_info['home_tel'];?>"/></p>
					<br>
					<p id="notice">注意：以上皆为必填项，需全部填写正确才能进入下一步。</p>
					<button id="next_step" type="submit" class="btn btn-success btn-sm">下一步</button>
				</form>
			</div>
		</div>
	</body>
</html>