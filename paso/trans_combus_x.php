<?php
session_start();
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
$paso = $_POST['paso_excel_g2'];
$paso1 = explode("#",$paso);
require_once dirname(__FILE__) . './clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->
getProperties()
	->setCreator("Cx Computers")
	->setLastModifiedBy("Cx Computers")
	->setTitle("Planilla Cargue Combustible")
	->setSubject("Consulta Web");
if ($empadrona == "F")
{
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
	$objPHPExcel->getActiveSheet()->getStyle('A1:F4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFill()->getStartColor()->setARGB('CCCCCC');
	$objPHPExcel->getActiveSheet()->getStyle("A5:F5")->getFont()->setBold(true);
	$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'MINISTERIO DE DEFENSA NACIONAL')
		->setCellValue('A2', 'COMANDO GENERAL DE LAS FUERZAS MILITARES')
		->setCellValue('A3', '')
		->setCellValue('A4', 'CUADRO DEMOSTRATIVO DE LA PARTIDA POR VEHÍCULO DEL '.$nombre.', CORRESPONDIENTE AL MES DE '.$mes.' DE '.$ano.' '.$tp_combus.' EN GALONES.')
		->setCellValue('A5', 'PLACA CIVIL')
		->setCellValue('B5', 'CENTROS DE COSTO')
		->setCellValue('C5', 'CANTIDAD')
		->setCellValue('D5', 'FECHA')
		->setCellValue('E5', 'KILOMETRAJE')
		->setCellValue('F5', 'VALOR');
}
else
{
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');
	$objPHPExcel->getActiveSheet()->getStyle('A1:G4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->getStartColor()->setARGB('CCCCCC');
	$objPHPExcel->getActiveSheet()->getStyle("A5:G5")->getFont()->setBold(true);
	$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'MINISTERIO DE DEFENSA NACIONAL')
		->setCellValue('A2', 'COMANDO GENERAL DE LAS FUERZAS MILITARES')
		->setCellValue('A3', '')
		->setCellValue('A4', 'CUADRO DEMOSTRATIVO DE LA PARTIDA POR VEHÍCULO DEL '.$nombre.', CORRESPONDIENTE AL MES DE '.$mes.' DE '.$ano.' GASOLINA EN GALONES.')
		->setCellValue('A5', 'PLACA CIVIL')
		->setCellValue('B5', 'CENTROS DE COSTO')
		->setCellValue('C5', 'CANTIDAD')
		->setCellValue('D5', 'FECHA')
		->setCellValue('E5', 'KILOMETRAJE')
		->setCellValue('F5', 'VALOR')
		->setCellValue('G5', 'BONOS');	
}
$j = 6;
$m = count($paso1);
if ($empadrona == "F")
{
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
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':F'.$j)->applyFromArray($BStyle);
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j, $v1)
			->setCellValue('B'.$j, $v2)
			->setCellValue('C'.$j, $v3)
			->setCellValue('D'.$j, $v4)
			->setCellValue('E'.$j, $v5)
			->setCellValue('F'.$j, $v6);
		$j++;
	}
}
else
{
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
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':G'.$j)->applyFromArray($BStyle);
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j, $v1)
			->setCellValue('B'.$j, $v2)
			->setCellValue('C'.$j, $v3)
			->setCellValue('D'.$j, $v4)
			->setCellValue('E'.$j, $v5)
			->setCellValue('F'.$j, $v6)
			->setCellValue('G'.$j, $v7);
		$j++;
	}	
}
$objPHPExcel->getActiveSheet()->setTitle('Planilla Cargue Combustible');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="CargueCombustible.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>