<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<link rel="stylesheet" type="text/css" href=''>
		<script type="text/javascript" src=""/>
		<script type="text/javascript" src=""/>
		<script type="text/javascript" src=""/>
		<script type="text/javascript">
			$(document).ready(function(){
				
			});
		</script>
		<style type="text/css">
			body {font-family:droid;}
			#application_form div {padding:4px 12px; font-size:18px;}
			#answer {display:inline-block; border-bottom:1px dotted #000; text-align:center;}
			#option {display:inline-block;}
			table {border-collapse:collapse; border:1px solid; text-align:center;}
			th, td {border:1px solid; padding:8px; font-weight: normal;}
		</style>
	</head>
	<body>
		<div id="step_menu" style="display:inline;">
			<a href="">basic info</a>
			<a href="">passport info</a>
			<a href="">travel info</a>
			<a href="">other info</a>
		</div>
		<p></p>
		<div id="application_form">
			<div>
				1、Full name 姓名:
				(English英文) <span id="answer" style="width:200px;">123</span>
				(Chinese中文) <span id="answer" style="width:200px;">321</span>
			</div>
			<div>
				2、Mr.先生
				<span id="option"><input type="checkbox" checked="checked"/></span>
				Mrs.女士 <span id="option"><input type="checkbox"/></span>
				Miss小姐 <span id="option"><input type="checkbox"/></span>
			</div>
			<div>3、Nationality 国籍:
				<span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				4、Date of Birth 出生日期:
				Day 日 <span id="answer" style="width:200px;">123</span>
				Month 月 <span id="answer" style="width:200px;">321</span>
				Year 年 <span id="answer" style="width:200px;">321</span>
			</div>
			<div>
				5、Place of birth 出生地点:
				<span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				6、Family Situation 婚姻状况:
				Married 已婚 <span id="option">123</span>
				Single 单身 <span id="option">321</span>
				Widowed 丧偶 <span id="option">321</span>
				Divorced 离异 <span id="option">321</span>
			</div>
			<div>
				7、Occupation 职业: 
				<span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				8、(a) Employer 就业单位:
				<span id="answer" style="width:200px;">123</span>
				Tel No.电话: <span id="answer" style="width:200px;">321</span><br>
				(b) Address 单位地址: <span id="answer" style="width:200px;">321</span>
			</div>
			<div>
				9、Home Address 家庭住址:
				<span id="answer" style="width:200px;">123</span><br>
				Tel No.电话: <span id="answer" style="width:200px;">321</span><br>
			</div>
			<div>
				10、Passport 护照:<br>
				(a) Number 护照号 <span id="answer" style="width:200px;">123</span>
				(b) Place of Issue 发照地 <span id="answer" style="width:200px;">321</span><br>
				(c) Date of Issue 发照日期 <span id="answer" style="width:200px;">321</span>
				(d) Expiry Date 有效日期至 <span id="answer" style="width:200px;">321</span>
			</div>
			<div>
				11、Purpose of Visit 访瓦目的:<br>
				Tourism 旅游 <span id="option">123</span>
				Visiting Relative 探亲 <span id="option">321</span>
				Business 商务 <span id="option">321</span>
				Other 其他 <span id="option">321</span>
			</div>
			<div>
				12、Address in Vanuatu 在瓦地址:
				<span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				13、Details of Family in Vanuatu if visiting relative 如属探亲在瓦亲属概况:<br>
				Name 姓名: <span id="answer" style="width:100px;">123</span>
				Add. 地址: <span id="answer" style="width:300px;">123</span>
			</div>
			<div>
				14、Details of arrival in Vanuatu抵瓦航班号:
				<span id="answer" style="width:200px;">123</span>
				日期: <span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				15、Details of return ticket 回程航班号:
				<span id="answer" style="width:200px;">123</span>
				日期: <span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				16、Proposed duration of stay 拟在瓦逗留时间:
				<span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				17、Source of financial support in Vanuatu 在瓦费用来源:
				<span id="answer" style="width:200px;">123</span>
			</div>
			<div>
				18、Details of family included in passport<br>
				护照内偕行儿童详细信息:<br>
				<table id="children_info">
					<tr>
						<th>Name 姓名</th>
						<th>Sex 性别</th>
						<th>Date of birth 出生日期</th>
						<th>Place of birth 出生地</th>
					</tr>
					<tr>
						<td>123123123123</td>
						<td>123123123123</td>
						<td>123123123123</td>
						<td>123123123123</td>
					</tr>
					<tr>
						<td>123123123123</td>
						<td>123123123123</td>
						<td>123123123123</td>
						<td>123123123123</td>
					</tr>
					<tr>
						<td>123123123123</td>
						<td>123123123123</td>
						<td>123123123123</td>
						<td>123123123123</td>
					</tr>
				</table>
			</div>
			<div>
				19、(a) Been convicted of or have any charges outstanding on a criminal offence in any country<br>
				是否在任何国家有过犯罪记录: Yes 是 <span id="option">321</span>Where 哪一国家 <span id="answer" style="width:200px;">123</span>No 否 <span id="option">321</span><br>
				(b) Been deported or excluded from any country<br>
				是否有被任何国家驱逐出境的经历: Yes 是 <span id="option">321</span>Where 哪一国家 <span id="answer" style="width:200px;">123</span>No 否 <span id="option">321</span>
			</div>
			<div>
				20、Details of previous visits? 您曾经到过瓦努阿图吗？<br>
				Yes 有 <span id="option">123</span>
				No 没有 <span id="option">321</span>
			</div>
			<div>
				21、Have you ever applied for a work, residence or student permit before in Vanuatu?<br>
				您是否曾经在瓦努阿图申请过工作、居留或学生签证？ Yes 是 <span id="option">321</span>When 何时 <span id="answer" style="width:200px;">123</span>No 否 <span id="option">321</span><br>
			</div>
			<div>
				22、Have you ever been refused entry to Vanuatu?<br>
				您曾经被瓦努阿图拒签过吗？ Yes 是 <span id="option">321</span>When 何时 <span id="answer" style="width:200px;">123</span>No 否 <span id="option">321</span><br>
			</div>
		</div>
	</body>
</html>
<?php
	$HTMLoutput = ob_get_contents();
	ob_end_clean();
	
	//Convert HTML 2 PDF by using MPDF PHP library
	/*require '../application/third_party/mPDF/mpdf.php';
	$mpdf = new mPDF('utf-8'); 
	$mpdf->useAdobeCJK = TRUE; 
	$mpdf->SetAutoFont(AUTOFONT_ALL);
	$mpdf->WriteHTML($HTMLoutput);
	$mpdf->Output('application_form.pdf', 'D');*/
	require '../application/third_party/dompdf/dompdf_config.inc.php';
	$dompdf = new DOMPDF();
	$dompdf->load_html($HTMLoutput);
	$dompdf->render();
	$dompdf->stream('sample.pdf');
?>