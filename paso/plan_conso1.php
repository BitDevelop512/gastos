<!doctype html>
<?php
session_start();
error_reporting(0);
if ($_SESSION["autenticado"] != "SI")
{
  header("location:resultado.php");
}
else
{
  require('conf.php');
  include('funciones.php');
  include('permisos.php');
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  $query = "SELECT especial FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $especial = odbc_result($cur,1);
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
</head>
<body style="overflow-x:hidden; overflow-y:hidden;">
<?php
include('titulo.php');
?>
<div>
  <section class="content-header">
    <div class="row">
      <div class="col col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div id="soportes">
          <h3>Plan de Inversi&oacute;n Consolidado</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <input type="hidden" name="unidad" id="unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sig_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="especial" id="especial" class="form-control" value="<?php echo $especial; ?>" readonly="readonly">
                  <input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
                  <select name="periodo" id="periodo" class="form-control select2" tabindex="1">
                    <option value="1">ENERO</option>
                    <option value="2">FEBRERO</option>
                    <option value="3">MARZO</option>
                    <option value="4">ABRIL</option>
                    <option value="5">MAYO</option>
                    <option value="6">JUNIO</option>
                    <option value="7">JULIO</option>
                    <option value="8">AGOSTO</option>
                    <option value="9">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                  </select>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">A&ntilde;o</font></label>
                  <select name="ano" id="ano" class="form-control select2" tabindex="2"></select>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Consultar" tabindex="3">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="dialogo"></div>
    </div>
  </section>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 500,
    closeOnEscape: false,
    resizable: false,
    draggable: false,
    show:
    {
      effect: "blind",
      duration: 1000
    },
    hide:
    {
      effect: "explode",
      duration: 1000
    },
    buttons: [
      {
        text: "Ok",
        click: function() {
          $( this ).dialog( "close" );
        }
      }
    ]
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(link);
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  trae_ano();
  $("#periodo").val('<?php echo $mes; ?>');
  $("#ano").val('<?php echo $ano; ?>');
});
</script>
<script>
function trae_ano()
{
  $("#ano").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_ano.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      var j = 0;
      for (var i in registros) 
      {
        j = j+1;
        var ano = registros[i].ano;
        salida += "<option value='"+ano+"'>"+ano+"</option>";
      }
      $("#ano").append(salida);
    }
  });
}
function link()
{
  var unidad = $("#unidad").val();
  var sigla = $("#sigla").val();
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  var ruta = $("#ruta").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_conso.php",
    data:
    {
      unidad: unidad,
      periodo: periodo,
      ano: ano
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var conse = registros.conse;
      var archivo = registros.archivo;
      if (conse > 0)
      {
        ruta = ruta+"\\fpdf\\pdf\\";
        var consolidado = "PlanInvCon_"+sigla+"_"+conse+"_"+periodo+"_"+ano+".pdf";
        if (archivo == "1")
        {
          var url = "cxvisor1/Default?valor1="+ruta+"\\&valor2="+consolidado+"&valor3=0&valor4=0";
          parent.R2.location.href = url;
        }
        else
        {
          var especial = $("#especial").val();
          var link = "conse="+conse+"&periodo="+periodo+"&ano="+ano;
          if (especial == "0")
          {
            var url = "./fpdf/638_2.php?"+link;
          }
          else
          {
            var url = "./fpdf/638_3.php?"+link;
          }
          window.open(url, 'R2');
        }
      }
      else
      {
        var detalle = "<center><h3>Plan Consolidado No Encontrado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
</script>
</body>
</html>
<?php
}
?>