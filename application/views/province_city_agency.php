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
			
			function submit_form() {
				return true;
			}
		</script>
		<style type="text/css">
		</style>
	</head>
	<body>
		<div>
			<form class="form-horizontal" role="form" method="post" action="/admin/new_province_city_agency" onsubmit="return submit_form();">
				<table class="table">
					<tr>
						<td>机构类型：</td>
						<td>
							<select name="permission">
								<option value="<?php echo RESERVATION_USER;?>">旅行社</option>
								<option value="<?php echo OFFICE_ADMIN;?>">办事处</option>
								<option value="<?php echo EMBASSY_ADMIN;?>">大使馆</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>所属省份：</td>
						<td>
							已有：<select id="provinces" name="province_id" onchange="javascript:city_list('new');">
								
							</select>
							&nbsp;&nbsp;或新增：<input name="new_province" type="text" placeholder="请输入省份"/>
						</td>
					</tr>
					<tr>
						<td>所属城市：</td>
						<td>
							已有：<select id="cities" name="city_id">
								
							</select>
							&nbsp;&nbsp;或新增：<input name="new_city" type="text" placeholder="请输入城市"/>
						</td>
					</tr>
					<tr>
						<td>机构名称：</td>
						<td><input name="new_agency_name" type="text" style="width:318px;" placeholder="请输入机构全称"/></td>
					</tr>
					<tr>
						<td>机构地址：</td>
						<td><input name="new_agency_addr" type="text" style="width:318px;" placeholder="请输入机构地址"/></td>
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