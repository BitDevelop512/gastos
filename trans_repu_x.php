<?php
session_start();
$paso = $_POST['paso_excel'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
	->setCreator("Cx Computers")
	->setLastModifiedBy("Cx Computers")
	->setTitle("Repuestos")
	->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle("A2:D1")->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'CÓDIGO')
	->setCellValue('B1', 'NOMBRE')
	->setCellValue('C1', 'MEDIDA')
	->setCellValue('D1', 'TIPO');
$j = 2;
$m = count($paso1);
for ($i=0;$i<count($paso1)-1;++$i)
{
	$k = $i+1;
	$variables = $paso1[$i];
	$paso2 = explode("|",$variables);
	$v1 = $paso2[0];
	$v2 = $paso2[1];
	$v3 = $paso2[2];
	switch ($v3)
	{
		case '1':
			$n3 = "UNIDAD";
			break;
		case '2':
			$n3 = "JUEGO";
			break;
		case '3':
			$n3 = "COPAS";
			break;
		default:
			$n3 = "";
			break;
	}
	$v4 = $paso2[3];
	$v5 = $paso2[4];
	switch ($v5)
	{
		case '1':
			$n5 = "AUTOMÓVILES";
			break;
		case '2':
			$n5 = "MOTOCICLETAS";
			break;
		default:
			$n5 = "";
			break;
	}
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':D'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j, $v1)
		->setCellValue('B'.$j, $v2)
		->setCellValue('C'.$j, $n3)
		->setCellValue('D'.$j, $n5);
	$j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Repuestos');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Repuestos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 09/02/2024 - Exportacion de repuestos a xzcel
?>