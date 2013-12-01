<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href=''>
		<script type="text/javascript" src=""/>
		<script type="text/javascript" src=""/>
		<script type="text/javascript" src=""/>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<div>
			<table>
				<tr>
					<td>申请人中文姓名</td>
					<td>申请人英文姓名</td>
					<td>护照号</td>
					<td>申请提交时间</td>
					<td>申请状态</td>
					<td>操作</td>
				</tr>
				<?php if (count($records) > 0) {
						foreach ($records as $one) { 
				?>
				<tr>
					<td><?php echo $one['name_en'];?></td>
					<td><?php echo $one['name_cn'];?></td>
					<td><?php echo $one['passport_number'];?></td>
					<td><?php echo $one['submit_time'];?></td>
					<td><?php echo $one['status'];?></td>
					<td>
						<a href="/admin/auditing/<?php echo $one['uuid'];?>">通过</a>
						<a href="/admin/agencies/<?php echo $one['uuid'];?>">不通过</a>
					</td>
				</tr>
				<?php
						}
					} else {
				?>
				<tr>
					<td colspan="6">nothing got here!</td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>
		<div id="step_menu" style="display:inline;">
			<a href="/admin/audit">审核申请</a>
			<a href="/admin/records">审核记录</a>
			<a href="/admin/account">帐户信息</a>
			<a href="/admin/password">密码修改</a>
		</div>
	</body>
</html>