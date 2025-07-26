<?php
session_start();
$paso = $_POST['paso_excel2'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
    ->setCreator("Cx Computers")
    ->setLastModifiedBy("Cx Computers")
    ->setTitle("Consulta de Conceptos del Gasto")
    ->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(100);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(100);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'No. Plan / Solicitud')
    ->setCellValue('B1', 'Fecha Plan / Solicitud')
    ->setCellValue('C1', 'Placa')
    ->setCellValue('D1', 'Clase')
    
    ->setCellValue('E1', 'Cantidad')
    ->setCellValue('F1', 'Detalle')
    ->setCellValue('G1', 'Código Unidad')
    ->setCellValue('H1', 'Unidad')
    ->setCellValue('I1', 'Usuario')
    ->setCellValue('J1', 'Periodo')
    ->setCellValue('K1', 'Kilometraje')
    ->setCellValue('L1', 'Consumo')
    ->setCellValue('M1', 'Plan / Solicitud')
    ->setCellValue('N1', 'Ordop')
    ->setCellValue('O1', 'Misión')
    ->setCellValue('P1', 'No. Misión')
    ->setCellValue('Q1', 'Gasto')
    ->setCellValue('R1', 'Nombre Gasto')
    ->setCellValue('S1', 'Tipo Combustible')
    ->setCellValue('T1', 'Tipo Solicitud')
    ->setCellValue('U1', 'Valor Solicitado')
    ->setCellValue('V1', 'Valor Ejecutado')
    ->setCellValue('W1', 'Diferencia');
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
    $v4 = floatval($v4);
    $v5 = $paso2[4];
    $v6 = $paso2[5];
    $v7 = $paso2[6];
    $v8 = $paso2[7];
    $v9 = $paso2[8];
    $v10 = $paso2[9];
    $v11 = $paso2[10];
    $v12 = $paso2[11];
    $v12 = str_replace("¥", "\n", $v12);
    $v13 = $paso2[12];
    $v14 = $paso2[13];
    $v15 = $paso2[14];
    $v16 = $paso2[15];
    $v17 = $paso2[16];
    $v18 = $paso2[17];
    $v19 = $paso2[18];
    $v20 = $paso2[19];
    $v21 = $paso2[20];
    $v22 = $paso2[21];
    $v23 = $paso2[22];
    $v23 = floatval($v23);
    $v24 = $v4-$v23;
    $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':W'.$j)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle('U'.$j.':W'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$j.':K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$j.':Q'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('B'.$j, $v8)
        ->setCellValue('C'.$j, $v2)
        ->setCellValue('D'.$j, $v3)

        ->setCellValue('E'.$j, $v21)
        ->setCellValue('F'.$j, $v5)
        ->setCellValue('G'.$j, $v17)
        ->setCellValue('H'.$j, $v6)
        ->setCellValue('I'.$j, $v7)
        ->setCellValue('J'.$j, $v9)
        ->setCellValue('K'.$j, $v10)
        ->setCellValue('L'.$j, $v18)
        ->setCellValue('M'.$j, $v14)
        ->setCellValue('N'.$j, $v11)
        ->setCellValue('O'.$j, $v12)
        ->setCellValue('P'.$j, $v13)
        ->setCellValue('Q'.$j, $v16)
        ->setCellValue('R'.$j, $v19)
        ->setCellValue('S'.$j, $v20)
        ->setCellValue('T'.$j, $v22)
        ->setCellValue('U'.$j, $v4)
        ->setCellValue('V'.$j, $v23)
        ->setCellValue('W'.$j, $v24);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Conceptos del Gasto');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ConceptosGastoVSEje.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 30/07/2024 - Ajuste columna ejecutado y diferencia
?>