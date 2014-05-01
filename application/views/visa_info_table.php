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
			.country_logo {display:inline-block; position:relative; left:100px; top:16px;}
			.title {display:inline-block; position:relative; font-size:32px; font-weight:bold; font-family:arial; top:6px; color:#fefefe;}
			.content {width:757px; height:auto; margin:0 auto; background:#ffffff;}
			.description {display:inline-block; position:relative; font-size:24px; font-weight:bold; font-family:arial; top:36px; left:106px; color:#434ad6; text-align:center;}
			.info_table {margin:24px auto; padding:12px;}
			.copyright {position:relative; text-align:center; width:100%; bottom:4px;}
		</style>
	</head>
	<body>
		<div class="header">
			<div class="header_inner">
				<div class="country_flag"><img src="/vanuatu_flag.png" style="width:121px;"/></div>
				<div class="title">Vanuatu Embassy Travel Certification</div>
			</div>
		</div>
		<div class="content">
			<div class="country_logo"><img src="/vanuatu.png" style="width:147px;"></div>
			<div class="description">Vanuatu Embassy Travel Certification<br>瓦努阿图驻华大使馆旅行证件</div>
			<div class="info_table">
				<table class="table table-hover table-bordered" style="font-size:16px;">
					<colgroup>
						<col style="width:45%;"/>
						<col style="width:55%"/>
					</colgroup>
					<?php if ($valid_visa) { ?>
					<tr>
						<td colspan="2" align="center" style="font-weight:bold;">旅行证件 / Travel Certification</td>
					</tr>
					<tr>
						<td>姓名 / Name</td>
						<td><?php echo $name;?></td>
					</tr>
					<tr>
						<td>性别 / Sex</td>
						<td><?php echo $gender;?></td>
					</tr>
					<tr>
						<td>出生地 / Place of Birth</td>
						<td><?php echo $birth_place;?></td>
					</tr>
					<tr>
						<td>出生日期 / Date of Birth</td>
						<td><?php echo $birth_date;?></td>
					</tr>
					<tr>
						<td>护照号 / Passport No.</td>
						<td><?php echo $passport_number;?></td>
					</tr>
					<tr>
						<td>护照签发地 / Place of Issue</td>
						<td><?php echo $passport_place;?></td>
					</tr>
					<tr>
						<td>护照签发日期 / Passport Date of Issue</td>
						<td><?php echo $passport_date;?></td>
					</tr>
					<tr>
						<td>护照有效日期 / Passport Date of Expiry</td>
						<td><?php echo $passport_expiry;?></td>
					</tr>
					<tr>
						<td>证件类型 / Travel Certification Type</td>
						<td><?php echo $type;?></td>
					</tr>
					<tr>
						<td>证件号 / Ref No.</td>
						<td><?php echo $visa_number;?></td>
					</tr>
					<tr>
						<td>证件签发日期 / Date of Issue</td>
						<td><?php echo $visa_date;?></td>
					</tr>
					<tr>
						<td>证件有效日期 / Date of Expiry</td>
						<td><?php echo $visa_expiry;?></td>
					</tr>
					<tr>
						<td>最长逗留时间 / Length of Stay</td>
						<td><?php echo $max_stay;?></td>
					</tr>
					<tr>
						<td>申请进度 / Application Status</td>
						<td><?php echo $application_status;?></td>
					</tr>
					<tr>
						<td>证件状态 / Certification Status</td>
						<td><?php echo $visa_status;?></td>
					</tr>
					<?php //if ($status == VISA_ISSUED) { ?>
					<tr>
						<td colspan="2" align="right">
							<!--<button class="btn btn-success" type="button" onclick="javascript:location.href='/api/download_visa_word/<?php echo $apply_id;?>/<?php echo $visa_number;?>'">下载签证(WORD)</button>-->
							<button class="btn btn-success" type="button" onclick="javascript:location.href='/api/download_visa_pdf/<?php echo $apply_id;?>/<?php echo $visa_number;?>'">下载 / Download</button>
						</td>
					</tr>
					<? //} ?>
					<?php } else { ?>
						<tr>
						<td colspan="2" align="center">找不到所需的证件信息 / No Travel Certification Found</td>
					</tr>
					<?php } ?>
				</table>				
			</div>
		</div>
		<div class="copyright">
			<span>Copyright &copy; 2014 Vanuatu Embassy. All Rights Reserved</span>
		</div>
	</body>
</html>