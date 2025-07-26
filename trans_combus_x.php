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
if (($empadrona == "F") or ($empadrona == "G"))
{
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(35);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:J2');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:J4');
	$objPHPExcel->getActiveSheet()->getStyle('A1:J4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:J5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A5:J5')->getFill()->getStartColor()->setARGB('CCCCCC');
	$objPHPExcel->getActiveSheet()->getStyle("A5:J5")->getFont()->setBold(true);
	$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	$objPHPExcel->getActiveSheet()->getStyle('A5:J5')->applyFromArray($BStyle);
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
		->setCellValue('F5', 'VALOR')
		->setCellValue('G5', 'PLAN /SOLICITUD')
		->setCellValue('H5', 'MISION')
		->setCellValue('I5', 'TIPO')
		->setCellValue('J5', 'SOPORTE');
}
else
{
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:I3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:I4');
	$objPHPExcel->getActiveSheet()->getStyle('A1:I4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->getFill()->getStartColor()->setARGB('CCCCCC');
	$objPHPExcel->getActiveSheet()->getStyle("A5:I5")->getFont()->setBold(true);
	$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray($BStyle);
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
		->setCellValue('G5', 'BONOS')
		->setCellValue('H5', 'UNIDAD')
		->setCellValue('I5', 'CONTRATO');
}
$j = 6;
$m = count($paso1);
if (($empadrona == "F") or ($empadrona == "G"))
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
		$v8 = $paso2[7];
		$v9 = $paso2[8];
		$v10 = $paso2[9];
		$v11 = $paso2[10];
		if ($v10 == "1")
		{
			$v10_1 = "PARTIDA MENSUAL DE COMBUSTIBLE";
		}
		else
		{
			$v10_1 = "SUMINISTRO DE COMBUSTIBLE ADICIONAL";	
		}
		if ($v11 == "1")
		{
			$v11_1 = "CON SOPORTE";
		}
		else
		{
			$v11_1 = "SIN SOPORTE";	
		}
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':F'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':J'.$j)->applyFromArray($BStyle);
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j, $v1)
			->setCellValue('B'.$j, $v2)
			->setCellValue('C'.$j, $v3)
			->setCellValue('D'.$j, $v4)
			->setCellValue('E'.$j, $v5)
			->setCellValue('F'.$j, $v6)
			->setCellValue('G'.$j, $v8)
			->setCellValue('H'.$j, $v9)
			->setCellValue('I'.$j, $v10_1)
			->setCellValue('J'.$j, $v11_1);
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
		$v8 = $paso2[7];
		$v9 = $paso2[8];
		$objPHPExcel->getActiveSheet()->getStyle('C'.$j.':D'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$j.':I'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':I'.$j)->applyFromArray($BStyle);
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$j, $v1)
			->setCellValue('B'.$j, $v2)
			->setCellValue('C'.$j, $v3)
			->setCellValue('D'.$j, $v4)
			->setCellValue('E'.$j, $v5)
			->setCellValue('F'.$j, $v6)
			->setCellValue('G'.$j, $v7)
			->setCellValue('H'.$j, $v8)
			->setCellValue('I'.$j, $v9);
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
// 11/02/2024 - Ajuste inclusion nuevos campos reporte excel
// 07/01/2025 - Ajuste inclusion unidad en excel contratos
// 03/02/2025 - Ajuste inclusion campo contrato excel
?>