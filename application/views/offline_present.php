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
		<script type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			
		</script>
		<style type="text/css">
			.form-control {width: 60px;}
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
			<form id="basic_form" method="POST" action="/admin/submit_present">
				<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
				<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
				<input type="hidden" name="province_id" value="<?php echo $province_id;?>"/>
				<p>1、Full name 姓名:
				(English英文)<input type="text" name="name_en" value="<?php echo $name_en;?>"/>
				(Chinese中文)<input type="text" name="name_cn" value="<?php echo $name_cn;?>"/></p>
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
				<p>10、Passport 护照:<br>
				(a) Number 护照号<input type="text" name="passport_number" value="<?php echo $passport_number;?>"/>
				(b) Place of Issue 发照地<input type="text" name="passport_place" value="<?php echo $passport_place;?>"/><br>
				(c) Date of Issue发照日期<input type="text" name="passport_date" style="width:150px" value="<?php echo $passport_date;?>" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd'})"/>
				(d) Expiry Date 有效日期至<input type="text" name="passport_expiry" style="width:150px" value="<?php echo $passport_expiry;?>" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd'})"/></P>
				<p>11、Purpose of Visit 访瓦目的:<br>
				Tourism 旅游<input type="radio" name="purpose" value="8" <?php echo ($purpose == 8 ? 'checked="checked"' : '')?>/>
				Visiting Relative 探亲<input type="radio" name="purpose" value="9" <?php echo ($purpose == 9 ? 'checked="checked"' : '')?>/>
				Business 商务<input type="radio" name="purpose" value="10" <?php echo ($purpose == 10 ? 'checked="checked"' : '')?>/>
				Other 其他<input type="radio" name="purpose" value="11" <?php echo ($purpose == 11 ? 'checked="checked"' : '')?>/>
				<input type="text" name="other_purpose" style="width:128px" value="<?php echo $other_purpose;?>"/></p>
				<p>12、Address in Vanuatu 在瓦地址:
				<input type="text" name="destination" style="width:300px" value="<?php echo $destination;?>"/></p>
				<p>13、Details of Family in Vanuatu if visiting relative 如属探亲在瓦亲属概况*:<br>
				Name 姓名:
				<input type="text" name="relative_name" style="width:150px" value="<?php echo $relative_info['relative_name'];?>"/>
				Add. 地址:
				<input type="text" name="relative_addr" style="width:300px" value="<?php echo $relative_info['relative_addr'];?>"/></p>
				<p>14、Details of arrival in Vanuatu 抵瓦航班号:
				<input type="text" name="arrival_number" style="width:150px" value="<?php echo $detail_info['arrival_number']?>"/>
				日期:
				<input type="text" name="arrival_date" style="width:150px" value="<?php echo $detail_info['arrival_date']?>" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd'})"/></p>
				<p>15、Details of return ticket 回程航班号:
				<input type="text" name="return_number" style="width:150px" value="<?php echo $detail_info['return_number']?>"/>
				日期:
				<input type="text" name="return_date" style="width:150px" value="<?php echo $detail_info['return_date']?>" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd'})"/></p>
				<p>16、Proposed duration of stay 拟在瓦逗留时间:
				<input type="text" name="duration" value="<?php echo $detail_info['duration']?>"/></p>
				<p>17、Source of financial support in Vanuatu 在瓦费用来源:
				<input type="text" name="financial_source" value="<?php echo $detail_info['financial_source']?>"/></p>
				<p>18、Details of family included in passport 护照内偕行儿童详细信息*:<br>
				<table id="children_info">
					<thead>
						<tr>
							<th>Name 姓名</th>
							<th>Sex 性别</th>
							<th>Date of birth 出生日期</th>
							<th>Place of birth 出生地</th>
						</tr>
					</thead>
					</tbody>
						<?php foreach ($children_info as $kid) { ?>
						<tr>
							<td><input type="text" name="child_name[]" value="<?php echo $kid['child_name'];?>"/></td>
							<td><input type="text" name="child_sex[]" value="<?php echo $kid['child_sex'];?>"/></td>
							<td><input type="text" name="child_date[]" value="<?php echo $kid['child_date'];?>" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd', maxDate:'%y-%M-%d'})"/></td>
							<td><input type="text" name="child_place[]" value="<?php echo $kid['child_place'];?>"/></td>
						</tr>
						<?php } ?>
					</tbody>
				</table></p>
				<p>19、(a) Been convicted of or have any charges outstanding on a criminal offence in any country<br>
				是否在任何国家有过犯罪记录:
				Yes是<input type="radio" name="criminal" value="on" <?php echo ($behaviour_info['criminal'] === 'on' ? 'checked="checked"' : '')?>/> Where哪一国家 <input type="text" name="crime_country" style="width:150px" value="<?php echo $behaviour_info['crime_country'];?>"/> No否 <input type="radio" name="criminal" value="off" <?php echo ($behaviour_info['criminal'] === 'off' ? 'checked="checked"' : '')?>/><br>
				(b) Been deported or excluded from any country<br>
				是否有被任何国家驱逐出境的经历:
				Yes是<input type="radio" name="deported" value="on" <?php echo ($behaviour_info['deported'] === 'on' ? 'checked="checked"' : '')?>/> Where哪一国家 <input type="text" name="deport_country" style="width:150px" value="<?php echo $behaviour_info['deport_country'];?>"/> No否 <input type="radio" name="deported" value="off" <?php echo ($behaviour_info['deported'] === 'off' ? 'checked="checked"' : '')?>/></p>
				<p>20、Details of previous visits? 您曾经到过瓦努阿图吗？Yes有 <input type="radio" name="visited" value="on" <?php echo ($behaviour_info['visited'] === 'on' ? 'checked="checked"' : '')?>/> No没有 <input type="radio" name="visited" value="off" <?php echo ($behaviour_info['visited'] === 'off' ? 'checked="checked"' : '')?>/></p>
				<p>21、Have you ever applied for a work, residence or student permit before in Vanuatu? <br>您是否曾经在瓦努阿图申请过工作、居留或学生签证？
				Yes是<input type="radio" name="applied" value="on" <?php echo ($behaviour_info['applied'] === 'on' ? 'checked="checked"' : '')?>/> When何时 <input type="text" name="apply_date" style="width:150px" value="<?php echo $behaviour_info['apply_date'];?>"/> No否 <input type="radio" name="applied" value="off" <?php echo ($behaviour_info['applied'] === 'off' ? 'checked="checked"' : '')?>/></p>
				<p>22、Have you ever been refused entry to Vanuatu?<br>
				您曾经被瓦努阿图拒签过吗？
				Yes是<input type="radio" name="refused" value="on" <?php echo ($behaviour_info['refused'] === 'on' ? 'checked="checked"' : '')?>/> When何时 <input type="text" name="refuse_date" style="width:150px" value="<?php echo $behaviour_info['refuse_date'];?>"/> No否 <input type="radio" name="refused" value="off" <?php echo ($behaviour_info['refused'] === 'off' ? 'checked="checked"' : '')?>/></p>
				<br>
				<div id="next_step">
					<button type="submit" class="btn btn-success">提交</button>
				</div>
			</form>
		</div>
		<br>
	</body>
</html>