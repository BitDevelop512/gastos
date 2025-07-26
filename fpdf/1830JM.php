<?php
/*  1830.php
	ACTA EVALUACIÓN COMITÉ CENTRAL DE INFORMACIÓN Y REGIONAL DE RECOMPENSAS.
	*Unifica los formatos:
	*602 ACTA EVALUACIÓN COMITÉ REGIONAL DE RECOMPENSAS,
	*604 ACTA EVALUACIÓN COMITÉ CENTRAL DE INFORMACIÓN DE RECOMPENSAS.

	Se usa $_GET['comite'] para determinar 1-Acta Central, 2-Acta Regional
	01/07/2023 - SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	25/08/2023 - Se Ajusta la sigla de la unidad centralizadora mayor. Jorge Clavijo. 
	30/10/2023 - Ajuste para cuando el valor del campo uni_efe de la tabla cx_reg_rec es 999. Jorge Clavijo 
	24/11/2023 - Se hace cambio a este ítem, debe decir OMITIDO (tomado del camapo de informaciones del registro de la tabla cx_act_cen) 
				 cuando es pago de recompensa si es informaciones debe llevar la información suministrada por la fuente  - Jorge Clavijo.
	10/01/2024 - Se hace ajuste a la unidad centralizadora mayor y a las firmas para que no se sobrepongan. - Jorge Clavijo. 
	01/02/2024 - Se hace ajuste para insertar un salto de página cuando las firmas queda al final de la hoja. - Jorge Clavijo.
	21/03/2024 - Se revisa la unidad que graba el informe tanto para acta central como regional. - Jorge Clavijo.
	22/03/2024 - Control para la ordop, a partir del 04-02-2024 inclusive. - Jorge Clavijo.
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
			require('../permisos.php');
			require('../permisos.php');
			global $sigla;
			$comite = $_GET['comite'];			
			$conse = $_GET['conse'];
			$ano = $_GET['ano'];

			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			if ($comite == 1) $consulta_act = "select * from cx_act_cen where conse = '".$conse."' and ano = '".$ano."'";
			else $consulta_act = "select * from cx_act_reg where conse = '".$conse."' and ano = '".$ano."'";
			$cur_act = odbc_exec($conexion,$consulta_act);
			$fecha_act = substr(odbc_result($cur_act,2),0,10);
			$unidad = trim(odbc_result($cur_act,4));

			//$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$unidad."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			if ($sigla1 <> "") if ($fecha_act >= $fecha_os) $sigla = $sigla1;			

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
			$this->Cell(70,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(55,5,'ACTA EVALUACIÓN',0,0,'C');
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(55,5,'COMITÉ DE PAGO DE',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-1830',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(55,5,'INFORMACIÓN Y',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(70,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(55,5,'RECOMPENSAS',0,0,'C');
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

			//Control insertar página en blanco
			if ($_GET['hoja'] == 1)
			{
				if ($this->page == 2)
				{
					$this->SetFont('Arial','',40);
					$pagb = "";
					for ($h=1;$h<=3;$h++) $pagb = $pagb."\n\n\n\n\n\n\n\n\n\n\n\n\nHOJA EN BLANCO";
					$pagb = $pagb."\n\n\n\n\n\n\n\n";
					$this->Multicell(191,5,$pagb,0,'C');
					$this->SetFont('Arial','',8);
					$this->AddPage();
				}   //if
			}   //if
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
		}//function _Arc($x1, $y1, $x2, $y2, $x3, $y3)

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
					$act = $this->GetY();
					$this->SetFont('Arial','',8);
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 71 or $this->tablewidths[$col] == 148) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt);
					else if ($this->tablewidths[$col] == 62 or $this->tablewidths[$col] == 78 or $this->tablewidths[$col] == 148)
						$this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'L');
					else if ($this->tablewidths[$col] == 29 or $this->tablewidths[$col] == 30 or $this->tablewidths[$col] == 42 or $this->tablewidths[$col] == 43 or$this->tablewidths[$col] == 44)
						$this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
 			$hoja = $_GET['hoja'];
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
		}//Footer
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
	$n_meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$linea = str_repeat("_",108);
	$linea1 = str_repeat("_",89);
	$linea2 = str_repeat("_",122);
	$lugar = "Bogotá";
	$directivas = array("No. 01 del 17 de Febrero de 2009","No. 21 del 5 de Julio de 2011","No. 16 del 25 de Mayo de 2012","No. 02 del 16 de Enero de 2019");
	
	$pdf->SetFillColor(204);
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(-1);

	$t_comite = $_GET['comite'];
	$conse = $_GET['conse'];
	$ano = $_GET['ano'];
	if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
	else $ajuste = "0";
	$hoja = $_GET['hoja'];

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=270.00125) $pdf->addpage();
	} //control_salto_pag

	if ($t_comite == 1)
	{
		$infgas	= "X";
		$relgas = "";
	}
	else
	{
		$infgas	= "";
		$relgas = "X";
	}   //if

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(2);
	$pdf->RoundedRect(9,$actual,192,8,0,'DF');
	$pdf->Cell(43,5,'COMITÉ REGIONAL',0,0,'R');
	$pdf->Cell(10,5,$relgas,1,0,'C');
	$pdf->Cell(8,5,'',0,0,'L');
	$pdf->Cell(35,5,'  COMITÉ CENTRAL',0,0,'L');
	$pdf->Cell(10,5,$infgas,1,0,'C');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(85,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(1);
	if ($t_comite == 1)   //central
	{
		$consulta = "select * from cx_act_cen where conse = '".$conse."' and ano = '".$ano."'";
		$cur = odbc_exec($conexion,$consulta);
		$row1 = odbc_fetch_array($cur);
		$acta_n = odbc_result($cur,1);
		$fecha = odbc_result($cur,2);
		$unidad = odbc_result($cur,4);
		$estado_r = trim(odbc_result($cur,5));
		$registro = odbc_result($cur,7);
		$ano1 = odbc_result($cur,8);
		$vlrsol = str_replace(",","",trim(odbc_result($cur,9)));
		$directiva = odbc_result($cur,10);
		$n_directiva = $directivas[$directiva-1];
		$firmas = $row1['firmas'];
		$sintesis = trim($row1['sintesis']);
		$constancia = trim($row1['constancia']);
		$concepto = trim($row1['concepto']);
		$informacion = trim($row1['informacion']);
		$observaciones = trim($row1['observaciones']);
		$neutralizados = trim($row1['neutralizados']);
		$totali = substr(str_replace(',','',trim(odbc_result($cur,14))),0);
		$totaln = substr(str_replace(',','',trim(odbc_result($cur,16))),0);
		if ($totaln == "") $totaln = "0.00";
		$material = trim($row1['material']);
		$totalm = trim(odbc_result($cur,18));
		$totala = str_replace(",","",trim(odbc_result($cur,19)));
		if ($totala == "") $totala = "0.00";
		$acta = trim(odbc_result($cur,23));
		$constancia = trim(odbc_result($cur,24));
		$folio = trim(odbc_result($cur,25));
		$fecha29 = trim(odbc_result($cur,29));
		$valoracion = trim($row1['valoracion']);
		$aprobacion = trim($row1['aprobacion']);
		$impacto = trim($row1['impacto']);
		$n_elaboro = trim($row1['elaboro']);
		$n_reviso = trim($row1['reviso']);

		$consulta_rec = "select * from cx_reg_rec where conse = '".$registro."' and ano = '".$ano1."'";
		$cur_rec = odbc_exec($conexion,$consulta_rec);
		$usuario = trim(odbc_result($cur_rec,3));
		$unidad_rec = trim(odbc_result($cur_rec,4));
		$fec_res = trim(odbc_result($cur_rec,8));
		$uni_man = odbc_result($cur_rec,16);
		$uni_efec = odbc_result($cur_rec,17);
		$uni_bri = odbc_result($cur_rec,18);

		if (trim(odbc_result($cur_rec,21)) == "") $vlr_solicitado = "0.00";
		else $vlr_solicitado = substr(str_replace(',','',trim(odbc_result($cur_rec,21))),0);

		$ordop = trim(odbc_result($cur_rec,24));
		$n_ordop = trim(odbc_result($cur_rec,25));
		$fragmenta = trim(odbc_result($cur_rec,27));

		//Unidad que graba el informe
		$consulta_os = "select * from cx_org_sub where subdependencia = '".$unidad_rec."'";
		$cur_os = odbc_exec($conexion,$consulta_os);
		$n_unidad = trim(odbc_result($cur_os,4));

		//Control para la ordop, a partir del 04-02-2024 inclusive.
		$fecha_ctlr = "20240204";      //control
		$fecha_rg = substr($fecha,0,4).substr($fecha,5,2).substr($fecha,8,2); //registro
		$dife = $fecha_rg-$fecha_ctlr;

		if ($dife > 0 and $ordop == "") $ordop = "N/A";
		else
		{
			if ($ordop == "") $ordop = "";
			else $ordop = $ordop." - ".$n_ordop;
		}

		if ($dife > 0 and $fragmenta == "") $fragmenta = "N/A";
		else
		{
			if ($fragmenta == "") $fragmenta = "";
			if ($ordop == "") $ordop = $fragmenta;
		}
		
		$sitio = odbc_result($cur_rec,30);
		$municipio = odbc_result($cur_rec,31);
		$departamento = odbc_result($cur_rec,32);
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

		$consulta_reg = "select * from cx_act_reg where registro = '".$registro."' and ano = '".$ano1."'";
		$cur_reg = odbc_exec($conexion,$consulta_reg);

		$consulta1 = "select * from cv_unidades where subdependencia = '".$unidad_rec."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$siguom = trim(odbc_result($cur1,4));
		if (odbc_result($cur1,1) >= 1 and odbc_result($cur1,1) <= 3) $unidad_asunto = trim(odbc_result($cur1,2));	
		if (odbc_result($cur1,1) >= 4 and odbc_result($cur1,1) <= 21) $unidad_asunto = trim(odbc_result($cur1,4));

		$consulta_os = "select * from cx_org_sub where sigla = '".$unidad_asunto."'";

		$cur_os = odbc_exec($conexion,$consulta_os);
		$unic_os = trim(odbc_result($cur_os,8));
		if ($unic_os != '1') $unidad_asunto = $siguom = trim(odbc_result($cur1,2));
				
		$acta_reg = trim(odbc_result($cur_reg,22));
		if ($acta_reg == "") $acta_reg = odbc_result($cur_reg,1);
		$fecha_reg = substr(odbc_result($cur_reg,2),0,10);

		$pdf->SetFont('Arial','',8);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,6,0,'');
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(130,6,'',0,0,'');
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
			$inter[$fir]["nom"] = strtr($interv[0],$sustituye);
			$inter[$fir]["cargo"] = strtr($interv[1],$sustituye);
			$inter_txt = $inter_txt.$inter[$fir]["nom"]."\n".$inter[$fir]["cargo"]."\n\n";
		}   //for
		$actual=$pdf->GetY();
		$pdf->Cell(42,4,'INTERVIENEN:',0,0,'');
		$pdf->Multicell(149,3.7,$inter_txt,1,'L');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		//30/10/2023 - Ajuste para cuando el valor del campo uni_efe de la tabla cx_reg_rec es 999. Jorge Clavijo 
		if ($uni_efec != '999')
		{
			$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_efec."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$s_unidad_afec = trim(odbc_result($cur1,4));
			$n_unidad_afec = trim(odbc_result($cur1,6));
		}
		else
		{
			if ($uni_bri == '0')
			{
				$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_man."'";
				$cur1 = odbc_exec($conexion,$consulta1);
				$s_unidad_afec = trim(odbc_result($cur1,4));
				$n_unidad_afec = trim(odbc_result($cur1,6));				
			}
			else
			{
				$consulta1 = "select * from cx_org_bat where conse = '".$uni_bri."'";
				$cur1 = odbc_exec($conexion,$consulta1);
				$s_unidad_afec = $n_unidad_afec = trim(odbc_result($cur1,2));
			}   //if
		}   //if

		//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
		$consulta_act = "select * from cx_act_cen where conse = '".$conse."' and ano = '".$ano."'";
		$cur_act = odbc_exec($conexion,$consulta_act);
		$fecha_act = substr(odbc_result($cur_act,2),0,10);
		$unidad = trim(odbc_result($cur_act,4));

		$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_efec."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$s_unidad_afec = trim(odbc_result($cur1,1));
		$sigla1 = trim(odbc_result($cur1,3));
		$nom1 = trim(odbc_result($cur1,4));
		$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
		if ($sigla1 <> "") if ($fecha_act >= $fecha_os) $s_unidad_afec = $sigla1;	

		$m_fecha = substr($fec_ofi, 5, 2);
		if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
		$fec_ofi = substr($fec_ofi, 8, 2)." DE ".strtoupper($n_meses[$m_fecha-1])." DE ".substr($fec_ofi, 0, 4);
		$m_fecha = substr($fec_res, 5, 2);
		if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
		$fec_res = substr($fec_res, 8, 2)." DE ".strtoupper($n_meses[$m_fecha-1])." DE ".substr($fec_res, 0, 4);
		
		if ($fragmenta == "") $fragmenta1 = "N/A";
		else $fragmenta1 = $fragmenta; 
		if ($ordop == "") $ordop1 = "N/A";
		else $ordop1 = $ordop;
		$asunto = "TRATA DEL ESTUDIO QUE HACE EL COMITÉ CENTRAL DE RECOMPENSAS AL EXPEDIENTE REMITIDO POR EL COMANDO DEL ".$unidad_asunto.", "; 
		$asunto = $asunto."MEDIANTE OFICIO No. ".$oficio." DE FECHA ".$fec_ofi.", CORRESPONDIENTE A LA INFORMACIÓN DE INTERES SUMINISTRADA POR LA(S) FUENTE(S) IDENTIFICADA(S) CON LA(S) CEDULA(S) No. ".$fuente_rec." ";
		$asunto = $asunto."QUE SIRVIÓ PARA EL PLANEAMIENTO Y POSTERIOR DESARROLLO DE LA OPERACIÓN MILITAR ".$ordop1.", ORDEN FRAGMENTARIA ".$fragmenta1;
		$asunto = $asunto.", RESULTADO REGISTRADO POR EL ".$s_unidad_afec." EL DÍA ".$fec_res.".";
		
		$mx = strlen($asunto);
		if ($mx > 115) $ax = ceil($mx/110);
		else if ($ax < 110) $ax = 12;
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,43,$ax*$ax+$ax,0,'');
		$pdf->Cell(42,$ax,'ASUNTO:',0,0,'');
		$pdf->Multicell(149,$ax,$asunto,1,'J');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'AL EFECTO SE PROCEDE COMO A CONTINUACIÓN SE RELACIONA',0,1,'L');
		$pdf->Multicell(191,5,$sintesis,0,'J');
		$pdf->Cell(191,3,$linea2,0,1,'C');

		$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_man."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$s_uni_man = trim(odbc_result($cur1,4));
		$n_uni_man = trim(odbc_result($cur1,6));
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(151,5,'VALOR SOLICITADO POR LA UNIDAD',0,0,'L');
		$pdf->Cell(40,5,'$'.number_format($vlr_solicitado,2),1,1,'R');
		$actual=$pdf->GetY();
		$alefecto1 = "Expediente Operacion Militar ".$ordop." orden fragmentaria ".$fragmenta;
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(45,5,'SOPORTE DE LA SOLICITUD: ',R,0,'L');
		$pdf->Cell(146,5,$alefecto1,0,1,'J');
		$pdf->Cell(191,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,10,0,'DF');
		$pdf->MultiCell(191,5,'1. CERTIFICACIÓN DE LA EXISTENCIA Y REGISTRO DE LA FUENTE HUMANA Y DE LA INFORMACIÓN SUMINISTRADA EN BASES DE DATOS DE INTELIGENCIA:',0,'L');
		$certi = "Según la certificación(es) anexa(s) a folio(s) ".$constancia." de la solicitud del pago, existe(n) una(s) fuente(s) que aportó(aportaron) para el proceso de la información y la generación de productos de inteligencia ";
		$certi = $certi."que impactaron en el planeamiento y desarrollo de la operación militar ".$ordop.", orden fragmentaria ".$fragmenta."\nPAGO PREVIO A LA FUENTE: SI / NO";
		if ($actas == 0) $certi = $certi."\nNo se realizaron pagos previos a la(s) fuente(s).";
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
		$pdf->RoundedRect(9,$actual,192,10,0,'DF');
		$pdf->Multicell(191,5,'2. SÍNTESIS DE LA INFORMACIÓN SUMINISTRADA POR LA FUENTE, UTILIDAD EN EL PROCESO DE INTELIGENCIA Y DE OPERACIONES MILITARES.',0,'L');
		
		//24/11/2023 - Se hace cambio a este ítem, debe decir OMITIDO (tomado del camapo de informaciones del registro de la tabla cx_act_cen) 
		//			   cuando es pago de recompensa si es informaciones debe llevar la información suministrada por la fuente  - Jorge Clavijo.
		$pdf->Multicell(191,5,"\n".$informacion."\n",0,'J');
		$pdf->Cell(191,3,$linea2,0,1,'C');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'3. VALORACIÓN DE LA SOLICITUD DEL PAGO DE INFORMACIÓN(S) EN CASOS CUYO MONTO SEA > 10 SMLMV',0,1,'L');
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(147,5,'Exactitud, oportunidad, utilidad de la información e impacto',0,0,'C');
		$pdf->Cell(44,5,'Valoración',1,1,'C');
		control_salto_pag($pdf->GetY());
		if (strlen($informacion) == 0)
		{
			$informacion = "OMITIDO";
			$totali = "0.00";
		}   //if
 		$pdf->tablewidths = array(148, 44);
		$vlr = number_format($totali,2);
		$data[] = array($informacion, '$'.$vlr);
		$t_valoracion = $t_valoracion + $totali;
		$pdf->morepagestable($data);
		unset($data);

		$actual=$pdf->GetY();
		control_salto_pag($pdf->GetY());
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(147,5,'Total valoración información(s).',0,0,'L');
		$pdf->Cell(44,5,'$'.number_format($t_valoracion,2),1,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'4. VALORACIÓN DE LA SOLICITUD DE PAGO DE RECOMPENSA(S).',0,1,'L');
		$pdf->Cell(191,5,'4.1 NEUTRALIZADOS',0,1,'L');
		$pdf->Ln(1);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,8,0,'');
		$pdf->Cell(9,4,'',0,0,'C');
		$pdf->Cell(62,4,'',L,0,'C');
		$pdf->Cell(62,4,'',L,0,'C');
		$pdf->Cell(29,4,'Montos directiva ',L,0,'C');
		$pdf->Cell(29,4,'',L,1,'C');
		$pdf->Cell(9,4,'Nivel',0,0,'C');
		$pdf->Cell(62,4,'Identidad',L,0,'C');
		$pdf->Cell(62,4,'Cargo en la organización delincuencial',L,0,'C');
		$pdf->Cell(29,4,'(hasta)',L,0,'C');
		$pdf->Cell(29,4,'Valoración',L,1,'C');

		$neutral = explode("|",$neutralizados);
		$cn = count($neutral)-2;
		$actual=$pdf->GetY();
		$x = 0;
		$y = $pdf->Gety();
		for ($f=0;$f<=$cn;$f++)
		{
			$neutral1 = explode("»",$neutral[$f]);
			$cr = count($neutral1)-1;
			if ($cr == 5) $neutral1[6] = "";			
			if (substr($neutral1[0],0,1) == 1) $elem = "I";
			if (substr($neutral1[0],0,1) == 2) $elem = "II";
			if (substr($neutral1[0],0,1) == 3) $elem = "III";
			if (substr($neutral1[0],0,1) == 4) $elem = "IV";
			if (substr($neutral1[0],0,1) == 5) $elem = "V";
			if (substr($neutral1[0],0,1) == 6) $elem = "VI";
			if (substr($neutral1[0],0,1) == 7) $elem = "VII";
			$data1[] = array($elem, $neutral1[1], trim($neutral1[6]),'$'.trim(substr($neutral1[2],0)), '$'.trim(substr($neutral1[4],0)));
		}   //for
		$pdf->tablewidths = array(10, 62, 62, 29, 29);
		$pdf->morepagestable($data1);
		unset($data1);

		$pdf->RoundedRect(9,$actual,192,7,'');
		$pdf->Cell(162,7,'SUBTOTAL',0,0,'L');
		$pdf->Cell(29,7,'$'.number_format($totaln,2),L,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$susten = "4.1.1 SUSTENTACIÓN DE LA VALORACIÓN DE INDIVIDUOS NEUTRALIZACIONES\n\n";
		$susten = $susten.$valoracion;
		$pdf->Multicell(191,5,$susten,0,'L');
		$pdf->Cell(44,5,'',0,1,'L');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,10,0,'DF');
		$pdf->Multicell(191,5,'4.2 VALORACIÓN MATERIAL, EQUIPO, EXPLOSIVOS, VEHÍCULOS, EQUIPO AERONÁUTICO, ELEMENTOS DE NARCOTRÁFICO Y SUSTANCIAS QUÍMICAS INCAUTADAS:',0,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,8,0,'');
		$pdf->Cell(77,8,'Elementos incautados',0,0,'C');
		$pdf->Cell(14,8,'Cant',L,0,'C');
		$pdf->Cell(43,8,'Valor según directiva (hasta)',L,0,'C');
		$pdf->Cell(14,8,'Estado',L,0,'C');
		$pdf->Cell(43,8,'V/R total aprobado',1,1,'C');

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
			if ($material1[2] == 0 or $material1[2] == "") $material1[2] = "0";
			if ($material1[6] == 0 or $material1[6] == "") $material1[6] = "0";
			$data1[] = array($elemento1, number_format(substr($material1[1],0,-1)), '$'.number_format(trim($material1[3]),2), trim(substr($material1[4],0,-1)), '$'.number_format(trim($material1[6]),2));
			$stot = $stot + str_replace(',','',trim($material1[6]));
			control_salto_pag($pdf->GetY());
			$pdf->tablewidths = array(78, 14, 43, 14, 43);
			$pdf->morepagestable($data1);
			unset($data1);
		}   //for

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,7,0,'');
		$pdf->Cell(148,7,'SUBTOTAL',0,0,'L');
		$pdf->Cell(43,7,'$'.number_format($stot,2),L,1,'R');

		$pdf->SetFont('Arial','',9);
		$actual=$pdf->GetY();
		$estado = "ESTADO: Según registros del informe de peritaje.\nN= Nuevo,	B= Bueno,	 D= Dañado o inservible,	 N/A= No Aplica";

		$pdf->Multicell(191,5,$estado,0,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,7,0,'');
		$pdf->Cell(148,7,'TOTAL VALORACIÓN SOLICITUD PAGO DE RECOMPENSA(S)',0,0,'L');
		$pdf->Cell(43,7,'$'.number_format($totala,2),L,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Multicell(191,5,'4.3 IMPACTO DEL RESULTADO OPERACIONAL',0,'L');
		$pdf->Multicell(191,5,$impacto,0,'L');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(192,5,'5. CONCEPTO DE EVALUACIÓN DEL COMITÉ',0,1,'L');
		$pdf->Multicell(191,5,$concepto,0,'J');
		$pdf->Cell(44,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'6. MONTO APROBADO',0,1,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(149,5,'Valor',0,0,'L');
		$pdf->Cell(43,5,'$'.number_format($totala,2),L,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(149,5,'UNIDAD CENTRALIZADORA QUE REALIZA EL PAGO',0,0,'L');
		$pdf->Cell(43,5,$siguom,L,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(192,5,'7. OBSERVACIONES',0,1,'L');
		$pdf->Multicell(191,5,$observaciones,0,'J');
		$pdf->Cell(191,3,$linea,0,1,'C');
	}
	else    //Regional
	{
		$consulta = "select * from cx_act_reg where conse = '".$conse."' and ano = '".$ano."'";
		$cur = odbc_exec($conexion,$consulta);
		$row2 = odbc_fetch_array($cur);
		$acta_n = odbc_result($cur,1);
		$unidad = odbc_result($cur,4);
		$estado_r = trim(odbc_result($cur,5));		
		$registro = odbc_result($cur,7);
		$ano1 = odbc_result($cur,8);
		$vlrsol = odbc_result($cur,9);
		if ($vlrsol == "") $vlrsol = "0.00";
		$vlrsol = substr(str_replace(',','',$vlrsol),0);
		$fecha = odbc_result($cur,2);
		$m_fecha = substr($fecha, 5, 2);
		if (substr($m_fecha,0,1) == '0') $m_fecha = substr($m_fecha,1,1);
		$fecha = substr($fecha, 8, 2)." de ".$n_meses[$m_fecha -1]." de ".substr($fecha, 0, 4);
		$directiva = odbc_result($cur,10);
		$n_directiva = $directivas[$directiva-1];
		$firmas = $row2['firmas'];
		$firmas = explode("|",$firmas);
		$inter_txt = "";
		for ($fir=0;$fir<=count($firmas)-2;$fir++)
		{
			$interv = explode("»",$firmas[$fir]);
			$inter[$fir]["nom"] = $interv[0];
			$inter[$fir]["cargo"] = $interv[1];
			$inter_txt = $inter_txt.$inter[$fir]["nom"]."\n".$inter[$fir]["cargo"]."\n\n";
		}   //for
		$sintesis = trim($row2['sintesis']);
		$concepto = trim($row2['concepto']);
		$recomendaciones = trim($row2['recomendaciones']);
		$observaciones = trim($row2['observaciones']);
		$neutralizados = trim($row2['neutralizados']);
		$totaln = trim(odbc_result($cur,14));
		if ($totaln == "") $totaln = "0.00";
		$material = trim($row2['material']);
		$totalm = trim(odbc_result($cur,16));
		$totala = str_replace(",","",trim(odbc_result($cur,17)));
		if ($totala == "") $totala = "0.00";
		$acta = trim(odbc_result($cur,22));
		$constancia = trim(odbc_result($cur,23));
		$folio = trim(odbc_result($cur,24));
		$impacto = trim($row2['impacto']);
		$valoracion = trim($row2['valoracion']);
		$n_elaboro = trim($row2['elaboro']);
		$n_reviso = trim($row2['reviso']);
		$informacion = trim($row2['informacion']);
		$totali = substr(str_replace(',','',trim(odbc_result($cur,30))),0);
		if ($totali == "") $totali = "0.00";		

		$consulta_rec = "select * from cx_reg_rec where conse = '".$registro."' and ano = '".$ano1."' order by conse";
		$cur_rec = odbc_exec($conexion,$consulta_rec);
		$usuario = trim(odbc_result($cur_rec,3));
		$unidad_rec = trim(odbc_result($cur_rec,4));
		$fec_res = trim(odbc_result($cur_rec,8));
		$uni_man = odbc_result($cur_rec,16);
		$uni_efec = odbc_result($cur_rec,17);
		$brigada = odbc_result($cur_rec,18);
		$ordop = trim(odbc_result($cur_rec,24));
		$n_ordop = trim(odbc_result($cur_rec,25));
		$fragmenta = trim(odbc_result($cur_rec,27));
		$actas = odbc_result($cur_rec,39);
		if (substr($actas,-1) == "|") $actas = substr($actas,0,-1);
		$fecha_act = odbc_result($cur_rec,40);
		if (substr($fecha_act,-1) == "|") $fecha_act = substr($fecha_act,0,-1);
		$valor_act = odbc_result($cur_rec,41);
		if (substr($valor_act,-1) == "|") $valor_act = substr($valor_act,0,-1);
		$usuario1 = trim(odbc_result($cur_rec,48));
		$usuario2 = trim(odbc_result($cur_rec,49));
		$tipo = odbc_result($cur_rec,54);

		//Unidad que graba el informe
		$consulta_os = "select * from cx_org_sub where subdependencia = '".$unidad_rec."'";
		$cur_os = odbc_exec($conexion,$consulta_os);
		$n_unidad = trim(odbc_result($cur_os,4));

		if ($tipo == 1)
		{
			$consulta_rev = "select * from cx_reg_rev where consecu = '".$registro."' and ano = '".$ano1."' order by conse";
			$cur_rev = odbc_exec($conexion,$consulta_rev);			
			$oficio = trim(odbc_result($cur_rev,13));
			$fec_ofi = trim(odbc_result($cur_rev,14));
		}
		else
		{
			$lista = odbc_result($cur_rec,47);
			$p_lista = explode("|",$lista);
			$oficio2 = $p_lista[1];
			$fec_ofi2 = $p_lista[2];
			$oficio = $p_lista[6];
			$fec_ofi = $p_lista[7];
		}   //if

		$consulta1 = "select * from cv_unidades where subdependencia = '".$unidad_rec."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$siguom = trim(odbc_result($cur1,4));
		//$siguom = trim(odbc_result($cur1,2));

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

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,6,0,'');
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(130,6,'',0,0,'');
		if ($acta != "") $acta_n = $acta;
		$pdf->Cell(61,6,'ACTA NR.:    '.$acta_n,1,1,'L');

		$pdf->RoundedRect(9,$actual+6,192,6,0,'');
		$pdf->Cell(42,6,'LUGAR Y FECHA:',0,0,'');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(149,6,$lugar.', '.$fecha,1,1,'L');

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

		//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
		$consulta_act = "select * from cx_act_cen where conse = '".$conse."' and ano = '".$ano."'";
		$cur_act = odbc_exec($conexion,$consulta_act);
		$fecha_act = substr(odbc_result($cur_act,2),0,10);
		$unidad = trim(odbc_result($cur_act,4));

		$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_efec."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$s_unidad_afec = trim(odbc_result($cur1,1));
		$sigla1 = trim(odbc_result($cur1,3));
		$nom1 = trim(odbc_result($cur1,4));
		$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
		if ($sigla1 <> "") if ($fecha_act >= $fecha_os) $s_unidad_afec = $sigla1;	

		//Control para la ordop, a partir del 04-02-2024 inclusive.
		$fecha_ctlr = "20240204";      //control
		$fecha_rg = substr($fecha,0,4).substr($fecha,5,2).substr($fecha,8,2); //registro
		$dife = $fecha_rg-$fecha_ctlr;

		if ($dife > 0 and $ordop == "") $ordop = "N/A";
		else
		{
			if ($ordop == "") $ordop = "";
			else $ordop = $ordop." - ".$n_ordop;
		}

		//$fragmenta = "N/A";
		if ($dife <= 0) 
		{
			if ($fragmenta == "") $fragmenta = "";
			if ($ordop == "") $ordop = $fragmenta;
		}

		$asunto = "Trata del estudio que hace el comité regional de recompensas al expediente remitido por la sección ".$seccion." de la ".$sigla_uni.", mediante oficio No. ".$oficio." de fecha ".$fec_ofi;
		if ($fec_res != "" ) $asunto = $asunto." correspondiente al resultado registrado el día ".$fec_res;
		$asunto = $asunto." en cumplimiento a la orden de operaciones ".$ordop.", orden fragmentaria ".$fragmenta." adelantada por tropas del ".$s_unidad_afec.".\n";
		$mx = strlen($asunto);
		if ($mx > 115)
		{
			$ax = ceil($mx/110);
			if ($ax < 4) $ax = 4; 
		}
		else if ($ax < 110) $ax= 12;

		$actual=$pdf->GetY();
		$pdf->Cell(42,$ax,'ASUNTO:',T,0,'');
		$pdf->Multicell(149,$ax,$asunto,1,'J');

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'AL EFECTO SE PROCEDE COMO A CONTINUACIÓN SE RELACIONA',0,1,'L');
		$alefecto = "Una vez revisado y analizado el expediente objeto del trámite se concluye que este contiene todos los documentos exigidos en la Directiva Ministerial Permanente ".$n_directiva.", por lo tanto, el Comité Regional de Recompensas procede a efectuar su evaluación y valoración.\n\n";
		$pdf->Multicell(191,5,$alefecto,0,'J');

		$pdf->Cell(191,3,$linea2,0,1,'C');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(151,5,'VALOR SOLICITADO POR LA UNIDAD',0,0,'L');
		$pdf->Cell(40,5,'$'.number_format($vlrsol,2),1,1,'R');

		$actual=$pdf->GetY();
		$alefecto1 = "Expediente Operacion Militar ".$ordop." orden fragmentaria ".$fragmenta;
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(45,5,'SOPORTE DE LA SOLICITUD: ',R,0,'L');
		$pdf->Cell(146,5,$alefecto1,0,1,'J');
		$pdf->Cell(191,5,'',0,1,'R');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$consulta1 = "select * from cx_org_sub where subdependencia = '".$uni_man."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$s_uni_man = trim(odbc_result($cur1,4));
		$n_uni_man = trim(odbc_result($cur1,6));

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,10,0,'DF');
		$pdf->MultiCell(191,5,'1. CERTIFICACIÓN DE LA EXISTENCIA Y REGISTRO DE LA FUENTE HUMANA Y DE LA INFORMACIÓN SUMINISTRADA EN BASES DE DATOS DE INTELIGENCIA:',0,'L');
		$certi = "Según la(s) certificación(es) anexa(s) a folio(s) ".$constancia." existe(n) una(s) fuente(s) que aportó(aron) información(es) que condujo al planeamiento y/o desarrollo de la orden de operaciones ".$ordop.", orden fragmentaria ".$fragmenta.", adelantada por tropas del ".$s_unidad_afec." - ".$n_unidad_afec.".";
		if ($actas == 0) $certi = $certi."\nLa fuente no registra pagos previos.\n\n";
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

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,10,0,'DF');
		$pdf->Multicell(191,5,'2. SÍNTESIS DE LA INFORMACIÓN SUMINISTRADA POR LA FUENTE, UTILIDAD EN EL PROCESO DE INTELIGENCIA Y DE OPERACIONES MILITARES.',0,'L');
		$long = strlen($sintesis);
		$pdf->Multicell(191,5,$sintesis,0,'J');
		$pdf->Cell(191,3,$linea2,0,1,'C');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'3. VALORACIÓN DE LA SOLICITUD DEL PAGO DE INFORMACIÓN(ES) EN CASOS CUYO MONTO SEA > 10 SMLMV',0,1,'L');
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(147,5,'Exactitud, oportunidad, utilidad de la información e impacto',0,0,'C');
		$pdf->Cell(44,5,'Valoración',1,1,'C');
		control_salto_pag($pdf->GetY());

		if (strlen($informacion) == 0)
		{
			$informacion = "OMITIDO";
			$totali = "0.00";
		}   //if
 		$pdf->tablewidths = array(148, 44);
		$vlr = number_format($totali,2);
		$data[] = array($informacion, '$'.$vlr);
		$t_valoracion = $t_valoracion + $totali;
		$pdf->morepagestable($data);
		unset($data);

		$actual=$pdf->GetY();
		control_salto_pag($pdf->GetY());
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(147,5,'Total valoración información(s).',0,0,'L');
		$pdf->Cell(44,5,'$'.number_format($t_valoracion,2),1,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(191,5,'4. VALORACIÓN DE LA SOLICITUD DE PAGO DE RECOMPENSA(S).',0,1,'L');
		$pdf->Cell(191,5,'4.1 NEUTRALIZADOS',0,1,'L');
		$pdf->Ln(1);
		if ($pdf->GetY() >= 248.40125)
		{
			$pdf->addpage();
			$pdf->Ln(1);
		}   //if
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,8,0,'');
		$pdf->Cell(9,4,'',0,0,'C');
		$pdf->Cell(62,4,'',L,0,'C');
		$pdf->Cell(62,4,'',L,0,'C');
		$pdf->Cell(29,4,'Montos directiva ',L,0,'C');
		$pdf->Cell(29,4,'',L,1,'C');
		$pdf->Cell(9,4,'Nivel',0,0,'C');
		$pdf->Cell(62,4,'Identidad',L,0,'C');
		$pdf->Cell(62,4,'Cargo en la organización delincuencial',L,0,'C');
		$pdf->Cell(29,4,'(hasta)',L,0,'C');
		$pdf->Cell(29,4,'Valoración',L,1,'C');
		$neutral = explode("|",$neutralizados);
		$cn = count($neutral)-2;
		$actual=$pdf->GetY();
		$x = 0;
		$y = $pdf->Gety();
		for ($f=0;$f<=$cn;$f++)
		{
			$neutral1 = explode("»",$neutral[$f]);
			$cr = count($neutral1)-1;
			if ($cr == 5) $neutral1[6] = "";	
			if (substr($neutral1[0],0,1) == 1) $elem = "I";
			elseif (substr($neutral1[0],0,1) == 2) $elem = "II";
			elseif (substr($neutral1[0],0,1) == 3) $elem = "III";
			elseif (substr($neutral1[0],0,1) == 4) $elem = "IV";
			elseif (substr($neutral1[0],0,1) == 5) $elem = "V";
			elseif (substr($neutral1[0],0,1) == 6) $elem = "VI";
			elseif (substr($neutral1[0],0,1) == 7) $elem = "VII";
			$data1[] = array($elem, $neutral1[1], trim($neutral1[6]), '$'.trim(substr($neutral1[2],0)), '$'.trim(substr($neutral1[4],0)));
		}   //for
		$pdf->tablewidths = array(10, 62, 62, 29, 29);
		$pdf->morepagestable($data1);
		unset($data1);

		$pdf->RoundedRect(9,$actual,192,7,'');
		$pdf->Cell(162,7,'SUBTOTAL',0,0,'L');
		$pdf->Cell(29,7,'$'.$totaln,L,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$susten = "4.1.1 SUSTENTACIÓN DE LA VALORACIÓN DE INDIVIDUOS NEUTRALIZACIONES\n\n";
		$susten = $susten.$valoracion;
		$pdf->Multicell(191,5,$susten,0,'L');
		$pdf->Cell(44,5,'',0,1,'L');
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,10,0,'DF');
		$pdf->Multicell(191,5,'4.2 VALORACIÓN MATERIAL, EQUIPO, EXPLOSIVOS, VEHÍCULOS, EQUIPO AERONÁUTICO, ELEMENTOS DE NARCOTRÁFICO Y SUSTANCIAS QUÍMICAS INCAUTADAS:',0,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,8,0,'');
		$pdf->Cell(77,8,'Elementos incautados',0,0,'C');
		$pdf->Cell(14,8,'Cant',L,0,'C');
		$pdf->Cell(43,8,'Valor según directiva (hasta)',L,0,'C');
		$pdf->Cell(14,8,'Estado',L,0,'C');
		$pdf->Cell(43,8,'V/R total aprobado',1,1,'C');

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
			if ($material1[2] == 0 or $material1[2] == "") $material1[2] = "0";
			if ($material1[6] == 0 or $material1[6] == "") $material1[6] = "0";
			if ($material1[3] == "") $material1[3] = "0.00";
			$data1[] = array($elemento1, number_format(substr($material1[1],0,-1)), '$'.number_format($material1[3],2), trim(substr($material1[4],0,-1)), '$'.number_format(trim($material1[6]),2));
			$stot = $stot + str_replace(',','',trim($material1[6]));
			control_salto_pag($pdf->GetY());
			$pdf->tablewidths = array(78, 14, 43, 14, 43);
			$pdf->morepagestable($data1);
			unset($data1);
		}   //for

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,6,0,'');
		$pdf->Cell(148,6,'SUBTOTAL',0,0,'L');
		$pdf->Cell(43,6,'$'.number_format($stot,2),L,1,'R');

		$pdf->SetFont('Arial','',9);
		$actual=$pdf->GetY();
		$estado = "ESTADO: Según registros del informe de peritaje.\nN= Nuevo,	B= Bueno,	 D= Dañado o inservible,	 N/A= No Aplica";
		$pdf->Multicell(191,5,$estado,0,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,6,0,'');
		$pdf->Cell(148,6,'TOTAL VALORACIÓN SOLICITUD PAGO DE RECOMPENSA(S) E INFORMACIÓN',0,0,'L');
		$pdf->Cell(43,6,'$'.number_format($totala,2),L,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Multicell(191,5,'4.3 IMPACTO DEL RESULTADO OPERACIONAL',0,'L');
		$pdf->Multicell(191,5,$impacto,0,'L');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(192,5,'5. CONCEPTO DE EVALUACIÓN DEL COMITÉ',0,1,'L');
		$pdf->Multicell(191,5,$concepto,0,'J');
		$pdf->Cell(44,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(148,5,'6. MONTO A SOLICITAR',0,0,'L');
		$pdf->Cell(43,5,'$'.number_format($totala,2),L,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(148,5,'UNIDAD CENTRALIZADORA QUE REALIZA EL PAGO',0,0,'L');
		$pdf->Cell(43,5,$siguom,L,1,'R');
		$pdf->Cell(44,5,'',0,1,'R');

		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(192,5,'7. OBSERVACIONES',0,1,'L');
		$pdf->Multicell(191,4,$observaciones,0,'J');
		$pdf->Cell(191,3,$linea,0,1,'C');
	}   //if

	//Firmas
	control_salto_pag($pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->Ln(2);
	$pdf->Multicell(191,5,"No siendo otro el objeto de la presente, se da por terminada y en constancia firman los que intervinieron en este Comité:",0,'J');
	$pdf->Ln(5);
	if ($ajuste > 0) $pdf->Ln($ajuste);
	$nfir = count($inter);
	if ($nfir % 2 == 0)
	{
		$cmp = count($inter)-1;
		$ax = 0;
	}
	else
	{
		$cmp = $nfir-1;
		$ax = 1;
	}   //if
	
	$pdf->SetFont('Arial','',7.5);
	for ($i=$cmp;$i>=$ax;$i=$i-2)
	{
		$nom = $inter[$i]["nom"]."\n".$inter[$i]["cargo"]."\n\n";
		$nom1 = $inter[$i-1]["nom"]."\n".$inter[$i-1]["cargo"]."\n\n";
		if ($ajuste > 0) $pdf->Ln($ajuste);		
		$pdf->Ln(18);
		if ($pdf->GetY() >= 248.40125)
		{
			$pdf->addpage();
			$pdf->Ln(24);
		}   //if
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetXY($x,$y);
		$pdf->Multicell(90,4,$nom,T,'C');
		$pdf->SetXY($x+90,$y);
		$pdf->Multicell(10,4,"",0,'C');
		$pdf->SetXY($x+100,$y);		
		$pdf->Multicell(90,4,$nom1,T,'C');
		$n = (count($inter)-1)/2;
		if ($i == $n) $pdf->Cell(190,0,'',0,1,'C');
		else $pdf->Cell(190,4,'',0,1,'C');
	}   //for

	if ($nfir % 2 != 0)
	{
		control_salto_pag($pdf->GetY());
		$actual=$pdf->GetY();
		$pdf->Ln(18);
		$nom = $inter[0]["nom"]."\n".$inter[0]["cargo"]."\n\n";
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetXY($x,$y);
		$pdf->Multicell(60,4,"",0,'C');
		$pdf->SetXY($x+60,$y);
		$pdf->Multicell(90,4,$nom,T,'C');
	}   //if
		
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(1);
	$pdf->SetFont('Arial','',7);
	control_salto_pag($pdf->GetY());
	$actual = $pdf->GetY();
	$pdf->Multicell(191,3,$texto,TB,'J');
	$pdf->SetFont('Arial','',8);
	$pdf->Ln(1);
	$actual = $pdf->GetY();
	$pdf->Cell(95,4,'Elaboró:    '.utf8_encode($n_elaboro),0,0,'');
	$pdf->Cell(95,4,'Revisó:    '.$n_reviso,0,1,'');
	$pdf->Ln(-2);
	$pdf->Cell(191,3,$linea2,0,1,'C');

	if ($estado_r == "F")
	{
		if ($t_comite == 1) $nom_pdf = "../fpdf/pdf/Actas/ActaComCen_".$n_unidad."_".$conse."_".$ano.".pdf";
		else $nom_pdf = "../fpdf/pdf/Actas/ActaComReg_".$n_unidad."_".$conse."_".$ano.".pdf";
		$pdf->Output($nom_pdf,"F");
	}   //if
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>
