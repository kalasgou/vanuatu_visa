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
			<form id="passport_form" method="POST" action="select_agency">
				<input type="hidden" name="unipue_uuid" value="<?php echo $uuid;?>"/>
				<input type="hidden" name="userid" value="4338"/>
				<p>请选择办事处:<br>
				<select name="province_id" onchange="">
					<?php foreach ($agencies as $one) { ?>
					<option value="<?php echo $one['id'];?>"><?php echo $one['province_cn'].'--'.$one['location_cn']?></option>
					<?php } ?>
				</select>
				</P>
				<button type="submit">保存并下一步</button>
			</form>
		</div>
	</body>
</html>