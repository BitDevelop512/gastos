<?php
/* 000.php
   FO-JEMPP-CEDE2-000- Reporte bienes.
   (pág 109 - "Ditectiva Permanente No. 00095 de 2017.PDF")

	- Se ajusta el pintado de las filas de información.
	01/07/2023 - SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	25/10/2024 - Se hace el cambio de la variable num_dependencia por unidad. Ahora se recibe la lista de unidades desde la consulta. -Jaime Morales
	15/11/2024 - Se controlan el cambio de las firmas a partir del 01/11/2024 y el cambio de las firmas a partir del 01/11/2024.  Jorge Clavijo.
	10/12/2024 - Se hace el control de firmas a partir del 01/01/2024 por solicitud de Jorge Clavijo, valida Angela Díaz.
select * from cv_pla_bie where unidad in (212,213,214,215,216,217,218,219,220,221,222,223,224,225,241,242,226,227,229,230,231,232,233,234,246,247,319,235,236,237,238,239,240,245) and convert(datetime,fec_com,102) BETWEEN convert(datetime,'2024/11/01',102) and (convert(datetime,'2024/11/30',102) + 1) order by conse
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
			
			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta_os = "select sigla, nombre, sigla1, nombre1, fecha, dependencia from cx_org_sub where sigla = '".$sig_usuario."'";
			$cur_os = odbc_exec($conexion,$consulta_os);
			$sigla = trim(odbc_result($cur_os,1));
			$sigla1 = trim(odbc_result($cur_os,3));
			$nom1 = trim(odbc_result($cur_os,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur_os,5)),0,10));			
			$n_dependencia = trim(odbc_result($cur_os,6));

			if ($uni_usuario == 2) $consulta_pb = "select * from cv_pla_bie where convert(datetime,fec_com,102) BETWEEN convert(datetime,'".$_GET['fecha1']."',102) and (convert(datetime,'".$_GET['fecha2']."',102) + 1) order by conse DESC";
			else $consulta_pb = "select * from cv_pla_bie where num_dependencia = '".$n_dependencia."' and convert(datetime,fec_com,102) BETWEEN convert(datetime,'".$_GET['fecha1']."',102) and (convert(datetime,'".$_GET['fecha2']."',102) + 1) order by conse DESC";
			$cur_pb = odbc_exec($conexion,$consulta_pb);
			$fecha_pb = substr(odbc_result($cur_pb,2),0,10);

			if ($sigla1 <> "") if ($fecha_pb >= $fecha_os) $sigla = $sigla1;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(115,175,$sigla,35);
			else $this->RotatedText(75,180,$sigla,35);

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(328,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(176,5,'',0,0,'C');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(176,5,'REPORTE DE BIENES ADQUIRIDOS CON',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-000',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(176,5,'GASTOS RESERVADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(176,5,'',0,0,'C');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'AAAA-MM-DD',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(175,3,'',0,0,'');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,339,26,0,'');
			$this->RoundedRect(114,15,174,26,0,'');
			$this->RoundedRect(288,15,60,26,0,'');
			$this->RoundedRect(9,15,339,183,0,'');

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
		}//function _Arc()

		function morepagestable($datas, $lineheight=3.5)
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
					if ($this->tablewidths[$col] == 64) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'J');
					elseif ($this->tablewidths[$col] == 20) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
  			$this->Cell(328,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
   			$this->Code39(329,200,$cod_bar,.5,5);
		}//Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');

	$pdf=new PDF('L','mm','Legal');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);

	$linea = str_repeat("_",203);
	$lugar = "Bogotá";

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=172.00125) $pdf->addpage();
	} //control_salto_pag

	$pdf->SetFont('Arial','',7);
	$actual=$pdf->GetY();
	$pdf->Cell(35,5,'UNIDAD CENTRALIZADORA',0,0,'L');
	$pdf->Cell(90,5,$sig_usuario,B,0,'L');
	$pdf->Cell(206,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(35,5,'PERIODO',0,0,'L');
	$pdf->Cell(90,5,'Del '.$_GET['fecha1'].' al '.$_GET['fecha2'],B,1,'L');
	$pdf->Ln(2);

	$pdf->SetFont('Arial','',6);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+3,339,9,0,'DF');
	$pdf->Ln(3);
	$pdf->Cell(61,9,'DESCRIPCIÓN DEL BIEN',0,0,'C');
	$pdf->Cell(15,3,'FECHA',LR,0,'C');
	$pdf->Cell(20,9,'VALOR',1,0,'C');
	$pdf->Cell(17,3,'COMPROBANTE',LR,0,'C');
	$pdf->Cell(28,3,'ORDOP/MISIÓN',LR,0,'C');
	$pdf->Cell(15,3,'UNIDAD',LR,0,'C');
	$pdf->Cell(60,3,'NR Y FECHA ACTAS',1,0,'C');
	$pdf->Cell(23,3,'ORDOP/MISIÓN',LR,0,'C');
	$pdf->Cell(30,3,'PÓLIZAS',LR,0,'C');
	$pdf->Cell(18,3,'ESTADO',LR,0,'C');
	$pdf->Cell(51,9,'OBSERVACIONES',LR,0,'C');
	$pdf->Cell(1,3,'',0,1,'C');

	$pdf->Cell(61,3,'',0,0,'C');
	$pdf->Cell(15,3,'COMPRA',LR,0,'C');
	$pdf->Cell(20,3,'',0,0,'C');
	$pdf->Cell(17,3,'DE EGRESO',LR,0,'C');
	$pdf->Cell(28,3,'DONDE FUE',LR,0,'C');
	$pdf->Cell(15,3,'REALIZO',LR,0,'C');
	$pdf->Cell(30,3,'RESPONSABLE',LR,0,'C');
	$pdf->Cell(30,3,'USUARIO FINAL',LR,0,'C');
	$pdf->Cell(23,3,'DONDE ESTA',LR,0,'C');
	$pdf->Cell(30,3,'ADQUIRIDO SOAT',LR,0,'C');
	$pdf->Cell(18,3,'ACTUAL',LR,0,'C');
	$pdf->Cell(51,3,'',LR,1,'C');

	$pdf->Cell(61,3,'',0,0,'C');
	$pdf->Cell(15,3,'',LR,0,'C');
	$pdf->Cell(20,3,'',0,0,'C');
	$pdf->Cell(17,3,'',LR,0,'C');
	$pdf->Cell(28,3,'COMPRADO',LR,0,'C');
	$pdf->Cell(15,3,'COMPRA',LR,0,'C');
	$pdf->Cell(30,3,'ORDOP',LR,0,'C');
	$pdf->Cell(30,3,'DEL BIEN',LR,0,'C');
	$pdf->Cell(23,3,'EMPLEADO',LR,0,'C');
	$pdf->Cell(30,3,'TODO RIESGO',LR,0,'C');
	$pdf->Cell(18,3,'DEL BIEN',LR,0,'C');
	$pdf->Cell(51,3,'',LR,1,'C');
	$pdf->SetFont('Arial','',6,5);

	$consulta_os = "select * from cx_org_sub where sigla = '".$sig_usuario."'";
	$cur = odbc_exec($conexion,$consulta_os);
	$n_dependencia = trim(odbc_result($cur,2));
	
	//13/11/2024 Se toman las firmas de la tabla cx_usu_web para eleaboró  de acuerdo con la sigla del usuario que consulta y de cx_org_sub para el resto.
	if (substr($sig_usuario,0,3) == 'DIV') $sig_usuario = substr($sig_usuario,0,3).substr($sig_usuario,4,1);

	$pp = substr($usu_usuario,0,4);
	$consulta_fmr = "select * from cx_usu_web where usuario = '".$pp.$sig_usuario."'";
	$cur_fmr = odbc_exec($conexion,$consulta_fmr);
	$sga = trim(odbc_result($cur_fmr,4));	

	$consulta_fmr1 = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
	$cur_fmr1 = odbc_exec($conexion,$consulta_fmr1);
	while($f<$row=odbc_fetch_array($cur_fmr1))
	{
		if (trim(odbc_result($cur_fmr1,13)) == "")
		{
			$n_eje = "";
			$c_eje = "OFICIAL DE INTELIGENCIA Y CONTRAINTELIGENCIA";
		}
		else 
		{
			$n_eje = trim(odbc_result($cur_fmr1,13));
			$c_eje = trim(odbc_result($cur_fmr1,28));
		}   //if
		$eje = $n_eje."\n".$c_eje;

		if (trim(odbc_result($cur_fmr1,14)) == "")
		{
			$n_jem = "";
			$c_jem = "JEFE DE ESTADO MAYOR ".trim(odbc_result($cur_fmr1,6));
		}
		else
		{
			$n_jem = trim(odbc_result($cur_fmr1,14));
			$c_jem = trim(odbc_result($cur_fmr1,29));
		}   //if
		$jem = $n_jem."\n".$c_jem;

		if (trim(odbc_result($cur_fmr1,14)) == "")
		{
			$n_cdo = "";
			$c_cdo = "COMANDANTE ".trim(odbc_result($cur_fmr1,6));		
		}
		else
		{
			$n_cdo = trim(odbc_result($cur_fmr1,15));
			$c_cdo = trim(odbc_result($cur_fmr1,30));
		}   //if
		$cdo = $n_cdo."\n".$c_cdo;
	}   //while

	//25/10/2024 Se hace el cambio de la variable num_dependencia por unidad. Ahora se recibe la lista de unidades desde la consulta. -Jaime Morales
	if ($uni_usuario == 2) $consulta = "select * from cv_pla_bie where convert(datetime,fec_com,102) BETWEEN convert(datetime,'".$_GET['fecha1']."',102) and (convert(datetime,'".$_GET['fecha2']."',102) + 1) order by conse";
	else $consulta = "select * from cv_pla_bie where unidad in (".$_GET['v_uni'].") and convert(datetime,fec_com,102) BETWEEN convert(datetime,'".$_GET['fecha1']."',102) and (convert(datetime,'".$_GET['fecha2']."',102) + 1) order by conse";
//echo $consulta."<br>";
	$cur = odbc_exec($conexion,$consulta);
	$row = odbc_num_rows($cur);

	$vtotal = 0;
	$actual=$pdf->GetY();
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$f = 1;
	while($f<$row=odbc_fetch_array($cur))
	{
		$fecha = substr(odbc_result($cur,2),0,10);
		$descri = trim($row[descripcion]);
		$fecha_c = odbc_result($cur,8);
		$vlr = substr(str_replace(',','',trim(odbc_result($cur,9))),0);
		$vtotal = $vtotal + $vlr;
		$soap = trim(odbc_result($cur,15));
		$poliza = trim(odbc_result($cur,21));
		$sp = $soap.", ".$poliza;
		$ordop = trim(odbc_result($cur,27));
		$mision = trim(odbc_result($cur,28));
		$om = $ordop.", ".$mision;
		$ordop1 = trim(odbc_result($cur,29));
		$uni_cmp = trim(odbc_result($cur,34));
		$estado1 = trim(odbc_result($cur,36));
		$c_egreso = trim(odbc_result($cur,37));
		$resp_ordop = trim(odbc_result($cur,42));
		$doc_respon = trim(odbc_result($cur,43));
		$fec_respon = trim(odbc_result($cur,44));
		$res_doc_fec = $resp_ordop.", ".$doc_respon.", ".$fec_respon;
		if (strlen($res_doc_fec) <= 6) $res_doc_fec = "";
		$nom_usua = trim(odbc_result($cur,67));
		$doc_usua = trim(odbc_result($cur,68));
		$fec_usua = trim(odbc_result($cur,69));
		$nom_doc_fec = $nom_usua." ".$doc_usua." ".$fec_usua;
		if (strlen($nom_doc_fec) <= 6) $nom_doc_fec = "";
		$data[] = array($descri, $fecha_c, wims_currency($vlr), $c_egreso, $om, $uni_cmp, $res_doc_fec, $nom_doc_fec, $ordop1, $sp, $estado1, "");
		$pdf->tablewidths = array(62, 15, 20, 17, 28, 15, 30, 30, 23, 30, 18, 51); 
		$pdf->morepagestable($data);
		unset($data);
		control_salto_pag($pdf->GetY());		
		$f++;
	}   //while

	$actual=$pdf->GetY();
	$pdf->Cell(76,5,'TOTAL',0,0,'R');
	$pdf->Cell(20,5,wims_currency($vtotal),1,1,'R');

	$actual=$pdf->GetY();
	if ($actual>=149.00125) $pdf->addpage();
	$pdf->Ln(4);
	$pdf->Cell(10,5,'Firmas',0,1,'L');

	//25/10/2024 Se controlan el cambio de las firmas a partir del 01/11/2024.
	//10/12/2024 El control de firmas se cambia a partir del 01/01/2024.
	$fe_cambio = "2024-01-01";
	$fe = str_replace("/", "-", $_GET['fecha1']);
	$actual = $pdf->GetY();
	if ($fe >= $fe_cambio)
	{	
		if (strlen($c_eje) >= 80 or strlen($c_jem) >= 80 or strlen($c_cdo) >= 80) $lin = 32;
		else $lin = 28;
		$pdf->RoundedRect(9,$actual,113,$lin,0,'');
		$pdf->RoundedRect(122,$actual,113,$lin,0,'');
		$pdf->RoundedRect(235,$actual,113,$lin,0,'');	
		$pdf->Ln(18);		
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetXY($x-1,$y);
		$pdf->Multicell(113,5,$eje,0,'C');
		$pdf->SetXY($x+112,$y);
		$pdf->Multicell(113,5,$jem,0,'C');	
		$pdf->SetXY($x+225,$y);
		$pdf->Multicell(113,5,$cdo,0,'C');	
	}
	else
	{
		$pdf->RoundedRect(9,$actual,170,28,0,'D');
		$pdf->RoundedRect(179,$actual,169,28,0,'D');
		$pdf->Ln(18);
		$pdf->Cell(170,5,'Firma, nombres y apellidos y cargo',0,0,'C');
		$pdf->Cell(170,5,'Firma, nombres y apellidos y cargo',0,1,'C');
		$pdf->Cell(169,5,'EJECUTOR GASTOS RESERVADOS SGA',0,0,'C');
		$pdf->Cell(169,5,'ORDENADOR DE GASTOS RESERVADOS CDO',0,1,'C');
		$n_eje = "";
	}   //if
		
	$actual = $pdf->GetY();
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(4);
	$pdf->Multicell(337,3,$texto,0,'J');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+1,339,5,0,'D');
	if ($fe >= $fe_cambio) $pdf->Cell(15,5,'Elaboró:    '.$sga,0,1,'L');
	else $pdf->Cell(15,5,'Elaboró:    ',0,1,'L');

	$pdf->Ln(2);
		$instgen="Instrucciones generales:\n1. Este reporte debe ser realizado por la unidad Centralizadora de gastos reservados.\n2. Relacionar todos los bienes devolutivos adquiridos en el periódo mensual por las Unidades o Áreas de inteligencia y contrainteligancia orgánicas.\n3. Diligenciar todos los campos.\n4. El campo de pólizas aplica solo para vehículos y motos adquiridas, otros bienes debe registrarse NO APLICA.\n5. El valor de los bienes corresponde al valor según factura de compra e incluye el IVA.\n6. En el ítem observaciones se indicará para el caso de perdidas, el Número del informe emitisdo por el responsable de la ORDOB o Misión y la circunstancia de la perdida y la acción tomada por el comandante de la unidad.\n7. El informe debe ser enviado MES VENCIDO, ejemplo: Bienes adquiridos en septiembre 2020 el reporte se envía con la cuenta del mes de octubre, dado que la información se extrae de los soportes de gastos realizados.";
	$pdf->Multicell(277,3,$instgen,0,'L');
	//Graba consulta
	$nom_pdf="pdf/ReporteBienes_".trim($sig_usuario)."_".substr($_GET['fecha1'],5,2)."_".substr($_GET['fecha1'],0,4).".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));
	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	//window.parent.document.getElementById('load1').style.display='none';
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>
