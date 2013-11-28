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
			<a href="">basic info</a>
			<a href="">passport info</a>
			<a href="">travel info</a>
			<a href="">other info</a>
		</div>
		<p></p>
		<div id="filling_info">
			<form id="travel_form" method="POST" action="update_travel_info">
				<input type="hidden" name="unipue_uuid" value="<?php echo $uuid;?>"/>
				<input type="hidden" name="userid" value="4338"/>
				<p>11、Purpose of Visit 访瓦目的:<br>
				Tourism 旅游<input type="radio" name="purpose" value="8"/>
				Visiting Relative 探亲<input type="radio" name="purpose" value="9"/>
				Business 商务<input type="radio" name="purpose" value="10"/>
				Other 其他<input type="radio" name="purpose" value="11"/></p>
				<p>12、Address in Vanuatu 在瓦地址:
				<input type="text" name="destination" value="<?php echo $destination;?>"/></p>
				<p>13、Details of Family in Vanuatu if visiting relative 如属探亲在瓦亲属概况:<br>
				Name 姓名:
				<input type="text" name="relative_name" value="<?php echo $relative_info['relative_name'];?>"/>
				Add. 地址:
				<input type="text" name="relative_addr" value="<?php echo $relative_info['relative_addr'];?>"/></p>
				<p>14、Details of arrival in Vanuatu抵瓦航班号:
				<input type="text" name="arrival_number" value="<?php echo $detail_info['arrival_number']?>"/>
				日期:
				<input type="text" name="arrival_date" value="<?php echo $detail_info['arrival_date']?>"/></p>
				<p>15、Details of return ticket 回程航班号:
				<input type="text" name="return_number" value="<?php echo $detail_info['return_number']?>"/>
				日期:
				<input type="text" name="return_date" value="<?php echo $detail_info['return_date']?>"/></p>
				<p>16、Proposed duration of stay 拟在瓦逗留时间:
				<input type="text" name="duration" value="<?php echo $detail_info['duration']?>"/></p>
				<p>17、Source of financial support in Vanuatu 在瓦费用来源:
				<input type="text" name="financial_source" value="<?php echo $detail_info['financial_source']?>"/></p>
				<button type="submit">保存并下一步</button>
				<p style="border-bottom:1px dashed #000; width=200px;">测试一下啦啦啦啦啦了乐乐乐乐斯蒂芬速度嘎我</p>
			</form>
		</div>
	</body>
</html>