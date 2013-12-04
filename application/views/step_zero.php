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
		<style type="text/css">
		</style>
	</head>
	<body>
		<div id="step_box" style="position:relative; margin:auto; width:1280px;">
			<div id="procedure" class="list_group">
				<a class="list-group-item active">选择办事处</a>
				<a class="list-group-item" href="/apply/basic_info/<?php echo $uuid;?>">基本个人信息</a>
				<a class="list-group-item" href="/apply/passport_info/<?php echo $uuid;?>">护照信息</a>
				<a class="list-group-item" href="/apply/travel_info/<?php echo $uuid;?>">行程信息</a>
				<a class="list-group-item" href="/apply/complement_info/<?php echo $uuid;?>">其他补充信息</a>
				<a class="list-group-item" href="/apply/confirm_info/<?php echo $uuid;?>">所填信息确认</a>
			</div>
			<p></p>
			<div id="filling_info">
				<form id="passport_form" method="POST" action="/apply/select_agency">
					<input type="hidden" name="uuid" value="<?php echo $uuid;?>"/>
					<p>请选择办事处:<br>
					<select name="province_id" onchange="">
						<?php foreach ($agencies as $one) { ?>
						<option value="<?php echo $one['id'];?>" <?php echo ($province_id == $one['id'] ? 'selected="selected"' : '')?>><?php echo $one['province_cn'].'--'.$one['location_cn']?></option>
						<?php } ?>
					</select>
					</P>
					<button id="next_step" type="submit">下一步</button>
				</form>
			</div>
		</div>
	</body>
</html>