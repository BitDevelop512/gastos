 <?php
/* 636.php (plan_necesidades.php)
   FO-JEMPP-CEDE2-636- Plan de Necesidades de Gastos Reservados para la Inteligencia y Contrainteligencia.
   (pág 101 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	-01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
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
	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');

	class PDF extends PDF_Rotate
	{
		function Header()
		{
			require('../conf.php');
			require('../permisos.php');

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta_pn = "select * from cx_pla_nes where periodo = '4'and ano = '2023'";
			$cur_pn = odbc_exec($conexion,$consulta_pn);
			$fecha_pn = substr(odbc_result($cur_pn,2),0,10);

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));

			if ($sigla1 <> "") if ($fecha_pn >= $fecha_os) $sigla = $sigla1;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
			else $this->RotatedText(25,230,$sigla,35);

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
			$this->Cell(55,5,'PLAN NECESIDADES DE GASTOS',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-636',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'RESERVADOS PARA INTELIGENCIA',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'Y CONTRAINTELIGENCIA',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2017-05-16',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(125,3,'CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,85,26,0,'');
			$this->RoundedRect(94,15,56,26,0,'');
			$this->RoundedRect(150,15,51,26,0,'');
			$this->RoundedRect(9,15,192,268,0,'');

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

		function morepagestable($datas, $lineheight=5)
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
					$this->SetFont('Arial','',8);		
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 48) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
					elseif ($this->tablewidths[$col] == 82) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'L');
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
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		} //Footer()

	}//class PDF extends PDF_Rotate

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');

	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$secciones = array('1. CAPACIDAD DE INTELIGENCIA ESPECIALIZADA','2. CAPACIDAD DE CONTRAINTELIGENCIA','3. CAPACIDAD DE INTELIGENCIA DE COMBATE','5. CONCEPTO DE AUTORIZACIÓN DEL ORDENADOR');
	$titulos1 = array('1.1. COMANDO DE APOYO DE COMBATE DE INTELIGENCIA MILITAR (CAIMI)','1.2. BRIGADA DE INTELIGENCIA MILITAR No. 1 (BRIMI1)','1.3. BRIGADA DE INTELIGENCIA MILITAR No. 2 (BRIMI2)');
	$item1 = array('1.1.', '1.2.', '1.3.');
	$titulos2 = array('2.1. COMANDO DE APOYO DE COMBATE DE CONTRAINTELIGENCIA MILITAR (CACIM)','2.2. BRIGADA DE CONTRAINTELIGENCIA MILITAR No. 1 (BRCIM1)','2.3. BRIGADA DE CONTRAINTELIGENCIA MILITAR No. 2 (BRCIM2)');
	$item2 = array('2.1.', '2.2.', '2.3.');
	$titulos3 = array('3.1. PRIMERA DIVISIÓN (G2)','3.2. SEGUNDA DIVISIÓN (G2)','3.3 TERCERA DIVISIÓN (G2)','3.4. CUARTA DIVISIÓN (G2)','3.5. QUINTA DIVISIÓN (G2)','3.6. SEXTA DIVISIÓN (G2)','3.7. SÉPTIMA DIVISIÓN (G2)','3.8. OCTAVA DIVISIÓN (G2)','3.9. DIVISIÓN DE FUERZAS ESPECIALES','3.10. FUERZA DE DESPLIEGUE RÁPIDO - FUDRA1','3.11. FUERZA DE DESPLIEGUE RÁPIDO - FUDRA2','3.12. COMANDO ESPECÍFICO DEL CAGUAN - CEC','3.13. COMANDO ESPECÍFICO DEL ORIENTE - CEO','3.14. DIVISIÓN DE AVIACIÓN Y ASALTO AEREO - DAVAA');
	$item3 = array('3.1.', '3.2.', '3.3.', '3.4.', '3.5.', '3.6.', '3.7.', '3.8.', '3.9.', '3.10.', '3.11.', '3.12.', '3.13.', '3.14.');
	$unidades1 = array('2','4','5');   //código dependencia en la tabla cx_org_dep - CAIMI
	$unidades2 = array('3','6','7');   //código dependencia en la tabla cx_org_dep - CACIM	  
	$unidades3 = array('4','5','6','7','8','9','10','11','12','13','14','15','16','17');   //código unidad en la tabla cx_org_dep, divisiones
	$cierre_sec = array('RECURSOS REQUERIDOS CAPACIDAD INTELIGENCIA ESP.','RECURSOS REQUERIDOS CAPACIDAD CONTRAINTELIGENCIA','RECURSOS REQUERIDOS INTELIGENCIA DE COMBATE','4. TOTAL GASTOS RESERVADOS REQUERIDOS SICIE','5. CONCEPTO DE AUTORIZACIÓN DEL ORDENADOR');	
	$linea = str_repeat("_",122);
	$suman_sicie = 0;

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=262.00125) $pdf->addpage();
	} //control_salto_pag

	function titulo_c($actual1, $y1, $titulos11, $unidad1, $flag, $item, $fecha_pn1)
	{
		require('../conf.php');		
		global $pdf;

		$pdf->Cell(191,4,$titulos11,0,1,'');
		$pdf->RoundedRect(9,$actual1+4,14,8,0,'DF');
		$pdf->RoundedRect(23,$actual1+4,82,8,0,'DF');			
		$pdf->RoundedRect(105,$actual1+4,48,8,0,'DF');			
		$pdf->RoundedRect(153,$actual1+4,48,8,0,'DF');
		$pdf->Cell(13,4,'',0,0,'C');
		$pdf->Cell(82,4,'',0,0,'C');			
		$pdf->Cell(48,4,'Gastos en actividades de inteligencia',0,0,'C');
		$pdf->Cell(48,4,'',0,1,'C');												
		$pdf->Cell(13,4,'ITEM',0,0,'C');
		$pdf->Cell(82,4,'UNIDAD',0,0,'C');			
		$pdf->Cell(48,4,'y contraint.',0,0,'C');
		$pdf->Cell(48,4,'Pago de informaciones',0,1,'C');
		$actual1=$pdf->GetY();		

		switch ($flag)
		{
		case 1:
		case 2:
			$consulta_unidad = "select * from cx_org_sub where dependencia = '".$unidad1."' order by subdependencia";
			break;
		case 3:
			$consulta_unidad = "select * from cx_org_sub where unidad = '".$unidad1."' or especial = '".$unidad1."' order by unidad";
			$cur_unidad = odbc_exec($conexion,$consulta_unidad);
			$nreg = odbc_num_rows($cur_unidad);
			$lisuni = $unidad1;
			$f = 0;
			while($f<=$nreg=odbc_fetch_array($cur_unidad))
			{
				if (odbc_result($cur_unidad, 40) <> 0) $lisuni = $lisuni.",".odbc_result($cur_unidad, 1);
				$f++;	
			}   //while
			$consulta_unidad = "select * from cx_org_sub where unidad in (".$lisuni.") order by dependencia";
			break;
		} //switch

		$cur_unidad = odbc_exec($conexion,$consulta_unidad);
		$nreg = odbc_num_rows($cur_unidad);
		$nreg1 = $nreg;
		$subdepen = Array($nreg);
		$suman_gastos = $suman_pagos = $suman_total = 0;
		$nota = "";
		$f = 1;
		$pos = 0;
		while($f<=$nreg=odbc_fetch_array($cur_unidad))
		{
			$subdepen[$f] = odbc_result($cur_unidad,3);
		
			//Consulta la dependencia
			$query1 = "select unidad, sigla, sigla1, fecha from cx_org_sub where subdependencia='$subdepen[$f]'";
			$cur1 = odbc_exec($conexion, $query1);
			$unid = odbc_result($cur1,1);
			$sigla = odbc_result($cur1,2);
			$var_uni = $sigla;
			
			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$sigla1 = trim(odbc_result($cur1,3));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,4)),0,10));	
			if ($sigla1 <> "") if ($fecha_pn1 >= $fecha_os) $var_uni = $sigla1;

			//Se consulta la centralizadora
			$query2 = "select subdependencia, especial from cx_org_sub where unidad='$unid' and unic='1'";
			$cur2 = odbc_exec($conexion, $query2);
			$centra = odbc_result($cur2,1);
			$esp = odbc_result($cur2,2);
			
			//Se consulta la tabla val_aut
			if ($esp <> 0)
			{
				$query4 = "select * from cx_org_sub where unidad = '".$esp."' and unic = 1";
				$cur4 = odbc_exec($conexion, $query4);
				$sub_esp = odbc_result($cur4,3);
				$consulta_subdepend = "select gastos, pagos, total from cx_val_aut where estado in ('V','I','G') and unidad = '".$subdepen[$f]."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'";
				$consulta_subdepend = $consulta_subdepend." and exists(select * from cx_inf_pla where unidad = '".$sub_esp."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and aprueba > 0 and revisa = 1)";
			}
			else $consulta_subdepend = "select gastos, pagos, total from cx_val_aut where estado in ('V','I','G') and unidad = '".$subdepen[$f]."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and exists(select * from cx_inf_pla where unidad = '".$centra."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and aprueba>0)";

			$cur_subdepend = odbc_exec($conexion,$consulta_subdepend);
			$nreg_subdepend = odbc_num_rows($cur_subdepend);

			if ($nreg_subdepend == 0)
			{
				$consulta_ip = "select * from cx_inf_pla where unidad = '".$subdepen[$f]."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'"; 
				$cur_ip = odbc_exec($conexion,$consulta_ip);
				$row = odbc_fetch_array($cur_ip);
				$nota_rec = trim($row[nota]);	
				$rechaza = odbc_result($cur_ip,10);
			}  //if

			$consulta_placen = "select gastos, pagos, recompensas, nota from cx_pla_cen where unidad = '".$subdepen[$f]."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'";
			$cur_placen = odbc_exec($conexion,$consulta_placen);
			$nreg_placen = odbc_num_rows($cur_placen);	
			if($nreg_placen <> 0) $descuento = str_replace(',','',trim(odbc_result($cur_placen,1)));
			if($nreg_subdepend <> 0)
			{
				$pos++;
				$actual1=$pdf->GetY();		
				$gastosiyc = odbc_result($cur_subdepend,1);
				$pagoasinf = odbc_result($cur_subdepend,2);
				$data[] = array($item.$pos, $var_uni, '$'.number_format($gastosiyc,2), '$'.number_format($pagoasinf,2));
				$suman_pagos = $suman_pagos + $gastosiyc; 
				$suman_gastos = $suman_gastos + odbc_result($cur_subdepend,2);
				$pdf->tablewidths = array(14, 82, 48, 48); 
				$pdf->morepagestable($data);
				unset($data);
				control_salto_pag($pdf->GetY());
			}  //if

			if ($rechaza == 1) $nota = $nota_rec;
			else $nota = $nota.trim(odbc_result($cur_placen,4));
			$f++;	 
		}  //while
		$actual=$pdf->GetY();

		$suman_total = $suman_total + $suman_pagos + $suman_gastos;
		$actual1=$pdf->GetY();		
		$pdf->RoundedRect(9,$actual1,192,4,0,'D');			
		$pdf->Cell(95,4,'SUMAN',0,0,'');
		$pdf->Cell(48,4,'$'.number_format($suman_pagos,2),1,0,'R');
		$pdf->Cell(48,4,'$'.number_format($suman_gastos,2),1,1,'R');	
		$pdf->Cell(143,4,'TOTAL',0,0,'');
		$pdf->Cell(48,4,'$'.number_format($suman_total,2),1,1,'R');	

		if (strlen($nota) > 0)
		{
			control_salto_pag($pdf->GetY());
			$actual=$pdf->GetY();
			$pdf->Ln(2);	
			$pdf->RoundedRect(9,$actual+2,192,4,0,'DF');
			$pdf->Cell(143,4,'NOTA',0,1,'');
			$pdf->SetFont('Arial','',7);
			$pdf->Multicell(190,4,$nota,0,'J');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(190,5,$linea,0,1,'C');
			$pdf->Ln(1);
		}   //if
		return $suman_total;
	} //titulo_c
	
	$consulta = "select * from cx_pla_nes where periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'";
	$cur = odbc_exec($conexion,$consulta);
	$nr = odbc_num_rows($cur);
	$fecha = substr(odbc_result($cur,2),0,10);
	$fecha_pn = substr(odbc_result($cur,2),0,10);

	$consulta1="select ciudad from Cx_org_sub where subdependencia = '".$_SESSION["uni_usuario"]."'"; 
	$cur1 = odbc_exec($conexion,$consulta1);

	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0);
	$pdf->Cell(190,3,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(25,4,'Lugar y Fecha,',0,0,'');
	$pdf->Cell(166,4,strtr(trim(odbc_result($cur1,1)), $sustituye)."   -   ".$fecha,B,1,'L');
	$pdf->Ln(2);	
	$pdf->Cell(107,4,'NECESIDADES DE INTELIGENCIA Y CONTRAINTELIGENCIA DEL MES DE:',0,0,'');
	$pdf->Cell(84,4,$n_meses[$_GET['periodo']-1],B,1,'');

	//Sección uno..........
	$pdf->Ln(2);	
	$pdf->RoundedRect(9,$actual+15,192,4,0,'DF');
	$pdf->Cell(191,4,$secciones[0],0,1,'');
	$pdf->Ln(1);
	
	$suman_recursos = 0;
	for ($y=0;$y<=2;$y++)
	{
		$actual=$pdf->GetY();
		$suman_recursos = $suman_recursos + titulo_c($actual, $y, $titulos1[$y], $unidades1[$y], '1', $item1[$y], $fecha_pn);
		control_salto_pag($pdf->GetY());
	} //for

	$actual=$pdf->GetY();
	$pdf->Ln(2);
	$pdf->RoundedRect(9,$actual+2,192,4,0,'DF');
	$pdf->Cell(143,4,$cierre_sec[0],0,0,'');
	$pdf->Cell(48,4,'$'.number_format($suman_recursos,2),0,1,'R');	
	$suman_sicie = $suman_sicie + $suman_recursos;
	$pdf->Ln(5);

	//Sección dos..........
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,4,0,'DF');
	$pdf->Cell(191,4,$secciones[1],0,1,'');
	$pdf->Ln(1);	
	
	$suman_recursos = 0;
	for ($y=0;$y<=2;$y++)
	{
		$actual=$pdf->GetY();
		$suman_recursos = $suman_recursos + titulo_c($actual, $y, $titulos2[$y], $unidades2[$y], '2', $item2[$y], $fecha_pn);
		control_salto_pag($pdf->GetY());
	} //for

	$actual=$pdf->GetY();
	$pdf->Ln(2);	
	$pdf->RoundedRect(9,$actual+2,192,4,0,'DF');
	$pdf->Cell(143,4,$cierre_sec[1],0,0,'');
	$pdf->Cell(48,4,'$'.number_format($suman_recursos,2),0,1,'R');	
	$suman_sicie = $suman_sicie + $suman_recursos;	
	$pdf->Ln(5);
	
	//Sección tres..........	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,4,0,'DF');
	$pdf->Cell(191,4,$secciones[2],0,1,'');
	$pdf->Ln(1);
   
	$suman_recursos = 0;
	for ($y=0;$y<=13;$y++)
	{
		$actual=$pdf->GetY();
		$suman_recursos = $suman_recursos + titulo_c($actual, $y, $titulos3[$y], $unidades3[$y], '3', $item3[$y], $fecha_pn);	
		control_salto_pag($pdf->GetY());		
	} //for
	
	$actual=$pdf->GetY();
	$pdf->Ln(2);	
	$pdf->RoundedRect(9,$actual+2,192,4,0,'DF');
	$pdf->Cell(143,4,$cierre_sec[2],0,0,'');
	$pdf->Cell(48,4,'$'.number_format($suman_recursos,2),0,1,'R');
	$suman_sicie = $suman_sicie + $suman_recursos;
	$pdf->Ln(2);
	
	//Sección cuatro..........	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Ln(2);	
	$pdf->RoundedRect(9,$actual+2,192,4,0,'DF');
	$pdf->Cell(143,4,$cierre_sec[3],0,0,'');
	$pdf->Cell(48,4,'$'.number_format($suman_sicie,2),0,1,'R');	
	$pdf->Cell(190,5,$linea,0,1,'C');

	//Sección cinco..........
	$consulta_planes = "select * from cx_pla_nes where periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'"; 
	$cur_planes = odbc_exec($conexion,$consulta_planes);
	$n_elaboro = strtr(trim(odbc_result($cur_planes,11)), $sustituye);
	$n_reviso1 = trim(odbc_result($cur_planes,12));
	$n_reviso2 = trim(odbc_result($cur_planes,13));
	$n_aprueba = trim(odbc_result($cur_planes,14));

	//Busca imagen de la firma Aprobo
	$consulta_fr = "select firma, usuario, cargo FROM cx_usu_web WHERE nombre='$n_aprueba'";
	$cur_fr = odbc_exec($conexion, $consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)
	{
		$f_aprobo = trim(odbc_result($cur_fr,1));
		$usuario_fr = trim(odbc_result($cur_fr,2));
		$c_aprobo = strtr(trim(odbc_result($cur_fr,3)), $sustituye);
		$data = str_replace('data:image/png;base64,', '', $f_aprobo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$usuario_fr.'.png';
		$success = file_put_contents($file, $data);
		$tamaño = getimagesize($file);
		//if ($tamaño[0] <> 317) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';

	control_salto_pag($pdf->GetY());	
	$pdf->Cell(60,5,$cierre_sec[4],0,1,'');	
	$texto="Consolidada de necesidades de la Capacidad de la Inteligencia Especializada, Capacidad de Inteligencia de Combate y la Capacidad de Contrainteligencia por parte de la DIADI, se autoriza la transferencia de recursos a las Unidades ejecutoras de gastos reservados, para la realización de pagos de informaciones y gastos en la financiación de actividades de inteligencia y contrainteligencia determinadas en el presente plan.";
	$pdf->Multicell(191,3,$texto,0,'J');
	$pdf->Ln(35);
	$actual=$pdf->GetY();
	//$pdf->Image($file,90,$actual-20,30,26);
	$pdf->Ln(4);	
	$pdf->Cell(192,5,'_____________________________________________',0,1,'C');	
	$pdf->Cell(192,5,$n_aprueba,0,1,'C');
	$pdf->Cell(64,5,'',0,0,'C');
	$pdf->Cell(60,5,$c_aprobo,0,1,'C');
	$pdf->Cell(190,5,$linea,0,1,'C');		
	
	control_salto_pag($actual);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(1);
	$pdf->Multicell(190,3,$texto,0,'J');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+2,192,10,0,'D');	
	$pdf->Ln(2);
	$pdf->Cell(15,5,'Elaboró:',0,0,'');
	$pdf->Cell(90,5,$n_elaboro,0,0,'L');
	$pdf->Cell(15,5,'Revisó:',0,0,'');
	$pdf->Cell(49,5,$n_reviso2,0,1,'L');
	$pdf->Cell(120,5,'',0,0,'L');
	$pdf->Cell(49,5,$n_reviso1,0,1,'L');
	$pdf->Cell(120,5,'',0,0,'L');	
	$pdf->Cell(49,5,'',0,1,'L');
	$pdf->Ln(-2);

	$nom_pdf="pdf/PlanNece_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	//$pdf->Output();	
	$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
