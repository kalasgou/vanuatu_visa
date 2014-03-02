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
		<script type="text/javascript" src="/jshash/md5-min.js"></script>
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				province_list('new');
			});
			
			function new_province_city_agency() {
				var permission = $('#permissions').val();
				if (permission == 0) {
					alert("请选择一个机构类型！");
					return ;
				}
				
				var province_id = $('#provinces').val();
				var new_province = $('#new_province').val();
				if (province_id == 0 && new_province === '') {
					alert("请选择一个已有省份或填写需要新增的省份！");
					return ;
				}
				
				var city_id = $('#cities').val();
				var new_city = $('#new_city').val();
				if (city_id == 0 && new_city === '') {
					alert("请选择一个已有城市或填写需要新增的城市！");
					return ;
				}
				
				var new_agency_name = $('#new_agency_name').val();
				var new_agency_addr = $('#new_agency_addr').val();
				var new_agency_cont = $('#new_agency_cont').val();
				if (new_agency_name === '' || new_agency_addr === '' || new_agency_cont === '') {
					alert("请完整填写机构名称、地址及联系电话！");
					return ;
				}
				
				$.ajax({
					url: '/admin/new_province_city_agency',
					data: {permission: permission, province_id: province_id, new_province: new_province, city_id: city_id, new_city: new_city, new_agency_name: new_agency_name, new_agency_addr: new_agency_addr, new_agency_cont: new_agency_cont},
					type: 'POST',
					dataType: 'json',
					success: function(json) {
						switch (json.msg) {
							case 'success': alert("操作成功，点击“确定”按钮继续添加！"); location.reload(); break;
							case 'fail': alert('无法创建新纪录！'); break;
							case 'province fail': alert('Province Error'); break;
							case 'city fail': alert('City Error'); break;
						}
					},
					error: function() {
						alert('Network Error');
					}
				});
			}
		</script>
		<style type="text/css">
		</style>
	</head>
	<body>
		<div>
			<form class="" method="post" action="javascript:new_province_city_agency();">
				<table class="table">
					<tr>
						<td>机构类型：</td>
						<td>
							<select id="permissions">
								<option value="0">请选择机构类型</option>
								<option value="<?php echo RESERVATION_USER;?>">旅行社</option>
								<option value="<?php echo OFFICE_ADMIN;?>">办事处</option>
								<option value="<?php echo EMBASSY_ADMIN;?>">大使馆</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>所属省份：</td>
						<td>
							已有：<select id="provinces" onchange="javascript:city_list('new');">
								
							</select>
							&nbsp;&nbsp;或新增：<input id="new_province" type="text" placeholder="请输入省份"/>
						</td>
					</tr>
					<tr>
						<td>所属城市：</td>
						<td>
							已有：<select id="cities">
								
							</select>
							&nbsp;&nbsp;或新增：<input id="new_city" type="text" placeholder="请输入城市"/>
						</td>
					</tr>
					<tr>
						<td>机构名称：</td>
						<td><input id="new_agency_name" type="text" style="width:318px;" placeholder="请输入机构全称"/></td>
					</tr>
					<tr>
						<td>机构地址：</td>
						<td><input id="new_agency_addr" type="text" style="width:318px;" placeholder="请输入机构地址"/></td>
					</tr>
					<tr>
						<td>联系电话：</td>
						<td><input id="new_agency_cont" type="text" style="width:318px;" placeholder="请输入机构联系电话"/></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button type="submit" class="btn btn-primary">添加</button>&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" class="btn btn-default" onclick="javascript:history.go(-1);">返回</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>