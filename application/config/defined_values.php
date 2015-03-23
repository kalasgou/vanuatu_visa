<?php
	$config['account_status'] = array(
									ACCOUNT_CANCELLED => '已失效', 
									ACCOUNT_INACTIVE => '未激活', 
									ACCOUNT_NORMAL => '正常'
								);
										
	$config['account_type'] = array(
									ILLEGAL_USER => '非法用户', 
									SYSTEM_ADMIN => '系统管理员', 
									EMBASSY_ADMIN => '大使馆管理员', 
									OFFICE_ADMIN => '办事处管理员', 
									RESERVATION_USER => '网上预约用户',
									CUSTOMER_SERVICE => '客户服务人员'
								);
	
	$config['apply_status_str'] = array(
									NEGATIVE_OVERFLOW => '负溢出异常',
									APPLY_TRASHED => '已删除',
									APPLY_NOTFINISHED => '未提交',
									APPLY_WAITING => '等待审核',
									APPLY_NOTPASSED => '未通过',
									APPLY_PASSED => '通过审核',
									APPLY_PAID => '已缴款',
									VISA_REFUSED => '被拒签',
									VISA_ISSUED => '已发签证',
									VISA_EXPIRED => '签证过期',
									POSITIVE_OVERFLOW => '正溢出异常'
									);
	
	$config['apply_status_stren'] = array(
									NEGATIVE_OVERFLOW => 'Overflow',
									APPLY_TRASHED => 'Deleted',
									APPLY_NOTFINISHED => 'Unfinished',
									APPLY_WAITING => 'Waiting',
									APPLY_NOTPASSED => 'Failed',
									APPLY_PASSED => 'Passed',
									APPLY_PAID => 'Paid',
									VISA_REFUSED => 'Refused',
									VISA_ISSUED => 'Issued',
									VISA_EXPIRED => 'Expired',
									POSITIVE_OVERFLOW => 'Overflow'
									);
	
	$config['apply_status_code'] = array(
									'drop' => APPLY_TRASHED,
									'half' => APPLY_NOTFINISHED,
									'wait' => APPLY_WAITING,
									'fail' => APPLY_NOTPASSED,
									'pass' => APPLY_PASSED,
									'paid' => APPLY_PAID,
									'oops' => VISA_REFUSED,
									'visa' => VISA_ISSUED,
									'best' => VISA_EXPIRED
									);
	
	$config['agency_type'] = array(
									ILLEGAL_USER => '非法', 
									SYSTEM_ADMIN => '系统', 
									EMBASSY_ADMIN => '大使馆', 
									OFFICE_ADMIN => '办事处', 
									RESERVATION_USER => '旅行社'
								);
	
	$config['apply_status_overview'] = array(
									NEGATIVE_OVERFLOW => 'Overflow',
									APPLY_TRASHED => 'Deleted',
									APPLY_NOTFINISHED => 'Not Finished',
									APPLY_WAITING => 'Waiting for Audition',
									APPLY_NOTPASSED => 'Audition Failed',
									APPLY_PASSED => 'Audition Passed',
									APPLY_PAID => 'Fee Paid',
									VISA_REFUSED => 'Visa Refused',
									VISA_ISSUED => 'Visa Issued',
									VISA_EXPIRED => 'Visa Expired',
									POSITIVE_OVERFLOW => 'Overflow'
									);
?>