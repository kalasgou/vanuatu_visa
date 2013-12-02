<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href='/common.css'/>
		<link rel="stylesheet" type="text/css" href=''/>
		<script type="text/javascript" src=""/></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
		<style type="text/css">
			#children_info input {
				font-family:宋体;
				font-size: 18px;
				text-align: center;
				line-height: 15px;
				border-top-width: 0px;
				border-right-width: 0px;
				border-bottom-width: 0px;
				border-left-width: 0px;
				width: 100%;
			}
		</style>
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
			<form id="passport_form" method="POST" action="/apply/update_complement_info">
				<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
				<p>18、Details of family included in passport 护照内偕行儿童详细信息:<br>
				<table id="children_info">
					<tr>
						<th>Name 姓名</th>
						<th>Sex 性别</th>
						<th>Date of birth 出生日期</th>
						<th>Place of birth 出生地</th>
					</tr>
					<?php foreach ($children_info as $kid) { ?>
					<tr>
						<td><input type="text" name="child_name[]" value="<?php echo $kid['child_name'];?>"/></td>
						<td><input type="text" name="child_sex[]" value="<?php echo $kid['child_sex'];?>"/></td>
						<td><input type="text" name="child_date[]" value="<?php echo $kid['child_date'];?>"/></td>
						<td><input type="text" name="child_place[]" value="<?php echo $kid['child_place'];?>"/></td>
					</tr>
					<?php } ?>
				</table></p>
				<p>19、(a) Been convicted of or have any charges outstanding on a criminal offence in any country<br>
				是否在任何国家有过犯罪记录:
				Yes是<input type="radio" name="criminal"/> Where哪一国家 <input type="text" name="crime_country" style="width:150px" value="<?php echo $behaviour_info['crime_country'];?>"/> No否<input type="radio" name="criminal"/><br>
				(b) Been deported or excluded from any country<br>
				是否有被任何国家驱逐出境的经历:
				Yes是<input type="radio" name="deported"/> Where哪一国家 <input type="text" name="deport_country" style="width:150px" value="<?php echo $behaviour_info['deport_country'];?>"/> No否<input type="radio" name="deported"/></p>
				<p>20、Details of previous visits? 您曾经到过瓦努阿图吗？Yes有 <input type="radio" name="visited"/> No没有<input type="radio" name="visited"/></p>
				<p>21、Have you ever applied for a work, residence or student permit before in Vanuatu? <br>您是否曾经在瓦努阿图申请过工作、居留或学生签证？
				Yes是<input type="radio" name="applied"/> When何时 <input type="text" name="apply_date" style="width:150px" value="<?php echo $behaviour_info['apply_date'];?>"/> No否<input type="radio" name="applied"/></p>
				<p>22、Have you ever been refused entry to Vanuatu?<br>
				您曾经被瓦努阿图拒签过吗？
				Yes是<input type="radio" name="refused"/> When何时 <input type="text" name="refuse_date" style="width:150px" value="<?php echo $behaviour_info['refuse_date'];?>"/> No否<input type="radio" name="refused"/></p>
				<!--<p>23、I declare that the information given in this application is true and correct to the best of my knowledge and belief.<br>
				我声明，本人在本申请表中所做之回答就本人所知均属实无误。<br>
				Signature 签字<input type="text" name="purpose"/>Date 日期<input type="text" name="purpose"/>.<br>
				(The holder of a visitor visa must not work or study in Vanuatu. <br>旅游签证持有者在旅游期间不得在瓦努阿图工作或学习。)</p>-->
				<button id="next_step" type="submit">提交</button>
				<p></p>
			</form>
		</div>
	</body>
</html>