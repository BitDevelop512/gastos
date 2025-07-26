<?php
/* 627.php
   FO-JEMPP-CEDE2-627 - Informe Consolidado de Ejecución Mensual de Gastos Reservados.
   (pág 227 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	Se incluye la función desarrollada por Gilmar para la generación del informe.
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
			$consulta1= "select sigla,nombre from cx_org_sub where subdependencia='".$_SESSION["uni_usuario"]."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = odbc_result($cur1,1);
			$sig_usuario = $sigla;

			$this->SetFont('Arial','B',120);
			$this->SetTextColor(214,219,223);
			$this->RotatedText(95,175,$sig_usuario,35);			

			$this->SetFont('Arial','B',8);
			$this->SetTextColor(255,150,150);
			$this->Cell(550,5,'SECRETO',0,1,'C');
			$this->Ln(2);

			$this->Image('sigar.png',10,17,17);
			$this->SetFont('Arial','B',8);
			$this->SetTextColor(0,0,0);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(475,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(388,5,'',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-627x30',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(388,5,'INFORME CONSOLIDADO DE EJECUCIÓN MENSUAL GASTOS RESERVADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(388,5,'',0,0,'C');
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
			$this->RoundedRect(114,15,388,26,0,'');
			$this->RoundedRect(502,15,58,26,0,'');
			$this->RoundedRect(9,15,551,183,0,'');

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
  			$this->SetY(-10);
  			$this->SetFont('Arial','',7);
  			$this->Cell(190,4,'SIGAR - '.$fecha1,0,1,'');
  			$this->Ln(-4);
  			$this->SetFont('Arial','B',8);
  			$this->SetTextColor(255,150,150);
  			$this->Cell(550,5,'SECRETO',0,1,'C');
  			$this->SetTextColor(0,0,0);
  			$cod_bar='SIGAR';
   			$this->Code39(540,200,$cod_bar,.5,5);
		}//function Footer()
	}//class PDF extends PDF_Rotate

	require('../conf.php');
	require('../permisos.php');
	require('../funciones.php');
	require('../numerotoletras2.php');

	$pdf=new PDF('L','mm', array(226,572));
	$pdf->AliasNbPages();
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);

	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$n_rubros = array('204-20-1', '204-20-2', 'A-02-02-04');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",561);

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=172.00125) $pdf->addpage();
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
	$pdf->Cell(400,5,'DE USO EXCLUSIVO',0,1,'R');
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

	$pdf->SetFont('Arial','',6);
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

    $pdf->SetFont('Arial','',5);
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
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(22,3,'',0,1,'C');
	$pdf->Ln(3);
	$pdf->RoundedRect(9,$actual+15,22,3,0,'');
	$pdf->Cell(21,3,'PAC MENSUAL',0,0,'');
	
	//Valor pac mensual
    if ($uni_usuario == '1') 
    {
		$consulta_ip = "select * from cx_crp where recurso = '1' order by conse";
		$cur_ip = odbc_exec($conexion,$consulta_ip);

		$ano_t = substr($_GET['fecha1'],0,4);
		$per_t = substr($_GET['fecha1'],5,2);
		if (substr($per_t,0,1) == '0') $per_t = substr($per_t,1,1);
		$vlr_pac = 0;
		$r = 0;
		while ($r<odbc_fetch_array($cur_ip))
		{
			$fe_vc = trim(odbc_result($cur_ip,5));
			$ano_vc = substr($fe_vc,0,4);
			$per_vc = substr($fe_vc,5,2);
			if (substr($per_vc,0,1) == '0') $per_vc = substr($per_vc,1,1);
			if ($ano_vc == $ano_t and $per_vc == $per_t) $vlr_pac = $vlr_pac + trim(odbc_result($cur_ip,10));
			$r++;
		}  //while
		$pdf->Cell(22,3,wims_currency($vlr_pac),1,1,'C');
	}
    else
    {
		$pdf->Cell(22,3,"N/A",1,1,'C');
	}   //if

	$actual=$pdf->GetY();
	$pdf->Ln(4);

	$pdf->Cell(142,3,'INFORMACIÓN DE EJECUCIÓN MENSUAL'.$recu,0,0,'');
	for ($j = 1; $j <= 8; $j++)
	{
		$pdf->Cell(17,3,'('.$j.')',1,0,'C');
	}
	$pdf->Cell(1,3,'',0,1,'');

	$pdf->RoundedRect(9,$actual+7,24,12,0,'DF');
	$lin = 33;
	for ($j = 1; $j <= 31; $j++)
	{
		$pdf->RoundedRect($lin,$actual+7,17,12,0,'DF');
		$lin = $lin + 17;
	}
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(23,3,'UNIDAD',0,0,'C');
	$pdf->Cell(17,3,'SALDO',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'REINTEGROS',0,0,'C');
	$pdf->Cell(17,3,'TRANSFERENCIAS',0,0,'C');
	$pdf->Cell(17,3,'DISPONIBILIDAD',0,0,'C');
	$pdf->Cell(17,3,'GASTOS EN',0,0,'C');
	$pdf->Cell(17,3,'PAGO',0,0,'C');
	$pdf->Cell(17,3,'PAGO',0,0,'C');
	$pdf->Cell(17,3,'GASTOS DE',0,0,'C');
	$pdf->Cell(17,3,'GASTOS DE',0,0,'C');
	$pdf->Cell(17,3,'DEVOLUCIONES',0,0,'C');
	$pdf->Cell(17,3,'TOTAL',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,1,'C');
	
	$pdf->Cell(23,3,'EJECUTORA Y',0,0,'C');
	$pdf->Cell(17,3,'ANTERIOR',0,0,'C');
	$pdf->Cell(17,3,'PRESUPUESTO',0,0,'C');
	$pdf->Cell(17,3,'PRESUPUESTO',0,0,'C');
	$pdf->Cell(17,3,'PRESUPUESTO',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'NETAS A UNIDADES',0,0,'C');
	$pdf->Cell(17,3,'EJECUTAR',0,0,'C');
	$pdf->Cell(17,3,'ACTIVIDADES DE',0,0,'C');
	$pdf->Cell(17,3,'INFORMACIONES',0,0,'C');
	$pdf->Cell(17,3,'RECOMPENSAS',0,0,'C');
	$pdf->Cell(17,3,'PROTECCIÓN',0,0,'C');
	$pdf->Cell(17,3,'COBERTURA',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C'); 
	$pdf->Cell(17,3,'EJECUTADO',0,0,'C');
	$pdf->Cell(17,3,'SALDO',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,1,'C');
	
	$pdf->Cell(23,3,'SUBORDINADA',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'MENSUAL',0,0,'C');
	$pdf->Cell(17,3,'ADICIONAL',0,0,'C');
	$pdf->Cell(17,3,'RECOMPENSAS',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'SUBORDINADAS',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'INTELIGENCIA Y',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,1,'C');	
	
	$pdf->Cell(23,3,'INTELIGENCIA',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'CONTRANTE.',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,0,'C');
	$pdf->Cell(17,3,'',0,1,'C');	

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
	$d_datos = array(40);

	//Procesa reporte
	$consulta = "select * from dbo.cf_rep_1627('".$fe_ini."','".$fe_fin."',$uni_usuario,$recurso_d) order by  ord_regi";
	$cur = odbc_exec($conexion,$consulta);
	$nr = odbc_num_rows($cur);
	$u=0;
	$tot = array(30);
	$tot[0] = "TOTALES"; 
	while($u<odbc_fetch_array($cur))
	{
		$actual=$pdf->GetY();
		$pdf->RoundedRect(9,$actual,24,3,0,'');
		$pdf->Cell(23,3,odbc_result($cur,2));  						  //sigla uni	(0)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,3)),1,0,'R');  //saldo_ant	(1)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,4)),1,0,'R');  //pre_men		(2)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,5)),1,0,'R');  //pre_adi		(3)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,6)),1,0,'R');  //pre_prec	(4)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,7)),1,0,'R');  //rei_ced		(5)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,8)),1,0,'R');  //tra_uni		(6)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,9)),1,0,'R');  //dip_eje		(7)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,10)),1,0,'R'); //gas_aic		(8)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,11)),1,0,'R'); //gas_inf		(9)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,12)),1,0,'R'); //pag_rec		(10)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,13)),1,0,'R'); //gas_pro		(11)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,14)),1,0,'R'); //gas_cob		(12)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,15)),1,0,'R'); //dev_uni		(13)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,16)),1,0,'R'); //sal_eje		(14)
		$pdf->Cell(17,3,wims_currency(odbc_result($cur,17)),1,0,'R'); //saldo 		(15)		
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(16)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(17)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(18)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(19)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(20)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(21)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(22)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(23)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(24)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(25)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(26)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(27)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(28)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(29)				
		$pdf->Cell(17,3,wims_currency(0),1,0,'R');                    //disponible 		(30)				
		$pdf->Cell(17,3,wims_currency(0),1,1,'R');                    //disponible 		(32)		
		
		//Acumula totales por columna
		for ($i=1;$i<=31;$i++)
		{
			$tot[$i] = $tot[$i] + odbc_result($cur,$i+2);
		}   //for
		$u++;
	}   //while

	//Pinta totales
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,551,3,0,'DF');
	$pdf->Cell(23,3,$tot[0],0,0,'R');

	for ($i=1;$i<=31;$i++)
	{
		$pdf->Cell(17,3,wims_currency($tot[$i]),1,0,'R');
	}   //for
	$pdf->Cell(2,3,'',0,1,'R');

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

	//Busca imagen de la firma Ejecutó
	//$n_eje = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_eje."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_eje = trim(odbc_result($cur_fr,1));
		$usuario_fr = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_eje);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$usuario_fr.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$pdf->Ln(2);
	$pdf->Image($file,46,$actual-20,30,30);

	//Busca imagen de la firma JEM
	//$n_jem = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_jem."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_jem = trim(odbc_result($cur_fr,1));
		$usuario_fr = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_jem);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$usuario_fr.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$pdf->Ln(2);
	$pdf->Image($file,130,$actual-20,30,30);

	//Busca imagen de la firma CDO
	//$n_cdo = "JAIME ALBERTO MORALES (CX)";
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_cdo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_cdo = trim(odbc_result($cur_fr,1));
		$usuario_fr = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_cdo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$usuario_fr.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$pdf->Ln(2);
	$pdf->Image($file,224,$actual-20,30,30);

	$pdf->Cell(184,3,'_____________________________________________',0,0,'C');
	$pdf->Cell(184,3,'_____________________________________________',0,0,'C');
	$pdf->Cell(184,3,'_____________________________________________',0,1,'C');	
	$pdf->Cell(184,4,$n_eje,0,0,'C');
	$pdf->Cell(184,4,$n_jem,0,0,'C');
	$pdf->Cell(184,4,$n_cdo,0,1,'C');
	$pdf->Cell(184,4,$c_eje,0,0,'C');
	$pdf->Cell(184,4,$c_jem,0,0,'C');
	$pdf->Cell(184,4,$c_cdo,0,1,'C');
	
	control_salto_pag($pdf->GetY()); 
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Ln(2);
	$pdf->Cell(550,4,$linea,0,1,'C');	
	$pdf->Multicell(551,3,$texto,0,'J');
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,551,5,0,'');
	$pdf->Cell(15,5,'Elaboró:',0,0,'');
	$pdf->Cell(30,5,strtr(trim($nom_usuario), $sustituye),0,1,'L'); 

	$file=basename(tempnam(getcwd(),'tmp'));
	$pdf->Output();
	//$pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}  //if
?>
