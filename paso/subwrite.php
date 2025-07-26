<?php
/* SubWrite.php
   Este método imprime texto desde la posición actual de la misma forma que Write(). 
   Un parámetro adicional permite reducir o aumentar el tamaño de la fuente; es útil para las iniciales.
   Un segundo parámetro permite especificar un desplazamiento para que el texto se coloque en una posición
   de superíndice o subíndice. 
*/

require('fpdf.php');

class PDF extends FPDF
{
function subWrite($h, $txt, $link='', $subFontSize=12, $subOffset=0)
{
    // resize font
    $subFontSizeold = $this->FontSizePt;
    $this->SetFontSize($subFontSize);
    
    // reposition y
    $subOffset = ((($subFontSize - $subFontSizeold) / $this->k) * 0.3) + ($subOffset / $this->k);
    $subX        = $this->x;
    $subY        = $this->y;
    $this->SetXY($subX, $subY - $subOffset);

    //Output text
    $this->Write($h, $txt, $link);

    // restore y position
    $subX        = $this->x;
    $subY        = $this->y;
    $this->SetXY($subX,  $subY + $subOffset);

    // restore font size
    $this->SetFontSize($subFontSizeold);
}   //SubWrite
}
?>
