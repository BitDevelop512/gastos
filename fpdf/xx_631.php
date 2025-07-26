<?php
/* 631.php
   FO-JEMPP-CEDE2-631 - Informe Detallado por Comprobantes, Conceptos y Valores Ejecutados.
   (pág 234 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	- 08/09/2022 - Se adiciona el control para las demas cuentas - Consuelo Martínez.
	- 01/07/2023 - Se hace control del cambio de la sigla de la unidad. Jorge Clavijo.
	- 04/07/2023 - Ajuste unidad que ejecutó. Jorge clavijo.
	- 11/10/2023 - Para la unidad DIADI se hace una selección especial para incluir unicmante las unidades DIPEI, DICOO, DIPDA y DIADI. - Jorge Clavijo.
	- 26/10/2023 - Se hace ajuste para el nombre de la unidad para las divisiones en la columa UOM para que aparezca DIV0# y no DIV#. - Jorge Clavijo.
	- 31/01/2024 - Se hace ajuste para insertar un salto de página cuando las firmas queda al final de la hoja. - Jorge Clavijo.
	- 22/05/2024 - Se elimina la grabación del formato en PDF. - Jorge Clavijo 
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
						
			global $fecha_lb;
			
			//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
			$consulta_lb = "select * from cv_lib_ban where unidad = '".$uni_usuario."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and cuenta = '".$_GET['cuenta']."' order by fecha DESC";
			$cur_lb = odbc_exec($conexion,$consulta_lb);
			$fecha_lb = substr(odbc_result($cur_lb,2),0,10);

			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));

			if ($sigla1 <> "") if ($fecha_lb >= $fecha_os) $sigla = $sigla1;
			
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
			$this->Cell(87,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(116,5,'',0,0,'C');
			$this->Cell(12,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(116,5,'INFORME DETALLADO POR COMPROBANTES,',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-631',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(116,5,'CONCEPTOS Y VALORES EJECUTADOS',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'0',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(87,5,'DEPARTAMENTO DE INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(116,5,'',0,0,'C');			
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,5,'2017-05-16',0,1,'');

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

		function morepagestable($datas, $lineheight=4)
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
					$this->SetFont('Arial','',4.6);
					//ancho de columnas 5, 11, 9, 11, 11, 11, 12, 5, 18, 18, 18, 32, 110, 8
					if ($this->tablewidths[$col] == 112) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'L');
					elseif ($this->tablewidths[$col] == 18) $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,'R');
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
	$pdf->SetFont('Arial','',5.5);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);
	$linea = str_repeat("_",236);
		
	$n_recursos = array('10 CSF', '50 SSF', '16 SSF', 'OTROS');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA','ORDEN DE PAGO SIIF');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$ajuste = $_GET['ajuste'];

	function control_salto_pag($st, $actual1)
	{
		global $pdf;
		if ($st == 0) $pdf->addpage();   //firmas
		elseif ($st == 1 and $actual1 >= 192.00125) $pdf->addpage();  //normal
		else if ($actual1 >= 192.00125) $pdf->addpage(); //cuadro
	} //control_salto_pag

	//01/07/2023 - Se hace control del cambio de la sigla de la unidad. Jorge Clavijo.
	function verifica_sigla($v_sigla, $f_fecha_lb)
	{
		require('../conf.php');
		$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where sigla = '".$v_sigla."' or sigla1 = '".$v_sigla."'";
		$cur1 = odbc_exec($conexion,$consulta1);
		$sigla = trim(odbc_result($cur1,1));
		$sigla1 = trim(odbc_result($cur1,3));
		$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));
		if ($sigla1 <> "") if ($f_fecha_lb >= $fecha_os) $sigla = $sigla1;
		return $sigla;
	}   //verifica_sigla

	$consulta_sub = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
	$cur_sub = odbc_exec($conexion,$consulta_sub);
	$unidad  = trim(odbc_result($cur_sub,1));
	$dependencia = trim(odbc_result($cur_sub,2));
	$subdependencia = trim(odbc_result($cur_sub,3));
	$nom_unidad = $ut = verifica_sigla(trim(odbc_result($cur_sub,4)), $fecha_lb);
	$unic_unidad = trim(odbc_result($cur_sub,8));	
	$especial = trim(odbc_result($cur_sub,40));

	$bri = "";
	if ($unic_unidad <> 1)
	{
		$consulta_cv = "select * from cv_unidades where subdependencia = '".$subdependencia."'";
		$cur_cv = odbc_exec($conexion,$consulta_cv);
		$nom_unidad = $uom = verifica_sigla(trim(odbc_result($cur_cv,4)), $fecha_lb);
	}   //if
	else
	{
		$consulta_cv = "select * from cv_unidades where unidad = '".$unidad."' and subdependencia = '".$subdependencia."'";	
		$cur_cv = odbc_exec($conexion,$consulta_cv);
		if (strlen(trim(odbc_result($cur_cv,2))) < 5) $uom = verifica_sigla(trim(odbc_result($cur_cv,4)), $fecha_lb);
		else $uom = verifica_sigla(trim(odbc_result($cur_cv,2)), $fecha_lb);
	}   //if

	$actual=$pdf->GetY();
	$pdf->Cell(276,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Cell(40,5,'UNIDAD CENTRALIZADORA',0,0,'');	
	$pdf->Cell(46,5,$nom_unidad,B,1,'L');	
	$pdf->Cell(40,5,'PERIODO DEL INFORME DESDE',0,0,'');
	$pdf->Cell(15,5,'1',B,0,'C');	
	$pdf->Cell(25,5,'  HASTA',0,0,'C');	
	$pdf->Cell(25,5,days_in_month($_GET['periodo'], $_GET['ano']),B,0,'C');
	$pdf->Cell(30,5,' de '.$n_meses[$_GET['periodo'] - 1].' de '.$_GET['ano'],0,0,'L');

	if ($_GET['periodo'] == 1)
	{
		$periodo = 12;
		$ano = $_GET['ano'] - 1;
	}
	else
	{
		$periodo = $_GET['periodo'] - 1;
		$ano = $_GET['ano'];
	}   //if

	if ($_GET['cuenta'] == '1')
	{
		$consulta_saldo = "select saldo from cx_sal_uni where unidad = '".$uni_usuario."' and ano = '".$ano."' and periodo = '".$periodo."'";
		$cur_saldo = odbc_exec($conexion,$consulta_saldo);
		$saldo_ant = odbc_result($cur_saldo,1);		

		if ($uni_usuario == '1')
		{
			$consulta_cta = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
			$cur_cta = odbc_exec($conexion,$consulta_cta);
			$nom_cta = 'GASTOS';
			$cta = trim(odbc_result($cur_cta,11));
			$pdf->Cell(50,5,'CUENTA: ',0,0,'R');
			$pdf->Cell(40,5,$nom_cta.' - '.$cta,B,1,'C');
		}
		else $pdf->Cell(50,5,'',0,1,'R');
	}
	else
	{
		$consulta_cta = "select * from cx_ctr_cue where conse ='".$_GET['cuenta']."'";
		$cur_cta = odbc_exec($conexion,$consulta_cta);
		if (odbc_num_rows($cur_cta) != 0)
		{
			$nom_cta = trim(odbc_result($cur_cta,5));
			$cta = trim(odbc_result($cur_cta,6));
			$pdf->Cell(30,5,'CUENTA: ',0,0,'R');
			$pdf->Cell(40,5,$nom_cta.' - '.$cta,B,1,'C');
		}   //if
		else $pdf->Cell(20,5,$nom_cta.'',0,1,'C');
		
		$consulta_salc = "select * from cx_sal_cue where conse ='".$_GET['cuenta']."' and ano = '".$ano."' and periodo = '".$periodo."'";
		$cur_salc = odbc_exec($conexion,$consulta_salc);
		if (odbc_num_rows($cur_salc) == 0) $saldo_ant = 0;
		else $saldo_ant = odbc_result($cur_salc, 2);		
	}   //if

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual+6,279,6,0,'DF');
	$pdf->Ln(6);
	$pdf->Cell(4,6,'No',0,0,'C');
	$pdf->Cell(11,6,'U.O.M',1,0,'C');
	$pdf->Cell(9,6,'BR',1,0,'C');	
	$pdf->Cell(11,6,'U.T',1,0,'C');
	$pdf->Cell(11,3,'Unidad/Dep',0,0,'C');	
	$pdf->Cell(11,6,'Fecha',1,0,'C');
	$pdf->Cell(12,6,'Comprobante',1,0,'C');
	$pdf->Cell(5,6,'No.',6,0,'C');
	$pdf->Cell(18,6,'Valor Ingreso',1,0,'C');
	$pdf->Cell(18,6,'Valor Egreso',1,0,'C');
	$pdf->Cell(18,6,'Saldo',1,0,'C');
	$pdf->Cell(32,6,'Concepto del Gasto',1,0,'C');
	$pdf->Cell(110,6,'Soporte',1,0,'C');
	$pdf->Cell(8,6,'Recurso',1,0,'C');
	$pdf->Cell(2,3,'',0,1,'C');
	$pdf->Cell(81,3,'emp recurso',0,1,'C');
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(110,3,'SALDO ANTERIOR',0,0,'L');
	$pdf->Cell(18,3,wims_currency($saldo_ant),1,1,'R');

	$saldo = $saldo_ant;
	$lin=9;	
	$jj = 1;
	$v_ingreso = 0;
	$v_egreso = 0;
	$t_ingreso = 0;
	$t_egreso = 0;
	$t_saldo = 0;

	$consulta_libban = "select * from cv_lib_ban where unidad = '".$uni_usuario."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' and cuenta = '".$_GET['cuenta']."' order by fecha, comprobante, tipo1";
	$cur_libban = odbc_exec($conexion,$consulta_libban);
	$K = 1;
	while($k<$row=odbc_fetch_array($cur_libban))
	{	
		$n_comp = trim(odbc_result($cur_libban,1));
		$fecha_all = odbc_result($cur_libban,2);
		$fecha_lb = substr(odbc_result($cur_libban,2),0,10);
		$nom_concepto = ucwords(strtolower(trim(odbc_result($cur_libban,8))));
		$recurso = trim(odbc_result($cur_libban,16));
		$recurso = $n_recursos[$recurso-1];

		//Procesa los Ingresos, $tipo1 = 1
		if (trim(odbc_result($cur_libban,10)) == 1)
		{
			$consulta_soporte = "select * from cx_com_ing where ingreso = '".$n_comp."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_soporte = odbc_exec($conexion,$consulta_soporte);
			$k1 = 0;
			while($k1<$row=odbc_fetch_array($cur_soporte))
			{	
				$concepto = odbc_result($cur_soporte,10);
				$soporte = $n_soportes[odbc_result($cur_soporte,13)-1].' - '.trim(odbc_result($cur_soporte,14));
				$v_ingreso = substr(str_replace(',','',trim(odbc_result($cur_soporte,9))),0);
 
				if ($unic_unidad == 1)
				{
					$ut = "";
					$bri = "";
				}   //if

                //11/10/2023 - Para la unidad DIADI se hace una selección especial para incluir unicmante las unidades DIPEI, DICOO, DIPDA y DIADI. Jorge Clavijo.
				if ($nom_unidad == 'DIPEI' or $nom_unidad == 'DICOO' or $nom_unidad == 'DIPDA') $nom_unidad = 'CEDE2';

				//04/07/2023, Jorge clavijo ajuste unidad que ejecutó.
				if ($nom_unidad == 'DAVAA')
				{
					$nom_unidad = 'CONAT'; 
					$bri = ' ';
				}   //if

				$v_saldo = 0;
				$v_egreso = 0;
				$data[] = array($jj, $uom, $bri, $ut, $nom_unidad, $fecha_lb, 'INGRESO', $n_comp, $v_ingreso, $v_egreso, $v_saldo, $nom_concepto, trim($soporte), trim($recurso), $fecha_all);
				$k1++;
			}   //while
			$jj++;
		}

		//Procesa los Egresos, $tipo1 = 2
		else 
		{
			$consulta_soporte = "select * from cx_com_egr where egreso = '".$n_comp."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_soporte = odbc_exec($conexion,$consulta_soporte);
			$concepto = trim(odbc_result($cur_soporte,21));
			$tpgasto = trim(odbc_result($cur_soporte,22));
			$sop =  trim(odbc_result($cur_soporte,27));
			$n_sop =  trim(odbc_result($cur_soporte,28));

			switch ($tpgasto)
			{
			case 0:
				if ($concepto == '21') $nom_concepto = "  Impuesto";
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";				
				break;
			case 1:
				if ($concepto == '7') $nom_concepto = "  Reintegros DTN";
				if ($concepto == '8') $nom_concepto = "  Gastos en Actividades";
				if ($concepto == '9') $nom_concepto = "  Gastos en Actividades";  
				if ($concepto == '6') $nom_concepto = "  Pago de Impuestos";   
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";   
				break;
			case 2:
				if ($concepto == '7') $nom_concepto = "  Reintegros DTN";
				if ($concepto == '8') $nom_concepto = "  Pago de Informaciones";				
				if ($concepto == '9') $nom_concepto = "  Pago de Informaciones";  
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";   
				break;
			case 3:
				if ($concepto == '7') $nom_concepto = "  Reintegros DTN";
				if ($concepto == '10') $nom_concepto = "  Pago de Recompensas";
				if ($concepto == '18') $nom_concepto = "  Devoluciones CEDE2";   
				break;
			case 99:
				if ($concepto == '8') $nom_concepto = "  Presupuesto Mensual";
				if ($concepto == '9') $nom_concepto = "  Presupuesto Adicional";
				if ($concepto == '10') $nom_concepto = "  Presupuesto Recompensas";
				break;				
			}  //switch

			$datos = trim(decrypt1(odbc_result($cur_soporte,31), $llave));
			$d_datos = explode("#",$datos);
			$c = count($d_datos) - 1;
			$v_ingreso = 0;

 			for ($h = 0;$h < $c;$h++)
			{
				$d_datos1 = explode("|",$d_datos[$h]);
				$dep = trim($d_datos1[0]);
				$ut = "";
				$br = trim(odbc_result($cur_sub,4));

				$consulta_sub2 = "select * from cx_org_sub where sigla = '".$dep."' or sigla1 = '".$dep."'";
				$cur_sub2 = odbc_exec($conexion,$consulta_sub2);
				$c_unidad = trim(odbc_result($cur_sub2,1));
				$c_depen = trim(odbc_result($cur_sub2,2));
				$c_sdepen = trim(odbc_result($cur_sub2,3));
				$unic = trim(odbc_result($cur_sub2,8));
				$tipo = trim(odbc_result($cur_sub2,7));

				$consulta_uni = "select * from cv_unidades where subdependencia = '".$c_sdepen."'";
				$cur_uni = odbc_exec($conexion,$consulta_uni);
				$nom_uni_br1 = trim(odbc_result($cur_uni,2));

				//26/10/2023 - Se hace ajuste para el nombre de la unidad para las divisiones en la columa UOM para que aparezca DIV0# y no DIV#. Jorge Clavijo.
				if (substr($nom_uni_br1,0,3) == 'DIV' and substr($nom_uni_br1,3,1) <> '0') $nom_uni_br1 = substr($nom_uni_br1,0,3)."0".substr($nom_uni_br1,3,1);

				$consulta_br = "select top(1) * from cx_org_sub where dependencia = '".$c_depen."' and unic <> 0";
				$cur_br = odbc_exec($conexion,$consulta_br);
				$bbrr = trim(odbc_result($cur_br,4));

				if ($unic_unidad <> 1 and $bbrr <> $nom_uni_br1) $nom_uni_br1 = $bbrr;
				if ($bbrr == 'BRIMI1' || $bbrr == 'BRIMI2') $nom_uni_br1 = 'CAIMI';
				if ($bbrr == 'BRCIM1' || $bbrr == 'BRCIM2') $nom_uni_br1 = 'CACIM';
				if ($bbrr == $nom_uni_br1) $bbrr = "";			
				if ($nom_uni_br1 == 'CONAT' || $nom_uni_br1 == 'BRIAV33') $nom_uni_br1 = 'DAVAA';
				if ($nom_uni_br1 == 'CENOR') $nom_uni_br1 = 'DIV02';
		
				if ($tipo == 4 || $tipo == 6)
				{
					if ($bbrr <> "")
					{
						$nom_uni_br1 = $bbrr;
						$bbrr = "";
					}
					else
					{
						$nom_uni_br1 = $dep;
					}   //if
				}   //if

				switch ($unic)
				{
				case 0:
					if ($c_sdepen < 6) $utl = "";
					else $ut1 = verifica_sigla(trim($d_datos1[0]), $fecha_lb);
					$dep = trim($d_datos1[0]);
					break;
				case 1:
					$ut = verifica_sigla(trim($d_datos1[0]), $fecha_lb);
					$ut1 = "";
					if ($dep == 'CONAT') $nom_uni_br1 = 'DAVAA';
					if ($dep == 'CENOR') $nom_uni_br1 = 'DIV02';
					break;
				case 2:
					$bbrr = $dep;
					$ut1 = "";
					break;
				}  //switch

				$dep1 = verifica_sigla($dep, $fecha_lb);
				$consulta_iaut = "select * from cx_inf_aut where unidad1 = '".$c_sdepen."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
				$cur_iaut = odbc_exec($conexion,$consulta_iaut);
				$aut = trim(odbc_result($cur_iaut,1));

				$consulta_csop = "select * from cx_ctr_sop where conse = '".$sop."'";
				$cur_csop = odbc_exec($conexion,$consulta_csop);
				if ($sop == '12') $soporte = trim(odbc_result($cur_csop,2)).' - '.$aut;
				else $soporte = trim(odbc_result($cur_csop,2)).' - '.$n_sop;
				$v_egreso = substr(str_replace(',','',trim($d_datos1[1])),0);

				if ($v_ingreso <> 0 || $v_egreso <> 0)
				{
					$v_saldo = 0;
					$data[] = array($jj, $nom_uni_br1, $bbrr, $ut1, $dep1, $fecha_lb, 'EGRESO', $n_comp, $v_ingreso, $v_egreso, $v_saldo, $nom_concepto, trim($soporte), trim($recurso), $fecha_all);
					$jj++;
				}   //if
				$t_egreso = $t_egreso + $v_egreso;
				$v_egreso = 0; 
			}   //for
		}   //if
		$k++;
	}   //while

	//08/09/2022 - Se adiciona el control para las demas cuentas - Consuelo Martínez.
	$consulta_cm = "select * from cx_cue_mov where unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."' order by egreso";
	$cur_cm = odbc_exec($conexion,$consulta_cm); 

	$credito_cm = 0;
	$debito_cm = 0;
	$i = 0;
	while($i<=$row=odbc_fetch_array($cur_cm))
	{
		$fecha_all = odbc_result($cur_cm,2);
		$fecha_cm = substr(odbc_result($cur_cm,2),0,10);
		$unidad_cm = odbc_result($cur_cm,4);
		$comp_cm = trim(odbc_result($cur_cm,7));
		$cta_inicial_cm = odbc_result($cur_cm,9);
		$cta_final_cm = odbc_result($cur_cm,10);
		
		$consulta_vu = "select * from cv_unidades where subdependencia = '".$unidad_cm."'";
		$cur_vu = odbc_exec($conexion,$consulta_vu);
		$n_unidad_cm =  trim(odbc_result($cur_vu,6));

		if ($cta_inicial_cm == '3' and $cta_final_cm == '1') $credito_cm = trim(odbc_result($cur_cm,12));
		if ($_GET['cuenta'] == $cta_final_cm)
		{
			//Revisión hecha para arreglo del concepto y del periodo.
			$consulta_csop = "select soporte, (select nombre from cx_ctr_sop where cx_com_egr.soporte = cx_ctr_sop.conse) as nom_sopo from cx_com_egr where egreso = '".$comp_cm."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_csop = odbc_exec($conexion,$consulta_csop);
			$soporte = trim(odbc_result($cur_csop,2));

			$consulta_cg = "select * from cx_ctr_gas where codigo = (select concepto from cx_com_egr where unidad = '".$uni_usuario."' and egreso = '".$comp_cm."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."')";
			$cur_cg = odbc_exec($conexion,$consulta_cg);
			$conceptof = ucwords(strtolower(trim(odbc_result($cur_cg,2))));

			$consulta_ce = "select * from cx_com_egr where egreso = '".$comp_cm."' and unidad = '".$uni_usuario."' and ano = '".$_GET['ano']."' and periodo = '".$_GET['periodo']."'";
			$cur_ce = odbc_exec($conexion,$consulta_ce);
			$recurso = trim(odbc_result($cur_ce,23));
			$recurso = $n_recursos[$recurso-1];

			$data[] = array($jj, $n_unidad_cm, "", "", $n_unidad_cm, $fecha_cm, 'EGRESO', $comp_cm, $credito_cm, $debito_cm, $saldo_cm, $conceptof, $soporte, $recurso, $fecha_all);
			$saldo = $saldo_cm;
			$jj++;
		}   //if
		$i++;
	}   //while

	//Ordena por comprobante y calcula saldo
	for ($ax=0;$ax<=count($data)-1;$ax++) $aux[$ax] = $data[$ax][14];
	array_multisort($aux, SORT_ASC, $data);
	$saldo = $saldo_ant;
	$t_ingreso = 0;
	$t_egreso = 0;
	$t_saldo = $saldo;

	$pdf->tablewidths = array(5, 11, 9, 11, 11, 11, 12, 5, 18, 18, 18, 32, 110, 8);	
	for ($ax=0;$ax<=count($data)-1;$ax++)
	{
		$t_ingreso = $t_ingreso + $data[$ax][8];
		$t_egreso = $t_egreso + $data[$ax][9];
		$saldo =  $saldo + $data[$ax][8] - $data[$ax][9];
		$aax = $ax + 1;
		$data1[] = array($aax, $data[$ax][1], $data[$ax][2], $data[$ax][3], $data[$ax][4], $data[$ax][5], $data[$ax][6], $data[$ax][7], wims_currency($data[$ax][8]), wims_currency($data[$ax][9]), wims_currency($saldo), $data[$ax][11], $data[$ax][12], $data[$ax][13]);
		$pdf->morepagestable($data1);
		unset($data1);
		control_salto_pag(3, $act);	
	}   //for

	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,279,3,0,'DF');
	$pdf->Cell(74,3,'TOTALES',0,0,'R');		
	$pdf->Cell(18,3,wims_currency($t_ingreso),1,0,'R');
	$pdf->Cell(18,3,wims_currency($t_egreso),1,0,'R');
	$t_saldo = $saldo_ant + $t_ingreso - $t_egreso;
	$pdf->Cell(18,3,wims_currency($t_saldo),1,0,'R');
	$pdf->SetFont('Arial','',6);
	
	$n_ejecuto = utf8_decode(strtr(trim($_GET["firma1"]), $sustituye));
	$c_ejecuto = utf8_decode(strtr(trim($_GET["cargo1"]), $sustituye));
	$n_autorizo = utf8_decode(strtr(trim($_GET["firma2"]), $sustituye));
	$c_autorizo = utf8_decode(strtr(trim($_GET["cargo2"]), $sustituye));
	$n_VoBo = utf8_decode(strtr(trim($_GET["firma3"]), $sustituye));
	$c_VoBo = utf8_decode(strtr(trim($_GET["cargo3"]), $sustituye));
	
	//Busca imagen de la firma Ejecutó
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_ejecuto."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,45,$actual-20,$w,30),0,0,'C');

	//Busca imagen de la firma autorizó
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_autorizo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,135,$actual-20,$w,30),0,0,'C');

	//Busca imagen de la firma VoBo
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$n_VoBo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_ejecuto = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_ejecuto);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	$actual = $pdf->GetY();
	if ($tamaño[0] == 0) $w = 30;
	else $w =  ($tamaño[0]*30)/317;
	//$pdf->Cell(95,5,$pdf->Image($file,225,$actual-20,$w,30),0,0,'C');

	//25/10/2023 - Se pintan las firmas con multicell.
	if ($ajuste > 0) $pdf->Ln($ajuste);		
	$pdf->Ln(15);
	$pdf->Cell(90,13,'',0,1,'C');
	if ($pdf->GetY() >= 150.40125)
	{
		$pdf->addpage();
	}   //if
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	$pdf->SetXY($x,$y);
	$pdf->Multicell(3,4,"",0,'C');
	$pdf->SetXY($x+3,$y);
	$pdf->Multicell(87,4,$n_ejecuto."\n".$c_ejecuto,T,'C');
	$pdf->SetXY($x+90,$y);
	$pdf->Multicell(5,4,"",0,'C');
	$pdf->SetXY($x+95,$y);		
	$pdf->Multicell(87,4,$n_autorizo."\n".$c_autorizo,T,'C');
	$pdf->SetXY($x+182,$y);
	$pdf->Multicell(5,4,"",0,'C');
	$pdf->SetXY($x+187,$y);	
	$pdf->Multicell(87,4,$n_VoBo."\n".$c_VoBo,T,'C');
	
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Cell(278,3,$linea,0,1,'C');	
	$pdf->Multicell(278,3,$texto,0,'J');
	$pdf->Cell(278,3,$linea,0,1,'C');	
	$pdf->Cell(15,3,'Elaboró:    '.strtr(trim($nom_usuario), $sustituye),0,1,'');
	$pdf->Cell(278,3,$linea,0,1,'C');	

	//No activar
	//$nom_pdf = "../fpdf/pdf/Libros/".$_GET['ano']."/DetCom_".trim($sig_usuario)."_".$_GET['periodo']."_".$_GET['ano']."_".$_GET['cuenta'].".pdf";
	//$pdf->Output($nom_pdf,"F");

	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";	
}   //if
?>

