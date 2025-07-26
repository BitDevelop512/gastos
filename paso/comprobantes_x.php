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
    ->setTitle("Consulta de Comprobantes")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'No.')
    ->setCellValue('B1', 'U.O.M')
    ->setCellValue('C1', 'BR')        
    ->setCellValue('D1', 'U.T')
    ->setCellValue('E1', 'Unidad / Dep Empleo Recurso')
    ->setCellValue('F1', 'Fecha')
    ->setCellValue('G1', 'Comprobante')
    ->setCellValue('H1', 'No.')
    ->setCellValue('I1', 'Valor Ingreso')
    ->setCellValue('J1', 'Valor Egreso')
    ->setCellValue('K1', 'Saldo')
    ->setCellValue('L1', 'Concepto del Gasto')
    ->setCellValue('M1', 'Soporte')
    ->setCellValue('N1', 'Recurso')
    ->setCellValue('O1', 'Origen')
    ->setCellValue('P1', 'Periodo')
    ->setCellValue('Q1', 'Unidad')
    ->setCellValue('R1', 'Cuenta');
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
    $v16 = $paso2[15];
    $v17 = $paso2[16];
    $objPHPExcel->getActiveSheet()
        ->getStyle('I:K')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $k)
        ->setCellValue('B'.$j, $v1)
        ->setCellValue('C'.$j, $v2)
        ->setCellValue('D'.$j, $v3)
        ->setCellValue('E'.$j, $v4)
        ->setCellValue('F'.$j, $v5)
        ->setCellValue('G'.$j, $v6)
        ->setCellValue('H'.$j, $v7)
        ->setCellValue('I'.$j, $v8)
        ->setCellValue('J'.$j, $v9)
        ->setCellValue('K'.$j, $v10)
        ->setCellValue('L'.$j, $v11)
        ->setCellValue('M'.$j, $v12)
        ->setCellValue('N'.$j, $v13)
        ->setCellValue('O'.$j, $v14)
        ->setCellValue('P'.$j, $v15)
        ->setCellValue('Q'.$j, $v16)
        ->setCellValue('R'.$j, $v17);
    if (trim($v7) == "SALDO ANTERIOR")
    {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', '');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', '');
    }
    if (trim($v7) == "TOTALES")
    {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$m, '');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$m.':R'.$m)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A'.$m.':R'.$m)->getFill()->getStartColor()->setARGB('CCCCCC');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$m.':R'.$m)->getFont()->setBold(true);
    }
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Detallado de Comprobantes');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DetalladoComprobantes.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>