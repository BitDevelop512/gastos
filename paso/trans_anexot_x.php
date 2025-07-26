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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(35);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:AI1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:AI2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:AI3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:AI4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:AI5');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:AI6');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A9:AI9');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AB7:AI7');
$objPHPExcel->getActiveSheet()->getStyle('A1:AI6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AI6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('AB7:AI7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:AI9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:AI9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A10:AI10')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A10:AI10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A10:AI10')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'MINISTERIO DE DEFENSA NACIONAL')
	->setCellValue('A2', 'COMANDO GENERAL DE LAS FUERZAS MILITARES')
	->setCellValue('A3', 'EJERCITO NACIONAL')
	->setCellValue('A4', $nombre)
	->setCellValue('A5', $nombre1)
	->setCellValue('A6', 'ANEXO "T"')
	->setCellValue('AB7', $ciudad." ".$mes." DE ".$ano)
	->setCellValue('A9', $tp_combus1)
	->setCellValue('A10', 'PLACA CIVIL')
	->setCellValue('B10', 'CENTROS DE COSTO')
	->setCellValue('C10', '1')
	->setCellValue('D10', '2')
	->setCellValue('E10', '3')
	->setCellValue('F10', '4')
	->setCellValue('G10', '5')
	->setCellValue('H10', '6')
	->setCellValue('I10', '7')
	->setCellValue('J10', '8')
	->setCellValue('K10', '9')
	->setCellValue('L10', '10')
	->setCellValue('M10', '11')
	->setCellValue('N10', '12')
	->setCellValue('O10', '13')
	->setCellValue('P10', '14')
	->setCellValue('Q10', '15')
	->setCellValue('R10', '16')
	->setCellValue('S10', '17')
	->setCellValue('T10', '18')
	->setCellValue('U10', '19')
	->setCellValue('V10', '20')
	->setCellValue('W10', '21')
	->setCellValue('X10', '22')
	->setCellValue('Y10', '23')
	->setCellValue('Z10', '24')
	->setCellValue('AA10', '25')
	->setCellValue('AB10', '26')
	->setCellValue('AC10', '27')
	->setCellValue('AD10', '28')
	->setCellValue('AE10', '29')
	->setCellValue('AF10', '30')
	->setCellValue('AG10', '31')
	->setCellValue('AH10', 'TOTAL CONSUMO EN EL MES')
	->setCellValue('AI10', 'TOTAL KM RECORRIDOS EN EL MES');
$j = 11;
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
?>