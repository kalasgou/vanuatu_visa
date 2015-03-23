<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Refresh" content="60">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href="/dist/css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="/common.css"/>
		<script type="text/javascript" src="/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			
		</script>
		<style type="text/css">
			.form-control {width: 60px;}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>您好，客服专员 <?= $user['nickname'] ?>！</h5>
			</div>
			<div id="menu">
				<a style="color:#1100FF;">查找签证</a> / 
				<a href="/account">帐户信息</a> / 
				<a href="/password">密码修改</a> / 
				<a href="/logout">安全登出</a>
			</div>
		</nav>
		<div id="list_box">
			<div>
				<form action="<?= base_url('service/searchVisas') ?>" method="get">
					<div style="display:inline-block;">
						请输入申请人护照号:&nbsp;<input type="text" name="passport_number" value="<?= $passport_number ?>" placeholder="正确填写9位字符护照号" />
					</div>
					<div style="display:inline-block;">
						<button type="submit">搜索</button>
					</div>
				</form>
			</div>
			<table class="table table-hover">
				<colgroup>
					<col style="width:20%;"/>
					<col style="width:16%"/>
					<col style="width:16%;"/>
					<col style="width:12%"/>
					<col style="width:12%;"/>
					<col style="width:12%"/>
					<col style="width:12%;"/>
				</colgroup>
				<thead>
					<tr>
						<th>申请流水号</th>
						<th>申请人姓名</th>
						<th>护照号</th>
						<th>提交日期</th>
						<th>当前状态</th>
						<th>审核日期</th>
						<th>签发日期</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($visas)): ?>
						<?php foreach ($visas as $one): ?>
					<tr>
						<td><?= $one['uuid'] ?></td>
						<td><?= $one['first_name'] ?> <?= $one['last_name'] ?></td>
						<td><?= $one['passport_number'] ?></td>
						<td><span title="具体时间 <?= $one['submit_time'] ?>"><?= substr($one['submit_time'], 0, 10) ?></span></td>
						<td><?= $one['status_str'] ?></td>
						<td><span title="具体时间 <?= $one['audit_time'] ?>"><?= substr($one['audit_time'], 0, 10) ?></span></td>
						<td><span title="具体时间 <?= $one['approve_time'];?>"><?= substr($one['approve_time'], 0, 10) ?></span></td>
					</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			<div id="pagination">
				<p>共查找<label style="color:green;"><?= $num_records ?></label>条签证记录</p>
			</div>
		</div>
	</body>
</html>