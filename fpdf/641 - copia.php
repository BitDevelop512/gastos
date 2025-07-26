<?php
/* 641.php
   FO-JEMPP-CEDE2-641- Solicitud de Recursos Gastos Reservados.
   (pág 77 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	01/01/2023 - SE HACE CAMBIO ENTRE SECRETO/ULTRASECRETO SEGÚN EL NIVEL. Consuelo Martínez
	01/07/2023 - SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	17/04/2024 - SE HACE AJUSTE A LAS FIRMAS POR CARACTERES ESPECIALES. Jorge Clavijo
	04/06/2024 - SE HACE REVISIÓN ÍTEM ANTERIOR PARA MOJARAR LA DETECCIÓN DE CARÁCTERES. Alfredo
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
				$conse = $_GET['conse'];
				$ano = $_GET['ano'];
				if (!empty($_GET['ano'])) $ano = $_GET['ano'];
				else $ano = date('Y');

				//01/01/2023 - Se hace cambio entre SECRETO/ULTRASECRETO según el Nivel.
				//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
				$consulta = "select * from cx_pla_inv where conse='$conse' and ano='$ano' and tipo='2'";
				$cur = odbc_exec($conexion,$consulta);
				$sigla_pi = substr(trim(odbc_result($cur,3)),4);
				$unidad = trim(odbc_result($cur,4));
				$estado = trim(odbc_result($cur,5));
				$nivel = trim(odbc_result($cur,56));
				$fecha_pi = str_replace("/", "-", substr(trim(odbc_result($cur,2)),0,10));

				$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$unidad."'";//$uni_usuario."'";
				$cur1 = odbc_exec($conexion,$consulta1);
				$sigla = trim(odbc_result($cur1,1));
				$sigla1 = trim(odbc_result($cur1,3));
				$nom1 = trim(odbc_result($cur1,4));
				$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));

				if ($nivel == 1 or $nivel == "") $msg = "SECRETO";
				else $msg = "ULTRASECRETO";
				if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $sigla = $sigla1;

				if ($unidad == '999' and $estado == 'X')
				{
					$this->SetFont('Arial','B',100);
					$this->SetTextColor(150,150,150);
					$this->RotatedText(30,100,'ANULADO',-35);
				}
				else
				{

					$this->SetFont('Arial','B',120);
					$this->SetTextColor(214,219,223);
					if (strlen($sigla) <= 6) $this->RotatedText(55,200,$sigla,35);
					else $this->RotatedText(25,230,$sigla,35);
					
				}   //if

				$this->SetFont('Arial','B',8);
				$this->SetTextColor(255,150,150);
				$this->Cell(190,5,$msg,0,1,'C');
				$this->Ln(2);

				$this->Image('sigar.png',10,17,17);
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(0,0,0);
				$this->Cell(17,5,'',0,0,'C',0);
				$this->Cell(70,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
				$this->Cell(55,5,'SOLICITUD DE RECURSOS',0,0,'C');
				$this->Cell(8,5,'Pág:',0,0,'');
				$this->SetFont('Arial','',8);
				$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

				$this->SetFont('Arial','B',8);
				$this->Cell(17,5,'',0,0,'C',0);
				$this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
				$this->Cell(55,5,'GASTOS',0,0,'C');
				$this->Cell(12,5,'Código:',0,0,'');
				$this->SetFont('Arial','',8);
				$this->Cell(36,5,'FO-JEMPP-CEDE2-641',0,1,'');

				$this->SetFont('Arial','B',8);
				$this->Cell(17,5,'',0,0,'C',0);
				$this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
				$this->Cell(55,5,'RESERVADOS',0,0,'C');
				$this->Cell(12,5,'Versión:',0,0,'');
				$this->SetFont('Arial','',8);
				$this->Cell(36,5,'2',0,1,'');

				$this->SetFont('Arial','B',8);
				$this->Cell(17,5,'',0,0,'C',0);
				$this->Cell(125,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
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
			
			function Footer()
			{
				require('../conf.php');
				$conse = $_GET['conse'];
				$ano = $_GET['ano'];
				$consulta = "select * from cx_pla_inv where conse='$conse' and ano='$ano' and tipo='2'";
				$cur = odbc_exec($conexion,$consulta);
				$unidad = trim(odbc_result($cur,4));
				$nivel = trim(odbc_result($cur,56));
				if ($nivel == 1 or $nivel == "") $msg = "SECRETO";
				else $msg = "ULTRASECRETO";

				$fecha1=date("d/m/Y H:i:s a");
				$fecha1 = "";
				$this->SetY(-10);
				$this->SetFont('Arial','',7);
				$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
				$this->Ln(-4);
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(255,150,150);

				$this->Cell(190,5,$msg,0,1,'C');
				$this->SetTextColor(0,0,0);
				$cod_bar='SIGAR';
				$this->Code39(182,285,$cod_bar,.5,5);
			}//Footer
		}//PDF extends PDF_Rotate

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

		$pdf->SetFillColor(204);
		$sustituye = array ( "'" => '"', "“" => '"', "”" => '"', 'Â€' => '"', 'Â€' => '"', "Ã¡" => "Á", "Ã©" => 'É', "Ã­" => "Í", "Ã³" => "Ó", "Â°" => "o", "Ãº" => "Ú", "Ã‘" => "Ñ", "Ã±" => "Ñ", "’" => "´", "–" => "-", "Ã“" => "Ó", "Ã‰" => "É", "Ãš" => "Ú");
		$sustituye2 = array ( "'" => '"', "“" => '"', "”" => '"', 'Â€' => '"', 'Â€' => '"', "Ã¡" => "Á", "Ã©" => 'É', "Ã­" => "Í", 'Ã“' => "Ó", "Ã³" => "Ó", "Â°" => "o", "Ãº" => "Ú", "Ã‘" => "Ñ", "Ã±" => "Ñ", "’" => "´", "–" => "-", "Ã“" => "Ó", "Ã‰" => "É", "Ãš" => "Ú");
		$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
		$linea = str_repeat("_",122);
		$linea1 = str_repeat("_",20);
		$espacio1 = str_repeat(" ",50);
 		$n_periodo="";
 		
 		//control de fecha para cambios en el formato, se imprime la estructura de cada misión solicitada por Joprge Clavijo 05/07/2023
 		$fecha_ctr = "2023-07-01";  

		$conse = $_GET['conse'];
		if (!empty($_GET['ano'])) $ano = $_GET['ano'];
		else $ano = date('Y');
		if (!empty($_GET['ajuste'])) $ajuste = $_GET['ajuste'];
		else $ajuste = "0";

		function remove_acentos($str) 
		{ 
		  $a = array('Â');
		  $b = array('');
		  return str_replace($a, $b, $str); 
		}   //remove_acentos 

		function control_salto_pag($actual1, $s)
		{
			global $pdf;
			$actual1=$actual1+5;
			if ($actual1>=259.00125) $pdf->addpage();
			if ($s == 1) $pdf->Ln(20);
		} //control_salto_pag

		$ruta_local1 = "C:\\inetpub\\wwwroot\\Gastos\\archivos\\server\\php\\anexos\\".trim($ano)."\\";
		$carpeta1 = $ruta_local1."\\".$conse;
		if(!file_exists($carpeta1)) mkdir ($carpeta1);

		$consulta = "select * from cx_pla_inv where conse='$conse' and ano='$ano' and tipo='2'";
		$cur = odbc_exec($conexion,$consulta);
		$row0 = odbc_fetch_array($cur);
		$consecu = odbc_result($cur,1);
		$fecha = substr(odbc_result($cur,2),0,10);
		$fecha_pi = str_replace("/", "-", substr($fecha,0,10));		
		$usuario = trim(odbc_result($cur,3));
		$estado = trim(odbc_result($cur,5));
		$lugar = trim(odbc_result($cur,6));
		$lugar = trim(decrypt1($lugar, $llave));
		$factor = explode(',', odbc_result($cur,7));
		$oms = trim(odbc_result($cur,23));
		$uni_anu = trim(odbc_result($cur,35));

		$linfac = "";
		$n_fac = count($factor);
		for ($i=0;$i<$n_fac;++$i)
		{
			$linfac = $linfac.$factor[$i].",";
		}   //for
		$linfac = substr($linfac,0,-2);
		
		$consulta1 = "select nombre from cx_ctr_fac where codigo in (".$linfac.")";
		$cur1 = odbc_exec($conexion,$consulta1);
		$n_factor = "";
		$i = 1;
		while($i<$row=odbc_fetch_array($cur1))
		{
			$n_factor = $n_factor.trim(odbc_result($cur1,1)).", ";
			$i++;
		}   //while

		$estructura = trim(odbc_result($cur,8));
		$consulta2 = "select nombre from cx_ctr_est where codigo in (".$estructura.")";
		$cur2 = odbc_exec($conexion,$consulta2);
		$n_estructura = "";
		$i = 1;
		while($i<$row=odbc_fetch_array($cur2))
		{
			$n_estructura = $n_estructura.trim(odbc_result($cur2,1)).", ";
			$i++;
		}   //while

		$periodo = $n_meses[odbc_result($cur,9)-1];
		$oficiales = odbc_result($cur,10);
		$suboficiales = odbc_result($cur,11);
		$auxiliares = odbc_result($cur,12);
		$soldados = odbc_result($cur,13);
		$ordop = odbc_result($cur,14);
		$ordop = trim(decrypt1($ordop, $llave));
		$n_ordop = odbc_result($cur,15);
		$n_ordop = trim(decrypt1($n_ordop, $llave));
		if ($n_ordop == "") $ordop = $ordop;
		else $ordop = $n_ordop." - ".$ordop;
		$misiones = odbc_result($cur,16);
		$misiones = trim(decrypt1($misiones, $llave));
		$misiones = str_replace('|',' - ',$misiones);
		$misiones = substr($misiones,0,-2);
		$n_misiones = odbc_result($cur,17);
		$actual1 = odbc_result($cur,21);
		$tipo1 = odbc_result($cur,27);

		$consulta11 = "select nombre from cx_ctr_oms where codigo='$oms'";
		$cur11 = odbc_exec($conexion,$consulta11);
		$n_oms = trim(odbc_result($cur11,1));

		$compania = odbc_result($cur,24);
		$consulta12 = "select * from cx_org_cmp where conse='$compania'";
		$cur12 = odbc_exec($conexion,$consulta12);
		$n_compania = trim(odbc_result($cur12,4));

		$unidad = trim(odbc_result($cur,4));
		$consulta13 = "select * from cx_org_sub where subdependencia='$unidad'";
		$cur13 = odbc_exec($conexion,$consulta13);
		$var_1 = odbc_result($cur13,1);            //unidad
		$var_2 = odbc_result($cur13,2);	           //dependencia
		$var_uni = trim(odbc_result($cur13,4));    //sigla - nombre dependencia
		$tipo_c = odbc_result($cur13,7);           //tipo
		$especial = trim(odbc_result($cur13,40));  //especial

		//Control para el cambio de sigla
		$sigla1 = trim(odbc_result($cur13,41));
		$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur13,43)),0,10));	
		if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $var_uni = $sigla1;

		if ($uni_anu <> 0)
		{
			$consulta13a = "select * from cx_org_sub where subdependencia='$uni_anu'";
			$cur13a = odbc_exec($conexion,$consulta13a);
			$var_uni = trim(odbc_result($cur13a,4));
		}   //if

		$consulta14 = "select nombre from cx_org_dep where dependencia='".$var_2."'";
		$cur14 = odbc_exec($conexion,$consulta14);
		$var_dep = trim(odbc_result($cur14,1));  //nombre dependencia

		$consulta15 = "select nombre from cx_org_uni where unidad='$var_1'";
		$cur15 = odbc_exec($conexion,$consulta15);
		$var_div = trim(odbc_result($cur15,1));   //nombre unidad mayor

		if ($tipo1 == "1") $tipo = "GASTOS EN ACTIVIDADES";
		else $tipo = "PAGO DE INFORMACIONES";

 		//----------- firma1 elaboro ------------
		$firma1 = trim(odbc_result($cur,45));

		if (substr($firma1,-2,2) == "Â»") $cc = -1;
		else $cc = 0;
		$elaboro = explode("»",$firma1);
		if ($cc == -1)
		{
			$n_elaboro = substr($elaboro[0],0,$cc);
			$c_elaboro = substr($elaboro[1],0,$cc);
		}
		else
		{
			$n_elaboro = $elaboro[0];
			$c_elaboro = $elaboro[1];
		}   //if
		
		//----------- firma3 reviso ------------
		$firma3 = trim(odbc_result($cur,47));
		if (substr($firma3,-2,2) == "Â»") $cc = -1;
		else $cc = 0;
		$reviso = explode("»",$firma3);
		if ($cc == -1) $n_reviso = substr($reviso[0],0,$cc);
		else $n_reviso = $reviso[0];
		$c_aprobo = "FIRMA SOLICITANTE";

		//----------- firma4 aprobó ------------
		$firma4 = trim(odbc_result($cur,48));
		if (substr($firma4,-2,2) == "Â»") $cc = -1;
		else $cc = 0;
		$aprobo = explode("»",$firma4);
		if ($cc == -1) $n_aprobo = substr($aprobo[0],0,-1);
		else $n_aprobo = $aprobo[0];
		$c_aprobo = "FIRMA SOLICITANTE";

		//----------- firma6 jem ------------
		$firma6 = trim(odbc_result($cur,50));
		if (substr($firma6,-2,2) == "Â»") $cc = -1;
		else $cc = 0;
		$jem = explode("»",$firma6);
		if ($cc == -1) $frm6 = substr($jem[0],0,$cc)."\n".substr($jem[1],0,$cc);
		else $frm6 = $jem[0]."\n".$jem[1];

		//----------- firma7 cdo ------------
		$firma7 = trim(odbc_result($cur,51));
		if (substr($firma7,-2,2) == "Â»") $cc = -1;
		else $cc = 0;
		$cdo = explode("»",$firma7);
		if ($cc == -1) $frm7 = substr($cdo[0],0,-1)."\n".substr($cdo[1],0,-1);
		else $frm7 = $cdo[0]."\n".$cdo[1];

		//Procesa informe -----------------------
		$pdf->SetFont('Arial','B',8);
		$pdf->Ln(-1);
		$pdf->Cell(190,5,'DE USO EXCLUSIVO',0,1,'R');
		$pdf->SetFont('Arial','',8);

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(27,5,'Ciudad',0,0,'');
		$pdf->Cell(81,5,$lugar,1,0,'');
		$pdf->Cell(15,5,'Fecha',1,0,'');
		$pdf->Cell(23,5,$fecha,0,0,'');
		$pdf->Cell(20,5,'Radicado',1,0,'L');
		$pdf->Cell(25,5,$consecu,L,1,'C');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(100,5,'Unidad/Dependencia/Sección de Inteligencia y Contrainteligencia solicitante',0,0,'');
		$pdf->Cell(91,5,$var_uni,L,1,'');

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(30,5,'Unidad centralizadora',0,0,'');

		if ($especial != 0)
		{
			$consulta_es = "select * from cx_org_sub where unidad = '".$especial."' and unic = '1'";
			$cur_es = odbc_exec($conexion,$consulta_es);
			$var_div = trim(odbc_result($cur_es,4));
		}	//if
		$pdf->Cell(18,5,$var_div,L,0,'');
		
		$pdf->Cell(17,5,'Brigada:',L,0,'');
		if (substr($var_dep,0,3) == 'DIV') $var_dep = substr($var_dep,0,3).substr($var_dep,-1);
		if ($var_div == $var_dep) $var_dep = "    ";
		if ($var_1 >= 4 and $var_1 <= 17 and $tipo_c == 6) $var_dep = "    ";
		$pdf->Cell(18,5,$var_dep,L,0,'');

		$pdf->Cell(17,5,'Batallón:',L,0,'');
		if (substr($var_uni,0,3) == 'DIV') $var_uni = substr($var_uni,0,3).substr($var_uni,-1);
		if ($var_div == $var_uni or $tipo_c == '5') $var_uni = "    ";
		if (substr($var_uni,0,2) == 'BR') $var_uni = "    ";
		if ($var_1 == 1 and $tipo_c == 2) $var_uni = "    ";
		if ($var_1 >= 4 and $var_1 <= 21 and ($tipo_c == 4 or $tipo_c == 6 or $tipo_c == 7 or $tipo_c == 9)) $var_uni = "    ";
		$pdf->Cell(18,5,$var_uni,L,0,'');
	
		$pdf->Cell(29,5,'Compañía/Sección',L,0,'');
		//if ($var_1 == 19 or $var_1 == 21) if ($tipo_c == 7 or $tipo_c == 9) $n_compania = $var_div;
		if ($var_1 == 21 and $tipo_c == 4 and $unic == 2) $n_compania = 'CENOR';
		$pdf->Cell(47,5,$n_compania,L,1,'');

		if ($tipo1 == "1")
		{
			$l_ordop = strlen($ordop);
			if ($l_ordop <= 55) $aa = 5;
			else $aa = (round($l_ordop/55)*5)+3;
			$actual=$pdf->GetY();
			$x = $pdf->Getx();
			$y = $pdf->Gety();
			$pdf->RoundedRect(9,$actual,192,$aa,0,'');
			$pdf->SetXY(9,$y);
			$pdf->Multicell(40,4,'ORDOP de Inteligencia/Ci No.',0,'L');
			$pdf->SetXY(49,$y);			
			$pdf->Multicell(89,4,utf8_decode($ordop),L,'L');
			$pdf->SetXY(138,$y);			
			$pdf->Multicell(30,$aa,'Misión de trabajo No.',L,'L');
			$pdf->SetXY(168,$y);			
			$pdf->Multicell(33,$aa,utf8_decode($misiones),L,'C');
		}

		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(30,5,'Concepto del gasto',0,0,'');
		$pdf->Cell(161,5,$tipo,L,1,'');
		$actual=$pdf->GetY();

		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(190,5,'1. JUSTIFICACIÓN DE LA NECESIDAD:',0,1,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,12,7,0,'');
		$pdf->RoundedRect(21,$actual,127,7,0,'');
		$pdf->RoundedRect(148,$actual,53,7,0,'');
		$pdf->Ln(1);
		$pdf->Cell(10,5,'ÍTEM',0,0,'C');
		$pdf->Cell(125,5,'CONCEPTO',0,0,'C');
		$pdf->Cell(55,5,'V/R SOLICITADO',0,1,'C');
		$pdf->Ln(2);

		if ($tipo1 == "1")
		{
			$consulta5 = "select * from cx_pla_gas where conse1='$conse' and ano = '$ano' order by interno";
			$cur5 = odbc_exec($conexion,$consulta5);
			$valort = 0;
			$valora = 0;
			$tvalorm = 0;
			$tvalora = 0;
			$i = 1;
			while($i<$row=odbc_fetch_array($cur5))
			{
				$mision1 = trim(odbc_result($cur5,5));
				$area1 = trim(odbc_result($cur5,6));
				$fecha1 = str_replace('/','-',trim(odbc_result($cur5,7)));
				$fecha2 = str_replace('/','-',trim(odbc_result($cur5,8)));
				$fecha1_1 = date_create($fecha1);
				$fecha2_2 = date_create($fecha2);
				$diff = date_diff($fecha1_1,$fecha2_2);
				$lapso = str_replace('days','días',$diff->format("%a days")) + 1;
				$oficiales1 = trim(odbc_result($cur5,9));
				$suboficiales1 = trim(odbc_result($cur5,10));
				$auxiliares1 = trim(odbc_result($cur5,11));
				$soldados1 = trim(odbc_result($cur5,12));
				$valorm = trim(odbc_result($cur5,13));
				$valorp = str_replace(',','',trim(odbc_result($cur5,13)));
				$valorp = substr($valorp,0,-3);
				$valort = $valort + $valorp;
				$valorv = str_replace(',','',trim(odbc_result($cur5,14)));
				$valora = $valora + $valorv;
		
				$estructura_mis = trim(odbc_result($cur5,17));
				$consulta_es = "select nombre from cx_ctr_est where codigo in (".$estructura_mis.")";
				$cur_es = odbc_exec($conexion,$consulta_es);
				$actividades1 = trim($row["actividades"]);
				$consulta16 = "select nombre from cx_ctr_act where codigo='$actividades1'";
				$cur16 = odbc_exec($conexion,$consulta16);
				$n_actividades1 = trim(odbc_result($cur16,1));
				
				$n_estructura_mis = "";
				//$i++;
				while($j<$row=odbc_fetch_array($cur_es))
				{
					$n_estructura_mis = $n_estructura_mis.trim(odbc_result($cur_es,1)).",";
					$j++;
				}   //while

				$var1 = "Misión: ".$mision1."\n";
				$var2 = "Area General: ".$area1."\n";
				$var3 = "Lapso: ".$lapso."  Días"."\n";
				$var4 = "Organización: ".$oficiales1." - ".$suboficiales1." - ".$soldados1." - ".$auxiliares1."\n";
				$var5 = "Conceptos del Gastos Solicitados"."\n";
				if ($fecha >= $fecha_ctr) $var6 = "Factor de Amenaza: ".$n_factor."   Estructura: ".$n_estructura_mis.", Blanco de alta retribución: ".$n_oms."\n";
				else $var6 = "Factor de Amenaza: ".$n_factor."   Estructura: ".$n_estructura.", Blanco de alta retribución: ".$n_oms."\n";
				$var7 = "Actividades: ".$n_actividades1."\n";

				$pdf->Ln(-1);
				$actual=$pdf->GetY();
				$pdf->Cell(11,5,$i,0,0,'C');
				$pdf->Multicell(127,5,$var1,LR,'L');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$var7,LR,'J');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$var6,LR,'J');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$var2,LR,1,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$var3,LR,1,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$var4,LR,1,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$var5,LR,1,'');

				$consulta3 = "select * from cx_pla_gad where conse1='$conse' and ano='$ano' and interno='$i'";
				$cur3 = odbc_exec($conexion,$consulta3);
				$total = odbc_num_rows($cur3);
				$j=1;

				while($j<$row=odbc_fetch_array($cur3))
				{
					$v_gasto = trim(odbc_result($cur3,5));
					if ($v_gasto == "99") $n_gasto = $v_otro;
					else
					{
						$consulta4 = "select nombre from cx_ctr_pag where codigo='$v_gasto'";
						$cur4 = odbc_exec($conexion,$consulta4);
						$n_gasto = trim(odbc_result($cur4,1));
					}   //if

					$v_otro = trim(odbc_result($cur3,6));
					$v_valor = "$ ".trim(odbc_result($cur3,7));

					$actual=$pdf->GetY();
					$pdf->Line(21,$actual,21,$actual+5);
					$pdf->Line(148,$actual,148,$actual+5);
					$pdf->Cell(12,5,'',0,0,'');
					$pdf->Cell(123,5,$j.". ".$n_gasto,0,0,'');
					$pdf->Cell(55,5,$v_valor,0,1,'R');
					$vlr1 = str_replace(',','',$v_valor);
					if ($t_bienes != "")
					{
						$pdf->Cell(11,5,'',0,0,'');
						$pdf->Multicell(127,5,$t_bienes,LR,1,'');
					}
					$j++;
				}   //while

				$pdf->Ln(-3);
				$actual=$pdf->GetY();
				$pdf->Line(21,$actual,21,$actual+5);
				$pdf->Line(148,$actual,148,$actual+5);
				$pdf->Cell(12,5,'',0,0,'');
				$pdf->Cell(123,5,'',0,0,'');
				$pdf->Cell(55,5,$linea1,0,1,'R');

				$actual=$pdf->GetY();
				$pdf->Line(21,$actual,21,$actual+5);
				$pdf->Line(148,$actual,148,$actual+5);
				$pdf->Cell(12,5,'',0,0,'');
				$pdf->Cell(123,5,'Suman:',0,0,'R');
				$pdf->Cell(55,5,'$ '.$valorm,0,1,'R');
				$pdf->Ln(-3);
				$pdf->Cell(190,5,$linea,0,1,'C');

				$valorm1 = str_replace(',','',$valorm);
				$tvalorm = $tvalorm + $valorm1;
				$tvalora = $valora;
				$i++;
			}   //while
		}
		else
		{
			$consulta6 = "select * from cx_pla_pag where conse='$conse' and ano='$ano'";
			$cur6 = odbc_exec($conexion,$consulta6);
			$valort = 0;
			$tvalorm = 0;
			$tvalora = 0;
			$k = 1;
			while($k<$row=odbc_fetch_array($cur6))
			{
				$ced_fuen = trim(odbc_result($cur6,4));
				if (strpos($ced_fuen, "K") !== false)
				{
				}
				else
				{
					$ced_fuen = "XXXX".substr($ced_fuen,-4);
				}
				$nom_fuen = trim(odbc_result($cur6,5));

				$fac_fuen = trim(odbc_result($cur6,6));
				$consulta7 = "select nombre from cx_ctr_fac where codigo='$fac_fuen'";
				$cur7 = odbc_exec($conexion,$consulta7);
				$n_factor = trim(odbc_result($cur7,1));

				$est_fuen = trim(odbc_result($cur6,7));
				$consulta8 = "select nombre from cx_ctr_est where codigo='$est_fuen'";
				$cur8 = odbc_exec($conexion,$consulta8);
				$n_estructura = trim(odbc_result($cur8,1));

				$fes_fuen = trim(odbc_result($cur6,8));
				$sin_fuen = trim(odbc_result($cur6,9));

				$dif_fuen = trim(odbc_result($cur6,10));
				$consulta9 = "select nombre from cx_ctr_dif where codigo='$dif_fuen'";
				$cur9 = odbc_exec($conexion,$consulta9);
				$n_difusion = trim(odbc_result($cur9,1));

				$din_fuen = trim(odbc_result($cur6,11));
				$fed_fuen = trim(odbc_result($cur6,12));
				$res_fuen = trim(odbc_result($cur6,13));
				$rad_fuen = trim(odbc_result($cur6,14));
				$fer_fuen = trim(odbc_result($cur6,15));
				$uti_fuen = trim(odbc_result($cur6,16));
				$rec_fuen = trim(odbc_result($cur6,24));
				$consulta9 = "select nombre from cx_ctr_dif where codigo='$rec_fuen'";
				$cur9 = odbc_exec($conexion,$consulta9);
				$n_recoleccion = trim(odbc_result($cur9,1));
				$ren_fuen = trim(odbc_result($cur6,25));
				$fec_rec = trim(odbc_result($cur6,26));
				$ord_fuen = trim(odbc_result($cur6,27));
				$bat_fuen = trim(odbc_result($cur6,28));
				$fec_ret = trim(odbc_result($cur6,29));

				$valorz = trim(odbc_result($cur6,17));
				$valorn = str_replace(',','',trim(odbc_result($cur6,17)));
				$valort = $valort+$valorn;
				$valorv = trim(odbc_result($cur6,18));

				if ($valorv == "") $valora = 0;
				else $valora = $valorv;

				$uni_fuen = odbc_result($cur6,19);
				$consulta10 = "select sigla from cx_org_sub where subdependencia='$uni_fuen'";
				$cur10 = odbc_exec($conexion,$consulta10);
				$n_unidad = trim(odbc_result($cur10,1));

				//Control para el cambio de sigla
				if ($sigla1 <> "") if ($fecha_pi >= $fecha_os) $n_unidad = $sigla1;

				$vap1 = "Fuente: ".$ced_fuen."\n";
				$vap2 = "Factor de Amenaza: ".$n_factor."   Estructura: ".$n_estructura."   Blanco de alta retribución: ".$n_oms."\n";
				$vap3 = "Fecha Suministro Información: ".$fes_fuen."\n";
				$vap4 = "Sintesis de la información: ".$sin_fuen."\n\n";
				$vap5 = "Difusión: ".$n_difusion."   Unidad / Dependencia: ".$n_unidad."   Nº ".$din_fuen."   Fecha: ".$fed_fuen."\n\n";
				if ($res_fuen == "2") $vap6 = "Condujo Resultado: NO"."\n\n";
				else $vap6 = "Condujo Resultado: SI   Reporte Radiograma: ".$rad_fuen."   Fecha: ".$fer_fuen." Ordop: ".$ord_fuen." Batallón: ".$bat_fuen." Fecha resultado: ".$fec_ret."\n\n";
				$vap7 = "Utilidad y Empleo de la Información: ".$uti_fuen;
				$vap8 =	"Recolección: ".$n_recoleccion."   Nº ".$ren_fuen."   Fecha: ".$fec_rec;

				$pdf->Ln(-1);
				$actual=$pdf->GetY();
				$pdf->Cell(11,5,$k,0,0,'C');
				$pdf->Multicell(127,5,$vap1,LR,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap2,LR,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap3,LR,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap4,LR,'J');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap8,LR,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap5,LR,'J');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap6,LR,'');
				$pdf->Cell(11,5,'',0,0,'');
				$pdf->Multicell(127,5,$vap7,LR,'J');
				$actual=$pdf->GetY();
				$pdf->Line(21,$actual,21,$actual+5);
				$pdf->Line(148,$actual,148,$actual+5);
				$pdf->Cell(12,5,'',0,0,'');
				$pdf->Cell(123,5,'Valor Solicitado:',0,0,'R');
				$pdf->Cell(55,5,wims_currency($valorn),0,1,'R');
				$pdf->Ln(-3);
				$pdf->Cell(190,5,$linea,0,1,'C');
				$pdf->Cell(12,5,'',0,0,'');
				$pdf->Cell(123,5,'Valor Autorizado:',0,0,'R');
				$pdf->Cell(55,5,$valora,0,1,'R');
				$pdf->Ln(-3);
				$pdf->Cell(190,5,$linea,0,1,'C');

				$valora1 = str_replace(',','',$valora);
				$tvalorm = $tvalorm + $valorn;
				$tvalora = $tvalora + $valora1;
				$k++;
			}   //while
		}   //if

		//Adquisición de bienes
		control_salto_pag($pdf->GetY(),0);
		$actual=$pdf->GetY();
		$pdf->Cell(190,4,$linea,0,1,'C');
		$pdf->Cell(50,5,'1.1 Adquisición de bienes devolutivos:',0,0,'');

		$consulta_g = "select * from cx_pla_gad where conse1='$conse' and gasto = '18' and ano='$ano'";
		$cur_g = odbc_exec($conexion,$consulta_g);
		$bienes =  trim(odbc_result($cur_g,9));

		if ($bienes <> "")
		{
			$pdf->Cell(6,5,'SI  ',0,0,'');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(1,5,'X',0,0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(9,5,'   NO  ',0,0,'');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(1,5,'-',0,1,'C');
			$pdf->SetFont('Arial','',8);
		}
		else
		{
			$pdf->Cell(6,5,'SI  ',0,0,'');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(1,5,'-',0,0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(9,5,'   NO  ',0,0,'');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(1,5,'X',0,1,'C');
			$pdf->SetFont('Arial','',8);
		}	//if

		if ($bienes == "") $t_bienes = "";
		else
		{
			$l_bienes = explode("#",$bienes);
			$nreg1 = count($l_bienes)-1;
			for ($i=0;$i<=$nreg1;++$i)
			{
				if ($i == 0) $codigo = explode("&",$l_bienes[$i]);
				if ($i == 1) $valor_t = explode("&",$l_bienes[$i]);
				if ($i == 2) $valor_n = explode("&",$l_bienes[$i]);
				if ($i == 3) $ttipo = explode("&",$l_bienes[$i]);
				if ($i == 4) $desc = explode("&",$l_bienes[$i]);
			}   //for
			$t_bienes = "";
			$nreg = count($codigo)-1;
			for ($i=0;$i<=$nreg-1;++$i)
			{
				$consulta_bie = "select * from cx_ctr_bie where codigo='".$codigo[$i]."'";
				$cur_bie = odbc_exec($conexion,$consulta_bie);
				$t_bienes = $t_bienes."- ".trim(odbc_result($cur_bie,3));
				$t_bienes = $t_bienes." - ".wims_currency($valor_n[$i]);
				$t_bienes = $t_bienes." ".$ttipo[$i];
				$t_justif = $t_justif."- ".$desc[$i];
				if ($i < count($codigo)-1)
				{
					$t_bienes = $t_bienes."\n\n";
					$t_justif = $t_justif."\n\n";
				}   //if
			}   //for
		}   //if
		$t_bienes = substr($t_bienes,0,-1);
		if ($t_bienes == "") $pdf->cell(192,5,$t_bienes,0,1,'L');
		else $pdf->Multicell(192,3,$t_bienes,'','L');
		$pdf->Cell(190,4,$linea,0,1,'C');

		//Justificación
		$pdf->Cell(50,5,'1.2 Justificación de su imprescindibilidad:',0,1,'');
		if ($t_justif == "") $pdf->Multicell(192,5,$t_justif,'','L');
		else $pdf->Multicell(192,3,$t_justif,'','L');
		$pdf->Ln(1);

		//Valor solicitado
		control_salto_pag($pdf->GetY(),0);
		$tvalorm = wims_currency(str_replace(',','',$tvalorm));
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(138,5,'Valor Solicitado:',0,0,'');
		$pdf->Cell(53,5,$tvalorm,L,1,'R');

		//Busca imagen de la firma solicitante
		$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_aprobo."'";
		$cur_fr = odbc_exec($conexion,$consulta_fr);
		if (odbc_num_rows($cur_fr) > 0)
		{
			$f_aprobo = trim(odbc_result($cur_fr,1));
			if ($f_aprobo != "")
			{
				$data = str_replace('data:image/png;base64,', '', $f_aprobo);
				$data = str_replace(' ', '+', $data);
				$data = base64_decode($data);
				$file = '../tmp/'.$n_usuario.'.png';
				$success = file_put_contents($file, $data);
				$tamano = getimagesize($file);
				//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
			}   //if
			else $file = '../tmp/firma_blanca.png';
		}
		else $file = '../tmp/firma_blanca.png';

		control_salto_pag($pdf->GetY(),0);
		$pdf->Ln(3);
		if ($ajuste > 0) $pdf->Ln($ajuste);
		$pdf->SetFont('Arial','',7);
		$actual=$pdf->GetY();
		$pdf->Ln(24);
		//$pdf->Image($file,91,$actual,$w,30);
		$pdf->Cell(190,4,'__________________________________________________',0,1,'C');
		$pdf->Cell(190,4,utf8_decode($n_aprobo),0,1,'C');
		$pdf->Cell(190,4,$c_aprobo,0,1,'C');
		$pdf->SetFont('Arial','',8);
		control_salto_pag($pdf->GetY(),0);

		//Autorización de pagos
		$pdf->Ln(1);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(190,5,'2. AUTORIZACIÓN DE PAGOS Y GASTOS',0,1,'L');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');		
		$pdf->Cell(138,5,'Valor Autorizado:',0,0,'');
		$pdf->Cell(53,5,wims_currency($tvalora),L,1,'R');
		$pdf->Cell(5,5,'',0,1,'');

		//Criterios de autorización
		control_salto_pag($pdf->GetY(),0);
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'DF');
		$pdf->Cell(190,5,'3. CRITERIOS DE AUTORIZACIÓN',0,1,'J');
		$pdf->Cell(5,5,'',0,1,'');
		
		$consulta_prev = "select * from cx_pla_rev where conse = '".$consecu."' and ano = '".$ano."' and estado <> 'Y' order by fecha DESC";
		$cur_prev = odbc_exec($conexion,$consulta_prev);
		$j=0;
		$motivo = "";
		$row=odbc_fetch_array($cur_prev);
		while($j<$row=odbc_fetch_array($cur_prev))
		{
			if ($row['motivo'] != "") $motivo = $motivo."\n".$row['motivo'];
			$j++;
		}
		$pdf->SetFont('Arial','',8);
		if ($motivo == "") $pdf->Multicell(192,5,$motivo,'','L');
		else $pdf->Multicell(192,5,$motivo,'','L');
		$pdf->Cell(190,4,$linea,0,1,'C');

		//Busca imagen de la firma JEM
		$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_jem."'";
		$cur_fr = odbc_exec($conexion,$consulta_fr);
		if (odbc_num_rows($cur_fr) > 0)
		{
			if ($f_aprobo != "")
			{
				$f_jem = trim(odbc_result($cur_fr,1));
				$n_usuario = trim(odbc_result($cur_fr,2));
				$data = str_replace('data:image/png;base64,', '', $f_jem);
				$data = str_replace(' ', '+', $data);
				$data = base64_decode($data);
				$file = '../tmp/'.$n_usuario.'.png';
				$success = file_put_contents($file, $data);
				$tamano = getimagesize($file);
				//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
			}   //if
			else $file = '../tmp/firma_blanca.png';
		}
		else $file = '../tmp/firma_blanca.png';

		//Busca imagen de la firma CDO
		$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_cdo."'";
		$cur_fr = odbc_exec($conexion,$consulta_fr);
		if (odbc_num_rows($cur_fr) > 0)
		{
			if ($f_aprobo != "")
			{
				$f_cdo = trim(odbc_result($cur_fr,1));
				$n_usuario = trim(odbc_result($cur_fr,2));
				$data = str_replace('data:image/png;base64,', '', $f_cdo);
				$data = str_replace(' ', '+', $data);
				$data = base64_decode($data);
				$file = '../tmp/'.$n_usuario.'.png';
				$success = file_put_contents($file, $data);
				$tamano = getimagesize($file);
				//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
			}   //if
			else $file = '../tmp/firma_blanca.png';
		}
		else $file = '../tmp/firma_blanca.png';
		//$pdf->Image($file,140,$actual,$w,30);

		control_salto_pag($pdf->GetY(),0);
		$actual=$pdf->GetY();
		$pdf->Ln(20);

		control_salto_pag($pdf->GetY(),1);
		$x = $pdf->Getx();
		$y = $pdf->Gety();
		$pdf->Multicell(92,4,$frm6,T,'C');
		$pdf->SetXY($x+92,$y);
		$pdf->Multicell(6,4,' ',0,'C');
		$pdf->SetXY($x+98,$y);
		$pdf->Multicell(92,4,$frm7,T,'C');
		$actual=$pdf->GetY();
		if (strlen($jem[1]) >= 90 or strlen($cdo[1]) >= 90) $pdf->Ln(6);
		else if (strlen($jem[1]) >= 40 or strlen($cdo[1]) >= 40) $pdf->Ln(6);
		else $pdf->Ln(2);
		$pdf->Cell(191,3,$linea,0,1,'C');		

		$pdf->Cell(191,5,'Anexos:',0,1,'');
		$dir = opendir ("../archivos/server/php/anexos/".$ano."/".$conse."/");
		while (false !== ($file = readdir($dir)))
		{
			if ((strpos($file, '.png',1)) or (strpos($file, '.gif',1)) or (strpos($file, '.jpg',1)) or (strpos($file, '.pdf',1)) or (strpos($file, '.doc',1)) or (strpos($file, '.docx',1)) or (strpos($file, '.xls',1)) or (strpos($file, '.xlsx',1)))
				$pdf->Cell(190,5,utf8_decode($file),0,1,'');
		}   //while

		control_salto_pag($pdf->GetY(),0);
		$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
		$pdf->Ln(2);
		$pdf->Multicell(191,3,$texto,TB,'J');
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,192,5,0,'');
		$pdf->Cell(15,5,'Elaboró:',0,0,'');
		$pdf->Cell(85,5,$n_elaboro,0,0,'');
		$pdf->Cell(15,5,'Revisó:',0,0,'');
		$pdf->Cell(76,5,$n_reviso,0,1,'');

		// Grabación de PDF
		if (($estado == "L") or ($estado == "W"))
		{
	  		$interno = str_pad($conse,5,"0",STR_PAD_LEFT);
	 		$archivo = $interno."_".$ano.".pdf";
			$nom_pdf = "../fpdf/pdf/".$ano."/".$archivo;
			$pdf->Output($nom_pdf,"F");
		}   //if
		// Fin grabación PDF
		$file = basename(tempnam(getcwd(),'tmp'));

		if ($cargar == "0") $pdf->Output();
		else $pdf->Output($file);
		echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";
	}
?>

