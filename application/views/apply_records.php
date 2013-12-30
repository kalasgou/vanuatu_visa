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
		<script type="text/javascript" src=""></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>你好，<?php echo $user['realname'];?>！</h5>
			</div>
			<div id="menu">
				<a style="color:#1100FF;">申请记录</a> / 
				<a href="/apply/agencies">签证申请</a> / 
				<a href="/user/account">帐户信息</a> / 
				<a href="/change_password">密码修改</a> / 
				<a href="/user/logout">安全登出</a>
			</div>
		</nav>
		<div id="list_box">
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
							<a href="/apply/view/<?php echo $one['uuid'];?>" target="_blank">查看</a>
							<?php if ($one['status'] <= 21) { ?><a href="/apply/agencies/<?php echo $one['uuid'];?>">修改</a><?php } ?>
							<a href="/apply/download_form/<?php echo $one['uuid'];?>" target="_blank">下载申请表</a>
							<?php if ($one['status'] == 101) { ?><a href="/apply/download_visa/<?php echo $one['uuid'];?>" target="_blank">下载签证</a><?php } ?>
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
				<p>当前共有<label style="color:green;"><?php echo $num_records;?></label>条记录</p>
				<?php echo $pagination;?>
			</div>
		</div>
	</body>
</html>