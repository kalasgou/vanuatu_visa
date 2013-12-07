<?php header("Content-type: text/html; charset=utf-8");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Vanuatu Visa</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta content="" name="">
		<link rel="apple-touch-icon-precomposed" href=""/>
		<link rel="shortcut icon" href=""/>
		<style type="text/css">
			#application_form div {position:relative; padding:4px 12px; font-size:16px; top:24px;}
			#answer {display:inline-block; border-bottom:1px dotted #000; text-align:center;}
			#option {display:inline-block;}
			table {border-collapse:collapse; border:1px solid; text-align:center;}
			th, td {border:1px solid; padding:8px; font-weight: normal;}
			#signature {display:inline-block; border-bottom:1px dotted #000; width:250px;}
			#annoucement {text-align:center;}
		</style>
	</head>
	<body>
		<div>
			<div id="annoucement"><img src="/var/www.visa2vanuatu.cn/www/vanuatu.jpg" style="width:80px;"/></div>
			<div id="annoucement"><b>THE REPUBLIC OF VANUATU</b></div>
			<div id="annoucement"><b>APPLICATION FOR A VISA FOR VANUATU</b></div>
			<div id="annoucement"><b>瓦努阿图共和国签证申请表</b></div>
		</div>
		<br>
		<div>
			<div style="position:relative; float:right;">&nbsp;&nbsp;&nbsp;&nbsp;</div>
			<div style="position:relative; float:right; width:130px; height:170px; border:1px solid; text-align:center; border:1px solid; font-size:8px; font-style:italic;">
				<br><br><br><br><br><br><br>Attach 1 passport size photograph<br>请附1张护照照片
			</div>
		</div>
		<br>
		<div id="application_form">
			<div>
				1、Full name 姓名:
				(English英文) <span id="answer" style="width:200px;"><?php echo $name_en;?></span>
				(Chinese中文) <span id="answer" style="width:200px;"><?php echo $name_cn;?></span>
			</div>
			<div>
				2、Mr.先生
				<span id="option"><input type="checkbox" <?php echo ($gender == 1 ? 'checked="checked"' : '');?>/></span>
				Mrs.女士 <span id="option"><input type="checkbox" <?php echo ($gender == 2 ? 'checked="checked"' : '');?>/></span>
				Miss小姐 <span id="option"><input type="checkbox" <?php echo ($gender == 3 ? 'checked="checked"' : '');?>/></span>
			</div>
			<div>3、Nationality 国籍:
				<span id="answer" style="width:200px;"><?php echo $nationality;?></span>
			</div>
			<div>
				4、Date of Birth 出生日期:
				Day 日 <span id="answer" style="width:200px;"><?php echo $birth_day;?></span>
				Month 月 <span id="answer" style="width:200px;"><?php echo $birth_month;?></span>
				Year 年 <span id="answer" style="width:200px;"><?php echo $birth_year;?></span>
			</div>
			<div>
				5、Place of birth 出生地点:
				<span id="answer" style="width:200px;"><?php echo $birth_place;?></span>
			</div>
			<div>
				6、Family Situation 婚姻状况:
				Married 已婚 <span id="option"><input type="checkbox" <?php echo ($family == 4 ? 'checked="checked"' : '');?>/></span>
				Single 单身 <span id="option"><input type="checkbox" <?php echo ($family == 5 ? 'checked="checked"' : '');?>/></span>
				Widowed 丧偶 <span id="option"><input type="checkbox" <?php echo ($family == 6 ? 'checked="checked"' : '');?>/></span>
				Divorced 离异 <span id="option"><input type="checkbox" <?php echo ($family == 7 ? 'checked="checked"' : '');?>/></span>
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
				<span id="answer" style="width:200px;"><?php echo $occupation_info['employer'];?></span>
				Tel No.电话: <span id="answer" style="width:200px;"><?php echo $occupation_info['employer_tel'];?></span><br>
				(b) Address 单位地址: <span id="answer" style="width:200px;"><?php echo $occupation_info['employer_addr'];?></span>
			</div>
			<?php
				$home_info = json_decode($home_info, TRUE);
			?>
			<div>
				9、Home Address 家庭住址:
				<span id="answer" style="width:200px;"><?php echo $home_info['home_addr'];?></span><br>
				Tel No.电话: <span id="answer" style="width:200px;"><?php echo $home_info['home_tel'];?></span><br>
			</div>
			<div>
				10、Passport 护照:<br>
				(a) Number 护照号 <span id="answer" style="width:200px;"><?php echo $passport_number;?></span>
				(b) Place of Issue 发照地 <span id="answer" style="width:200px;"><?php echo $passport_place;?></span><br>
				(c) Date of Issue 发照日期 <span id="answer" style="width:200px;"><?php echo $passport_date;?></span>
				(d) Expiry Date 有效日期至 <span id="answer" style="width:200px;"><?php echo $passport_expiry;?></span>
			</div>
			<div>
				11、Purpose of Visit 访瓦目的:<br>
				Tourism 旅游 <span id="option"><input type="checkbox" <?php echo ($purpose == 8 ? 'checked="checked"' : '');?>/></span>
				Visiting Relative 探亲 <span id="option"><input type="checkbox" <?php echo ($purpose == 9 ? 'checked="checked"' : '');?>/></span>
				Business 商务 <span id="option"><input type="checkbox" <?php echo ($purpose == 10 ? 'checked="checked"' : '');?>/></span>
				Other 其他 <span id="option"><input type="checkbox" <?php echo ($purpose == 11 ? 'checked="checked"' : '');?>/></span>
			</div>
			<div>
				12、Address in Vanuatu 在瓦地址:
				<span id="answer" style="width:200px;"><?php echo $destination;?></span>
			</div>
			<?php
				$relative_info = json_decode($relative_info, TRUE);
			?>
			<div>
				13、Details of Family in Vanuatu if visiting relative 如属探亲在瓦亲属概况:<br>
				Name 姓名: <span id="answer" style="width:100px;"><?php echo $relative_info['relative_name'];?></span>
				Add. 地址: <span id="answer" style="width:300px;"><?php echo $relative_info['relative_addr'];?></span>
			</div>
			<?php
				$detail_info = json_decode($detail_info, TRUE);
			?>
			<div>
				14、Details of arrival in Vanuatu 抵瓦航班号:
				<span id="answer" style="width:200px;"><?php echo $detail_info['arrival_number'];?></span>
				日期: <span id="answer" style="width:200px;"><?php echo $detail_info['arrival_date'];?></span>
			</div>
			<div>
				15、Details of return ticket 回程航班号:
				<span id="answer" style="width:200px;"><?php echo $detail_info['return_number'];?></span>
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
				18、Details of family included in passport<br>
				护照内偕行儿童详细信息:<br>
				<table id="children_info">
					<tr>
						<th>Name 姓名</th>
						<th>Sex 性别</th>
						<th>Date of birth 出生日期</th>
						<th>Place of birth 出生地</th>
					</tr>
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
				</table>
			</div>
			<?php
				$behaviour_info = json_decode($behaviour_info, TRUE);
			?>
			<div>
				19、(a) Been convicted of or have any charges outstanding on a criminal offence in any country<br>
				是否在任何国家有过犯罪记录: Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['criminal'] === 'on' ? 'checked="checked"' : '');?>/></span> Where哪一国家 <span id="answer" style="width:200px;"><?php echo $behaviour_info['crime_country'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['criminal'] === 'off' ? 'checked="checked"' : '');?>/></span><br>
				(b) Been deported or excluded from any country<br>
				是否有被任何国家驱逐出境的经历: Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['deported'] === 'on' ? 'checked="checked"' : '');?>/></span> Where哪一国家 <span id="answer" style="width:200px;"><?php echo $behaviour_info['deport_country'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['deported'] === 'off' ? 'checked="checked"' : '');?>/></span>
			</div>
			<div>
				20、Details of previous visits? 您曾经到过瓦努阿图吗？<br>
				Yes有 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['visited'] === 'on' ? 'checked="checked"' : '');?>/></span>
				No没有 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['visited'] === 'off' ? 'checked="checked"' : '');?>/></span>
			</div>
			<div>
				21、Have you ever applied for a work, residence or student permit before in Vanuatu?<br>
				您是否曾经在瓦努阿图申请过工作、居留或学生签证？ Yes是 <span id="option"><input type="checkbox"  <?php echo ($behaviour_info['applied'] === 'on' ? 'checked="checked"' : '');?>/></span> When何时 <span id="answer" style="width:200px;"><?php echo $behaviour_info['apply_date'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['applied'] === 'off' ? 'checked="checked"' : '');?>/></span><br>
			</div>
			<div>
				22、Have you ever been refused entry to Vanuatu?<br>
				您曾经被瓦努阿图拒签过吗？ Yes是 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['refused'] === 'on' ? 'checked="checked"' : '');?>/></span> When何时 <span id="answer" style="width:200px;"><?php echo $behaviour_info['refuse_date'];?></span> No否 <span id="option"><input type="checkbox" <?php echo ($behaviour_info['refused'] === 'off' ? 'checked="checked"' : '')?>/></span><br>
			</div>
			<div>23、I declare that the information given in this application is true and correct to the best of my knowledge and belief.<br>
				我声明，本人在本申请表中所做之回答就本人所知均属实无误。<br>
				Signature 签字 <span id="signature"><?php for ($i = 1; $i < 50; $i ++) echo '&nbsp;';?></span>
				Date 日期 <span id="signature"><?php for ($i = 1; $i < 50; $i ++) echo '&nbsp;';?></span><br>
				<span>(The holder of a visitor visa must not work or study in Vanuatu. 旅游签证持有者在旅游期间不得在瓦努阿图工作或学习。)<span>
			</div>
			<div style="margin-top:100px; margin-bottom:12px;"><b style="border-bottom:1px solid #000;">RESERVED FOR EMBASSY</b></div> 
			<div>Valid until: ………………………………………………………………………………………………………</div>
			<div>Date of Issue: …………………………………………………………………………………………………</div>
			<div>No. Visa: …………………………………………………………………………………………………………</div>
			<div>Comment / Remarks: …………………………………………………………………………………………</div>
		</div>
	</body>
</html>
<?php
	$HTMLoutput = ob_get_contents();
	ob_end_clean();
	
	//Convert HTML 2 PDF by using MPDF PHP library
	require '../application/third_party/mPDF/mpdf.php';
	$mpdf = new mPDF('utf-8'); 
	$mpdf->useAdobeCJK = TRUE; 
	$mpdf->SetAutoFont(AUTOFONT_ALL);
	$mpdf->WriteHTML($HTMLoutput);
	$mpdf->Output('application_form.pdf', 'D');
?>