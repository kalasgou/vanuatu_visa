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
		<script type="text/javascript" src="/jquery-1.9.1.min.js"></script>
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
			
			function filter_them() {
				location.href = '/admin/audit/' + $('#cur_status').val() + '/';
			}
		</script>
	</head>
	<body>
		<div>
			<div>
				<select id="cur_status">
					<option value="wait">待审核</option>
					<option value="pass">已通过</option>
					<option value="fail">未通过</option>
					<option value="paid">已缴费</option>
				</select>
				<button onclick="javascript:filter_them();">搜索</button>
			</div>
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
						<a href="/admin/total_preview/<?php echo $one['uuid'];?>">查看详细</a> / 
						<a href="javascript:pay_for_visa('<?php echo $one['uuid'];?>');">通过签证</a> / 
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
			<a href="/admin/approve">审批签证</a>
			<a href="/admin/approved_records">审批记录</a>
			<a href="/admin/account">帐户信息</a>
			<a href="/admin/password">密码修改</a>
			<a href="/user/logout">退出登录</a>
		</div>
	</body>
</html>