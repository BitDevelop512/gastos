<?php
session_start();
$paso = $_POST['paso_excel1'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
    ->setCreator("Cx Computers")
    ->setLastModifiedBy("Cx Computers")
    ->setTitle("Consulta de Misiones")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'No. Plan / Solicitud')
    ->setCellValue('B1', 'Fecha Plan / Solicitud')
    ->setCellValue('C1', 'Usuario')
    ->setCellValue('D1', 'Código Unidad')
    ->setCellValue('E1', 'Unidad')
    ->setCellValue('F1', 'Periodo')
    ->setCellValue('G1', 'Año')
    ->setCellValue('H1', 'Misión')
    ->setCellValue('I1', 'No. Misión')
    ->setCellValue('J1', 'Valor Solicitado')
    ->setCellValue('K1', 'Valor Aprobado')
    ->setCellValue('L1', 'Valor Ejecutado')
    ->setCellValue('M1', 'Area')
    ->setCellValue('N1', 'Fecha Inicial')
    ->setCellValue('O1', 'Fecha Final');
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
    $v12 = $paso2[11];
    $v13 = $paso2[12];
    $v14 = $paso2[13];
    $v15 = $paso2[14];
    $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':O'.$j)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$j.':L'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('B'.$j, $v2)
        ->setCellValue('C'.$j, $v3)
        ->setCellValue('D'.$j, $v4)
        ->setCellValue('E'.$j, $v7)
        ->setCellValue('F'.$j, $v5)
        ->setCellValue('G'.$j, $v6)
        ->setCellValue('H'.$j, $v8)
        ->setCellValue('I'.$j, $v9)
        ->setCellValue('J'.$j, $v10)
        ->setCellValue('K'.$j, $v11)
        ->setCellValue('L'.$j, $v12)
        ->setCellValue('M'.$j, $v13)
        ->setCellValue('N'.$j, $v14)
        ->setCellValue('O'.$j, $v15);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Misiones');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Misiones.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 30/07/2024 - Ajuste inclusion columna valor ejecutado
// 27/11/2024 - Ajuste inclusion columna area y lapso de fechas
?>