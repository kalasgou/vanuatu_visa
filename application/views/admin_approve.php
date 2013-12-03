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
				var fee = parseInt(prompt('������ǩ֤���ã���λ��������'));
				if (isNaN(fee)) {
					alert('���������֣�');
					return;
				}
				var message = 'ǩ֤������ˮ�� ' + uuid + ' �ѽɿ�RMB ' + fee + '����ȴ�ǩ֤ͨ����';
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
					<option value="wait">�����</option>
					<option value="pass">��ͨ��</option>
					<option value="fail">δͨ��</option>
					<option value="paid">�ѽɷ�</option>
				</select>
				<button onclick="javascript:filter_them();">����</button>
			</div>
			<table>
				<tr>
					<td>��������������</td>
					<td>������Ӣ������</td>
					<td>���պ�</td>
					<td>�����ύʱ��</td>
					<td>����״̬</td>
					<td>����</td>
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
						<a href="/admin/total_preview/<?php echo $one['uuid'];?>">�鿴��ϸ</a> / 
						<a href="javascript:pay_for_visa('<?php echo $one['uuid'];?>');">ͨ��ǩ֤</a> / 
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
			<a href="/admin/approve">����ǩ֤</a>
			<a href="/admin/approved_records">������¼</a>
			<a href="/admin/account">�ʻ���Ϣ</a>
			<a href="/admin/password">�����޸�</a>
			<a href="/user/logout">�˳���¼</a>
		</div>
	</body>
</html>