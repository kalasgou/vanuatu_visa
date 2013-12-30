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
		<script type="text/javascript" src="/simple.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
			
			function get_trace_admin(uuid) {
				$.ajax({
					url: '/admin/audit_trace_by_uuid/' + uuid,
					data: {},
					type: 'GET',
					dataType: 'json',
					success: function(json) {
						var detail = '';
						var len = json.records.length;
						if (len > 0) {
							for (var i = 0; i < len; i ++) {
								detail += 	'<tr>' + 
												'<td>' + json.records[i].status_str + '</td>' + 
												'<td>' + json.records[i].audit_time + '</td>' + 
												'<td>' + json.records[i].message + '</td>' + 
											'</tr>';
							}
						} else {
							detail = '<tr><td colspan="3">暂时没有任何审核记录</td></tr>';
						}
						$('#trace_body').empty();
						$('#trace_body').append(detail);
					},
					error: function() {
						alert('Network Error');
					}
				});
			}
		</script>
		<style type="text/css">
			body {padding:0px;}
			#application_form {width:810px; top:0px; left:0px;}
			#application_form div {padding:4px;}
			#answer {display:inline-block; border-bottom:1px dotted #000; text-align:center;}
			#option {display:inline-block;}
			table {border-collapse:collapse; border:1px solid; text-align:center;}
			th, td {border:1px solid; padding:8px; font-weight: normal; text-align:center;}
			img {width:100%;}
			#message {width:100%; height:160px; overflow-y:auto; overflow-x:hidden; word-wrap:break-word; resize:none;}
		</style>
	</head>
	<body>
		<div id="application_form">
			<div>
				1、Full name 姓名:
				(English英文) <span id="answer" style="width:150px;"><?php echo $name_en;?></span>
				(Chinese中文) <span id="answer" style="width:150px;"><?php echo $name_cn;?></span>
			</div>
			<div>
				2、Mr.先生
				<span id="option"><input type="checkbox" <?php echo ($gender == 1 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Mrs.女士 <span id="option"><input type="checkbox" <?php echo ($gender == 2 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Miss小姐 <span id="option"><input type="checkbox" <?php echo ($gender == 3 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
			</div>
			<div>3、Nationality 国籍:
				<span id="answer" style="width:150px;"><?php echo $nationality;?></span>
			</div>
			<div>
				4、Date of Birth 出生日期:
				Day 日 <span id="answer" style="width:60px;"><?php echo $birth_day;?></span>
				Month 月 <span id="answer" style="width:60px;"><?php echo $birth_month;?></span>
				Year 年 <span id="answer" style="width:60px;"><?php echo $birth_year;?></span>
			</div>
			<div>
				5、Place of birth 出生地点:
				<span id="answer" style="width:200px;"><?php echo $birth_place;?></span>
			</div>
			<div>
				6、Family Situation 婚姻状况:<br>&nbsp;&nbsp;
				Married 已婚 <span id="option"><input type="checkbox" <?php echo ($family == 4 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Single 单身 <span id="option"><input type="checkbox" <?php echo ($family == 5 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Widowed 丧偶 <span id="option"><input type="checkbox" <?php echo ($family == 6 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Divorced 离异 <span id="option"><input type="checkbox" <?php echo ($family == 7 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
			</div>
			<?php
				$occupation_info = json_decode($occupation_info, TRUE);
			?>
			<div>
				7、Occupation 职业: 
				<span id="answer" style="width:200px;"><?php echo $occupation_info['occupation'];?></span>
			</div>
			<div>
				8、(a) Employer 就业单位:
				<span id="answer" style="width:250px;"><?php echo $occupation_info['employer'];?></span>
				Tel No.电话: <span id="answer" style="width:150px;"><?php echo $occupation_info['employer_tel'];?></span><br>&nbsp;&nbsp;
				(b) Address 单位地址: <span id="answer" style="width:350px;"><?php echo $occupation_info['employer_addr'];?></span>
			</div>
			<?php
				$home_info = json_decode($home_info, TRUE);
			?>
			<div>
				9、Home Address 家庭住址:
				<span id="answer" style="width:350px;"><?php echo $home_info['home_addr'];?></span><br>&nbsp;&nbsp;
				Tel No.电话: <span id="answer" style="width:150px;"><?php echo $home_info['home_tel'];?></span><br>
			</div>
			<div>
				10、Passport 护照:<br>
				(a) Number 护照号 <span id="answer" style="width:160px;"><?php echo $passport_number;?></span>
				(b) Place of Issue 发照地 <span id="answer" style="width:160px;"><?php echo $passport_place;?></span><br>
				(c) Date of Issue 发照日期 <span id="answer" style="width:120px;"><?php echo date('Y-m-d', $passport_date);?></span>
				(d) Expiry Date 有效日期至 <span id="answer" style="width:120px;"><?php echo date('Y-m-d', $passport_expiry);?></span>
			</div>
			<div>
				11、Purpose of Visit 访瓦目的:<br>&nbsp;&nbsp;
				Tourism 旅游 <span id="option"><input type="checkbox" <?php echo ($purpose == 8 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Visiting Relative 探亲 <span id="option"><input type="checkbox" <?php echo ($purpose == 9 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Business 商务 <span id="option"><input type="checkbox" <?php echo ($purpose == 10 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				Other 其他 <span id="option"><input type="checkbox" <?php echo ($purpose == 11 ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				<span id="answer" style="width:128px;"><?php echo $other_purpose;?></span>
			</div>
			<div>
				12、Address in Vanuatu 在瓦地址:
				<span id="answer" style="width:350px;"><?php echo $destination;?></span>
			</div>
			<?php
				$relative_info = json_decode($relative_info, TRUE);
			?>
			<div>
				13、Details of Family in Vanuatu if visiting relative 如属探亲在瓦亲属概况:<br>&nbsp;&nbsp;
				Name 姓名: <span id="answer" style="width:120px;"><?php echo $relative_info['relative_name'];?></span>
				Add. 地址: <span id="answer" style="width:330px;"><?php echo $relative_info['relative_addr'];?></span>
			</div>
			<?php
				$detail_info = json_decode($detail_info, TRUE);
			?>
			<div>
				14、Details of arrival in Vanuatu <br>
				抵瓦航班号: <span id="answer" style="width:200px;"><?php echo $detail_info['arrival_number'];?></span>
				日期: <span id="answer" style="width:200px;"><?php echo $detail_info['arrival_date'];?></span>
			</div>
			<div>
				15、Details of return ticket <br>
				回程航班号: <span id="answer" style="width:200px;"><?php echo $detail_info['return_number'];?></span>
				日期: <span id="answer" style="width:200px;"><?php echo $detail_info['return_number'];?></span>
			</div>
			<div>
				16、Proposed duration of stay 拟在瓦逗留时间:
				<span id="answer" style="width:200px;"><?php echo $detail_info['duration'];?></span>
			</div>
			<div>
				17、Source of financial support in Vanuatu 在瓦费用来源:
				<span id="answer" style="width:200px;"><?php echo $detail_info['financial_source'];?></span>
			</div>
			<div>
				18、Details of family included in passport<br>&nbsp;&nbsp;
				护照内偕行儿童详细信息:<br>
				<table id="children_info">
					<thead>
						<tr>
							<th style="width:150px;">Name 姓名</th>
							<th style="width:120px;">Sex 性别</th>
							<th style="width:250px;">Date of birth 出生日期</th>
							<th style="width:250px;">Place of birth 出生地</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$children_info = json_decode($children_info, TRUE);
							foreach ($children_info as $kid) {
						?>
						
						<tr>
							<td><?php echo $kid['child_name'];?></td>
							<td><?php echo $kid['child_sex'];?></td>
							<td><?php echo $kid['child_date'];?></td>
							<td><?php echo $kid['child_place'];?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php
				$behaviour_info = json_decode($behaviour_info, TRUE);
			?>
			<div>
				19、(a) Been convicted of or have any charges outstanding on a criminal offence in any country<br>
				是否在任何国家有过犯罪记录: Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['criminal'] === 'on' ? 'checked="checked"' : 'disabled="disabled"');?>/></span> Where哪一国家 <span id="answer" style="width:150px;"><?php echo $behaviour_info['crime_country'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['criminal'] === 'off' ? 'checked="checked"' : 'disabled="disabled"');?>/></span><br>
				(b) Been deported or excluded from any country<br>
				是否有被任何国家驱逐出境的经历: Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['deported'] === 'on' ? 'checked="checked"' : 'disabled="disabled"');?>/></span> Where哪一国家 <span id="answer" style="width:150px;"><?php echo $behaviour_info['deport_country'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['deported'] === 'off' ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
			</div>
			<div>
				20、Details of previous visits? 您曾经到过瓦努阿图吗？
				Yes有 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['visited'] === 'on' ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
				No没有 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['visited'] === 'off' ? 'checked="checked"' : 'disabled="disabled"');?>/></span>
			</div>
			<div>
				21、Have you ever applied for a work, residence or student permit before in Vanuatu?<br>
				您是否曾经在瓦努阿图申请过工作、居留或学生签证？<br>Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['applied'] === 'on' ? 'checked="checked"' : 'disabled="disabled"');?>/></span> When何时 <span id="answer" style="width:150px;"><?php echo $behaviour_info['apply_date'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['applied'] === 'off' ? 'checked="checked"' : 'disabled="disabled"');?>/></span><br>
			</div>
			<div>
				22、Have you ever been refused entry to Vanuatu?<br>
				您曾经被瓦努阿图拒签过吗？ Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['refused'] === 'on' ? 'checked="checked"' : 'disabled="disabled"');?>/></span> When何时 <span id="answer" style="width:150px;"><?php echo $behaviour_info['refuse_date'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['refused'] === 'off' ? 'checked="checked"' : 'disabled="disabled"');?>/></span><br>
			</div>
			<?php if ($status >= 41) { ?>
			<div id="scan_file">
				<div>签证相片:<img src="<?php echo $photo_pic?>" alt="签证相片"/></div>
				<div>护照:<img src="<?php echo $passport_pic?>" alt="护照"/></div>
				<div>身份证:<img src="<?php echo $identity_pic?>" alt="身份证"/></div>
				<div>往返机票:<img src="<?php echo $ticket_pic?>" alt="往返机票"/></div>
				<div>银行存款证明:<img src="<?php echo $deposition_pic?>" alt="银行存款证明"/></div>
			</div>
			<? } ?>
			<br>
			<div>
				<b>审核记录：</b><br>
				<table style="width:100%;">
					<colgroup>
						<col style="width:15%;"/>
						<col style="width:25%;"/>
						<col style="width:60%;"/>
					</colgroup>
					<thead>
						<tr>
							<th>审核状态</th>
							<th>审核时间</th>
							<th>审核留言</th>
						</tr>
					</thead>
					<tbody id="trace_body">
					</tbody>
					<tr>
						<td colspan="3"><a href="javascript:void(0);" onclick="get_trace_admin('<?php echo $uuid;?>')">刷新一下</a></td>
					</tr>
				</table>
			</div>
			<br>
			<?php if ($status < 31 && $user['permission'] == 3) { ?>
			<div>
				<b>请在此处填写审核留言（主要填写申请未能通过审核的原因，若通过可不填写）：</b><br>
				<textarea id="message"></textarea>
			</div>
			<div id="next_step">
				<a class="btn btn-success" href="javascript:pass_or_not('<?php echo $uuid;?>', 'pass');">通过</a>
				<a class="btn btn-warning" href="javascript:pass_or_not('<?php echo $uuid;?>', 'fail');">驳回</a>
			</div>
			<?php } ?>
			<?php if ($status == 41 && $user['permission'] == 2) { ?>
			<div id="next_step">
				<a class="btn btn-success" href="javascript:visa_or_not('<?php echo $uuid;?>', 'visa');">同意</a>
				<a class="btn btn-warning" href="javascript:visa_or_not('<?php echo $uuid;?>', 'oops');">拒签</a>
			</div>
			<?php } ?>
		</div>
	</body>
</html>