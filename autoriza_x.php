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
    ->setTitle("Autorización Recurso Adicional")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'No.')
    ->setCellValue('B1', 'Fecha')
    ->setCellValue('C1', 'Numero')        
    ->setCellValue('D1', 'Unidad Centralizadora')
    ->setCellValue('E1', 'Brigada')
    ->setCellValue('F1', 'Unidad Táctica')
    ->setCellValue('G1', 'Concepto del Gasto')
    ->setCellValue('H1', 'ORDOP Misión')
    ->setCellValue('I1', 'Fuente')
    ->setCellValue('J1', 'Factor de Amenaza')
    ->setCellValue('K1', 'Estructura')
    ->setCellValue('L1', 'Fecha Sumnistro')
    ->setCellValue('M1', 'Difusión')
    ->setCellValue('N1', 'Condujo al Resultado')
    ->setCellValue('O1', 'Nombre Operación')
    ->setCellValue('P1', 'Radiograma')
    ->setCellValue('Q1', 'Fec. Radiograma')
    ->setCellValue('R1', 'Valor Solicitado')
    ->setCellValue('S1', 'Valor Aprobado')
    ->setCellValue('T1', 'Estado')
    ->setCellValue('U1', 'Observación')
    ->setCellValue('V1', 'Usuario')
    ->setCellValue('W1', 'Fecha')
    ->setCellValue('X1', 'Recursos')
    ->setCellValue('Y1', 'Omave - Omina - Omire')
    ->setCellValue('Z1', 'Número de Acta CEDE2')
    ->setCellValue('AA1', 'Fecha de Acta CEDE2')
    ->setCellValue('AB1', 'CRP');
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
    $v7 = $paso2[6]." ";
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
    $v18 = $paso2[17];
    $v19 = $paso2[18];
    $v20 = $paso2[19];
    $v21 = $paso2[20];
    $v22 = $paso2[21];
    $v23 = $paso2[22];
    $v24 = $paso2[23];
    $v25 = $paso2[24];
    $v26 = $paso2[25];
    $v27 = $paso2[26];
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
        ->setCellValue('K'.$j, $v17)
        ->setCellValue('L'.$j, $v10)
        ->setCellValue('M'.$j, $v11)
        ->setCellValue('N'.$j, $v12)
        ->setCellValue('O'.$j, $v13)
        ->setCellValue('P'.$j, $v18)
        ->setCellValue('Q'.$j, $v19)
        ->setCellValue('R'.$j, $v14)
        ->setCellValue('S'.$j, $v15)
        ->setCellValue('T'.$j, $v16)
        ->setCellValue('U'.$j, $v20)
        ->setCellValue('V'.$j, $v21)
        ->setCellValue('W'.$j, $v22)
        ->setCellValue('X'.$j, $v23)
        ->setCellValue('Y'.$j, $v24)
        ->setCellValue('Z'.$j, $v25)
        ->setCellValue('AA'.$j, $v26)
        ->setCellValue('AB'.$j, $v27);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Autorización Recurso Adicional');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="AutorizacionRecurso.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>