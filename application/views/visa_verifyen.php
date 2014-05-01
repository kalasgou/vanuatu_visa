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
			function submit_form() {
				var valid_num = 0;
				if ($('#SN').val() !== '') {
					valid_num ++;
				}
				if ($('#PN').val() !== '') {
					valid_num ++;
				}
				if ($('#VN').val() !== '') {
					valid_num ++;
				}
				if (valid_num < 2) {
					alert('Please specify at least two options below!');
					return false;
				} else {
					return true;
				}
			}
		</script>
		<style type="text/css">
			body {margin:0; padding:0; background:#f5f5f5;}
			.header {width:100%; height:72px; background:#1D8BDF;}
			.header_inner {width:1000px; margin:0 auto; height:100%;}
			.country_flag {display:inline-block;}
			.country_logo {display:inline-block; position:relative; left:100px; top:16px;}
			.title {display:inline-block; position:relative; font-size:32px; font-weight:bold; font-family:arial; top:6px; color:#fefefe;}
			.content {width:757px; height:auto; margin:0 auto; background:#ffffff;}
			.description {display:inline-block; position:relative; font-size:24px; font-weight:bold; font-family:arial; top:36px; left:106px; color:#434ad6; text-align:center;}
			.search_form {width:400px; margin:0 auto; font-size:20px;}
			input {border:none; border-bottom:1px solid #000000;}
			.lang_switch {position:relative; float:right; right:128px; top:78px;}
			.copyright {position:fixed; text-align:center; width:100%; bottom:4px;}
		</style>
	</head>
	<body>
		<div class="header">
			<div class="header_inner">
				<div class="country_flag"><img src="/vanuatu_flag.png" style="width:121px;"/></div>
				<div class="title">Vanuatu Embassy Travel Certification</div>
				<div class="lang_switch">
					<a href="/cn">中文</a> / 
					<a style="color:#CACACA;">English</a>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="country_logo"><img src="/vanuatu.png" style="width:147px;"></div>
			<div class="description">Vanuatu Embassy Travel Certification<br>瓦努阿图驻华大使馆旅行证件</div>
			<div class="search_form">
				<form action="/api/visa_verify_table" method="get" style="padding:24px;" onsubmit="return submit_form();">
					<table>
						<tr>
							<td colspan="2" style="font-size:16px; font-weight:bold;" align="center">Enter Travel Certification info here<br>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" style="font-size:16px; font-weight:bold;" align="center">The one who carries a document should travel to Vanuatu within 90 days.<br>&nbsp;</td>
						</tr>
						<tr>
							<td style="vertical-align:bottom;">Serial No. </td>
							<td><input class="text" id="SN" type="text" name="apply_id"/></td>
						</tr>
						<tr>
							<td style="vertical-align:bottom;">Passport No. </td>
							<td><input class="text" id="PN" type="text" name="passport"/></td>
						</tr>
						<tr>
							<td style="vertical-align:bottom;">Ref No. </td>
							<td><input type="text" id="VN" name="visa"/></td>
						</tr>
						<tr>
							<td colspan="2" align="right"><button class="btn btn-success" type="submit">Submit</button></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size:12px; color:#ACACAC;" align="center"><br>Notice:Choose at least two options as your search condition.</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="copyright">
			<span>Copyright &copy; 2014 Vanuatu Embassy. All Rights Reserved</span>
		</div>
	</body>
</html>