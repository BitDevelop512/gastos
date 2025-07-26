<?php
session_start();
ini_set('display_errors', 1);


  define('FPDF_FONTPATH','font/');
  require('rotar.php');
  class PDF extends PDF_Rotate
  {
    function Header()
    {
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
    }
  }

  require('../conf.php');
  require('../permisos.php');

  $pdf=new PDF();
  $pdf->Open();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',12);
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTitle('Cx Computers');
  $pdf->SetAuthor('Cx Computers');


  $pdf->Ln(20);
  $usu_usuario = "CX-JAIME";
  $query = "SELECT firma FROM cx_usu_web WHERE usuario='$usu_usuario'";
  $sql = odbc_exec($conexion, $query);
  $firma = trim(odbc_result($sql,1));
  $data = str_replace('data:image/png;base64,', '', $firma);
  $data = str_replace(' ', '+', $data);
  $data = base64_decode($data); 
  $file = '../tmp/'.$usu_usuario.'.png';
  $success = file_put_contents($file, $data);

  $actual=$pdf->GetY();
  $pdf->Image($file,120,$actual,30);
  $pdf->Ln(10);
  $pdf->Cell(120,5,$nom_usuario,0,0,'');


  $file = basename(tempnam(getcwd(),'tmp'));
  $pdf->Output();




?>