<?php
/* 623.php
   FO-JEMPP-CEDE2-623- Autorización Recurso Adicional.
   (pág 109 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
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
			$sigla = "CEDE2";	
			
			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(95,175,$sigla,35);

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
			$this->Cell(116,5,'AUTORIZACIÓN RECURSOS ADICIONALES',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-623',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'GASTOS RESERVADOS',0,0,'C');
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
		}//function RoundedRect($x,$y,$w,$h,$r,$style='')

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//function _Arc($x1, $y1, $x2, $y2, $x3, $y3)

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
					$this->SetFont('Arial','',7);		
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 21 or $this->tablewidths[$col] == 24 or $this->tablewidths[$col] == 28 or $this->tablewidths[$col] == 29) 
						$this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
					elseif ($this->tablewidths[$col] == 86) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'J');
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
   			$this->Code39(268,200,$cod_bar,.5,5);
		}//function Footer()
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
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
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
		$tabla = "cx_sol_aut";
		$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);
		$cur_nr = odbc_num_rows($cur);		
		if ($cur_nr <> 0) $pag_info = 'X';
	}   //if
	if ($_GET['tipo'] == '2')
	{
		$tabla = "cx_rec_aut";
		$consulta = "select * from cx_rec_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);		
		$cur_nr = odbc_num_rows($cur);
		if ($cur_nr <> '0') $pag_reco = 'X';
	}   //if
//echo $_GET['tipo']."<br>".$consulta."<br>";
	$fecha = substr(odbc_result($cur,2),0,10);
	$planes = trim(decrypt1(odbc_result($cur,6), $llave));
	$lugar = "Bogotá";	

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
	$pdf->RoundedRect(9,$actual+3,279,8,0,'DF');
	$pdf->Ln(3);
	$pdf->Cell(4,8,'No',0,0,'C');
	$pdf->Cell(15,8,'UNIDAD',1,0,'C');
	$pdf->Cell(12,8,'DIVISIÓN',1,0,'C');		
	$pdf->Cell(12,8,'BRIGADA',1,0,'C');			
	$pdf->Cell(14,8,'BATALLÓN',1,0,'C');
	$pdf->Cell(20,8,'ORDOP',1,0,'C');					
	$pdf->Cell(16,8,'ORFRAG',1,0,'C');
	$pdf->Cell(16,8,'FECHA',1,0,'C');
	$pdf->Cell(86,8,'RESUMEN',1,0,'C');
	$pdf->Cell(21,8,'VALOR',1,0,'C');
	$pdf->Cell(21,8,'VALOR A',1,0,'C');
	$pdf->Cell(41,4,'ACTA COMITÉ EVALUACIÓN',1,1,'C');
	$pdf->Cell(4,5,'',0,0,'C');
	$pdf->SetFont('Arial','',6.8);	
	$pdf->Cell(15,5,'EJECUTORA',0,0,'C');
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(12,5,'',0,0,'C');		
	$pdf->Cell(12,5,'',0,0,'C');			
	$pdf->Cell(14,5,'',0,0,'C');
	$pdf->Cell(20,5,'',0,0,'C');					
	$pdf->Cell(16,5,'',0,0,'C');
	$pdf->Cell(16,5,'RESULTADO',0,0,'C');
	$pdf->Cell(86,5,'RESULTADO',0,0,'C');
	$pdf->Cell(21,5,'APROBADO',0,0,'C');
	$pdf->Cell(21,5,'GIRAR',0,0,'C');
	$pdf->Cell(26,4,'No.',1,0,'C');	
	$pdf->Cell(15,4,'FECHA',1,1,'C');		

	if ($_GET['tipo'] == '1' or $_GET['tipo'] == "") //pago información
	{
		$consulta = "select * from cx_sol_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
		$cur = odbc_exec($conexion,$consulta);
		$cur_nr = odbc_num_rows($cur);
		$fecha = substr(odbc_result($cur,2),0,10);
		$planes = trim(decrypt1(odbc_result($cur,6), $llave));
		$firmas = trim(decrypt1(odbc_result($cur,8), $llave));
		$n_elaboro = trim(odbc_result($cur,12));

		$consulta5 = "select tipo1 from cx_pla_inv where tipo1=1 and conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur5 = odbc_exec($conexion,$consulta5);	
		if (odbc_num_rows($cur5) <> 0 and trim(odbc_result($cur5,1)) == '1') $gastos_ic = 'X';

		$consulta_pp = "select distinct conse from cx_pla_pag where conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur_pp = odbc_exec($conexion,$consulta_pp);

		$tvaprobado = 0;
		$tvgirado = 0;
		$i = 0;
		while($i<$row=odbc_fetch_array($cur_pp))
		{
			$consecu = odbc_result($cur_pp,1);
			$consulta1 = "select * from cx_pla_pag where conse = '".$consecu."' and ano = '".$_GET['ano']."' order by conse";//echo $consulta1."<br>";
			$cur1 = odbc_exec($conexion,$consulta1);
			$n_ordop = trim(odbc_result($cur1,27));
			$ordop = strtr($n_ordop, $sustituye);
			$fe_ret = trim(odbc_result($cur1,29));
			
			$consulta2 = "select * from cx_val_aut1 where solicitud='".$consecu."' and ano = '".$_GET['ano']."'";
			$cur2 = odbc_exec($conexion,$consulta2);
			$batallon = trim(odbc_result($cur2,7));
			$uejecuta = trim(odbc_result($cur2,17));
			$uom = trim(odbc_result($cur2,15));
			$unidad = trim(odbc_result($cur2,16));
			$division = trim(odbc_result($cur2,17));
			$solicitud = trim(odbc_result($cur2,21));
			$valor_apr = substr(str_replace(',','',trim(odbc_result($cur2,9))),0);  
			$tvaprobado = $tvaprobado + $valor_apr;
			$valor_gir = substr(str_replace(',','',trim(odbc_result($cur2,10))),0); 
			$tvgirado = $tvgirado + $valor_gir;

			if ($division == 'CAIMI' or $division == 'CACIM')
			{
				$brigada = trim(odbc_result($cur2,15));
				$uejecuta = trim(odbc_result($cur2,15));
			}
			else $brigada = trim(odbc_result($cur2,17));  

			if ($division == 'DAVAA' or $division == 'DIV2')
			{
				$brigada = trim(odbc_result($cur2,15));
				$unidad_au = trim(odbc_result($cur2,4));
				$consulta_vu = "select * from cv_unidades where subdependencia = '".$unidad_au."'";
				$cur_vu = odbc_exec($conexion,$consulta_vu);				
				$division = trim(odbc_result($cur_vu,2));
			}   //if

			if ($unidad >= '13' and $unidad <= '16') $brigada = "";
			else $brigada = trim(odbc_result($cur2,15));  
			if ($uejecuta == 'CENOR') $uejecuta = "DIV2";
			if ($uejecuta == 'CONAT') $uejecuta = "DAVAA";

			$ordop = iconv('UTF-8', 'windows-1252', $ordop);	
			if ($ordop == "") $ordop = "N/A";
			if ($fe_ret == "") $fe_ret = "N/A";
			$ofragment = "N/A";
			$resultado = "                                                         N/A";
			$data[] = array($i+1, $uejecuta, $division, $brigada, $batallon, $ordop, $ofragment, $fe_ret, $resultado, '$'.number_format($valor_apr,2), '$'.number_format($valor_gir,2), $_GET['conse'], $fecha);
			$i++;		
		}   //while
		$actual=$pdf->GetY();
		$pdf->tablewidths = array(5, 15, 12, 12, 14, 20, 16, 16, 86, 21, 21, 26, 15); 
		$pdf->morepagestable($data);
		unset($data);

		$actual=$pdf->GetY();
		$pdf->SetFont('Arial','B',7);		
		$pdf->RoundedRect(9,$actual,279,5,0,'D');	
		$pdf->Cell(195,5,'SUMAN',0,0,'R');
		$pdf->Cell(21,5,'$'.number_format($tvaprobado,2),1,0,'R');
		$pdf->Cell(21,5,'$'.number_format($tvgirado,2),1,1,'R');
		$pdf->SetFont('Arial','',7);	
		$actual=$pdf->GetY();	
		$pdf->Ln(3);	
		$pdf->Cell(80,5,'3.  Gastos en Actividades de Inteligencia o Contrainteligencia',0,0,'L');	
		$pdf->Cell(10,5,$gastos_ic,1,1,'C');	
		$valor_apr = 0;
		
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

		$consulta1 = "select * from cx_pla_inv where tipo1=1 and conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
		$cur1 = odbc_exec($conexion,$consulta1);
		$tvaprobado = 0;
		$tvgirado1 = 0;
		$tvalgirar = 0;
		$i = 0;
		while($i<$row=odbc_fetch_array($cur1))
		{	
			$consulta6 = "select * from cx_val_aut1 where solicitud='".odbc_result($cur1,1)."' and ano = '".$_GET['ano']."'";
			$cur6 = odbc_exec($conexion,$consulta6);
			$uadelanta = trim(odbc_result($cur6,7));		
			$uejecutora = trim(odbc_result($cur6,15));
			if ($uejecutora == 'CENOR') $uejecutora = "DIV2";
			if ($uejecutora == 'CONAT') $uejecutora = "DAVAA";

			$ordob1 =  trim(decrypt1(odbc_result($cur1,14), $llave));
			$n_ordob = utf8_decode($ordob1);
			$mision = utf8_decode(substr(trim(decrypt1(odbc_result($cur1,16), $llave)),0,-1));
			$solicitud = trim(odbc_result($cur6,21));
			$valor_apr = substr(str_replace(',','',trim(odbc_result($cur6,8))),0);  
			$tvaprobado = $tvaprobado +  $valor_apr;
			$valor_gir = substr(str_replace(',','',trim(odbc_result($cur6,10))),0); 
			$tvgirado1 = $tvgirado1 + $valor_gir;
			$tvalgirar = $tvalgirar + $valor_gir;
			$data[] = array($i+1, $uejecutora, $uadelanta, $n_ordob, $mision, $_GET['conse'], $fecha, '$'.number_format($valor_apr,2), '$'.number_format($valor_gir,2));
			$i++;		
		}   //while
		$actual=$pdf->GetY();
		$pdf->tablewidths = array(6, 18, 40, 71, 45, 15, 27, 28, 29); 
		$pdf->morepagestable($data);
		unset($data);
		
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,279,5,0,'D');	
		$pdf->Cell(221,5,'SUMAN',0,0,'L');
		$pdf->Cell(28,5,'$'.number_format($tvaprobado,2),1,0,'R');
		$pdf->Cell(29,5,'$'.number_format($tvalgirar,2),1,1,'R');
		$actual=$pdf->GetY();	
		$totvalgirar = $tvgirado + $tvalgirar;
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',7);		
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
	}
	else   //tipo = 2, pago de recompensas
	{
		$consulta = "select * from cx_rec_aut where conse ='".$_GET['conse']."' and ano = '".$_GET['ano']."'";
//echo $consulta."<br>";
		$cur = odbc_exec($conexion,$consulta);
		$cur_nr = odbc_num_rows($cur);
		$fecha = substr(odbc_result($cur,2),0,10);
		$firmas = trim(decrypt1(odbc_result($cur,8), $llave));
		$n_elaboro = trim(odbc_result($cur,9));
		$actas = trim(decrypt1(odbc_result($cur,6), $llave));
		$pos = "";
		$pos = strpos($actas, "#");
		if ($pos != "")
		{
			$actas = explode("#",$acts);
			$actas = $act[0];
			$fe_act = $act[1];
			$act = explode(",",$actas);
			$fe_act = explode(",",$fe_actas);
			$r = 0;			
			for ($r=0;$r<=count($acts)-1;$r++)
			{
				$consulta_ac = "select * from cx_act_cen where conse = ".$act[$r]." and ano = ".$fe_act[$r]." order by conse";
//echo $consulta_ac."<br>";
				$cur_ac = odbc_exec($conexion,$consulta_ac);
				$cur1_nr = odbc_num_rows($cur_ac);
				
				$registro = trim(odbc_result($cur_ac,7));
				$ano1 = trim(odbc_result($cur_ac,8));
				$valor_apr = substr(str_replace(',','',trim(odbc_result($cur_ac,19))),0);  
				$tvaprobado = $tvaprobado + $valor_apr;
				$valor_gir = substr(str_replace(',','',trim(odbc_result($cur_ac,19))),0);  
				$tvgirado = $tvgirado + $valor_gir;
				$acta = trim(odbc_result($cur_ac,23));
				if ($acta == "") $acta = $_GET['conse'];
				$fe_acta = trim(odbc_result($cur_ac,29));			
				if ($fe_acta == "") $fe_acta = substr(odbc_result($cur_ac,2),0,10);				






				$batallon = trim(odbc_result($cur1,4));
				$consulta_uni = "select * from cv_unidades where subdependencia = '".$batallon."'";
				$cur_uni = odbc_exec($conexion,$consulta_uni);
				$batallon = trim(odbc_result($cur_uni,6));
				$brigada = trim(odbc_result($cur_uni,4));
				$division = trim(odbc_result($cur_uni,2));
				$uejecuta = trim(odbc_result($cur_uni,2));
				if ($uejecuta == 'FUDRA1' or $uejecuta == 'FUDRA2' or $uejecuta == 'CEO' or $uejecuta == 'CEC') $brigada = "";
				$n_ordop = trim(odbc_result($cur1,24));
				$ordop = trim(odbc_result($cur1,25));
				$ofragmenta = trim(odbc_result($cur1,27));
				$fe_resul = trim(odbc_result($cur1,8));
				$resultado1 = trim(odbc_result($cur1,34));
				$resultado = str_replace($buscar, $reemplazar, $resultado1);
				$valor_apr = substr(str_replace(',','',trim(odbc_result($cur1,21))),0);  
				$tvaprobado = $tvaprobado + $valor_apr;
				$valor_gir = trim(odbc_result($cur1,22)); 
				$tvgirado = $tvgirado + $valor_gir;

				$consulta_ac = "select * from cx_act_cen where conse = '".$_GET['conse']."' and ano = '".$_GET['ano']."'";
				$cur_ac = odbc_exec($conexion,$consulta_ac);
				$acta = trim(odbc_result($cur_ac,23));
				$fe_acta = trim(odbc_result($cur_ac,29));
				if ($acta == "")
				{
					$acta = $_GAT['conse'];
					$fe_acta = substr(odbc_result($cur_ac,2),0,10);
				}   //if	
				if ($ordop == "") $ordop = "N/A";
				else $ordop = $n_ordop." - ".$ordop;	
				if ($ofragmenta == "") $ofragmenta = "N/A";
				if ($fe_resul == "") $fe_resul = "N/A";
				$data[] = array($i+1, $uejecuta, $division, $brigada, $batallon, $ordop, $ofragment, $fe_resul, $resultado, '$'.number_format($valor_apr,2), '$'.number_format($valor_gir,2), $acta, $fe_acta);
			}   //for		
			$actual=$pdf->GetY();
			$pdf->tablewidths = array(5, 15, 12, 12, 14, 20, 16, 16, 86, 21, 21, 26, 15); 
			$pdf->morepagestable($data);
			unset($data);
		}   //if
		else
		{
			
		}   //if
		$pdf->Cell(171,5,'',0,0,'C');
		$pdf->Cell(24,5,'SUMAN',1,0,'R');
		$pdf->Cell(21,5,'$'.number_format($tvaprobado,2),1,0,'R');
		$pdf->Cell(21,5,'$'.number_format($tvgirado,2),1,1,'R');

		$tvaprobado = 0;
		$actual=$pdf->GetY();	
		$pdf->Ln(3);	
		$pdf->Cell(80,5,'3.  Gastos en Actividades de Inteligencia o Contrainteligencia',0,0,'L');	
		$pdf->Cell(10,5,$gastos_ic,1,1,'C');	
			
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
		$pdf->RoundedRect(9,$actual,279,5,0,'D');	
		$pdf->Cell(221,5,'SUMAN',0,0,'L');
		$pdf->Cell(28,5,'$'.number_format($tvaprobado,2),1,0,'R');
		$pdf->Cell(29,5,'$'.number_format($tvalgirar,2),1,1,'R');
		$actual=$pdf->GetY();	
		$totvalgirar = $tvgirado + $tvalgirar;
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',7);		
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
	$pdf->Ln(1);
	$pdf->Cell(278,5,$linea,0,1,'C');
	$pdf->Ln(20);
	$pdf->Cell(94,4,'__________________________________________________',0,0,'C');	
	$pdf->Cell(94,4,'__________________________________________________',0,0,'C');	
	$pdf->Cell(94,4,'__________________________________________________',0,1,'C');	
	$pdf->Cell(94,3,$inter[0]["nom"],0,0,'C');
	$pdf->Cell(92,3,$inter[1]["nom"],0,0,'C');
	$pdf->Cell(92,3,$inter[2]["nom"],0,1,'C');
	$pdf->Cell(94,3,$inter[0]["cargo"],0,0,'C');
	$pdf->Cell(92,3,$inter[1]["cargo"],0,0,'C');
	$pdf->Cell(92,3,$inter[2]["cargo"],0,1,'C');
	$pdf->Cell(278,5,$linea,0,1,'C');		

	control_salto_pag($pdf->GetY());
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(277,3,$texto,0,'J');
	$pdf->Ln(1);
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,279,5,0,'D');	
	$pdf->Cell(15,5,'Elaboró:    '.$n_elaboro,0,1,'L');

	ob_end_clean();
	$nom_pdf="pdf/InfGiro_".$_GET['informe']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output(); 
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";		 	
}
?>

