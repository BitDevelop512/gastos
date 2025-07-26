<?php
session_start();
$paso = $_POST['paso_excel'];
$paso1 = explode("#",$paso);
$paso0 = $_POST['paso_reporte'];
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
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(100);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->applyFromArray($BStyle);
if ($paso0 == "1")
{
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'No. Plan / Solicitud')
        ->setCellValue('B1', 'Fecha Plan / Solicitud')
        ->setCellValue('C1', 'Placa')
        ->setCellValue('D1', 'Clase')
        ->setCellValue('E1', 'Valor')
        ->setCellValue('F1', 'Cantidad')
        ->setCellValue('G1', 'Detalle')
        ->setCellValue('H1', 'Código Unidad')
        ->setCellValue('I1', 'Unidad')
        ->setCellValue('J1', 'Usuario')
        ->setCellValue('K1', 'Periodo')
        ->setCellValue('L1', 'Kilometraje')
        ->setCellValue('M1', 'Consumo')
        ->setCellValue('N1', 'Plan / Solicitud')
        ->setCellValue('O1', 'Ordop')
        ->setCellValue('P1', 'Misión')
        ->setCellValue('Q1', 'No. Misión')
        ->setCellValue('R1', 'Gasto')
        ->setCellValue('S1', 'Nombre Gasto')
        ->setCellValue('T1', 'Tipo Combustible')
        ->setCellValue('U1', 'Tipo Solicitud');
}
if ($paso0 == "2")
{
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'No. Relación')
        ->setCellValue('B1', 'Fecha Relación')
        ->setCellValue('C1', 'Placa')
        ->setCellValue('D1', 'Clase')
        ->setCellValue('E1', 'Valor')
        ->setCellValue('F1', 'Cantidad')
        ->setCellValue('G1', 'Detalle')
        ->setCellValue('H1', 'Código Unidad')
        ->setCellValue('I1', 'Unidad')
        ->setCellValue('J1', 'Usuario')
        ->setCellValue('K1', 'Periodo')
        ->setCellValue('L1', 'Kilometraje')
        ->setCellValue('M1', 'Consumo')
        ->setCellValue('N1', 'Plan / Solicitud')
        ->setCellValue('O1', 'Ordop')
        ->setCellValue('P1', 'Misión')
        ->setCellValue('Q1', 'No. Misión')
        ->setCellValue('R1', 'Gasto')
        ->setCellValue('S1', 'Nombre Gasto')
        ->setCellValue('T1', 'Tipo Combustible')
        ->setCellValue('U1', 'Tipo Solicitud');
}
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
    if ($paso0 == "1")
    {
        $v12 = str_replace("¥", "\n", $v12);
    }
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
    $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':U'.$j)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$j.':E'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$j.':L'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('R'.$j.':R'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('B'.$j, $v8)
        ->setCellValue('C'.$j, $v2)
        ->setCellValue('D'.$j, $v3)
        ->setCellValue('E'.$j, $v4)
        ->setCellValue('F'.$j, $v21)
        ->setCellValue('G'.$j, $v5)
        ->setCellValue('H'.$j, $v17)
        ->setCellValue('I'.$j, $v6)
        ->setCellValue('J'.$j, $v7)
        ->setCellValue('K'.$j, $v9)
        ->setCellValue('L'.$j, $v10)
        ->setCellValue('M'.$j, $v18)
        ->setCellValue('N'.$j, $v14)
        ->setCellValue('O'.$j, $v11)
        ->setCellValue('P'.$j, $v12)
        ->setCellValue('Q'.$j, $v13)
        ->setCellValue('R'.$j, $v16)
        ->setCellValue('S'.$j, $v19)
        ->setCellValue('T'.$j, $v20)
        ->setCellValue('U'.$j, $v22);
    if ($paso0 == "1")
    {
        //$objPHPExcel->getActiveSheet()->getStyle('P'.$j)->getAlignment()->setWrapText(true);
    }
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Conceptos del Gasto');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ConceptosGasto.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 24/07/2024 - Ajuste inclusion columna tipo de solicitud
?>