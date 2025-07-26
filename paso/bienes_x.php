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
    ->setTitle("Consulta de Bienes")
    ->setSubject("Consulta Web");
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(80);
$objPHPExcel->getActiveSheet()->getStyle('A1:BJ1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:BJ1')->getFill()->getStartColor()->setARGB('CCCCCC');
$objPHPExcel->getActiveSheet()->getStyle("A1:BJ1")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Código')
    ->setCellValue('B1', 'Clasificación')
    ->setCellValue('C1', 'Nombre del Bien')        
    ->setCellValue('D1', 'Descripción')
    ->setCellValue('E1', 'Unidad')
    ->setCellValue('F1', 'Marca')
    ->setCellValue('G1', 'Color')
    ->setCellValue('H1', 'Modelo')
    ->setCellValue('I1', 'Serial')
    ->setCellValue('J1', 'Valor')
    ->setCellValue('K1', 'Fecha Compra')
    ->setCellValue('L1', 'Numero Soat')
    ->setCellValue('M1', 'Aseguradora')
    ->setCellValue('N1', 'Fecha Inicial')
    ->setCellValue('O1', 'Fecha Final')
    ->setCellValue('P1', 'Clase Seguro')
    ->setCellValue('Q1', 'Valor Seguro')
    ->setCellValue('R1', 'Número Seguro')
    ->setCellValue('S1', 'Aseguradora')
    ->setCellValue('T1', 'Fecha Inicial')
    ->setCellValue('U1', 'Fecha Final')
    ->setCellValue('V1', 'Funcionario')
    ->setCellValue('W1', 'Ordop Origen')
    ->setCellValue('X1', 'Misión Origen')
    ->setCellValue('Y1', 'Ordop Actual')
    ->setCellValue('Z1', 'Misión Actual')
    ->setCellValue('AA1', 'Plan / Solicitud')
    ->setCellValue('AB1', 'Relación de Gastos')
    ->setCellValue('AC1', 'Fecha Relación')    
    ->setCellValue('AD1', 'Compañía')
    ->setCellValue('AE1', 'Estado')
    ->setCellValue('AF1', 'Egreso')
    ->setCellValue('AG1', 'No. Unidad')
    ->setCellValue('AH1', 'Nombre Unidad')
    ->setCellValue('AI1', 'Tipo Elemento')
    ->setCellValue('AJ1', 'Responsable Bien (Grado, Nombre y Apellido o Código)')
    ->setCellValue('AK1', 'Número Documento Asignación Bien')
    ->setCellValue('AL1', 'Fecha Documento Asignación Bien')
    ->setCellValue('AM1', 'Código SAP')
    ->setCellValue('AN1', 'Número Acta Alta SAP')
    ->setCellValue('AO1', 'Fecha Acta Alta SAP')
    ->setCellValue('AP1', 'Almacén a Transferir')
    ->setCellValue('AQ1', 'Fecha Siniestro')
    ->setCellValue('AR1', 'Tipo Siniestro')
    ->setCellValue('AS1', 'Número Informe')
    ->setCellValue('AT1', 'Fecha Informe')
    ->setCellValue('AU1', 'Número Acto Administrativo')
    ->setCellValue('AV1', 'Fecha Acto Administrativo')
    ->setCellValue('AW1', 'Observaciones')
    ->setCellValue('AX1', 'Número Acto Administrativo')
    ->setCellValue('AY1', 'Fecha Acto Administrativo')
    ->setCellValue('AZ1', 'Orden Semanal')
    ->setCellValue('BA1', 'Fecha Orden Semanal')
    ->setCellValue('BB1', 'Observaciones')
    ->setCellValue('BC1', 'Usuario Final del Bien (Grado, Nombre y Apellido o Código)')
    ->setCellValue('BD1', 'Número Documento Asignación Bien')
    ->setCellValue('BE1', 'Fecha Documento Asignación Bien')
    ->setCellValue('BF1', 'Traspaso')
    ->setCellValue('BG1', 'Acta')
    ->setCellValue('BH1', 'Fecha')
    ->setCellValue('BI1', 'Observaciones')
    ->setCellValue('BJ1', 'Revistas');
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
    $v9 = $paso2[8]." ";
    $v10 = $paso2[9];
    $v11 = $paso2[10];
    $v12 = $paso2[11]." ";
    $v13 = $paso2[12];
    $v14 = $paso2[13];
    $v15 = $paso2[14];
    $v16 = $paso2[15];
    $v17 = $paso2[16];
    $v18 = $paso2[17]." ";
    $v19 = $paso2[18];
    $v20 = $paso2[19];
    $v21 = $paso2[20];
    $v22 = $paso2[21];
    $v23 = $paso2[22];
    $v24 = $paso2[23]." ";
    $v25 = $paso2[24];
    $v26 = $paso2[25]." ";
    $v27 = $paso2[26]." ";
    $v28 = $paso2[27];
    $v29 = $paso2[28];
    $v30 = $paso2[29];
    $v31 = $paso2[30];
    $v32 = $paso2[31];
    $v33 = $paso2[32];
    $v34 = $paso2[33];
    $v35 = $paso2[34];
    $v36 = $paso2[35]." ";
    $v37 = $paso2[36];
    $v38 = $paso2[37];
    $v39 = $paso2[38];
    $v40 = $paso2[39];
    $v41 = $paso2[40];
    $v42 = $paso2[41];
    $v43 = $paso2[42];
    $v44 = $paso2[43];
    $v45 = $paso2[44];
    $v46 = $paso2[45];
    $v47 = $paso2[46];
    $v48 = $paso2[47];
    $v49 = $paso2[48];
    $v50 = $paso2[49];
    $v51 = $paso2[50];
    $v52 = $paso2[51];
    $v53 = $paso2[52];
    $v54 = $paso2[53];
    $v55 = $paso2[54]." ";
    $v56 = $paso2[55];
    $v57 = $paso2[56];
    if (trim($v57) == "1900-01-01")
    {
        $v57 = "";
    }
    $v58 = $paso2[57];
    $v59 = $paso2[58];
    $v60 = $paso2[59];
    $v61 = $paso2[60];
    if (trim($v58) == "")
    {
        $v62 = "";
    }
    else
    {
        $v62 = "X";
    }
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
        ->setCellValue('AC'.$j, $v57)
        ->setCellValue('AD'.$j, $v29)
        ->setCellValue('AE'.$j, $v30)
        ->setCellValue('AF'.$j, $v31)
        ->setCellValue('AG'.$j, $v32)
        ->setCellValue('AH'.$j, $v33)
        ->setCellValue('AI'.$j, $v34)
        ->setCellValue('AJ'.$j, $v35)
        ->setCellValue('AK'.$j, $v36)
        ->setCellValue('AL'.$j, $v37)
        ->setCellValue('AM'.$j, $v38)
        ->setCellValue('AN'.$j, $v39)
        ->setCellValue('AO'.$j, $v40)
        ->setCellValue('AP'.$j, $v41)
        ->setCellValue('AQ'.$j, $v42)
        ->setCellValue('AR'.$j, $v43)
        ->setCellValue('AS'.$j, $v44)
        ->setCellValue('AT'.$j, $v45)
        ->setCellValue('AU'.$j, $v46)
        ->setCellValue('AV'.$j, $v47)
        ->setCellValue('AW'.$j, $v48)
        ->setCellValue('AX'.$j, $v49)
        ->setCellValue('AY'.$j, $v50)
        ->setCellValue('AZ'.$j, $v51)
        ->setCellValue('BA'.$j, $v52)
        ->setCellValue('BB'.$j, $v53)
        ->setCellValue('BC'.$j, $v54)
        ->setCellValue('BD'.$j, $v55)
        ->setCellValue('BE'.$j, $v56)
        ->setCellValue('BF'.$j, $v62)
        ->setCellValue('BG'.$j, $v58)
        ->setCellValue('BH'.$j, $v59)
        ->setCellValue('BI'.$j, $v60)
        ->setCellValue('BJ'.$j, $v61);
    $j++;
}
$objPHPExcel->getActiveSheet()->setTitle('Consulta de Bienes');
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ConsultaBienes.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>