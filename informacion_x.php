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
    ->setTitle("Relación Pagos de Información")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Radicado')
    ->setCellValue('B1', 'Fecha Acta')
    ->setCellValue('C1', 'Unidad Autoriza Pago')
    ->setCellValue('D1', 'Unidad Realiza Pago')
    ->setCellValue('E1', 'Concepto del Gasto')
    ->setCellValue('F1', 'Pagos')
    ->setCellValue('G1', 'Beneficiario')
    ->setCellValue('H1', 'Valor Acta')
    ->setCellValue('I1', 'Número')
    ->setCellValue('J1', 'Plan / Solicitud');
$j=2;
$m = count($paso1);
for ($i=0;$i<count($paso1)-1;++$i)
{
    $k = $i+1;
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
        ->setCellValue('B'.$j, $v2)
        ->setCellValue('C'.$j, $v11)
        ->setCellValue('D'.$j, $v4)
        ->setCellValue('E'.$j, 'PAGO DE INFORMACION')
        ->setCellValue('F'.$j, $v5)
        ->setCellValue('G'.$j, $v6." ")
        ->setCellValue('H'.$j, $v8)
        ->setCellValue('I'.$j, $v10)
        ->setCellValue('J'.$j, $v9);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Relación Pagos de Información');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="RelacionPagos.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>