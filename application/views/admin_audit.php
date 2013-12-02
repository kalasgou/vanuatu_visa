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
		<script type="text/javascript" src="/jquery-1.9.1.min.js"/></script>
		<script type="text/javascript">
			function pay_for_visa(uuid) {
				var fee = parseInt(prompt('请输入签证费用，单位：人名币'));
				if (isNaN(fee)) {
					alert('请输入数字！');
					return;
				}
				var message = '签证申请流水号 ' + uuid + ' 已缴款RMB ' + fee + '，请等待签证通过！';
				$.ajax({
					url: '/admin/auditing/' + uuid + '/paid',
					data: {message: message},
					type: 'POST',
					dataType: 'json',
					success: function(json) {
						alert(json);
					},
					error: function() {
						alert('Network Error');
					}
				});
			}
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
						<a href="/admin/audit_preview/<?php echo $one['uuid'];?>">查看详细</a> / 
						<a href="javascript:pay_for_visa('<?php echo $one['uuid'];?>');">缴费</a> 
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