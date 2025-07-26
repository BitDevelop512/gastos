<?php
/* 634.php (lib_aux_bco.php)
   FO-JEMPP-CEDE2-634- Libro Auxiliar de Bancos.
   (pág 209 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(278,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(205,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(75,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(130,5,'LIBRO AUXILIAR',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-634',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(86,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(119,5,'BANCOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(132,5,'',0,0,'C');
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
/*
			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(55,200,$sig_usuario,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(125,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'LIBRO AUXILIAR',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-634',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'BANCOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2018-07-10',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(125,3,'CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,91,26,0,'');
			$this->RoundedRect(100,15,50,26,0,'');
			$this->RoundedRect(150,15,51,26,0,'');
			$this->RoundedRect(9,15,192,268,0,'');
*/
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
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//function Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');

	function control_salto_pag($actual1)
	{
		global $pdf;
		$hecho = 0;
		$actual1=$actual1+5;
		if ($actual1>=176.00125)  //219.00125
		{
			$pdf->addpage();
			$hecho = 1;
		}
		return $hecho;
	} //control_salto_pag	

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);
	$linea = str_repeat("_",177);

	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú','Ã“' => 'Ó','ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â' => 'Í', 'Ã­' => 'í', 'Ã'  => 'Á');
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_soportes = array('ACTA PAGO DE INFORMACION','ACTA PAGO DE RECOMPENSA','ORDOP','MISION DE TRABAJO DE INTELIGENCIA O CONTRAINT.','FACTURA','CONTRATO','TRANSACCIONES NET CASH','CHEQUE','FORMULARIO DIAN');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$ajuste = $_GET['ajuste'];

	$consulta_nit = "select nit from cx_org_sub where subdependencia = '".$uni_usuario."' and sigla = '".$sig_usuario."'";
	$cur_nit = odbc_exec($conexion,$consulta_nit);
	$nit = odbc_result($cur_nit,1);
	if ($nit == "") $nit = "90025707-8";

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual-3,279,22,0,'');		
	$pdf->Cell(40,5,'Unidad Centralizadora',0,0,'');
	$pdf->Cell(110,5,$_SESSION["sig_usuario"],B,0,''); 
	$pdf->Cell(125,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(40,5,'Número NIT:',0,0,'');
	$pdf->Cell(149,5,$nit,B,1,'');
	
	$pdf->Cell(40,5,'Periodo del informe del:',0,0,'');
	$pdf->Cell(15,5,'1',B,0,'C');
	$pdf->Cell(20,5,'      Hasta',0,0,'');
	$pdf->Cell(20,5,days_in_month($_GET['periodo'], $_GET['ano']),B,0,'C');
	$pdf->Cell(30,5,' de '.$n_meses[$_GET['periodo'] - 1].' de '.$_GET['ano'],0,10,'C');
	
	$pdf->SetFont('Arial','',7);
	$actual=$pdf->GetY();
	$pdf->Ln(4);
	$pdf->RoundedRect(9,$actual+4,25,15,0,'DF');	
	$pdf->RoundedRect(34,$actual+4,20,15,0,'DF');
	$pdf->RoundedRect(54,$actual+4,46,15,0,'DF');		
	$pdf->RoundedRect(100,$actual+4,53,15,0,'DF');	
	$pdf->RoundedRect(153,$actual+4,45,15,0,'DF');
	$pdf->RoundedRect(198,$actual+4,45,15,0,'DF');	
	$pdf->RoundedRect(243,$actual+4,45,15,0,'DF');	
	$pdf->Cell(25,5,'NUMERO',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(46,5,'NUMERO',0,0,'C');
	$pdf->Cell(53,5,'',0,0,'C');
	$pdf->Cell(45,5,'',0,0,'C');
	$pdf->Cell(45,5,'',0,0,'C');
	$pdf->Cell(45,5,'',0,1,'C');
	$pdf->Cell(25,5,'COMPROBANTE',0,0,'C');
	$pdf->Cell(20,5,'FECHA',0,0,'C');
	$pdf->Cell(46,5,'CHEQUE/',0,0,'C');
	$pdf->Cell(53,5,'CONCEPTO',0,0,'C');
	$pdf->Cell(45,5,'DEBITO',0,0,'C');
	$pdf->Cell(45,5,'CRÉDITO',0,0,'C');
	$pdf->Cell(45,5,'SALDO',0,1,'C');
	$pdf->Cell(25,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');	
	$pdf->Cell(46,5,'CONSIGNACIÓN',0,0,'C');
	$pdf->Cell(53,5,'',0,0,'C');	
	$pdf->Cell(45,5,'',0,0,'C');
	$pdf->Cell(45,5,'',0,0,'C');
	$pdf->Cell(45,5,'',0,1,'C');

	$periodo = $_GET['periodo'];
	$ano = $_GET['ano'];
	if ($periodo == 1)
	{
		$periodo = 12;
		$ano = $ano - 1;
	}
	else $periodo = $periodo - 1;
	$consulta_saluni = "select * from cx_sal_uni where periodo = '".$periodo."' and ano = '".$ano."' and unidad = '".$uni_usuario."' order by fecha";
	$cur_saluni = odbc_exec($conexion,$consulta_saluni);
	if (odbc_num_rows($cur_saluni) == 0) $saldo_ant = 0;
	else $saldo_ant = odbc_result($cur_saluni, 6);
	
	$pdf->RoundedRect(9,$actual+19,234,5,0,'');	
	$pdf->Cell(234,5,'SALDO ANTERIOR',0,0,'L');
	$pdf->SetFont('Arial','',8);	
	$pdf->RoundedRect(243,$actual+19,45,5,0,'');	
	$pdf->Cell(45,5,'$'.number_format($saldo_ant,2),0,1,'R');

	$consulta_libban = "select * from cv_lib_ban where periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and unidad = '".$uni_usuario."' order by fecha"; 
	$cur_libban = odbc_exec($conexion,$consulta_libban);

	$t_debito = 0;
	$t_credito = 0;
	$t_saldo = 0;	
	$saldo = $saldo_ant;
	$lin = 24;
	$i=1;
	
	while($i<=$row=odbc_fetch_array($cur_libban))
	{
		$consulta_soporte = "select * from cx_com_egr where egreso = '".odbc_result($cur_libban,1)."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."' order by egreso";
		$cur_soporte = odbc_exec($conexion,$consulta_soporte);
		$unidad_centralizadora = odbc_result($cur_soporte,4);
		$soporte = $n_soportes1[odbc_result($cur_soporte,27)-1].' - '.odbc_result($cur_soporte,30);
		$tpgasto = trim(odbc_result($cur_soporte,22));
		$concepto = odbc_result($cur_soporte,21);

		$consulta_gas = "Select * from cx_ctr_gas where codigo ='".$concepto."'";
		$cur_gas = odbc_exec($conexion,$consulta_gas);
		$n_concepto = odbc_result($cur_gas,2);

		if ($unidad_centralizadora == 1)
		{
			if ($concepto == '7' and $tpgasto == '1') $nom_concepto = $n_concepto;
			elseif ($tpgasto == '1') $nom_concepto = "  Gastos en Actividades Inteligencia y C/I";
			else $nom_concepto = $n_concepto;
		}
		else
		{
//			$nom_concepto = "  Gastos en Actividades";     //cualquier valor que no este en la lista $tpgasto
			if ($tpgasto == '99' or $tpgasto == '8') $nom_concepto = "  Presupuesto Mensual";
			else if ($tpgasto == '1') $nom_concepto = "  Gastos en Actividades Inteligencia y C/I";   	
			else if ($tpgasto == '2') $nom_concepto = "  Pago de Información";
			else if ($tpgasto == '3') $nom_concepto = "  Pago de Recompensas";
			else if ($tpgasto == '') $nom_concepto = "  Pago de Información";			
		}	//if	
			
		$actual=$pdf->GetY(); 
		$pdf->RoundedRect(9,$actual,279,5,0,'');
		if (odbc_result($cur_libban, 10) == '1')
		{
			$compf = "I-".odbc_result($cur_libban,1);
			$conceptof = odbc_result($cur_libban,8);
		}
		else   //odbc_result($cur_libban, 10) == '2'
		{
			$compf = "E-".odbc_result($cur_libban,1);
			$conceptof = $nom_concepto;
		}  //if

		$debito = odbc_result($cur_libban,11);									
		$credito = odbc_result($cur_libban,12);									
		$t_debito = $t_debito + $debito;		
		$t_credito = $t_credito + $credito;
		$saldo = $saldo + $credito - $debito;
		
		$pdf->Cell(24,5,$compf,0,0,'C');								 		// campo Tipo1:   1=Ingreso, 2=Egreso
		$pdf->Cell(20,5,substr(odbc_result($cur_libban,2),0,10),1,0,'C');		//fecha
		$pdf->Cell(46,5,trim(odbc_result($cur_libban,9)),1,0,'C');				//numero cheque
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(53,5,$conceptof,1,0,'C'); 									//Concepto 
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(45,5,wims_currency($credito),1,0,'R');						//crédito   
		$pdf->Cell(45,5,wims_currency($debito),1,0,'R');						//debito
		$pdf->Cell(45,5,wims_currency($saldo),1,1,'R');							//Saldo

		control_salto_pag($pdf->GetY());
		$i++;
	} //while

	$pdf->Cell(143,5,'TOTALES',0,0,'R');
	$pdf->Cell(45,5,wims_currency($t_credito),1,0,'R');	
	$pdf->Cell(45,5,wims_currency($t_debito),1,0,'R');
	$pdf->Cell(45,5,wims_currency($saldo),1,1,'R');

	if ($sig_usuario == 'DIADI' || $sig_usuario == 'CEDE2')
	{
		$ela = 15;
		$rev = 16;
		$jem = 17;
		$cdo = 18;
	}	
	else
	{
		if ($sig_usuario == 'CACIM' || $sig_usuario == 'CAIMI')
		{
			$ela = 10;
			$rev = 19;
			$jem = 12;
			$cdo = 13;
		}
		else
		{
			if (substr($sig_usuario,0,2) == 'BR')
			{
				$ela = 31;
				$rev = 7;
				$jem = 8;
				$cdo = 9;
			} 
			else   //DIV y FUDRA
			{
				$ela = 10;
				$rev = 11;
				$jem = 12;
				$cdo = 13;
			}  //if
		}  //if
	}  //if
	
	if ($sig_usuario == 'DIADI' || $sig_usuario == 'CEDE2')
	{
		$consulta_usu = "select usuario, cargo, nombre from cx_usu_web where unidad in ('1','2') and admin in ('".$jem."', '".$cdo."', '".$ela."', '".$rev."') order by usuario desc";	
	}
	else
	{
		$consulta_usu = "select usuario, cargo, nombre from cx_usu_web where unidad = '".$uni_usuario."' and admin in ('".$jem."', '".$cdo."', '".$ela."', '".$rev."') order by usuario desc";
	}  //if
	$cur_usu = odbc_exec($conexion,$consulta_usu);
	$x=0;
	$firma1 = trim($_GET['firma1']);
	$cargo1 = trim($_GET['cargo1']);
	$firma2 = trim($_GET['firma2']);
	$cargo2 = trim($_GET['cargo2']);
	$firma3 = trim($_GET['firma3']);
	$cargo3 = trim($_GET['cargo3']);

    while($x<$row=odbc_fetch_array($cur_usu))
    {
		if ($x == 0) $elaboro = trim(odbc_result($cur_usu,3));
		if ($x == 1)
		{
			if ($firma1 <> "")
			{
				$reviso = $firma1;
				$c_reviso = $cargo1; 
			}
			else
			{
				$reviso = trim(odbc_result($cur_usu,3));
				$c_reviso = trim(odbc_result($cur_usu,2)); 
			}  //if
		}  //if

		if ($sig_usuario == 'DIADI' || $sig_usuario == 'CEDE2')
		{		

			if ($x == 2)
			{
				if ($firma3 <> "")
				{
					$cdo = $firma3;
					$c_cdo = $cargo3;
				}
				else
				{	
					$cdo = trim(odbc_result($cur_usu,3));
					$c_cdo = trim(odbc_result($cur_usu,2));
				}
			}   //if
			if ($x == 3)
			{
				if ($firma2 <> "")
				{
					$jem = $firma2;
					$c_jem = $cargo2;
				}
				else
				{
					$jem = trim(odbc_result($cur_usu,3));
					$c_jem = trim(odbc_result($cur_usu,2));
				}
			}  //if
		}
		else
		{
			if ($x == 2)
			{
				if ($firma2 <> "")
				{
					$jem = $firma2;
					$c_jem = $cargo2;
				}
				else
				{	
					$jem = trim(odbc_result($cur_usu,3));
					$c_jem = trim(odbc_result($cur_usu,2));
				}
			}  //if
			if ($x == 3)
			{
				if ($firma3 <> "")
				{
					$cdo = $firma3;
					$c_cdo = $cargo3;
				}
				else
				{	
					$cdo = trim(odbc_result($cur_usu,3));
					$c_cdo = trim(odbc_result($cur_usu,2));
				}
			}  //if
		}   //if 
		$x++;
	}   //while
	
	$actual=$pdf->GetY();
	$pdf->Cell(278,3,$linea,0,1,'C');		
	$pdf->Ln(15);
	$pdf->Cell(139,5,strtr(utf8_decode($reviso), $sustituye),0,0,'C');
	$pdf->Cell(139,5,strtr(utf8_decode($jem), $sustituye),0,1,'C');
	$pdf->SetFont('Arial','',7);	
	$pdf->Cell(139,5,strtr(utf8_decode($c_reviso), $sustituye),0,0,'C');
	$pdf->Cell(139,5,strtr(utf8_decode($c_jem), $sustituye),0,1,'C');
	$pdf->SetFont('Arial','',8);
		
	if (control_salto_pag($pdf->GetY()) == 1) $lin = 0;
	else $lin = 4;
	if ($ajuste > 0) $pdf->Ln($ajuste);	
	$pdf->Ln(13);	
	$pdf->Cell(278,5,strtr(utf8_decode($cdo), $sustituye),0,1,'C');
	$pdf->SetFont('Arial','',7);	
	$pdf->Cell(278,5,strtr(utf8_decode($c_cdo), $sustituye),0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(278,3,$linea,0,1,'C');	
	
	if (control_salto_pag($pdf->GetY()) == 1) $lin = 0;
	else $lin = 4;
	$pdf->Ln(1);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(278,3,$texto,0,'J');

	$pdf->Cell(278,3,$linea,0,1,'C');	
	$pdf->Ln(1);	
	$pdf->Cell(15,3,'Elaboró:',0,0,'');
	$pdf->Cell(35,3,strtr(utf8_decode($elaboro), $sustituye),0,1,'L');  
	$pdf->Cell(278,3,$linea,0,1,'C');	

	$nom_pdf="../fpdf/pdf/InfGiro_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
