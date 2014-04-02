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
					case '1' : location.href = '/admin/approve?orderby=' + selected + '&cur_status=' + $('#cur_status').val(); break;
					case '2' : location.href = '/admin/approve?orderby=' + selected + '&apply_id=' + $('#apply_id').val(); break;
					case '3' : location.href = '/admin/approve?orderby=' + selected + '&passport_no=' + $('#passport_no').val(); break;
					case '4' : location.href = '/admin/approve?orderby=' + selected + '&start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val(); break;
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
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>Hello. Embassy Admin <?php echo $user['nickname'];?>!</h5>
			</div>
			<div id="lang_switch">
				<a href="/admin/audit_trace?lang=sc">中文</a> / 
				<a style="color:#CACACA;">English</a>
			</div>
			<div id="menu">
				<a href="/admin/approve?lang=en">Application</a> / 
				<a style="color:#1100FF;">History</a> / 
				<a href="/account">Account</a> / 
				<a href="/password">Password</a> / 
				<a href="/logout">Logout</a>
			</div>
		</nav>
		<div id="list_box">
			<!--<div>
				<div style="display:inline-block;">
					<select id="orderby" onchange="javascript:what_is_selected();">
						<option value="1">申请状态</option>
						<option value="2">申请流水号</option>
						<option value="3">护照号</option>
						<option value="4">日期范围</option>
					</select>
				</div>
				<div id="od1" style="display:inline-block;">
					<select id="cur_status">
						<option value="paid">未发签证</option>
						<option value="visa">已发签证</option>
					</select>
				</div>
				<div id="od2" style="display:none">
					&nbsp;请输入需要查询的申请流水号:&nbsp;<input id="apply_id" type="text" placeholder="申请流水号"/>
				</div>
				<div id="od3" style="display:none">
					&nbsp;请输入需要查询的护照号:&nbsp;<input id="passport_no" type="text" placeholder="护照号"/>
				</div>
				<div id="od4" style="display:none">
					&nbsp;请输入需要查询的日期范围:&nbsp;<input id="start_time" type="text" placeholder="起始日期" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd', maxDate:'%y-%M-%d'})"/> ~ 
					<input id="end_time" type="text" placeholder="结束日期" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd', maxDate:'%y-%M-%d'})"/>
					<a href="javascript:void(0)" onclick="download_excel();" target="_blank">导出Excel表格</a>
				</div>
				<div style="display:inline-block;">
					<button onclick="javascript:filter_them(selected);">搜索</button>
				</div>
			</div>-->
			<table class="table table-hover">
				<colgroup>
					<col style="width:11%;"/>
					<col style="width:16%"/>
					<col style="width:11%;"/>
					<col style="width:62%"/>
				</colgroup>
				<thead>
					<tr>
						<th>Serial No.</th>
						<th>Audit Date</th>
						<th>Status</th>
						<th>Message</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($records) > 0) {
							foreach ($records as $one) { 
					?>
					<tr>
						<td><a href="/admin/total_preview/<?php echo $one['uuid'];?>" target="_blank"><?php echo $one['uuid'];?></a></td>
						<td><?php echo $one['audit_time'];?></td>
						<td><?php echo $one['status_str'];?></td>
						<td><?php echo $one['message'];?></td>
					</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
			<div id="pagination">
				<p><label style="color:green;"><?php echo $num_records;?></label> Record<?php echo $num_records > 1 ? 's' : '';?> Found</p>
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
		}8/
	</script>
</html>