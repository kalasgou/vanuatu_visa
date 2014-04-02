<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<!--<meta http-equiv="Refresh" content="60">-->
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
					case '<?php echo APPLY_STATUS;?>' : location.href = '/admin/approve?lang=en&orderby=' + selected + '&cur_status=' + $('#cur_status').val(); break;
					case '<?php echo APPLY_UUID;?>' : location.href = '/admin/approve?lang=en&orderby=' + selected + '&apply_id=' + $('#apply_id').val(); break;
					case '<?php echo APPLY_PASSPORT;?>' : location.href = '/admin/approve?lang=en&orderby=' + selected + '&passport_no=' + $('#passport_no').val(); break;
					case '<?php echo APPLY_PERIOD;?>' : location.href = '/admin/approve?lang=en&orderby=' + selected + '&start_time=' + $('#start_time').val() + '&end_time=' + $('#end_time').val(); break;
					case '<?php echo APPLY_PRESENT;?>' : location.href = '/admin/approve?lang=en&orderby=' + selected; break;
					default : return;
				}
			}
			
			function set_default_filter() {
				if (selected_arg === '') {
					return ;
				}
				$('#od' + selected).css('display', 'none');
				selected = selected_arg;
				$('#orderby').val(selected);
				$('#od' + selected).css('display', 'inline-block');
				switch (selected) {
					case '<?php echo APPLY_STATUS;?>' : $('#cur_status').val(cur_status); refresh_tuner = setInterval('location.reload();', 10000); break;
					case '<?php echo APPLY_UUID;?>' : $('#apply_id').val(apply_id); break;
					case '<?php echo APPLY_PASSPORT;?>' : $('#passport_no').val(passport_no); break;
					case '<?php echo APPLY_PERIOD;?>' : $('#start_time').val(start_time); $('#end_time').val(end_time); break;
					default : return;
				}
			}
		</script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="hello">
				<h5>Hello. Embassy Admin <?php echo $user['nickname'];?>!</h5>
			</div>
			<div id="lang_switch">
				<a href="/admin/approve?lang=sc">中文</a> / 
				<a style="color:#CACACA;">English</a>
			</div>
			<div id="menu">
				<a style="color:#1100FF;">Application</a> / 
				<a href="/admin/audit_trace?lang=en">History</a> / 
				<a href="/account">Account</a> / 
				<a href="/password">Password</a> / 
				<a href="/logout">Logout</a>
				<label id="auto_visa">
					Auto Issue
					<a <?php echo $auto_visa_switch === FALSE ? 'href="javascript:void(0);" onclick="javascript:auto_visa_switch(\'on\');"' : 'style="color:#CACACA;"'?>>On</a> / 
					<a <?php echo $auto_visa_switch === TRUE ? 'href="javascript:void(0);" onclick="javascript:auto_visa_switch(\'off\');"' : 'style="color:#CACACA;"'?>>Off</a>
				</label>
			</div>
		</nav>
		<div id="list_box">
			<div>
				<div style="display:inline-block;">
					Serach by:&nbsp;
					<select id="orderby" onclick="javascript:disable_refresh_tuner();" onchange="javascript:what_is_selected();">
						<option value="<?php echo APPLY_STATUS;?>">Status</option>
						<option value="<?php echo APPLY_UUID;?>">Serial No.</option>
						<option value="<?php echo APPLY_PASSPORT;?>">Passport No.</option>
						<option value="<?php echo APPLY_PERIOD;?>">Date</option>
						<option value="<?php echo APPLY_PRESENT;?>">Offline</option>
					</select>
				</div>
				<div id="od1" style="display:inline-block;">
					&nbsp;Application Status:&nbsp;
					<select id="cur_status">
						<option value="pass">Passed</option>
						<option value="visa">Issued</option>
						<option value="oops">Refused</option>
						<option value="best">Expired</option>
					</select>
				</div>
				<div id="od2" style="display:none">
					&nbsp;Serial Number of Application:&nbsp;<input id="apply_id" type="text" placeholder="Serial No."/>
				</div>
				<div id="od3" style="display:none">
					&nbsp;Passport Number of Application:&nbsp;<input id="passport_no" type="text" placeholder="Passport No."/>
				</div>
				<div id="od4" style="display:none">
					&nbsp;Date:&nbsp;from <input id="start_time" type="text" placeholder="From" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd', maxDate:'%y-%M-%d'})"/> ~ 
					to <input id="end_time" type="text" placeholder="To" onclick="WdatePicker({readOnly:true, dateFmt:'yyyy-MM-dd', maxDate:'%y-%M-%d'})"/>
					<a href="javascript:void(0)" onclick="download_excel('admin');" target="_blank">Download Excel</a>
				</div>
				<div style="display:inline-block;">
					<button onclick="javascript:filter_them(selected);">Search</button>
				</div>
			</div>
			<table class="table table-hover">
				<colgroup>
					<col style="width:11%;"/>
					<col style="width:12%"/>
					<col style="width:10%;"/>
					<col style="width:8%"/>
					<col style="width:10%;"/>
					<col style="width:9%"/>
					<col style="width:10%;"/>
					<col style="width:10%;"/>
					<col style="width:15%;"/>
				</colgroup>
				<thead>
					<tr>
						<th>Serial No.</th>
						<th>Name</th>
						<th>Passport No.</th>
						<th>Fee</th>
						<th>Submit Date</th>
						<th>Status</th>
						<th>Audit Date</th>
						<th>Issue Date</th>
						<th>Operation</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($records) > 0) {
							foreach ($records as $one) { 
					?>
					<tr>
						<td><?php echo $one['uuid'];?></td>
						<td><?php echo $one['first_name'];?> <?php echo $one['last_name'];?></td>
						<td><?php echo $one['passport_number'];?></td>
						<td><?php echo $one['fee'];?></td>
						<td><span title="Detail <?php echo $one['submit_time'];?>"><?php echo substr($one['submit_time'], 0, 10);?></span></td>
						<td><?php echo $one['status_str'];?></td>
						<td><span title="Detail <?php echo $one['audit_time'];?>"><?php echo substr($one['audit_time'], 0, 10);?></span></td>
						<td><span title="Detail <?php echo $one['approve_time'];?>"><?php echo substr($one['approve_time'], 0, 10);?></span></td>
						<td>
							<a href="/admin/total_preview/<?php echo $one['uuid'];?>" target="_blank">Detail</a>
							<?php if ($one['status'] == APPLY_PASSED) { ?> / 
								<a style="color:green;" href="javascript:void(0);" onclick="visa_it('<?php echo $one['uuid'];?>', 'visa', this);">Issue</a>
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
				<p><label style="color:green;"><?php echo $num_records;?></label> Application<?php echo $num_records > 1 ? 's' : '';?> Found</p>
				<?php echo $pagination;?>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		var selected = '<?php echo APPLY_STATUS;?>', refresh_tuner = '';
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