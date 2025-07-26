<?php
/* 624.php
   FO-JEMPP-CEDE2-624 - Comprobante de Egresos.
   (pág 158 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$this->RotatedText(55,200,$sig_usuario,35);

			$egreso = $_GET['egreso'];
			$ano = $_GET['ano'];
			$consulta = "select * from cx_com_egr where egreso='$egreso' and ano='$ano' and unidad='".$_SESSION["uni_usuario"]."'";
			$cur = odbc_exec($conexion,$consulta);
			$estado_egr = odbc_result($cur,8);
			if ($estado_egr == "A")
			{
				$this->SetFont('Arial','B',100);
				$this->SetTextColor(150,150,150);			
				$this->RotatedText(30,100,'ANULADO',-35);
			}

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
			$this->Cell(55,5,'COMPROBANTE DE',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-624',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'EGRESOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'4',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(125,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
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
			$fecha1="";
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

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');

	$sustituye = array ('Ã¡' => 'á', 'Ãº' => 'ú','Ã“' => 'Ó','ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â' => 'Í', 'Ã­' => 'í', 'Ã' => 'Á');
	$n_bancos = array ('BBVA', 'AV VILLAS', 'DAVIVIENDA', 'BANCOLOMBIA', 'BANCO DE BOGOTA','POPULAR');
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO','ABONO EN CUENTA');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$autoriza_pag = array('INFORME DE AUTORIZACION','SOLICITUD RECURSOS','PLAN DE NECESIDADES','PLAN DE INVERSIÓN','ACTO ADM AUTORIZACIÓN RECURSO CEDE2','ACTO ADMINISTRATIVO DE RECURSOS ADICIONALES','CONTRATO','SOLICITUD TRASPASO CUENTA','RADIOGRAMA CEDE2','RECIBO OFICIAL DE PAGO IMPUESTOS NACIONALES');
	$linea = str_repeat("_",122);
	$egreso = $_GET['egreso'];
	$ano = $_GET['ano'];

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=198.00125) $pdf->addpage();
	} //control_salto_pag

	$consulta = "select * from cx_com_egr where egreso='$egreso' and ano='$ano' and unidad='$uni_usuario'";
	$cur = odbc_exec($conexion,$consulta);
	$fechacomp = substr(odbc_result($cur,2),0,10);
	$usuario = trim(odbc_result($cur,3));
	$unidad_centralizadora = odbc_result($cur,4);
	$mes = odbc_result($cur,5);
	$estado_egr = odbc_result($cur,8);
	$concepto = odbc_result($cur,21);
	$tpgasto = odbc_result($cur,22);
	$recurso = odbc_result($cur,23);
	$rubro = $n_rubros[odbc_result($cur,24)-1];
	$soporte = odbc_result($cur,27);
	$auto_num = trim(odbc_result($cur,25)) - 1;	
	$autoriza1 = $autoriza_pag[$auto_num];
	$num_autoriza = trim(odbc_result($cur,26));
	$cash = odbc_result($cur,30);

	$consulta_gas = "Select * from cx_ctr_gas where codigo ='".$concepto."'";
	$cur_gas = odbc_exec($conexion,$consulta_gas);
	$n_concepto = odbc_result($cur_gas,2);
	
	$consulta_sop = "select * from cx_ctr_sop where conse = '".$soporte."'";
	$cur_sop = odbc_exec($conexion,$consulta_sop);
	$n_soporte= odbc_result($cur_sop,2);

	$consulta_infg = "select top(1) crp, cdp, unidad from cx_inf_gir where cash = '".$cash."'";
	$cur_infg = odbc_exec($conexion,$consulta_infg);
	$crp = trim(odbc_result($cur_infg,1));
	$cdp = trim(odbc_result($cur_infg,2));
	$unidad1 = odbc_result($cur_infg,3);

	if ($unidad_centralizadora  != 1)
	{
		$n_cdp = "N/A";
		$fecha_cdp = "N/A";
		$n_crp = "N/A";
		$fecha_crp = "N/A";
	}
	else
	{
		if ($usu_usuario == 'STE_DIADI')
		{
			$cdp = trim(odbc_result($cur,39));
			$crp = trim(odbc_result($cur,40));
		}
		
		$consulta_cdp = "select numero, fecha1 from cx_cdp where conse = '".$cdp."'";
		$cur_cdp = odbc_exec($conexion,$consulta_cdp);
		$n_cdp = odbc_result($cur_cdp,1);
		$fecha_cdp = odbc_result($cur_cdp,2);

		$consulta_crp = "select numero, fecha1 from cx_crp where conse = '".$crp."'";
		$cur_crp = odbc_exec($conexion,$consulta_crp);
		$n_crp = odbc_result($cur_crp,1);
		$fecha_crp = odbc_result($cur_crp,2);
	}   //if
	
	$recurso = $n_recursos[$recurso-1];
	$num_sopo = trim(odbc_result($cur,28));
	$subtotal = "$ ".number_format(trim(odbc_result($cur,10)),2);
	$iva = "$ ".number_format(trim(odbc_result($cur,11)),2);
	$total = "$ ".number_format(trim(odbc_result($cur,12)),2);
	$rete_fuente = "$ ".number_format(trim(odbc_result($cur,13)),2);
	$rete_ica = "$ ".number_format(trim(odbc_result($cur,14)),2);
	$rete_iva = "$ ".number_format(trim(odbc_result($cur,15)),2);
	$piva = " %".number_format(odbc_result($cur,17) * 100, 2, ",", ".");
	$pfuente = " %".number_format(odbc_result($cur,18) * 100, 2, ",", ".");
	$pica = " %".number_format(odbc_result($cur,19) * 100, 2, ",", ".");
	$val_neto = odbc_result($cur,16);
	$val_neto1 = "$ ".number_format(trim($val_neto),2);
	$total_retensiones = "$ ".number_format($rete_fuente + $rete_ica + $rete_iva,2);

	//if (odbc_result($cur,29) == 1) $pago = "Cash";
	//if (odbc_result($cur,29) == 2) $pago = "Cheque";	
	$pago = odbc_result($cur,30); 
	$datos = trim(decrypt1(odbc_result($cur,31), $llave));
	$transferencia = $n_transacciones[odbc_result($cur,16)-1];

	$firmas = trim(decrypt1(odbc_result($cur,32), $llave));
	$num_firmas = explode("|",$firmas);
	for ($i=0;$i<count($num_firmas);++$i)
	{
		$fir[$i] = $num_firmas[$i];
	}   //if

	$ejecuto = explode("»",$fir[0]);
	$autorizo = explode("»",$fir[1]);
	$vobo = explode("»",$fir[2]);
	$elaboro = explode("»",$fir[3]);
	$ejecuto[0] = substr($ejecuto[0], 0, strlen($ejecuto[0])-1);
	$autorizo[0]= substr($autorizo[0], 0, strlen($autorizo[0])-1);
	$vobo[0] = substr($vobo[0], 0, strlen($vobo[0])-1);
	$elaboro[0] = substr($elaboro[0], 0, strlen($elaboro[0])-1);
	$ciudad = odbc_result($cur,35);

	$consulta1 = "select * from Cx_org_sub where subdependencia = '".$unidad_centralizadora."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$n_unidadcen = odbc_result($cur1,6);
	$sigla = odbc_result($cur1,4);
	$ciudad1 = odbc_result($cur1,5);
	$banco = $n_bancos[odbc_result($cur1,10)-1];
	$cuenta = odbc_result($cur1,11);

	$consulta_plainv = "select actual from cx_pla_inv where conse = '".$num_autoriza."'";
	$cur_plainv = odbc_exec($conexion,$consulta_plainv);
	$concepto1 = odbc_result($cur_plainv,1);

	if ($concepto == '6' and $tpgasto == '1') $nom_concepto = "  PAGO DE IMPUESTOS";
	else if ($concepto == '7' and $tpgasto == '1') $nom_concepto = "  REINTEGROS DTN";
	else if ($concepto == '8' and $tpgasto == '1') $nom_concepto = "  GASTOS EN ACTIVIDADES INTELIGENCIA Y C/I";
	else if ($concepto == '8' and $tpgasto == '99') $nom_concepto = "  PRESUPUESTO MENSUAL";
	else if ($concepto == '9' and $tpgasto == '2') $nom_concepto = "  PAGO DE INFORMACIÓN";
	else if ($concepto == '9' and $tpgasto == '99') $nom_concepto = "  PRESUPUESTO ADICIONAL";
	else if ($concepto == '10' and $tpgasto == '99') $nom_concepto = "  PRESUPUESTO RECOMPENSAS";
	else if ($concepto == '18') $nom_concepto = "  DEVOLUCIONES A CEDE2";
	else if ($tpgasto == '0') $nom_concepto = "  DEVOLUCIONES A CEDE2";
	else if ($tpgasto == '1') $nom_concepto = "  GASTOS EN ACTIVIDADES INTELIGENCIA Y C/I";
	else if ($tpgasto == '2') $nom_concepto = "  PAGO DE INFORMACIÓN";
	else if ($tpgasto == '3') $nom_concepto = "  PAGO DE RECOMPENSAS";
    else if ($tpgasto == '4') $nom_concepto = "  GASTOS DE PROTECCIÓN";
    else if ($tpgasto == '5') $nom_concepto = "  GASTOS DE COBERTURA";	
	else $nom_concepto = $n_concepto;

/*
	if ($unidad_centralizadora == 1)
	{
		if ($concepto == '6' and $tpgasto == '1') $nom_concepto = "  PAGO DE IMPUESTOS";
		else if ($concepto == '7' and $tpgasto == '1') $nom_concepto = "  REINTEGROS DTN";
		else if ($concepto == '8' and $tpgasto == '1') $nom_concepto = "  GASTOS EN ACTIVIDADES INTELIGENCIA Y C/I";
		else if ($concepto == '8' and $tpgasto == '99') $nom_concepto = "  PRESUPUESTO MENSUAL";
		else if ($concepto == '9' and $tpgasto == '2') $nom_concepto = "  PAGO DE INFORMACIÓN";
		else if ($concepto == '9' and $tpgasto == '99') $nom_concepto = "  PRESUPUESTO ADICIONAL";
		else if ($concepto == '10' and $tpgasto == '99') $nom_concepto = "  PRESUPUESTO RECOMPENSAS";
		else if ($concepto == '18') $nom_concepto = "  DEVOLUCIONES A CEDE2";
		else if ($tpgasto == '1') $nom_concepto = "  GASTOS EN ACTIVIDADES INTELIGENCIA Y C/I";
		else if ($tpgasto == '0') $nom_concepto = "  DEVOLUCIONES A CEDE2";
		else $nom_concepto = $n_concepto;
	}
	else
	{
		if ($tpgasto == '99' or $tpgasto == '8') $nom_concepto = "  PRESUPUESTO MENSUAL";
		else if ($tpgasto == '0') $nom_concepto = "  DEVOLUCIONES A CEDE2";
		else if ($tpgasto == '1') $nom_concepto = "  GASTOS EN ACTIVIDADES INTELIGENCIA Y C/I"; 
		else if ($concepto == '18') $nom_concepto = "  DEVOLUCIONES A CEDE2";  
		else if ($tpgasto == '2') $nom_concepto = "  PAGO DE INFORMACIÓN";
		else if ($tpgasto == '3') $nom_concepto = "  PAGO DE RECOMPENSAS";
        else if ($tpgasto == '4') $nom_concepto = "  GASTOS DE PROTECCIÓN";
        else if ($tpgasto == '5') $nom_concepto = "  GASTOS DE COBERTURA";
	}   //if
*/
	if ($concepto == 8)
	{
		$pagadoa = "INFORMACIÓN RESTRINGIDA";
		$id = "INF.  RESTRINGIDA";
	}
	else
	{	
		$pagadoa = "INFORMACIÓN RESTRINGIDA";
		$id = "INF. RESTRINGIDA";
	}	//if

	$recibio[0] = $pagadoa;
	$recibio[1] = "";

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual-3,192,22,0,'');
	$pdf->Ln(-1);	
	$pdf->Cell(40,5,'UNIDAD CENTRALIZADORA',0,0,'');
	$pdf->Cell(90,5,rtrim($n_unidadcen),B,0,'');
	$pdf->Cell(60,5,'DE USO EXCLUSIVO',0,1,'R');	
	$pdf->SetTextColor(0);
	$pdf->Cell(15,5,'LUGAR',0,0,'');
	$pdf->Cell(80,5,$ciudad,B,0,'');
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fechacomp,B,0,'C');
	$pdf->Cell(20,5,'EGRESO NR',0,0,'');
	$pdf->Cell(30,5,$_GET['egreso'],B,1,'C');
	$pdf->Cell(15,5,'BANCO',0,0,'');
	$pdf->Cell(100,5,$banco,B,0,'');
	$pdf->Cell(20,5,'CUENTA No.',0,0,'');
	$pdf->Cell(55,5,$cuenta,B,1,'');

	$pdf->Ln(5);
	$pdf->RoundedRect(9,$actual+19,192,5,0,'DF');
	$pdf->Cell(190,5,'DESCRIPCIÓN',0,0,'C');
	
	$pdf->Ln(7);	
	$pdf->Cell(32,5,'ART. PRESUPUESTAL',0,0,'');
	$pdf->Cell(32,5,$rubro,B,0,'');
	$pdf->Cell(18,5,'RECURSO',0,0,'');
	$pdf->Cell(28,5,$recurso,B,0,'');
	$pdf->Cell(10,5,'CDP',0,0,'');
	$pdf->Cell(25,5,$n_cdp,B,0,'C');
	$pdf->Cell(15,5,'FECHA',0,0,'');	
	$pdf->Cell(30,5,$fecha_cdp,B,1,'C');
	$pdf->Cell(7,5,'CRP',0,0,'');	
	$pdf->Cell(15,5,$n_crp,B,0,'C');
	$pdf->Cell(10,5,'FECHA',0,0,'');	
	$pdf->Cell(20,5,$fecha_crp,B,0,'C');
	$pdf->Cell(34,5,'CONCEPTO DEL GASTO',0,0,'');
	$pdf->Cell(75,5,$nom_concepto,B,0,'');
	$pdf->Cell(8,5,'MES',0,0,'');
	$pdf->Cell(22,5,$n_meses[$mes-1],B,1,'C');
	$pdf->Cell(18,5,'PAGADO A',0,0,'');
	$pdf->Cell(120,5,$pagadoa,B,0,'');
	$pdf->Cell(13,5,'NIT/CC',0,0,'');
	$pdf->Cell(40,5,$id,B,1,'');
	
	$pdf->Cell(28,5,'AUTORIZACIÓN',0,0,'');
	$pdf->Cell(162,5,$autoriza1,B,1,'');
	$pdf->Cell(10,5,'No.',0,0,'');
	$pdf->Multicell(180,5,$num_autoriza,B,'L');
	
	$pdf->Cell(17,5,'SOPORTE ',0,0,'');
	$pdf->Cell(173,5,$n_soporte,B,1,'');    
	$pdf->Cell(10,5,'No.',0,0,'');
	$pdf->Cell(180,5,$num_sopo,B,1,'');

	$pdf->Ln(6);
	$linn = 116;
	$pdf->RoundedRect(9,$linn,105,5,0,'');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(103,5,'DISTRIBUCIÓN UNIDADES / DEPENDENCIAS / SECCIONES',0,0,'C');

	$pdf->SetFont('Arial','',7);
	$linn = 121;		
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$pdf->Ln(5);
	$pdf->Cell(14,5,'Uni/Dep/Sec',0,0,'C');
	$pdf->Cell(20,5,'Valor',0,0,'C');
	$pdf->Cell(15,5,'Uni/Dep/Sec',0,0,'C');
	$pdf->Cell(21,5,'Valor',0,0,'C');
	$pdf->Cell(15,5,'Uni/Dep/Sec',0,0,'C');
	$pdf->Cell(20,5,'Valor',0,1,'C');

	$d_datos_wt = array(32);
	$d_datos_wt = explode("#",$datos);
	$c = count($d_datos_wt) - 1;	
	$d_datos = array(32);
	$ind = 0;
	for ($jj=0;$jj<=$c;$jj++)
	{
		$d_datos1 = explode("|",$d_datos_wt[$jj]);
		if ($d_datos1[1] > 0)
		{
			$d_datos[$ind] = $d_datos_wt[$jj];
			$ind++;
		}
	}
	$cc = count($d_datos_wt) - 1;	
	$pdf->SetFont('Arial','',6);	
	$linn = 126;		
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[0]);
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R'); 
	$d_datos1 = explode("|",$d_datos[1]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[2]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,1,'R');

	$pdf->SetFont('Arial','',6);
	$linn = 131;			
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[3]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[4]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[5]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,1,'R');

	$pdf->SetFont('Arial','',6);	
	$linn = 136;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[6]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[7]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[8]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,1,'R');

	$pdf->SetFont('Arial','',6);	
	$linn = 141;
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[9]);				
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[10]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[11]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,1,'R');

	$pdf->SetFont('Arial','',6);	
	$linn = 146;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');	
	$pdf->RoundedRect(95,$linn,19,5,0,'');	
	$d_datos1 = explode("|",$d_datos[12]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[13]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[14]);	
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,1,'R');

	$pdf->SetFont('Arial','',6);	
	$linn = 151;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[15]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[16]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[17]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	
	$pdf->SetFont('Arial','',8);			
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(22,5,'SUBTOTAL',0,0,'C');
	$pdf->Cell(38,5,$subtotal,1,1,'R');

	$pdf->SetFont('Arial','',6);	
	$linn = 156;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[18]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[19]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[20]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');

	$pdf->SetFont('Arial','',8);		
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(22,5,'IVA',0,0,'C');
	$pdf->Cell(38,5,$iva,1,1,'R');	

	$pdf->SetFont('Arial','',6);	
	$linn = 161;		
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[21]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[22]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[23]);			
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');

	$pdf->SetFont('Arial','',8);			
	$pdf->Cell(26,5,'',0,0,'L');
	$pdf->Cell(22,5,'TOTAL',0,0,'C');
	$pdf->Cell(38,5,$total,1,1,'R');

	$pdf->SetFont('Arial','',6);
	$linn = 166;			
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[24]);
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R'); 
	$d_datos1 = explode("|",$d_datos[25]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[26]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');

	$pdf->SetFont('Arial','',8);		
	$pdf->Cell(36,5,'   RETE FUENTE',0,0,'L');
	$pdf->Cell(12,5,$pfuente,1,0,'C');
	$pdf->Cell(38,5,$rete_fuente,1,1,'R');	

	$pdf->SetFont('Arial','',6);
	$linn = 171;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[27]);
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R'); 
	$d_datos1 = explode("|",$d_datos[28]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[29]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	
	$pdf->SetFont('Arial','',8);			
	$pdf->Cell(36,5,'   RETE ICA',0,0,'L');
	$pdf->Cell(12,5,$pica,1,0,'C');
	$pdf->Cell(38,5,$rete_ica,1,1,'R');

	$pdf->SetFont('Arial','',6);	
	$linn = 176;
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[30]);
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R'); 
	$d_datos1 = explode("|",$d_datos[31]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[32]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	
	$pdf->SetFont('Arial','',8);			
	$pdf->Cell(36,5,'   RETE IVA',0,0,'L');
	$pdf->Cell(12,5,$piva,1,0,'C');
	$pdf->Cell(38,5,$rete_iva,1,1,'R');

	$pdf->SetFont('Arial','',6);
	$linn = 181;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[33]);
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R'); 
	$d_datos1 = explode("|",$d_datos[34]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[35]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	
	$pdf->SetFont('Arial','',8);			
	$pdf->Cell(36,5,'   TOTAL RETENCIONES',0,0,'L');
	$pdf->Cell(12,5,'',0,0,'C');
	$pdf->Cell(38,5,$total_retensiones,1,1,'R');

	$pdf->SetFont('Arial','',6);
	$linn = 186;	
	$pdf->RoundedRect(9,$linn,16,5,0,'');
	$pdf->RoundedRect(25,$linn,19,5,0,'');
	$pdf->RoundedRect(44,$linn,16,5,0,'');
	$pdf->RoundedRect(60,$linn,19,5,0,'');
	$pdf->RoundedRect(79,$linn,16,5,0,'');
	$pdf->RoundedRect(95,$linn,19,5,0,'');
	$d_datos1 = explode("|",$d_datos[36]);
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R'); 
	$d_datos1 = explode("|",$d_datos[37]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
	$d_datos1 = explode("|",$d_datos[38]);		
	$pdf->Cell(16,5,$d_datos1[0],0,0,'');
	$pdf->Cell(19,5,"$".$d_datos1[1],0,0,'R');
		
	$pdf->SetFont('Arial','',8);			
	$pdf->Cell(34,5,'VALOR NETO',0,0,'R');
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(38,5,$val_neto1,1,1,'R');	
	$pdf->Cell(38,5,'',0,1,'R');	

	//$pdf->Ln(1);	
	$pdf->Cell(24,5,'CHEQUE/CASH',0,0,'');
	$pdf->Cell(24,5,$pago,B,1,'');
	$pdf->Cell(24,5,'SON',0,0,'');
	$valor_letras = num2letras($val_neto);	
	$pdf->Cell(166,5,$valor_letras,B,1,'');

	$pdf->Ln(3);	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+5,192,5,0,'');
	$pdf->Cell(190,5,'IMPUTACIÓN CONTABLE',0,1,'C');
		
	$pdf->RoundedRect(9,$actual+5,35,5,0,'');
	$pdf->Cell(34,5,'CODIGO CONTABLE',0,0,'C');
	$pdf->RoundedRect(44,$actual+5,61,5,0,'');
	$pdf->Cell(60,5,'CUENTA',0,0,'C');
	$pdf->RoundedRect(105,$actual+5,48,5,0,'');
	$pdf->Cell(48,5,'DEBE',0,0,'C');
	$pdf->RoundedRect(153,$actual+5,48,5,0,'');
	$pdf->Cell(48,5,'HABER',0,1,'C');

	if ($concepto == 14)
	{
		$cta_otros = '111005001';
		$cta_bancos = '111005004';
		$banco1 = 'BANCOS';
		$banco2 = 'BANCOS DTN';
	}
	else
	{
		$cta_otros = '2490550010';
		$cta_bancos = '111005001';
		$banco1 = 'OTROS AVANCES Y ANTICIPOS';
		$banco2 = 'BANCOS';
	}   //if

	$pdf->RoundedRect(9,$actual+10,35,5,0,'');
	$pdf->Cell(34,5,$cta_otros,0,0,'C');
	$pdf->RoundedRect(44,$actual+10,61,5,0,'');
	$pdf->Cell(61,5,$banco1,0,0,'');
	$pdf->RoundedRect(105,$actual+10,48,5,0,'');
	$pdf->Cell(48,5,$val_neto1,0,0,'R');
	$pdf->RoundedRect(153,$actual+10,48,5,0,'');
	$pdf->Cell(48,5,'',0,1,'R');

	$pdf->RoundedRect(9,$actual+15,35,5,0,'');
	$pdf->Cell(34,5,$cta_bancos,0,0,'C');
	$pdf->RoundedRect(44,$actual+15,61,5,0,'');
	$pdf->Cell(61,5,$banco2,0,0,'');
	$pdf->RoundedRect(105,$actual+15,48,5,0,'');
	$pdf->Cell(48,5,'',0,0,'R');
	$pdf->RoundedRect(153,$actual+15,48,5,0,'');
	$pdf->Cell(48,5,$val_neto1,0,1,'R');

	$pdf->Cell(95,5,'SUMAS IGUALES',0,0,'C');
	$pdf->RoundedRect(105,$actual+20,48,5,0,'');
	$pdf->Cell(48,5,$val_neto1,0,0,'R');
	$pdf->RoundedRect(153,$actual+20,48,5,0,'');
	$pdf->Cell(48,5,$val_neto1,0,1,'R');

	$pdf->RoundedRect(9,$actual+29,96,45,0,'');
	$pdf->Ln(4);
	$pdf->Cell(95,5,'',0,0,'L');
	$pdf->RoundedRect(105,$actual+29,96,45,0,'');
	$pdf->Cell(96,4,'Recibió',0,1,'L');
	$pdf->Ln(16);
		
	$n_ejecuto = strtr(trim($ejecuto[0]), $sustituye);
	$c_ejecuto = strtr(trim($ejecuto[1]), $sustituye);
	$n_recibio = strtr(trim($recibio[0]), $sustituye);
	$c_recibio = strtr(trim($recibio[1]), $sustituye);
	$n_autorizo = strtr(trim($autorizo[0]), $sustituye);
	$c_autorizo = strtr(trim($autorizo[1]), $sustituye);
	$n_vobo = strtr(trim($vobo[0]), $sustituye);
	$c_vobo = strtr(trim($vobo[1]), $sustituye);

	//Busca imagen de la firma Ejecutó
	//$n_ejecuto = "JAIME ALBERTO MORALES (CX)";
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
		$tamaño = getimagesize($file);
		if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	//$pdf->Cell(95,5,$pdf->Image($file,46,$actual-20,30,26),0,0,'C');

	//Busca imagen de la firma Recibió
	//$n_recibio = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_recibio."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_recibio = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_recibio);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	//$pdf->Cell(95,5,$pdf->Image($file,140,$actual-20,30,26),0,0,'C');
	
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',6.7);
	$pdf->Cell(95,4,'_____________________________________________',0,0,'C');
	$pdf->Cell(96,4,'_____________________________________________',0,1,'C');		
	$pdf->Cell(95,4,$n_ejecuto,0,0,'C');
	$pdf->Cell(96,4,$n_recibio,0,1,'C');	
	$pdf->Cell(95,4,$c_ejecuto,0,0,'C');
	$pdf->Cell(96,4,$c_recibio,0,1,'C');	

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,96,45,0,'');
	$pdf->Cell(95,4,'',0,0,'L');
	$pdf->RoundedRect(105,$actual,96,45,0,'');
	$pdf->Cell(96,4,'',0,1,'L');
	$pdf->Ln(17);
	
	//Busca imagen de la firma Autorizo
	//$n_autorizo = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_autorizo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_autorizo = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_autorizo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	//$pdf->Cell(95,5,$pdf->Image($file,46,$actual-20,30,26),0,0,'C');

	//Busca imagen de la firma VoBo
	//$n_vobo = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_vobo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_vobo = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_vobo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	//$pdf->Cell(95,5,$pdf->Image($file,140,$actual-20,30,26),0,0,'C');	
	
	$pdf->Ln(6);
	$pdf->Cell(95,4,'_____________________________________________',0,0,'C');
	$pdf->Cell(96,4,'_____________________________________________',0,1,'C');		
	$pdf->Cell(95,4,$n_autorizo,0,0,'C');
	$pdf->Cell(96,4,$n_vobo,0,1,'C');
	$pdf->Cell(95,4,$c_autorizo,0,0,'C');
	$pdf->Cell(96,4,$c_vobo,0,1,'C');

	$pdf->Ln(9);
	$pdf->SetFont('Arial','',7);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,3,$texto,0,'J');
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Ln(1);
	$pdf->Cell(50,3,'Elaboró:    '.strtr($elaboro[0], $sustituye),0,1,'');

	$nom_pdf="../fpdf/pdf/Comprobantes/".$_GET['ano']."/CompEgr_".trim($sig_usuario)."_".$_GET['egreso']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
