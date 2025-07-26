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
    ->setTitle("Recompensas")
    ->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(100);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(100);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(100);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AY1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:AY2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
$objPHPExcel->getActiveSheet()->getStyle('A1:E2')->getFill()->getStartColor()->setARGB('FFC000');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F1:R1');
$objPHPExcel->getActiveSheet()->getStyle('F1:R1')->getFill()->getStartColor()->setARGB('375623');
$objPHPExcel->getActiveSheet()->getStyle('F2:R2')->getFill()->getStartColor()->setARGB('A9D08E');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S1:U1');
$objPHPExcel->getActiveSheet()->getStyle('S1:U2')->getFill()->getStartColor()->setARGB('FFC000');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('V1:W1');
$objPHPExcel->getActiveSheet()->getStyle('V1:W2')->getFill()->getStartColor()->setARGB('1F4E78');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('X1:Z1');
$objPHPExcel->getActiveSheet()->getStyle('X1:Z2')->getFill()->getStartColor()->setARGB('C65911');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA1:AS1');
$objPHPExcel->getActiveSheet()->getStyle('AA1:AS1')->getFill()->getStartColor()->setARGB('808080');
$objPHPExcel->getActiveSheet()->getStyle('AA2:AS2')->getFill()->getStartColor()->setARGB('808080');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AT1:AW1');
$objPHPExcel->getActiveSheet()->getStyle('AT1:AW1')->getFill()->getStartColor()->setARGB('203764');
$objPHPExcel->getActiveSheet()->getStyle('AT2:AW2')->getFill()->getStartColor()->setARGB('8EA9DB');
$objPHPExcel->getActiveSheet()->getStyle('AX1:AX2')->getFill()->getStartColor()->setARGB('8EA9DB');
$objPHPExcel->getActiveSheet()->getStyle('AY1:AY2')->getFill()->getStartColor()->setARGB('FF9933');
$objPHPExcel->getActiveSheet()->getStyle('A1:AX2')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'UNIDAD SOLICITANTE')
    ->setCellValue('F1', 'UNIDAD QUE ADELANTÓ LA OPERACIÓN MILITAR')
    ->setCellValue('S1', 'UNIDAD SOLICITANTE')
    ->setCellValue('V1', 'UNIDAD OPERATIVA MENOR')
    ->setCellValue('X1', 'UNIDAD OPERATIVA MAYOR')
    ->setCellValue('AA1', 'COMITÉ CENTRAL DE LA FUERZA')
    ->setCellValue('AT1', 'UNIDAD CENTRALIZADORA RESPONSABLE DEL PAGO')
    ->setCellValue('A2', 'NR')
    ->setCellValue('B2', 'UNIDAD QUE MANEJO LA FUENTE')
    ->setCellValue('C2', 'NR HR INICIO TRAMITE')
    ->setCellValue('D2', 'FECHA HR')
    ->setCellValue('E2', 'IDENTIDAD Y NOMBRE FUENTE')
    ->setCellValue('F2', 'DIV')
    ->setCellValue('G2', 'BR')
    ->setCellValue('H2', 'U.T. REALIZÓ OPERACIÓN')
    ->setCellValue('I2', 'FECHA RESULTADO')
    ->setCellValue('J2', 'ORDOP')
    ->setCellValue('K2', 'FRAGMENTARIA')
    ->setCellValue('L2', 'LUGAR (VEREDA-CORREGIMIENTO)')
    ->setCellValue('M2', 'MUNICIPIO')
    ->setCellValue('N2', 'DEPARTAMENTO')
    ->setCellValue('O2', 'AMENAZA')
    ->setCellValue('P2', 'ESTRUCTURA')
    ->setCellValue('Q2', 'TIPO RESULTADO')
    ->setCellValue('R2', 'DESCRIPCIÓN RESULTADO')
    ->setCellValue('S2', 'OFICIO SOLICITUD')
    ->setCellValue('T2', 'FECHA')
    ->setCellValue('U2', 'VALOR SOLICITADO')
    ->setCellValue('V2', 'NR OFICIO APOYO BRIGADA')
    ->setCellValue('W2', 'FECHA')
    ->setCellValue('X2', 'NR ACTA EVAL COMITÉ REGIONAL')
    ->setCellValue('Y2', 'FECHA')
    ->setCellValue('Z2', 'VALOR APROBADO COMITÉ REGIONAL')
    ->setCellValue('AA2', 'NUMERO OFICIO UOM')
    ->setCellValue('AB2', 'FECHA OFICIO UOM')
    ->setCellValue('AC2', 'FECHA RADICACIÓN CEDE2')
    ->setCellValue('AD2', 'Nº OFICIO LLEGADO 2 VEZ')
    ->setCellValue('AE2', 'FECHA OFICIO 2 VEZ')
    ->setCellValue('AF2', 'Nº REGISTRO CEDE2 2 VEZ')
    ->setCellValue('AG2', 'FECHA 2DA LLEGADA')
    ->setCellValue('AH2', 'OBSERVACIONES')
    ->setCellValue('AI2', 'NUMERO OFICIO OBSERVACIONES')
    ->setCellValue('AJ2', 'FECHA')
    ->setCellValue('AK2', 'PRORROGAS APROBADAS CEDE2')
    ->setCellValue('AL2', 'NUMERO OFICIO PRORROGA')
    ->setCellValue('AM2', 'FECHA')
    ->setCellValue('AN2', 'OFICIO RESPUESTA OBSERVACIONES')
    ->setCellValue('AO2', 'FECHA')
    ->setCellValue('AP2', 'FECHA RADICACIÓN RESPUESTA CEDE2')
    ->setCellValue('AQ2', 'NR ACTA EVALUACIÓN COMITÉ CENTRAL')
    ->setCellValue('AR2', 'FECHA ACTA')
    ->setCellValue('AS2', 'VALOR APROBADO')
    ->setCellValue('AT2', 'FECHA GIRO')
    ->setCellValue('AU2', 'NR ACTA PAGO')
    ->setCellValue('AV2', 'FECHA PAGO')
    ->setCellValue('AW2', 'OBSERVACIONES DEL PAGO')
    ->setCellValue('AX2', 'DIAS HABILES')
    ->setCellValue('AY2', 'ESTADO');
$j=3;
$m = count($paso1);
for ($i=0;$i<count($paso1)-1;++$i)
{
    $k = $i+1;
    $variables = $paso1[$i];
    $paso2 = explode("|",$variables);
    $v1 = $paso2[0];
    $v2 = $paso2[1];
    $v3 = $paso2[2]." ";
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
    $v19 = $paso2[18]." ";
    $v20 = $paso2[19];
    $v21 = $paso2[20];
    $v22 = $paso2[21]." ";
    $v23 = $paso2[22];
    $v24 = $paso2[23];
    $v25 = $paso2[24];
    $v26 = $paso2[25];
    $v27 = $paso2[26]." ";
    $v28 = $paso2[27];
    $v29 = $paso2[28];
    $v30 = $paso2[29]." ";
    $v31 = $paso2[30];
    $v32 = $paso2[31]." ";
    $v33 = $paso2[32];
    $v34 = $paso2[33];
    $v35 = $paso2[34]." ";
    $v36 = $paso2[35];
    $v37 = $paso2[36];
    $v38 = $paso2[37]." ";
    $v39 = $paso2[38];
    $v40 = $paso2[39]." ";
    $v41 = $paso2[40];
    $v42 = $paso2[41];
    $v43 = $paso2[42]." ";
    $v44 = $paso2[43];
    $v45 = $paso2[44];
    $v46 = $paso2[45];
    $v47 = $paso2[46];
    $v48 = $paso2[47];
    $v49 = $paso2[48];
    $v50 = $paso2[49];
    $v51 = $paso2[50];
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
        ->setCellValue('AI'.$j, $v35)
        ->setCellValue('AJ'.$j, $v36)
        ->setCellValue('AK'.$j, $v37)
        ->setCellValue('AL'.$j, $v38)
        ->setCellValue('AM'.$j, $v39)
        ->setCellValue('AN'.$j, $v40)
        ->setCellValue('AO'.$j, $v41)
        ->setCellValue('AP'.$j, $v42)
        ->setCellValue('AQ'.$j, $v43)
        ->setCellValue('AR'.$j, $v44)
        ->setCellValue('AS'.$j, $v45)
        ->setCellValue('AT'.$j, $v46)
        ->setCellValue('AU'.$j, $v47)
        ->setCellValue('AV'.$j, $v48)
        ->setCellValue('AW'.$j, $v49)
        ->setCellValue('AX'.$j, $v50)
        ->setCellValue('AY'.$j, $v51);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Recompensas');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Recompensas.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>