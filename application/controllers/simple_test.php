<?php
	date_default_timezone_set('Asia/HongKong');
	require_once '../Classes/PHPExcel.php';
	
	$excel = new PHPExcel();
	
	// Set Head Titles
	$excel	->setActiveSheetIndex(0)
			->setCellValue('A1', '')
			->setCellValue('B1', '申请流水号')
			->setCellValue('C1', '申请人中文/英文姓名')
			->setCellValue('D1', '申请时间')
			->setCellValue('E1', '审核时间')
			->setCellValue('F1', '缴费时间')
			->setCellValue('G1', '签证时间')
			->setCellValue('H1', '签证费用');
	
	// Set Cell Content
	for ($i = 0; $i < 10; $i ++) {
		$cur_column = $i + 2;
		$excel	->setActiveSheetIndex(0)
				->setCellValue('A'.$cur_column, $i + 1)
				->setCellValue('B'.$cur_column, '申请流水号')
				->setCellValue('C'.$cur_column, '申请人中文/英文姓名')
				->setCellValue('D'.$cur_column, '申请时间')
				->setCellValue('E'.$cur_column, '审核时间')
				->setCellValue('F'.$cur_column, '缴费时间')
				->setCellValue('G'.$cur_column, '签证时间')
				->setCellValue('H'.$cur_column, '签证费用');
	}
	
	$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
	$excel->getActiveSheet()->setTitle('Simple');
	$excel->setActiveSheetIndex(0);
	
	$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	$objWriter->save('text_simple.xlsx');
?>