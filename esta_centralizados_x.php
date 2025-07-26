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
    ->setTitle("Planes Centralizados")
    ->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Unidad')
    ->setCellValue('B1', 'Periodo')
    ->setCellValue('C1', 'Número')
    ->setCellValue('D1', 'Fecha')
    ->setCellValue('E1', 'Gastos en Actividades')
    ->setCellValue('F1', 'Pago de Informaciones')
    ->setCellValue('G1', 'Total');
$j=2;
for ($i=0;$i<count($paso1)-1;$i++)
{
    $k = $i;
    $variables = $paso1[$i];
    $paso2 = explode("|",$variables);
    $v1 = $paso2[0];
    $v2 = $paso2[1];
    $v3 = $paso2[2];
    $v4 = $paso2[3];
    $v5 = $paso2[4];
    $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $v1)
        ->setCellValue('E'.$j, $v2)
        ->setCellValue('F'.$j, $v3)
        ->setCellValue('G'.$j, $v4);
    $paso3 = explode("»",$v5);
    $y = count($paso3)-2;
    for ($x=0;$x<count($paso3)-1;$x++)
    {
        $variables1 = $paso3[$x];
        $paso4 = explode("-",$variables1);
        $v6 = $paso4[0];
        $v7 = $paso4[1];
        $v8 = $paso4[2];
        $objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$j, $v6)
            ->setCellValue('C'.$j, $v7)
            ->setCellValue('D'.$j, $v8);
        if ($x == $y)
        {
        }
        else
        {
            $j++;
        }
    }
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Planes Centralizados');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Estadistica3.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>