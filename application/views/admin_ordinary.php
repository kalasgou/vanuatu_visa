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
		<script type="text/javascript" src="/My97DatePicker/WdatePicker.js"></script>
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			function what_is_selected() {
				$('#od' + selected).css('display', 'none');
				selected = $('#orderby').val();
				$('#od' + selected).css('display', 'inline-block');
			}
			
			function filter_them(selected) {
				switch (selected) {
					case '1' : location.href = '/admin/ordinary?orderby=' + selected + '&account_status=' + $('#account_status').val(); break;
					case '2' : location.href = '/admin/ordinary?orderby=' + selected + '&email=' + $('#email').val(); break;
					default : return;
				}
			}
			
			function set_default_filter() {
				$('#od' + selected).css('display', 'none');
				selected = selected_arg;
				$('#orderby').val(selected);
				$('#od' + selected).css('display', 'inline-block');
				switch (selected) {
					case '1' : $('#account_status').val(account_status); break;
					case '2' : $('#email').val(email); break;
					default : return;
				}
			}
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>你好，系统管理员 <?php echo $user['realname'];?>！</h5>
			</div>
			<div id="menu">
				<a href="/admin/permit">管理员帐号</a> / 
				<a style="color:#1100FF;">普通用户帐号</a> / 
				<a href="/account">帐户信息</a> / 
				<a href="/password">密码修改</a> / 
				<a href="/logout">安全登出</a>
			</div>
		</nav>
		<div id="list_box">
			<div>
				<div style="display:inline-block;">
					<select id="orderby" onchange="javascript:what_is_selected();">
						<option value="1">帐号状态</option>
						<option value="2">邮箱地址</option>
					</select>
				</div>
				<div id="od1" style="display:inline-block;">
					&nbsp;请选择需要查询的状态类型:&nbsp;
					<select id="account_status">
						<option value="0">未激活</option>
						<option value="1">正常</option>
						<option value="-1">已失效</option>
					</select>
				</div>
				<div id="od2" style="display:none">
					&nbsp;请选择需要查询的邮箱地址:&nbsp;
					<input id="email" type="email" placeholder="邮箱地址"/>
				</div>
				<div style="display:inline-block;">
					<button onclick="javascript:filter_them(selected);">搜索</button>
				</div>
			</div>
			<table class="table table-hover">
				<colgroup>
					<col style="width:10%;"/>
					<col style="width:10%;"/>
					<col style="width:20%"/>
					<col style="width:15%;"/>
					<col style="width:15%"/>
					<col style="width:10%;"/>
					<col style="width:10%"/>
					<col style="width:10%;"/>
				</colgroup>
				<thead>
					<tr>
						<th>帐号昵称</th>
						<th>真实姓名</th>
						<th>电子邮箱</th>
						<th>联系电话</th>
						<th>注册日期</th>
						<th>帐号权限</th>
						<th>帐号状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($users) > 0) {
							foreach ($users as $one) { 
					?>
					<tr>
						<td><?php echo $one['nickname'];?></td>
						<td><?php echo $one['realname'];?></td>
						<td><?php echo $one['email'];?></td>
						<td><?php echo $one['phone'];?></td>
						<td><span title="具体时间 <?php echo $one['reg_time'];?>"><?php echo substr($one['reg_time'], 0, 10);?></span></td>
						<td>普通用户</td>
						<td><?php echo $one['status_str'];?></td>
						<td>
							<?php if ($one['status'] == 0) { ?>
								<a href="javascript:void(0);" onclick="change_account_status('applicant', '<?php echo $one['userid'];?>', 'yes', this);">激活</a>
							<?php } else if ($one['status'] == 1) { ?>
								<a href="javascript:void(0);" onclick="change_account_status('applicant', '<?php echo $one['userid'];?>', 'no', this);">注销</a>
							<?php } ?>
						</td>
					</tr>
					<?php
							}
						} else {
					?>
					<tr>
						<td colspan="8" style="text-align:center;">nothing got here!</td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
			<div id="pagination">
				<p>当前共有<label style="color:green;"><?php echo $num_users;?></label>条记录</p>
				<?php echo $pagination;?>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		var selected = '1';
		var selected_arg = '', account_status = '', email = '';
		
		var argument_str = location.search;
		if (argument_str.indexOf('?') != -1) {
			argument_str = argument_str.substr(1);
			var arguments = argument_str.split('&');
			for (var i = 0; i < arguments.length; i ++) {
				switch(arguments[i].split('=')[0]) {
					case 'orderby': selected_arg = arguments[i].split('=')[1]; break;
					case 'account_status': account_status = arguments[i].split('=')[1]; break;
					case 'email': email = arguments[i].split('=')[1]; break;
					default: continue;
				}
			}
			set_default_filter();
		}
	</script>
</html>