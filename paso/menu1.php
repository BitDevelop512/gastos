<?php
require('permisos.php');
if ($sup_usuario == "1")
{
?>
  <li><a href="#" onclick="sql(); return false;"><i class="fa fa-database"></i><span>Administrador</span></a></li>
  <li><a href="#" onclick="soportes(); return false;"><i class="fa fa-database"></i><span>Soportes Avanzados</span></a></li>
<?php
}
?>
<li><a href="logout.php"><i class="fa fa-power-off"></i><span>Cerrar Sesi&oacute;n</span></a></li>