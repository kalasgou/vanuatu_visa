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
									RESERVATION_USER => '网上预约用户'
								);
	
	
	$config['apply_status_str'] = array(
									NEGATIVE_OVERFLOW => '负溢出异常',
									APPLY_TRASHED => '已删除',
									APPLY_NOTFINISHED => '未完成',
									APPLY_WAITING => '等待审核',
									APPLY_NOTPASSED => '未通过',
									APPLY_PASSED => '通过审核',
									APPLY_PAID => '已缴款',
									APPLY_REJECTED => '被拒签',
									APPLY_ACCEPTED => '已出签证',
									APPLY_EXPIRED => '申请过期无效',
									VISA_EXPIRED => '签证过期无效',
									POSITIVE_OVERFLOW => '正溢出异常'
									);
	
	$config['apply_status_code'] = array(
									'drop' => APPLY_TRASHED,
									'half' => APPLY_NOTFINISHED,
									'wait' => APPLY_WAITING,
									'fail' => APPLY_NOTPASSED,
									'pass' => APPLY_PASSED,
									'paid' => APPLY_PAID,
									'oops' => APPLY_REJECTED,
									'visa' => APPLY_ACCEPTED,
									'lost' => APPLY_EXPIRED,
									'best' => VISA_EXPIRED
									);
?>