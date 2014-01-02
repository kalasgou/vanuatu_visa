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
					case '1' : location.href = '/admin/fast?orderby=' + selected + '&cur_status=' + $('#cur_status').val(); break;
					case '2' : location.href = '/admin/fast?orderby=' + selected + '&apply_id=' + $('#apply_id').val(); break;
					case '3' : location.href = '/admin/fast?orderby=' + selected + '&passport_no=' + $('#passport_no').val(); break;
					case '4' : location.href = '/admin/fast?orderby=' + selected + '&start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val(); break;
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
			}
		</script>
		<style type="text/css">
			.form-control {width: 60px;}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>您好，办事处管理员 <?php echo $user['realname'];?>！</h5>
			</div>
			<div id="menu">
				<a href="/admin/permit">管理员帐号</a> / 
				<a href="/admin/ordinary">普通用户帐号</a> / 
				<a style="color:#1100FF;">快速通道</a> / 
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
					</select>
				</div>
				<div id="od1" style="display:inline-block;">
					&nbsp;请选择需要查询的状态类型:&nbsp;
					<select id="cur_status">
						<option value="wait">待审核</option>
						<option value="fail">未通过</option>
						<option value="pass">已通过</option>
						<option value="paid">已缴费</option>
						<option value="visa">已发签证</option>
						<option value="lost">已失效</option>
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
							<a href="/admin/total_preview/<?php echo $one['uuid'];?>" target="_blank">查看详细</a>
							<?php if ($one['status'] != 101) { ?> / 
								<a href="javascript:void(0);" onclick="visa_it('<?php echo $one['uuid'];?>', 'visa', this);">通过签证</a>
							<?php } ?>
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
	<script type="text/javascript">
		var selected = '1';
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
		}
	</script>
</html>