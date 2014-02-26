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
		<style type="text/css">
			body {margin:0; padding:0; background:#f5f5f5;}
			.header {width:100%; height:72px; background:#1D8BDF;}
			.header_inner {width:1000px; margin:0 auto; height:100%;}
			.country_flag {display:inline-block;}
			.country_logo {display:inline-block; position:relative; left:124px; top:2px;}
			.title {display:inline-block; position:relative; font-size:32px; font-weight:bold; font-family:arial; top:6px; color:#fefefe;}
			.content {width:47.4pc; height:auto; margin:0 auto; background:#ffffff;}
			.description {display:inline-block; position:relative; font-size:24px; font-weight:bold; font-family:arial; top:24px; left:136px; color:#434ad6; text-align:center;}
			.search_form {width:360px; margin:0 auto; font-size:20px;}
			input {border:none; border-bottom:1px solid #000000;}
		</style>
	</head>
	<body>
		<div class="header">
			<div class="header_inner">
				<div class="country_flag"><img src="/vanuatu_flag.png" style="width:121px;"/></div>
				<div class="title">Vanuatu Embassy eVisa</div>
			</div>
		</div>
		<div class="content">
			<div class="country_logo"><img src="/vanuatu.png" style="width:147px;"></div>
			<div class="description">Vanuatu Embassy eVisa<br>瓦努阿图驻华大使馆电子签证</div>
			<div class="search_form">
				<form action="/api/visa_verify_table" method="get" style="padding:24px;">
					<table>
						<tr>
							<td colspan="2" style="font-size:16px; font-weight:bold;"  align="center">请输入需要查询的签证的相关信息<br>&nbsp;</td>
						</tr>
						<tr>
							<td>申请号：</td>
							<td><input class="text" type="text" name="apply_id" placeholder="Serial Number"/></td>
						</tr>
						<tr>
							<td>护照号：</td>
							<td><input class="text" type="text" name="passport" placeholder="Passport Number"/></td>
						</tr>
						<tr>
							<td>签证号：</td>
							<td><input type="text" name="visa" placeholder="Visa Number"/></td>
						</tr>
						<tr>
							<td colspan="2" align="right"><button class="btn btn-success" type="submit">查 询</button></td>
						</tr>
						<tr>
							<td colspan="2" style="font-size:12px; color:#ACACAC;" align="center"><br>注：以上条件任选其二作为查询条件，也可全选。</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>