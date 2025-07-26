<?php
/* 627E.php
   FO-JEMPP-CEDE2-627 - Informe Consolidado de Ejecución Mensual de Gastos Reservados.
   (pág 227 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

   Genera el informe 627 a un archivo de Excel
   Exportación Excel, el archivo queda en la carpeta Downloads del equipo local.
*/ 
ob_start();
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
	define('FPDF_FONTPATH','font/');
	require('rotar.php');
	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require_once '../Clases/PHPExcel.php';	

	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$columna = array ('UNIDAD EJECUTORA Y SUBORDINADA INTELIGENCIA', 'SALDO ANTERIOR', 'TOTAL PRESUPUESTO MENSUAL', 'TOTAL PRESUPUESTO ADICIONAL', 'TOTAL PRESUPUESTO RECOMPENSAS','REINTEGROS','TRANSFERENCIAS NETAS A UNIDADES SUBORDINADAS','DISPONIBLE EJECUTAR','GASTOS EN ACTIVIDADES DE INTELIGENCIA Y CONTRATE','PAGO INFORMACIONES','PAGO RECOMPENSAS','GASTOS DE PROTECCION','GASTOS DE COBEERTURA','DEVOLUCIONES','TOTAL EJECUTADO', 'SALDO');

	$cols = count($columna)+1;	
	$cols = 16;
	$objPHPExcel = new PHPExcel();
	
	$consulta_uni = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'"; 
	$cur_uni = odbc_exec($conexion,$consulta_uni);
	$unidad = odbc_result($cur_uni,3);
	$sig_unidad = trim(odbc_result($cur_uni,4));
	$dependencia = odbc_result($cur_uni, 2);
	$n_unidadcen = strtr(trim(odbc_result($cur_uni,6)), $sustituye);
	$u_unic = trim(odbc_result($cur_uni,8));
	$n_eje = trim(odbc_result($cur_uni,13));
	$c_eje = trim(odbc_result($cur_uni,28));
	$n_jem = trim(odbc_result($cur_uni,14));
	$c_jem = trim(odbc_result($cur_uni,29));
	$n_cdo = trim(odbc_result($cur_uni,15));	
	$c_cdo = trim(odbc_result($cur_uni,30));	

	if ($unidad == '1') $cod_uni_eje = "SIIF NACION II (081)";
	else $cod_uni_eje = "N/A";
	$rubro = $n_rubros[2];
	$nom_rubro = "GASTOS RESERVADOS"; 
	if ($_GET['ajuste'] <> 0) $ajuste = $_GET['ajuste'];
	else $ajuste = 2;
	$ano = substr($_GET['fecha1'],0,4);	
	$periodo = substr($_GET['fecha1'],5,2);
	$periodo1 = substr($_GET['fecha2'],5,2);
	
	//fechas para generar informe 
	$fe_ini = substr($_GET['fecha1'],0,4).substr($_GET['fecha1'],5,2).substr($_GET['fecha1'],8,2);
	$fe_fin = substr($_GET['fecha2'],0,4).substr($_GET['fecha2'],5,2).substr($_GET['fecha2'],8,2);
	$fe_per = substr($_GET['fecha2'],5,2);
	
	if (substr($periodo,0,1) == '0') $periodo = substr($periodo,1,1);
	$dias_mes = cal_days_in_month(CAL_GREGORIAN, $periodo, $ano);
	$vigencia = "Del 01-".$n_meses[$periodo-1]."-".$ano." AL ".$dias_mes."-".$n_meses[$periodo1-1]."-".$ano;
	
	//Selecciona el tipo de recurso a filtrar.
	$recurso_d = $_GET['recurso'];
	if ($recurso_d == 4) $recurso_d = 0;
	if ($uni_usuario == 1)
	{
		if ($recurso_d == 0) $recu = " (Recurso: todos)";
		if ($recurso_d == 1) $recu = " (Recurso: 10 CSF)";
		if ($recurso_d == 2) $recu = " (Recurso: 50 CSF)";
		if ($recurso_d == 3) $recu = " (Recurso: 16 CSF)";
	}   //if
	$tit_info = "INFORMACION DE EJECUCION MENSUAL".$recu;

	if (substr($periodo,0,1) == '0') $periodo = substr($periodo,1,1);
	if ($periodo == 1)
	{
		$periodo = 12;
		$ano = $ano - 1;
	}
	else
	{
		$periodo = $periodo - 1;
		$ano = $ano;
	}

	//Propiedades del objeto Excel
	$objPHPExcel->getProperties()
		->setCreator("Cx Computers SAS")
		->setLastModifiedBy("Cx Computers SAS")
		->setTitle("Informe Consolidado de Ejecucion Mensual")
		->setSubject("FO-JEMPP-CEDE2-627")
		->setDescription("Informe Consolidado de Ejecucion Mensual")
		->setKeywords("Consolidado Ejecucion Mensual")
		->setCategory("Informe");

	// Procesa info	
	$ran0 = 'B1:AG1';
	$ran1 = 'B2:AG2';
	$ran2 = 'B2:AG100';
	$ran3 = 'B3:AG100';	
		
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFill()->getStartColor()->setARGB('cccccc');
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFont()->setBold(true);	
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
	$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'wrap' => true));
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->applyFromArray($style);
	
	$objPHPExcel->getActiveSheet()->mergeCells($ran0);			
	$tit = "INFORME CONSOLIDADO DE EJECUCION MENSUAL DE GASTOS RESRVADOS   ".$sig_usuario."   Vigencia: ".$vigencia;
	$objPHPExcel->getActiveSheet()->setCellValue('B1', $tit);

	$objPHPExcel->getActiveSheet()->getStyle($ran2)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => 'FF000000')))));
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getFill()->getStartColor()->setARGB('cccccc');
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getFont()->setBold(true);					
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFont()->setsize(11);
	$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' => true));
	$objPHPExcel->getActiveSheet()->getStyle($ran1)->applyFromArray($style);			
	foreach(range('B','Q') as $cols)
	{
		$objPHPExcel->getActiveSheet()->getColumnDimension($cols)->setAutoSize(true);
	}  //for	

	$col = 1;
	foreach ($columna as $cols)
	{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, $cols);
		$col++;
	}  //for

	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getFill()->getStartColor()->setARGB('ffffff');
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getFont()->setBold(false);			
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	

	$consulta = "select * from dbo.cf_rep_1627('".$fe_ini."','".$fe_fin."',$uni_usuario,$recurso_d) order by  ord_regi";	
	$cur = odbc_exec($conexion,$consulta);
	$nr = odbc_num_rows($cur);
	$tot = array(32);
	$tot[0] = "TOTALES"; 

	$fil=3;
	while($fil<odbc_fetch_array($cur))
	{
		for ($clm=2;$clm<=33;$clm++)
		{
			$vlr = trim(odbc_result($cur,$clm));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clm-1, $fil, $vlr);
		}   //for

		//Acumula totales por columna
		for ($i=1;$i<=31;$i++)
		{
			$tot[$i] = $tot[$i] + odbc_result($cur,$i+2);
		}   //for
		$fil++;
	}   //while

	//Pinta totales
	$ran4 = 'B'.$fil.':AG'.$fil;	
	$objPHPExcel->getActiveSheet()->getStyle($ran4)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran4)->getFill()->getStartColor()->setARGB('cccccc');
	$objPHPExcel->getActiveSheet()->getStyle($ran4)->getFont()->setBold(true);		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fil, $tot[0]);
	for ($clm=2;$clm<=32;$clm++)
	{
		if ($tot[$clm-1] == "") $tot[$clm-1] = 0;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clm, $fil, $tot[$clm-1]);
	}   //if

	$nom_file = $sig_usuario."_".$fe_per.".xlsx";
	$objPHPExcel->getActiveSheet()->setTitle('Consolidado');
	$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename='.$nom_file);
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//file_put_contents('depuracion.txt', ob_get_contents());
	ob_end_clean();	
	$objWriter->save('php://output');
	exit;
}   //if
?>
