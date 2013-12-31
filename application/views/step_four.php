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
		<script type="text/javascript" src=""></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>你好，<?php echo $user['realname'];?>！</h5>
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
				<a class="list-group-item" href="/apply/basic_info/<?php echo $uuid;?>">基本个人信息</a>
				<a class="list-group-item" href="/apply/passport_info/<?php echo $uuid;?>">护照信息</a>
				<a class="list-group-item" href="/apply/travel_info/<?php echo $uuid;?>">行程信息</a>
				<a class="list-group-item active">其他补充信息</a>
				<a class="list-group-item" href="/apply/confirm_info/<?php echo $uuid;?>">所填信息确认</a>
			</div>
			<p></p>
			<div id="filling_info">
				<form id="passport_form" method="POST" action="/apply/update_complement_info">
					<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
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
					<p id="notice">注意：以上除带*标记为选填项，其余皆为必填项，需全部填写正确才能进入下一步。</p>
					<button id="next_step" type="submit" class="btn btn-success btn-sm">提交</button>
					<p></p>
				</form>
			</div>
		</div>
	</body>
</html>