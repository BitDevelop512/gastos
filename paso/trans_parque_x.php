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
	->setTitle("Parque Automotor")
	->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:AL1');
$objPHPExcel->getActiveSheet()->getStyle('A1:AL1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AL1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AL2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:AL2')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle("A2:AL2")->getFont()->setBold(true);
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$objPHPExcel->getActiveSheet()->getStyle('A1:AL2')->applyFromArray($BStyle);
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'PARQUE AUTOMOTOR')
	->setCellValue('A2', 'UNIDAD')
	->setCellValue('B2', 'COMPAÑIA')
	->setCellValue('C2', 'PLACA')
	->setCellValue('D2', 'CLASE')
	->setCellValue('E2', 'MARCA')
	->setCellValue('F2', 'LINEA')
	->setCellValue('G2', 'MODELO')
	->setCellValue('H2', 'ACTIVO')
	->setCellValue('I2', 'ESTADO')
	->setCellValue('J2', 'EMPADRONAMIENTO')
	->setCellValue('K2', 'NOMBRE ASEGURADORA')
	->setCellValue('L2', 'FECHA TODO RIESGO')
	->setCellValue('M2', 'SEGURO TODO RIESGO')
	->setCellValue('N2', 'ASEGURADORA SOAT')
	->setCellValue('O2', 'NUMERO SOAT')
	->setCellValue('P2', 'FECHA SOAT')
	->setCellValue('Q2', 'VENCIMIENTO SOAT')
	->setCellValue('R2', 'FECHA RTM')
	->setCellValue('S2', 'VENCIMIENTO RTM')
	->setCellValue('T2', 'INVENTARIO')
	->setCellValue('U2', 'FECHA MANTINIMIENTO')
	->setCellValue('V2', 'TIPO MANTENIMIENTO')
	->setCellValue('W2', 'DESCRIPCIÓN MANTENIMIENTO')
	->setCellValue('X2', 'CILINDRAJE')
	->setCellValue('Y2', 'CENTRO DE COSTO')
	->setCellValue('Z2', 'COLOR')
	->setCellValue('AA2', 'NÚMERO MOTOR')
	->setCellValue('AB2', 'NÚMERO CHASIS')
	->setCellValue('AC2', 'MATRICULA')
	->setCellValue('AD2', 'FECHA ALTA')
	->setCellValue('AE2', 'ORIGEN RECURSO')
	->setCellValue('AF2', 'NÚMERO EQUIPO')
	->setCellValue('AG2', 'CONSUMO')
	->setCellValue('AH2', 'KILOMETRAJE')
	->setCellValue('AI2', 'OBSERVACIONES')
	->setCellValue('AJ2', 'TIPO DE COMBUSTIBLE')
	->setCellValue('AK2', 'REINICIO ODOMETRO')
	->setCellValue('AL2', 'AUTORIZACIÓN');
$j = 3;
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
	$v11 = $paso2[10]." ";
	$v12 = $paso2[11];
	$v13 = $paso2[12];
	$v14 = $paso2[13];
	$v15 = $paso2[14];
    if (trim($v15) == "1900-01-01")
    {
        $v15 = "";
    }
	$v16 = $paso2[15];
	$v17 = $paso2[16];
	$v18 = $paso2[17]." ";
	$v19 = $paso2[18];
    if (trim($v19) == "1900-01-01")
    {
        $v19 = "";
    }
	$v20 = $paso2[19];
    if (trim($v20) == "1900-01-01")
    {
        $v20 = "";
    }
	$v21 = $paso2[20];
    if (trim($v21) == "1900-01-01")
    {
        $v21 = "";
    }
	$v22 = $paso2[21];
	$v23 = $paso2[22];
	$v24 = $paso2[23]." ";
	$v25 = $paso2[24]." ";
	$v26 = $paso2[25]." ";
	$v27 = $paso2[26]." ";
	$v28 = $paso2[27]." ";
	$v29 = $paso2[28]." ";
	$v30 = $paso2[29];
    if (trim($v30) == "1900-01-01")
    {
        $v30 = "";
    }
    $v31 = $paso2[30]." ";
	$v32 = $paso2[31]." ";
	$v33 = $paso2[32]." ";
	$v34 = $paso2[33]." ";
	$v35 = $paso2[34];
	$v36 = $paso2[35];
	$v37 = $paso2[36];
	$v38 = $paso2[37];
	if ($v38 == "0")
	{
		$v38 = "NO";
	}
	else
	{
		$v38 = "SI";
	}
	$v39 = $paso2[38]." ";
	$v40 = $paso2[39];
    if (trim($v40) == "1900-01-01")
    {
        $v40 = "";
    }
	$v41 = $paso2[40];
    if (trim($v41) == "1900-01-01")
    {
        $v41 = "";
    }
	$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':AL'.$j)->applyFromArray($BStyle);
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$j, $v3)
		->setCellValue('B'.$j, $v5)
		->setCellValue('C'.$j, $v6)
		->setCellValue('D'.$j, $v7)
		->setCellValue('E'.$j, $v8)
		->setCellValue('F'.$j, $v9)
		->setCellValue('G'.$j, $v10)
		->setCellValue('H'.$j, $v11)
		->setCellValue('I'.$j, $v12)
		->setCellValue('J'.$j, $v13)
		->setCellValue('K'.$j, $v14)
		->setCellValue('L'.$j, $v15)
		->setCellValue('M'.$j, $v16)
		->setCellValue('N'.$j, $v17)
		->setCellValue('O'.$j, $v18)
		->setCellValue('P'.$j, $v19)
		->setCellValue('Q'.$j, $v40)		
		->setCellValue('R'.$j, $v20)
		->setCellValue('S'.$j, $v41)
		->setCellValue('T'.$j, $v39)
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
		->setCellValue('AI'.$j, $v35)
		->setCellValue('AJ'.$j, $v36)
		->setCellValue('AK'.$j, $v37)
		->setCellValue('AL'.$j, $v38);
	$j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Parque Automotor');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ParqueAutomotor.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
// 06/10/2023 - Nueva consulta de parque automotor
// 03/01/2024 - Inclusion 3 campos (vencimiento soat, rtm e inventario)
?>