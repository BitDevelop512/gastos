<?php
session_start();
$unidad = $_POST['unidad_excel'];
$dias = $_POST['dias_excel'];
$galones = $_POST['galones_excel'];
$tanqueo = $_POST['tanqueo_excel'];
$tanqueo = number_format($tanqueo, 2);
$promedio = $_POST['promedio_excel'];
$promedio = number_format($promedio, 2);
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
	$tp_combus1 = "GASOLINA CORRIENTE";
}
else
{
	$tp_combus = "ACPM / DIESEL";
	$tp_combus1 = $tp_combus;
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
	->setTitle("Planilla Anexo T")
	->setSubject("Consulta Web");
$gdImage = imagecreatefromjpeg('dist/img/escudo.jpg');
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setHeight(80);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(35);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:A4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:G1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:G2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:G3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:G4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:AE1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:AE2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H3:AE3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:AE4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:AI5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:AI6');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:AI7');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A8:AI8');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A9:AI9');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A10:AI10');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AF1:AI1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AF2:AI2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AF3:AI3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AF4:AI4');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AF1:AI1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AF2:AI2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AF3:AI3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AF4:AI4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H1:AE4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A6:AI6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A8:AI8')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:AI9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A6:AI6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A8:AI8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A9:AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A11:AI11')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A11:AI11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H2:AE2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$BStyle1 = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('B1:G4')->applyFromArray($BStyle1);
$objPHPExcel->getActiveSheet()->getStyle('H1:AE4')->applyFromArray($BStyle1);
$objPHPExcel->getActiveSheet()->getStyle('A5:AI10')->applyFromArray($BStyle1);
$objPHPExcel->getActiveSheet()->getStyle('AF1:AI1')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('AF2:AI2')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('AF3:AI3')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('AF4:AI4')->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle('A11:AI11')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('B1', 'MINISTERIO DE DEFENSA NACIONAL')
	->setCellValue('B2', 'COMANDO GENERAL DE LAS FUERZAS MILITARES')
	->setCellValue('B3', 'EJERCITO NACIONAL')
	->setCellValue('B4', 'COMANDO LOGÍSTICO')
	->setCellValue('H2', 'CUADRO DEMOSTRATIVO DE CONSUMO DE COMBUSTIBLE DIARIO')
	->setCellValue('A6', 'BATALLÓN '.$nombre)
	->setCellValue('A8', 'CUADRO DEMOSTRATIVO CONSUMO DE COMBUSTIBLE DIARIO POR VEHÍCULO CORRESPONDIENTE AL PRESUPUESTO MENSUAL ASIGNADO CORRESPONDIENTE AL MES '.$mes.' DE '.$ano)
	->setCellValue('A9', 'TIPO DE COMBUSTIBLE '.$tp_combus1)
	->setCellValue('AF1', 'Pág: 1 de 1')
	->setCellValue('AF2', 'Código: FO-JEMGF-COLOG-1777')
	->setCellValue('AF3', 'Versión: 0')
	->setCellValue('AF4', 'Fecha de emisión: 2022-09-14')
	->setCellValue('A11', 'PLACA CIVIL')
	->setCellValue('B11', 'CENTROS DE COSTO')
	->setCellValue('C11', '1')
	->setCellValue('D11', '2')
	->setCellValue('E11', '3')
	->setCellValue('F11', '4')
	->setCellValue('G11', '5')
	->setCellValue('H11', '6')
	->setCellValue('I11', '7')
	->setCellValue('J11', '8')
	->setCellValue('K11', '9')
	->setCellValue('L11', '10')
	->setCellValue('M11', '11')
	->setCellValue('N11', '12')
	->setCellValue('O11', '13')
	->setCellValue('P11', '14')
	->setCellValue('Q11', '15')
	->setCellValue('R11', '16')
	->setCellValue('S11', '17')
	->setCellValue('T11', '18')
	->setCellValue('U11', '19')
	->setCellValue('V11', '20')
	->setCellValue('W11', '21')
	->setCellValue('X11', '22')
	->setCellValue('Y11', '23')
	->setCellValue('Z11', '24')
	->setCellValue('AA11', '25')
	->setCellValue('AB11', '26')
	->setCellValue('AC11', '27')
	->setCellValue('AD11', '28')
	->setCellValue('AE11', '29')
	->setCellValue('AF11', '30')
	->setCellValue('AG11', '31')
	->setCellValue('AH11', 'TOTAL CONSUMO EN EL MES')
	->setCellValue('AI11', 'TOTAL KM RECORRIDOS EN EL MES');
$j = 12;
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
	$v28 = $paso2[27];
	$v29 = $paso2[28];
	$v30 = $paso2[29];
	$v31 = $paso2[30];
	$v32 = $paso2[31];
	$v33 = $paso2[32];
	$v34 = $paso2[33];
	$v35 = $paso2[34];
	if ($v34 == "0")
	{
		$v35 = "0";
	}
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':AI'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j, $v1)
		->setCellValue('B'.$j, $v2)
		->setCellValue('C'.$j, $v3)
		->setCellValue('D'.$j, $v4)
		->setCellValue('E'.$j, $v5)
		->setCellValue('F'.$j, $v6)
		->setCellValue('G'.$j, $v7)
		->setCellValue('H'.$j, $v8)
		->setCellValue('I'.$j, $v9)
		->setCellValue('J'.$j, $v10)
		->setCellValue('K'.$j, $v11)
		->setCellValue('L'.$j, $v12)
		->setCellValue('M'.$j, $v13)
		->setCellValue('N'.$j, $v14)
		->setCellValue('O'.$j, $v15)
		->setCellValue('P'.$j, $v16)
		->setCellValue('Q'.$j, $v17)
		->setCellValue('R'.$j, $v18)
		->setCellValue('S'.$j, $v19)
		->setCellValue('T'.$j, $v20)
		->setCellValue('U'.$j, $v21)
		->setCellValue('V'.$j, $v22)
		->setCellValue('W'.$j, $v23)
		->setCellValue('X'.$j, $v24)
		->setCellValue('Y'.$j, $v25)
		->setCellValue('Z'.$j, $v26)
		->setCellValue('AA'.$j, $v27)
		->setCellValue('AB'.$j, $v28)
		->setCellValue('AC'.$j, $v29)
		->setCellValue('AD'.$j, $v30)
		->setCellValue('AE'.$j, $v31)
		->setCellValue('AF'.$j, $v32)
		->setCellValue('AG'.$j, $v33)
		->setCellValue('AH'.$j, $v34)
		->setCellValue('AI'.$j, $v35);
	$j++;
}
$k = $j+1;
$k = $k-2;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$k.':B'.$k);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':AG'.$k)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':B'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Balance
$k = $k+2;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$k.':AI'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$k, 'BALANCE GENERAL CORRESPONDIENTE AL MES DE '.$mes.' DE '.$ano.' '.$tp_combus);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':AI'.$k)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':AI'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$k = $k+2;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$k.':D'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$k, 'VALOR PROMEDIO GALON '.$tp_combus);
$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':D'.$k)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$k.':I'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, "$     ".$promedio);
$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$k = $k+2;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$k.':D'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$k, 'GALONES CONSUMIDOS');
$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':D'.$k)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$k.':I'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, $galones);
$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$k = $k+2;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$k.':D'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$k, 'TOTAL');
$objPHPExcel->getActiveSheet()->getStyle('B'.$k.':D'.$k)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$k.':I'.$k);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, "$     ".$tanqueo);
$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

switch ($dias)
{
	case '28':
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('AE10', '')
			->setCellValue('AF10', '')
			->setCellValue('AG10', '');
		break;
	case '29':
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('AF10', '')
			->setCellValue('AG10', '');
		break;
	case '30':
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('AG10', '');
		break;
	default:
		break;
}
$objPHPExcel->getActiveSheet()->setTitle('Planilla Anexo T');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="AnexoT.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 13/06/2024 - Ajuste consumo del mes en 0
// 10/09/2024 - Ajuste inclusion nuevo encabezado
// 19/02/2025 - Ajuste titulo por inspeccion
?>