<?php
/* 1834.php
   INFORME VERIFICACIÓN SOLICITUDES RECURSOS ADICIONALES.
http://192.168.1.107:8086/GASTOS/fpdf/1834.php
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
			$this->RotatedText(55,200,$sigla,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(190,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(55,5,'INFORME VERIFICACIÓN',0,0,'C');
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'SOLICITUDES RECURSOS',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-1834',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'ADICIONALES',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'',0,0,'C');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2022-12-21',0,1,'');

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
					if ($this->tablewidths[$col] == 24) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	$lugar = "Bogotá";

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=266.00125) $pdf->addpage();
	} //control_salto_pag
	
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(-1);
	$ano = $_GET['ano'];
	if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
	else $ajuste = "0";

	$consulta = "select * from cx_sol_aut where conse = '".$_GET['conse']."' and ano = '".$_GET['ano']."'";
	$cur = odbc_exec($conexion,$consulta);	
	$fecha = substr(odbc_result($cur,2),0,10);
	$planes = trim(decrypt1(odbc_result($cur,6), $llave));
	$fir = trim(decrypt1(odbc_result($cur,8), $llave));
	$asunto = trim(odbc_result($cur,9));
	$sustentacion = trim(odbc_result($cur,10));
	$observacion = trim(odbc_result($cur,11));
	$n_elaboro = trim(odbc_result($cur,12));	

	$consulta_usuweb = "select usuario, nombre, cargo from cx_usu_web where usuario = '".$usu_usuario."'";
	$cur_usuweb = odbc_exec($conexion,$consulta_usuweb);
	$c_elaboro = trim(odbc_result($cur_usuweb,3));

	$num_fir = explode("|",$fir);
	for ($i=0;$i<count($num_fir);++$i)
	{
		$fir1[$i] = $num_fir[$i];
	}   //for

	$inter[0]["nom"] = $n_elaboro;
	$inter[0]["cargo"] = $c_elaboro;
	for ($i=0;$i<count($fir1);$i++)
	{
		$fir2 = explode("»",$fir1[$i]);
		$fir2[0] = substr($fir2[0],0,-1);
		$inter[$i+1]["nom"] = $fir2[0]; 
		$inter[$i+1]["cargo"] = $fir2[1];
	}   //for

	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(191,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(9,5,'',0,0,'');
	$pdf->Cell(110,5,'Radicado.',0,0,'R');
	$pdf->Cell(72,5,$_GET['conse'],1,1,'C');
	$pdf->RoundedRect(9,$actual+5,192,5,0,'');
	$pdf->Cell(39,5,'LUGAR Y FECHA:',0,0,'');
	$pdf->Cell(152,5,$lugar.' - '.$fecha,1,1,'L');

	$actual=$pdf->GetY();
	$i++;
	$aa = ($i*8)+($i*5);
	$pdf->RoundedRect(9,$actual,192,$aa,0,'');
	$pdf->Cell(39,5,'INTERVIENEN:',0,0,'');
	$texto1_int = "\n";

	for ($i=count($inter)-1;$i>=0;$i--)
	{
		$texto1_int = $texto1_int.$inter[$i]["nom"]."\n";
		$texto1_int = $texto1_int.$inter[$i]["cargo"]."\n\n";
	}   //for
	$pdf->Multicell(152,4,$texto1_int,1,'L');

	$actual=$pdf->GetY();
	$l_asunto = strlen($asunto);
    if ($l_asunto <= 87) $aa = 5;
    else $aa = ceil($l_asunto/87)*5;
 
	$pdf->RoundedRect(9,$actual,192,$aa,0,'');
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->Multicell(39,5,'A S U N T O:',0,'L');
	$pdf->RoundedRect(49,$actual,152,$aa,0,'');	
	$pdf->SetXY($x+39,$y);		
	$pdf->Multicell(152,4,$asunto,0,'J');
	$pdf->Ln(4);		
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,7,0,'');
	$pdf->Cell(192,7,'I.  SOLICITUD(ES) DE RECURSOS ADICIONALES OBJETO DE VERIFICACIÓN DEL CUMPLIMIENTO DE REQUISITOS:',0,1,'L');	

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'DF');
	$pdf->Cell(11,10,'RAD',R,0,'C');
	$pdf->Cell(54,5,'UNIDAD',0,0,'C');
	$pdf->Cell(48,10,'CONCEPTO',1,0,'C');
	$pdf->Cell(48,10,'AMENAZA',1,0,'C');
	$pdf->Cell(30,5,'VALOR',0,0,'C');
	$pdf->Cell(0,5,'',0,1);

	$pdf->Cell(11,10,'',0,0,'');
	$pdf->Cell(27,5,'SOLICITANTE',1,0,'C');
	$pdf->Cell(27,5,'CENTRALIZADORA',1,0,'C');
	$pdf->Cell(48,1,'',0,0,'');
	$pdf->Cell(48,1,'',0,0,'C');   
	$pdf->Cell(30,5,'SOLICITADO',0,1,'C');

	$consulta1 = "select * from cx_pla_inv where conse in (".$planes.") and ano = '".$_GET['ano']."' order by conse";
	$cur1 = odbc_exec($conexion,$consulta1);
	$rr = 
	$tvsol = 0;
	$tvaprobado = 0;
	$vsol = 0;
	$vaprobado = 0;
	$anexos1 = "";
	$rg=1;
	$pdf->tablewidths = array(12, 27, 27, 48, 48, 30); 
    while($rg<$row=odbc_fetch_array($cur1))
    {
		$conse = odbc_result($cur1,1);
		$tipo =  odbc_result($cur1,20);
		$tipo1 =  odbc_result($cur1,27);

		$consulta2 = "select * from cx_val_aut1 where solicitud='".$conse."' and ano = '".$_GET['ano']."'";
		$cur2 = odbc_exec($conexion,$consulta2);
		$radicado = trim(odbc_result($cur2,21));
		$division = trim(odbc_result($cur2,17));
		$cod_usolicita = trim(odbc_result($cur2,4));
		$unidadsol = trim(odbc_result($cur2,7));		
		$unidadcen = trim(odbc_result($cur2,15));
		$anexos1 = $anexos1.$radicado." - ".$unidadsol."; ";

		$consulta_osub = "select * from cx_org_sub where subdependencia='$cod_usolicita'";
		$cur_osub = odbc_exec($conexion,$consulta_osub);
		$cunidad = odbc_result($cur_osub,1);
		if ($cunidad < 18 and $cunidad > 3) $unidadcen = trim(odbc_result($cur2,17));

    	if ($tipo1 == '1')
    	{
			$rad = odbc_result($cur1,1);
			$concepto = "Gastos Actividades";
			$n_ordop1 = trim(decrypt1(odbc_result($cur1,14), $llave));
			$n_ordop = strtr($n_ordop1, $sustituye);
			$mision = substr(trim(decrypt1(odbc_result($cur1,16), $llave)),0,-1);
			$mision_s = str_replace("|","\n",$mision);
			$ordopmision = utf8_decode($n_ordop." - ".$mision);
			$factor_amenaza = trim(odbc_result($cur1,7));
			$l_estructura = trim(odbc_result($cur1,8));
			$consulta3 = "select * from cx_pla_gas where conse1='".$conse."' and ano = '".$_GET['ano']."'";
		    $cur3 = odbc_exec($conexion,$consulta3);
		    $valgas = 0;
			$gas=0;
			while($gas<$row=odbc_fetch_array($cur3))
			{		    
				$valgas = $valgas + substr(str_replace(',','',trim(odbc_result($cur3,14))),0);
				$gas++;
			}   //while
			$vsol = $vsol + $valgas;
			$alto = 10;
		}	
    	else   //$tipo = '2'
    	{
			$concepto = "Pago de Información";
			$ordopmision = "";					    
		    $consulta4 = "select * from cx_pla_pag where conse='".$conse."' and ano = '".$_GET['ano']."'";
		    $cur4 = odbc_exec($conexion,$consulta4);
		    $valpag = 0;
			$pag=0;
			while($pag<$row=odbc_fetch_array($cur4))
			{		    
				$valpag = $valpag + substr(str_replace(',','',trim(odbc_result($cur4,17))),0);
				$gas++;                   
			}   //while			
			$vsol = $vsol + $valpag;
			if (trim(odbc_result($cur4,6)) == '999') $factor_amenaza = "N/A";
			else $factor_amenaza = trim(odbc_result($cur4,6));
			if (trim(odbc_result($cur4,7)) == '999') $l_estructura = "N/A";
			else $l_estructura = trim(odbc_result($cur4,7));
		}   //if

		$texto_int = "";
		if (trim(odbc_result($cur1,7)) == '999')
		{
			$factor_amenaza = "N/A";
			$texto_int = $texto_int."N/A".",";
		}
		else
		{
			$amenazas = explode(",",$factor_amenaza);
			for ($ii=0;$ii<count($amenazas);++$ii)
			{
				$consulta_ame = "select nombre from cx_ctr_fac where codigo = '".$amenazas[$ii]."'";
				$cur_ame = odbc_exec($conexion,$consulta_ame);
				$ame = trim(odbc_result($cur_ame,1));
				if ($ame <> "") $texto_int = $texto_int.$ame.",";
				else $texto_int = $texto_int."N/A".",";
			}	//for				
		}   //if 
		
		if (trim(odbc_result($cur1,8)) == '999')
		{
			$l_estructura = "N/A"; 
			$texto_int = $texto_int."N/A".",";
		}
		else 
		{
			$estructura = explode(",",$l_estructura);
			$texto_int = substr($texto_int,0,-1)." - Estructura: ";
			for ($ii=0;$ii<count($estructura);++$ii)
			{
				$consulta_est = "select nombre from cx_ctr_est where codigo = '".$estructura[$ii]."'";
				$cur_est = odbc_exec($conexion,$consulta_est);
				$est = trim(odbc_result($cur_est,1));
				if ($est <> "") $texto_int = $texto_int.$est.",";
				else $texto_int = $texto_int."N/A".",";
			}	//for		
		}   //if
		if ($factor_amenaza == "N/A" and $l_estructura = "N/A") $texto_int = "N/A";
       	$vaprobado = substr(str_replace(',','',trim(odbc_result($cur2,10))),0);
		control_salto_pag($pdf->GetY());    	
		$actual=$pdf->GetY();
		$concepto = $concepto." ".$ordopmision;
		$texto_int = $texto_int;
		$data[] = array($radicado, $unidadsol, $unidadcen, $concepto, $texto_int, '$'.number_format($vsol,2), '$'.number_format($vaprobado,2));
		$pdf->morepagestable($data);
		unset($data);		
		$tvsol = $tvsol + $vsol;
		$vsol = 0;
		$tvaprobado = $tvaprobado + $vaprobado;
		$rg++;
	}   //while
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();	
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(161,5,'TOTAL',0,0,'R');
	$pdf->Cell(30,5,'$'.number_format($tvaprobado,2),1,1,'R');
	$pdf->SetFont('Arial','',8);
		
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,7,0,'');	
	$pdf->Cell(192,7,'II.  CUMPLIMIENTO DE REQUISITOS:',0,1,'L');
	$actual=$pdf->GetY();

	$aa = ceil(strlen($sustentacion)/110)*5;
	$pdf->Ln(2);
	$pdf->Multicell(191,4,$sustentacion,0,'J');    
	$pdf->Ln(1);
	$pdf->Cell(190,3,$linea,0,1,'C');
			
	$actual=$pdf->GetY();
	$aa = ceil(strlen($anexos1)+110/110)*3;	
	$anexos = "Anexo: Solicitudes de recursos adicionales\n";
	$pdf->Ln(2);
	$pdf->Multicell(191,4,$anexos.$anexos1,0,'L');
	$pdf->Cell(190,3,$linea,0,1,'C');

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();	
	$pdf->Cell(192,5,'III.  OBSERVACIONES:',0,1,'L');	
	$pdf->Ln(1);
	$pdf->Multicell(191,4,$observacion,0,'L');
	$pdf->Cell(190,3,$linea,0,1,'C');
	
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	//$pdf->Cell(192,5,'IV.     CIERRE',0,1,'L');	
	$cierre = "No siendo otro el objeto de la presente, se da por terminada y en constancia firman los que intervinieron.";
	$pdf->Cell(191,10,$cierre,0,1,'L');	

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	if ($ajuste > 0) $pdf->Ln($ajuste);
	$pdf->Ln(20);
	$nfir = count($inter);
	if ($nfir % 2 == 0) $cmp = count($inter);
	else $cmp = count($inter)-1;

	for ($i=0;$i<$cmp;$i=$i+2)
	{
		$pdf->Cell(15,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["nom"],T,0,'C'); 
		$pdf->Cell(16,4,'',0,0,'C');		
		$pdf->Cell(72,4,$inter[$i+1]["nom"],T,1,'C');
		$pdf->Cell(15,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,0,'C');
		$pdf->Cell(16,4,'',0,0,'C');		
		$pdf->Cell(72,4,$inter[$i+1]["cargo"],0,1,'C');
		$n = (count($inter)/2);
		if ($i == $n) $pdf->Cell(190,0,'',0,1,'C');
		else $pdf->Cell(190,13,'',0,1,'C');	
		$pdf->Ln(16);		
	}   //for
	if ($nfir % 2 <> 0)
	{	
		$pdf->Cell(55,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["nom"],T,1,'C');
		$pdf->Cell(55,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,1,'C');
	}   //if	

	control_salto_pag($pdf->GetY());
	$pdf->Cell(190,3,$linea,0,1,'C');
	$texto = "NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$actual=$pdf->GetY();
	$pdf->Multicell(190,3,$texto,0,'J');
	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(60,5,'Elaboró:    '.$n_elaboro,0,1,'');

	ob_end_clean();
	$nom_pdf="pdf/InfAuto_".trim($sigla1)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
