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
			function filter_them() {
				location.href = '/admin/approve/' + $('#cur_status').val() + '/';
			}
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>你好，大使馆管理员 <?php echo $user['realname'];?>！</h5>
			</div>
			<div id="menu">
				<a style="color:#1100FF;">审批签证</a> / 
				<a href="/admin/approve_records">审批记录</a> / 
				<a href="/user/account">帐户信息</a> / 
				<a href="/user/password">密码修改</a> / 
				<a href="/user/logout">安全登出</a>
			</div>
		</nav>
		<div id="list_box">
			<div>
				<select id="cur_status">
					<option value="paid">未发签证</option>
					<option value="visa">已发签证</option>
				</select>
				<button onclick="javascript:filter_them();">搜索</button>
			</div>
			<table class="table table-hover">
				<colgroup>
					<col style="width:11%;"/>
					<col style="width:18%"/>
					<col style="width:9%;"/>
					<col style="width:9%"/>
					<col style="width:8%;"/>
					<col style="width:9%"/>
					<col style="width:9%;"/>
					<col style="width:9%;"/>
					<col style="width:18%;"/>
				</colgroup>
				<thead>
					<tr>
						<th>申请流水号</th>
						<th>申请人英文/中文姓名</th>
						<th>护照号</th>
						<th>提交日期</th>
						<th>当前状态</th>
						<th>审核日期</th>
						<th>缴费日期</th>
						<th>签发日期</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($records) > 0) {
							foreach ($records as $one) { 
					?>
					<tr>
						<td><?php echo $one['uuid'];?></td>
						<td><?php echo $one['name_en'];?> / <?php echo $one['name_cn'];?></td>
						<td><?php echo $one['passport_number'];?></td>
						<td><span title="具体时间 <?php echo $one['submit_time'];?>"><?php echo substr($one['submit_time'], 0, 10);?></span></td>
						<td><?php echo $one['status_str'];?></td>
						<td><span title="具体时间 <?php echo $one['audit_time'];?>"><?php echo substr($one['audit_time'], 0, 10);?></span></td>
						<td><span title="具体时间 <?php echo $one['pay_time'];?>"><?php echo substr($one['pay_time'], 0, 10);?></span></td>
						<td><span title="具体时间 <?php echo $one['approve_time'];?>"><?php echo substr($one['approve_time'], 0, 10);?></span></td>
						<td>
							<a href="/admin/total_preview/<?php echo $one['uuid'];?>">查看详细</a> / 
							<a href="">通过签证</a>
						</td>
					</tr>
					<?php
							}
						} else {
					?>
					<tr>
						<td colspan="9" style="text-align:center;">nothing got here!</td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
			<div id="pagination">
				<?php echo $pagination;?>
			</div>
		</div>
	</body>
</html>