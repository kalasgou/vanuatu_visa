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
					case '1' : location.href = '/admin/account?orderby=' + selected + '&account_status=' + $('#account_status').val() + '&account_type=' + $('#account_type').val() + '&province=' + $('#provinces').val() + '&city=' + $('#cities').val(); break;
					case '2' : location.href = '/admin/account?orderby=' + selected + '&email=' + $('#email').val(); break;
					default : return;
				}
			}
			
			function set_default_filter() {
				$('#od' + selected).css('display', 'none');
				selected = selected_arg;
				$('#orderby').val(selected);
				$('#od' + selected).css('display', 'inline-block');
				switch (selected) {
					case '1' : $('#account_status').val(account_status); $('#account_type').val(account_type); $('#provinces').val(province); $('#cities').val(city); city_list('all'); break;
					case '2' : $('#email').val(email); break;
					default : return;
				}
			}
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>您好，<?php echo $user['nickname'];?>！</h5>
			</div>
			<div id="menu">
				<a style="color:#1100FF;">帐号管理</a> / 
				<a href="/admin/quick">快速通道</a> / 
				<a href="/admin/agency">合作方管理</a> / 
				<a href="/account">帐户信息</a> / 
				<a href="/password">密码修改</a> / 
				<a href="/logout">安全登出</a>
			</div>
		</nav>
		<div id="list_box">
			<div>
				<div style="display:inline-block;">
					<select id="orderby" onchange="javascript:what_is_selected();">
						<option value="1">混合查询</option>
						<option value="2">电子邮箱</option>
					</select>
				</div>
				<div id="od1" style="display:inline-block;">
					请选择&nbsp;帐号状态:&nbsp;
					<select id="account_status">
						<option value="0">全部</option>
						<option value="<?php echo ACCOUNT_NORMAL;?>">正常</option>
						<option value="<?php echo ACCOUNT_CANCELLED;?>">失效</option>
					</select>
					&nbsp;帐号类型:&nbsp;
					<select id="account_type">
						<option value="0">全部</option>
						<option value="<?php echo RESERVATION_USER;?>">网上预约用户</option>
						<option value="<?php echo OFFICE_ADMIN;?>">办事处管理员</option>
						<option value="<?php echo EMBASSY_ADMIN;?>">大使馆管理员</option>
						<option value="<?php echo CUSTOMER_SERVICE;?>">客户服务人员</option>
					</select>
					&nbsp;省份:&nbsp;
					<select id="provinces" onchange="city_list('all');">
						<option value="0">加载中</option>
					</select>
					&nbsp;城市:&nbsp;
					<select id="cities">
						<option value="0">加载中</option>
					</select>
				</div>
				<div id="od2" style="display:none">
					&nbsp;请输入需要查询的邮箱地址:&nbsp;
					<input id="email" type="email" placeholder="邮箱地址"/>
				</div>
				<div style="display:inline-block;">
					<button onclick="javascript:filter_them(selected);">搜索</button>
				</div>
				<div style="position:relative; float:right;" style="display:inline-block;">
					<button onclick="javascript:location.href='/register';">注册新帐号</button>
				</div>
			</div>
			<table class="table table-hover">
				<colgroup>
					<col style="width:10%;"/>
					<col style="width:10%;"/>
					<col style="width:12%;"/>
					<col style="width:10%"/>
					<col style="width:10%;"/>
					<col style="width:13%"/>
					<col style="width:5%;"/>
					<col style="width:11%"/>
					<col style="width:10%"/>
					<col style="width:6%;"/>
				</colgroup>
				<thead>
					<tr>
						<th>用户姓名</th>
						<th>电子邮箱</th>
						<th>机构</th>
						<th>省/市</th>
						<th>联系电话</th>
						<th>权限</th>
						<th>状态</th>
						<th>注册日期</th>
						<th>负责人</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($users) > 0) {
							foreach ($users as $one) { 
					?>
					<tr>
						<td><?php echo $one['nickname'];?></td>
						<td><?php echo $one['email'];?></td>
						<td><?php echo $one['agency'];?></td>
						<td><?php echo $one['province_str'].'/'.$one['city_str'];?>
						<td><?php echo $one['telephone'];?></td>
						<td><?php echo $one['permission_str'];?></td>
						<td><?php echo $one['status_str'];?></td>
						<td><span title="具体时间 <?php echo $one['reg_time'];?>"><?php echo substr($one['reg_time'], 0, 10);?></span></td>
						<td>
							<select id="charge_<?php echo $one['userid'];?>">
								<?php foreach($one['superiors'] as $userid => $nickname) { ?>
								<option value="<?php echo $userid;?>" <?php echo $userid == $one['superior_id'] ? 'selected' : '';?>><?php echo $nickname;?></option>
								<?php } ?>
							</select>
						</td>
						<td>
							<a style="color:darkgreen;" href="javascript:void(0);" onclick="update_account_superior(<?php echo $one['userid'];?>, <?php echo $one['superior_id'];?>, this);">更新</a> / 
							<?php if ($one['status'] == ACCOUNT_CANCELLED) { ?>
								<a style="color:green;" href="javascript:void(0);" onclick="change_account_status('<?php echo $one['userid'];?>', 'yes', this);">激活</a>
							<?php } else if ($one['status'] == ACCOUNT_NORMAL) { ?>
								<a style="color:red;" href="javascript:void(0);" onclick="change_account_status('<?php echo $one['userid'];?>', 'no', this);">注销</a>
							<?php } ?>
						</td>
					</tr>
					<?php
							}
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
		var selected_arg = '', account_status = '', account_type = '', email = '', province = '', city = '';
		
		province_list('all');
		
		var argument_str = location.search;
		if (argument_str.indexOf('?') != -1) {
			argument_str = argument_str.substr(1);
			var arguments = argument_str.split('&');
			for (var i = 0; i < arguments.length; i ++) {
				switch(arguments[i].split('=')[0]) {
					case 'orderby': selected_arg = arguments[i].split('=')[1]; break;
					case 'account_status': account_status = arguments[i].split('=')[1]; break;
					case 'account_type': account_type = arguments[i].split('=')[1]; break;
					case 'email': email = arguments[i].split('=')[1]; break;
					case 'province': province = arguments[i].split('=')[1]; break;
					case 'city': city = arguments[i].split('=')[1]; break;
					default: continue;
				}
			}
			set_default_filter();
		}
	</script>
</html>