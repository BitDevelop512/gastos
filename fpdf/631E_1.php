<?php
/* 631E_1.php
   FO-JEMPP-CEDE2-631 - Informe Detallado por Comprobantes, Conceptos y Valores Ejecutados.
   (pág 234 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	- 08/09/2022 - Se adiciona el control para las demas cuentas - Consuelo Martínez.
	- 01/07/2023 - Se hace control del cambio de la sigla de la unidad.  - Jorge Clavijo.
	- 04/07/2023 - Ajuste unidad que ejecutó. - Jorge clavijo.
	- 11/10/2023 - Para la unidad DIADI se hace una selección especial para incluir unicmante las unidades DIPEI, DICOO, DIPDA y DIADI. - Jorge Clavijo.
	- 26/10/2023 - Se hace ajuste para el nombre de la unidad para las divisiones en la columa UOM para que aparezca DIV0# y no DIV#. - Jorge Clavijo.
	- 13/12/2023 - Generar el informe en MS Excel. Incluye todas las unidades. - Jorge Clavijo.
	- 10/01/2024 - Se incluyen las columnas origen y unidad al final del reporte. - Jorge Clavijo.
	- 31/01/2024 - Se solicita hacer los siguientes cambios: 1) Eliminar la columna No., 2) mover a la columna B la columna Q,
				   3) Cambiar el nombre UND por Filtro Unidad, 4) Cambiar el nombre de CUENTA por Filtro Cuenta, 5) En vez del código de la unidad mostrar la Sigla. - Jorge Clavijo.
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
	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require_once '../clases/PHPExcel.php';	
	
	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA','ORDEN DE PAGO SIIF');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$columna = array ('Filtro Unidad', 'U.O.M', 'BR', 'UT', 'Unidad/Dep emp recurso','Fecha','Comprobante','No.','Valor Ingreso','Valor Egreso','Concepto del gasto','Soporte','Recurso','origen','unidad','Filtro Cuenta');

	//01/07/2023 - Se hace control del cambio de la sigla de la unidad. Jorge Clavijo.
	function verifica_sigla($v_sigla, $f_fecha_lb)
	{
		require('../conf.php');
		$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where sigla = '".$v_sigla."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$sigla = trim(odbc_result($cur1,1));
		$sigla1 = trim(odbc_result($cur1,3));
		$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
		if ($sigla1 <> "") if ($f_fecha_lb >= $fecha_os) $sigla = $sigla1;
		return $sigla;
	}   //verifica_sigla

	$consulta_sub = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
	$cur_sub = odbc_exec($conexion,$consulta_sub);
	$unidad  = trim(odbc_result($cur_sub,1));
	$dependencia = trim(odbc_result($cur_sub,2));
	$subdependencia = trim(odbc_result($cur_sub,3));
	$nom_unidad = $ut = verifica_sigla(trim(odbc_result($cur_sub,4)), $fecha_lb);
	$unic_unidad = trim(odbc_result($cur_sub,8));	
	$especial = trim(odbc_result($cur_sub,40));

	if ($_GET['periodo'] == 1)
	{
		$periodo = 12;
		$ano = $_GET['ano'] - 1;
	}
	else
	{
		$periodo = $_GET['periodo'] - 1;
		$ano = $_GET['ano'];
	}   //if

	$bri = "";
	$lin=9;	
	$jj = 1;
	$v_ingreso = 0;
	$v_egreso = 0;

	$consulta_libban = "select * from cv_lib_ban where periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."  ' order by fecha, comprobante, tipo1";	
	$cur_libban = odbc_exec($conexion,$consulta_libban);
	$K = 1;
	while($k<$row=odbc_fetch_array($cur_libban))
	{	
		$n_comp = trim(odbc_result($cur_libban,1));
		$fecha_all = odbc_result($cur_libban,2);
		$fecha_lb = substr(odbc_result($cur_libban,2),0,10);
		$und = trim(odbc_result($cur_libban,3));
		$nom_concepto = ucwords(strtolower(trim(odbc_result($cur_libban,8))));
		$recurso = trim(odbc_result($cur_libban,16));
		$recurso = $n_recursos[$recurso-1];
		$cuenta = trim(odbc_result($cur_libban,17));

		$consulta_ors = "select * from cx_org_sub where subdependencia = '".$und."'";
		$cur_ors = odbc_exec($conexion,$consulta_ors);
		$n_und  = trim(odbc_result($cur_ors,4));		

		//Procesa los Ingresos, $tipo1 = 1
		if (trim(odbc_result($cur_libban,10)) == 1)
		{
			$consulta_soporte = "select * from cx_com_ing where ingreso = '".$n_comp."' and unidad = '".$und."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_soporte = odbc_exec($conexion,$consulta_soporte);
			$k1 = 0;
			while($k1<$row=odbc_fetch_array($cur_soporte))
			{
				$consulta_os = "select * from cx_org_sub where subdependencia = '".$und."'";
				$cur_os = odbc_exec($conexion,$consulta_os);
				$unidad  = trim(odbc_result($cur_os,1));
				$subdependencia = trim(odbc_result($cur_os,3));
				$nom_unidad = $ut = verifica_sigla(trim(odbc_result($cur_os,4)), $fecha_lb);				
				$unic_unidad = trim(odbc_result($cur_os,8));

				$consulta_cv = "select * from cv_unidades where unidad = '".$unidad."' and subdependencia = '".$subdependencia."'";	
				$cur_cv = odbc_exec($conexion,$consulta_cv);
				if (strlen(trim(odbc_result($cur_cv,2))) < 5) $uom = verifica_sigla(trim(odbc_result($cur_cv,4)), $fecha_lb);
				else $uom = verifica_sigla(trim(odbc_result($cur_cv,2)), $fecha_lb);
				if ($unic_unidad <> 1) $nom_unidad = $uom = verifica_sigla(trim(odbc_result($cur_cv,4)), $fecha_lb);

				$concepto = odbc_result($cur_soporte,10);
				$soporte = $n_soportes[odbc_result($cur_soporte,13)-1].' - '.trim(odbc_result($cur_soporte,14));
				$v_ingreso = substr(str_replace(',','',trim(odbc_result($cur_soporte,9))),0);
		
				$consulta_cv = "select * from cv_unidades where subdependencia = '".trim(odbc_result($cur_soporte,24))."'";	
				$cur_cv = odbc_exec($conexion,$consulta_cv);
				if (odbc_result($cur_soporte,24) == 0)  $n_unidad1 = "";
				else $n_unidad1 = trim(odbc_result($cur_cv,6));
				
				if ($unic_unidad == 1)
				{
					$ut = "";
					$bri = "";
				}   //if

                //11/10/2023 - Para la unidad DIADI se hace una selección especial para incluir unicmante las unidades DIPEI, DICOO, DIPDA y DIADI. Jorge Clavijo.
				if ($nom_unidad == 'DIPEI' or $nom_unidad == 'DICOO' or $nom_unidad == 'DIPDA') $nom_unidad = 'CEDE2';

				//04/07/2023, Jorge clavijo ajuste unidad que ejecutó.
				if ($nom_unidad == 'DAVAA')
				{
					$nom_unidad = 'CONAT'; 
					$bri = ' ';
				}   //if

				$v_egreso = 0;
				$data[] = array($jj, $uom, $bri, $ut, $nom_unidad, $fecha_lb, 'INGRESO', $n_comp, $v_ingreso, $v_egreso, utf8_encode($nom_concepto), trim($soporte), trim($recurso), $rsocial_n = strtr(trim(odbc_result($cur_soporte,21)), $sustituye), $n_unidad1, $n_und." (cod: ".$und.")", $cuenta, $fecha_all);
				$k1++;
			}   //while
			$jj++;
		}

		//Procesa los Egresos, $tipo1 = 2
		else 
		{
			$consulta_soporte = "select * from cx_com_egr where egreso = '".odbc_result($cur_libban,1)."' and unidad = '".odbc_result($cur_libban,3)."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_soporte = odbc_exec($conexion,$consulta_soporte);
			$concepto = trim(odbc_result($cur_soporte,21));
			$tpgasto = trim(odbc_result($cur_soporte,22));
			$sop =  trim(odbc_result($cur_soporte,27));
			$n_sop =  trim(odbc_result($cur_soporte,28));

			//Columna de nombre de unidad, adicional solicitado por Jorge Clavijo.
			$consulta_cv = "select * from cv_unidades where subdependencia = '".trim(odbc_result($cur_soporte,36))."'";	
			$cur_cv = odbc_exec($conexion,$consulta_cv);
			if (odbc_result($cur_soporte,36) == 0) $n_unidad1 = "";
			$n_unidad1 = trim(odbc_result($cur_cv,6));

			switch ($tpgasto)
			{
			case 0:
				if ($concepto == '21') $nom_concepto = "  Impuesto";
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";				
				break;
			case 1:
				if ($concepto == '7') $nom_concepto = "  Reintegros DTN";
				if ($concepto == '8') $nom_concepto = "  Gastos en Actividades";
				if ($concepto == '9') $nom_concepto = "  Gastos en Actividades";  
				if ($concepto == '6') $nom_concepto = "  Pago de Impuestos";   
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";   
				break;
			case 2:
				if ($concepto == '7') $nom_concepto = "  Reintegros DTN";
				if ($concepto == '8') $nom_concepto = "  Pago de Informaciones";				
				if ($concepto == '9') $nom_concepto = "  Pago de Informaciones";  
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";   
				break;
			case 3:
				if ($concepto == '7') $nom_concepto = "  Reintegros DTN";
				if ($concepto == '10') $nom_concepto = "  Pago de Recompensas";
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";   
				break;
			case 99:
				if ($concepto == '8') $nom_concepto = "  Presupuesto Mensual";
				if ($concepto == '9') $nom_concepto = "  Presupuesto Adicional";
				if ($concepto == '10') $nom_concepto = "  Presupuesto Recompensas";
				break;				
			}  //switch

			$datos = trim(decrypt1(odbc_result($cur_soporte,31), $llave));
			$d_datos = explode("#",$datos);
			$c = count($d_datos) - 1;
			$v_ingreso = 0;

 			for ($h = 0;$h < $c;$h++)
			{
				$d_datos1 = explode("|",$d_datos[$h]);
				$dep = trim($d_datos1[0]);
				$ut = "";
				$br = trim(odbc_result($cur_sub,4));

				$consulta_sub2 = "select * from cx_org_sub where sigla = '".$dep."' or sigla1 = '".$dep."'";
				$cur_sub2 = odbc_exec($conexion,$consulta_sub2);
				$c_unidad = trim(odbc_result($cur_sub2,1));
				$c_depen = trim(odbc_result($cur_sub2,2));
				$c_sdepen = trim(odbc_result($cur_sub2,3));
				$unic = trim(odbc_result($cur_sub2,8));
				$tipo = trim(odbc_result($cur_sub2,7));

				$consulta_uni = "select * from cv_unidades where subdependencia = '".$c_sdepen."'";
				$cur_uni = odbc_exec($conexion,$consulta_uni);
				$nom_uni_br1 = trim(odbc_result($cur_uni,2));
				
				$consulta_br = "select top(1) * from cx_org_sub where dependencia = '".$c_depen."' and unic <> 0";
				$cur_br = odbc_exec($conexion,$consulta_br);
				$bbrr = trim(odbc_result($cur_br,4));				

				if ($unic_unidad <> 1 and $bbrr <> $nom_uni_br1) $nom_uni_br1 = $bbrr;
				if ($bbrr == 'BRIMI1' || $bbrr == 'BRIMI2') $nom_uni_br1 = 'CAIMI';
				if ($bbrr == 'BRCIM1' || $bbrr == 'BRCIM2') $nom_uni_br1 = 'CACIM';
				if ($bbrr == $nom_uni_br1) $bbrr = "";			
				if ($nom_uni_br1 == 'CONAT' || $nom_uni_br1 == 'BRIAV33') $nom_uni_br1 = 'DAVAA';
				if ($nom_uni_br1 == 'CENOR') $nom_uni_br1 = 'DIV02';
								
				if ($tipo == 4 || $tipo == 6)
				{
					if ($bbrr <> "")
					{
						$nom_uni_br1 = $bbrr;
						$bbrr = "";
					}
					else
					{
						$nom_uni_br1 = $dep;
					}   //if
				}   //if

				switch ($unic)
				{
				case 0:
					if ($c_sdepen < 6) $ut1 = "";
					else $ut1 = verifica_sigla(trim($d_datos1[0]), $fecha_lb);
					$dep = trim($d_datos1[0]);
					break;
				case 1:
					$ut = verifica_sigla(trim($d_datos1[0]), $fecha_lb);
					$ut1 = "";
					if ($dep == 'CONAT') $nom_uni_br1 = 'DAVAA';
					if ($dep == 'CENOR') $nom_uni_br1 = 'DIV02';
					break;
				case 2:
					$bbrr = $dep;
					$ut1 = "";
					break;
				}  //switch

				//26/10/2023 - Se hace ajuste para el nombre de la unidad para las divisiones en la columa UOM para que aparezca DIV0# y no DIV#. Jorge Clavijo.
				if (substr($nom_uni_br1,0,3) == 'DIV' and substr($nom_uni_br1,3,1) <> '0') $nom_uni_br1 = substr($nom_uni_br1,0,3)."0".substr($nom_uni_br1,3,1);
				$dep1 = verifica_sigla($dep, $fecha_lb);

				$consulta_iaut = "select * from cx_inf_aut where unidad1 = '".$c_sdepen."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
				$cur_iaut = odbc_exec($conexion,$consulta_iaut);
				$aut = trim(odbc_result($cur_iaut,1));

				$consulta_csop = "select * from cx_ctr_sop where conse = '".$sop."'";
				$cur_csop = odbc_exec($conexion,$consulta_csop);
				if ($sop == '12') $soporte = trim(odbc_result($cur_csop,2)).' - '.$aut;
				else $soporte = trim(odbc_result($cur_csop,2)).' - '.$n_sop;
				//if ($sop == '16') $nom_uni_br1 = 'CAIMI';
				$v_egreso = substr(str_replace(',','',trim($d_datos1[1])),0);

				if ($v_ingreso <> 0 || $v_egreso <> 0)
				{
					$data[] = array($jj, $nom_uni_br1, $bbrr, $ut1, $dep1, $fecha_lb, 'EGRESO', $n_comp, $v_ingreso, $v_egreso, $nom_concepto, trim($soporte), trim($recurso), "", $n_unidad1, $n_und." (cod: ".$und.")", $cuenta, $fecha_all);
					$jj++;
				}   //if
				$t_egreso = $t_egreso + $v_egreso;
				$v_egreso = 0; 
			}   //for
		}   //if
		$k++;
	}   //while
	
	//08/09/2022 - Se adiciona el control para las demas cuentas - Consuelo Martínez.
	$consulta_cm = "select * from cx_cue_mov where unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."' order by egreso";
	$cur_cm = odbc_exec($conexion,$consulta_cm); 
	$debito_cm = 0;
	$credito_cm = 0;
	$i = 0;
	while($i<=$row=odbc_fetch_array($cur_cm))
	{
		$fecha_all = odbc_result($cur_cm,2);
		$fecha_cm = substr(odbc_result($cur_cm,2),0,10);
		$unidad_cm = odbc_result($cur_cm,4);
		$comp_cm = trim(odbc_result($cur_cm,7));
		$cta_inicial_cm = odbc_result($cur_cm,9);
		$cta_final_cm = odbc_result($cur_cm,10);
		
		$consulta_vu = "select * from cv_unidades where subdependencia = '".$unidad_cm."'";
		$cur_vu = odbc_exec($conexion,$consulta_vu);
		$n_unidad_cm =  trim(odbc_result($cur_vu,6));

		if ($cta_inicial_cm == '3' and $cta_final_cm == '1') $credito_cm = trim(odbc_result($cur_cm,12));
		if ($_GET['cuenta'] == $cta_final_cm)
		{
			//Revisión hecha para arreglo del concepto y del periodo.
			$consulta_csop = "select soporte, (select nombre from cx_ctr_sop where cx_com_egr.soporte = cx_ctr_sop.conse) as nom_sopo from cx_com_egr where egreso = '".$comp_cm."' and ano = '2023' and periodo = '".$_GET['periodo']."'";
			$cur_csop = odbc_exec($conexion,$consulta_csop);
			$soporte = trim(odbc_result($cur_csop,2));

			$consulta_cg = "select * from cx_ctr_gas where codigo = (select concepto from cx_com_egr where unidad = '".$uni_usuario."' and egreso = '".$comp_cm."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."')";
			$cur_cg = odbc_exec($conexion,$consulta_cg);
			$conceptof = ucwords(strtolower(trim(odbc_result($cur_cg,2))));

			$consulta_ce = "select * from cx_com_egr where egreso = '".$comp_cm."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_ce = odbc_exec($conexion,$consulta_ce);
			$recurso = trim(odbc_result($cur_ce,23));
			$recurso = $n_recursos[$recurso-1];
			$data[] = array($jj, $n_unidad_cm, "", "", $n_unidad_cm, $fecha_cm, 'EGRESO', $comp_cm, $credito_cm, $debito_cm, $conceptof, $soporte, $recurso, "", "", $n_unidad_cm." (cod: ".$unidad_cm.")", $cta_final_cm, $fecha_all);
			$saldo = $saldo_cm;
			$jj++;
		}   //if
		$i++;
	}   //while	
	
	//Ordena por comprobante y calcula saldo
	for ($ax=0;$ax<=count($data)-1;$ax++) $aux[$ax] = $data[$ax][16];
	array_multisort($aux, SORT_ASC, $data);
	$t_ingreso = 0;
	$t_egreso = 0;

	for ($ax=0;$ax<=count($data)-1;$ax++)
	{
		$t_ingreso = $t_ingreso + $data[$ax][8];
		$t_egreso = $t_egreso + $data[$ax][9];
		$aax = $ax +1;
		$data1[] = array($data[$ax][15], $data[$ax][1], $data[$ax][2], $data[$ax][3], $data[$ax][4], $data[$ax][5], $data[$ax][6], $data[$ax][7], $data[$ax][8], $data[$ax][9], $data[$ax][10], utf8_encode(trim($data[$ax][11])), $data[$ax][12], utf8_encode(trim($data[$ax][13])), $data[$ax][14], $data[$ax][16]);
	}   //for

	//Propiedades del objeto Excel
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()
		->setCreator("Cx Computers SAS")
		->setLastModifiedBy("Cx Computers SAS")
		->setTitle("Informe Detallado por Comprobantes")
		->setSubject("FO-JEMPP-CEDE2-631")
		->setDescription("Informe Detallado por Comprobantes")
		->setKeywords("Informe Detallado por Comprobantes")
		->setCategory("Informe");

	//Procesa info	
	$ran0 = 'B1:Q1';
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => 'FF000000')))));
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFill()->getStartColor()->setARGB('339966');
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'wrap' => true)));
	$objPHPExcel->getActiveSheet()->mergeCells($ran0);
	$per_inf = str_repeat(" ", 13)."DESDE   1   HASTA   ".days_in_month($_GET['periodo'], $_GET['ano'])."  de ".$n_meses[$_GET['periodo'] - 1]." de ".$_GET['ano'];
	$tit = "INFORME DETALLADO POR COMPROBANTES\nPERIODO DEL INFORME:".$per_inf;
	$objPHPExcel->getActiveSheet()->setCellValue('B1', $tit);

	$ran1 = 'B2:Q2';
	$objPHPExcel->getActiveSheet()->getStyle($ran1)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => 'FF000000')))));
	$objPHPExcel->getActiveSheet()->getStyle($ran1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran1)->getFill()->getStartColor()->setARGB('cccccc');
	$objPHPExcel->getActiveSheet()->getStyle($ran1)->getFont()->setBold(true);					
	$objPHPExcel->getActiveSheet()->getStyle($ran0)->getFont()->setsize(11);
	$style = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' => true));
	$objPHPExcel->getActiveSheet()->getStyle($ran1)->applyFromArray($style);			
	foreach(range('B','R') as $cols) $objPHPExcel->getActiveSheet()->getColumnDimension($cols)->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->setAutoFilter($ran1);

	$col = 1;
	foreach ($columna as $cols)
	{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, $cols);
		$col++;
	}  //for

	$f_data1 = count($data1)+2;
	$ran2 = 'B3:Q'.$f_data1;
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => 'FF000000')))));
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getFill()->getStartColor()->setARGB('ffffff');
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getFont()->setBold(false);			
	$objPHPExcel->getActiveSheet()->getStyle($ran2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
	$objPHPExcel->getActiveSheet()->getStyle('B3:I2000')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
	$objPHPExcel->getActiveSheet()->getStyle('J3:K2000')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	for ($fil=0;$fil<=count($data1);$fil++)
	{
		for ($clm=2;$clm<=18;$clm++)
		{
			$cc = $clm - 2;
			$vlr = trim($data1[$fil][$cc]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($clm-1, $fil+3, $vlr);
		}   //for
	}   //for

	//Pinta totales
	$fil = $fil + 2;
	$ran3 = 'B'.$fil.':Q'.$fil;	
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => 'FF000000')))));
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getFill()->getStartColor()->setARGB('cccccc');
	$objPHPExcel->getActiveSheet()->getStyle($ran3)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->mergeCells('B'.$fil.':I'.$fil);
	$objPHPExcel->getActiveSheet()->mergeCells('L'.$fil.':N'.$fil);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$fil)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $fil, 'TOTALES');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fil, $t_ingreso);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $fil, $t_egreso);

	//Graba archivo de Excel
	$nom_file = $sig_usuario."_".$_GET['periodo']."_".$_GET['ano'].".xlsx";
	$objPHPExcel->getActiveSheet()->setTitle('Consolidado');
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(80);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$nom_file);
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	file_put_contents('depuracion.txt', ob_get_contents());
	ob_end_clean();	
	$objWriter->save('php://output');
	exit;
}   //if
?>

