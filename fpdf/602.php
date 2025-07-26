<?php
/* 602.php
   ACTA EVALUACIÓN COMITÉ REGIONAL DE RECOMPENSAS.
   (pág 147 - "Dirtectiva Permanente No. 00000 de 20.PDF")
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
			$sigla = $_SESSION["sig_usuario"];
			
			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(55,200,$sigla,35); 

			$this->SetFont('Arial','B',11);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(85,5,'',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->SetFont('Arial','B',14);		
			$this->Cell(85,5,'ACTA EVALUACIÓN COMITÉ',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->SetFont('Arial','B',14);			
			$this->Cell(85,5,'REGIONAL DE RECOMPENSAS',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(85,5,'',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(89,3,'',0,0,'');
			$this->Cell(85,3,'',0,1,'');

			$this->RoundedRect(9,15,107,26,0,'');
			$this->RoundedRect(116,15,85,26,0,'');
			$this->RoundedRect(9,15,192,268,0,'');
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
		}//RoundedRect($x,$y,$w,$h,$r,$style='')

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc($x1, $y1, $x2, $y2, $x3, $y3)

		function morepagestable($datas, $lineheight=4)
		{
			$l = $this->lMargin;
			$startheight = $h = $this->GetY();
			$startpage = $currpage = $maxpage = $this->page;
			$pag_act = $this->page;
			$fullwidth = 0;
			foreach($this->tablewidths AS $width) $fullwidth += $width;
			foreach($datas AS $row => $data)
			{
				$this->page = $currpage;
				$this->Line($l+1,$h,$fullwidth+$l+1,$h);
				foreach($data AS $col => $txt)
				{
					$this->page = $currpage;
					$act = $this->GetY();
					$this->SetFont('Arial','',8);
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 44 or $this->tablewidths[$col] == 33) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
			$this->Line($l+1,$h,$fullwidth+$l+1,$h);
			
			for($i = $startpage; $i <= $maxpage; $i++)
			{
				$this->page = $i;
				$l = $this->lMargin;
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
  			$fecha1="";
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - Página: '.$this->PageNo().' de {nb}',0,1,'');
  			//$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',11);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(190,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
  			$this->Code39(182,285,$cod_bar,.5,5);
		}//Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
	$reemplazar = array("", "", "", "", "", "" , "");
	$n_meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$linea = str_repeat("_",108);
	$linea1 = str_repeat("_",89);
	$linea2 = str_repeat("_",122);
	$lugar = $ciu_usuario;
	$directivas = array("No. 01 del 17 de Febrero de 2009","No. 21 del 5 de Julio de 2011","No. 16 del 25 de Mayo de 2012","No. 02 del 16 de Enero de 2019");
	
	function control_salto_pag($actual1)
	{
		global $pdf, $sp;
		$sp = 0;
		$actual1=$actual1+5;
		if ($actual1>=259.00125)
		{
			$pdf->addpage();
			$sp = 1;
		}
		return $sp;
	} //control_salto_pag
	
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(-1);
	
	$conse = $_GET['conse'];
	$ano = $_GET['ano'];
	if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
	else $ajuste = "0";
	$hoja = $_GET['hoja'];

	$consulta = "select * from cx_act_reg where conse = '".$conse."' and ano = '".$ano."'";
	$cur = odbc_exec($conexion,$consulta);
	$row = odbc_fetch_array($cur);
	$unidad = odbc_result($cur,4);
	$registro = odbc_result($cur,7);
	$ano1 = odbc_result($cur,8);
	$vlrsol = odbc_result($cur,9);

	$fecha = odbc_result($cur,2);
	$m_fecha = substr($fecha, 5, 2);
	if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
	$fecha = substr($fecha, 8, 2)." de ".$n_meses[$m_fecha -1]." de ".substr($fecha, 0, 4);

	$directiva = odbc_result($cur,10);
	$n_directiva = $directivas[$directiva-1];
	$firmas = $row['firmas'];
	$firmas = explode("|",$firmas);
	$inter_txt = "";
	for ($fir=0;$fir<=count($firmas)-2;$fir++)
	{
		$interv = explode("»",$firmas[$fir]);
		$inter[$fir]["nom"] = $interv[0];
		$inter[$fir]["cargo"] = $interv[1];
		$inter_txt = $inter_txt.$inter[$fir]["nom"]."\n".$inter[$fir]["cargo"]."\n\n";
	}   //for
	 
	$sintesis = trim($row['sintesis']);
	$concepto = trim($row['concepto']);
	$recomendaciones = trim($row['recomendaciones']);
	$observaciones = trim($row['observaciones']);
	$neutralizados = trim($row['neutralizados']);
	$totaln = trim(odbc_result($cur,14));
	$material = trim($row['material']);	
	$totalm = trim(odbc_result($cur,16));
	$totala = trim(odbc_result($cur,17));
	$acta = trim(odbc_result($cur,22));
	$constancia = trim(odbc_result($cur,23));
	$folio = trim(odbc_result($cur,24));
	$valoracion = trim($row['valoracion']);
	$n_reviso = trim($row['reviso']);

	$consulta_rec = "select * from cx_reg_rec where conse = '".$registro."' and ano = '".$ano1."' order by conse";
	$cur_rec = odbc_exec($conexion,$consulta_rec);
	$usuario = trim(odbc_result($cur_rec,3));
	$unidad_rec = trim(odbc_result($cur_rec,4));
	$fec_res = trim(odbc_result($cur_rec,8));
	$uni_man = odbc_result($cur_rec,16);
	$uni_efec = odbc_result($cur_rec,17);
	$brigada = odbc_result($cur_rec,18);
	if (trim(odbc_result($cur_rec,24)) == "") $ordop = "N/A";
	else $ordop = odbc_result($cur_rec,24)." - ".odbc_result($cur_rec,25);
	if (trim(odbc_result($cur_rec,27)) == "") $fragmenta = "N/A";
	else $fragmenta = odbc_result($cur_rec,27);
	$actas = odbc_result($cur_rec,39);
	if (substr($actas,-1) == "|") $actas = substr($actas,0,-1);
	if ($actas == 0) $actas = "";
	$fecha_act = odbc_result($cur_rec,40);
	if (substr($fecha_act,-1) == "|") $fecha_act = substr($fecha_act,0,-1);
	$valor_act = odbc_result($cur_rec,41);
	if (substr($valor_act,-1) == "|") $valor_act = substr($valor_act,0,-1);
	$lista = odbc_result($cur_rec,47);
	$usuario1 = trim(odbc_result($cur_rec,48));
	$usuario2 = trim(odbc_result($cur_rec,49));
	$p_lista = explode("|",$lista);
	$oficio2 = $p_lista[1];
	$fec_ofi2 = $p_lista[2];
	$oficio = $p_lista[6];
	$fec_ofi = $p_lista[7];

	$consulta1 = "select * from cx_org_sub where subdependencia = '".$unidad."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$n_unidad = trim(odbc_result($cur1,6));
	$siguom = trim(odbc_result($cur1,4));
	if (substr($siguom,0,3) == 'DIV') $siguom = substr($siguom,0,3).substr($siguom,-1);

	if ($usuario2 == "")
	{
		$seccion = "B2";
		$consulta_uw = "select * from cx_usu_web where usuario = '".$usuario1."'";
	}
	else
	{
		$sección = "C2";
		$consulta_uw = "select * from cx_usu_web where usuario = '".$usuario2."'";	
	}   //if
	$cur_uw = odbc_exec($conexion,$consulta_uw);
	$tipo = trim(odbc_result($cur_uw,10));
	$subdep = trim(odbc_result($cur_uw,11));

	$consulta1 = "select * from cx_org_sub where subdependencia = '".$subdep."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$sigla_uni = trim(odbc_result($cur1,4));

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(191,5,'DE USO EXCLUSIVO',0,1,'R');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,6,0,'');
	$pdf->Cell(42,6,'NOMBRE DE UNIDAD:',0,0,'');
	$pdf->Cell(105,6,$n_unidad,1,0,'L');
	$pdf->Cell(13,6,'ACTA NR.',0,0,'L');
	if ($acta != 0) $pdf->Cell(34,6,$acta,0,1,'C');
	else $pdf->Cell(34,6,$_GET['conse'],0,1,'C');
	$pdf->RoundedRect(9,$actual+6,192,6,0,'');
	$pdf->Cell(42,6,'LUGAR Y FECHA:',0,0,'');
	$pdf->Cell(149,6,strtoupper($lugar.', '.$fecha),1,1,'L');
	
	$actual=$pdf->GetY();
	$pdf->Cell(42,4,'INTERVIENEN:',0,0,'');
	$pdf->Multicell(149,4,$inter_txt,1,'L');

	$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_efec."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	if (odbc_num_rows($cur1) > 0)	
	{
		$s_unidad_afec = trim(odbc_result($cur1,4));
		$n_unidad_afec = trim(odbc_result($cur1,6));
	}
	else
	{
		$consulta1 = "select * from cx_org_bat where conse = '".$brigada."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$s_unidad_afec = trim(odbc_result($cur1,2));
		$n_unidad_afec = "";		
	}   //if

	$asunto = "Trata del estudio que hace el comité regional de recompensas al expediente remitido por la sección ".$seccion." de la ".$sigla_uni.", mediante oficio No. ".$oficio." de fecha ".$fec_ofi;
    $asunto = $asunto." correspondiente al resultado registrado el día ".$fec_res." en cumplimiento a la orden de operaciones ".$ordop.", orden fragmantaria ".$fragmenta;
    $asunto = $asunto." adelantada por tropas del ".$s_unidad_afec.".\n\n";

	$mx = strlen($asunto);
	if ($mx > 115) $ax = ceil($mx/110);
	else if ($ax < 110) $ax = 12;
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,43,$ax*$ax+$ax,0,'');
	$pdf->Cell(42,$ax,'ASUNTO:',0,0,'');
	$pdf->Multicell(149,$ax,$asunto,1,'J');

	$actual=$pdf->GetY();
	$alefecto = "\nI.     AL EFECTO SE PROCEDE COMO A CONTINUACIÓN SE RELACIONA\nUna vez revisado y analizado el expediente objeto del trámite de recompensas se concluye que este contiene todos los documentos exigidos en la Directiva Ministerial Permanente ".$n_directiva.", por lo tanto, el Comité Regional de Recompensas procede a efectuar su evaluación y valoración.";
	$alefecto = $alefecto."\n\nAnexo: Expediente Operacion Militar ".$ordop." - ".$n_ordop." orden fragmentaria ".$fragmenta; 
	$pdf->Multicell(191,5,$alefecto,0,'J');
	$pdf->Cell(191,3,$linea2,0,1,'C');	

	$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_man."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$s_uni_man = trim(odbc_result($cur1,4));
	$n_uni_man = trim(odbc_result($cur1,6));

	$actual=$pdf->GetY();
	$vlrsolicit = "\nII.     VALOR SOLICITADO POR LA UNIDAD\nSegún oficio No. ".$oficio2." de fecha ".$fec_ofi2." del ".$s_uni_man.", solicita por la información que condujo al resultado operacional la suma de $".$vlrsol;
	$pdf->Multicell(191,5,$vlrsolicit,0,'J');
	$pdf->Cell(191,3,$linea2,0,1,'C');	
		
	$actual=$pdf->GetY();
	$certi = "\nIII.     CERTIFICACIÓN DE LA FUENTE\nSegún la certificación anexa a folio ".$constancia." existe una fuente que aportó información que condujo al planeamiento y/o desarrollo de la orden de operaciones ".$ordop.", orden fragmantaria ".$fragmenta.", adelantada por tropas del ".$s_unidad_afec." - ".$n_unidad_afec.".";

	if ($actas == "" and $fecha_act == "" and $valor_act == "") $certi = $certi."\n\nLa fuente no registra pagos previos.";
	else
	{
		$v_actas = explode("|",$actas);
		$v_fecha_act = explode("|",$fecha_act);
		$v_valor_act = explode("|",$valor_act);
		$texto_act = "";
		for ($i=0;$i<=count($v_actas)-1;$i++)
		{
			$texto_act = $texto_act.$v_actas[$i]." de fecha ".$v_fecha_act[$i]." por valor de $".$v_valor_act[$i].", ";
			if ($i < count($v_actas)-1) $texto_act = $texto_act." acta No.: ";
		}   //for
		$texto_act = substr($texto_act,0,-2).".";
		$certi = $certi."\n\nLa(s) fuente(s) registra(n) pago(s) previo(s) según acta(s) No. ".$texto_act;
	}   //if
	$pdf->Multicell(191,5,$certi,0,'J');
	$pdf->Cell(191,3,$linea2,0,1,'C');	

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$infof = "\nIV.     INFORMACIÓN SUMINISTRADA POR LA FUENTE, REGISTRO Y EMPLEO EN EL PROCESO DE LA INFORMACIÓN DE INTELIGENCIA Y CONTRAINTELIGENCIA.\n\n".$sintesis;
	$pdf->Multicell(191,5,$infof,0,'J');
	$pdf->Cell(191,3,$linea2,0,1,'C');		

	if ($pdf->PageNo() == 1 and $hoja == 1)
	{
		$pdf->addpage();
		$pdf->SetFont('Arial','',40);
		$pagb = "\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n";
		$pdf->Multicell(191,5,$pagb,0,'C');
		$pdf->SetFont('Arial','',8);		
		$pdf->addpage();
	}   //if	

	$pdf->SetFont('Arial','',9);
	$vlrcion = "\nV.     VALORACIÓN DE LA SOLICITUD DE PAGO DE RECOMPENSAS POR LA INFORMACIÓN(S) SUMINISTRADA(S) POR LA(S) FUENTE(S) E IMPACTO.\n\nA.  Neutralizados";
	$pdf->Multicell(191,5,$vlrcion,0,'J');	
	$pdf->Ln(1);	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(10,$actual,190,10,'');
	$pdf->Cell(12,5,'',0,0,'C');
	$pdf->Cell(88,5,'',L,0,'C');
	$pdf->Cell(45,5,'MONTOS DIRECTIVA',L,0,'C');
	$pdf->Cell(45,5,'',L,1,'C');
	$pdf->Cell(12,5,'NIVEL',0,0,'C');
	$pdf->Cell(88,5,'IDENTIDAD',L,0,'C');
	$pdf->Cell(45,5,'(HASTA)',L,0,'C');
	$pdf->Cell(45,5,'VALORACIÓN',L,1,'C');

	$neutral = explode("|",$neutralizados);
	$cn = count($neutral)-2;
	$actual=$pdf->GetY();	
	$x = 0;
	$y = $pdf->Gety();		
	for ($f=0;$f<=$cn;$f++)
	{
		$neutral1 = explode("»",$neutral[$f]);
		$le = strlen($neutral1[1]);
		if ($le >= 55)
		{
			$aa = floor($le/55)*3.6;
			if ($aa < 10) $aa = 10;
		}
		else $aa = 10;			

		if (substr($neutral1[0],0,1) == 1) $elem = "I";
		if (substr($neutral1[0],0,1) == 2) $elem = "II";
		if (substr($neutral1[0],0,1) == 3) $elem = "III";
		if (substr($neutral1[0],0,1) == 4) $elem = "IV";
		if (substr($neutral1[0],0,1) == 5) $elem = "V";
		if (substr($neutral1[0],0,1) == 6) $elem = "VI";
		if (substr($neutral1[0],0,1) == 7) $elem = "VII";
		$pdf->RoundedRect(10,$y,12,$aa,0,'');
		$pdf->Multicell(12,$aa,$elem,0,'C');
		$pdf->SetXY($x+22,$y);
		$pdf->RoundedRect(22,$y,88,$aa,0,'');
		$pdf->Multicell(88,4,$neutral1[1],0,'J');
		$pdf->SetXY($x+94,$y);
		$pdf->RoundedRect(110,$y,45,$aa,0,'');
		$pdf->Multicell(60,$aa,'$'.trim(substr($neutral1[2],0)),0,'R');
		$pdf->SetXY($x+140,$y);
		$pdf->RoundedRect(155,$y,45,$aa,0,'');		
		$pdf->Multicell(60,$aa,'$'.trim(substr($neutral1[4],0)),0,'R');
		$x = 0;
		$y = $pdf->GetY();		
	}   //for

	$pdf->Cell(145,8,'SUBTOTAL',1,0,'L');
	$pdf->Cell(45,8,'$'.$totaln,1,1,'R');
	$pdf->Ln(1);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(191,3,$linea1,0,1,'C');
	$pdf->Cell(192,10,'Sustentación de la valoración (para neutralizaciones)',0,1,'L');
	$pdf->Multicell(191,5,$valoracion,0,'J');	
	$pdf->Cell(191,3,$linea1,0,1,'C');

	control_salto_pag($pdf->GetY());
	$pdf->Cell(182,10,'B.  Valoración elementos incautados',0,1,'L');	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',9);
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(10,$actual,190,10,'');
	$pdf->Cell(80,5,'',0,0,'C');
	$pdf->Cell(19,5,'',L,0,'C');
	$pdf->Cell(44,5,'V/R SEGÚN DIRECTIVA',L,0,'C');
	$pdf->Cell(14,5,'',L,0,'C');
	$pdf->Cell(33,5,'VR. TOTAL',L,1,'C');
	$pdf->Cell(80,5,'ELEMENTOS INCAUTADOS',L,0,'C');
	$pdf->Cell(19,5,'CANTIDAD',L,0,'C');
	$pdf->Cell(44,5,'(HASTA)',L,0,'C');
	$pdf->Cell(14,5,'ESTADO',L,0,'C');
	$pdf->Cell(33,5,'APROBADO',L,1,'C');	

	$materia = explode("|",substr($material,0,-1));
	$cn = count($materia);
	$stot = 0; 
	for ($r=0;$r<=$cn-1;$r++)
	{	
		$material1 = explode("»",$materia[$r]);
		$mat1 = explode(",",$material1[0]);		
		$np = count($material1);
		$consulta_mat = "select * from cx_ctr_mat where codigo = '".$mat1[0]."'";
		$cur_mat = odbc_exec($conexion,$consulta_mat);
		$elemento = trim(odbc_result($cur_mat,2));
		$elemento1 = preg_replace("/[\r\n|\n|\r]+/", " ", $elemento);
		if ($elemento1 == "") $elemento1 = "OMITIDO";
		$l_elemento1 = strlen($elemento1);
		if ($l_elemento1 <= 40) $aa = 6;
		else $aa = (ceil($l_elemento1/40)*5);
		if ($material1[2] == 0 or $material1[2] == "") $material1[2] = "0";
		if ($material1[6] == 0 or $material1[6] == "") $material1[6] = "0";
		
		$vlr1 = number_format(substr($material1[1],0,-1));
		$vlr2 = "$".number_format(trim($material1[3]),2);
		$vlr3 = "$".number_format(trim($material1[6]),2);
		$vlr4 = trim(substr($material1[4],0,-1));
		$data[] = array($elemento1, $vlr1, $vlr2, $vlr4, $vlr3);
		$stot = $stot + str_replace(',','',trim($material1[6]));
	}   //for
		
	$actual=$pdf->GetY();
	$pdf->tablewidths = array(80, 19, 44, 14, 33); 
	$pdf->morepagestable($data);
	unset($data);
	
	$pdf->Cell(157,8,'SUBTOTAL',1,0,'L');
	$pdf->Cell(33,8,'$'.number_format($stot,2),1,1,'R');
	$estado = "ESTADO Según registros del informe de peritaje\nO=Optimo  B=Bueno  D=Dañado o inservible";
	$pdf->SetFont('Arial','',9);
	$pdf->Multicell(190,5,$estado,1,'L');	
	$pdf->Cell(157,10,'TOTAL VALORACIÓN SOLICITUD DE PAGO DE RECOMPENSAS',1,0,'L');	
	$pdf->Cell(33,10,'$'.$totala,1,1,'R');
	$pdf->Ln(1);
	$pdf->Cell(190,3,$linea,0,1,'C');

	control_salto_pag($pdf->GetY());			
	$actual=$pdf->GetY();
	$pdf->Cell(192,5,'VI.     CONCEPTO DE EVALUACIÓN DEL COMITÉ REGIONAL',0,1,'L');	
	$pdf->Multicell(191,5,"\n".$concepto,0,'J');
	$pdf->Cell(190,3,$linea,0,1,'C');		
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Cell(192,5,'VII.     RECOMENDACIÓN PARA LA SOLICITUD DEL PAGO DE LA RECOMPENSA',0,1,'L');	
	$pdf->Multicell(191,5,"\n".$recomendaciones,0,'L');
	$pdf->Cell(190,3,$linea,0,1,'C');			
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Cell(192,5,'VIII.     OBSERVACIONES',0,1,'L');	
	$pdf->Multicell(191,5,"\n".$observaciones,0,'J');
	$pdf->Cell(190,3,$linea,0,1,'C');			

	control_salto_pag($pdf->GetY());	
	$actual=$pdf->GetY();
	$pdf->Cell(192,5,'',0,1,'L');	
	$cierre = "IX.     CIERRE\n\nNo siendo otro el objeto de la presente, se da por terminada y en constancia firman los que intervinieron en este comité";
	$pdf->Multicell(191,5,$cierre,0,'L');

	$pdf->SetFont('Arial','',8);
	for ($fir=count($inter)-1;$fir>=0;$fir=$fir-2)
	{
		control_salto_pag($pdf->GetY());
		if ($sp <> 0) $pdf->Cell(95,12,'',0,0,'C');
		if ($ajuste <> 0) $pdf->Ln(12 + $ajuste);
		else $pdf->Ln(18);
		$pdf->Cell(95,4,'_____________________________________________',0,0,'C');
		$pdf->Cell(95,4,'_____________________________________________',0,1,'C');
		$pdf->Cell(95,4,$inter[$fir]["nom"],0,0,'C');
		$pdf->Cell(95,4,$inter[$fir-1]["nom"],0,1,'C');
		$pdf->Cell(95,4,$inter[$fir]["cargo"],0,0,'C');
		$pdf->Cell(95,4,$inter[$fir-1]["cargo"],0,1,'C');
	}   //for
	$pdf->Cell(190,3,$linea2,0,1,'C');

	control_salto_pag($pdf->GetY());
	$texto = "NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$actual=$pdf->GetY();
	$pdf->Ln(1);
	$pdf->Multicell(191,3,$texto,0,'J');
	$pdf->Cell(190,4,$linea2,0,1,'C');
	$actual = $pdf->GetY();
	$pdf->Cell(95,4,'Elaboró:    '.$_SESSION["nom_usuario"],0,0,'');
	$pdf->Cell(95,4,'Revisó:    '.$n_reviso,0,1,'');
	$pdf->Cell(190,3,$linea2,0,1,'C');

	ob_end_clean();
	$nom_pdf="pdf/Actas/ActaComReg_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
