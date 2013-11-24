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
			<a>basic info</a>
			<a href="passport_info">passport info</a>
			<a href="travel_info">travel info</a>
			<a href="other_info">other info</a>
		</div>
		<p></p>
		<div id="filling_info">
			<form id="basic_form" method="POST" action="update_basic_info">
				<input type="hidden" name="unipue_uuid" value="<?php echo $uuid;?>"/>
				<p>1、Full name 姓名:
				(English英文)<input type="text" name="name_en" value="<?php echo $name_en;?>"/>
				(Chinese中文)<input type="text" name="name_cn" value="<?php echo $name_cn;?>"/></p>
				<!--<input type="checkbox" name="gender" checked="checked" disabled="disabled"/>
				<input type="checkbox" name="gender" disabled="disabled"/>
				<input type="checkbox" name="gender" disabled="disabled"/>-->
				<p>2、Mr.先生<input type="radio" name="gender" value="1"/>&nbsp;/
				Mrs.女士<input type="radio" name="gender" value="2"/>&nbsp;/
				Miss小姐<input type="radio" name="gender" value="3"/></p>
				<p>3、Nationality 国籍:
				<input type="text" name="nationality" value="<?php echo $nationality;?>"/></p>
				<p>4、Date of Birth 出生日期:
				Day 日<input type="text" name="birth_day" value="<?php echo $birth_day;?>"/>/
				Month 月<input type="text" name="birth_month" value="<?php echo $birth_month;?>"/>/
				Year 年<input type="text" name="birth_year" value="<?php echo $birth_year;?>"/></p>
				<p>5、Place of birth 出生地点:
				<input type="text" name="birth_place" value="<?php echo $birth_place;?>"/></p>
				<p>6、Family Situation 婚姻状况:
				Married已婚<input type="radio" name="family" value="4"/>
				Single单身<input type="radio" name="family" value="5"/>
				Widowed丧偶<input type="radio" name="family" value="6"/>
				Divorced离异<input type="radio" name="family" value="7"/></p>
				<p>7、Occupation 职业:
				<input type="text" name="occupation" value="<?php echo $occupation_info['occupation'];?>"/></p>
				<p>8、(a) Employer 就业单位:
				<input type="text" name="employer" value="<?php echo $occupation_info['employer'];?>"/>
				Tel No.电话:
				<input type="text" name="employer_tel" value="<?php echo $occupation_info['employer_tel'];?>"/><br>
				&nbsp;&nbsp;&nbsp;(b) Address 单位地址:
				<input type="text" name="employer_addr" value="<?php echo $occupation_info['employer_addr'];?>"/></p>
				<p>9、Home Address 家庭住址:
				<input type="text" name="home_addr" value="<?php echo $home_info['home_addr'];?>"/><br>
				&nbsp;&nbsp;&nbsp;Tel No.电话:
				<input type="text" name="home_tel" value="<?php echo $home_info['home_tel'];?>"/></p>
			</form>
		</div>
	</body>
</html>