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
			$this->RotatedText(100,180,$sig_usuario,35);
		
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
			$this->Cell(87,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(116,5,'LIBRO AUXILIAR',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-634',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'DE BANCOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(132,5,'',0,0,'C');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2018-07-10',0,1,'');

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
		}//Header

		function RotatedText($x,$y,$txt,$angle)
		{
    		$this->Rotate($angle,$x,$y);
    		$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}//RotatedText

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
		}//RoundedRect

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc

		function morepagestable($datas, $lineheight=4)
		{
			$l = $this->lMargin-1;
			$startheight = $h = $this->GetY();
			$startpage = $currpage = $maxpage = $this->page;
			$pag_act = $this->page;
			$fullwidth = 0;
			foreach($this->tablewidths AS $width) $fullwidth += $width;
			foreach($datas AS $row => $data)
			{
				$this->page = $currpage;
				$this->Line($l,$h,$fullwidth+$l,$h);
				foreach($data AS $col => $txt)
				{
					$this->page = $currpage;
					$this->SetFont('Arial','',7);		
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 45) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
					else $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'C');
					$l += $this->tablewidths[$col];
					
					if(!isset($tmpheight[$row.'-'.$this->page])) $tmpheight[$row.'-'.$this->page] = 0;
					if($tmpheight[$row.'-'.$this->page] < $this->GetY()) $tmpheight[$row.'-'.$this->page] = $this->GetY();
					if($this->page > $maxpage) $maxpage = $this->page;
				}   //for
				$h = $tmpheight[$row.'-'.$maxpage];
				$l = $this->lMargin-1;
				$currpage = $maxpage;
			}   //for
			$this->page = $maxpage;
			$this->Line($l,$h,$fullwidth+$l,$h);
			
			for($i = $startpage; $i <= $maxpage; $i++)
			{
				$this->page = $i;
				$l = $this->lMargin-1;
				$t  = ($i == $startpage) ? $startheight : 44.00125;
				$lh = ($i == $maxpage)   ? $h : $this->h-$this->bMargin;
				$this->Line($l,$t,$l,$lh);
				foreach($this->tablewidths AS $width) {
					$l += $width;
					$this->Line($l,$t,$l,$lh);
				}   //for
			}   //for
			$GLOBALS["actual"] = $h;
			$this->page = $maxpage;
			$this->SetXY($l,$h);			
			$this->MultiCell(10,0.1,"");
		}//morepagestable

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
   			$this->Code39(248,200,$cod_bar,.5,5);  			
		}//Footer()
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
		if ($actual1>=184.00125)
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
	$pdf->Cell(40,5,'Unidad Centralizadora',0,0,'');
	$pdf->Cell(110,5,$_SESSION["sig_usuario"],B,0,''); 
	$pdf->Cell(125,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(40,5,'Número NIT:',0,0,'');
	$pdf->Cell(110,5,$nit,B,1,'');
	
	$pdf->Cell(40,5,'Periodo del informe del:',0,0,'');
	$pdf->Cell(15,5,'1',B,0,'C');
	$pdf->Cell(20,5,'      Hasta',0,0,'');
	$pdf->Cell(20,5,days_in_month($_GET['periodo'], $_GET['ano']),B,0,'C');
	$pdf->Cell(40,5,' de '.$n_meses[$_GET['periodo'] - 1].' de '.$_GET['ano'],0,1,'C');
	
	$periodo = $_GET['periodo'];
	$ano = $_GET['ano'];
	if ($periodo == 1)
	{
		$periodo = 12;
		$ano = $ano - 1;
	}
	else $periodo = $periodo - 1;

	if ($_GET['cuenta'] == '1')
	{
		if ($uni_usuario == '1')
		{
			$consulta_cta = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
			$cur_cta = odbc_exec($conexion,$consulta_cta);
			$nom_cta = 'GASTOS';
			$cta = trim(odbc_result($cur_cta,11));
			//$pdf->Cell(50,5,'CUENTA: ',0,0,'R');
			//$pdf->Cell(40,5,$nom_cta.' - '.$cta,B,1,'C');
			
			$consulta_saluni = "select * from cx_sal_uni where periodo = '".$periodo."' and ano = '".$ano."' and unidad = '".$uni_usuario."' order by fecha";
			$cur_saluni = odbc_exec($conexion,$consulta_saluni);
			if (odbc_num_rows($cur_saluni) == 0) $saldo_ant = 0;
			else $saldo_ant = odbc_result($cur_saluni, 6);			
		}   //if
		else $pdf->Cell(50,5,'',0,1,'R');
	}
	else
	{
		$consulta_cta = "select * from cx_ctr_cue where conse ='".$_GET['cuenta']."'";
		$cur_cta = odbc_exec($conexion,$consulta_cta);
		if (odbc_num_rows($cur_cta) != 0)
		{
			$nom_cta = trim(odbc_result($cur_cta,5));
			$cta = trim(odbc_result($cur_cta,6));
			//$pdf->Cell(50,5,'CUENTA: ',0,0,'R');
			//$pdf->Cell(40,5,$nom_cta.' - '.$cta,B,1,'C');
		}   //if
		else $pdf->Cell(20,5,$nom_cta.'',0,1,'C');

		$consulta_salc = "select * from cx_sal_cue where conse ='".$_GET['cuenta']."'";
		$cur_salc = odbc_exec($conexion,$consulta_salc);
		if (odbc_num_rows($cur_salc) == 0) $saldo_ant = 0;
		else $saldo_ant = odbc_result($cur_salc, 2);
	}   //if
	$pdf->Cell(50,2,'',0,1,'R');

	$pdf->SetFont('Arial','',7);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,12,0,'DF');	
	$pdf->Cell(24,4,'NUMERO',0,0,'C');
	$pdf->Cell(20,4,'',L,0,'C');
	$pdf->Cell(29,4,'NUMERO',L,0,'C');
	$pdf->Cell(70,4,'',L,0,'C');
	$pdf->Cell(45,4,'',L,0,'C');
	$pdf->Cell(45,4,'',L,0,'C');
	$pdf->Cell(4,4,'',L,1,'C');
	$pdf->Cell(24,4,'COMPROBANTE',0,0,'C');
	$pdf->Cell(20,4,'FECHA',L,0,'C');
	$pdf->Cell(29,4,'CHEQUE/',L,0,'C');
	$pdf->Cell(70,4,'CONCEPTO',L,0,'C');
	$pdf->Cell(45,4,'DEBITO',L,0,'C');
	$pdf->Cell(45,4,'CRÉDITO',L,0,'C');
	$pdf->Cell(45,4,'SALDO',L,1,'C');
	$pdf->Cell(24,4,'',0,0,'C');
	$pdf->Cell(20,4,'',L,0,'C');	
	$pdf->Cell(29,4,'CONSIGNACIÓN',L,0,'C');
	$pdf->Cell(70,4,'',L,0,'C');	
	$pdf->Cell(45,4,'',L,0,'C');
	$pdf->Cell(45,4,'',L,0,'C');
	$pdf->Cell(45,4,'',L,1,'C');

	$pdf->Cell(233,5,'SALDO ANTERIOR',0,0,'L');
	$pdf->SetFont('Arial','',8);	
	$pdf->Cell(45,5,'$'.number_format($saldo_ant,2),L,1,'R');

	$consulta_libban = "select * from cv_lib_ban where periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and unidad = '".$uni_usuario."'  and cuenta = '".$_GET['cuenta']."' order by fecha"; 
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

		$consulta_gas = "select * from cx_ctr_gas where codigo ='".$concepto."'";
		$cur_gas = odbc_exec($conexion,$consulta_gas);
		$n_concepto = odbc_result($cur_gas,2);

		//campo Tipo1: 1=Ingreso, 2=Egreso
		$comp = odbc_result($cur_libban,1);
		if (odbc_result($cur_libban, 10) == '1') $compf = "I-".$comp;   
		else $compf = "E-".$comp;
		$conceptof = odbc_result($cur_libban,8);

		$debito = odbc_result($cur_libban,11);									
		$credito = odbc_result($cur_libban,12);									
		$t_debito = $t_debito + $debito;		
		$t_credito = $t_credito + $credito;
		$saldo = $saldo + $credito - $debito;
		$fecha = substr(odbc_result($cur_libban,2),0,10);
		$n_cheque = trim(odbc_result($cur_libban,9));
		$data[] = array($compf, $fecha, $n_cheque, $conceptof, wims_currency($credito), wims_currency($debito), wims_currency($saldo));
		$i++;
		control_salto_pag($pdf->GetY());
	} //while

	$consulta_cm = "select * from cx_cue_mov where unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."' order by egreso";
	$cur_cm = odbc_exec($conexion,$consulta_cm);
	$debito_cm = 0;
	$credito_cm = 0;
	$i = 0;
	while($i<=$row=odbc_fetch_array($cur_cm))
	{	
		$fecha_cm = substr(odbc_result($cur_cm,2),0,10);
		$unidad_cm = odbc_result($cur_cm,4);
		$comp = trim(odbc_result($cur_cm,7));
		$egreso_cm = "E-".$comp;
		$cta_inicial_cm = odbc_result($cur_cm,9);
		$cta_final_cm = odbc_result($cur_cm,10);
		if ($_GET['cuenta'] == $cta_final_cm)
		{
			if ($c_final_cm = '1' or $c_final_cm = '4') $credito_cm = trim(odbc_result($cur_cm,12));
			$debito_cm = 0;
			$saldo = $saldo + $credito_cm - $debito_cm;
			$t_debito = $t_debito + $debito_cm;		
			$t_credito = $t_credito + $credito_cm;
			$n_cheque_cm = "";
			$consulta_cg = "select * from cx_ctr_gas where codigo = (select concepto from cx_com_egr where unidad = '".$uni_usuario."' and egreso = '".trim(odbc_result($cur_cm,7))."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."')";
			$cur_cg = odbc_exec($conexion,$consulta_cg);
			$conceptof = trim(odbc_result($cur_cg,2));
			$data[] = array($egreso_cm, $fecha_cm, $n_cheque_cm, $conceptof, wims_currency($credito_cm), wims_currency($debito_cm), wims_currency($saldo));
		}   //if
		$i++;
		control_salto_pag($pdf->GetY());
	} //while

	for ($ax=0;$ax<=count($data)-1;$ax++) $aux[$ax] = $data[$ax][1];
	array_multisort($aux, SORT_ASC, $data);
	for ($ax=0;$ax<=count($data)-1;$ax++)
	{
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,279,4,0,'');
		$pdf->Cell(24,4,$data[$ax][0],0,0,'C');
		$pdf->Cell(20,4,$data[$ax][1],L,0,'C');
		$pdf->Cell(29,4,$data[$ax][2],L,0,'C');
		$pdf->Cell(70,4,$data[$ax][3],L,0,'C');
		$pdf->Cell(45,4,$data[$ax][4],L,0,'R');
		$pdf->Cell(45,4,$data[$ax][5],L,0,'R');
		$pdf->Cell(45,4,$data[$ax][6],L,1,'R');
		control_salto_pag($pdf->GetY());		
	}   //for

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Cell(143,5,'TOTALES',0,0,'R');
	$pdf->Cell(45,5,wims_currency($t_credito),1,0,'R');	
	$pdf->Cell(45,5,wims_currency($t_debito),1,0,'R');
	$t_saldo = $saldo_ant + $t_credito - $t_debito;
	$pdf->Cell(45,5,wims_currency($t_saldo),1,1,'R');

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
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
	if ($ajuste > 0) $pdf->Ln($ajuste);	
	$n_reviso = strtr(utf8_decode($reviso), $sustituye);
	$c_reviso = strtr(utf8_decode($c_reviso), $sustituye);
	$n_jem = strtr(utf8_decode($jem), $sustituye);
	$c_jem = strtr(utf8_decode($c_jem), $sustituye);
	$n_cdo = strtr(utf8_decode($cdo), $sustituye);
	$c_cdo = strtr(utf8_decode($c_cdo), $sustituye);
	$pdf->Ln(25);

	//Busca imagen de la firma Ejecutó
	//$n_reviso = "JAIME ALBERTO MORALES (CX)";  
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_reviso."'";
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
	//$pdf->Cell(95,5,$pdf->Image($file,45,$actual-20,$w,30),0,0,'C');
	
	//Busca imagen de la firma Autorizo
	//$n_jem = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_jem."'";
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
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	//$pdf->Cell(95,5,$pdf->Image($file,135,$actual-20,$w,30),0,0,'C');
	
	//Busca imagen de la firma Autorizo
	//$n_cdo = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_cdo."'";
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
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	//$pdf->Cell(95,5,$pdf->Image($file,225,$actual-20,$w,30),0,1,'C');

	control_salto_pag($pdf->GetY());
	$pdf->Cell(139,5,'_______________________________________________________',0,0,'C');
	$pdf->Cell(139,5,'_______________________________________________________',0,1,'C');
	$pdf->Cell(139,3,$n_reviso,0,0,'C');
	$pdf->Cell(139,3,$n_jem,0,0,'C');
	$pdf->Cell(139,3,$n_cdo,0,1,'C');
	$pdf->Cell(139,3,$c_reviso,0,0,'C');
	$pdf->Cell(278,8,'',0,1,'L');	
	
	control_salto_pag($pdf->GetY());	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual+$ajuste,279,30,0,'');
	$pdf->Ln(16);		
	$pdf->Cell(279,5,'_______________________________________________________',0,1,'C');
	$pdf->Cell(279,3,$c_jem,0,1,'C');	
	$pdf->Cell(279,3,$c_cdo,0,1,'C');
	$pdf->Ln(3);	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,279,5,0,'');
	$pdf->Cell(15,5,'Elaboró:',0,0,'');
	$pdf->Cell(35,5,strtr(utf8_decode($elaboro), $sustituye),0,1,'L');  

	ob_end_clean();
	$nom_pdf="pdf/InfGiro_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
