<?php
/* 631.php
   FO-JEMPP-CEDE2-631 - Informe Detallado por Comprobantes, Conceptos y Valores Ejecutados.
   (pág 234 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
*/

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

	class PDF extends PDF_Rotate
	{
		function Header()
		{
			require('../conf.php');
			$consulta1= "select sigla,nombre from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = odbc_result($cur1,1);
			$sig_usuario = $sigla;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(95,175,$sig_usuario,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(278,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(116,5,'',0,0,'C');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(116,5,'INFORME DETALLADO POR COMPROBANTES,',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-631',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'CONCEPTOS Y VALORES EJECUTADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(116,5,'',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2017-05-16',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(125,3,'',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,105,26,0,'');
			$this->RoundedRect(114,15,116,26,0,'');
			$this->RoundedRect(230,15,58,26,0,'');
			$this->RoundedRect(9,15,279,183,0,'');

			$this->Ln(4);
		}

		function RotatedText($x,$y,$txt,$angle)
		{
    		$this->Rotate($angle,$x,$y);
    		$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}

		function RoundedRect($x,$y,$w,$h,$r,$style='')
		{
			$k = $this->k;
  			$hp = $this->h;
  			if($style=='F')
  			$op='f';
  			elseif($style=='FD' or $style=='DF')
    			$op='B';
  			else
				$op='S';
			$MyArc = 4/3 * (sqrt(2) - 1);
  			$this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));
  			$xc = $x+$w-$r ;
  			$yc = $y+$r;
  			$this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
  			$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
  			$xc = $x+$w-$r ;
  			$yc = $y+$h-$r;
  			$this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
  			$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
  			$xc = $x+$r ;
  			$yc = $y+$h-$r;
  			$this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
  			$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
  			$xc = $x+$r ;
  			$yc = $y+$r;
  			$this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
  			$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
  			$this->_out($op);
		}//function RoundedRect($x,$y,$w,$h,$r,$style='')

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//function _Arc($x1, $y1, $x2, $y2, $x3, $y3)

		function Footer()
		{
  			$fecha1=date("d/m/Y H:i:s a");
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(278,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
   			$this->Code39(268,200,$cod_bar,.5,5);
		}//function Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',6);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);
	$linea = str_repeat("_",236);
		
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA','ORDEN DE PAGO SIIF');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$ajuste = $_GET['ajuste'];

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=192.00125) $pdf->addpage();
	} //control_salto_pag
	
	$consulta_sub = "select * from cx_org_sub where subdependencia='".$uni_usuario."'";
	$cur_sub = odbc_exec($conexion,$consulta_sub);
	$dependencia = trim(odbc_result($cur_sub,2));
	$nom_uni_br = trim(odbc_result($cur_sub,4));
	$unidad = trim(odbc_result($cur_sub,1));
	$unic_unibr = trim(odbc_result($cur_sub,8));	
	$esp = 0;

	$actual=$pdf->GetY();
	$pdf->Cell(276,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(40,5,'UNIDAD CENTRALIZADORA',0,0,'');	
	$pdf->Cell(46,5,$nom_uni_br,B,1,'L');	
	$pdf->Cell(40,5,'PERIODO DEL INFORME DESDE',0,0,'');
	$pdf->Cell(15,5,'1',B,0,'C');	
	$pdf->Cell(25,5,'  HASTA',0,0,'C');	
	$pdf->Cell(25,5,days_in_month($_GET['periodo'], $_GET['ano']),B,0,'C');
	$pdf->Cell(30,5,' de '.$n_meses[$_GET['periodo'] - 1].' de '.$_GET['ano'],0,0,'L');

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

	if ($_GET['cuenta'] == '1')
	{
		$consulta_saldo = "select saldo from cx_sal_uni where unidad = '".$uni_usuario."' and ano = '".$ano."' and periodo = '".$periodo."'";
		$cur_saldo = odbc_exec($conexion,$consulta_saldo);
		$saldo_ant = odbc_result($cur_saldo,1);		

		if ($uni_usuario == '1')
		{
			$consulta_cta = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
			$cur_cta = odbc_exec($conexion,$consulta_cta);
			$nom_cta = 'GASTOS';
			$cta = trim(odbc_result($cur_cta,11));
			$pdf->Cell(50,5,'CUENTA: ',0,0,'R');
			$pdf->Cell(40,5,$nom_cta.' - '.$cta,B,1,'C');
		}
		else $pdf->Cell(50,5,'',0,1,'R');
	}
	else
	{
		$consulta_cta = "select * from cx_ctr_cue where conse ='".$_GET['cuenta']."'";
		$cur_cta = odbc_exec($conexion,$consulta_cta);
		if (odbc_num_rows($cur_cta) != 0)
		{
			$nom_cta = trim(odbc_result($cur_cta,5));
			//$saldo_ant = trim(odbc_result($cur_cta,7));
			$cta = trim(odbc_result($cur_cta,6));
			$pdf->Cell(30,5,'CUENTA: ',0,0,'R');
			$pdf->Cell(40,5,$nom_cta.' - '.$cta,B,1,'C');
		}   //if
		else $pdf->Cell(20,5,$nom_cta.'',0,1,'C');
		
		$consulta_salc = "select * from cx_sal_cue where conse ='".$_GET['cuenta']."'";
		$cur_salc = odbc_exec($conexion,$consulta_salc);
		if (odbc_num_rows($cur_salc) == 0) $saldo_ant = 0;
		else $saldo_ant = odbc_result($cur_salc, 2);		
	}   //if
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+6,279,6,0,'DF');
	$pdf->Ln(6);
	$pdf->Cell(4,6,'No',0,0,'C');
	$pdf->Cell(10,6,'U.O.M',1,0,'C');
	$pdf->Cell(10,6,'BR',1,0,'C');	
	$pdf->Cell(10,6,'U.T',1,0,'C');
	$pdf->Cell(12,3,'Unidad/Dep',0,0,'C');	
	$pdf->Cell(13,6,'Fecha',1,0,'C');
	$pdf->Cell(14,6,'Comprobante',1,0,'C');
	$pdf->Cell(7,6,'No.',6,0,'C');
	$pdf->Cell(22,6,'Valor Ingreso',1,0,'C');
	$pdf->Cell(22,6,'Valor Egreso',1,0,'C');
	$pdf->Cell(22,6,'Saldo',1,0,'C');
	$pdf->Cell(44,6,'Concepto del Gasto',1,0,'C');
	$pdf->Cell(78,6,'Soporte',1,0,'C');
	$pdf->Cell(10,6,'recurso',1,0,'C');
	$pdf->Cell(2,3,'',0,1,'C');
	$pdf->Cell(80,3,'emp recurso',0,1,'C');
	$pdf->SetFont('Arial','',5.5);
	$pdf->Cell(124,3,'SALDO ANTERIOR',0,0,'L');
	$pdf->Cell(22,3,wims_currency($saldo_ant),1,1,'R');
	$saldo = $saldo_ant;

	$consulta_sub1 = "select top(1) * from cx_org_sub where unidad='".$unidad."'";
	$cur_sub1 = odbc_exec($conexion,$consulta_sub1);
	$dependencia1 = trim(odbc_result($cur_sub1,2));
	$nom_uni_br1 = trim(odbc_result($cur_sub1,4));
	$ut = trim(odbc_result($cur_sub1,4));

	$consulta_uni = "select * from cv_unidades where sigla = '".$ut."'";
	$cur_uni = odbc_exec($conexion,$consulta_uni);
	$n_brigada_uni = trim(odbc_result($cur_uni,4));
	$bbrr =  trim(odbc_result($cur_uni,6));
	
	$lin=9;	
	$jj = 1;
	$saldo = $saldo_ant;
	$v_ingreso = 0;
	$v_egreso = 0;
	$t_ingreso = 0;
	$t_egreso = 0;
	$t_saldo = 0;

	$consulta_libban = "select * from cv_lib_ban where unidad = '".$uni_usuario."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and cuenta = '".$_GET['cuenta']."' order by fecha, comprobante, tipo1";
	$cur_libban = odbc_exec($conexion,$consulta_libban);
	$K = 1;
	while($k<$row=odbc_fetch_array($cur_libban))
	{	
		$actual=$pdf->GetY();	
		$tipo1 = odbc_result($cur_libban,10);
		if ($tipo1 == 1)   //Ingresos
		{
			$consulta_soporte = "select * from cx_com_ing where ingreso = '".odbc_result($cur_libban,1)."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_soporte = odbc_exec($conexion,$consulta_soporte);
			$k1 = 0;
			while($k1<$row=odbc_fetch_array($cur_soporte))
			{	
				$concepto = odbc_result($cur_soporte,10);
				$soporte = $n_soportes[odbc_result($cur_soporte,13)-1].' - '.trim(odbc_result($cur_soporte,14));
				$v_ingreso = substr(str_replace(',','',trim(odbc_result($cur_soporte,9))),0);
				$v_egreso = 0;
				$t_ingreso = $t_ingreso + $v_ingreso;
				$n_comp = trim(odbc_result($cur_libban,1));
				$recurso = trim(odbc_result($cur_libban,16));
				$recurso = $n_recursos[$recurso-1];
				$v_saldo = $saldo + $v_ingreso - $v_egreso;
				$nom_concepto= ucwords(strtolower(trim(odbc_result($cur_libban,8))));
				if ($unic_unibr == 1)
				{
					$n_brigada_uni = $ut = "";
					$bbrr = $nom_uni_br;
				}   //if
				
				$pdf->RoundedRect(9,$actual,5,3,0,'');		
				$pdf->Cell(4,3,$jj,0,0,'C');                               			//No.
				$pdf->Cell(10,3,$nom_uni_br,1,0,'C');                        		//U.O.M.  
				$pdf->Cell(10,3,$n_brigada_uni,1,0,'C');  							//BR
				$pdf->Cell(10,3,$ut,1,0,'C');							  			//UT
				$pdf->Cell(12,3,$bbrr,1,0,'C');   									//Dependencia
				$pdf->Cell(13,3,substr(odbc_result($cur_libban,2),0,10),1,0,'C');   //Fecha
				$pdf->Cell(14,3,'INGRESO',1,0,'C');									//Comprobante
				$pdf->Cell(7,3,$n_comp,1,0,'C');						 			//No.
				$pdf->Cell(22,3,wims_currency($v_ingreso),1,0,'R');					//Valor Ingreso
				$pdf->Cell(22,3,wims_currency($v_egreso),1,0,'R'); 					//Valor Ingreso
				$pdf->Cell(22,3,wims_currency($v_saldo),1,0,'R');					//saldo
				$pdf->Cell(44,3,$nom_concepto,1,0,'C');  							//concepto del gasto
				$pdf->Cell(78,3,trim($soporte),1,0,'L');							//soporte
				$pdf->Cell(10,3,trim($recurso),1,1,'C');							//recurso
				$saldo = $v_saldo;
				$k1++;
			}
			$jj++;
		}
		else   //($tipo1 == 2) Egresos
		{
			$recurso = trim(odbc_result($cur_libban,16));
			$recurso = $n_recursos[$recurso-1];

			$consulta_soporte = "select * from cx_com_egr where egreso = '".odbc_result($cur_libban,1)."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_soporte = odbc_exec($conexion,$consulta_soporte);
			$concepto = trim(odbc_result($cur_soporte,21));
			$tpgasto = trim(odbc_result($cur_soporte,22));
			$sop =  trim(odbc_result($cur_soporte,27));
			$n_sop =  trim(odbc_result($cur_soporte,28));

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

				$consulta_sub2 = "select * from cx_org_sub where sigla = '".$dep."'";
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

				if ($unic_unibr <> 1 and $bbrr <> $nom_uni_br1) $nom_uni_br1 = $bbrr;
				if ($bbrr == 'BRIMI1' || $bbrr == 'BRIMI2') $nom_uni_br1 = 'CAIMI';
				if ($bbrr == 'BRCIM1' || $bbrr == 'BRCIM2') $nom_uni_br1 = 'CACIM';
				if ($bbrr == $nom_uni_br1) $bbrr = "";			

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
					if ($c_sdepen < 6) $utl = "";
					else $ut1 = trim($d_datos1[0]);
					$dep = trim($d_datos1[0]);
					break;
				case 1:
					$ut = trim($d_datos1[0]);
					$ut1 = "";
					break;
				case 2:
					$bbrr = $dep;
					$ut1 = "";
					break;
				}  //switch

				$consulta_iaut = "select * from cx_inf_aut where unidad1 = '".$c_sdepen."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
				$cur_iaut = odbc_exec($conexion,$consulta_iaut);
				$aut = trim(odbc_result($cur_iaut,1));

				$consulta_csop = "select * from cx_ctr_sop where conse = '".$sop."'";
				$cur_csop = odbc_exec($conexion,$consulta_csop);

				if ($sop == '12') $soporte = trim(odbc_result($cur_csop,2)).' - '.$aut;
				else $soporte = trim(odbc_result($cur_csop,2)).' - '.$n_sop;
				$v_egreso = substr(str_replace(',','',trim($d_datos1[1])),0);   //,-3
				$v_saldo = $saldo + $v_ingreso - $v_egreso;

				if ($v_ingreso <> 0 || $v_egreso <> 0)
				{
					$actual=$pdf->GetY();	
					$pdf->RoundedRect(9,$actual,5,3,0,'');	
					$pdf->Cell(4,3,$jj,0,0,'C');										//No.
					$pdf->Cell(10,3,$nom_uni_br1,1,0,'C');                     			//U.O.M.  
					$pdf->Cell(10,3,$bbrr,1,0,'C');  							 		//BR   
					$pdf->Cell(10,3,$ut1,1,0,'C');										//UT
					$pdf->Cell(12,3,$dep,1,0,'C');										//unidad depend. empleo el recurso
					$pdf->Cell(13,3,substr(odbc_result($cur_libban,2),0,10),1,0,'C');	//Fecha
					$pdf->Cell(14,3,'EGRESO',1,0,'C');  								//comprobante
					$pdf->Cell(7,3,trim(odbc_result($cur_libban,1)),1,0,'C');  			//número comprobante
					$pdf->Cell(22,3,wims_currency($v_ingreso),1,0,'R');  				//Valor ingreso
					$pdf->Cell(22,3,wims_currency($v_egreso),1,0,'R');  				//vlr egreso
					$pdf->Cell(22,3,wims_currency($v_saldo),1,0,'R');					//saldo
					$pdf->Cell(44,3,$nom_concepto,1,0,'C');								//concepto del gasto
					$pdf->Cell(78,3,trim($soporte),1,0,'L');							//soporte
					$pdf->Cell(10,3,trim($recurso),1,1,'C');							//recurso
					$saldo = $v_saldo;
					$jj++;
				}  //if
				$t_egreso = $t_egreso + $v_egreso;
				$v_egreso = 0; 
			} //for
		}  //if
		$k++;
		control_salto_pag($pdf->GetY());
	} //while

	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,279,3,0,'DF');
	$pdf->Cell(80,3,'TOTALES',0,0,'R');		
	$pdf->Cell(22,3,wims_currency($t_ingreso),1,0,'R');
	$pdf->Cell(22,3,wims_currency($t_egreso),1,0,'R');
	$pdf->Cell(22,3,wims_currency($saldo_ant + $t_ingreso - $t_egreso),1,0,'R');
	$pdf->SetFont('Arial','',6);
	
	control_salto_pag($pdf->GetY());
	if ($ajuste > 0) $pdf->Ln($ajuste);		
	$pdf->Ln(25);
	$pdf->Cell(90,15,'',0,1,'C');

	$n_ejecuto = utf8_decode(strtr(trim($_GET["firma1"]), $sustituye));
	$c_ejecuto = utf8_decode(strtr(trim($_GET["cargo1"]), $sustituye));
	$n_autorizo = utf8_decode(strtr(trim($_GET["firma2"]), $sustituye));
	$c_autorizo = utf8_decode(strtr(trim($_GET["cargo2"]), $sustituye));
	$n_VoBo = utf8_decode(strtr(trim($_GET["firma3"]), $sustituye));
	$c_VoBo = utf8_decode(strtr(trim($_GET["cargo3"]), $sustituye));
	$pdf->Ln(5);
	
	//Busca imagen de la firma Ejecutó
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_ejecuto."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,45,$actual-20,$w,30),0,0,'C');

	//Busca imagen de la firma Ejecutó
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_autorizo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	$pdf->Cell(95,5,$pdf->Image($file,135,$actual-20,$w,30),0,0,'C');

	//Busca imagen de la firma Ejecutó
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_VoBo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,225,$actual-20,$w,30),0,0,'C');
	
	$pdf->Ln(4);
	$pdf->Cell(90,5,'_______________________________________________________',0,0,'C');
	$pdf->Cell(90,5,'_______________________________________________________',0,0,'C');
	$pdf->Cell(90,5,'_______________________________________________________',0,1,'C');
	$pdf->Cell(90,3,$n_ejecuto,0,0,'C');
	$pdf->Cell(90,3,$n_autorizo,0,0,'C');
	$pdf->Cell(90,3,$n_VoBo,0,1,'C');
	$pdf->Cell(90,3,$c_ejecuto,0,0,'C');
	$pdf->Cell(90,3,$c_autorizo,0,0,'C');	
	$pdf->Cell(90,3,$c_VoBo,0,1,'C');
		
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Cell(278,3,$linea,0,1,'C');	
	$pdf->Multicell(278,3,$texto,0,'J');
	$pdf->Cell(278,3,$linea,0,1,'C');	
	$pdf->Cell(15,3,'Elaboró:    '.strtr(trim($nom_usuario), $sustituye),0,1,'');
	$pdf->Cell(278,3,$linea,0,1,'C');	

	$nom_pdf="../fpdf/pdf/InfDetCom_".$uni_usuario."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	
	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}   //if
?>
