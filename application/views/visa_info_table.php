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
			.description {display:inline-block; position:relative; font-size:24px; font-weight:bold; font-family:arial; top:24px; color:#434ad6; text-align:center;}
			.info_table {margin:0 auto; padding:12px;}
		</style>
	</head>
	<body>
		<div class="header">
			<div class="header_inner">
				<div class="country_flag"><img src="/vanuatu_flag.png" style="width:84%;"/></div>
				<div class="title">Vanuatu Embassy eVisa</div>
			</div>
		</div>
		<div class="content">
			<div class="country_logo"><img src="/vanuatu.png" style="width:50%;"></div>
			<div class="description">Vanuatu Embassy eVisa<br>瓦努阿图驻华大使馆电子签证</div>
			<div class="info_table">
				<table class="table table-hover table-bordered" style="font-size:16px;">
					<colgroup>
						<col style="width:45%;"/>
						<col style="width:55%"/>
					</colgroup>
					<?php if ($valid_visa) { ?>
					<tr>
						<td colspan="2" align="center" style="font-weight:bold;">一次有效签注 / Single Entry Visa</td>
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
						<td>签证类型 / Visa Type</td>
						<td><?php echo $type;?></td>
					</tr>
					<tr>
						<td>签证号 / Visa No.</td>
						<td><?php echo $visa_number;?></td>
					</tr>
					<tr>
						<td>签证签发日期 / Visa Date of Issue</td>
						<td><?php echo $visa_date;?></td>
					</tr>
					<tr>
						<td>签证有效日期 / Visa Date of Expiry</td>
						<td><?php echo $visa_expiry;?></td>
					</tr>
					<tr>
						<td>最长逗留时间 / Max Days of Stay</td>
						<td><?php echo $max_stay;?></td>
					</tr>
					<tr>
						<td>申请进度 / Application Status</td>
						<td><?php echo $application_status;?></td>
					</tr>
					<tr>
						<td>签证状态 / Visa Status</td>
						<td><?php echo $visa_status;?></td>
					</tr>
					<?php if ($status == APPLY_ACCEPTED) { ?>
					<tr>
						<td colspan="2" align="right">
							<button class="btn btn-success" type="button" onclick="javascript:location.href='/api/download_visa_word/<?php echo $apply_id;?>/<?php echo $visa_number;?>'">下载签证(WORD)</button>
							<button class="btn btn-success" type="button" onclick="javascript:location.href='/api/download_visa_pdf/<?php echo $apply_id;?>/<?php echo $visa_number;?>'">下载签证(PDF)</button>
						</td>
					</tr>
					<? } ?>
					<?php } else { ?>
						<tr>
						<td colspan="2" align="center">找不到所需签证信息 / No Visa Found</td>
					</tr>
					<?php } ?>
				</table>				
			</div>
		</div>
	</body>
</html>