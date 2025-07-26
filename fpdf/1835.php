<?php
/* 1835.php    
     Acta Informe de Verificación.

	01/07/2023 - SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
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
			$acta = $_GET['acta'];
			$conse = $_GET['conse'];
			$ano = $_GET['ano'];
			
			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta_av = "select * from cx_act_ver where conse = '".$conse."' and ano = '".$ano."'";
			$cur_av = odbc_exec($conexion,$consulta_av);
			$sub_av = odbc_result($cur_av,4);
			$fecha_av = substr(odbc_result($cur_av,9),0,10);
			$ucen_av = trim(odbc_result($cur_av,10));
			$pos_av = 0;
			$pos_av = strpos($ucen_av, '-');
			if ($pos_av <> 0) $ucen_av = substr($ucen_av,0,$pos_av);
			else $ucen_av = substr($ucen_av,0,7);

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where sigla = '".$ucen_av."'"; //subdependencia = '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			if (odbc_num_rows($cur1) == 0) $sigla = $ucen_av;
			else
			{
				$sigla = trim(odbc_result($cur1,1));
				$sigla1 = trim(odbc_result($cur1,3));
				$nom1 = trim(odbc_result($cur1,4));
				$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
				if ($sigla1 <> "") if ($fecha_av >= $fecha_os) $sigla = $sigla1;
			}   //if

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
			else $this->RotatedText(25,230,$sigla,35);

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
			$this->Cell(73,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(50,5,'INFORME DE',0,0,'C');
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(50,5,'VERIFICACIÓN',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-1835',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(50,5,'GASTOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(50,5,'RESERVADOS',0,0,'C');
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
		}//_Arc

		function morepagestable($datas, $lineheight=4.0)
		{
			global $act;
			$linea = str_repeat("_",122);
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
				if ($this->GetY() >= 230.00125) $sal = 1;

				foreach($data AS $col => $txt)
				{
					$this->page = $currpage;
					$act = $h;
					$this->SetXY($l,$h);
					$this->SetFont('Arial','',8);
					//ancho de columnas 9, 17, 102, 18, 46
					if ($this->tablewidths[$col] == 9 or $this->tablewidths[$col] == 17 or $this->tablewidths[$col] == 18)
					    $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'C');
					elseif ($this->tablewidths[$col] == 46) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'C');
					else $this->MultiCell($this->tablewidths[$col],$lineheight,$txt);
					$l += $this->tablewidths[$col];

					if(!isset($tmpheight[$row.'-'.$this->page])) $tmpheight[$row.'-'.$this->page] = 0;
					if($tmpheight[$row.'-'.$this->page] < $this->GetY()) $tmpheight[$row.'-'.$this->page] = $this->GetY();
					if($this->page > $maxpage) $maxpage = $this->page;
				}   //for
				$h = $tmpheight[$row.'-'.$maxpage];
				$l = $this->lMargin-1;
				$currpage = $maxpage;
				$this->page = $currpage;
			}   //for
			$this->SetXY($l,$h);
			$this->Cell(191,8,'',0,1);
			$this->page = $maxpage;
			$this->Line($l,$h,$fullwidth+$l,$h);
			$act = $h + 8;

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
  			$this->Cell(190,4,'SIGAR - '."Fecha de impresión: ".$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
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
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(192);
	$pdf->SetFont('Arial','',8);
	$buscar = array(chr(13).chr(10), chr(13), chr(10), "\r\n", "\n", "\r", "\n\r");
	$sustituye = array ('Ã¡' => 'á', 'Ãº' => 'ú','Ã“' => 'Ó','ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'ÃƒÂƒÃ‚ÂƒÃƒÂ‚Ã‚ÂƒÃƒÂƒÃ‚Â‚ÃƒÂ‚Ã‚Â' => 'Í', 'Ã­' => 'í', 'Ã' => 'Á');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);

	$acta = $_GET['acta'];
	$conse = $_GET['conse'];
	$ano = $_GET['ano'];
	if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
	else $ajuste = "0";
	$hoja = $_GET['hoja'];

	function control_salto_pag($st, $actual1)
	{
		global $pdf;
		if ($st == 0 and $actual1 >= 245.00125) $pdf->addpage();   //firmas
		elseif ($st == 1 and $actual1 >= 260.00125) $pdf->addpage();  //normal
		else if ($actual1 >= 272.00125) $pdf->addpage(); //cuadro
	} //control_salto_pag

	$consulta = "select * from cx_act_ver where conse = '".$conse."' and ano = '".$ano."'";
	$cur = odbc_exec($conexion,$consulta);
	$row = odbc_fetch_array($cur);
	$estado = trim(odbc_result($cur,5));
	$fecha = substr(odbc_result($cur,9),0,10);
	$ucentraliza = $row['centraliza'];
	$periodo= $row['periodo'];
	$plan_ver = $row['planes'];
	$acta = trim(odbc_result($cur,7));
	if ($acta == "") $acta = odbc_result($cur,1);
	$lugar = trim(odbc_result($cur,8));
	$asunto = trim($row['asunto']);
	$fe_ini = substr(odbc_result($cur,13),0,10);
	$fe_fin = substr(odbc_result($cur,14),0,10);
	$ciudad = trim(odbc_result($cur,14));
	$funci_ap = substr($row['funcionarios'],0,-1);
	$resp_ap = trim($row['responsable']);
	$docs = trim($row['documentos']);
	$asptec	= trim($row['aspectos']);
	$observaciones = substr(trim($row['observaciones']),0,-1);
	$actividades = trim($row['actividades']);
	$recomendaciones = trim($row['recomendaciones']);
	$reconocimientos = trim($row['reconocimientos']);
	$aprueba = trim($row['aprobo']);
	$elaboro = trim($row['elaboro']);
	$reviso = trim($row['reviso']);
	$prese_ap = substr($row['presentan'],0,-1);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(96,5,'Radicado NR.',0,0,'R');
	$pdf->Cell(96,5,$acta,L,1,'L');
	$pdf->RoundedRect(9,$actual+5,192,5,0,'');
	$pdf->Cell(96,5,'Lugar y fecha de elaboración del informe:',0,0,'');
	$fecha = substr($fecha,8,2)."/".substr($fecha,5,2)."/".substr($fecha,0,4);
	$pdf->Cell(96,5,$lugar.', '.$fecha,0,1,'L');
	$pdf->RoundedRect(9,$actual+10,192,5,0,'');
	$pdf->Cell(96,5,'Unidad centralizadora gastos reservados verificada:',0,0,'');
	$pdf->Cell(96,5,$ucentraliza,L,1,'L');
	$pdf->RoundedRect(9,$actual+15,192,5,0,'');
	$pdf->Cell(96,5,'Período de ejecución gastos reservados verificado:',0,0,'');
	$pdf->Cell(96,5,$periodo,L,1,'L');
	$pdf->RoundedRect(9,$actual+20,192,5,0,'');
	$pdf->Cell(96,5,'Plan de verificación No:',0,0,'');
	$pdf->Cell(96,5,$plan_ver,L,1,'L');
	$pdf->RoundedRect(9,$actual+25,192,5,0,'');
	$pdf->Cell(72,5,'Fecha de inicio de la verificación:',0,0,'');
	$pdf->Cell(24,5,$fe_ini,1,0,'C');
	$pdf->Cell(71,5,'Fecha término de la verificación:',L,0,'');
	$pdf->Cell(24,5,$fe_fin,1,1,'C');

	$fir_res= "";
	$responsable = explode("|",$resp_ap);
	for ($i=0;$i<count($responsable)-1;$i++) $resp[$i] = $responsable[$i];
	for ($i=0;$i<=count($resp);$i++)
	{
		$resp1 = explode("»",$resp[$i]);
		$fun[$i]["nom"] = $resp1[0];
		$fun[$i]["cargo"] = $resp1[1];
		$fir_res = $fir_res.$fun[$i]["nom"]."\n";
		if ($i < count($resp)) $fir_res = $fir_res.$fun[$i]["cargo"]."\n\n";
		else $fir_res = $fir_res.$fun[$i]["cargo"];
	}   //for
	$fir_res = substr($fir_res,0,-3);

	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x-1,$y);
	$pdf->multicell(97,4,'Responsable procedimiento gastos reservados:',0,'');
	$pdf->SetXY($x+96,$y);
	$pdf->Multicell(95,4,"\n".$fir_res,L,'L');
	$pdf->Ln(-2);
	$pdf->Cell(190,3,$linea,0,1,'C');

	$actual=$pdf->GetY();
	$pdf->Multicell(191,4,'Documentos analizados:'."\n".$docs."\n",0,'J');
	$pdf->Cell(192,3,$linea,0,1,'C');

	control_salto_pag(1, $pdf->GetY());
	$actual = $act = $pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(192,5,'1. RESULTADOS DE LA VERIFICACIÓN',0,1,'L');
	$pdf->RoundedRect(9,$actual+5,192,5,0,'DF');
	$pdf->Cell(192,5,'1.1 ASPECTOS POSITIVOS',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x,$y);
	if ($act == 44.00125) $asptec = $asptec."\n\n\n";
	$pdf->Multicell(191,5,$asptec,0,'J');

	control_salto_pag(1, $pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(192,5,'1.2 OBSERVACIONES',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'D');
	$pdf->Cell(8,5,'No.',0,0,'C');
	$pdf->Cell(17,5,'UNIDAD',L,0,'C');
	$pdf->Cell(102,5,'DESCRIPCIÓN DE LA OBSERVACIÓN',L,0,'C');
	$pdf->Cell(18,5,'FECHA',L,0,'C');
	$pdf->Cell(46,5,'TIPO DOCUMENTO',L,1,'C');

	if ($observaciones == "")
	{
		$pdf->Cell(8,5,'',0,0,'C');
		$pdf->Cell(17,5,'',L,0,'C');
		$pdf->Cell(102,5,'',L,0,'C');
		$pdf->Cell(18,5,'',L,0,'C');
		$pdf->Cell(46,5,'',L,1,'C');
	}
	else
	{
		$pdf->tablewidths = array(9, 17, 102, 18, 46);
		$obser = explode("|",$observaciones);
		foreach ($obser as $row => $dat)
		{
			$observa = explode("»",$dat);
			$consulta_cu = "select * from cv_unidades where subdependencia = '".$observa[1]."'";
			$cur_cu = odbc_exec($conexion,$consulta_cu);
			$n_unidad = trim(odbc_result($cur_cu,6));

			$consulta_ts = "select * from cx_ctr_doc where codigo = '".$observa[4]."'";
			$cur_ts = odbc_exec($conexion,$consulta_ts);
			$t_soporte = trim(odbc_result($cur_ts,2));
			$data[] = array($observa[0], $n_unidad, $observa[2], trim($observa[3]), $t_soporte);
			$pdf->morepagestable($data);
			unset($data);
			control_salto_pag(3, $act);
		}   //for
	}   //if

	control_salto_pag(1, $act);
	$pdf->Ln(4);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(192,5,'1.3 RECOMENDACIONES',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x,$y);
	$pdf->Multicell(191,5,$recomendaciones."\n\n",0,'J');
	$pdf->Cell(5,5,'',0,1,'');

	control_salto_pag(1, $pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(192,5,'2. RECONOCIMIENTOS',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x,$y);
	$pdf->Multicell(191,5,$reconocimientos."\n\n",0,'J');

	control_salto_pag(1, $pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(192,5,'3. OTRAS ACTIVIDADES REALIZADAS',0,1,'L');
	$pdf->SetFont('Arial','',8);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x,$y);
	$pdf->Multicell(191,5,$actividades."\n",0,'J');

	//control_salto_pag(1, $pdf->GetY());
	if ($pdf->GetY() >= 250.10125)
	{
		$pdf->addpage();
	}   //if	

	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->RoundedRect(9,$actual,192,5,0,'DF');
	$pdf->Cell(96,5,'Funcionarios(s) designado(s) para la verificación',0,0,'C');
	$pdf->Cell(96,5,'Funcionario(s) que presenta(n) la verificación',L,1,'C');
	$pdf->SetFont('Arial','',8);

	$funcionarios = explode("|",$funci_ap);
	$prese = explode("|",$prese_ap);
	for ($f=0;$f<count($funcionarios);$f++) $funci[$f] = $funcionarios[$f];
	for ($p=0;$p<=count($prese)-1;$p++) $prese1[$p] = $prese[$p];
	$max = max(count($funcionarios), count($prese));
	for ($p=0;$p<=$max-1;$p++)
	{
		$funci1= explode("»",$funci[$p]);
		$prese = explode("»",$prese1[$p]);
		$actual=$pdf->GetY();
		$tfun = $tpre = "";
		$tfun = "\n\n\n".$funci1[0]."\n".$funci1[1]."\n\n";
		$tpre = "\n\n\n".$prese[0]."\n".$prese[1]."\n\n";
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetXY($x-1,$y);
		$pdf->Multicell(97,5,$tfun,R,'C');
		$pdf->SetXY($x+96,$y);
		$pdf->Multicell(95,5,$tpre,L,'C');
		control_salto_pag(0, $pdf->GetY());
	}   //for

	control_salto_pag(1, $pdf->GetY());
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',7);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x-1,$y);
	$pdf->Multicell(192,3,$texto,1,'J');

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(95,5,'Elaboró:    '.strtr($elaboro, $sustituye),0,0,'');
	$pdf->Cell(96,5,'Revisó:    '.strtr($reviso, $sustituye),L,1,'');

	if ($estado == "A")
	{
		//$nom_pdf="pdf/Actas/ActaInfVer_".trim($sig_usuario)."_".$_GET['acta']."_".$_GET['ano'].".pdf";
		$nom_pdf = "../fpdf/pdf/Actas/ActaInfVer_".$_GET['acta']."_".$_GET['conse']."_".$_GET['ano'].".pdf";
		$pdf->Output($nom_pdf,"F");
	}
	$file=basename(tempnam(getcwd(),'tmp'));

	//$pdf->Output();
	$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
}
?>

