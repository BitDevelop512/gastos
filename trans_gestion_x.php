<?php
session_start();
/*
$unidad = $_POST['unidad_excel'];
$empadrona = $_POST['dias_excel'];
$combustible = $_POST['combustible_excel'];
if ($unidad == "1")
{
	$nombre1 = "DIRECCION ADMINISTRATIVA DE INTELIGENCIA";
}
else
{
	$nombre1 = "";
}
if ($combustible == "1")
{
	$tp_combus = "GASOLINA";
}
else
{
	$tp_combus = "ACPM / DIESEL";
}
$mes = $_POST['mes_excel'];
$ano = $_POST['ano_excel'];
$ciudad = $_POST['ciu_excel'];
$nombre = $_POST['uni_excel'];
$gpaso = $_POST['paso_excel_g1'];
*/
$paso = $_POST['paso_excel_g2'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
	->setCreator("Cx Computers")
	->setLastModifiedBy("Cx Computers")
	->setTitle("Planilla Gestión Presupuesto")
	->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:L2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:L4');
$objPHPExcel->getActiveSheet()->getStyle("A1:L4")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A5:L5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A5:L5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A5:L5')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle("A5:L5")->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A5:L5')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A5:L5')->getAlignment()->setWrapText(true);
$salto = "\n";
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'MINISTERIO DE DEFENSA NACIONAL')
	->setCellValue('A2', 'COMANDO GENERAL DE LAS FUERZAS MILITARES')
	->setCellValue('A4', 'CUADRO DEMOSTRATIVO DE LA PARTIDA POR VEHÍCULO')
	->setCellValue('A5', 'UNIDAD'.$salto.'CENTRALIZADORA'.$salto)
	->setCellValue('B5', 'BRIGADA'.$salto.$salto)
	->setCellValue('C5', 'BATALLON'.$salto.$salto)
	->setCellValue('D5', 'PLACA'.$salto.$salto)
	->setCellValue('E5', 'TOTAL DE'.$salto.'COMBUSTIBLE'.$salto.'(VALOR)'.$salto)
	->setCellValue('F5', 'TOTAL GALONES'.$salto.'(CONSUMO)'.$salto.$salto)
	->setCellValue('G5', 'KILOMETRAJE INICIAL'.$salto.'(VIGENCIA)'.$salto.$salto)
	->setCellValue('H5', 'KILOMETRAJE FINAL'.$salto.'(VIGENCIA)'.$salto.$salto)
	->setCellValue('I5', 'KILOMETRAJE RECORRIDO'.$salto.'(INICIAL - FINAL)'.$salto)
	->setCellValue('J5', 'VALOR TOTAL MANTENIMIENTO'.$salto.'Y REPUESTOS'.$salto.'(VIGENCIA)')
	->setCellValue('K5', 'VALOR TOTAL'.$salto.'REVISIÓN'.$salto.'TECNOMENCANICA'.$salto.'(VIGENCIA)')
	->setCellValue('L5', 'VALOR TOTAL'.$salto.'LLANTAS'.$salto.'(VIGENCIA)'.$salto);
$j = 6;
$m = count($paso1);
for ($i=0;$i<count($paso1)-1;++$i)
{
	$k = $i+1;
	$variables = $paso1[$i];
	$paso2 = explode("^",$variables);
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
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':L'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':L'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j, $v1)
		->setCellValue('B'.$j, $v2)
		->setCellValue('C'.$j, $v4." - ".$v5)
		->setCellValue('D'.$j, $v6)
		->setCellValue('E'.$j, $v7)
		->setCellValue('F'.$j, $v8)
		->setCellValue('G'.$j, $v9)
		->setCellValue('H'.$j, $v10)
		->setCellValue('I'.$j, $v11)
		->setCellValue('J'.$j, $v12)
		->setCellValue('K'.$j, $v13)
		->setCellValue('L'.$j, $v14);
	$j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Planilla Gestion Presupuesto');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="GestionPresupuesto.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>