<?php
/* 628.php
   FO-JEMPP-CEDE2-628-1 - Informe Control de Erogaciones Causadas en ORDOP o Misiones de Trabajo de Inteligencia y Contrainteligencia.
   (pág 255 - "Dirtectiva Permanente No. 00095 de 2017.PDF")

	- MODIFICACIONES
		+ Sgto. Duran, el informe 628.php es muy extenso y se consolido.
	- OBSERVACIONES
		+ Resume por periódo todo el plan de gastos.
		+ El PDF imprimible solo visualizará el total de la sumatoria de las misiones dispuestas en cada unidad.
		+ Cada BATALLÓN, BRIGADA, COMANDO, DIVISION y CEDE2 generará este imprimible.
	- INFORMES CONSOLIDADOS															
		+ Consolidará a nivel Brigada incluyendo lo gastado por los Batallones															
		+ Consolidará a nivel Comando o División incluyendo lo gastado por las Brigadas y Batallones															
		+ Consolidará a nivel CEDE2 incluyendo lo gastado por las Divisiones, Comandos y CEDE2
	- SE INCLUYEN UNIDADES ESPECIALES.	 Consuleo Martínez
	- SE HACE CONTROL DEL CAMBIO DE LA SIGLA DE LA UNIDAD. Jorge Clavijo
	- 13/06/2024 - Se retira el descuento del reintegro de los gastos básicos. Jorge Clavijo 
	- 05/07/2024 - Se suspende la grabacion del archivo pdf. Jorge Clavijo 
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
			$consulta1 = "select sigla, nombre, sigla1, nombre1, fecha from cx_org_sub where subdependencia= '".$uni_usuario."'";
			$cur1 = odbc_exec($conexion,$consulta1);
			$sigla = trim(odbc_result($cur1,1));
			$sigla1 = trim(odbc_result($cur1,3));
			$nom1 = trim(odbc_result($cur1,4));
			$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur1,5)),0,10));

			$consulta_reg = "select fecha from cx_rel_gas where periodo = '".$_GET['periodo']."' and ano = '". $_GET['ano']."' order by fecha";
			$cur_reg = odbc_exec($conexion,$consulta_reg);
			$fecha_rg = substr(trim(odbc_result($cur_reg,1)),0,10);
			
			if ($sigla1 <> "") if ($fecha_rg >= $fecha_os) $sigla = $sigla1;

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
			$this->Cell(65,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
			$this->Cell(57,5,'INFORME CONTROL DE',0,0,'C');			
			$this->Cell(8,5,'Pág:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(65,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
			$this->Cell(57,5,'EROGACIONES CAUSADAS EN',0,0,'C');
			$this->Cell(12,5,'Código:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'FO-JEMPP-CEDE2-628',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(65,5,'EJÉRCITO NACIONAL',0,0,'');
			$this->Cell(57,5,'ORDOP O MISIONES DE TRABAJO DE',0,0,'C');
			$this->Cell(12,5,'Versión:',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'1',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'',0,0,'C',0);
			$this->Cell(65,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
			$this->Cell(57,5,'INTELIGENCIA Y CONTRAINTELIGENCIA',0,0,'C');
			$this->Cell(26,5,'Fecha de emisión:',0,0,'');			
			$this->SetFont('Arial','',8);
			$this->Cell(36,5,'2018-07-10',0,1,'');

			$this->SetFont('Arial','B',8);
			$this->Cell(17,3,'',0,0,'C',0);
			$this->Cell(65,3,'CONTRAINTELIGENCIA',0,0,'');
			$this->Cell(57,5,'',0,0,'C');
			$this->Cell(26,3,'',0,0,'');
			$this->SetFont('Arial','',8);
			$this->Cell(22,3,'',0,1,'');

			$this->RoundedRect(9,15,80,26,0,'');
			$this->RoundedRect(89,15,60,26,0,'');
			$this->RoundedRect(149,15,52,26,0,'');
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
  			//$fecha1="";
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
	require('../numerotoletras2.php');

	$pdf=new PDF();
	$pdf->AliasNbPages();  
	$pdf->Open();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);
	$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
	$pdf->SetAuthor('Cx Computers');
	$pdf->SetFillColor(204);
		
	$sustituye_sig = array ('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9');
	$sustituye = array ( 'Ã¡' => 'á', 'Ãº' => 'ú', 'Ã“' => 'Ó', 'Ã³' => 'ó', 'Ã‰' => 'É', 'Ã©' => 'é', 'Ã‘' => 'Ñ', 'Ã­' => 'í' );
	$n_rubros = array('204-20-1', '204-20-2');
	$n_soportes = array('INFORME DE GIRO CEDE2', 'CONSIGNACION', 'NOTA CREDITO', 'ABONO EN CUENTA');
	$n_transacciones = array('TRANSFERENCIA', 'CONSIGNACION', 'NOTA CREDITO');
	$n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$linea = str_repeat("_",122);
	//$unidad_1 = $_GET['unidad'];

	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=268.00125) $pdf->addpage();
	} //control_salto_pag

	//01/07/2023 - Se hace control del cambio de la sigla a partir de la fecha de cx_org_sub.
	$consulta_sub = "select * from cx_org_sub where subdependencia = '".$uni_usuario."'";
	$cur_sub = odbc_exec($conexion,$consulta_sub);
	$unidad = odbc_result($cur_sub,1);
	$dependencia = trim(odbc_result($cur_sub,2));
	$subdependencia = trim(odbc_result($cur_sub,3));
	$sigla = trim(odbc_result($cur_sub,4));
	$nombre_uni = trim(odbc_result($cur_sub,6));
	$tipo_org = trim(odbc_result($cur_sub,7));
	$unic = trim(odbc_result($cur_sub,8));
	$especial_rg = trim(odbc_result($cur_sub,40));
	$dias_mes = cal_days_in_month(CAL_GREGORIAN, $_GET['periodo'], $_GET['ano']);
	$vigencia = "Del 01-".$n_meses[$_GET['periodo']-1]."-".$_GET['ano']." AL ".$dias_mes."-".$n_meses[$_GET['periodo']-1]."-".$_GET['ano'];
	$sigla1 = trim(odbc_result($cur_sub,41));
	$nom1 = trim(odbc_result($cur_sub,42));
	$fecha_os = str_replace("/", "-", substr(trim(odbc_result($cur_sub,43)),0,10));
	$consulta_reg = "select fecha from cx_rel_gas where periodo = '".$_GET['periodo']."' and ano = '". $_GET['ano']."' order by fecha";
	$cur_reg = odbc_exec($conexion,$consulta_reg);
	$fecha_rg = substr(trim(odbc_result($cur_reg,1)),0,10);
	if ($sigla1 <> "") if ($fecha_rg >= $fecha_os) $sigla = $sigla1;
	
	//firmas
	if ($unic == 1)
	{
		$eje = trim(odbc_result($cur_sub,13));
		$jem = trim(odbc_result($cur_sub,14));
		$cdo = trim(odbc_result($cur_sub,15));
		$c_eje = trim(odbc_result($cur_sub,28));	
		$c_jem = trim(odbc_result($cur_sub,29));
		$c_cdo = trim(odbc_result($cur_sub,30));

		if ($especial_rg <> 0)
		{
			$consulta_uweb = "select * from cx_usu_web where unidad = '".$uni_usuario."'";   //."' and admin = 3";
			$cur_uweb = odbc_exec($conexion,$consulta_uweb);
			$u = 0;
			while($u<=$row=odbc_fetch_array($cur_uweb))
			{
				if (trim(odbc_result($cur_uweb,13)) == 11)
				{
					$eje = trim(odbc_result($cur_uweb,4));
					$c_eje = trim(odbc_result($cur_uweb,18));
				}   //if 

				if (trim(odbc_result($cur_uweb,13)) == 13)
				{
					$cdo = trim(odbc_result($cur_uweb,4));
					$c_cdo = trim(odbc_result($cur_uweb,18));
				}   //if 
				$u++;
			}   //while
		}   //if
	}
	else
	{
		$usuarios_uni = substr($usu_usuario,4);
		$consulta_uweb = "select * from cx_usu_web where usuario = 'CDO_".$usuarios_uni."'";
		$cur_uweb = odbc_exec($conexion,$consulta_uweb);
		$cdo = trim(odbc_result($cur_uweb,4));
		$c_cdo = trim(odbc_result($cur_uweb,18));
		
		if ($tipo_org == 5)
		{
			$consulta_uweb = "select * from cx_usu_web where unidad = '".$uni_usuario."' order by admin";
			$cur_uweb = odbc_exec($conexion,$consulta_uweb);
			$u = 0;
			while($u<=$row=odbc_fetch_array($cur_uweb))
			{
				if (trim(odbc_result($cur_uweb,13)) == 1)
				{
					$eje = trim(odbc_result($cur_uweb,4));
					$c_eje = trim(odbc_result($cur_uweb,18));
				}   //if 

				if (trim(odbc_result($cur_uweb,13)) == 2)
				{
					$cdo = trim(odbc_result($cur_uweb,4));
					$c_cdo = trim(odbc_result($cur_uweb,18));
				}   //if 
				$u++;
			}   //while
		}
		elseif ($tipo_org == 8)
		{
			$consulta_uweb = "select * from cx_usu_web where unidad = '".$uni_usuario."' and admin = 3";
			$cur_uweb = odbc_exec($conexion,$consulta_uweb);
			$eje = trim(odbc_result($cur_uweb,4));
			$c_eje = trim(odbc_result($cur_uweb,18));
		}
		elseif ($unidad == 2 or $unidad == 3)
		{
			$consulta_uweb = "select * from cx_usu_web where unidad = '".$uni_usuario."' and admin = 3";
			$cur_uweb = odbc_exec($conexion,$consulta_uweb);
			$eje = trim(odbc_result($cur_uweb,4));
			$c_eje = trim(odbc_result($cur_uweb,18));
		}
		elseif ($unidad >= 4 and $unidad <= 17)
		{
			$consulta_uweb = "select * from cx_usu_web where unidad = '".$uni_usuario."' and admin = 7";
			$cur_uweb = odbc_exec($conexion,$consulta_uweb);
			$eje = trim(odbc_result($cur_uweb,4));
			$c_eje = trim(odbc_result($cur_uweb,18));
		}
		else
		{
			$consulta_uweb = "select * from cx_usu_web where unidad = '".$uni_usuario."' and usuario like 'O%'";
			$cur_uweb = odbc_exec($conexion,$consulta_uweb);
			$eje = trim(odbc_result($cur_uweb,4));
			$c_eje = trim(odbc_result($cur_uweb,18));
		}   //if
	}   //if
		
	$actual=$pdf->GetY();
	$pdf->Cell(38,5,'UNIDAD',0,0,'');	
	$pdf->Cell(46,5,$sigla,B,0,'L');	
	$pdf->Cell(106,5,'DE USO EXCLUSIVO',0,1,'R');
	$pdf->Ln(1);		
	$pdf->Cell(38,5,'PERIODO DEL INFORME',0,0,'');
	$pdf->Cell(70,5,$vigencia,0,1,'L');	
	$pdf->Ln(1);
	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,155,5,0,'DF');	
	$pdf->RoundedRect(164,$actual,37,5,0,'DF');		
	$pdf->Cell(155,5,'EROGACIONES',0,0,'L');
	$pdf->Cell(37,5,'TOTAL EROGACIÓN',0,1,'C');

	//Crea matriz con los conceptos de pago e inicializa en cero.
	$consulta_ctrpag = "select * from cx_ctr_pag order by codigo";
	$cur_ctrpag = odbc_exec($conexion,$consulta_ctrpag);
	$i = 0;
    while($i<=$row=odbc_fetch_array($cur_ctrpag))
    {
		$erogaciones[0][$i] = odbc_result($cur_ctrpag,1).". ".strtr(trim(odbc_result($cur_ctrpag,2)), $sustituye);
		$erogaciones[1][$i] = "0.00";
		$erogaciones[2][$i] = odbc_result($cur_ctrpag,3);
		$i++;
	}  //while

	if (odbc_num_rows($cur_sub) <> 0)
	{
		if ($unidad == 1) $consulta_osub1 = "select * from cv_unidades where unidad > 0 order by unidad, dependencia, subdependencia";
		elseif ($unidad == 2 or $unidad == 3)
		{
			if ($unic == 0) $consulta_osub1 = "select * from cx_org_sub where subdependencia = '".$subdependencia."' and dependencia = '".$dependencia."'";
			if ($unic == 1) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."' and dependencia = '".$dependencia."'";
			if ($unic == 2) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."' and dependencia = '".$dependencia."'";
		}
		elseif ($unidad >= 4 and $unidad <= 17)
		{
			if ($unic == 0) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."' and subdependencia = '".$subdependencia."'";			
			elseif ($unic == 1) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."'";	
			elseif ($unic == 2) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."' and dependencia = '".$dependencia."'";
		}
		else
		{
			if ($unic == 0) $consulta_osub1 = "select * from cx_org_sub where subdependencia = '".$subdependencia."'";
			elseif ($unic == 1) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."' and dependencia = '".$dependencia."'";
			elseif ($unic == 2) $consulta_osub1 = "select * from cx_org_sub where unidad = '".$unidad."'";
		}   //if 		
		$cur_osub1 = odbc_exec($conexion, $consulta_osub1);
		$lisuni = "";
		while($i<$row=odbc_fetch_array($cur_osub1))
		{
			$lisuni.="'".odbc_result($cur_osub1,3)."',";
		}   //while
		$lisuni = substr($lisuni,0,-1);

		// Se verifica si es unidad centralizadora especial
		if (strpos($especial, $subdependencia) !== false)
		{
			$lisuni .= ",";
			$consulta_osb1 = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";
			$cur_osb1 = odbc_exec($conexion, $consulta_osb1);
			while($i<$row=odbc_fetch_array($cur_osb1))
			{
				$n_unidad = odbc_result($cur_osb1,1);
				$n_dependencia = odbc_result($cur_osb1,2);
				$consulta_osb2 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
				$cur_osb2 = odbc_exec($conexion, $consulta_osb2);
				while($j<$row=odbc_fetch_array($cur_osb2))
				{
					$lisuni .= "'".odbc_result($cur_osb2,1)."',";
				}   //while
			}   //while
		  }   //if
		  if (substr($lisuni,-1) == ',') $lisuni = substr($lisuni,0,-1);

		$consulta_subg = "select subdependencia from cx_org_sub where subdependencia in (".$lisuni.") order by subdependencia";
        $cur_subg = odbc_exec($conexion,$consulta_subg);
		$l = 0;
		while($l<$nreg=odbc_fetch_array($cur_subg))
		{
			$unidades[$l] = odbc_result($cur_subg, 1);
			$l++;
		} // while

		if ($_GET['unidad'] != 999)
		{
			$consulta_relgas = "select * from cx_rel_gas where unidad = '".$_GET['unidad']."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' order by consecu";
			$cur_relgas = odbc_exec($conexion, $consulta_relgas);
			$u = 0;
			while($u<odbc_fetch_array($cur_relgas))
			{
				$conse1 = odbc_result($cur_relgas,1);
				$consecu = odbc_result($cur_relgas,18);
				
				$consulta_reldis = "select * from cx_rel_dis where conse1 = '".$conse1."' and consecu = '".$consecu."' and ano=".$_GET['ano']." order by gasto";		 
				$cur_reldis = odbc_exec($conexion, $consulta_reldis);
				$u1 = 0;
				while($u1<odbc_fetch_array($cur_reldis))
				{				
					$col = strval(odbc_result($cur_reldis,3))-1;
					$rval = substr(str_replace(',','',trim(odbc_result($cur_reldis,4))),0);
					$erogaciones[1][$col] = $erogaciones[1][$col] + $rval;		
					if (trim(odbc_result($cur_reldis,8)) == 'R') $erogaciones[1][0] = $erogaciones[1][0] - $rval;
					$u1++;
				}   //while
			}  //while
		}   //if
		else
		{
			for ($a=0;$a<=$l-1;$a++)
			{
				$consulta_relgas = "select * from cx_rel_gas where unidad = '".$unidades[$a]."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."' order by consecu";
				$cur_relgas = odbc_exec($conexion, $consulta_relgas);
				$u = 0;
				while($u<odbc_fetch_array($cur_relgas))
				{
					$conse1 = odbc_result($cur_relgas,1);
					$consecu = odbc_result($cur_relgas,18);
					$reintegro = substr(str_replace(',','',trim(odbc_result($cur_relgas,21))),0);					
					$consulta_reldis = "select * from cx_rel_dis where conse1 = '".$conse1."' and consecu = '".$consecu."' and ano= '".$_GET['ano']."'  and gasto <> '' order by gasto";				
					$cur_reldis = odbc_exec($conexion, $consulta_reldis);
					$u1 = 0;
					while($u1<odbc_fetch_array($cur_reldis))
					{				
						$rval = trim(odbc_result($cur_reldis,5));
						$col = strval(odbc_result($cur_reldis,3))-1;
						
						//13/06/2024 - Se retira el descuento del reintegro de los gastos básicos. Jorge Clavijo
						if (odbc_result($cur_reldis,3) == 1) $erogaciones[1][$col] = $erogaciones[1][$col] + $rval; // - $reintegro;					
						else
						{
							$erogaciones[1][$col] = $erogaciones[1][$col] + $rval;
							if (trim(odbc_result($cur_reldis,8)) == 'R') $erogaciones[1][0] = $erogaciones[1][0] - $rval;
						}   //if
						$u1++;
					}   //while
				}  //while
			}   //for
		}  //if
	}  //if

	$total_erogaciones = 0;
	for ($j=$h=0;$j<$i;$j++)
	{
		control_salto_pag($pdf->GetY());			
		if ($erogaciones[2][$j] != 'X')
		{
			$actual=$pdf->GetY();
			$pdf->RoundedRect(9,$actual,192,5,0,'');		
			$pdf->Cell(154,5,$erogaciones[0][$j],0,0,'L');
			$pdf->Cell(38,5,'$'.number_format($erogaciones[1][$j],2),L,1,'R');
			$total_erogaciones = $total_erogaciones + $erogaciones[1][$j];
		}   //if
	}   //for

	$actual=$pdf->GetY();
	$pdf->RoundedRect(9,$actual,155,5,0,'DF');
	$pdf->RoundedRect(164,$actual,37,5,0,'DF');		
	$pdf->Cell(154,5,'TOTAL ORDOP/MISIÓN',0,0,'L');
	$pdf->Cell(38,5,'$'.number_format($total_erogaciones,2),0,1,'R');	

	control_salto_pag($pdf->GetY());
	$pdf->Ln(25);

	//Busca imagen de la firma Ejecutó
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$eje."'";
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
	//$pdf->Cell(95,5,$pdf->Image($file,46,$actual-15,$w,30),0,0,'C');
	
	//Busca imagen de la firma Autorizo
	$consulta_fr = "select firma, usuario from cx_usu_web where nombre = '".$cdo."'";
	$cur_fr = odbc_exec($conexion,$consulta_fr);
	if (odbc_num_rows($cur_fr) > 0)	
	{
		$f_autorizo = trim(odbc_result($cur_fr,1));
		$n_usuario = trim(odbc_result($cur_fr,2));
		$data = str_replace('data:image/png;base64,', '', $f_autorizo);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data); 
		$file = '../tmp/'.$n_usuario.'.png';
		$success = file_put_contents($file, $data);
		$tamano = getimagesize($file);
		//if ($tamano[0] <> 270 or $tamano[1] <> 270) $file = '../tmp/firma_blanca.png';
	}
	else $file = '../tmp/firma_blanca.png';
	//$pdf->Cell(95,5,$pdf->Image($file,135,$actual-15,$w,30),0,1,'C');

	$pdf->Ln(2);
	$s_eje = "_____________________________________________"."\n".$eje."\n".$c_eje;
	$s_cdo = "_____________________________________________"."\n".$cdo."\n".$c_cdo;
	$x = $pdf->Getx();
	$y = $pdf->Gety();
	$pdf->Multicell(95,5,$s_eje,0,'C');
	$pdf->SetXY($x+95,$y);
	$pdf->Multicell(95,5,$s_cdo,0,'C');
 
	$pdf->Ln(2);
	$pdf->Cell(190,5,$linea,0,1,'C');	
	$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
	$pdf->Multicell(190,4,$texto,0,'J');
	control_salto_pag($pdf->GetY());	
	$actual=$pdf->GetY();	
	$pdf->RoundedRect(9,$actual,192,5,0,'');
	$pdf->Cell(191,5,'Elaboró:   '.utf8_decode(strtr(trim($_SESSION["nom_usuario"]), $sustituye)),0,1,'L');

	//$nom_pdf="pdf/Libros/".$_GET['ano']."/ConEro_".trim($sig_usuario)."_".$_GET['unidad']."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
	//$pdf->Output($nom_pdf,"F");
	$file=basename(tempnam(getcwd(),'tmp'));

	if ($cargar == "0") $pdf->Output();
	else $pdf->Output($file);
	echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>";		
}
?>
