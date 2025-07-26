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
    ->setTitle("Consulta PQR")
    ->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(100);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(100);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'No.')
    ->setCellValue('B1', 'Año')
    ->setCellValue('C1', 'Fecha')        
    ->setCellValue('D1', 'Usuario')
    ->setCellValue('E1', 'Unidad')
    ->setCellValue('F1', 'Tipo')
    ->setCellValue('G1', 'Módulo')
    ->setCellValue('H1', 'Submódulo')
    ->setCellValue('I1', 'Descripción')
    ->setCellValue('J1', 'Respuesta')
    ->setCellValue('K1', 'Estado');
$j=2;
$m = count($paso1);
for ($i=0;$i<count($paso1)-1;++$i)
{
    $k = $i;
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
    $v10 = $paso2[9];
    $v11 = $paso2[10];
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('B'.$j, $v4)
        ->setCellValue('C'.$j, $v2)
        ->setCellValue('D'.$j, $v3)
        ->setCellValue('E'.$j, $v6)
        ->setCellValue('F'.$j, $v7)
        ->setCellValue('G'.$j, $v8)
        ->setCellValue('H'.$j, $v9)
        ->setCellValue('I'.$j, $v10)
        ->setCellValue('J'.$j, $v11)
        ->setCellValue('K'.$j, $v5);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Consulta PQR');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ConsultaPQR.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>