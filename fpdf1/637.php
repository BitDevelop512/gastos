<?php
/* 637.PHP
   FO-JEMPP-CEDE2-637 - Plan de Inversión Gastos Reservados Unidad Centralizadora.
   (pág 91 - "Dirtectiva Permanente No. 00095 de 2017.PDF")
*/

session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('../conf.php');
  require('../permisos.php');
  require('../funciones.php');

  $n_meses = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
  $bat_usuario = strtr(trim($bat_usuario), $sustituye);
  $unidad = $bat_usuario;
  $unidades = $_GET['unidades'];
  $periodo = $_GET['periodo'];
  $ano = $_GET['ano'];
  
  $query_ciu = "select ciudad from cx_usu_web where usuario='$usu_usuario'";
  $sql_ciu = odbc_exec($conexion,$query_ciu);
  $lugar = trim(odbc_result($sql_ciu,1));
  $fecha = date('Y/m/d');

  	function control_salto_pag($actual1)
	{
		global $pdf;
		$actual1=$actual1+5;
		if ($actual1>=298.00125) $pdf->addpage();  //183.00125
	} //control_salto_pag
  
  $query = "select * from cx_pla_cen where unidad='$uni_usuario' and periodo='$periodo' and ano='$ano'";
  $sql = odbc_exec($conexion,$query);
  $plan_num = trim(odbc_result($sql,1));
  $plan_ela = trim(odbc_result($sql,3));
  $plan_sal = trim(odbc_result($sql,8));
  $plan_gas = trim(odbc_result($sql,9));
  $plan_pag = trim(odbc_result($sql,10));
  $plan_rec = trim(odbc_result($sql,11));
  $plan_gas1 = trim(odbc_result($sql,12));
  $plan_pag1 = trim(odbc_result($sql,13));
  $plan_rec1 = trim(odbc_result($sql,14));
  $plan_revi = odbc_result($sql,15);
  $plan_orde = odbc_result($sql,16);
  $plan_vist = odbc_result($sql,17);
  $plan_nota = trim(odbc_result($sql,18));
  $plan_sal1 = str_replace(',','',$plan_sal);
  $plan_sal1 = substr($plan_sal1,0,-3);
  $plan_sal1 = intval($plan_sal1);

  $plan_gas2 = str_replace(',','',$plan_gas);
  $plan_gas2 = substr($plan_gas2,0,-3);
  $plan_gas2 = intval($plan_gas2);
 
  if ($plan_revi == "0")
  {
    $n_revisa = "";
  }
  else
  {
    $consulta1 = "select nombre, cargo from cx_usu_web where conse='$plan_revi'";
    $cur1 = odbc_exec($conexion,$consulta1);
    $n_revisa = trim(odbc_result($cur1,1));
    $c_revisa = trim(odbc_result($cur1,2));
  }

  if ($plan_orde == "0")
  {
    $n_ordena = "";
  }
  else
  {
    $consulta2 = "select nombre, cargo from cx_usu_web where conse='$plan_orde'";
    $cur2 = odbc_exec($conexion,$consulta2);
    $n_ordena = trim(odbc_result($cur2,1));
    $c_ordena = trim(odbc_result($cur2,2));
  }

  if ($plan_vist == "0")
  {
    $n_visto = "";
  }
  else
  {
    $consulta3 = "select nombre, cargo from cx_usu_web where conse='$plan_vist'";
    $cur3 = odbc_exec($conexion,$consulta3);
    $n_visto = trim(odbc_result($cur3,1));
    $c_visto = trim(odbc_result($cur3,2));
  }

  $consulta4 = "select nombre, cargo from cx_usu_web where usuario='$plan_ela'";
  $cur4 = odbc_exec($conexion,$consulta4);
  $n_elabora = trim(odbc_result($cur4,1));
  $c_elabora = trim(odbc_result($cur4,2));

define('FPDF_FONTPATH','font/');
require('rotar.php');
class PDF extends PDF_Rotate
{
function Header()
{
  require('../conf.php');
  $sig_usuario = $_SESSION["sig_usuario"];
  $div_usuario = $_SESSION["div_usuario"];
  $bat_usuario = $_SESSION["bat_usuario"];
  $this->SetFont('Arial','B',120);
  $this->SetTextColor(214,219,223);
  $this->RotatedText(55,200,$sig_usuario,35);

  $this->SetFont('Arial','B',8);
  $this->SetTextColor(255,150,150);
  $this->Cell(190,5,'SECRETO',0,1,'C');
  $this->Ln(2);

  $this->Image('sigar.png',10,17,17);
  $this->SetFont('Arial','B',8);
  $this->SetTextColor(0,0,0);
  $this->Cell(17,5,'',0,0,'C',0);
  $this->Cell(70,5,'MINISTERIO DE DEFENSA NACIONAL',0,0,'');
  $this->Cell(55,5,'PLAN DE INVERSION GASTOS',0,0,'C');
  $this->Cell(8,5,'Pág:',0,0,'');
  $this->SetFont('Arial','',8);
  $this->Cell(40,5,$this->PageNo().'/{nb}',0,1,'');

  $this->SetFont('Arial','B',8);
  $this->Cell(17,5,'',0,0,'C',0);
  $this->Cell(70,5,'COMANDO GENERAL FUERZAS MILITARES',0,0,'');
  $this->Cell(55,5,'RESERVADOS UNIDAD',0,0,'C');
  $this->Cell(12,5,'Código:',0,0,'');
  $this->SetFont('Arial','',8);
  $this->Cell(36,5,'FO-JEMPP-CEDE2-637',0,1,'');

  $this->SetFont('Arial','B',8);
  $this->Cell(17,5,'',0,0,'C',0);
  $this->Cell(70,5,'EJÉRCITO NACIONAL',0,0,'');
  $this->Cell(55,5,'CENTRALIZADORA',0,0,'C');
  $this->Cell(12,5,'Versión:',0,0,'');
  $this->SetFont('Arial','',8);
  $this->Cell(36,5,'0',0,1,'');

  $this->SetFont('Arial','B',8);
  $this->Cell(17,5,'',0,0,'C',0);
  $this->Cell(125,5,'DEPARTAMENTO DE INTELIGENCIA Y',0,0,'');
  $this->Cell(26,5,'Fecha de emisión:',0,0,'');
  $this->SetFont('Arial','',8);
  $this->Cell(22,5,'2017-05-16',0,1,'');

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
}
function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
  $h = $this->h;
  $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
  $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}
function Footer()
{
  $fecha1=date("d/m/Y H:i:s a");
  $fecha1 = "";
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
}
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->SetFont('Arial','B',8);
$pdf->SetTitle(':: SIGAR :: Sistema Integrado de Gastos Reservados ::');
$pdf->SetAuthor('Cx Computers');

$pdf->SetFillColor(204);
$linea = str_repeat("_",122);
$linea1 = str_repeat("_",20);
$espacio1 = str_repeat(" ",40);

$pdf->RoundedRect(9,41,192,22,0,'');
$pdf->RoundedRect(9,63,192,5,0,'DF');
$pdf->RoundedRect(9,68,72,15,0,'');
$pdf->RoundedRect(81,68,40,15,0,'');
$pdf->RoundedRect(121,68,40,15,0,'');
$pdf->RoundedRect(161,68,40,15,0,'');

$pdf->SetFont('Arial','',8);
$pdf->Ln(-1);
$pdf->Cell(50,5,'UNIDAD CENTRALIZADORA',0,0,'');
$pdf->Cell(50,5,$sig_usuario,0,0,'');
$pdf->Cell(90,5,'DE USO EXCLUSIVO',0,1,'R');

$pdf->Cell(30,5,'RADICADO No.',0,0,'');
$pdf->Cell(15,5,$plan_num,0,0,'R');
$pdf->Cell(145,5,'',0,1,'');

$pdf->Cell(30,5,'LUGAR Y FECHA',0,0,'');
$pdf->Cell(160,5,$lugar.'   '.$fecha,0,1,'');

$pdf->Cell(50,5,'PERIODO EJECUCION RECURSOS',0,0,'');
$pdf->Cell(140,5,$n_meses[$periodo-1],0,1,'');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,5,'1. CONCEPTOS DEL GASTO SOLICITADOS',0,1,'');

$pdf->Ln(2);
$pdf->Cell(70,4,'UNIDADES / DEPENDENCIA /',0,0,'C');
$pdf->Cell(40,4,'GASTOS EN ACTIVIDADES',0,0,'C');
$pdf->Cell(40,4,'PAGO DE',0,0,'C');
$pdf->Cell(40,4,'TOTAL',0,1,'C');

$pdf->Cell(70,4,'SECCION INTELIGENCIA O',0,0,'C');
$pdf->Cell(40,4,'DE INTELIGENCIA Y',0,0,'C');
$pdf->Cell(40,4,'INFORMACIONES',0,0,'C');
$pdf->Cell(40,4,'',0,1,'C');

$pdf->Cell(70,4,'CONTRAINTELIGENCIA',0,0,'C');
$pdf->Cell(40,4,'CONTRAINTELIGENCIA',0,0,'C');
$pdf->Cell(40,4,'',0,0,'C');
$pdf->Cell(40,4,'',0,1,'C');

$pdf->Ln(1);
$consulta = "select * from cx_val_aut where unidad in ($unidades) and periodo='$periodo' and ano='$ano' order by unidad";
$cur = odbc_exec($conexion,$consulta);
$valort1 = 0;
$valort2 = 0;
$valort3 = 0;

$i = 1;
while($i<$row=odbc_fetch_array($cur))
{
  $ordenador = trim(odbc_result($cur,3));
  $unidad1 = trim(odbc_result($cur,4));
  $aprueba = trim(odbc_result($cur,11));
  $unidad = trim(odbc_result($cur,7));
  $gastos = trim(odbc_result($cur,8));

  $consulta_placen = "select gastos from cx_pla_cen where unidad = '".$unidad1."' and periodo = '".$_GET['periodo']."' and ano = '".$_GET['ano']."'";
  $cur_placen = odbc_exec($conexion,$consulta_placen);
  $nreg_placen = odbc_num_rows($cur_placen);	
  if($nreg_placen <> 0) $descuento = str_replace(',','',trim(odbc_result($cur_placen,1)));  

  $consulta_sub = "select * from cx_org_sub where subdependencia = '".$unidad1."'"; 
  $cur_sub = odbc_exec($conexion,$consulta_sub);
  $total = trim(odbc_result($cur,10));
  if(odbc_result($cur_sub,8) == 1) $gastos = $gastos;
  // - $descuento;

  // Se consultan saldos de plan centralizado
  $v_gas = "0.00";
  if ($uni_usuario == "1")
  {
    $pregunta1 = "SELECT gastos FROM cx_pla_cen WHERE unidad='$unidad1'";
    $cur1 = odbc_exec($conexion, $pregunta1);
    $v_gas = odbc_result($cur1,1);
    if ($v_gas == "") $v_gas = "0.00";
  }
  $v_gas1 = str_replace(',','',$v_gas);
  $v_gas1 = substr($v_gas1,0,-3);
  $v_gas1 = intval($v_gas1);
  $gastos = $gastos-$v_gas1;
  $p_gastos = $gastos;
  $pagos = trim(odbc_result($cur,9));
  $total = $gastos + $pagos;
  $gastos = "$ ".number_format($gastos,2);
  $pagos = "$ ".number_format($pagos,2);
  $total = $total-$v_gas1;
  $p_total = $total;
  $total = "$ ".number_format($total,2);
  $gasto = trim(odbc_result($cur,8));
  $gasto = intval($gasto);

  $valorp1 = str_replace(',','',$p_gastos);
  $valort1 = $valort1+$valorp1;
  $valorp2 = str_replace(',','',trim(odbc_result($cur,9)));
  $valort2 = $valort2+$valorp2;
  $valorp3 = str_replace(',','',$p_total);
  $valort3 = $valort3+$valorp3;

  $actual=$pdf->GetY();
  $pdf->RoundedRect(9,$actual,72,5,0,'');
  $pdf->RoundedRect(81,$actual,40,5,0,'');
  $pdf->RoundedRect(121,$actual,40,5,0,'');
  $pdf->RoundedRect(161,$actual,40,5,0,'');
  
  $pdf->Cell(70,5,$unidad,0,0,''); 
  $pdf->Cell(40,5,$gastos,0,0,'R');
  $pdf->Cell(40,5,$pagos,0,0,'R');
  $pdf->Cell(40,5,$total,0,1,'R');
  $i++;  
  control_salto_pag($pdf->GetY()); 
}

$actual=$pdf->GetY();
$pdf->RoundedRect(9,$actual,72,5,0,'DF');
$pdf->RoundedRect(81,$actual,40,5,0,'');
$pdf->RoundedRect(121,$actual,40,5,0,'');
$pdf->RoundedRect(161,$actual,40,5,0,'');

$valortt = $valort3;
$plan_req = $valortt;
$valort1 = "$ ".number_format($valort1,2);
$valort2 = "$ ".number_format($valort2,2);
$valort3 = "$ ".number_format($valort3,2);

$pdf->Cell(70,5,'SUMAN NECESIDADES',0,0,'C'); 
$pdf->Cell(40,5,$valort1,0,0,'R');
$pdf->Cell(40,5,$valort2,0,0,'R');
$pdf->Cell(40,5,$valort3,0,1,'R');

$pdf->Ln(5);
$actual=$pdf->GetY();
$pdf->RoundedRect(9,$actual,72,5,0,'');
$pdf->RoundedRect(81,$actual,40,5,0,'');
$pdf->RoundedRect(121,$actual,40,5,0,'');
$pdf->RoundedRect(161,$actual,40,5,0,'');
$pdf->Cell(70,5,'TOTAL CONCEPTOS GASTO',0,0,'C'); 
$pdf->Cell(40,5,$valort1,0,0,'R');
$pdf->Cell(40,5,$valort2,0,0,'R');
$pdf->Cell(40,5,$valort3,0,1,'R');

$pdf->Ln(5);
$actual=$pdf->GetY();
$pdf->RoundedRect(161,$actual,40,5,0,'');
$pdf->Cell(70,5,'SALDO EN BANCO A LA FECHA',0,0,''); 
$pdf->Cell(80,5,'',0,0,'');
$pdf->Cell(40,5,'$ '.$plan_sal,0,1,'R');

control_salto_pag($pdf->GetY()); 
$pdf->Ln(5);
$actual=$pdf->GetY();
$pdf->RoundedRect(9,$actual,152,5,0,'DF');
$pdf->RoundedRect(161,$actual,40,5,0,'DF');
$pdf->Cell(150,5,'2. TOTAL GASTOS RESERVADOS REQUERIDOS',0,0,''); 
$pdf->Cell(40,5,wims_currency($plan_req),0,1,'R');

$plan_obse = $plan_nota;   //por indicación de Consuelo...
$plan_nota = "";   
$pdf->Multicell(190,5,'NOTA: '.$plan_nota,0,'J');

control_salto_pag($pdf->GetY()); 
$pdf->Ln(3);
$actual=$pdf->GetY();
$pdf->RoundedRect(9,$actual,192,5,0,'DF');
$pdf->Cell(190,5,'3. JUSTIFICACION SALDOS EN BANCO',0,1,'');
$pdf->RoundedRect(9,$actual+5,192,15,0,'');
$pdf->Cell(40,5,'Gastos en Actividades:',0,0,''); 
$pdf->Cell(30,5,'$ '.$plan_gas,0,0,'');
$pdf->Multicell(120,5,$plan_gas1,0,'');
$pdf->Cell(40,5,'Pago de Informaciones:',0,0,''); 
$pdf->Cell(30,5,'$ '.$plan_pag,0,0,'');
$pdf->Multicell(120,5,$plan_pag1,0,'');
$pdf->Cell(40,5,'Pago de Recompensas:',0,0,''); 
$pdf->Cell(30,5,'$ '.$plan_rec,0,0,'');
$pdf->Multicell(120,5,$plan_rec1,0,'');

control_salto_pag($pdf->GetY()); 
$actual=$pdf->GetY();
$pdf->RoundedRect(9,$actual,192,5,0,'DF');
$pdf->Cell(190,5,'4. OBSERVACIONES',0,1,'');
$pdf->Multicell(190,4,$plan_obse,0,'J');
$actual=$pdf->GetY();
$pdf->RoundedRect(9,$actual,192,40,0,'');
$pdf->Cell(50,5,'ANEXOS:',0,1,'');

$pdf->Ln(15);
$pdf->Cell(95,5,$n_ordena,0,0,'C');
$pdf->Cell(95,5,$n_visto,0,1,'C');
if ($tpu_usuario == "6") $pdf->Cell(95,5,$c_ordena,0,0,'C');   //'Jefe de Estado Mayor '.$sig_usuario
else $pdf->Cell(95,5,'Ordenador de Gastos Reservados '.$sig_usuario,0,0,'C'); 
$pdf->Cell(95,5,$c_visto,0,1,'C');   //'Comandante '.$sig_usuario

control_salto_pag($pdf->GetY()); 
$texto="NOTA: RESERVA LEGAL, ACTA DE COMPROMISO DE RESERVA Y TRASLADO DE LA RESERVA LEGAL. Se reitera que en Colombia, la información de inteligencia goza de reserva legal y, por tal razón, la difusión debe realizarse únicamente a los receptores legalmente autorizados, observando los parámetros establecidos en la Ley Estatutaria 1621 de 2013 y el Decreto 1070 de 2015, en especial, lo pertinente a reserva legal, acta de compromiso y protocolos de seguridad y restricción de la información, de acuerdo con los artículos 33, 34, 35, 36, 36, 37 y 38 de la Ley Estatutaria 1621 de 2013. Con la entrega del presente documento se hace traslado de la reserva legal de la información al destinatario del presente documento, en calidad de receptor legal autorizado, quien al recibir el presente documento o conocer de él, manifiesta con su firma o lectura que está suscribiendo acta de compromiso de reserva legal y garantizando de forma expresa (escrita), la reserva legal de la información a la que tuvo acceso. La reserva legal, protocolos y restricciones aplican tanto a la autoridad competente o receptor legal destinatario de la información, como al servidor público que reciba o tenga conocimiento dentro del proceso de entrega, recibo o trazabilidad del presente documento de inteligencia o contrainteligencia, por lo cual, se obliga a garantizar que en ningún caso podrá revelar información, fuentes, métodos, procedimientos, agentes o identidad de quienes desarrollan actividades de inteligencia y contrainteligencia, ni pondrá en peligro la Seguridad y Defensa Nacional. Quienes indebidamente divulguen, entreguen, filtren, comercialicen, empleen o permitan que alguien emplee la información o documentos que gozan de reserva legal, incurrirán en causal de mala conducta, sin perjuicio de las acciones penales a que haya lugar.";
$actual=$pdf->GetY();
//$pdf->RoundedRect(9,$actual+4,192,42,0,'');
$pdf->Ln(12);
$pdf->Multicell(190,3,$texto,0,'J');
//$pdf->Ln(2);
$pdf->Cell(190,4,$linea,0,1,'C');
$pdf->Cell(15,3,'Elaboró',0,0,'');
$pdf->Cell(85,3,$n_elabora,0,0,'L');
$pdf->Cell(15,3,'Revisó:',0,0,'');
$pdf->Cell(74,3,$n_revisa,0,1,'');
$pdf->Cell(190,3,$linea,0,1,'C');

if (($adm_usuario == "9") or ($adm_usuario == "13"))
{
  $nom_pdf="pdf/PlanInvCen_".trim($sig_usuario)."_".$periodo."_".$ano.".pdf";
  if (file_exists($nom_pdf))
  {
  }
  else
  {
  	$pdf->Output($nom_pdf,"F");
  }
}

$nom_pdf="../fpdf/pdf/PlanInvCen_".trim($sig_usuario)."_".$_GET['periodo']."_".$_GET['ano'].".pdf";
$pdf->Output($nom_pdf,"F");
	
$file=basename(tempnam(getcwd(),'tmp'));
$pdf->Output();
//$pdf->Output($file);
echo "<HTML><SCRIPT>document.location='consulta.php?f=$file';</SCRIPT></HTML>"; 
}
?>
