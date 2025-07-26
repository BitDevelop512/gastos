<?php
session_start();
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 3600);
$paso = $_POST['paso_excel'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
    ->setCreator("Cx Computers")
    ->setLastModifiedBy("Cx Computers")
    ->setTitle("Informe de Verificación GGRR")
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
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle("A1:M1")->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Informe')
    ->setCellValue('B1', 'Fecha')
    ->setCellValue('C1', 'Lugar')        
    ->setCellValue('D1', 'Unidad Centralizadora')
    ->setCellValue('E1', 'Fecha Inicio')
    ->setCellValue('F1', 'Fecha Termino')
    ->setCellValue('G1', 'Periodo de Ejecución')
    ->setCellValue('H1', 'No.')
    ->setCellValue('I1', 'Unidad')
    ->setCellValue('J1', 'Descripción de la Observación')
    ->setCellValue('K1', 'Fecha')
    ->setCellValue('L1', 'Tipo de Documento')
    ->setCellValue('M1', 'Plan de Verificación');
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
    $num_v8 = explode("&",$v8);
    $tot_v8 = count($num_v8)-2;
    $v9 = $paso2[8];
    $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':M'.$j)->applyFromArray($BStyle);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('B'.$j, $v2)
        ->setCellValue('C'.$j, $v3)
        ->setCellValue('D'.$j, $v4)
        ->setCellValue('E'.$j, $v5)
        ->setCellValue('F'.$j, $v6)
        ->setCellValue('G'.$j, $v7)
        ->setCellValue('H'.$j, '')
        ->setCellValue('I'.$j, '')
        ->setCellValue('J'.$j, '')
        ->setCellValue('K'.$j, '')
        ->setCellValue('L'.$j, '')
        ->setCellValue('M'.$j, $v9);
    for ($k=0;$k<$tot_v8;++$k)
    {
        $l = $j+$k;
        $paso3 = $num_v8[$k];
        $num_paso3 = explode("^",$paso3);
        $tot_paso3 = count($num_paso3);
        for ($m=0;$m<$tot_paso3;++$m)
        {
            $paso4 = $num_paso3[0];
            $paso5 = $num_paso3[1];
            $paso6 = $num_paso3[2];
            $paso7 = $num_paso3[3];
            $paso8 = $num_paso3[4];
        }
        $objPHPExcel->getActiveSheet()->getStyle('A'.$l.':M'.$l)->applyFromArray($BStyle);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H'.$l, $paso4)
            ->setCellValue('I'.$l, $paso5)
            ->setCellValue('J'.$l, $paso6)
            ->setCellValue('K'.$l, $paso7)
            ->setCellValue('L'.$l, $paso8);
    }
    $j = $j+$tot_v8;
}
$objPHPExcel->getActiveSheet()->setTitle('Informe de Verificación GGRR');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="InformeVerificacion.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>