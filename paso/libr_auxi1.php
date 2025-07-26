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
  $tipo = $_GET['tipo'];
  switch ($tipo)
  {
    case '1':
      $titulo = "Libro Auxiliar de Bancos";
      break;
    case '2':
      $titulo = "Informe Consolidado de Ejecuci&oacute;n Mensual";
      break;
    case '3':
      $titulo = "Informe Detallado por Comprobantes";
      break;
    case '4':
      $titulo = "Informe Control Erogaciones Causadas Ordop";
      break;
    default:
      $titulo = "";
      break;
  }
  $query = "SELECT unidad, dependencia, tipo FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $query);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  $n_tipo = odbc_result($cur,3);
  if (($nun_usuario == "1") or ($nun_usuario == "2") or ($nun_usuario == "3"))
  {
    if (($nun_usuario == "2") or ($nun_usuario == "3"))
    {
      $pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad'";
      $sql = odbc_exec($conexion, $pregunta);
      $dependencia = odbc_result($sql,1);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
    }
    else
    {
      //$query1 = "SELECT subdependencia FROM cx_org_sub WHERE unic='1' ORDER BY subdependencia";
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND tipo='2' AND unic='0' ORDER BY subdependencia";
    }
  }
  else
  {
    if ($n_tipo == "7")
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' AND dependencia='$n_dependencia' ORDER BY subdependencia";
    }
    else
    {
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$nun_usuario' ORDER BY subdependencia";
    }
  }
  $cur1 = odbc_exec($conexion, $query1);
  $numero = "";
  while($i<$row=odbc_fetch_array($cur1))
  {
    $numero.="'".odbc_result($cur1,1)."',";
  }
  $numero = substr($numero,0,-1);
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
    $numero .= ",";
    $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";
    $cur = odbc_exec($conexion, $query);
    while($i<$row=odbc_fetch_array($cur))
    {
      $n_unidad = odbc_result($cur,1);
      $n_dependencia = odbc_result($cur,2);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      while($j<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
    }
    $numero .= $uni_usuario;
  }
  // Firmas
  $query2 = "SELECT firma1, firma2, firma3, firma4, cargo1, cargo2, cargo3, cargo4 FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur2 = odbc_exec($conexion, $query2);
  $firma1 = trim(utf8_encode(odbc_result($cur2,1)));
  $firma2 = trim(utf8_encode(odbc_result($cur2,2)));
  $firma3 = trim(utf8_encode(odbc_result($cur2,3)));
  $firma4 = trim(utf8_encode(odbc_result($cur2,4)));
  $cargo1 = trim(utf8_encode(odbc_result($cur2,5)));
  $cargo2 = trim(utf8_encode(odbc_result($cur2,6)));
  $cargo3 = trim(utf8_encode(odbc_result($cur2,7)));
  $cargo4 = trim(utf8_encode(odbc_result($cur2,8)));
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
          <h3><?php echo $titulo; ?></h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <input type="hidden" name="super" id="super" class="form-control" value="<?php echo $sup_usuario; ?>" readonly="readonly" tabindex="0">
                <input type="hidden" name="libro" id="libro" class="form-control" value="<?php echo $tipo; ?>" readonly="readonly">
                <input type="hidden" name="centra" id="centra" class="form-control" value="<?php echo $tpc_usuario; ?>" readonly="readonly">
                <input type="hidden" name="unidades" id="unidades" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
                <input type="hidden" name="unidad1" id="unidad1" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly">
                <input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly">
                <div id="tipo1">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Periodo</font></label>
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
                </div>
                <div id="tipo2">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Fecha</font></label>
                    <input type="text" name="fecha1" id="fecha1" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  </div>
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">&nbsp;</font></label>
                    <input type="text" name="fecha2" id="fecha2" class="form-control fecha" placeholder="yy/mm/dd" readonly="readonly">
                  </div>
                </div>
                <div id="unidades4">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Recurso</font></label>
                    <select name="recurso" id="recurso" class="form-control select2" tabindex="5">
                      <option value="0">- SELECCIONAR -</option>
                      <option value="1">10 CSF</option>
                      <option value="2">50 SSF</option>
                      <option value="3">16 SSF</option>
                      <option value="4">OTROS</option>
                    </select>
                  </div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Ajuste de Lineas</font></label>
                  <div>
                    <input name="ajuste" id="ajuste" class="numero" onkeypress="return check(event);" value="0">
                  </div>
                </div>
                <div id="unidades2">
                  <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                    <label><font face="Verdana" size="2">Unidad</font></label>
                    <select name="unidades1" id="unidades1" class="form-control select2" tabindex="7"></select>
                  </div>
                </div>
                <div id="unidades5">
                  <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                    <label><font face="Verdana" size="2">Cuenta Bancaria</font></label>
                    <select name="cuenta" id="cuenta" class="form-control select2" tabindex="9"></select>
                  </div>
                </div>
                <div id="unidades3">
                  <div class="col col-lg-1 col-sm-1 col-md-1 col-xs-1">
                    <input type="checkbox" name="chk_excel" id="chk_excel" value="0">&nbsp;
                    <label><font face="Verdana" size="2">Excel</font></label>
                    <br><br>
                    <input type="checkbox" name="chk_reporte" id="chk_reporte" value="0">&nbsp;
                    <label><font face="Verdana" size="2">Excel Todas</font></label>
                  </div>
								</div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <input type="button" name="aceptar1" id="aceptar1" value="Firmas" tabindex="10">
                  <div class="espacio1"></div>
                  <input type="button" name="aceptar" id="aceptar" value="Consultar" tabindex="11">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="dialogo">
      	<table width="98%" align="center" border="0">
      		<tr>
      			<td>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">Ejecutor GGRR</font></div></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="text" name="firma1" id="firma1" class="form-control input-sm" value="<?php echo $firma1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="cargo1" id="cargo1" class="form-control input-sm" value="<?php echo $cargo1; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">JEM</font></div></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="text" name="firma2" id="firma2" class="form-control input-sm" value="<?php echo $firma2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="cargo2" id="cargo2" class="form-control input-sm" value="<?php echo $cargo2; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
              </div>
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><div class="centrado"><font face="Verdana" size="2">Comandante</font></div></label>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                  <input type="text" name="firma3" id="firma3" class="form-control input-sm" value="<?php echo $firma3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
                <div class="col col-lg-5 col-sm-5 col-md-5 col-xs-5">
                  <input type="text" name="cargo3" id="cargo3" class="form-control input-sm" value="<?php echo $cargo3; ?>" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off">
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </section>
</div>
<style>
.ui-widget-header
{
  color: #000000;
  font-weight: bold;
}
</style>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 7,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    beforeShow: function (input, inst) {
      var rect = input.getBoundingClientRect();
      setTimeout(function () {
        inst.dpDiv.css({ top: rect.top-145, left: rect.left+0 });
      }, 0);
    },
    onSelect: function () {
      $("#fecha2").prop("disabled", false);
      $("#fecha2").datepicker("destroy");
      $("#fecha2").val('');
      $("#fecha2").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha1").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true,
        beforeShow: function (input, inst) {
          var rect = input.getBoundingClientRect();
          setTimeout(function () {
            inst.dpDiv.css({ top: rect.top-145, left: rect.left+0 });
          }, 0);
        },
      });
    },
  });
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 168,
    width: 900,
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
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").click(link);
  $("#aceptar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#aceptar1").button();
  $("#aceptar1").click(firmas);
  $("#aceptar1").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#periodo").val('<?php echo $mes; ?>');
  $("#ano").val('<?php echo $ano; ?>');
  $("#ajuste").spinner({ min: 0 });
  $("#ajuste").width(50);
  var tipo = $("#libro").val();
  var super1 = $("#super").val();
  var unidad1 = $("#unidad1").val();
  if ((tipo == "1") || (tipo == "3"))
  {
    $("#unidades5").show();
  }
  else
  {
    $("#unidades5").hide();
  }
  $("#chk_reporte").prop("disabled",false);
  if (tipo == "2")
  {
    $("#tipo1").hide();
    $("#tipo2").show();
    if ((unidad1 == "1") || (unidad1 == "2"))
    {
      $("#unidades4").show();
    }
    else
    {
      $("#unidades4").hide();  
    }
		$("#unidades3").show();
	$("#chk_reporte").prop("disabled",true);
  }
  else
  {
    $("#tipo1").show();
    $("#tipo2").hide();
    $("#unidades4").hide();
    if (tipo == "3")
  	{
      if (super1 == "0")
      {
        $("#unidades3").hide();
      }
      else
      {
        $("#unidades3").show();
      }
	  }
	  else
	  {
	  	$("#unidades3").hide();
	  }
  }
  if (tipo == "4")
  {
    $("#unidades2").show();
    trae_unidades();
  }
  else
  {
    $("#unidades2").hide();
  }
  trae_ano();
  trae_cuentas();
});
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
function trae_cuentas()
{
  $("#cuenta").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_cuentas1.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          var cuenta = registros[i].cuenta;
          var saldo = registros[i].saldo;
          var saldo1 = registros[i].saldo1;
          var descripcion = nombre+" - "+cuenta;
          var valores = codigo+"|"+saldo+"|"+saldo1;
          salida += "<option value='"+valores+"'>"+descripcion+"</option>";
      }
      $("#cuenta").append(salida);
    }
  });
}
function trae_unidades()
{
  $("#unidades1").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unidades.php",
    data:
    {
      unidades: $("#unidades").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<option value='999'>- SELECCIONAR -</option>";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidades1").append(salida);
    }
  });
}
function link()
{
  var libro = $("#libro").val();
  var periodo = $("#periodo").val();
  var ano = $("#ano").val();
  var ajuste = $("#ajuste").val();
  var unidad = $("#unidades1").val();
  var recurso = $("#recurso").val();
  var cuenta = $("#cuenta").val();
  var var_ocu = cuenta.split('|');
  var cuenta1 = var_ocu[0];
  var fecha1 = $("#fecha1").val();
  var fecha2 = $("#fecha2").val();
  var firma1 = $("#firma1").val();
  var cargo1 = $("#cargo1").val();
  var firma2 = $("#firma2").val();
  var cargo2 = $("#cargo2").val();
  var firma3 = $("#firma3").val();
  var cargo3 = $("#cargo3").val();
  var ruta = $("#ruta").val();
  ruta = ruta+"\\fpdf\\pdf\\Libros\\"+ano;
  var link = "";
  if (unidad == null)
  {
    unidad = 0;
  }
  var excel = "0";
  if ($("#chk_excel").is(":checked"))
  {
    excel = "1";
  }
  var nuevo = "0";
  if ($("#chk_reporte").is(":checked"))
  {
    nuevo = "1";
  }
  if (libro == "2")
  {
    link = "fecha1="+fecha1+"&fecha2="+fecha2+"&ajuste="+ajuste+"&unidad="+unidad+"&recurso="+recurso+"&excel="+excel+"&firma1="+firma1+"&cargo1="+cargo1+"&firma2="+firma2+"&cargo2="+cargo2+"&firma3="+firma3+"&cargo3="+cargo3;
  }
  else
  {
    link = "periodo="+periodo+"&ano="+ano+"&ajuste="+ajuste+"&unidad="+unidad+"&excel="+excel+"&firma1="+firma1+"&cargo1="+cargo1+"&firma2="+firma2+"&cargo2="+cargo2+"&firma3="+firma3+"&cargo3="+cargo3;    
  }
  if ((libro == "1") || (libro == "3"))
  {
    link += "&cuenta="+cuenta1;
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_libro.php",
    data:
    {
      libro: libro,
      periodo: periodo,
      ano: ano,
      unidad: unidad,
      cuenta: cuenta1
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var archivo = registros.archivo;
      var carpeta = registros.carpeta;
      var existe = registros.existe;
      switch (libro)
      {
        case '1':
          if (existe == "1")
          {
            var url = "cxvisor1/Default?valor1="+ruta+"\\&valor2="+archivo+"&valor3="+carpeta+"&valor4=1";
          }
          else
          {
            var url = "./fpdf/634.php?"+link;
          }
          break;
        case '2':
          // Falta validacion por rango fechas
          if (nuevo == "1")
          {
            var url = "./fpdf/627x30.php?"+link;
          }
          else
          {
            var url = "./fpdf/627.php?"+link;
          }
          break;
        case '3':
          if (existe == "1")
          {
            var url = "cxvisor1/Default?valor1="+ruta+"\\&valor2="+archivo+"&valor3="+carpeta+"&valor4=1";
          }
          else
          {
            var url = "./fpdf/631.php?"+link;
          }
          break;
        case '4':
          if (existe == "1")
          {
            var url = "cxvisor1/Default?valor1="+ruta+"\\&valor2="+archivo+"&valor3="+carpeta+"&valor4=1";
          }
          else
          {
            var url = "./fpdf/628_1.php?"+link;
          }
          break;
        default:
          var url = "./fpdf/634.php?"+link;
          break;
      }
      if ((libro == "2") && (excel == "1"))
      {
        if (nuevo == "1")
        {
          url = "./fpdf/627x30E.php?"+link;
        }
        else
        {
          url = "./fpdf/627E.php?"+link;
        }
        window.open(url, "_blank");
      }
      else
      {
      	if ((libro == "3") && (excel == "1"))
      	{
      		url = "./fpdf/631E.php?"+link;
      	}
      	else
      	{
	        if (nuevo == "1")
    	    {
      			url = "./fpdf/631E_1.php?"+link;
    	    }
      	}
       	window.open(url, "R2");
      }
    }
  });
}
function check(e)
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla == 8)
  {
    return true;
  }
  patron = /[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function firmas()
{
	$("#dialogo").dialog("open");
}
</script>
</body>
</html>
<?php
}
// 19/12/2023 - Inclusion de check excel en detalleado de comprobantes
// 31/01/2024 - Inlcusion check de permiso excel solo a administradores
// 06/02/2024 - Ajuste descarga libro
?>