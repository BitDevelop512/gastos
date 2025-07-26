<!doctype html>
<?php
session_start();
error_reporting(0);
$_SESSION["chat"] = "SI";
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
?>
<html lang="es">
<head>
  <?php
  include('encabezado1.php');
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x:hidden; overflow-y:auto;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Usuarios Parametrizados</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Tipo de Usuarios</font></label>
                  <select name="tipo" id="tipo" class="form-control select2" tabindex="1">
                    <option value="1">PARAMETRIZADOS</option>
                    <option value="2">SIN PARAMETRIZACION</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Filtro</font></label>
                  <input type="text" name="filtro" id="filtro" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off" tabindex="2">
                </div>
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Unidad</font></label>
                  <?php
                  $menu1_1 = odbc_exec($conexion,"SELECT * FROM dbo.cf_sigla(1) ORDER BY sigla");
                  $menu1 = "<select name='unidad' id='unidad' class='form-control select2' tabindex='3'>";
                  $i = 1;
                  $menu1 .= "\n<option value='999'>- TODAS -</option>";
                  while($i<$row=odbc_fetch_array($menu1_1))
                  {
                    $nombre = trim($row['sigla']);
                    $menu1 .= "\n<option value=$row[subdepen]>".$nombre."</option>";
                    $i++;
                  }
                  $menu1 .= "\n</select>";
                  echo $menu1;
                  ?>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Continuar" tabindex="4">
                </div>
              </div>
            </form>
          </div>
          <h3>Lista de Usuarios</h3>
          <div>
						<div id="load1">
							<center>
								<img src="imagenes/cargando1.gif" alt="Cargando...">
							</center>
						</div>
	          <div id="frmReporte"></div>
					</div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#load1").hide();
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#filtro").keyup(function () {
    var valthis = $(this).val().toLowerCase();
    $("select#unidad>option").each(function () {
      var text = $(this).text().toLowerCase();
      if(text.indexOf(valthis) !== -1)  
      {
        $(this).show();
        $(this).prop("selected",true);
      }
      else
      {
        $(this).hide();
      }
    });
  });
  $("#aceptar").button();
  $("#aceptar").click(consulta);
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
});
function consulta()
{
	$("#load1").show();
  $("#soportes").accordion({active: 1});
  $("#frmReporte").html('');
  var url = "con_parame.php";
  $("#frmReporte").load(url, {
    'tipo': $("#tipo").val(),
    'unidad': $("#unidad").val(),
    'unidad1': $("#unidad option:selected").html()
  });
  $("#load1").hide();
}
</script>
</body>
</html>
<?php
}
// 02/08/2023 - Ajuste tabla desde funcion para consultar cambio de siglas
// 09/04/2025 - Ajuste tipos de usuario desde tabla cx_ctr_usu
?>