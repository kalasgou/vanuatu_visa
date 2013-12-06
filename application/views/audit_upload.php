<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href=''/>
		<script type="text/javascript" src=""></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<div>
			<form id="scan_file" action="/admin/upload_now/<?php echo $uuid;?>" method="post" enctype="multipart/form-data">
				<table>
					<colgroup>
						<col style="width:120px;">
						<col>
					</colgroup>
					<tr>
						<th colspan="1" style="text-align:center;">
							<h4>扫描件上传</h4>
						</th>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							<span>你现在要处理的是申请流水号为<b><?php echo $uuid;?></b>，申请人为<b><?php echo $name_en.'/'.$name_cn;?></b>的签证申请，请核实无误后再上传证明文件。</span>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<th>签证相片：</th>
						<td><input type="file" name="photo"/></td>
					</tr>
					<tr>
						<th>护照：</th>
						<td><input type="file" name="passport"/></td>
					</tr>
					<tr>
						<th>身份证：</th>
						<td><input type="file" name="identity"/></td>
					</tr>
					<tr>
						<th>往返机票：</th>
						<td><input type="file" name="ticket"/></td>
					</tr>
					<tr>
						<th>存款证明：</th>
						<td><input type="file" name="deposition"/></td>
					</tr>
					<tr>
						<th></th>
						<td><button type="submit" class="btn btn-primary"/>上传</button>	
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>