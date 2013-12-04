<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href="/common.css"/>
		<link rel="stylesheet" type="text/css" href="/dist/css/bootstrap.css"/>
		<script type="text/javascript" src=""></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<div id="step_box" style="position:relative; margin:auto; width:1280px;">
			<div id="procedure" class="list_group">
				<a class="list-group-item" href="/apply/agencies/<?php echo $uuid;?>">选择办事处</a>
				<a class="list-group-item" href="/apply/basic_info/<?php echo $uuid;?>">基本个人信息</a>
				<a class="list-group-item" href="/apply/passport_info/<?php echo $uuid;?>">护照信息</a>
				<a class="list-group-item active">行程信息</a>
				<a class="list-group-item" href="/apply/complement_info/<?php echo $uuid;?>">其他补充信息</a>
				<a class="list-group-item" href="/apply/confirm_info/<?php echo $uuid;?>">所填信息确认</a>
			</div>
			<p></p>
			<div id="filling_info">
				<form id="travel_form" method="POST" action="/apply/update_travel_info">
					<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
					<p>11、Purpose of Visit 访瓦目的:<br>
					Tourism 旅游<input type="radio" name="purpose" value="8" <?php echo ($purpose == 8 ? 'checked="checked"' : '')?>/>
					Visiting Relative 探亲<input type="radio" name="purpose" value="9" <?php echo ($purpose == 9 ? 'checked="checked"' : '')?>/>
					Business 商务<input type="radio" name="purpose" value="10" <?php echo ($purpose == 10 ? 'checked="checked"' : '')?>/>
					Other 其他<input type="radio" name="purpose" value="11" <?php echo ($purpose == 11 ? 'checked="checked"' : '')?>/></p>
					<p>12、Address in Vanuatu 在瓦地址:
					<input type="text" name="destination" style="width:300px" value="<?php echo $destination;?>"/></p>
					<p>13、Details of Family in Vanuatu if visiting relative 如属探亲在瓦亲属概况:<br>
					Name 姓名:
					<input type="text" name="relative_name" style="width:150px" value="<?php echo $relative_info['relative_name'];?>"/>
					Add. 地址:
					<input type="text" name="relative_addr" style="width:300px" value="<?php echo $relative_info['relative_addr'];?>"/></p>
					<p>14、Details of arrival in Vanuatu 抵瓦航班号:
					<input type="text" name="arrival_number" style="width:150px" value="<?php echo $detail_info['arrival_number']?>"/>
					日期:
					<input type="text" name="arrival_date" style="width:150px" value="<?php echo $detail_info['arrival_date']?>"/></p>
					<p>15、Details of return ticket 回程航班号:
					<input type="text" name="return_number" style="width:150px" value="<?php echo $detail_info['return_number']?>"/>
					日期:
					<input type="text" name="return_date" style="width:150px" value="<?php echo $detail_info['return_date']?>"/></p>
					<p>16、Proposed duration of stay 拟在瓦逗留时间:
					<input type="text" name="duration" value="<?php echo $detail_info['duration']?>"/></p>
					<p>17、Source of financial support in Vanuatu 在瓦费用来源:
					<input type="text" name="financial_source" value="<?php echo $detail_info['financial_source']?>"/></p>
					<button id="next_step" type="submit">下一步</button>
				</form>
			</div>
		</div>
	</body>
</html>