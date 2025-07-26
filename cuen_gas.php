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
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  $dia = date('d');
  $dia = intval($dia);
  $pregunta = "SELECT sigla FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $sql = odbc_exec($conexion, $pregunta);
  $sigla = trim(odbc_result($sql,1));
  if (strpos($per_usuario, "Z|01/") !== false)
  {
    $descarga = "1";
  }
  else
  {
    $descarga = "0";
  }
  if (strpos($per_usuario, "Z|02/") !== false)
  {
    $elimina = "1";
  }
  else
  {
    $elimina = "0";
  }
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css"/>
  <link rel="stylesheet" href="alertas/themes/alertify.default.css"/>
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
          <h3>Cuenta Gastos Reservados</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando..." />
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <input type="hidden" name="v_usuario" id="v_usuario" class="form-control" value="<?php echo $usu_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="v_unidad" id="v_unidad" class="form-control" value="<?php echo $uni_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="sigla" id="sigla" class="form-control" value="<?php echo $sigla; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="dia" id="dia" class="form-control" value="<?php echo $dia; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="ruta" id="ruta" class="form-control" value="<?php echo $ruta_local; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="url" id="url" class="form-control" value="<?php echo $url; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="descarga" id="descarga" class="form-control" value="<?php echo $descarga; ?>" readonly="readonly">
                  <input type="hidden" name="elimina" id="elimina" class="form-control" value="<?php echo $elimina; ?>" readonly="readonly">
                  <input type="hidden" name="correo" id="correo" class="form-control" value="<?php echo $ema_usuario; ?>" readonly="readonly" tabindex="0">
                  <input type="hidden" name="servidor" id="servidor" class="form-control" value="" readonly="readonly" tabindex="0">
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
                <div id="lbl2">
	                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
	                  <label><font face="Verdana" size="2">Unidad</font></label>
	                  <?php
	                  $menu1_1 = odbc_exec($conexion,"SELECT unidad, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla");
	                  $menu1 = "<select name='centra' id='centra' class='form-control select2' onchange='busca();'>";
	                  $i = 1;
	                  $menu1 .= "\n<option value='-'>- SELECCIONAR -</option>";
	                  while($i<$row=odbc_fetch_array($menu1_1))
	                  {
	                    $nombre = trim($row['sigla']);
	                    $menu1 .= "\n<option value=$row[unidad]>".$nombre."</option>";
	                    $i++;
	                  }
	                  $menu1 .= "\n</select>";
	                  echo $menu1;
	                  ?>
	                </div>
								</div>
                <div id="lbl3">
                  <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4">
                    <label><font face="Verdana" size="2">Unidades:</font></label>
                    <select name="unidad" id="unidad" class="form-control select2" multiple="multiple" data-placeholder="&nbsp;Seleccione uno o mas unidades"></select>
                  </div>
                </div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <br>
                  <center>
                    <input type="button" name="consultar" id="consultar" value="Consultar">
                  </center>
                </div>
                <div class="col col-lg-4 col-sm-4 col-md-4 col-xs-4"></div>
                <div class="col col-lg-2 col-sm-2 col-md-2 col-xs-2">
                  <center>
                    <div class="espacio1"></div>
                    <div id="lbl1">
                      <label><font face="Verdana" size="2">Archivo Comprimido</font></label>
                    </div>
                    <a href="#" id="clip" onclick="subir(); return false;"><img src="imagenes/clip.png" title="Archivos Cuenta Gastos"></a>
                  </center>
                </div>
              </div>
              <br>
              <br>
              <div id="tabla7"></div>
              <div id="resultados5"></div>
              <div id="vinculo"></div>
            </form>
            <form name="formu_excel" id="formu_excel" action="cuentas_x.php" target="_blank" method="post">
              <input type="hidden" name="paso_excel" id="paso_excel" class="form-control" readonly="readonly">
            </form>
          </div>
          <div id="dialogo"></div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="bower_components/select2/dist/js/select2.full.min.js?1.0.0"></script>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
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
  $("#load").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 170,
    width: 670,
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
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#lbl1").hide();
  $("#clip").hide();
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#consultar").css({ width: '150px', 'padding-top': '8px', 'padding-bottom': '8px' });
  $("#periodo").val('<?php echo $mes; ?>');
  $("#centra").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  $("#unidad").select2({
    tags: false,
    allowClear: false,
    closeOnSelect: true
  });
  var v_unidad = $("#v_unidad").val();
	if ((v_unidad == "1") || (v_unidad == "2"))
	{
		$("#lbl2").show();
	}
	else
	{
		$("#lbl2").hide();  
	}
  $("#lbl3").hide();
  var servidor = location.host;
  $("#servidor").val(servidor);
  trae_unidades(0);
  trae_ano();
});
function trae_unidades(valor)
{
  var valor;
  $("#unidad").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unid1.php",
    data:
    {
      valor: valor
    },    
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
        var codigo = registros[i].codigo;
        var nombre = registros[i].nombre;
        salida += "<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#unidad").append(salida);
    }
  });
}
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
function busca()
{
  var centra = $("#centra").val();
  var sigla = $("#centra option:selected").html();
  var consulta = "1";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_unidad1.php",
    data:
    {
      consulta: consulta,
      centra: centra,
      sigla: sigla
    },
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function ()
    {
      $("#load").hide();
    },
    success: function (data)
    {
      $("#load").hide();
      $("#unidad").val('');
      var registros = JSON.parse(data);
      var datos = registros.salida;
      var var_ocu = datos.split('|');
      var var_ocu1 = var_ocu.length;
      var paso = "";
      for (var i=0; i<var_ocu1-1; i++)
      {
        paso += "'"+var_ocu[i]+"',";
      }
      paso = paso.substr(0, paso.length-1);
      paso = "["+paso+"]";
      var final = '$("#unidad").val('+paso+').trigger("change");';
      eval(final);
    }
  });
}
function consultar()
{
  var dia = $("#dia").val();
  var descarga = $("#descarga").val();
  var elimina = $("#elimina").val();
  var unidad = $("#v_unidad").val();
  var periodo = $("#periodo").val();
  var periodo1 = $("#periodo option:selected").html();
  var periodo2 = rellenar(periodo, 2);
  var ano = $("#ano").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "cuen_consu.php",
    data:
    {
      unidad: unidad,
      sigla: $("#sigla").val(),
      unidades: $("#unidad").select2('val'),
      periodo: periodo,
      periodo1: periodo1,
      ano: ano
    },
    beforeSend: function ()
    {
      $("#load").show();
    },
    error: function ()
    {
      $("#load").hide();
    },
    success: function (data)
    {
      $("#load").hide();
      $("#tabla7").html('');
      $("#resultados5").html('');
      var registros = JSON.parse(data);
      var contador = registros.contador;
      var archivos = registros.archivos;
      var archivos1 = registros.archivos1;
      var archivos2 = registros.archivos2;
      var siglas = registros.siglas;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      if (contador == "0")
      {
        if ((unidad == "1") || (unidad == "2"))
        {
          var detalle = "<center><h3>No se encontraron archivos para el periodo seleccionado</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          $("#lbl1").show();
          $("#clip").show();
          if (dia > 5)
          {
            //correo();
          }
        }
      }
      else
      {
        $("#clip").hide();
        if (contador > 0)
        {
		      salida1 += "<table width='100%' align='center' border='0'><tr><td width='85%'><b>Archivos Encontrados:</b></td></tr></table><br>";
		      salida1 += "<div class='row'><div class='col col-lg-3 col-sm-3 col-md-3 col-xs-3'><input type='text' name='buscar' id='buscar' placeholder='Buscar...' class='form-control' autocomplete='off' /></div><div class='col col-lg-8 col-sm-8 col-md-8 col-xs-8'></div>";
		      salida1 += "<div class='col col-lg-1 col-sm-1 col-md-1 col-xs-1'><center><a href='#' id='excel' onclick='excel(); return false;'><img src='dist/img/excel.png' title='Descargar Resultados a Excel - SAP'></a></center></div></div>";
		      salida1 += "<br>";
          salida1 += "<table width='100%' align='center' border='0'><tr><td height='35' width='45%'><b>Nombre</b></td><td height='35' width='19%'><b>Fecha Cargue</b></td><td height='35' width='12%'><center><b>Extensi&oacute;n</b></center></td><td height='35' width='12%'><center><b>Descargar</b></center></td><td height='35' width='12%'><center><b>Eliminar</b></center></td></tr></table>";
          salida2 += "<table width='100%' align='center' border='0' id='a-table1'>";
          var var_ocu = archivos.split('|');
          var var_ocu1 = var_ocu.length;
          var paso = "";
          var paso1 = "";
          var paso2 = "";
          var paso3 = "";
          var v_var1 = "";
          for (var i=0; i<var_ocu1-1; i++)
          {
            paso = var_ocu[i];
            paso = paso.trim();
            var var_ocu2 = archivos1.split('#');
            var var_ocu3 = var_ocu2[i];
            var var_ocu4 = var_ocu3.split('|');
            var var_ocu5 = var_ocu4.length;
            var val_ocu2 = archivos2.split('#');
            var val_ocu3 = val_ocu2[i];
            var val_ocu4 = val_ocu3.split('|');
            var val_ocu5 = val_ocu4.length;
            var paso4 = "<br>";
            var paso5 = "<br>";
            var v3 = "<br>";
            var v4 = "<br>";
            var v5 = "<br>";
            if (var_ocu5 == "1")
            {
            }
            else
            {
              for (var j=0; j<var_ocu5-1; j++)
              {
                paso1 = var_ocu4[j];
                paso5 = val_ocu4[j];
                paso4 += paso+" "+paso1+"<br><br>";
                paso2 = paso1.split(".");
                var v1 = paso2[0];
                var v2 = paso2[1];
                paso3 = '\"'+paso+'\",\"'+v1+'\",\"'+v2+'\"';
                switch (v2)
                {
                  case 'zip':
                  case 'ZIP':
                    v3 += "<center><img src='dist/img/zip.png' width='28' height='28' border='0' title='Archivo .ZIP'></center><br>";
                    break;
                  case 'rar':
                  case 'RAR':
                    v3 += "<center><img src='dist/img/rar.png' width='28' height='28' border='0' title='Archivo .RAR'></center><br>";
                    break;
                  case 'jpg':
                  case 'JPG':
                  case 'jpeg':
                  case 'JPEG':
                    v3 += "<center><img src='dist/img/jpg.png' width='28' height='28' border='0' title='Archivo .JPG - .JPEG'></center><br>";
                    break;
                  default:
                    v3 += "";
                }
                if (descarga == "1")
                {
                  v4 += "<center><a href='#' onclick='descargar("+paso3+")'><img src='dist/img/download.png' width='32' height='32' border='0' title='Descargar Archivo'></a></center><br>";
                }
                else
                {
                  v4 += "&nbsp;<br>";
                }
                if (elimina == "1")
                {
                  v5 += "<center><a href='#' onclick='eliminar("+paso3+")'><img src='dist/img/borrar.png' width='32' height='32' border='0' title='Eliminar Archivo'></a></center><br>";
                }
                else
                {
                  v5 += "&nbsp;<br>";
                }
              }
              if ((unidad == "1") || (unidad == "2"))
        			{
	              var valida = siglas.indexOf(paso) > -1;
	              var valida1 = $("#centra").val();
	              if (valida1 == "-")
	              {
	              	valida = true;
	              }
	              if (valida == false)
	              {
	              }
	              else
	              {
		              salida2 += "<tr><td width='45%' height='35' id='l1_"+i+"'>"+paso4+"</td>";
		              salida2 += "<td width='19%' height='35' id='l2_"+i+"'>"+paso5+"</td>";
		              salida2 += "<td width='12%' height='35' id='l3_"+i+"'>"+v3+"</td>";
		              salida2 += "<td width='12%' height='35' id='l4_"+i+"'>"+v4+"</td>";
		              salida2 += "<td width='12%' height='35' id='l5_"+i+"'>"+v5+"</td></tr>";
		            }
		          }
		          else
		          {
		            salida2 += "<tr><td width='45%' height='35' id='l1_"+i+"'>"+paso4+"</td>";
		            salida2 += "<td width='19%' height='35' id='l2_"+i+"'>"+paso5+"</td>";
		            salida2 += "<td width='12%' height='35' id='l3_"+i+"'>"+v3+"</td>";
		            salida2 += "<td width='12%' height='35' id='l4_"+i+"'>"+v4+"</td>";
		            salida2 += "<td width='12%' height='35' id='l5_"+i+"'>"+v5+"</td></tr>";
		          }
              v_var1 += periodo1+"|"+ano+"|"+paso+"|"+paso1+"|"+paso5+"|"+periodo2+"|#";
            }
          }
          salida2 += "</table>";
          $("#paso_excel").val(v_var1);
          $("#tabla7").append(salida1);
          $("#resultados5").append(salida2);
        }
      }
    }
  });
}
function subir()
{
  var sigla = $("#sigla").val();
  var periodo = $("#periodo").val();
  var periodo1 = $("#periodo option:selected").html();
  var ano = $("#ano").val();
  var url = "<a href='./subir14.php?sigla="+sigla+"&periodo="+periodo1+"&ano="+ano+"' class='pantalla-modal'><img src='dist/img/blanco.png' name='link1' id='link1'></a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $(".pantalla-modal").magnificPopup({
    type: 'iframe',
    preloader: false,
    modal: false
  });
  $("#link1").click();
  $("html,body").animate({ scrollTop: 9999 }, "slow");
}
function descargar(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var periodo = $("#periodo option:selected").html();
  var ano = $("#ano").val();
  var url = $("#url").val();
  var carpeta = url+"upload/cuenta/"+ano+"/"+periodo+"/"+valor+"/"+valor1+"."+valor2;
  var url = "<a href='"+carpeta+"' download='"+valor1+"."+valor2+"'><img src='dist/img/blanco.png' name='link2' id='link2'></a>";
  $("#vinculo").hide();
  $("#vinculo").html('');
  $("#vinculo").append(url);
  $("#link2").click();
  $("html,body").animate({ scrollTop: 9999 }, "slow");
}
function eliminar(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var periodo = $("#periodo option:selected").html();
  var ano = $("#ano").val();
  var ruta = $("#ruta").val();
  var carpeta = ruta+"\\upload\\cuenta\\"+ano+"\\"+periodo+"\\"+valor; 
  var archivo = valor1+"."+valor2;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "borrar.php",
    data:
    {
      carpeta: carpeta,
      archivo: archivo
    },
    success: function (data)
    {
      $("#consultar").click();
    }
  });
}
function correo()
{
  var usuario = $("#v_usuario").val();
  var copia = $("#correo").val();
  copia = copia.trim();
  if (copia == "")
  {
    var detalle = "El usuario "+usuario+" no cuenta con correo parametrizado";
    alerta(detalle);
  }
  else
  {
    var email = copia;
    correo1(usuario, email, copia);
  }
}
function correo1(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  var tipo = "6";
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "correo.php",
    data:
    {
      tipo: tipo,
      usuario: $("#v_usuario").val(),
      email: valor1,
      copia: valor2,
      servidor: $("#servidor").val(),
      valor1: $("#periodo option:selected").html(),
      valor2: $("#ano").val()
    },
    success: function (data) {
      var registros = JSON.parse(data);
      var salida = registros.salida;
      if (salida == "1")
      {
        alerta1("E-mail enviado correctamente");
      }
      else
      {
        alerta("Error durante el envio e-mail");
      }
    }
  });
}
function rellenar(value, length)
{ 
  return ('0'.repeat(length) + value).slice(-length); 
}
function excel()
{
  formu_excel.submit();
}
function alerta(valor)
{
  alertify.error(valor);
}
function alerta1(valor)
{
  alertify.success(valor);
}
</script>
</body>
</html>
<?php
}
// 31/10/2023 - Exportacion a excel de registros
?>