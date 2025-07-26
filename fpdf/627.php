<?php
/* 627.php
   FO-JEMPP-CEDE2-627 - Informe Consolidado de Ejecución Mensual de Gastos Reservados.
   (pág 227 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	- Se incluye la función desarrollada por Gilmar para la generación del informe.
	- SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	- 12/03/2024 Gilmar genera procedimiento para cambiar la manera de calcular el valor del PAC Mensual y se usa para el calculo del saldo. -Consuelo Martínez.
	- 19/07/2024 Se genera nota para las subdependencias que cambiaron de dependencia. Jorge Clavijo.
	- 03/12/2024 se ajustan firmas con un multicell. Angela Díaz.
	- 26/12/2024 Se retira la nota de cambio de unidad. Jorge Clavijo.
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
			$fe_ini = substr($_GET['fecha1'],0,4)."-".substr($_GET['fecha1'],5,2)."-".substr($_GET['fecha1'],8,2);
			$fe_fin = substr($_GET['fecha2'],0,4)."-".substr($_GET['fecha2'],5,2)."-".substr($_GET['fecha2'],8,2);
				
			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
			if ($sigla1 <> "") if ($fe_fin >= $fecha_os) $sigla = $sigla1;

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
			$this->Cell(205,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(75,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(130,5,'',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-627',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(86,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(119,5,'INFORME CONSOLIDADO DE EJECUCIÓN MENSUAL GASTOS RESERVADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(73,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(132,5,'',0,0,'C');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2018-07-10',0,1,'');

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
		}//RoundedRect

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
  			$h = $this->h;
  			$this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}//_Arc

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
					$this->SetFont('Arial','',4.8);		
					$this->SetXY($l,$h);
					if ($this->tablewidths[$col] == 20) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'L');
					else $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
		}//Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');

	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',7);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);

	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",269);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=192.00125) $pdf->addpage();
	} //control_salto_pag

	$consulta_uni = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'"; 
	$cur_uni = odbc_exec($conexion,$consulta_uni);
	$unidad = odbc_result($cur_uni,3);
	$sig_unidad = trim(odbc_result($cur_uni,4));
	$dependencia = odbc_result($cur_uni, 2);
	$n_unidadcen = strtr(trim(odbc_result($cur_uni,6)), $sustituye);
	$u_unic = trim(odbc_result($cur_uni,8));
	$n_eje = trim(odbc_result($cur_uni,13));
	$c_eje = trim(odbc_result($cur_uni,28));
	$n_jem = trim(odbc_result($cur_uni,14));
	$c_jem = trim(odbc_result($cur_uni,29));
	$n_cdo = trim(odbc_result($cur_uni,15));	
	$c_cdo = trim(odbc_result($cur_uni,30));	

	if ($unidad == '1') $cod_uni_eje = "SIIF NACION II (081)";
	else $cod_uni_eje = "N/A";
	$rubro = $n_rubros[2];
	$nom_rubro = "GASTOS RESERVADOS"; 
	if ($_GET['ajuste'] <> 0) $ajuste = $_GET['ajuste'];
	else $ajuste = 2;

	$ano = substr($_GET['fecha1'],0,4);	
	$periodo = substr($_GET['fecha1'],5,2);
	$periodo1 = substr($_GET['fecha2'],5,2);
	
	//fechas para generar informe 
	$fe_ini = substr($_GET['fecha1'],0,4).substr($_GET['fecha1'],5,2).substr($_GET['fecha1'],8,2);
	$fe_fin = substr($_GET['fecha2'],0,4).substr($_GET['fecha2'],5,2).substr($_GET['fecha2'],8,2);

	//Selecciona el tipo de recurso a filtrar.
	$recurso_d = $_GET['recurso'];
	if ($recurso_d == 4) $recurso_d = 0;
	if ($uni_usuario == 1)
	{
		if ($recurso_d == 0) $recu = " (Recurso: todos)";
		if ($recurso_d == 1) $recu = " (Recurso: 10 CSF)";
		if ($recurso_d == 2) $recu = " (Recurso: 50 CSF)";
		if ($recurso_d == 3) $recu = " (Recurso: 16 CSF)";
	}   //if

	if (substr($periodo,0,1) == '0') $periodo = substr($periodo,1,1);
	$dias_mes = cal_days_in_month(CAL_GREGORIAN, $periodo, $ano);
	$vigencia = "Del 01-".$n_meses[$periodo-1]."-".$ano." AL ".$dias_mes."-".$n_meses[$periodo1-1]."-".$ano;

	if ($periodo == 1)
	{
		$periodo = 12;
		$ano = $ano - 1;
	}
	else
	{
		$periodo = $periodo - 1;
		$ano = $ano;
	}   //if

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,46,5,0,'');
	$pdf->RoundedRect(55,$actual,100,5,0,'');
	$pdf->RoundedRect(9,$actual+5,46,5,0,'');
	$pdf->RoundedRect(55,$actual+5,100,5,0,'');
	$pdf->RoundedRect(9,$actual+10,46,5,0,'');
	$pdf->RoundedRect(55,$actual+10,100,5,0,'');
	$pdf->Cell(45,5,'NOMBRE UNIDAD EJECUTORA',0,0,'');
	$pdf->Cell(100,5,$n_unidadcen,0,0,'C');
	$pdf->Cell(130,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(45,5,'CÓDIGO UNIDAD EJECUTORA',0,0,'');
	$pdf->Cell(100,5,$cod_uni_eje,0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(28,5,'Rubro Presupuestal:',1,0,'');
	$pdf->Cell(35,5,$rubro,1,1,'L');
	$pdf->Cell(45,5,'VIGENCIA',0,0,'');
	$pdf->Cell(100,5,$vigencia,0,0,'C');
	$pdf->Cell(70,5,'',0,0,'C');
	$pdf->Cell(28,5,'Nombre Rubro:',1,0,'');
	$pdf->Cell(35,5,$nom_rubro,1,1,'L');
	$pdf->Cell(31,3,'',0,1,'');

	$pdf->SetFont('Arial','',5);
	$actual=$pdf->GetY();
	$pdf->Cell(9,3,'INFORMACIÓN PRESUPUESTAL',0,1,'');
	$lin = 9;
	for ($j = 1; $j <= 11; $j++)
	{
		$pdf->RoundedRect($lin,$actual+3,19,6,0,'DF');
		$lin = $lin + 19;
	}
	$pdf->Cell(18,3,'Apropiación',0,0,'C');
	$pdf->Cell(19,3,'Modificaciones',0,0,'C');
	$pdf->Cell(19,3,'Modificaciones',0,0,'C');
	$pdf->Cell(19,3,'Apropiación',0,0,'C');
	$pdf->Cell(19,3,'Valor',0,0,'C');
	$pdf->Cell(19,3,'Valor',0,0,'C');
	$pdf->Cell(19,3,'Valor Pagar',0,0,'C');
	$pdf->Cell(19,3,'Saldo Por',0,0,'C');
	$pdf->Cell(19,3,'Saldo por',0,0,'C');
	$pdf->Cell(19,3,'Saldo Por Pagar',0,0,'C');
	$pdf->Cell(19,3,'Total PAC',0,1,'C');
	$pdf->Cell(19,3,'Inicial',0,0,'C');
	$pdf->Cell(19,3,'Positivas',0,0,'C');
	$pdf->Cell(19,3,'Negativas',0,0,'C');
	$pdf->Cell(19,3,'Definitiva',0,0,'C');
	$pdf->Cell(19,3,'Compromisos',0,0,'C');
	$pdf->Cell(19,3,'Obligaciones',0,0,'C');
	$pdf->Cell(19,3,'',0,0,'C');
	$pdf->Cell(19,3,'Obligar',0,0,'C');
	$pdf->Cell(19,3,'Comprometer',0,0,'C');
	$pdf->Cell(19,3,'',0,0,'C');
	$pdf->Cell(19,3,'Autorizado',0,1,'C');

    if ($uni_usuario == '1')
    {
		//1. Apropiación inicial
		$pdf->RoundedRect(9,$actual+9,19,3,0,'');
		$ano_ai = substr($_GET['fecha1'],0,4);
		$consulta_ip = "select * from cx_apropia where ano = '".$ano_ai."' order by conse";
		$cur_ip = odbc_exec($conexion,$consulta_ip);
		$apro_ini = 0;
		$r = 0;
		while ($r<odbc_fetch_array($cur_ip))
		{
			$ai = substr(str_replace(',','',trim(odbc_result($cur_ip,3))),0);
			$apro_ini = $apro_ini + $ai;
			$r++;
		}  //while
		$pdf->Cell(18,3,wims_currency($apro_ini),0,0,'C');
		
		//2. Modificaciones positivas
		$consulta_ip = "select * from cx_apro_dis where tipo = 'A' order by conse";
		$cur_ip = odbc_exec($conexion,$consulta_ip);
		$modi_pos = 0;
		$r = 0;
		while ($r<odbc_fetch_array($cur_ip))
		{
			$modi_pos = $modi_pos + trim(odbc_result($cur_ip,5));
			$r++;
		}  //while
		$pdf->Cell(19,3,wims_currency($modi_pos),1,0,'C');
	
		//3. Modificaciones negativas
		$consulta_ip = "select * from cx_apro_dis where tipo = 'R' order by conse";
		$cur_ip = odbc_exec($conexion,$consulta_ip);
		$modi_neg = 0;
		$r = 0;
		while ($r<odbc_fetch_array($cur_ip))
		{
			$modi_neg = $modi_neg + trim(odbc_result($cur_ip,5));
			$r++;
		}  //while
		$pdf->Cell(19,3,wims_currency($modi_neg),1,0,'C');
	
		//4. Apropiación definitiva
		$apro_def = $apro_ini + $modi_pos - $modi_neg;
		$pdf->Cell(19,3,wims_currency($apro_def),1,0,'C');
	
		//5. Valor compromisos
		$consulta_ip = "select * from cx_crp where recurso = '1' order by conse";
		$cur_ip = odbc_exec($conexion,$consulta_ip);

		$ano_t = substr($_GET['fecha1'],0,4);
		$per_t = substr($_GET['fecha1'],5,2);
		if (substr($per_t,0,1) == '0') $per_t = substr($per_t,1,1);
		$vlr_com = 0;
		$r = 0;
		while ($r<odbc_fetch_array($cur_ip))
		{
			$fe_vc = trim(odbc_result($cur_ip,5));
			$ano_vc = substr($fe_vc,0,4);
			$per_vc = substr($fe_vc,5,2);
			if (substr($per_vc,0,1) == '0') $per_vc = substr($per_vc,1,1);
			if ($ano_vc == $ano_t and $per_vc <= $per_t) $vlr_com = $vlr_com + trim(odbc_result($cur_ip,10));
			$r++;
		}  //while
		$pdf->Cell(19,3,wims_currency($vlr_com),1,0,'C');
	
		//6. Valor obligaciones
		$vlr_obl = 0;   //no esta en la base el valor
		$pdf->Cell(19,3,wims_currency($vlr_obl),1,0,'C');
	
		//7. Valor pagar
		$vlr_pgr = $apro_def - $vlr_obl;
		$pdf->Cell(19,3,wims_currency($vlr_pgr),1,0,'C');	
	
		//8. Saldo por obligar
		$sal_obl = $apro_def - $vlr_obl;
		$pdf->Cell(19,3,wims_currency($sal_obl),1,0,'C');
	
		//9. Saldo por obligar comprometer
		$sal_oblc = $apro_def - $vlr_obl;
		$pdf->Cell(19,3,wims_currency($vlr_com),1,0,'C');
	
		//10. Saldo por pagar
		$sal_ppgr = $apro_def - $vlr_pgr;
		$pdf->Cell(19,3,wims_currency($sal_ppgr),1,0,'C');

		//11. Total PAC autorizado
		$tot_pac_aut = $vlr_com;
		$pdf->Cell(19,3,wims_currency($tot_pac_aut),1,0,'C');
	}
	else
	{
		$pdf->RoundedRect(9,$actual+9,19,3,0,'');
		$pdf->Cell(18,3,"N/A",0,0,'C');
		$pdf->Cell(19,3,"N/A",1,0,'C');
		$pdf->Cell(19,3,"N/A",1,0,'C');
		$pdf->Cell(19,3,"N/A",1,0,'C');
		$pdf->Cell(19,3,"N/A",1,0,'C');	
		$pdf->Cell(19,3,"N/A",1,0,'C');	
		$pdf->Cell(19,3,"N/A",1,0,'C');	
		$pdf->Cell(19,3,"N/A",1,0,'C');	
		$pdf->Cell(19,3,"N/A",1,0,'C');
		$pdf->Cell(19,3,"N/A",1,0,'C');	
		$pdf->Cell(19,3,"N/A",1,0,'C');
	}  //if
	$pdf->Cell(22,3,'',0,1,'C');
	$pdf->Ln(3);
	$pdf->RoundedRect(9,$actual+15,22,3,0,'');
	$pdf->Cell(21,3,'PAC MENSUAL',0,0,'');
	
	//Valor pac mensual
    if ($uni_usuario == '1') 
    {
		if ($recurso_d == 0) $consulta_ip = "select sum(valor1) as vlr from cx_crp where CONVERT(date,fecha1,102)>= '".$fe_ini."' and CONVERT(date,fecha1,102)<= '".$fe_fin."'";
		else $consulta_ip = "select sum(valor1) as vlr from cx_crp where recurso = '".$recurso_d."' and CONVERT(date,fecha1,102)>= '".$fe_ini."' and CONVERT(date,fecha1,102)<= '".$fe_fin."'";		
		$cur_ip = odbc_exec($conexion,$consulta_ip);
		$vlr_pac = odbc_result($cur_ip,1);
		$pdf->Cell(22,3,wims_currency($vlr_pac),1,1,'C');
	}
    else $pdf->Cell(22,3,"N/A",1,1,'C');

	$actual=$pdf->GetY();
	$pdf->Ln(4);
	$pdf->Cell(140,3,'INFORMACIÓN DE EJECUCIÓN MENSUAL'.$recu,0,0,'');
	for ($j = 1; $j <= 8; $j++)
	{
		if ($j == 8) $pdf->Cell(19,3,'('.$j.')',1,0,'C');
		else $pdf->Cell(17,3,'('.$j.')',1,0,'C');
	}   //if
	
	$pdf->Cell(1,3,'',0,1,'');

	$pdf->RoundedRect(9,$actual+7,20,12,0,'DF');
	$lin = 29;
	for ($j = 1; $j <= 15; $j++)
	{
		if ($j == 7 or $j == 15)
		{
			$pdf->RoundedRect($lin,$actual+7,19,12,0,'DF'); 
			$lin = $lin + 19;		
		}
		else
		{
			$pdf->RoundedRect($lin,$actual+7,17,12,0,'DF');
			$lin = $lin + 17;
		}
	}  //if
	
	$pdf->SetFont('Arial','',4.8);
	$pdf->Cell(19,3,'UNIDAD',0,0,'C');
	$pdf->Cell(17,3,'SALDO',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'REINTEGROS',0,0,'C');
	$pdf->Cell(17,3,'TRANSFERENCIAS',0,0,'C');
	$pdf->Cell(19,3,'DISPONIBILIDAD',0,0,'C');
	$pdf->Cell(17,3,'GASTOS EN',0,0,'C');
	$pdf->Cell(17,3,'PAGO',0,0,'C');
	$pdf->Cell(17,3,'PAGO',0,0,'C');
	$pdf->Cell(17,3,'GASTOS DE',0,0,'C');
	$pdf->Cell(17,3,'GASTOS DE',0,0,'C');
	$pdf->Cell(17,3,'DEVOLUCIONES',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(19,3,'',0,1,'C');
	$pdf->Cell(19,3,'EJECUTORA Y',0,0,'C');
	$pdf->Cell(17,3,'ANTERIOR',0,0,'C');
	$pdf->Cell(17,3,'PRESUPUESTO',0,0,'C');
	$pdf->Cell(17,3,'PRESUPUESTO',0,0,'C');
	$pdf->Cell(17,3,'PRESUPUESTO',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'NETAS A UNIDADES',0,0,'C');
	$pdf->Cell(19,3,'EJECUTAR',0,0,'C'); 
	$pdf->Cell(17,3,'ACTIVIDADES DE',0,0,'C');
	$pdf->Cell(17,3,'INFORMACIONES',0,0,'C');
	$pdf->Cell(17,3,'RECOMPENSAS',0,0,'C');
	$pdf->Cell(17,3,'PROTECCIÓN',0,0,'C');
	$pdf->Cell(17,3,'COBERTURA',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C'); 
	$pdf->Cell(17,3,'EJECUTADO',0,0,'C');
	$pdf->Cell(19,3,'SALDO',0,1,'C'); 
	$pdf->Cell(19,3,'SUBORDINADA',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'MENSUAL',0,0,'C');
	$pdf->Cell(17,3,'ADICIONAL',0,0,'C');
	$pdf->Cell(17,3,'RECOMPENSAS',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'SUBORDINADAS',0,0,'C');
	$pdf->Cell(19,3,'',0,0,'C'); 
	$pdf->Cell(17,3,'INTELIGENCIA Y',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(19,3,'',0,1,'C'); 
	$pdf->Cell(19,3,'INTELIGENCIA',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(19,3,'',0,0,'C');
	$pdf->Cell(17,3,'CONTRANTE.',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(19,3,'',0,1,'C');

	$tot_sal_ant = 0;
	$tot_pre_men = 0;
	$tot_pre_adi = 0;
	$tot_pre_rec = 0;
	$tot_rei_ced = 0;
	$tot_tra_uni = 0;
	$tot_dip_eje = 0;
	$tot_gas_aic = 0;
	$tot_pag_inf = 0;
	$tot_pag_rec = 0;	
	$tot_gas_pro = 0;
	$tot_gas_cob = 0;
	$tot_dev_cede2 = 0;	
	$tot_gas_eje = 0;
	$tot_sal = 0;
	$n_egr = 0;

	//Procesa reporte
	if ($uni_usuario > 1 ) $consulta = "select * from dbo.cf_rep_A627('".$fe_ini."','".$fe_fin."',$uni_usuario,$recurso_d) order by  ord_regi";
	else $consulta = "select * from dbo.cf_rep_X627('".$fe_ini."','".$fe_fin."',$uni_usuario,$recurso_d) order by  ord_regi";
	$cur = odbc_exec($conexion,$consulta);
	$nr = odbc_num_rows($cur);
	$u=0;
	$tot = array(16);
	$tot[0] = "TOTALES"; 
	$pdf->tablewidths = array(20, 17, 17, 17, 17, 17, 17, 19, 17, 17, 17, 17, 17, 17, 17, 19); 
	while($u<odbc_fetch_array($cur))
	{
		$data[] = array(odbc_result($cur,2), wims_currency(odbc_result($cur,3)), wims_currency(odbc_result($cur,4)), wims_currency(odbc_result($cur,5)),wims_currency(odbc_result($cur,6)), 
			wims_currency(odbc_result($cur,7)), wims_currency(odbc_result($cur,8)), wims_currency(odbc_result($cur,9)), wims_currency(odbc_result($cur,10)), 
			wims_currency(odbc_result($cur,11)), wims_currency(odbc_result($cur,12)), wims_currency(odbc_result($cur,13)), wims_currency(odbc_result($cur,14)), 
			wims_currency(odbc_result($cur,15)), wims_currency(odbc_result($cur,16)), wims_currency(odbc_result($cur,17)));
			
		//Acumula totales por columna
		for ($i=1;$i<=15;$i++) $tot[$i] = $tot[$i] + odbc_result($cur,$i+2);
		$actual=$pdf->GetY();
		$pdf->morepagestable($data);
		control_salto_pag($pdf->GetY()); 
		unset($data);
		
		//19/07/2024 Se genera nota para las subdependencias que cambiaron de dependencia. Jorge Clavijo.
		if (odbc_result($cur,22) > 0) $cambia[$u] = array(trim(odbc_result($cur,2)));

		$u++;
	}   //while

	//Pinta totales
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,279,3,0,'DF');
	$pdf->Cell(19,3,$tot[0],0,0,'R');

	for ($i=1;$i<=15;$i++)
	{
		if ($i == 7 or $i == 15) $pdf->Cell(19,3,wims_currency($tot[$i]),1,0,'R');
		else $pdf->Cell(17,3,wims_currency($tot[$i]),1,0,'R');
	}   //for
	$pdf->Cell(2,3,'',0,1,'R');

	//Pinta nota para las subdependencias que cambiaron de dependencia.
	$pdf->SetFont('Arial','',6);
	$uni_cam = "";
	//$nota_cam = "Cambió de unidad, de allí la variación en los saldos en la unidad a la que pertenecieron....";
	for ($iu=0;$iu<=$u;$iu++) if (strlen($cambia[$iu][0]) > 0) $uni_cam = $uni_cam.$cambia[$iu][0].", ";
	$uni_cam = substr($uni_cam,0,-1);

	control_salto_pag($pdf->GetY()); 
	$pdf->Ln(2);
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->SetXY($x-1,$y);
	$pdf->Multicell(279,5,"Nota: ".$uni_cam." ".$nota_cam,TB,'L');

	//Firmas según unidad
	control_salto_pag($pdf->GetY()); 
	$ususig = substr($sig_usuario,0,2);
	if ($ususig == 'DI')
	{
		$sigla1 = strtr(trim($sig_usuario), $sustituye_sig);  
		$eje = "OD2_".$sigla1;
		$jem = "JEM_".$sigla1;
		$cdo = "CDO_".$sigla1;
	}
	elseif ($ususig == 'BR')
	{
		$sigla1 = strtr(trim($sig_usuario), $sustituye_sig);  
		$eje = "OB4_".$sigla1;
		$jem = "JEM_".$sigla1;
		$cdo = "CDO_".$sigla1;
	}	
	else
    {
		if ($sig_usuario == 'CEDE2') $eje = "OPD_DIADI";
		if ($sig_usuario == 'CACIM' || $sig_usuario == 'CAIMI') $eje = "OC8_".$sig_usuario;
		if ($sig_usuario == 'FUDRA2') $eje = "OF2_".$sig_usuario;
		if ($sig_usuario == 'CEO' || $sig_usuario == 'CEC') $eje = "OC2_".$sig_usuario;
		$jem = "JEM_".$sig_usuario;
		$cdo = "CDO_".$sig_usuario;
	}  //if

	$pdf->Cell(2,3,'',0,1,'R');
	control_salto_pag($pdf->GetY()); 
	if ($ajuste > 0) $pdf->Ln(16 + $ajuste);
	$actual=$pdf->GetY();

	$pdf->Cell(93,3,'_____________________________________________',0,0,'C');
	$pdf->Cell(93,3,'_____________________________________________',0,0,'C');
	$pdf->Cell(93,3,'_____________________________________________',0,1,'C');	
	$pdf->Cell(93,4,$n_eje,0,0,'C');
	$pdf->Cell(93,4,$n_jem,0,0,'C');
	$pdf->Cell(92,4,$n_cdo,0,1,'C');
	$pdf->Cell(20,4,'',0,0,'C');
	$pdf->Cell(53,4,$c_eje,0,0,'C');
	$pdf->Cell(40,4,'',0,0,'C');
	$pdf->Cell(53,4,$c_jem,0,0,'C');
	$pdf->Cell(40,4,'',0,0,'C');
	$pdf->Cell(53,4,$c_cdo,0,1,'C');
/*
	//03/12/2024 se ajustan firmas con un multicell. Angela Díaz.
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);
	$pdf->Multicell(3,4,"",0,'C');
	$pdf->SetXY($x+3,$y);
	$pdf->Multicell(87,4,$n_eje."\n".$c_eje,T,'C');
	$pdf->SetXY($x+90,$y);
	$pdf->Multicell(5,4,"",0,'C');
	$pdf->SetXY($x+95,$y);		
	$pdf->Multicell(87,4,$n_jem."\n".$c_jem,T,'C');
	$pdf->SetXY($x+182,$y);
	$pdf->Multicell(5,4,"",0,'C');
	$pdf->SetXY($x+187,$y);	
	$pdf->Multicell(87,4,$n_cdo."\n".$c_cdo,T,'C');
*/
	control_salto_pag($pdf->GetY()); 
	$pdf->SetFont('Arial','',5.3);
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(2);
	$pdf->Cell(277,4,$linea,0,1,'C');	
	$pdf->Multicell(278,3,$texto,0,'J');
	$actual=$pdf->GetY();
	$pdf->SetFont('Arial','',6);	
	$pdf->RoundedRect(9,$actual,279,5,0,'');
	$pdf->Cell(15,5,'Elaboró:',0,0,'');
	$pdf->Cell(30,5,strtr(trim(utf8_decode($nom_usuario)), $sustituye),0,1,'L'); 

	$nom_pdf  = "../fpdf/pdf/InfConEje_".$sig_usuario." _".substr($_GET['fecha1'],5,2)." _".$ano.".pdf";
	$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}  //if
?>

