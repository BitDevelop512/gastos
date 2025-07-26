<?php
session_start();
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 3600);
$paso = $_POST['paso_excel1'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
    ->setCreator("Cx Computers")
    ->setLastModifiedBy("Cx Computers")
    ->setTitle("Consulta de CRP")
    ->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'CDP')
    ->setCellValue('B1', 'CRP')
    ->setCellValue('C1', 'Fecha')        
    ->setCellValue('D1', 'Valor')
    ->setCellValue('E1', 'Adiciones')
    ->setCellValue('F1', 'Reducciones')
    ->setCellValue('G1', 'Valor Disponible')
    ->setCellValue('H1', 'Saldo CRP')
    ->setCellValue('I1', 'Destinación');
$j=2;
for ($i=0;$i<count($paso1)-1;++$i)
{
    $variables = $paso1[$i];
    $paso2 = explode("|",$variables);
    $v1 = $paso2[0];
    $v2 = $paso2[1];
    $v3 = $paso2[2];
    $v4 = $paso2[3];
    $v5 = $paso2[4];
    $v6 = $paso2[5];
    $v7 = $paso2[6];
    $v8 = $paso2[7];
    $v9 = $paso2[8];
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('B'.$j, $v2)
        ->setCellValue('C'.$j, $v3)
        ->setCellValue('D'.$j, $v4)
        ->setCellValue('E'.$j, $v5)
        ->setCellValue('F'.$j, $v6)
        ->setCellValue('G'.$j, $v7)
        ->setCellValue('H'.$j, $v8)
        ->setCellValue('I'.$j, $v9);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Consulta de CRP');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ConsultaCRP.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>