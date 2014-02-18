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
			/*function what_is_selected() {
				$('#od' + selected).css('display', 'none');
				selected = $('#orderby').val();
				$('#od' + selected).css('display', 'inline-block');
			}
			
			function filter_them(selected) {
				switch (selected) {
					case '1' : location.href = '/admin/fast?orderby=' + selected + '&cur_status=' + $('#cur_status').val(); break;
					case '2' : location.href = '/admin/fast?orderby=' + selected + '&apply_id=' + $('#apply_id').val(); break;
					case '3' : location.href = '/admin/fast?orderby=' + selected + '&passport_no=' + $('#passport_no').val(); break;
					case '4' : location.href = '/admin/fast?orderby=' + selected + '&start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val(); break;
					case '5' : location.href = '/admin/fast?orderby=' + selected + '&user=1'; break;
					default : return;
				}
			}
			
			function set_default_filter() {
				$('#od' + selected).css('display', 'none');
				selected = selected_arg;
				$('#orderby').val(selected);
				$('#od' + selected).css('display', 'inline-block');
				switch (selected) {
					case '1' : $('#cur_status').val(cur_status); break;
					case '2' : $('#apply_id').val(apply_id); break;
					case '3' : $('#passport_no').val(passport_no); break;
					case '4' : $('#start_time').val(start_time); $('#end_time').val(end_time); break;
					default : return;
				}
			}*/
		</script>
		<style type="text/css">
			.city, .addr, .cont {border:1px dotted #000;border-top-width:0px; border-right-width:0px; border-left-width:0px;}
			.city {width:100px;}
			.addr {width:324px;}
			.cont {width:104px;}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>您好，办事处管理员 <?php echo $user['nickname'];?>！</h5>
			</div>
			<div id="menu">
				<a href="/admin/permit">管理员帐号</a> / 
				<a href="/admin/ordinary">普通用户帐号</a> / 
				<a href="/admin/fast">快速通道</a> / 
				<a style="color:#1100FF;">办事处管理</a> / 
				<a href="/account">帐户信息</a> / 
				<a href="/password">密码修改</a> / 
				<a href="/logout">安全登出</a>
			</div>
		</nav>
		<div id="list_box">
			<div>
				<div style="display:inline-block;">
					<select id="orderby" onchange="javascript:what_is_selected();">
						<option value="1">申请状态</option>
						<option value="2">申请流水号</option>
						<option value="3">护照号</option>
						<option value="4">日期范围</option>
						<option value="5">线下申请</option>
					</select>
				</div>
			</div>
			<table class="table table-hover">
				<colgroup>
					<col style="width:10%"/>
					<col style="width:12%"/>
					<col style="width:34%;"/>
					<col style="width:12%"/>
					<col style="width:7%;"/>
					<col style="width:15%;"/>
					<col style="width:10%"/>
				</colgroup>
				<thead>
					<tr>
						<th>省</th>
						<th>市</th>
						<th>地 址</th>
						<th>联系电话</th>
						<th>状 态</th>
						<th>更新日期</th>
						<th>操 作</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($agencies) > 0) {
							foreach ($agencies as $one) { 
					?>
					<tr>
						<td><?php echo $one['province_cn'];?></td>
						<td><input id="city_<?php echo $one['id'];?>" class="city" type="text" value="<?php echo $one['city_cn'];?>"/></td>
						<td><input id="addr_<?php echo $one['id'];?>" class="addr" type="text" value="<?php echo $one['addr_cn'];?>"/></td>
						<td><input id="cont_<?php echo $one['id'];?>" class="cont" type="text" value="<?php echo $one['contact'];?>"/></td>
						<td><?php echo $one['status_str'];?></td>
						<td><?php echo date('Y-m-d H:i:s', $one['date']);?></td>
						<td>
							<a href="javascript:void(0);" onclick="update_agency(<?php echo $one['id'];?>);">修改</a> / 
							<a href="javascript:void(0);" onclick="delete_agency(<?php echo $one['id'];?>);">删除</a>
						</td>
					</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
			<div id="pagination">
				<p>当前共有<label style="color:green;"><?php echo $num_agencies;?></label>条记录</p>
				<?php echo $pagination;?>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		/*var selected = '1';
		var selected_arg = '', cur_status = '', apply_id = '', passport_no = '', start_time = '', end_time = '';
		
		var argument_str = location.search;
		if (argument_str.indexOf('?') != -1) {
			argument_str = argument_str.substr(1);
			var arguments = argument_str.split('&');
			for (var i = 0; i < arguments.length; i ++) {
				switch(arguments[i].split('=')[0]) {
					case 'orderby': selected_arg = arguments[i].split('=')[1]; break;
					case 'cur_status': cur_status = arguments[i].split('=')[1]; break;
					case 'apply_id': apply_id = arguments[i].split('=')[1]; break;
					case 'passport_no': passport_no = arguments[i].split('=')[1]; break;
					case 'start_time': start_time = arguments[i].split('=')[1]; break;
					case 'end_time': end_time = arguments[i].split('=')[1]; break;
					default: continue;
				}
			}
			set_default_filter();
		}*/
	</script>
</html>