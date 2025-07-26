<?php
/* 623.php
   FO-JEMPP-CEDE2-623- Autorización Recurso Adicional.
   (pág 109 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	01/07/2023 - Se hace control del cambio de la sigla. Jorge Clavijo
	28/08/2024 - Se incluye el cargo para la firma del elaboró. Jorge Clavijo
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
	$actual="0";

	class PDF extends PDF_Rotate
	{
		function Header()
		{
			require('../conf.php');
			require('../permisos.php');

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			if ($_GET['tipo'] == '1' or $_GET['tipo'] == "")
			{
				$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
				$cur = odbc_exec($conexion,$consulta);
				$fecha_rg = substr(odbc_result($cur,2),0,10);
			}
			elseif ($_GET['tipo'] == '2')
			{
				$consulta = "select * from cx_rec_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
				$cur = odbc_exec($conexion,$consulta);
				$fecha_rg = substr(odbc_result($cur,2),0,10);
			}   //if

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));

			if ($sigla1 <> "") if ($fecha_rg >= $fecha_os) $sigla = $sigla1;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(95,175,$sigla,35);
			else $this->RotatedText(75,180,$sigla,35);

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
			$this->Cell(116,5,'AUTORIZACIÓN TRANSFERENCIAS',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-623',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'GASTOS RESERVADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(116,5,'',0,0,'C');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2022-12-21',0,1,'');

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
		}//Header()

		function RotatedText($x,$y,$txt,$angle)
		{
    		$this->Rotate($angle,$x,$y);
    		$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}//RotatedText()

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
		}//RoundedRect()

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc()

		function morepagestable($datas, $lineheight=3)
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
					$act = $this->GetY();
					$this->SetFont('Arial','',6.2);
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 28) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
		}//morepagestable()

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
		}//Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);

	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã•' => 'í', 'Ã­' => 'í');
	$linea = str_repeat("_",203);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=185.00125) $pdf->addpage();
	} //control_salto_pag

	$pag_info = "";
	$pag_reco = "";

	if ($_GET['tipo'] == '1' or $_GET['tipo'] == "")
	{
		$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);
		$cur_nr = odbc_num_rows($cur);
		$planes = trim(decrypt1(odbc_result($cur,6), $llave));

		$consulta1 = "select * from cx_pla_pag where conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur1 = odbc_exec($conexion,$consulta1);
		$cur1_nr = odbc_num_rows($cur1);

		if ($cur_nr <> 0 or $cur1_nr <> 0) $pag_info = 'X';
		if ($cur_nr <> 0 and $cur1_nr == 0) $pag_info = '';
		if ($cur_nr == 0 and $cur1_nr <> 0) $pag_info = 'X';
		if ($cur_nr == 0 and $cur1_nr == 0) $pag_info = '';
	}   //if
	if ($_GET['tipo'] == '2')
	{
		$consulta = "select * from cx_rec_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);

		if (odbc_num_rows($cur) <> '0') $pag_reco = 'X';
	}   //if
	$fecha = substr(odbc_result($cur,2),0,10);
	$unid = trim(odbc_result($cur,4));

	$consulta_cv = "select * from cv_unidades where subdependencia = '".$unid."'";
	$cur_cv = odbc_exec($conexion,$consulta_cv);
	$us = trim(odbc_result($cur_cv,6));

	$consulta_os = "select ciudad from cx_org_sub where subdependencia = '".odbc_result($cur,4)."'";
	$cur_os = odbc_exec($conexion,$consulta_os);
	$lugar = trim(odbc_result($cur_os,1));

	$pdf->SetFont('Arial','',7);
	$actual=$pdf->GetY();
	$pdf->Cell(35,5,'Número',0,0,'L');
	$pdf->Cell(46,5,$_GET['conse'],B,0,'L');
	$pdf->Cell(196,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(35,5,'Lugar y fecha',0,0,'L');
	$pdf->Cell(46,5,$lugar.' - '.$fecha,B,1,'L');
	$pdf->Ln(4);
	$pdf->Cell(40,5,'1. Pago de Recompensas.',0,0,'L');
	$pdf->Cell(10,5,$pag_reco,1,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(40,5,'2. Pago de Información',0,0,'L');
	$pdf->Cell(10,5,$pag_info,1,1,'C');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+3,279,9,0,'DF');
	$pdf->Ln(3);
	$pdf->Cell(5,3,'',0,0,'C');
	$pdf->Cell(19,3,'',L,0,'C');
	$pdf->Cell(24,3,'',L,0,'C');
	$pdf->Cell(24,3,'',L,0,'C');
	$pdf->Cell(22,3,'',L,0,'C');
	$pdf->Cell(40,3,'',L,0,'C');
	$pdf->Cell(56,3,'',L,0,'C');
	$pdf->Cell(28,3,'',L,0,'C');
	$pdf->Cell(28,3,'',L,0,'C');
	$pdf->Cell(31,3,'ACTA EVALUACIÓN O',L,1,'C');

	$pdf->Cell(5,3,'No',0,0,'C');
	$pdf->Cell(19,3,'UNIDAD',L,0,'C');
	$pdf->Cell(24,3,'UNIDAD',L,0,'C');
	$pdf->Cell(24,3,'ORDOP',L,0,'C');
	$pdf->Cell(22,3,'ORDEN',L,0,'C');
	$pdf->Cell(40,3,'RESULTADO OPERACIONAL',L,0,'C');
	$pdf->Cell(56,3,'ORDENADOR AUTORIZÓ',L,0,'C');
	$pdf->Cell(28,3,'MONTO',L,0,'C');
	$pdf->Cell(28,3,'VALOR A',L,0,'C');
	$pdf->Cell(31,3,'INFORME VERIFICACIÓN',L,1,'C');
	$pdf->Cell(5,3,'',0,0,'C');
	$pdf->Cell(19,3,'SOLICITANTE',L,0,'C');
	$pdf->Cell(24,3,'CENTRALIZADORA',L,0,'C');
	$pdf->Cell(24,3,'',L,0,'C');
	$pdf->Cell(22,3,'FRAGMENTARIA',L,0,'C');
	$pdf->Cell(13,3,'FECHA',LT,0,'C');
	$pdf->Cell(27,3,'REPORTADO HR No.',LT,0,'C');
	$pdf->Cell(56,3,'MONTO',L,0,'C');
	$pdf->Cell(28,3,'APROBADO',L,0,'C');
	$pdf->Cell(28,3,'GIRAR',L,0,'C');
	$pdf->Cell(17,3,'No.',LT,0,'C');
	$pdf->Cell(15,3,'FECHA',LT,1,'C');

	if ($_GET['tipo'] == '1' or $_GET['tipo'] == "")    //pago información
	{
		$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);
		$cur_nr = odbc_num_rows($cur);
		$fecha = substr(odbc_result($cur,2),0,10);
		$planes = trim(decrypt1(odbc_result($cur,6), $llave));
		$firmas = trim(decrypt1(odbc_result($cur,8), $llave));
		$n_elaboro = trim(odbc_result($cur,12));
		$c_elaboro = trim(odbc_result($cur,13));

		$consulta5 = "select tipo1, firma7 from cx_pla_inv where tipo1=1 and conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur5 = odbc_exec($conexion,$consulta5);
		$cur5_nr = odbc_num_rows($cur5);
		if (odbc_num_rows($cur5) <> 0 and trim(odbc_result($cur5,1)) == '1') $gastos_ic = 'X';

		$consulta1 = "select distinct conse from cx_pla_pag where conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur1 = odbc_exec($conexion,$consulta1);
		$cur1_nr = odbc_num_rows($cur1);
		$tvaprobado = 0;
		$tvgirado = 0;
		$i = 0;
		$rg = 0;
		while($i<$row=odbc_fetch_array($cur1))
		{
			$consecu = trim(odbc_result($cur1,1));
			$consulta2 = "select * from cx_val_aut1 where solicitud='".$consecu."' and ano = '".$_GET['ano']."'";
			$cur2 = odbc_exec($conexion,$consulta2);
			$unidad = trim(odbc_result($cur2,7));
			$centralizdora = trim(odbc_result($cur2,15));
			$ordop = strtr(trim(odbc_result($cur1,27)), $sustituye);
			$ordop = iconv('UTF-8', 'windows-1252', $ordop);
			if ($ordop == "") $ordop = "N/A";
			$ofragment = "N/A";
			$fe_ret = trim(odbc_result($cur1,29));
			if ($fe_ret == "") $fe_ret = "N/A";
			$reportado = trim(odbc_result($cur1,15));
			if ($reportado == "") $reportado = "N/A";
			$oam = trim(odbc_result($cur5,2));
			$ordenador = explode("»",$oam);
			//$ord_aut = substr($ordenador[0],0,-1);
			$ord_aut = $ordenador[0];
			$vlr_girar = trim(odbc_result($cur2,10));
			$tvaprobado = $tvaprobado + $vlr_girar;
			$tvgirado = $tvaprobado;
			$data[] = array($i+1, $unidad, $centralizdora, $ordop, $ofragment, $fe_ret, $reportado, $ord_aut, '$'.number_format($vlr_girar,2), '$'.number_format($vlr_girar,2), $_GET['conse'], $fecha);
			$i++;
		}   //while
		$actual=$pdf->GetY();
		$pdf->tablewidths = array(6, 19, 24, 24, 22, 13, 27, 56, 28, 28, 17, 15);
		$pdf->morepagestable($data);
		unset($data);

		$actual=$pdf->GetY();
		$pdf->SetFont('Arial','B',7);
		$pdf->RoundedRect(9,$actual,279,5,0,'D');
		$pdf->Cell(180,5,'SUMAN',0,0,'L');
		$pdf->Cell(28,5,'$'.number_format($tvaprobado,2),L,0,'R');
		$pdf->Cell(28,5,'$'.number_format($tvgirado,2),LR,1,'R');

		$pdf->SetFont('Arial','',7);
		$actual=$pdf->GetY();
		$pdf->Ln(3);
		$pdf->Cell(80,5,'3.  Gastos en Actividades de Inteligencia o Contrainteligencia',0,0,'L');
		$pdf->Cell(10,5,$gastos_ic,1,1,'C');
		$valor_apr = 0;

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual+3,279,6,0,'DF');
		$pdf->Ln(3);
		$pdf->Cell(5,3,'',0,0,'C');
		$pdf->Cell(23,3,'UNIDAD',L,0,'C');
		$pdf->Cell(24,3,'UNIDAD',L,0,'C');
		$pdf->Cell(63,3,'',L,0,'C');
		$pdf->Cell(33,3,'',L,0,'C');
		$pdf->Cell(32,3,'ORDENADOR AUTORIZO',L,0,'C');
		$pdf->Cell(28,3,'MONTO',L,0,'C');
		$pdf->Cell(28,3,'VALOR A',L,0,'C');
		$pdf->Cell(42,3,'INFORME VERIFICACIÓN',1,1,'C');
		$pdf->Cell(5,3,'No',0,0,'C');
		$pdf->Cell(23,3,'SOLICITANTE',L,0,'C');
		$pdf->Cell(24,3,'CENTRALIZADORA',L,0,'C');
		$pdf->Cell(63,3,'ORDOP',L,0,'C');
		$pdf->Cell(33,3,'MISIÓN TRABAJO INT/CI.',L,0,'C');
		$pdf->Cell(32,3,'MONTO',L,0,'C');
		$pdf->Cell(28,3,'APROBADO',L,0,'C');
		$pdf->Cell(28,3,'GIRAR',L,0,'C');
		$pdf->Cell(23,3,'No.',L,0,'C');
		$pdf->Cell(19,3,'Fecha',L,1,'C');

		$consulta1 = "select * from cx_pla_inv where tipo1=1 and conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur1 = odbc_exec($conexion,$consulta1);
		$tvaprobado1 = 0;
		$tvgirado1 = 0;
		$tvalgirar = 0;
		$i = 0;
		while($i<$row=odbc_fetch_array($cur1))
		{
			$consulta6 = "select * from cx_val_aut1 where solicitud='".odbc_result($cur1,1)."' and ano = '".$_GET['ano']."'";
			$cur6 = odbc_exec($conexion,$consulta6);
			$unidad = trim(odbc_result($cur6,7));
			$centralizdora = trim(odbc_result($cur6,15));
			$ordop = strtr(trim(decrypt1(odbc_result($cur1,14), $llave)), $sustituye);
			$n_ordop = trim(decrypt1(odbc_result($cur1,15), $llave));
			if ($ordop == "") $ordop = "N/A";
			else $ordop = $ordop." - ".$n_ordop;
			$mision = substr(trim(decrypt1(odbc_result($cur1,16), $llave)),0,-1);
			$oam = trim(odbc_result($cur1,51));
			$ordenador = explode("»",$oam);
			//$ord_aut = substr($ordenador[0],0,-1);
			$ord_aut = $ordenador[0];
			$consulta_pp = "select * from cx_pla_gas where conse1 = ".odbc_result($cur1,1)." and ano = '".$_GET['ano']."'";
			$cur_pp = odbc_exec($conexion,$consulta_pp);
			$m_aprobado = str_replace(',','',trim(odbc_result($cur_pp,14)));
			$vlr_girar = trim(odbc_result($cur6,10));
			$num = trim(odbc_result($cur6,1));
			$fecha = substr(trim(odbc_result($cur6,2)),0,10);
			$tvaprobado1 = $tvaprobado1 + $m_aprobado;
			$tvgirado1 = $tvgirado1 + $vlr_girar;
			$data[] = array($i+1, $unidad, $centralizdora, $ordop, $mision, $ord_aut, '$'.number_format($m_aprobado,2), '$'.number_format($vlr_girar,2), $_GET['conse'], $fecha);
			//$data[] = array($i+1, $unidad, $centralizdora, $ordop, $mision, $ord_aut, '$'.number_format($m_aprobado,2), '$'.number_format($vlr_girar,2), trim(odbc_result($cur6,22)), $fecha);
			$i++;
		}   //while
		$actual=$pdf->GetY();
		$pdf->tablewidths = array(6, 23, 24, 63, 33, 32, 28, 28, 23, 19);
		$pdf->morepagestable($data);
		unset($data);

		$actual=$pdf->GetY();
		$pdf->SetFont('Arial','B',7);
		$pdf->RoundedRect(9,$actual,279,5,0,'D');
		$pdf->Cell(180,5,'SUMAN',0,0,'L');
		$pdf->Cell(28,5,'$'.number_format($tvaprobado1,2),L,0,'R');
		$pdf->Cell(28,5,'$'.number_format($tvgirado1,2),LR,1,'R');
		$pdf->SetFont('Arial','',7);
		$actual=$pdf->GetY();
		$totvalgirar = $tvgirado + $tvgirado1;
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',7);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,279,5,0,'D');
		$pdf->Cell(208,5,'VALOR TOTAL A GIRAR',0,0,'R');
		$pdf->Cell(28,5,'$'.number_format($totvalgirar,2),LR,1,'R');
		$pdf->SetFont('Arial','',7);

		$firmas1 = explode("|",$firmas);
		for ($k=0;$k<=count($firmas1)-1;$k++)
		{
			$frm = explode("»",$firmas1[$k]);
			$inter[$k]["nom"] = substr(trim($frm[0]),0,-1);
			$inter[$k]["cargo"] = trim($frm[1]);
		}	//for
	}
	else   //tipo = 2, pago de recompensas
	{
		$consulta = "select * from cx_rec_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);
		$cur_nr = odbc_num_rows($cur);
		$fecha = substr(odbc_result($cur,2),0,10);
		$actas = trim(decrypt1(odbc_result($cur,6), $llave));
		$firmas = trim(decrypt1(odbc_result($cur,8), $llave));
		$n_elaboro = trim(odbc_result($cur,9));
		$c_elaboro = trim(odbc_result($cur,10));
		$pos = "";
		$pos = strpos($actas, "#");
		if ($pos != "")
		{
			$act = explode("#",$actas);
			$actas = $act[0];
			$fe_actas = $act[1];
			$act = explode(",",$actas);
			$fe_act = explode(",",$fe_actas);
			$rg = 0;
			for ($r=0;$r<=count($act)-1;$r++)
			{
				$consulta_ac = "select * from cx_act_cen where conse = ".$act[$r]." and ano = ".$fe_act[$r]." order by conse";
				$cur_ac = odbc_exec($conexion,$consulta_ac);
				$cur1_nr = odbc_num_rows($cur_ac);
				if (trim(odbc_result($cur_ac,23)) == "") $acta = trim(odbc_result($cur_ac,1));
				else $acta = trim(odbc_result($cur_ac,23));
				if (trim(odbc_result($cur_ac,29)) == "") $fe_acta = substr(odbc_result($cur_ac,2),0,10);
				else $fe_acta = trim(odbc_result($cur_ac,29));
				$registro = trim(odbc_result($cur_ac,7));
				$ano1 = trim(odbc_result($cur_ac,8));

				$consulta1 = "select * from cx_reg_rec where conse = '".$registro."' and ano = '".$ano1."'";
				$cur1 = odbc_exec($conexion,$consulta1);
				$cur1_nr = odbc_num_rows($cur1);
				$sb_unidad = trim(odbc_result($cur1,4));
				$vlr_girar = str_replace(',','',trim(odbc_result($cur_ac,19)));

				$consulta_vu = "select * from cv_unidades where subdependencia = '".$sb_unidad."'";
				$cur_vu = odbc_exec($conexion,$consulta_vu);
				$unidad = trim(odbc_result($cur_vu,6));
				if ($sb_unidad < '69') $centralizadora = trim(odbc_result($cur_vu,4));
				else $centralizadora = trim(odbc_result($cur_vu,2));
				if ($centralizadora == 'CENOR') $centralizadora = "DIV2";
				if ($centralizadora == 'CONAT') $centralizadora = "DAVAA";
				$n_ordop = trim(odbc_result($cur1,24));
				$ordop = trim(odbc_result($cur1,25));
				$ofragmenta = trim(odbc_result($cur1,27));
				$fe_ret = trim(odbc_result($cur1,8));
				$resultado = trim(odbc_result($cur1,9));
				$resultado = preg_replace("/[\r\n|\n|\r]+/", " ", $resultado);
				$resultado = $resultado."\n\n";
				$ord = trim(odbc_result($cur_ac,11));
				$ord1 = explode("»",$ord);
				$ord_aut = trim($ord1[0]);
				$rg++;
				if ($ordop == "") $ord = "N/A";
				else $ord = $n_ordop."-".$ordop;
				if ($ofragmenta == "") $ofragmenta = "N/A";
				if ($fe_resul == "") $ffe_resul = "N/A";
				else $ffe_resul = $fe_resul;
				$tvgirado = $tvgirado + $vlr_girar;
				$tvaprobado = $tvgirado;
				$data[] = array($r+1, $unidad, $centralizadora, $ordop, $ofragmenta, $fe_ret, $resultado, $ord_aut, '$'.number_format($vlr_girar,2), '$'.number_format($vlr_girar,2), $acta, $fe_acta);
			}   //for
			$pdf->tablewidths = array(6, 19, 24, 24, 22, 13, 27, 56, 28, 28, 17, 15);
			$pdf->morepagestable($data);
			unset($data);
		}   //if
		else
		{
			$consulta_ac = "select * from cx_act_cen where conse in (".$actas.") and ano = '".$_GET['ano']."' order by conse";
			$cur_ac = odbc_exec($conexion,$consulta_ac);
			$cur1_nr = odbc_num_rows($cur_ac);
			$i = 0;
			$rg = 0;
			while($i<$row=odbc_fetch_array($cur_ac))
			{
				if (trim(odbc_result($cur_ac,23)) == "") $acta = trim(odbc_result($cur_ac,1));
				else $acta = trim(odbc_result($cur_ac,23));
				if (trim(odbc_result($cur_ac,29)) == "") $fe_acta = substr(odbc_result($cur_ac,2),0,10);
				else $fe_acta = trim(odbc_result($cur_ac,29));

				$registro = trim(odbc_result($cur_ac,7));
				$ano1 = trim(odbc_result($cur_ac,8));

				$consulta1 = "select * from cx_reg_rec where conse = '".$registro."' and ano = '".$ano1."'";
				$cur1 = odbc_exec($conexion,$consulta1);
				$cur1_nr = odbc_num_rows($cur1);
				$sb_unidad = trim(odbc_result($cur1,4));
				$vlr_girar = str_replace(',','',trim(odbc_result($cur_ac,19)));

				$consulta_vu = "select * from cv_unidades where subdependencia = '".$sb_unidad."'";
				$cur_vu = odbc_exec($conexion,$consulta_vu);
				$unidad = trim(odbc_result($cur_vu,6));
				if ($sb_unidad < '69') $centralizadora = trim(odbc_result($cur_vu,4));
				else $centralizadora = trim(odbc_result($cur_vu,2));
				if ($centralizadora == 'CENOR') $centralizadora = "DIV2";
				if ($centralizadora == 'CONAT') $centralizadora = "DAVAA";
				$n_ordop = trim(odbc_result($cur1,24));
				$ordop = trim(odbc_result($cur1,25));
				$ofragmenta = trim(odbc_result($cur1,27));
				$fe_ret = trim(odbc_result($cur1,8));
				$resultado = trim(odbc_result($cur1,9));
				$resultado = preg_replace("/[\r\n|\n|\r]+/", " ", $resultado);
				$resultado = $resultado."\n\n";
				$ord = trim(odbc_result($cur_ac,11));
				$ord1 = explode("»",$ord);
				$ord_aut = trim($ord1[0]);
				$rg++;
				if ($ordop == "") $ordop = "N/A";
				else $ord = $n_ordop."-".$ordop;
				if ($ofragmenta == "") $ofragmenta = "N/A";
				if ($fe_resul == "") $ffe_resul = "N/A";
				else $ffe_resul = $fe_resul;
				$tvgirado = $tvgirado + $vlr_girar;
				$tvaprobado = $tvgirado;
				$data[] = array($i+1, $unidad, $centralizadora, $ordop, $ofragmenta, $fe_ret, $resultado, $ord_aut, '$'.number_format($vlr_girar,2), '$'.number_format($vlr_girar,2), $acta, $fe_acta);
				$i++;
			}   //while
			$pdf->tablewidths = array(6, 19, 24, 14, 22, 13, 27, 56, 28, 28, 27, 15);
			$pdf->morepagestable($data);
			unset($data);
		}   //if
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->SetFont('Arial','B',7);
		$pdf->RoundedRect(9,$actual,279,5,0,'D');
		$pdf->Cell(180,5,'SUMAN',0,0,'L');
		$pdf->Cell(28,5,'$'.number_format($tvaprobado,2),L,0,'R');
		$pdf->Cell(28,5,'$'.number_format($tvgirado,2),L,0,'R');
		$pdf->Cell(42,5,'',L,1,'R');

		control_salto_pag($pdf->GetY());
		$pdf->SetFont('Arial','',7);
		$tvaprobado = 0;
		$actual=$pdf->GetY();
		$pdf->Ln(3);
		$pdf->Cell(80,5,'3.  Gastos en Actividades de Inteligencia o Contrainteligencia',0,0,'L');
		$pdf->Cell(10,5,$gastos_ic,1,1,'C');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual+3,279,8,0,'DF');
		$pdf->Ln(3);
		$pdf->Cell(5,8,'No',0,0,'C');
		$pdf->Cell(18,8,'UNIDAD',1,0,'C');
		$pdf->Cell(40,8,'UNIDAD ADELANTA',1,0,'C');
		$pdf->Cell(71,8,'ORDOP',1,0,'C');
		$pdf->Cell(45,8,'MISIÓN',1,0,'C');
		$pdf->Cell(42,4,'ACTA COMITÉ EVALUACIÓN',1,0,'C');
		$pdf->Cell(28,8,'VALOR APROBADO',1,0,'C');
		$pdf->Cell(29,8,'VALOR A GIRAR',1,0,'C');
		$pdf->Cell(0,4,'',0,1);
		$pdf->Cell(5,5,'',0,0,'C');
		$pdf->Cell(18,5,'EJECUTORA',0,0,'C');
		$pdf->Cell(40,5,'ACTIVIDAD INTELIGENCIA O C/I',0,0,'C');
		$pdf->Cell(71,4,'',0,0);
		$pdf->Cell(45,4,'',0,0);
		$pdf->Cell(15,4,'No.',1,0,'C');
		$pdf->Cell(27,4,'FECHA',1,0,'C');
		$pdf->Cell(57,4,'',0,1,'C');

		$actual=$pdf->GetY();
		$pdf->SetFont('Arial','B',7);
		$pdf->RoundedRect(9,$actual,279,5,0,'D');
		$pdf->Cell(221,5,'SUMAN',0,0,'L');
		$pdf->Cell(28,5,'$'.number_format($tvaprobado,2),1,0,'R');
		$pdf->Cell(29,5,'$'.number_format($tvalgirar,2),1,1,'R');
		$pdf->SetFont('Arial','',7);
		$actual=$pdf->GetY();
		$totvalgirar = $tvgirado + $tvalgirar;
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',7);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,279,5,0,'D');
		$pdf->Cell(249,5,'VALOR TOTAL A GIRAR',0,0,'R');
		$pdf->Cell(29,5,'$'.number_format($totvalgirar,2),1,1,'R');
		$pdf->SetFont('Arial','',7);

		$firmas1 = explode("|",$firmas);
		for ($k=0;$k<=count($firmas1)-1;$k++)
		{
			$frm = explode("»",$firmas1[$k]);
			$inter[$k]["nom"] = substr(trim($frm[0]),0,-1);
			$inter[$k]["cargo"] = trim($frm[1]);
		}	//for
	}   //if

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	if ($_GET['ajuste'] <> 0) $pdf->Ln($_GET['ajuste']);
	$pdf->Ln(20);

	$frm1 = $inter[0]["nom"]."\n".$inter[0]["cargo"];
	$frm2 = $inter[1]["nom"]."\n".$inter[1]["cargo"];
	$frm3 = $inter[2]["nom"]."\n".$inter[2]["cargo"];
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->Multicell(92,4,$frm1,T,'C');
	$pdf->SetXY($x+92,$y);
	$pdf->Multicell(2,4,' ',0,'C');
	$pdf->SetXY($x+94,$y);
	$pdf->Multicell(91,4,$frm2,T,'C');
	$pdf->SetXY($x+185,$y);
	$pdf->Multicell(2,4,' ',0,'C');
	$pdf->SetXY($x+187,$y);
	$pdf->Multicell(90,4,$frm3,T,'C');
	$pdf->Cell(278,3,$linea,0,1,'C');

	control_salto_pag($pdf->GetY());
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(277,3,$texto,0,'J');

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,5,0,'D');
	$pdf->Cell(15,5,'Elaboró:    '.$n_elaboro." - ".$c_elaboro,0,1,'L');

	if ($_GET['tipo'] == 1 or $_GET['tipo'] == "") $nom_pdf = "../fpdf/pdf/Autorizaciones/AutoSolRec_".$us."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	else $nom_pdf = "../fpdf/pdf/Autorizaciones/AutoRecAut_".$us."_".$_GET['conse']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>
