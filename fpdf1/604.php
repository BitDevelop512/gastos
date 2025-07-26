<?php
/* 604.php
   ACTA EVALUACIÓN COMITÉ CENTRAL DE INFORMACIÓN RECOMPENSAS.
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
			//$sigla = $_SESSION["sig_usuario"];
			$sigla = "CEDE2";
			
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
			$this->Cell(85,5,'CENTRAL DE INFORMACIÓN',0,1,'C');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(89,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->SetFont('Arial','B',14);	
			$this->Cell(85,5,'RECOMPENSAS',0,1,'C');
			

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(89,3,'',0,0,'');
			$this->Cell(85,3,'',0,1,'');

			$this->RoundedRect(9,15,107,26,0,'');
			$this->RoundedRect(116,15,85,26,0,'');
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
  			$this->Cell(190,4,'SIGAR - Página: '.$this->PageNo().' de {nb}',0,1,'');
  			//$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',11);
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
	$sustituye = array ( 'Á¡' => 'Á', 'Ã•' => 'Á', 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ãš' => 'Ú', 'ÃƒÂ“' => 'Ó', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Aagosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$linea = str_repeat("_",108); 
	$linea1 = str_repeat("_",89);
	$linea2 = str_repeat("_",122);
	$lugar = "Bogotá";
	$directivas = array("No. 01 del 17 de Febrero de 2009","No. 21 del 5 de Julio de 2011","No. 16 del 25 de Mayo de 2012","No. 02 del 16 de Enero de 2019");
	
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(-1);
	
	$conse = $_GET['conse'];
	$ano = $_GET['ano'];
	if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
	else $ajuste = "0";
	$hoja = $_GET['hoja'];

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=266.00125) $pdf->addpage();
	} //control_salto_pag
	
	$consulta = "select * from cx_act_cen where conse = '".$conse."' and ano = '".$ano."'";
	$cur = odbc_exec($conexion,$consulta);
	$row = odbc_fetch_array($cur);
	$acta_n = odbc_result($cur,1);   
	$unidad = odbc_result($cur,4);
	$registro = odbc_result($cur,7);
	$ano1 = odbc_result($cur,8);
	$vlrsol = trim(odbc_result($cur,9));
	$fecha = odbc_result($cur,2);
	$directiva = odbc_result($cur,10);
	$n_directiva = $directivas[$directiva-1];
	$firmas = $row['firmas'];
	$sintesis = trim($row['sintesis']);
	$constancia = trim($row['constancia']);
	$concepto = trim($row['concepto']);
	$informacion = trim($row['informacion']);
	$observaciones = trim($row['observaciones']);
	$neutralizados = trim($row['neutralizados']);
	$totali = trim(odbc_result($cur,14));
	$totaln = trim(odbc_result($cur,16));
	$material = trim($row['material']);	
	$totalm = trim(odbc_result($cur,18));
	$totala = str_replace(",","",trim(odbc_result($cur,19)));
	$acta = trim(odbc_result($cur,23));  
	$constancia = trim(odbc_result($cur,24));
	$folio = trim(odbc_result($cur,25));
	$fecha29 = trim(odbc_result($cur,29));
	$valoracion = trim($row['valoracion']);
	$aprobacion = trim($row['aprobacion']);
	$impacto = trim($row['impacto']);
	$n_elaboro = trim($row['elaboro']);
	$n_reviso = trim($row['reviso']);

	$consulta_rec = "select * from cx_reg_rec where conse = '".$registro."'";
	$cur_rec = odbc_exec($conexion,$consulta_rec);
	$usuario = trim(odbc_result($cur_rec,3));
	$unidad_rec = trim(odbc_result($cur_rec,4));
	$fec_res = trim(odbc_result($cur_rec,8));
	$uni_man = odbc_result($cur_rec,16);
	$uni_efec = odbc_result($cur_rec,17);

	if (trim(odbc_result($cur_rec,24)) == "") $ordop = "";
	else $ordop = odbc_result($cur_rec,24)." - ".odbc_result($cur_rec,25);
	if (trim(odbc_result($cur_rec,27)) == "") $fragmenta = "";
	else $fragmenta = odbc_result($cur_rec,27);
	if ($ordop == "") $ordop = $fragmenta;

	$fuente = odbc_result($cur_rec,35);
	if ($fuente != "")
	{
		$fuente = explode("|",$fuente);
		$fuente_rec = "";
		for ($c=0;$c<=count($fuente)-1;$c++) if ($fuente[$c] != "") $fuente_rec = $fuente_rec."XXXX".substr($fuente[$c],-4).",";
	}
	else $fuente_rec = "-SIN DATOS-";
 
	$actas = odbc_result($cur_rec,39);
	if (substr($actas,-1) == "|") $actas = substr($actas,0,-1);
	$fecha_act = odbc_result($cur_rec,40);
	if (substr($fecha_act,-1) == "|") $fecha_act = substr($fecha_act,0,-1);
	$valor_act = odbc_result($cur_rec,41);
	if (substr($valor_act,-1) == "|") $valor_act = substr($valor_act,0,-1);
	$lista = odbc_result($cur_rec,47);
	$usuario1 = trim(odbc_result($cur_rec,48));
	$usuario2 = trim(odbc_result($cur_rec,49));
	$usuario3 = trim(odbc_result($cur_rec,50));

	$p_lista = explode("|",$lista);
	$oficio2 = $p_lista[1];
	$fec_ofi2 = $p_lista[2];
	$contacto = $p_lista[11];
	$fec_contacto = $p_lista[12];
	$oficio = $p_lista[11];
	$fec_ofi = $p_lista[12];

	$consulta_reg = "select * from cx_act_reg where registro = '".$registro."'";
	$cur_reg = odbc_exec($conexion,$consulta_reg);
	$unidad1 = odbc_result($cur_reg,4);
	$acta_reg = trim(odbc_result($cur_reg,22));
	if ($acta_reg == "") $acta_reg = odbc_result($cur_reg,1);
	$fecha_reg = substr(odbc_result($cur_reg,2),0,10);
	$vlr_solicitado = trim(odbc_result($cur_reg,17));
	
	$consulta1 = "select * from cx_org_sub where subdependencia = '".$unidad1."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$siguom = trim(odbc_result($cur1,4));
	if (substr($siguom,0,3) == 'DIV') $siguom = substr($siguom,0,3).substr($siguom,-1);
	$sigla_uni = trim(odbc_result($cur1,4));

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(191,5,'DE USO EXCLUSIVO',0,1,'R');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,6,0,'');
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(130,6,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA:',0,0,'');

	if ($acta != "") $acta_n = $acta;
	$pdf->Cell(61,6,'ACTA NR.:    '.$acta_n,1,1,'L');
	
	if ($fecha29 != "") $fecha = $fecha29;
	else $fecha = substr($fecha,0,10);
	$m_fecha = substr($fecha, 5, 2);
	if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
	$fecha = substr($fecha, 8, 2)." de ".$n_meses[$m_fecha -1]." de ".substr($fecha, 0, 4);
	$pdf->RoundedRect(9,$actual+6,192,6,0,'');
	$pdf->Cell(42,6,'LUGAR Y FECHA:',0,0,'');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(149,6,$lugar.', '.$fecha,1,1,'L');
	
	$firmas = explode("|",$firmas);
	$inter_txt = "";
	for ($fir=0;$fir<=count($firmas)-2;$fir++)
	{
		$interv = explode("»",$firmas[$fir]);
		$inter[$fir]["nom"] = strtr($interv[0],$sustituye); //strtr(utf8_decode(substr($interv[0],0,-3)),$sustituye);
		$inter[$fir]["cargo"] = strtr($interv[1],$sustituye);
		$inter_txt = $inter_txt.$inter[$fir]["nom"]."\n".$inter[$fir]["cargo"]."\n\n";
	}   //for
	$actual=$pdf->GetY();
	$pdf->Cell(42,4,'INTERVIENEN:',0,0,'');
	$pdf->Multicell(149,4,$inter_txt,1,'L');

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_efec."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$s_unidad_afec = trim(odbc_result($cur1,4));
	$n_unidad_afec = trim(odbc_result($cur1,6));
	$m_fecha = substr($fec_ofi, 5, 2);
	if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
	$fec_ofi = substr($fec_ofi, 8, 2)." DE ".$n_meses[$m_fecha-1]." DE ".substr($fec_ofi, 0, 4);
	$m_fecha = substr($fec_res, 5, 2);
	if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
	$fec_res = substr($fec_res, 8, 2)." DE ".$n_meses[$m_fecha-1]." DE ".substr($fec_res, 0, 4);

	//se retoma que cuando la ordop o la frangmentaria este vacia se mantenga como valor  N/A. 25/08/2023 Jorge Clavijo
	if ($fragmenta == "") $fragmenta1 = "N/A";
	else $fragmenta1 = $fragmenta; 
	if ($ordop == "") $ordop1 = "N/A";
	else $ordop1 = $ordop;
	$asunto = "TRATA DEL ESTUDIO QUE HACE EL COMITÉ CENTRAL DE RECOMPENSAS AL EXPEDIENTE REMITIDO POR EL COMANDO DEL ".$sigla_uni.", ";
	$asunto = $asunto."MEDIANTE OFICIO No. ".$oficio." DE FECHA ".$fec_ofi.", CORRESPONDIENTE A LA INFORMACIÓN DE INTERES SUMINISTRADA POR LA(S) FUENTE(S) IDENTIFICADA(S) CON LA(S) CEDULA(S) No. ".$fuente_rec." ";
	$asunto = $asunto."QUE SIRVIÓ PARA EL PLANEAMIENTO Y POSTERIOR DESARROLLO DE LA OPERACIÓN MILITAR ".$ordop1.", ORDEN FRAGMANTARIA ".$fragmenta1;
	$asunto = $asunto.", RESULTADO REGISTRADO POR EL ".$s_unidad_afec." EL DÍA ".$fec_res.".";
	$mx = strlen($asunto);
	if ($mx > 115) $ax = ceil($mx/110);
	else if ($ax < 110) $ax = 12;
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,43,$ax*$ax+$ax,0,'');
	$pdf->Cell(42,$ax,'ASUNTO:',0,0,'');
	$pdf->Multicell(149,$ax,$asunto,1,'J');

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(191,5,"I.  AL EFECTO SE PROCEDE COMO A CONTINUACIÓN SE RELACIONA",0,1,'L');
	$pdf->Multicell(191,5,$sintesis,0,'J');
	$pdf->Cell(191,3,$linea2,0,1,'C');	

	$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_man."'";
	$cur1 = odbc_exec($conexion,$consulta1);
	$s_uni_man = trim(odbc_result($cur1,4));
	$n_uni_man = trim(odbc_result($cur1,6));

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(191,5,"II.  VALOR SOLICITADO POR LA UNIDAD",0,1,'L');
	$m_fecha = substr($fecha_reg, 5, 2);
	if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
	$fec_reg = substr($fecha_reg, 8, 2)." de ".strtolower($n_meses[$m_fecha-1])." de ".substr($fecha_reg, 0, 4);
	$vlrsolicit = "Según Acta del Comité Regional No. ".$acta_reg." de fecha ".$fec_reg." la unidad solicita por la información que condujo al resultado operacional la suma de ".$vlr_solicitado.".";
	$pdf->Multicell(191,5,$vlrsolicit,0,'J');

	if ($pdf->PageNo() == 1 and $hoja == 1)
	{
		$pdf->addpage();
		$pdf->SetFont('Arial','',40);
		$pagb = "\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO\n\n\n\n\n\n\n\n\n\n\n";
		$pdf->Multicell(191,5,$pagb,0,'C');
		$pdf->SetFont('Arial','',8);		
		$pdf->addpage();
	}   //if	
		
	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(191,5,"III.  CERTIFICACIÓN DE LA FUENTE Y PAGOS PREVIOS",0,1,'L');	
	$certi = "Según la certificación(es) anexa(s) a folio(s) ".$constancia." de la solicitud del pago, existe(n) una(s) fuente(s) que aportó(aportaron) para el proceso de la información y la generación de productos de inteligencia ";
	$certi = $certi."que impactaron en el planeamiento y desarrollo de la operación militar ".$ordop.".\n\nPAGO PREVIO A LA FUENTE: SI / NO";
	if ($actas == 0) $certi = $certi."\n\nNo se realizaron pagos previos a la(s) fuente(s).";
	else
	{
		$v_actas = explode("|",$actas);
		$v_fecha_act = explode("|",$fecha_act);
		$v_valor_act = explode("|",$valor_act);
		$texto_act = "";
		$anticipo = 0;
		for ($i=0;$i<=count($v_actas)-1;$i++)
		{
			$texto_act = $texto_act.$v_actas[$i]." de fecha ".$v_fecha_act[$i]." por valor de $".$v_valor_act[$i].", ";
			if ($i < count($v_actas)-1) $texto_act = $texto_act." acta No.: ";
			$anticipo = $anticipo + str_replace(",","",$v_valor_act[$i]);
		}   //for
		$texto_act = substr($texto_act,0,-2).".";
		$certi = $certi."\nLa(s) fuente(s) registra(n) pago(s) previo(s) según acta(s) No. ".$texto_act;
	}   //if
	$pdf->Multicell(191,5,$certi,0,'J');	

	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(191,5,"IV.  VALORACIÓN DE LA SOLICITUD DE PAGO DE LA INFORMACIÓN(S) SUMINISTRADA(S) POR LA(S) FUENTE(S) E IMPACTO",0,1,'L');	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,148,10,0,'');
	$pdf->RoundedRect(157,$actual,44,10,0,'');
	$pdf->Cell(147,10,"A.  VALORACIÓN DE LA INFORMACIÓN SUMINISTRADA (OPORTUNIDAD Y UTILIDAD DE LA INFORMACIÓN)",0,0,'L');	
	$pdf->Cell(44,10,"VALORACIÓN",0,1,'C');		

	$le = strlen($informacion);

	if ($le >= 100)
	{
		$aa = floor($le/100)*3.3;
		if ($aa < 10) $aa = 10;
	}
	else $aa = 10;	
 
	if ($le == 0)
	{
		$informacion = "OMITIDO";
		$totali = "0.00";
	}   //if

	$actual=$pdf->GetY();
	$x = 0;
	$y = $pdf->Gety();
	$pdf->RoundedRect(9,$y,148,$aa,0,'');
	$pdf->Multicell(147,3,$informacion,0,'J');
	$pdf->SetXY($x+157,$y);
	$pdf->RoundedRect(157,$y,44,$aa,0,'');		
	$pdf->Multicell(44,$aa,'$'.trim($totali),1,'R');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,8,0,'');
	$pdf->Cell(147,8,"TOTAL (Valoración informaciónes).",0,0,'L');	
	$pdf->Cell(44,8,"$".trim($totali),0,1,'R');				

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->Ln(1);
	$pdf->RoundedRect(9,$actual,192,10,0,'DF');
	$pdf->Multicell(191,5,"V.  VALORACIÓN DE LA SOLICITUD DE PAGO DE RECOMPENSA POR LA INFORMACIÓN(S) SUMINISTRADA(S) POR LA(S) FUENTE(S) E IMPACTO",0,1,'L');	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191,5,"A.  NEUTRALIZADOS",0,1,'L');	
	$pdf->SetFont('Arial','',8);
	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,18,10,0,'');
	$pdf->RoundedRect(27,$actual,90,10,0,'');
	$pdf->RoundedRect(117,$actual,42,10,0,'');	
	$pdf->RoundedRect(159,$actual,42,10,0,'');
	$pdf->Cell(18,10,"NIVEL",0,0,'C');	
	$pdf->Cell(89,10,"IDENTIDAD",0,0,'C');	
	$pdf->Cell(42,10,"MONTOS DIRECTIVA (HASTA)",1,0,'C');		
	$pdf->Cell(42,10,"VALORACIÓN",0,1,'C');
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
		$pdf->RoundedRect(9,$y,18,$aa,0,'');
		$pdf->Multicell(18,$aa,$elem,0,'C');
		$pdf->SetXY($x+27,$y);
		$pdf->RoundedRect(27,$y,90,$aa,0,'');
		$pdf->Multicell(90,4,$neutral1[1],0,'J');
		$pdf->SetXY($x+117,$y);
		$pdf->RoundedRect(117,$y,42,$aa,0,'');
		$pdf->Multicell(42,$aa,'$'.trim(substr($neutral1[2],0,-1)),0,'R');
		$pdf->SetXY($x+159,$y);
		$pdf->RoundedRect(159,$y,42,$aa,0,'');		
		$pdf->Multicell(42,$aa,'$'.trim(substr($neutral1[4],0,-1)),0,'R');
		$x = 0;
		$y = $pdf->GetY();	
	}   //for

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,8,0,'');
	$pdf->Cell(149,8,'SUBTOTAL',0,0,'L');
	$pdf->Cell(42,8,'$'.$totaln,1,1,'R');
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Multicell(191,5,"\n".$valoracion."\n\n\n",0,'J');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191,5,"B.  VALORACIÓN ELEMENTOS INCAUTADOS:",0,1,'L');	
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,10,0,'DF');
	$pdf->Cell(80,5,'',0,0,'C');
	$pdf->Cell(19,5,'',L,0,'C');
	$pdf->Cell(44,5,'V/R SEGÚN DIRECTIVA',L,0,'C');
	$pdf->Cell(16,5,'',L,0,'C');
	$pdf->Cell(34,5,'VR. TOTAL',L,1,'C');
	$pdf->Cell(80,5,'ELEMENTOS INCAUTADOS',0,0,'C');
	$pdf->Cell(19,5,'CANTIDAD',L,0,'C');
	$pdf->Cell(44,5,'(HASTA)',L,0,'C');
	$pdf->Cell(16,5,'ESTADO',L,0,'C');
	$pdf->Cell(34,5,'APROBADO',L,1,'C');	

	$materia = explode("|",substr($material,0,-1));
	$cn = count($materia);
	$stot = 0; 

	$actual=$pdf->GetY();
	$x = $pdf->Getx();
	$y = $pdf->Gety();
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
		$le = strlen($elemento1);
		if ($le >= 42) $aa = floor($le/44)*5.2;
		else $aa = 10;		

		if ($material1[2] == 0 or $material1[2] == "") $material1[2] = "0";
		if ($material1[6] == 0 or $material1[6] == "") $material1[6] = "0";
		
		$pdf->SetXY($x,$y);
		$pdf->RoundedRect(9,$y,81,$aa,0,'');
		$pdf->Multicell(81,4,$elemento1,0,'L');
		$pdf->SetXY($x+81,$y);
		$pdf->RoundedRect(90,$y,19,$aa,0,'');
		$pdf->Multicell(19,5,number_format(substr($material1[1],0,-1),0),0,'C');
		$pdf->SetXY($x+99,$y);
		$pdf->RoundedRect(109,$y,44,$aa,0,'');
		$pdf->Multicell(44,5,'$'.trim(substr($material1[2],0,-1)),0,'R');
		$pdf->SetXY($x+143,$y);
		$pdf->RoundedRect(153,$y,16,$aa,0,'');		
		$pdf->Multicell(16,5,trim(substr($material1[4],0,-1)),0,'C');
		$pdf->SetXY($x+158,$y);
		$pdf->RoundedRect(169,$y,32,$aa,0,'');
		$pdf->Multicell(32,5,'$'.number_format(trim($material1[6]),2),0,'R');
		$stot = $stot + str_replace(',','',trim($material1[5]));
		$pdf->Ln($aa-5);
		$y = $pdf->GetY();
		control_salto_pag($pdf->GetY());
	}   //for

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(157,10,'SUBTOTAL',0,0,'L');
	$pdf->Cell(33,10,'$'.number_format($stot,2),0,1,'R');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$estado = "ESTADO Según registros del informe de peritaje\nO=Optimo  B=Bueno  D=Dañado o inservible";
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(190,5,$estado,0,'L');	

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,10,0,'');
	$pdf->Cell(157,10,'TOTAL VALORACIÓN SOLICITUD DE PAGO DE RECOMPENSAS',0,0,'L');	
	$pdf->Cell(34,10,'$'.number_format($totala,2),1,1,'R');

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());			
	$pdf->SetFont('Arial','B',8);	
	$pdf->Cell(191,5,"C.  IMPACTO RESULTADO OPERACIONAL:",0,1,'L');	
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(190,5,$impacto,0,'J');	

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());					
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->cell(192,5,"VI.  CONCEPTO DE EVALUACIÓN DEL COMITÉ CENTRAL.",0,1,'L');	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,20,'');
	$pdf->Multicell(191,5,$concepto,0,'J');

	$actual=$pdf->GetY();	
	control_salto_pag($pdf->GetY());	
	$consulta_uni = "select * from cv_unidades where subdependencia = '".$unidad_rec."'";
	$cur_uni = 	odbc_exec($conexion,$consulta_uni);
	$n_dependencia = trim(odbc_result($cur_uni,4));
	
	$actual=$pdf->GetY();	
	control_salto_pag($pdf->GetY());	
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->cell(192,5,"VII.  APROBACIÓN DE PAGO.",0,1,'L');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,20,'');
	$pdf->Multicell(191,5,$aprobacion,0,'J');	

	control_salto_pag($pdf->GetY());	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->cell(192,5,"VIII.  OBSERVACIONES.",0,1,'L');	

	$actual=$pdf->GetY();
	$pdf->Multicell(191,5,$observaciones,0,'J');	
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,0,B,'');

	//Firmas
	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->Multicell(191,5,"No siendo otro el objeto de la presente, se da por terminada y en constancia firman los que intervinieron en este el Comité:",0,'J');
	$pdf->Ln(5);
//	if ($ajuste > 0) $pdf->Ln($ajuste);
	$nfir = count($inter)-1;
	if ($nfir % 2 == 0) $cmp = count($inter)-1;
	else $cmp = $nfir;
	$firmas1 = 1;
	for ($i=$cmp;$i>=2;$i=$i-2)
	{
		control_salto_pag($pdf->GetY());				
		$pdf->Ln(14);
		$pdf->Cell(15,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["nom"],T,0,'C'); 
		$pdf->Cell(16,4,'',0,0,'C');		
		$pdf->Cell(72,4,$inter[$i-1]["nom"],T,1,'C');
		$pdf->Cell(15,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,0,'C');
		$pdf->Cell(16,4,'',0,0,'C');		
		$pdf->Cell(72,4,$inter[$i-1]["cargo"],0,1,'C');
		$n = (count($inter)/2);
		if ($i == $n) $pdf->Cell(190,0,'',0,1,'C');
		else $pdf->Cell(190,13,'',0,1,'C');
	}   //for

	if ($nfir % 2 != 0)
	{
		$pdf->Ln(14);
		$pdf->Cell(60,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["nom"],T,1,'C'); 
		$pdf->Cell(60,4,'',0,0,'C');
		$pdf->Cell(72,4,$inter[$i]["cargo"],0,0,'C');
		$pdf->Ln(10);
	}	

	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->RoundedRect(9,$actual,192,0,B,'');
	$pdf->cell(192,5,"Aceptada:",0,1,'L');	
	$pdf->Ln(14);
	$pdf->Cell(60,4,'',0,0,'C');
	$pdf->Cell(72,4,$inter[0]["nom"],T,1,'C');
	$pdf->Cell(60,4,'',0,0,'C');
	$pdf->Cell(72,4,$inter[0]["cargo"],0,1,'C');
	$pdf->Ln(3);
	
	$actual=$pdf->GetY();
	control_salto_pag($pdf->GetY());
	$pdf->RoundedRect(9,$actual,192,0,B,'');
	$texto = "NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$actual=$pdf->GetY();
	$pdf->Ln(1);
	$pdf->Multicell(191,3,$texto,0,'J');
	$pdf->Ln(1);
	$actual = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,6,B,'');
	$pdf->Cell(95,4,'Elaboró:    '.$n_elaboro,0,0,'');
	$pdf->Cell(95,4,'Revisó:    '.$n_reviso,0,1,'');

	$nom_pdf="../fpdf/pdf/Actas/ActaComCen_".trim($sig_usuario)."_".$conse."_".$ano.".pdf";
	$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));
	//$pdf->Output();
	$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}
?>
