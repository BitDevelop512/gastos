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
  include('permisos.php');
  $ano = date('Y');
  $ano1 = date('Y');
  $mes = date('m');
  if ($mes == "12")
  {
    $mes = 1;
    $ano = $ano+1;
  }
  else
  {
    $mes = $mes+1;
  }
  switch ($adm_usuario)
  {
    case '3':
      $numero = "'".$uni_usuario."'";
      $compa = $tip_usuario;
      break;
    case '4':
    case '27':
      $numero = "'".$uni_usuario."'";
      $compa = "0";
      break;
    default:
      $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
      $cur = odbc_exec($conexion, $query);
      $n_unidad = odbc_result($cur,1);
      $n_dependencia = odbc_result($cur,2);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      $numero = "";
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
      $numero = substr($numero,0,-1);
      $compa = "0";
      break;
  }
  // Se consultan las especiales
  $query2 = "SELECT unidad FROM cx_org_sub WHERE especial!='0' ORDER BY unidad";
  $cur2 = odbc_exec($conexion, $query2);
  $numero1 = "";
  while($i<$row=odbc_fetch_array($cur2))
  {
    $numero1 .= "'".odbc_result($cur2,1)."',";
  }
  $numero1 = substr($numero1,0,-1);
  // Se valida cambio de sigla
  $actual = date('Y-m-d');
  $query3 = "SELECT sigla, sigla1, fecha FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur3 = odbc_exec($conexion, $query3);
  $v_sigla = trim(odbc_result($cur3,1));
  $n_sigla = trim(odbc_result($cur3,2));
  $f_sigla = trim(odbc_result($cur3,3));
  $c_sigla = "0";
  if ($f_sigla == "")
  {
  }
  else
  {
    $f_sigla = str_replace("/", "-", $f_sigla);
    if ($actual >= $f_sigla)
    {
      $c_sigla = "1";
    }
}
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
<link href="css1/ui.jqgrid.css" rel="stylesheet" type="text/css"/>
<link href="css1/bootstrap.css" rel="stylesheet">
<link href="css1/jquery-ui.css" rel="stylesheet">
<link href="css1/estilospropios.css" rel="stylesheet">
<script src="js1/jquery-1.11.2.js?1.0.0" ></script>
<script src="js1/jquery-ui-1.9.2.custom.min.js?1.0.0" ></script>
<style>
body
{
  background: #f4f7f9;
  margin-top: 7px;
}
</style>
</head>
<body>
<?php
include('titulo.php');
?>
<br>
<input type="hidden" name="paso" id="paso" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
<input type="hidden" name="paso0" id="paso0" class="form-control" value="<?php echo $numero1; ?>" readonly="readonly">
<input type="hidden" name="paso1" id="paso1" class="form-control" value="<?php echo $compa; ?>" readonly="readonly">
<input type="hidden" name="paso2" id="paso2" value="<?php echo $usu_usuario; ?>" readonly="readonly">
<input type="hidden" name="paso3" id="paso3" value="<?php echo $uni_usuario; ?>" readonly="readonly">
<input type="hidden" name="paso4" id="paso4" value="<?php echo $c_sigla; ?>" readonly="readonly">
<input type="hidden" name="mes" id="mes" class="form-control" value="<?php echo $mes; ?>" readonly="readonly">
<input type="hidden" name="ano" id="ano" class="form-control" value="<?php echo $ano; ?>" readonly="readonly">
<input type="hidden" name="ano1" id="ano1" class="form-control" value="<?php echo $ano1; ?>" readonly="readonly">
<input type="hidden" name="admin" id="admin" class="form-control" value="<?php echo $adm_usuario; ?>" readonly="readonly">
<input type="hidden" name="nunidad" id="nunidad" class="form-control" value="<?php echo $nun_usuario; ?>" readonly="readonly">
<input type="hidden" name="datox" id="datox" class="form-control" value="" readonly="readonly">
<div align="center">
  <table id="lista"></table> 
  <div id="paginador"></div>
</div>
<div id="dialogo"></div>
<div id="dialogo1"></div>
<div class="estiloGifLoad">
  <img src="imagenes/cargando1.gif" alt="Cargando..." />
</div>
<script src="js1/jquery-migrate-1.2.1.js?1.0.0" type="text/javascript"></script>
<script src="revi_plan.js?1.0.11" type="text/javascript"></script>
<script src="js1/grid.locale-es.js?1.0.0" type="text/javascript"></script>
<script src="js1/jquery.jqGrid.min.js?1.0.0" type="text/javascript"></script>
<script>
$(document).ready(function () {
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 580,
    modal: true,
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
          $(this).dialog("close");
        }
      }
    ]
  });
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 195,
    width: 580,
    modal: true,
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
    buttons: {
      "Aceptar": function() {
        $(this).dialog("close");
        consolida();
      },
      "Cancelar": function() {
        $(this).dialog("close");
      }
    }
  });
});
function valida()
{
  var especiales = $("#paso0").val();
  var administrador = $("#admin").val();
  var nunidad = $("#nunidad").val();
  if ((nunidad == "1") || (nunidad == "2") || (nunidad == "3"))
  {
    if ((administrador == "4") || (administrador == "27"))
    {
      var consulta = $("#datox").val();
      var mes = $("#mes").val();
      var ano = $("#ano").val();
      $.ajax({
        type: "POST",
        datatype: "json",
        url: "trae_estados.php",
        data:
        {
          consulta: consulta,
          mes: mes,
          ano: ano
        },
        success: function (data)
        {
          var registros = JSON.parse(data);
          var total = registros.total;
          total = parseInt(total);
          var total1 = registros.total1;
          total1 = parseInt(total1);
          var salida = registros.salida;
          if (total == "0")
          {
            var lista = [];
            var var_ocu = salida.split('#');
            var var_ocu1 = var_ocu.length;
            var var_ocu2 = var_ocu1-1;
            var contador = 0;
            for (var i=0; i<var_ocu1-1; i++)
            {
              paso = var_ocu[i];
              if ((paso == " ") || (paso == "P") || (paso == "Y"))
              {
                lista.push(paso);
              }
              if (paso == "W")
              {
                contador++;
              }
            }
            paso1 = lista.length;
            paso1 = parseInt(paso1);
            if (paso1 == "0")
            {
              if (total1 == "0")
              {
              }
              else
              {
                if (contador == var_ocu2)
                {
                  if (total1 == "1")
                  {
                    var detalle = "<center><h3>Desea continuar con la elaboración del Plan Consolidado ?</h3></center>";
                    $("#dialogo1").html(detalle);
                    $("#dialogo1").dialog("open");
                    $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                  }
                }
                else
                {
                  var detalle = "<center><h3>Desea continuar con la elaboración del Plan Consolidado ?</h3></center>";
                  $("#dialogo1").html(detalle);
                  $("#dialogo1").dialog("open");
                  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
                }
              }
            }
            else
            {
              var detalle = "<center><h3>Total de Planes En Tramite y/o Pendientes: "+paso1+"</h3></center>";
              $("#dialogo").html(detalle);
              $("#dialogo").dialog("open");
              $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
            }
          }
          else
          {
            var detalle = "<center><h3>Plan Consolidado del Mes ya Elaborado</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
      });
    }
  }
  else
  {
    var valida = especiales.indexOf(nunidad) > -1
    if (valida == true)
    {
      if ((administrador == "10") || (administrador == "11") || (administrador == "13"))
      {
        consolida1();
      }
    }
  }
}
function consolida()
{
  location.href = "apli_plan.php";
}
function consolida1()
{
  location.href = "apli_plan3.php";
}
</script>
</body>
</html>
<?php
}
// 10/08/2023 - Ajuste de cambio de sigla validando la fecha actual
?>