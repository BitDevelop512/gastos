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
  $fecha = date('Y/m/d');
  $ano = date('Y');
  $mes = date('m');
  $mes = intval($mes);
  switch ($adm_usuario)
  {
    case '6':
    case '7':
    case '8':
    case '9':
      $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
      $cur = odbc_exec($conexion, $query);
      $n_unidad = odbc_result($cur,1);
      $n_dependencia = odbc_result($cur,2);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' ORDER BY subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      $numero = "";
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero.="'".odbc_result($cur1,1)."',";
      }
      $numero = substr($numero,0,-1);
      break;
    case '10':
    case '11':
    case '12':
    case '13':
    case '25':
      $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
      $cur = odbc_exec($conexion, $query);
      $n_unidad = odbc_result($cur,1);
      $n_dependencia = odbc_result($cur,2);
      $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
      $cur1 = odbc_exec($conexion, $query1);
      $numero = "";
      while($i<$row=odbc_fetch_array($cur1))
      {
        $numero .= "'".odbc_result($cur1,1)."',";
      }
      $numero = substr($numero,0,-1);
      break;
    default:
      $numero = "'".$uni_usuario."'";
      break;
  }
  // Se verifica si es unidad centralizadora especial
  if (strpos($especial, $uni_usuario) !== false)
  {
    $numero .= ",";
    $numero1 = "";
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
        $numero1 .= "'".odbc_result($cur1,1)."',";
      }
    }
    $numero = substr($numero,0,-1);
    $numero1 = substr($numero1,0,-1);
  }
  //echo $adm_usuario." - ".$numero." - ".$nun_usuario." - ".$tpc_usuario."<hr>";
?>
<html lang="es">
<head>
  <?php
  include('encabezado2.php');
  include('encabezado4.php');
  ?>
  <script type="text/javascript" src="alertas/lib/alertify.js"></script>
  <link rel="stylesheet" href="alertas/themes/alertify.core.css">
  <link rel="stylesheet" href="alertas/themes/alertify.default.css">
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
          <h3>Plan de Inversi&oacute;n Unidad Centralizadora</h3>
          <div>
            <div id="load">
              <center>
                <img src="imagenes/cargando1.gif" alt="Cargando...">
              </center>
            </div>
            <form name="formu" method="post">
              <div class="row">
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <label><font face="Verdana" size="2">Periodo</font></label>
                  <input type="hidden" name="admin" id="admin" class="form-control" value="<?php echo $adm_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="nunusuario" id="nunusuario" class="form-control" value="<?php echo $nun_usuario; ?>" readonly="readonly">
                  <input type="hidden" name="unidades" id="unidades" class="form-control" value="<?php echo $numero; ?>" readonly="readonly">
                  <input type="hidden" name="unidades1" id="unidades1" class="form-control" value="<?php echo $numero1; ?>" readonly="readonly">
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
                <div class="col col-lg-3 col-sm-3 col-md-3 col-xs-3">
                  <br>
                  <input type="button" name="aceptar" id="aceptar" value="Consultar" tabindex="3">
                </div>
              </div>
            </form>
            <br>
            <div id="res_unic"></div>
            <form name="formu3" action="ver_planes.php" method="post" target="_blank">
              <input type="hidden" name="plan_conse" id="plan_conse" readonly="readonly">
              <input type="hidden" name="plan_ano" id="plan_ano" readonly="readonly">
              <input type="hidden" name="plan_tipo" id="plan_tipo" readonly="readonly">
            </form>
            <form name="formu4" action="ver_centraliza.php" method="post" target="_blank">
              <input type="hidden" name="centra_per" id="centra_per" readonly="readonly">
              <input type="hidden" name="centra_ano" id="centra_ano" readonly="readonly">
              <input type="hidden" name="centra_uni" id="centra_uni" readonly="readonly">
            </form>
          </div>
        </div>
      </div>
      <div id="valores">
        <input type="hidden" name="v_uni" id="v_uni" class="form-control" readonly="readonly">
        <input type="hidden" name="v_per" id="v_per" class="form-control" readonly="readonly">
        <input type="hidden" name="v_ano" id="v_ano" class="form-control" readonly="readonly">
        <input type="hidden" name="v_sig" id="v_sig" class="form-control" readonly="readonly">
        <input type="hidden" name="v_dep" id="v_dep" class="form-control" readonly="readonly">
        <input type="hidden" name="v_nde" id="v_nde" class="form-control" readonly="readonly">
        <input type="hidden" name="v_uom" id="v_uom" class="form-control" readonly="readonly">
        <input type="hidden" name="v_nuo" id="v_nuo" class="form-control" readonly="readonly">
        <input type="hidden" name="v_gas" id="v_gas" class="form-control" readonly="readonly">
        <input type="hidden" name="v_pag" id="v_pag" class="form-control" readonly="readonly">
        <input type="hidden" name="v_tot" id="v_tot" class="form-control" readonly="readonly">
        <input type="hidden" name="v_uni1" id="v_uni1" class="form-control" readonly="readonly">
        <input type="hidden" name="v_sig1" id="v_sig1" class="form-control" readonly="readonly">
        <input type="hidden" name="v_gas1" id="v_gas1" class="form-control" readonly="readonly">
        <input type="hidden" name="v_pag1" id="v_pag1" class="form-control" readonly="readonly">
        <input type="hidden" name="v_tot1" id="v_tot1" class="form-control" readonly="readonly">
        <input type="hidden" name="v_coman" id="v_coman" class="form-control" readonly="readonly">
        <input type="hidden" name="v_comac" id="v_comac" class="form-control" readonly="readonly">
        <input type="hidden" name="v_blo" id="v_blo" class="form-control" value="0" readonly="readonly">
      </div>
      <div id="dialogo"></div>
      <div id="dialogo1"></div>
      <div id="dialogo2">
        <form name="formu2">
          <div id="val_modi"></div>
        </form>
      </div>
    </div>
  </section>
</div>
<link rel="stylesheet" href="magnific-popup/magnific-popup.css?1.0.0">
<script src="magnific-popup/jquery.magnific-popup.js?1.0.0"></script>
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
    width: 600,
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
    height: 170,
    width: 450,
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
        graba();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 350,
    width: 850,
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
        aprueba();
      },
      Cancelar: function() {
        $(this).dialog("close");
      }
    }
  });
  $("#soportes").accordion({
    heightStyle: "content"
  });
  $("#aceptar").button();
  $("#aceptar").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
  var valida = $("#admin").val();
  if (valida == "9")
  {
    $("#aceptar").click(consulta1);
  }
  else
  {
    if ((valida == "10") || (valida == "11") || (valida == "12") || (valida == "25"))
    {
      $("#aceptar").click(consulta2);
    }
    else
    {
      if (valida == "13")
      {
        $("#aceptar").click(consulta3);
      }
      else
      {
        $("#aceptar").click(consulta);
      }
    }
  }
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
function consulta()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "centra_consu.php",
    data:
    {
      unidades: $("#unidades").val(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      $("#res_unic").html('');
      var registros = JSON.parse(data);
      var tp_admin = $("#admin").val();
      var valida = registros.total1;
      var techo = registros.techo;
      var saldo = registros.saldo;
      if (saldo == undefined)
      {
        saldo = "0.00";
      }
      saldo = parseFloat(saldo);
      saldo = saldo.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var planes = registros.planes;
      var v_revisa = registros.v_revisa;
      var v_ordena = registros.v_ordena;
      var v_visto =  registros.v_visto;
      var plan = "";
      var sigla = "";
      var salida = "";
      salida += "<form name='formu1' method='post'>";
      salida += "<table width='95%' align='center' border='0'><tr><td width='60%'>&nbsp;</td><td width='40%' align='right'><b>Techo Unidad Centralizadora:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='techo' id='techo' class='c7' value='0.00' readonly='readonly' style='border-style: none; background: transparent; color: #000;'><input type='hidden' name='techo1' id='techo1' class='c7' value='0' readonly='readonly'><input type='hidden' name='planes' id='planes' class='c7' readonly='readonly'></td></tr></table><br>";
      salida += "<table width='95%' align='center' border='1'><tr><td width='25%' height='60' bgcolor='#cccccc'><center><b>UNIDADES / DEPENDENCIA /<br>SECCION INTELIGENCIA O<br>CONTRAINTELIGENCIA</b></center></td><td width='20%' height='60' bgcolor='#cccccc'><center><b>GASTOS EN ACTIVIDADES<br>DE INTELIGENCIA Y<br>CONTRAINTELIGENCIA</b></center></td><td width='20%' height='60' bgcolor='#cccccc'><center><b>PAGO DE<br>INFORMACIONES</b></center></td><td width='25%' height='60' bgcolor='#cccccc'><center><b>TOTAL</b></center></td><td width='5%' height='60' bgcolor='#cccccc'>&nbsp;</td><td width='5%' height='60' bgcolor='#cccccc'>&nbsp;</td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor1 = parseFloat(value.gastos);
        valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor3 = parseFloat(value.pagos);
        valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor5 = parseFloat(value.total);
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        if ((tp_admin == "6") || (tp_admin == "25"))
        {
          if (index == "0")
          {
          }
          else
          {
            plan = "'"+value.plan+"'";
            sigla = value.sigla.trim();
            salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly"><input type="hidden" name="dep_'+y+'" id="dep_'+y+'" class="c10" value='+value.depen+' readonly="readonly"><input type="hidden" name="nde_'+y+'" id="nde_'+y+'" class="c10" value='+value.n_depen+' readonly="readonly"><input type="hidden" name="uom_'+y+'" id="uom_'+y+'" class="c10" value='+value.uom+' readonly="readonly"><input type="hidden" name="nuo_'+y+'" id="nuo_'+y+'" class="c10" value='+value.n_uom+' readonly="readonly">'+value.sigla+'</td><td align="right"><input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" readonly="readonly" onfocus="blur();" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right"><input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td><td height="35"><center><a href="#" onclick="link1('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Consolidado"></a></center></td><td height="35"><center><a href="./archivos/index2.php?sigla='+sigla+'&ano='+value.ano+'&conse='+plan+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
          }
        }
        else
        {
          if (tp_admin == "7")
          {
            salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly"><input type="hidden" name="dep_'+y+'" id="dep_'+y+'" class="c10" value='+value.depen+' readonly="readonly"><input type="hidden" name="nde_'+y+'" id="nde_'+y+'" class="c10" value='+value.n_depen+' readonly="readonly"><input type="hidden" name="uom_'+y+'" id="uom_'+y+'" class="c10" value='+value.uom+' readonly="readonly"><input type="hidden" name="nuo_'+y+'" id="nuo_'+y+'" class="c10" value='+value.n_uom+' readonly="readonly">'+value.sigla+'</td><td align="right">';
          }
          else
          {
            salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly">'+value.sigla+'</td><td align="right">';
          }
          if (tp_admin == "7")
          {
            if (index == "0")
            {
            }
            else
            {
              salida += '<a href="#" name="gra_'+y+'" id="gra_'+y+'" onclick="modif('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor1+','+y+','+1+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
            }
            salida += '<input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" onkeyup="paso_val1('+y+'); totaliza('+y+'); suma('+valida+');"';
            if (index == "0")
            {
            }
            else
            {
              salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
            }
            salida += '><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right">';
            if (index == "0")
            {
            }
            else
            {
              salida += '<a href="#" name="gra1_'+y+'" id="gra1_'+y+'" onclick="modif('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor3+','+y+','+2+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
            }
            salida += '<input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onkeyup="paso_val2('+y+'); totaliza('+y+'); suma('+valida+');"';
            if (index == "0")
            {
            }
            else
            {
              salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
            }
            salida += '><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td>';
            if (index == "0")
            {
              salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
            }
            else
            {
              plan = "'"+value.plan+"'";
              sigla = value.sigla.trim();
              salida += '<td height="35"><center><a href="#" onclick="link1('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Consolidado"></a></center></td>';
              salida += '<td height="35"><center><a href="./archivos/index2.php?sigla='+sigla+'&ano='+value.ano+'&conse='+plan+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
            }
          }
          else
          {
            if (index == "1")
            {
            }
            else
            {
              salida += '<a href="#" name="gra_'+y+'" id="gra_'+y+'" onclick="modif1('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor1+','+y+','+1+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
            }
            salida += '<input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" onkeyup="paso_val1('+y+'); totaliza('+y+'); suma('+valida+');"';
            if (index == "1")
            {
            }
            else
            {
              salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
            }
            salida += '><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right">';
            if (index == "1")
            {
            }
            else
            {
              salida += '<a href="#" name="gra1_'+y+'" id="gra1_'+y+'" onclick="modif1('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor3+','+y+','+2+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
            }
            salida += '<input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onkeyup="paso_val2('+y+'); totaliza('+y+'); suma('+valida+');"';
            if (index == "1")
            {
            }
            else
            {
              salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
            }
            salida += '><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td>';
            if (index == "1")
            {
              salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
            }
            else
            {
              if (value.conso == "0")
              {
                salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
              }
              else
              {
                plan = "'"+value.plan+"'";
                sigla = value.sigla.trim();
                salida += '<td height="35"><center><a href="#" onclick="link1('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Consolidado"></a></center></td>';
                salida += '<td height="35"><center><a href="./archivos/index2.php?sigla='+sigla+'&ano='+value.ano+'&conse='+plan+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
              }
            } 
          }
        }
        y++;
      });
      // Totales
      salida += '<tr><td height="35" bgcolor="#cccccc"><b>TOTAL NECESIDADES</b></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total1" id="total1" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp1" id="totalp1" class="c7" value="0" readonly="readonly"></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total2" id="total2" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp2" id="totalp2" class="c7" value="0" readonly="readonly"></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total3" id="total3" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp3" id="totalp3" class="c7" value="0" readonly="readonly"></td><td height="35" bgcolor="#cccccc">&nbsp;</td><td height="35" bgcolor="#cccccc">&nbsp;</td></tr>';
      salida += '<tr><td colspan="6" height="35">&nbsp;</td></tr>';
      // Saldos
      if ((tp_admin == "6") || (tp_admin == "25"))
      {
        salida += '<tr><td height="35"><b>SALDO EN BANCO</b></td><td align="right" height="35"><input type="text" name="saldo" id="saldo" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="saldo1" id="saldo1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><center><b>JUSTIFICACION SALDO EN BANCOS</b></center></td></tr>';
        salida += '<tr><td height="35">Gastos en Actividades</td><td align="right" height="35"><input type="text" name="gastos" id="gastos" class="c7" value="0.00" onkeyup="paso_val8();" onblur="suma1();" autocomplete="off" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="gastos1" id="gastos1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="gastos2" id="gastos2" class="form-control" value="N/A" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" style="border-style: none; background: transparent; color: #000;"></td></tr>';
        salida += '<tr><td height="35">Pago de Informaciones</td><td align="right" height="35"><input type="text" name="pagos" id="pagos" class="c7" value="0.00" onkeyup="paso_val9();" onblur="suma1();" autocomplete="off" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="pagos1" id="pagos1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="pagos2" id="pagos2" class="form-control" value="N/A" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" style="border-style: none; background: transparent; color: #000;"></td></tr>';
        salida += '<tr><td height="35">Pago de Recompensas</td><td align="right" height="35"><input type="text" name="recompensas" id="recompensas" class="c7" value="0.00" onkeyup="paso_val10();" onblur="suma1();" autocomplete="off" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="recompensas1" id="recompensas1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="recompensas2" id="recompensas2" class="form-control" value="N/A" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" style="border-style: none; background: transparent; color: #000;"></td></tr>';
      }
      else
      {
        salida += '<tr><td height="35"><b>SALDO EN BANCO</b></td><td align="right" height="35"><input type="text" name="saldo" id="saldo" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="saldo1" id="saldo1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><center><b>JUSTIFICACION SALDO EN BANCOS</b></center></td></tr>';
        salida += '<tr><td height="35">Gastos en Actividades</td><td align="right" height="35"><input type="text" name="gastos" id="gastos" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="gastos1" id="gastos1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="gastos2" id="gastos2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
        salida += '<tr><td height="35">Pago de Informaciones</td><td align="right" height="35"><input type="text" name="pagos" id="pagos" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="pagos1" id="pagos1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="pagos2" id="pagos2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
        salida += '<tr><td height="35">Pago de Recompensas</td><td align="right" height="35"><input type="text" name="recompensas" id="recompensas" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="recompensas1" id="recompensas1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="recompensas2" id="recompensas2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
        if (tp_admin == "7")
        {
          salida += '<tr><td height="35"><b>OBSERVACIONES:</b></td><td height="35" colspan="5"><textarea name="nota" id="nota" class="form-control" rows="4" style="border-style: none; background: transparent; color: #000;" /></td></tr>';
        }
        if (tp_admin == "8")
        {
          salida += '<tr><td height="35"><b>OBSERVACIONES:</b></td><td height="35" colspan="5"><textarea name="nota" id="nota" class="form-control" rows="4" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" /></td></tr>';
        }
      }
      salida += '</table>';
      salida += '<center><input type="hidden" name="pasog" id="pasog" class="c9" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></center>';
      salida += '<center><input type="hidden" name="pasop" id="pasop" class="c9" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></center>';
      salida += '<br><center><input type="button" name="aceptar1" id="aceptar1" value="Continuar"><input type="button" name="aceptar3" id="aceptar3" value="Visualizar"></center>';
      $("#res_unic").append(salida);
      $("#gastos").maskMoney();
      $("#pagos").maskMoney();
      $("#recompensas").maskMoney();
      $("#techo").val(registros.techo);
      $("#saldo").val(saldo);
      $("#saldo1").val(registros.saldo);
      $("#planes").val(registros.planes);
      if ((tp_admin == "7") || (tp_admin == "8"))
      {
        $("#gastos").val(registros.sal_gas);
        $("#pagos").val(registros.sal_pag);
        $("#recompensas").val(registros.sal_rec);
        $("#gastos2").val(registros.jus_gas);
        $("#pagos2").val(registros.jus_pag);
        $("#recompensas2").val(registros.jus_rec);
        $("#nota").val(registros.nota);
      }
      $("#v_blo").val(y);
      $("#aceptar1").button();
      $("#aceptar1").click(pregunta);
      $("#aceptar1").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar3").button();
      $("#aceptar3").click(link);
      $("#aceptar3").hide();
      $("#aceptar3").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      paso_val7();
      suma(valida);
      for(i=1;i<=valida;i++)
      {
        $("#va1_"+i).maskMoney();
        $("#va2_"+i).maskMoney();
      }
      if ((tp_admin == "6") || (tp_admin == "25"))
      {
        $("#aceptar1").hide();
        val_plan();
      }
      if ((tp_admin == "7") && (v_revisa > 0))
      {
        $("#aceptar1").hide();
        $("#nota").prop("disabled",true);
      }
      if (tp_admin == "8")
      {
        if (v_revisa == "0")
        {
          var detalle = "<center><h3>Plan de Inversión Centralizado sin Revisión</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#res_unic").html('');
        }
      }
      $(".pantalla-modal").magnificPopup({
        type: 'iframe',
        preloader: false,
        modal: false
      });
    }
  });
}
function consulta1()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "centra_consu1.php",
    data:
    {
      unidades: $("#unidades").val(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      $("#res_unic").html('');
      var registros = JSON.parse(data);
      var tp_admin = $("#admin").val();
      var valida = registros.total1;
      var techo = registros.techo;
      var planes = registros.planes;
      var v_revisa = registros.v_revisa;
      var v_ordena = registros.v_ordena;
      var v_visto =  registros.v_visto;
      var salida = "";
      salida += "<form name='formu1' method='post'>";
      salida += "<table width='90%' align='center' border='0'><tr><td width='60%'>&nbsp;</td><td width='40%' align='right'><b>Techo Unidad Centralizadora:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='techo' id='techo' class='c7' value='0.00' readonly='readonly' style='border-style: none; background: transparent; color: #000;'><input type='hidden' name='techo1' id='techo1' class='c7' value='0' readonly='readonly'><input type='hidden' name='planes' id='planes' class='c7' readonly='readonly'></td></tr></table><br>";
      salida += "<table width='90%' align='center' border='1'><tr><td width='25%'><center><b>UNIDADES / DEPENDENCIA /<br>SECCION INTELIGENCIA O<br>CONTRAINTELIGENCIA</b></center></td><td width='25%'><center><b>GASTOS EN ACTIVIDADES<br>DE INTELIGENCIA Y<br>CONTRAINTELIGENCIA</b></center></td><td width='25%'><center><b>PAGO DE<br>INFORMACIONES</b></center></td><td width='25%'><center><b>TOTAL</b></center></td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor1 = parseFloat(value.gastos);
        valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor3 = parseFloat(value.pagos);
        valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor5 = parseFloat(value.total);
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly">'+value.sigla+'</td><td align="right"><input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right"><input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td></tr>';
        y++;
      });
      salida += '<tr><td><b>TOTAL NECESIDADES</b></td><td align="right" height="25"><input type="text" name="total1" id="total1" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp1" id="totalp1" class="c7" value="0" readonly="readonly"></td><td align="right"><input type="text" name="total2" id="total2" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp2" id="totalp2" class="c7" value="0" readonly="readonly"></td><td align="right"><input type="text" name="total3" id="total3" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp3" id="totalp3" class="c7" value="0" readonly="readonly"></td></tr>';
      salida += '</table>';
      salida += '<br><center><input type="button" name="aceptar2" id="aceptar2" value="Visto Bueno"><input type="button" name="aceptar4" id="aceptar4" value="Visualizar"></center>';
      $("#res_unic").append(salida);
      $("#techo").val(registros.techo);
      $("#aceptar2").button();
      $("#aceptar2").click(visto);
      $("#aceptar2").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar4").button();
      $("#aceptar4").click(link);
      $("#aceptar4").hide();
      $("#aceptar4").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      paso_val7();
      suma(valida);
      if (tp_admin == "9")
      {
        if (v_ordena == "0")
        {
          var detalle = "<center><h3>Plan de Inversión Centralizado sin Revisión</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          $("#res_unic").html('');
        }
        else
        {
          if (valida == "0")
          {
            $("#aceptar2").hide();
            var detalle = "<center><h3>Sin Pendientes por Visto Bueno</h3></center>";
            $("#dialogo").html(detalle);
            $("#dialogo").dialog("open");
            $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
          }
        }
      }
    }
  });
}
function consulta2()
{
  var tp_admin = $("#admin").val();
  var nunusuario = $("#nunusuario").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "centra_consu3.php",
    data:
    {
      unidades: $("#unidades").val(),
      unidades1: $("#unidades1").val(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      $("#res_unic").html('');
      var registros = JSON.parse(data);
      var valida = registros.total1;
      var comando = registros.comando;
      var revisa = registros.revisa;
      revisa = parseFloat(revisa);
      var ordena = registros.ordena;
      ordena = parseFloat(ordena);
      var techo = registros.techo;
      var saldo = registros.saldo;
      if (saldo == undefined)
      {
        saldo = "0.00";
      }
      saldo = parseFloat(saldo);
      saldo = saldo.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var salida = "";
      salida += "<form name='formu1' method='post'>";
      salida += "<table width='95%' align='center' border='0'><tr><td width='60%'>&nbsp;</td><td width='40%' align='right'><b>Techo Unidad Centralizadora:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='techo' id='techo' class='c7' value='0.00' readonly='readonly' style='border-style: none; background: transparent; color: #000;'><input type='hidden' name='techo1' id='techo1' class='c7' value='0' readonly='readonly'><input type='hidden' name='planes' id='planes' class='c7' readonly='readonly'></td></tr></table><br>";
      salida += "<table width='95%' align='center' border='1'><tr><td width='25%' height='60' bgcolor='#cccccc'><center><b>UNIDADES / DEPENDENCIA /<br>SECCION INTELIGENCIA O<br>CONTRAINTELIGENCIA</b></center></td><td width='20%' height='60' bgcolor='#cccccc'><center><b>GASTOS EN ACTIVIDADES<br>DE INTELIGENCIA Y<br>CONTRAINTELIGENCIA</b></center></td><td width='20%' height='60' bgcolor='#cccccc'><center><b>PAGO DE<br>INFORMACIONES</b></center></td><td width='25%' height='60' bgcolor='#cccccc'><center><b>TOTAL</b></center></td><td width='5%' height='60' bgcolor='#cccccc'>&nbsp;</td><td width='5%' height='60' bgcolor='#cccccc'>&nbsp;</td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor1 = parseFloat(value.gastos);
        valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor3 = parseFloat(value.pagos);
        valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor5 = parseFloat(value.total);
        if (isNaN(valor5))
        {
          valor5 = 0;
        }
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        if ((tp_admin == "10") || (tp_admin == "25"))
        {
          if (index == "0")
          {
            salida += '<tr><td height="35">'+value.sigla+'</td><td height="35"></td><td height="35"></td><td height="35"></td><td height="35"></td><td height="35"></td></tr>';
          }
          else
          {
            salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly">'+value.sigla+'</td><td align="right"><input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right"><input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td>';
            if (index == "1")
            {
							if (value.conso1 == "1")
							{
								salida += '<td height="35"><center><a href="#" onclick="link2('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Plan / Solicitud"></a></center></td>';
                salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
							}
							else
							{
								salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
							}
            }
            else
            {
              if (value.conso == "0")
              {
                salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
              }
              else
              {
                if (value.conso1 == "1")
                {
                  salida += '<td height="35"><center><a href="#" onclick="link2('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Plan / Solicitud"></a></center></td>';
                  salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
                }
                else
                {
                  salida += '<td height="35"><center><a href="#" onclick="link1('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Consolidado"></a></center></td>';
                  salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
                }
              }
            }
          }
        }
        else
        {
          salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly">'+value.sigla+'</td><td align="right" height="35">';
          if (index == "0")
          {
          }
          else
          {
            if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
            {
            }
            else
            {
              if (tp_admin == "12")
              {
              }
              else
              {
                if (valor2 == "0.00")
                {
                  salida += '&nbsp;&nbsp;&nbsp;';
                }
                else
                {
                  salida += '<a href="#" name="gra_'+y+'" id="gra_'+y+'" onclick="modif2('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor1+','+y+','+1+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
                }
              }
            }
          }
          salida += '<input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" onkeyup="paso_val1('+y+'); totaliza('+y+'); suma('+valida+');"';
          if (index == "0")
          {
          }
          else
          {
            if ((tp_admin == "12") && (index == "1"))
            {
              if (ordena > 0)
              {
                salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
              }
              else
              {
                // Si es division - usuario JEM
                if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
                {
                }
                else
                {
                  if (tp_admin == "12")
                  {
                    salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
                  }
                }
              }
            }
            else
            {
              salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
            }
          }
          salida += '><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right" height="35">';
          if (index == "0")
          {
          }
          else
          {
            if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
            {
            }
            else
            {
              if (tp_admin == "12")
              {
              }
              else
              {
                if (valor4 == "0.00")
                {
                  salida += '&nbsp;&nbsp;&nbsp;';
                }
                else
                {
                  salida += '<a href="#" name="gra1_'+y+'" id="gra1_'+y+'" onclick="modif2('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor3+','+y+','+2+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
                }
              }
            }
          }
          salida += '<input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onkeyup="paso_val2('+y+'); totaliza('+y+'); suma('+valida+');"';
          if (index == "0")
          {
          }
          else
          {
            if ((tp_admin == "12") && (index == "1"))
            {
              if (ordena > 0)
              {
                salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
              }
              else
              {
                // Si es division - usuario JEM
                if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
                {
                }
                else
                {
                  if (tp_admin == "12")
                  {
                    salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
                  }
                }
              }
            }
            else
            {
              salida += ' onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
            }
          }
          salida += '><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right" height="35"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td>';
          if ((index == "0") || (index == "1"))
          {
            if (value.conso1 == "1")
            {
              salida += '<td><center><a href="#" onclick="link2('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Plan / Solicitud"></a></center></td>';
              salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
            }
            else
            {
              salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
            }
          }
          else
          {
            if (value.conso == "0")
            {
              salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
            }
            else
            {
              if (value.conso1 == "1")
              {
                salida += '<td><center><a href="#" onclick="link2('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Plan / Solicitud"></a></center></td>';
                salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
              }
              else
              {
                salida += '<td><center><a href="#" onclick="link1('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Consolidado"></a></center></td>';
                salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
              }
            }
          }
        }
        y++;
      });
      // Total
      salida += '<tr><td height="35" bgcolor="#cccccc"><b>TOTAL NECESIDADES</b></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total1" id="total1" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp1" id="totalp1" class="c7" value="0" readonly="readonly"></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total2" id="total2" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp2" id="totalp2" class="c7" value="0" readonly="readonly"></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total3" id="total3" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp3" id="totalp3" class="c7" value="0" readonly="readonly"></td><td height="35" bgcolor="#cccccc">&nbsp;</td><td height="35" bgcolor="#cccccc">&nbsp;</td></tr>';
      salida += '<tr><td colspan="6" height="35">&nbsp;</td></tr>';
      // Saldos
      if ((tp_admin == "10") || (tp_admin == "25"))
      {
        salida += '<tr><td height="35"><b>SALDO EN BANCO</b></td><td align="right" height="35"><input type="text" name="saldo" id="saldo" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="saldo1" id="saldo1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><center><b>JUSTIFICACION SALDO EN BANCOS</b></center></td></tr>';
        salida += '<tr><td>Gastos en Actividades</td><td align="right" height="35"><input type="text" name="gastos" id="gastos" class="c7" value="0.00" onkeyup="paso_val8();" onblur="suma1();" autocomplete="off" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="gastos1" id="gastos1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><input type="text" name="gastos2" id="gastos2" class="form-control" value="N/A" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" style="border-style: none; background: transparent; color: #000;"></td></tr>';
        salida += '<tr><td>Pago de Informaciones</td><td align="right" height="35"><input type="text" name="pagos" id="pagos" class="c7" value="0.00" onkeyup="paso_val9();" onblur="suma1();" autocomplete="off" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="pagos1" id="pagos1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><input type="text" name="pagos2" id="pagos2" class="form-control" value="N/A" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" style="border-style: none; background: transparent; color: #000;"></td></tr>';
        salida += '<tr><td>Pago de Recompensas</td><td align="right" height="35"><input type="text" name="recompensas" id="recompensas" class="c7" value="0.00" onkeyup="paso_val10();" onblur="suma1();" autocomplete="off" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="recompensas1" id="recompensas1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><input type="text" name="recompensas2" id="recompensas2" class="form-control" value="N/A" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" autocomplete="off" style="border-style: none; background: transparent; color: #000;"></td></tr>';
      }
      else
      {       
        salida += '<tr><td height="35"><b>SALDO EN BANCO</b></td><td align="right" height="35"><input type="text" name="saldo" id="saldo" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="saldo1" id="saldo1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><center><b>JUSTIFICACION SALDO EN BANCOS</b></center></td></tr>';
        salida += '<tr><td height="35">Gastos en Actividades</td><td align="right" height="35"><input type="text" name="gastos" id="gastos" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="gastos1" id="gastos1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><input type="text" name="gastos2" id="gastos2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
        salida += '<tr><td height="35">Pago de Informaciones</td><td align="right" height="35"><input type="text" name="pagos" id="pagos" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="pagos1" id="pagos1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><input type="text" name="pagos2" id="pagos2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
        salida += '<tr><td height="35">Pago de Recompensas</td><td align="right" height="35"><input type="text" name="recompensas" id="recompensas" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="recompensas1" id="recompensas1" class="c7" value="0" readonly="readonly"></td><td colspan="4"><input type="text" name="recompensas2" id="recompensas2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
        if (tp_admin == "11")
        {
          salida += '<tr><td height="35"><b>OBSERVACIONES:</b></td><td height="35" colspan="5"><textarea name="nota" id="nota" class="form-control" rows="4" style="border-style: none; background: transparent; color: #000;" /></td></tr>';
        }
        else
        {
          salida += '<tr><td height="35"><b>OBSERVACIONES:</b></td><td height="35" colspan="5"><textarea name="nota" id="nota" class="form-control" rows="4" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" /></td></tr>';
        }
      }
      salida += '</table>';
      salida += '<center><input type="hidden" name="pasog" id="pasog" class="c9" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></center>';
      salida += '<center><input type="hidden" name="pasop" id="pasop" class="c9" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"></center>';
      salida += '<br><center><input type="button" name="aceptar5" id="aceptar5" value="Continuar"><input type="button" name="aceptar6" id="aceptar6" value="Visualizar"></center>';
      $("#res_unic").append(salida);
      $("#gastos").maskMoney();
      $("#pagos").maskMoney();
      $("#recompensas").maskMoney();
      $("#techo").val(registros.techo);
      $("#saldo").val(saldo);
      $("#saldo1").val(registros.saldo);
      if ((tp_admin == "11") || (tp_admin == "12"))
      {
        $("#gastos").val(registros.sal_gas);
        $("#pagos").val(registros.sal_pag);
        $("#recompensas").val(registros.sal_rec);
        $("#gastos2").val(registros.jus_gas);
        $("#pagos2").val(registros.jus_pag);
        $("#recompensas2").val(registros.jus_rec);
        $("#nota").val(registros.nota);

      }
      $("#aceptar5").button();
      $("#aceptar5").click(pregunta);
      $("#aceptar5").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar6").button();
      $("#aceptar6").click(link);
      $("#aceptar6").hide();
      $("#aceptar6").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      paso_val7();
      suma(valida);
      for(i=1;i<=valida;i++)
      {
        $("#va1_"+i).maskMoney();
        $("#va2_"+i).maskMoney();
      }
      if ((tp_admin == "10") || (tp_admin == "25"))
      {
        $("#aceptar5").hide();
        val_plan();
      }
      else
      {
        if (tp_admin == "12")
        {
          if (ordena > 1)
          {
            $("#aceptar5").hide();
            $("#aceptar6").show();
            $("#aceptar6").click();
          }
          else
          {
            $("#aceptar5").show();
            $("#aceptar6").hide();
          }
        }
        else
        {
          if (comando == "1")
          {
            $("#aceptar5").hide();
            $("#aceptar6").show();
            $("#aceptar6").click();
            for (j=1;j<=40;j++)
            {
              $("#gra_"+j).hide();
              $("#gra1_"+j).hide();
            }
            $("#nota").prop("disabled",true);
          }
        }
      }
      if (tp_admin == "11")
      {
        var centraliza = registros.centra;        
        if (centraliza == "0")
        {
          $("#aceptar5").hide();
          var detalle = "<center><h3>Saldos no registrados para el periodo seleccionado</h3></center>";
          $("#dialogo").html(detalle);
          $("#dialogo").dialog("open");
          $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        }
        else
        {
          if (comando == "1")
          {
            $("#aceptar5").hide();
            $("#aceptar6").show();
          }
          else
          {
            $("#aceptar5").show();
            $("#aceptar6").hide();
          }
        }
      }
      $(".pantalla-modal").magnificPopup({
        type: 'iframe',
        preloader: false,
        modal: false
      });
    }
  });
}
function consulta3()
{
  var tp_admin = $("#admin").val();
  var nunusuario = $("#nunusuario").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "centra_consu3.php",
    data:
    {
      unidades: $("#unidades").val(),
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      $("#res_unic").html('');
      var registros = JSON.parse(data);
      var valida = registros.total1;
      var comando = registros.comando;
      var visto = registros.visto;
      visto = parseFloat(visto);
      var techo = registros.techo;
      var saldo = registros.saldo;
      if (saldo == undefined)
      {
        saldo = "0.00";
      }
      saldo = parseFloat(saldo);
      saldo = saldo.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      var salida = "";
      salida += "<form name='formu1' method='post'>";
      salida += "<table width='95%' align='center' border='0'><tr><td width='60%'>&nbsp;</td><td width='40%' align='right'><b>Techo Unidad Centralizadora:</b>&nbsp;&nbsp;&nbsp;<input type='text' name='techo' id='techo' class='c7' value='0.00' readonly='readonly' style='border-style: none; background: transparent; color: #000;'><input type='hidden' name='techo1' id='techo1' class='c7' value='0' readonly='readonly'><input type='hidden' name='planes' id='planes' class='c7' readonly='readonly'></td></tr></table><br>";
      salida += "<table width='95%' align='center' border='1'><tr><td width='25%' height='60' bgcolor='#cccccc'><center><b>UNIDADES / DEPENDENCIA /<br>SECCION INTELIGENCIA O<br>CONTRAINTELIGENCIA</b></center></td><td width='20%' height='60' bgcolor='#cccccc'><center><b>GASTOS EN ACTIVIDADES<br>DE INTELIGENCIA Y<br>CONTRAINTELIGENCIA</b></center></td><td width='20%' height='60' bgcolor='#cccccc'><center><b>PAGO DE<br>INFORMACIONES</b></center></td><td width='25%' height='60' bgcolor='#cccccc'><center><b>TOTAL</b></center></td><td width='5%' height='60' bgcolor='#cccccc'>&nbsp;</td><td width='5%' height='60' bgcolor='#cccccc'>&nbsp;</td></tr>";
      var y = 1;
      $.each(registros.rows, function (index, value)
      {
        valor1 = parseFloat(value.gastos);
        valor2 = valor1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor3 = parseFloat(value.pagos);
        valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        valor5 = parseFloat(value.total);
        valor6 = valor5.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        salida += '<tr><td><input type="hidden" name="uni_'+y+'" id="uni_'+y+'" class="c10" value="'+value.unidad+'" readonly="readonly"><input type="hidden" name="per_'+y+'" id="per_'+y+'" class="c10" value='+value.periodo+' readonly="readonly"><input type="hidden" name="ano_'+y+'" id="ano_'+y+'" class="c10" value='+value.ano+' readonly="readonly"><input type="hidden" name="sig_'+y+'" id="sig_'+y+'" class="c10" value='+value.sigla+' readonly="readonly">'+value.sigla+'</td><td align="right">';
        if ((index == "0") || (index == "1"))
        {
        }
        else
        {
          if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
          {
          }
          else
          {
            salida += '<a href="#" name="gra_'+y+'" id="gra_'+y+'" onclick="modif2('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor1+','+y+','+1+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="24" height="24" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
          }
        }
        salida += '<input type="text" name="va1_'+y+'" id="va1_'+y+'" class="c7" value="'+valor2+'" onkeyup="paso_val1('+y+'); totaliza('+y+'); suma('+valida+');" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
        salida += '><input type="hidden" name="vap1_'+y+'" id="vap1_'+y+'" class="c7" value="'+value.gastos+'" readonly="readonly"></td><td align="right">';
        if ((index == "0") || (index == "1"))
        {
        }
        else
        {
          if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
          {
          }
          else
          {
          	if (valor4 == "0.00")
          	{
          		salida += "&nbsp;";
          	}
          	else
          	{
            	salida += '<a href="#" name="gra1_'+y+'" id="gra1_'+y+'" onclick="modif2('+value.unidad+','+value.periodo+','+value.ano+','+index+','+valor3+','+y+','+2+','+valida+')"><img src="imagenes/editar.png" title="Modificar Valores" width="24" height="24" border="0" align="absmiddle"></a>&nbsp;&nbsp;&nbsp;';
            }
          }
        }
        salida += '<input type="text" name="va2_'+y+'" id="va2_'+y+'" class="c7" value="'+valor4+'" onkeyup="paso_val2('+y+'); totaliza('+y+'); suma('+valida+');" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"';
        salida += '><input type="hidden" name="vap2_'+y+'" id="vap2_'+y+'" class="c7" value="'+value.pagos+'" readonly="readonly"></td><td align="right"><input type="text" name="va3_'+y+'" id="va3_'+y+'" class="c7" value="'+valor6+'" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="vap3_'+y+'" id="vap3_'+y+'" class="c7" value="'+value.total+'" readonly="readonly"></td>';
        if ((index == "0") || (index == "1"))
        {
          salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
        }
        else
        {
          if (value.conso == "0")
          {
            salida += '<td height="35">&nbsp;</td><td height="35">&nbsp;</td></tr>';
          }
          else
          {
            if (value.conso1 == "1")
            {
              salida += '<td height="35"><center><a href="#" onclick="link2('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Plan / Solicitud"></a></center></td>';
              salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
            }
            else
            {
              salida += '<td height="35"><center><a href="#" onclick="link1('+value.conso+')"><img src="imagenes/pdf.png" border="0" title="Visualizar Consolidado"></a></center></td>';
              salida += '<td><center><a href="./archivos/index1.php?ano='+value.ano+'&conse='+value.conso+'" class="pantalla-modal"><img src="imagenes/clip.png" border="0" title="Visualizar Anexos"></a></center></td></tr>';
            }
          }
        }
        y++;
      });
      // Total
      salida += '<tr><td height="35" bgcolor="#cccccc"><b>TOTAL NECESIDADES</b></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total1" id="total1" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp1" id="totalp1" class="c7" value="0" readonly="readonly"></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total2" id="total2" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp2" id="totalp2" class="c7" value="0" readonly="readonly"></td><td align="right" height="35" bgcolor="#cccccc"><input type="text" name="total3" id="total3" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="totalp3" id="totalp3" class="c7" value="0" readonly="readonly"></td><td height="35" bgcolor="#cccccc">&nbsp;</td><td height="35" bgcolor="#cccccc">&nbsp;</td></tr>';
      salida += '<tr><td colspan="6" height="35">&nbsp;</td></tr>';
      salida += '<tr><td height="35"><b>SALDO EN BANCO</b></td><td align="right" height="25"><input type="text" name="saldo" id="saldo" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="saldo1" id="saldo1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><center><b>JUSTIFICACION SALDO EN BANCOS</b></center></td></tr>';
      salida += '<tr><td height="35">Gastos en Actividades</td><td align="right" height="35"><input type="text" name="gastos" id="gastos" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="gastos1" id="gastos1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="gastos2" id="gastos2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
      salida += '<tr><td height="35">Pago de Informaciones</td><td align="right" height="35"><input type="text" name="pagos" id="pagos" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="pagos1" id="pagos1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="pagos2" id="pagos2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
      salida += '<tr><td height="35">Pago de Recompensas</td><td align="right" height="35"><input type="text" name="recompensas" id="recompensas" class="c7" value="0.00" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;"><input type="hidden" name="recompensas1" id="recompensas1" class="c7" value="0" readonly="readonly"></td><td colspan="4" height="35"><input type="text" name="recompensas2" id="recompensas2" class="form-control" onfocus="blur();" readonly="readonly" style="border-style: none; background: transparent; color: #000;" maxlength="100" autocomplete="off"></td></tr>';
      salida += '<tr><td height="35"><b>OBSERVACIONES:</b></td><td height="35" colspan="5"><textarea name="nota" id="nota" rows="4" class="form-control" style="border-style: none; background: transparent; color: #000;" /></td></tr>';
      salida += '</table>';
      salida += '<br><center><input type="button" name="aceptar5" id="aceptar5" value="Autorizar"><input type="button" name="aceptar6" id="aceptar6" value="Visualizar"></center>';
      $("#res_unic").append(salida);
      $("#gastos").maskMoney();
      $("#pagos").maskMoney();
      $("#recompensas").maskMoney();
      $("#techo").val(registros.techo);
      $("#saldo").val(saldo);
      $("#saldo1").val(registros.saldo);
      $("#gastos").val(registros.sal_gas);
      $("#pagos").val(registros.sal_pag);
      $("#recompensas").val(registros.sal_rec);
      $("#gastos2").val(registros.jus_gas);
      $("#pagos2").val(registros.jus_pag);
      $("#recompensas2").val(registros.jus_rec);
      $("#nota").val(registros.nota);
      $("#aceptar5").button();
      $("#aceptar5").click(pregunta);
      $("#aceptar5").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      $("#aceptar6").button();
      $("#aceptar6").click(link);
      $("#aceptar6").hide();
      $("#aceptar6").css({ width: '200px', 'padding-top': '8px', 'padding-bottom': '8px' });
      paso_val7();
      suma(valida);
      if (visto > 1)
      {
        $("#aceptar5").hide();
        $("#aceptar6").show();
        $("#aceptar6").click();
        for (j=1;j<=40;j++)
        {
          $("#gra_"+j).hide();
          $("#gra1_"+j).hide();
        }
      }
      else
      {
        $("#aceptar5").show();
        $("#aceptar6").hide();
      }
      $(".pantalla-modal").magnificPopup({
        type: 'iframe',
        preloader: false,
        modal: false
      });
    }
  });
}
function modif(valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor4 = parseFloat(valor4);
  valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores2.php",
    data:
    {
      unidad: valor,
      periodo: valor1,
      ano: valor2,
      index: valor3,
      valor: valor4
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
      $("#val_modi").html('');
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<table width='90%' align='center' border='0'>";
      if (valor6 == "1")
      {
        var var_cmp = registros.compas.split('|');
        var var_con = registros.conses.split('|');
        var var_mis = registros.mision.split('|');
        var var_val = registros.valorm.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_cmp[j];
          var var2 = var_con[j];
          var var3 = var_mis[j];
          var var4 = var_val[j];
          var var5 = valor5+"|"+valor6+"|"+valor7+"|"+valor+"|"+var3;
          var var6 = j+1;          
          salida += '<tr><td>'+var1+'</td><td>Misión: '+var3+'</td><td align="right">'+var4+'</td><td align="right"><input type="hidden" name="m_'+j+'" id="m_'+j+'" class="c10" value="'+var6+'"><input type="hidden" name="k_'+j+'" id="k_'+j+'" class="c10" value="'+var3+'"><input type="hidden" name="p_'+j+'" id="p_'+j+'" class="c10" value="'+var2+'"><input type="text" name="v_'+j+'" id="v_'+j+'" class="c7" value="'+var4+'" onkeyup="suma2('+var_con1+');"></td></tr>';
        }
        salida += '<tr><td colspan="3">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly"></td></tr>';
        salida += '</table>';
        salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+var5+'">';
        $("#val_modi").append(salida);
        for (var j=0; j<var_con1-1; j++)
        {
          $("#v_"+j).maskMoney();
        }
      }
      else
      {
        var var_cmp = registros.compan.split('|');
        var var_con = registros.fuente.split('|');
        var var_mis = registros.cedula.split('|');
        var var_val = registros.valorc.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_cmp[j];
          var var2 = var_con[j];
          var var3 = var_mis[j];
          var var4 = var_val[j];
          var var5 = valor5+"|"+valor6+"|"+valor7+"|"+valor+"|"+var3;
          var var6 = j+1;
          salida += '<tr><td>'+var1+'</td><td>'+var3+'</td><td align="right">'+var4+'</td><td align="right"><input type="hidden" name="m_'+j+'" id="m_'+j+'" class="c10" value="'+var6+'"><input type="hidden" name="k_'+j+'" id="k_'+j+'" class="c10" value="'+var3+'"><input type="hidden" name="p_'+j+'" id="p_'+j+'" class="c10" value="'+var2+'"><input type="text" name="v_'+j+'" id="v_'+j+'" class="c7" value="'+var4+'" onkeyup="suma2('+var_con1+');"></td></tr>';
        }
        salida += '<tr><td colspan="3">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly"></td></tr>';
        salida += '</table>';
        salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+var5+'">';
        $("#val_modi").append(salida);
        for (var j=0; j<var_con1-1; j++)
        {
          $("#v_"+j).maskMoney();
        }

      }
      $("#dialogo2").dialog("open");
    }
  });
}
function modif1(valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor4 = parseFloat(valor4);
  valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores3.php",
    data:
    {
      unidad: valor,
      periodo: valor1,
      ano: valor2,
      index: valor3,
      valor: valor4
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
      $("#val_modi").html('');
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<table width='90%' align='center' border='0'>";
      if (valor6 == "1")
      {
        var var_cmp = registros.compas.split('|');
        var var_con = registros.conses.split('|');
        var var_mis = registros.mision.split('|');
        var var_val = registros.valorm.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_cmp[j];
          var var2 = var_con[j];
          var var3 = var_mis[j];
          var var4 = var_val[j];
          var var5 = valor5+"|"+valor6+"|"+valor7+"|"+valor+"|"+var3;
          var var6 = j+1;
          salida += '<tr><td>'+var1+'</td><td>Misión: '+var3+'</td><td align="right">'+var4+'</td><td align="right"><input type="hidden" name="m_'+j+'" id="m_'+j+'" class="c10" value="'+var6+'"><input type="hidden" name="k_'+j+'" id="k_'+j+'" class="c10" value="'+var3+'"><input type="hidden" name="p_'+j+'" id="p_'+j+'" class="c10" value="'+var2+'"><input type="text" name="v_'+j+'" id="v_'+j+'" class="c7" value="'+var4+'" onkeyup="suma2('+var_con1+');"></td></tr>';
        }
        salida += '<tr><td colspan="3">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly"></td></tr>';
        salida += '</table>';
        salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+var5+'">';
        $("#val_modi").append(salida);
        for (var j=0; j<var_con1-1; j++)
        {
          $("#v_"+j).maskMoney();
        }
      }
      else
      {
        var var_cmp = registros.compan.split('|');
        var var_con = registros.fuente.split('|');
        var var_mis = registros.cedula.split('|');
        var var_val = registros.valorc.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_cmp[j];
          var var2 = var_con[j];
          var var3 = var_mis[j];
          var var4 = var_val[j];
          var var5 = valor5+"|"+valor6+"|"+valor7+"|"+valor+"|"+var3;
          var var6 = j+1;
          salida += '<tr><td>'+var1+'</td><td>'+var3+'</td><td align="right">'+var4+'</td><td align="right"><input type="hidden" name="m_'+j+'" id="m_'+j+'" class="c10" value="'+var6+'"><input type="hidden" name="k_'+j+'" id="k_'+j+'" class="c10" value="'+var3+'"><input type="hidden" name="p_'+j+'" id="p_'+j+'" class="c10" value="'+var2+'"><input type="text" name="v_'+j+'" id="v_'+j+'" class="c7" value="'+var4+'" onkeyup="suma2('+var_con1+');"></td></tr>';
        }
        salida += '<tr><td colspan="3">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly"></td></tr>';
        salida += '</table>';
        salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+var5+'">';
        $("#val_modi").append(salida);
        for (var j=0; j<var_con1-1; j++)
        {
          $("#v_"+j).maskMoney();
        }

      }
      $("#dialogo2").dialog("open");
    }
  });
}
function modif2(valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7)
{
  var valor, valor1, valor2, valor3, valor4, valor5, valor6, valor7;
  valor4 = parseFloat(valor4);
  valor4 = valor4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_valores4.php",
    data:
    {
      unidad: valor,
      periodo: valor1,
      ano: valor2,
      index: valor3,
      valor: valor4
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
      $("#val_modi").html('');
      var registros = JSON.parse(data);
      var salida = "";
      salida += "<table width='90%' align='center' border='0'>";
      if (valor6 == "1")
      {
        var var_cmp = registros.compas.split('|');
        var var_con = registros.conses.split('|');
        var var_mis = registros.mision.split('|');
        var var_val = registros.valorm.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_cmp[j];
          var var2 = var_con[j];
          var var3 = var_mis[j];
          var var4 = var_val[j];
          var var5 = valor5+"|"+valor6+"|"+valor7+"|"+valor+"|"+var3;
          var var6 = j+1;
          salida += '<tr><td>'+var1+'</td><td>Misión: '+var3+'</td><td align="right">'+var4+'</td><td align="right"><input type="hidden" name="m_'+j+'" id="m_'+j+'" class="c10" value="'+var6+'"><input type="hidden" name="k_'+j+'" id="k_'+j+'" class="c10" value="'+var3+'"><input type="hidden" name="p_'+j+'" id="p_'+j+'" class="c10" value="'+var2+'"><input type="text" name="v_'+j+'" id="v_'+j+'" class="c7" value="'+var4+'" onkeyup="suma2('+var_con1+');" onfocus="blur();" readonly="readonly"></td></tr>';
          var var_dis = registros.discri.split('|');
          var var_con2 = var_dis.length;
        	for (var k=0; k<var_con2-1; k++)
        	{
        		var var7 = var_dis[k];
        		var var_det = var7.split('¬');
        		var var8 = var_det[0];
        		var var9 = var_det[1];
        		var var10 = var_det[2];
        		var var11 = var_det[3];
        		var var12 = var_det[4];
            var var13 = var_det[5];
	          salida += '<tr><td>&nbsp;</td><td colspan="2">'+var10+'</td><td class="espacio1" align="right"><input type="text" name="w_'+j+'_'+k+'" id="w_'+j+'_'+k+'" class="c7" value="'+var12+'" onkeyup="suma3('+j+','+var_con1+');"';
	          if (var11 == "")
	          {
	          }
	          else
	          {
	          	salida += ' onfocus="blur();" readonly="readonly"';
	          }
	          salida += '><input type="hidden" name="y_'+j+'_'+k+'" id="y_'+j+'_'+k+'" class="c10" value="'+var11+'" onfocus="blur();" readonly="readonly"><input type="hidden" name="y1_'+j+'_'+k+'" id="y1_'+j+'_'+k+'" class="c10" value="'+var8+'" onfocus="blur();" readonly="readonly"><input type="hidden" name="y2_'+j+'_'+k+'" id="y2_'+j+'_'+k+'" class="c10" value="'+var9+'" onfocus="blur();" readonly="readonly"></td></tr>';
					}
        }
        salida += '<tr><td colspan="3">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly"></td></tr>';
        salida += '</table>';
        salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+var5+'">';
        $("#val_modi").append(salida);
        for (var j=0; j<var_con1-1; j++)
        {
          $("#v_"+j).maskMoney();
	        for (var k=0; k<var_con2-1; k++)
	        {
	          $("#w_"+j+"_"+k).maskMoney();
            var vv1 = $("#y_"+j+"_"+k).val();
            if (vv1 == "")
            {
            }
            else
            {
              $("#w_"+j+"_"+k).css("background-color", "#f18973");
            }
        	}
        }
      }
      else
      {
        var var_cmp = registros.compan.split('|');
        var var_con = registros.fuente.split('|');
        var var_mis = registros.cedula.split('|');
        var var_val = registros.valorc.split('|');
        var var_con1 = var_con.length;
        for (var j=0; j<var_con1-1; j++)
        {
          var var1 = var_cmp[j];
          var var2 = var_con[j];
          var var3 = var_mis[j];
          var var4 = var_val[j];
          var var5 = valor5+"|"+valor6+"|"+valor7+"|"+valor+"|"+var3;
          var var6 = j+1;
          salida += '<tr><td>'+var1+'</td><td>'+var3+'</td><td align="right">'+var4+'</td><td align="right"><input type="hidden" name="m_'+j+'" id="m_'+j+'" class="c10" value="'+var6+'"><input type="hidden" name="k_'+j+'" id="k_'+j+'" class="c10" value="'+var3+'"><input type="hidden" name="p_'+j+'" id="p_'+j+'" class="c10" value="'+var2+'"><input type="text" name="v_'+j+'" id="v_'+j+'" class="c7" value="'+var4+'" onkeyup="suma2('+var_con1+');"></td></tr>';
        }
        salida += '<tr><td colspan="3">&nbsp;</td><td align="right"><input type="text" name="v_tota" id="v_tota" class="c7" value="'+valor4+'" onfocus="blur();" readonly="readonly"></td></tr>';
        salida += '</table>';
        salida += '<input type="hidden" name="val_paso" id="val_paso" class="c7" value="'+var5+'">';
        $("#val_modi").append(salida);
        for (var j=0; j<var_con1-1; j++)
        {
          $("#v_"+j).maskMoney();
        }
      }
      $("#dialogo2").dialog("open");
      $("#dialogo2").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
  });
}
function pregunta()
{
  var detalle = "<center><h3>Esta seguro de continuar ?</h3></center>";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
  $("#dialogo1").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
}
// Se convierte el valor capturado en moneda para sumarlo en totales
function paso_val1(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('va1_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap1_"+valor).val(valor1);
}
function paso_val2(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('va2_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap2_"+valor).val(valor1);
}
function paso_val3()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('total1').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#totalp1").val(valor1);
}
function paso_val4()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('total2').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#totalp2").val(valor1);
}
function paso_val5()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('total3').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#totalp3").val(valor1);
}
function paso_val6(valor)
{
  var valor;
  var valor1;
  valor1 = document.getElementById('va3_'+valor).value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#vap3_"+valor).val(valor1);
}
function paso_val7()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('techo').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#techo1").val(valor1);
}
function paso_val8()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('gastos').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#gastos1").val(valor1);
}
function paso_val9()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('pagos').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#pagos1").val(valor1);
}
function paso_val10()
{
  var valor;
  var valor1;
  valor1 = document.getElementById('recompensas').value;
  valor1 = parseFloat(valor1.replace(/,/g,''));
  $("#recompensas1").val(valor1);
}
// Se totaliza por fila
function totaliza(valor)
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  var valor4;
  valor3 = 0;
  valor4 = 0;
  valor1 = document.getElementById('vap1_'+valor).value;
  valor1 = parseFloat(valor1);
  valor2 = document.getElementById('vap2_'+valor).value;
  valor2 = parseFloat(valor2);
  valor3 = valor1+valor2;
  valor4 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#va3_"+valor).val(valor4);
  paso_val6(valor);
}
// Se suman todos los totales
function suma(valor)
{
  var valor;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  var valor4;
  var valor5;
  var valor6;
  valor5 = 0;
  valor6 = 0;
  var valor7;
  var valor8;
  var valor9;
  valor8 = 0;
  valor9 = 0;
  valori = 0;
  var tp_admin = $("#admin").val();
  if ((tp_admin == "6") || (tp_admin == "10") || (tp_admin == "25"))
  {
    valori = 2;
  }
  else
  {
    valori = 1;
  }
  if (tp_admin == "13")
  {
  	valor = valor+1;
  }
  for (i=valori;i<=valor;i++)
  {
    valor1 = $("#vap1_"+i).val();
    valor2 = parseFloat(valor1);
    valor3 = valor3+valor2;
    valor4 = $("#vap2_"+i).val();
    valor5 = parseFloat(valor4);
    valor6 = valor6+valor5;
    valor7 = $("#vap3_"+i).val();
    if (valor7 == ".00")
    {
      valor7 = "0.00";
    }
    valor8 = parseFloat(valor7);
    valor9 = valor9+valor8;
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total1").val(valor3);
  valor6 = valor6.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total2").val(valor6);
  valor9 = valor9.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#total3").val(valor9);
  paso_val3();
  paso_val4();
  paso_val5();
  if ((tp_admin == "7") || (tp_admin == "8"))
  {
    val_techo();
  }
  if ((tp_admin == "11") || (tp_admin == "12"))
  {
    val_techo1();
  }
}
function suma1()
{
  var tp_admin = $("#admin").val();
  var valor, valor1, valor2, valor3, valor4, valor5;
  valor5 = 0;
  valor = document.getElementById('gastos1').value;
  valor = parseFloat(valor);
  valor1 = document.getElementById('pagos1').value;
  valor1 = parseFloat(valor1);
  valor2 = document.getElementById('recompensas1').value;
  valor2 = parseFloat(valor2);
  valor3 = valor+valor1+valor2;
  valor4 = document.getElementById('saldo1').value;
  valor4 = parseFloat(valor4);
  valor5 = valor4-valor3;
  valor5 = parseFloat(valor5);
  if (valor5 == "0")
  {
    if (tp_admin == "6")
    {
      $("#aceptar1").show();
    }
    else
    {
      $("#aceptar5").show(); 
    }
  }
  else
  {
    if (tp_admin == "6")
    {
      $("#aceptar1").hide();
    }
    else
    {
      $("#aceptar5").hide();
    }
  }
}
function suma2(valor)
{
  var valor;
  valor = valor-1;
  var valor1;
  var valor2;
  var valor3;
  valor2 = 0;
  valor3 = 0;
  for (i=0; i<valor; i++)
  {
    valor1 = $("#v_"+i).val();
    valor1 = parseFloat(valor1.replace(/,/g,''));
    valor2 = parseFloat(valor1);
    valor3 = valor3+valor2;
  	if (isNaN(valor3))
    {
      valor3 = "0.00";
      valor3 = parseFloat(valor3);
      $("#v_"+i).val('0.00');
    }
  }
  valor3 = valor3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#v_tota").val(valor3);
}
function suma3(valor, contador)
{
  var valor, contador;
  var total = 0;
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux = document.formu2.elements[i].name;
    if (saux.indexOf('w_'+valor+'_')!=-1)
    {
      valor1 = document.getElementById(saux).value;
      valor1 = parseFloat(valor1.replace(/,/g,''));
      valor2 = parseFloat(valor1);
      total = total+valor2;
    }
  }
  var total1 = total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#v_"+valor).val(total1);
  suma2(contador);
}
function suma_total()
{
  var valor = $("#nunusuario").val();
  valor = parseFloat(valor);
  var valor0 = $("#totalp3").val();
  valor0 = parseFloat(valor0);
  var valor1 = $("#techo1").val();
  valor1 = parseFloat(valor1);
  var valor2 = $("#vap1_1").val();
  valor2 = parseFloat(valor2);
  var valor3 = $("#gastos").val();
  valor3 = parseFloat(valor3.replace(/,/g,''));
  valor3 = parseFloat(valor3);
  var valor4 = valor0+valor3;
  valor4 = parseFloat(valor4);
  var valor5 = (valor1-valor4);
  if (valor5 < 0)
  {
    var detalle = "<center><h3>Valor Superior al Techo de la Unidad Centralizadora</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar1").hide();
  }
  else
  {
    $("#aceptar1").show();
  }
}
function val_techo()
{
  var valor1, valor2, valor3;
  valor3 = 0;
  valor1 = $("#techo1").val();
  valor1 = parseFloat(valor1);
  valor2 = $("#totalp3").val();
  valor2 = parseFloat(valor2);
  valor3 = (valor2-valor1);
  if (valor3 > 0)
  {
    var detalle = "<center><h3>Valor Superior al Techo de la Unidad Centralizadora</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar1").hide();
  }
  else
  {
    $("#aceptar1").show();
  }
  if (valor2 == "0")
  {
    $("#aceptar1").hide();
    $("#aceptar3").show();
  }
  suma_total();
}
function val_techo1()
{
  var valor, valor0, valor1, valor2, valor3, valor4, valor5;
  valor = $("#nunusuario").val();
  valor = parseFloat(valor);
  valor0 = $("#gastos").val();
  valor0 = parseFloat(valor0.replace(/,/g,''));
  valor0 = parseFloat(valor0);
  valor1 = $("#techo1").val();
  valor1 = parseFloat(valor1);
  valor2 = $("#vap3_1").val();
  valor2 = parseFloat(valor2);
  valor3 = $("#totalp3").val();
  valor3 = parseFloat(valor3);
  if (valor > 3)
  {
    valor4 = valor0+valor3;
  }
  else
  {
    valor4 = valor0+valor2;
  }
  valor5 = valor1-valor4;
  if (valor5 < 0)
  {
    var detalle = "<center><h3>Valor Superior al Techo de la Unidad Centralizadora</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
    $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    $("#aceptar5").hide();
  }
  else
  {
    $("#aceptar5").show();
  }
}
function aprueba()
{
  var var1, var2, var3, var4, var5, var6, var7, var8, var9, var10, var11, var12, var13, var14, var15, var16, var17, var18, var19;
  var1 = $("#val_paso").val();
  var2 = $("#v_tota").val();
  var3 = var1.split('|');
  var4 = var3[0];
  var5 = var3[1];
  var6 = var3[2];
  var12 = var3[3];
  var13 = var3[4];
  var7 = $("#pasog").val();
  if (var7 == undefined)
  {
    var7 = "";
  }
  var8 = "";
  var9 = "";
  var10 = "";
  var11 = $("#pasop").val();
  if (var11 == undefined)
  {
    var11 = "";
  }
  var14 = "";
  var15 = "";
  // Ajuste para modificar gasto discriminado
  var16 = ""; 
  var17 = "";
  var18 = "";
  var19 = "";
  for (i=0;i<document.formu2.elements.length;i++)
  {
    saux = document.formu2.elements[i].name;
    if (saux.indexOf('k_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var14 += valor+"|";
    }
    if (saux.indexOf('m_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var15 += valor+"|";
    }
    if (saux.indexOf('p_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var8 += valor+"|";
    }
    if (saux.indexOf('v_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var9 += valor+"|";
    }
    // Ajuste para modificar gasto discriminado
    if (saux.indexOf('w_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var16 += valor+"|";
    }
    if (saux.indexOf('y1_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var17 += valor+"|";
    }
    if (saux.indexOf('y2_')!=-1)
    {
      valor = document.getElementById(saux).value;
      var18 += valor+"|";
    }
  }
  var10 = var12+"#"+var5+"#"+var8+"#"+var9+"#"+var14+"#"+var15+"»";
  var19 = var16+"#"+var17+"#"+var18+"»";
  aprueba1(var10,var5);
  if (var5 == "1")
  {
    var7 += var10;
    $("#pasog").val(var7);
    $("#va1_"+var4).val(var2);
    paso_val1(var4);
    totaliza(var4);
    suma(var6);
    $("#gra_"+var4).hide();
    // Ajuste para modificar gasto discriminado
    var p_paso1 = $("#v_comac").val();
    var p_paso2 = p_paso1+var19;
    $("#v_comac").val(p_paso2);
  }
  else
  {
    var11 += var10;
    $("#pasop").val(var11);
    $("#va2_"+var4).val(var2);
    paso_val2(var4);
    totaliza(var4);
    suma(var6);
    $("#gra1_"+var4).hide(); 
  }
  $("#dialogo2").dialog("close");
}
function aprueba1(valor, valor1)
{
  var valor, valor1;
  var var_ocu = valor.split('«');
  var var_ocu1 = var_ocu.length;
  var z = 0;
  var final = "";
  for (var i=0; i<var_ocu1; i++)
  {
    var paso = var_ocu[i];
    var paso1 = paso.split('#');
    var p_1 = paso1[0];
    var p_2 = paso1[1];
    var p_3 = paso1[2];
    var paso2 = p_3.split('|');
    var p_4 = paso1[3];
    var paso3 = p_4.split('|');
    var p_5 = paso1[4];
    var paso4 = p_5.split('|');
    var p_6 = paso1[5];
    var paso5 = p_6.split('|');
    var paso6 = paso2.length;
    for (var j=0; j<paso6-1; j++)
    {
      final += paso5[j]+"»"+paso4[j]+"»"+paso2[j]+"»"+paso3[j]+"»€";
    }
    var p_7 = paso2[0];
    var p_8 = paso3[0];
    var p_final = p_1+"|"+p_2+"|"+final+"|#";
    var p_paso1 = $("#v_coman").val();
    var p_paso2 = p_paso1+p_final;
    $("#v_coman").val(p_paso2);
  }
}
function graba()
{
  var tp_admin = $("#admin").val();
  var nunusuario = $("#nunusuario").val();
  if ((tp_admin == "11") || (tp_admin == "12") || (tp_admin == "13"))
  {
    var p_uni = $("#uni_1").val();
    $("#v_uni").val(p_uni);
    var p_per = $("#per_1").val();
    $("#v_per").val(p_per);
    var p_ano = $("#ano_1").val();
    $("#v_ano").val(p_ano);
    var p_sig = $("#sig_1").val();
    $("#v_sig").val(p_sig);
    var p_vap1 = $("#vap1_1").val();
    $("#v_gas").val(p_vap1);
    var p_vap2 = $("#vap2_1").val();
    $("#v_pag").val(p_vap2);
    var p_vap3 = $("#vap3_1").val();
    $("#v_tot").val(p_vap3);
    if ((tp_admin == "11") || (tp_admin == "13"))
    {
      if ((nunusuario == "1") || (nunusuario == "2") || (nunusuario == "3"))
      {
      }
      else
      {
        document.getElementById('v_uni1').value = "";
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('uni_')!=-1)
          {
            valor = document.getElementById(saux).value;
            document.getElementById('v_uni1').value = document.getElementById('v_uni1').value+valor+"|";
          }
        }
        document.getElementById('v_sig1').value = "";
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('sig_')!=-1)
          {
            valor = document.getElementById(saux).value;
            document.getElementById('v_sig1').value = document.getElementById('v_sig1').value+valor+"|";
          }
        }
        document.getElementById('v_gas1').value = "";
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('vap1_')!=-1)
          {
            valor = document.getElementById(saux).value;
            document.getElementById('v_gas1').value = document.getElementById('v_gas1').value+valor+"|";
          }
        }
        document.getElementById('v_pag1').value = "";
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('vap2_')!=-1)
          {
            valor = document.getElementById(saux).value;
            document.getElementById('v_pag1').value = document.getElementById('v_pag1').value+valor+"|";
          }
        }
        document.getElementById('v_tot1').value = "";
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux = document.formu1.elements[i].name;
          if (saux.indexOf('vap3_')!=-1)
          {
            valor = document.getElementById(saux).value;
            document.getElementById('v_tot1').value = document.getElementById('v_tot1').value+valor+"|";
          }
        }
      }
    }
  }
  else
  {
    document.getElementById('v_uni').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('uni_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_uni').value = document.getElementById('v_uni').value+valor+"|";
      }
    }
    document.getElementById('v_per').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('per_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_per').value = document.getElementById('v_per').value+valor+"|";
      }
    }
    document.getElementById('v_ano').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('ano_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_ano').value = document.getElementById('v_ano').value+valor+"|";
      }
    }
    document.getElementById('v_sig').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('sig_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_sig').value = document.getElementById('v_sig').value+valor+"|";
      }
    }
    document.getElementById('v_dep').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('dep_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_dep').value = document.getElementById('v_dep').value+valor+"|";
      }
    }
    document.getElementById('v_nde').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('nde_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_nde').value = document.getElementById('v_nde').value+valor+"|";
      }
    }
    document.getElementById('v_uom').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('uom_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_uom').value = document.getElementById('v_uom').value+valor+"|";
      }
    }
    document.getElementById('v_nuo').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('nuo_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_nuo').value = document.getElementById('v_nuo').value+valor+"|";
      }
    }
    document.getElementById('v_gas').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('vap1_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_gas').value = document.getElementById('v_gas').value+valor+"|";
      }
    }
    document.getElementById('v_pag').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('vap2_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_pag').value = document.getElementById('v_pag').value+valor+"|";
      }
    }
    document.getElementById('v_tot').value = "";
    for (i=0;i<document.formu1.elements.length;i++)
    {
      saux = document.formu1.elements[i].name;
      if (saux.indexOf('vap3_')!=-1)
      {
        valor = document.getElementById(saux).value;
        document.getElementById('v_tot').value = document.getElementById('v_tot').value+valor+"|";
      }
    }
  }
  if ((tp_admin == "6") || (tp_admin == "10") || (tp_admin == "25"))
  {
    var salida = true, detalle = '';
  	var v_gastos = $("#gastos2").val();
  	v_gastos = v_gastos.trim().length;
  	if (v_gastos == "0")
  	{
      $("#gastos2").addClass("ui-state-error");
      salida = false;
      alerta("Debe ingresar una justificación del saldo de Gastos");
    }
    else
    {
      $("#gastos2").removeClass("ui-state-error");
    }
  	var v_pagos = $("#pagos2").val();
  	v_pagos = v_pagos.trim().length;
  	if (v_pagos == "0")
  	{
      $("#pagos2").addClass("ui-state-error");
      salida = false;
      alerta("Debe ingresar una justificación del saldo de Informaciones");
    }
    else
    {
      $("#pagos2").removeClass("ui-state-error");
    }
  	var v_reco = $("#recompensas2").val();
  	v_reco = v_reco.trim().length;
  	if (v_reco == "0")
  	{
      $("#recompensas2").addClass("ui-state-error");
      salida = false;
      alerta("Debe ingresar una justificación del saldo de Recompensas");
    }
    else
    {
      $("#recompensas2").removeClass("ui-state-error");
    }
    if (salida == false)
    {
    }
    else
    {
      graba1();
    }
  }
  else
  {
    graba1();
  }
}
function graba1()
{
  var coman = $("#v_coman").val();
  var comac = $("#v_comac").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "coman_grab.php",
    data:
    {
      valores: coman,
      valores1: comac
    }
  });
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "val_grab.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      planes: $("#planes").val(),
      unidades: $("#v_uni").val(),
      periodos: $("#v_per").val(),
      anos: $("#v_ano").val(),
      siglas: $("#v_sig").val(),
      depen: $("#v_dep").val(),
      ndepen: $("#v_nde").val(),
      uom: $("#v_uom").val(),
      nuom: $("#v_nuo").val(),
      gastos: $("#v_gas").val(),
      pagos: $("#v_pag").val(),
      totales: $("#v_tot").val(),
      saldo: $("#saldo").val(),
      gastos1: $("#gastos").val(),
      gastos2: $("#gastos2").val(),
      pagos1: $("#pagos").val(),
      pagos2: $("#pagos2").val(),
      recompensas1: $("#recompensas").val(),
      recompensas2: $("#recompensas2").val(),
      pasog: $("#pasog").val(),
      pasop: $("#pasop").val(),
      unidades3: $("#v_uni1").val(),
      siglas3: $("#v_sig1").val(),
      gastos3: $("#v_gas1").val(),
      pagos3: $("#v_pag1").val(),
      totales3: $("#v_tot1").val(),
      nota: $("#nota").val()
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
      var admin = $("#admin").val();
      var registros = JSON.parse(data);
      var valida, notifica, detalle;
      valida = registros.salida;
      notifica = registros.notifica;
      detalle = "<center><h3>Notificaci&oacute;n Enviada a: "+notifica+"</h3></center>";
      $("#dialogo").html(detalle);
      $("#dialogo").dialog("open");
      $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      if (valida > 0)
      {
        if ((admin == "6") || (admin == "7") || (admin == "8") || (admin == "25"))
        {
          $("#aceptar1").hide();
        }
        if ((admin == "10") || (admin == "11") || (admin == "12") || (admin == "13") || (admin == "25"))
        {
          $("#aceptar5").hide();
          $("#nota").prop("disabled",true);
        }
        if ((admin == "6") || (admin == "10") || (admin == "25"))
        {
          $("#gastos").prop("disabled",true);
          $("#pagos").prop("disabled",true);
          $("#gastos2").prop("disabled",true);
          $("#pagos2").prop("disabled",true);
          $("#recompensas").prop("disabled",true);
          $("#recompensas2").prop("disabled",true);
        }
        if ((admin == "7") || (admin == "8"))
        {
          $("#aceptar3").show();
        }
        if ((admin == "11") || (admin == "12") || (admin == "13"))
        {
          $("#aceptar6").show();
          $("#aceptar6").click();
        }
        for (i=0;i<document.formu1.elements.length;i++)
        {
          saux=document.formu1.elements[i].name;
          if (saux.indexOf('va1_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
          if (saux.indexOf('va2_')!=-1)
          {
            document.getElementById(saux).setAttribute("disabled","disabled");
          }
        }
        for (j=1;j<=40;j++)
        {
          $("#gra_"+j).hide();
          $("#gra1_"+j).hide();
        }
      }
      else
      {
        detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar1").show();
      }
    }
  });
}
function visto()
{
  document.getElementById('v_uni').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('uni_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('v_uni').value=document.getElementById('v_uni').value+valor+"|";
    }
  }
  document.getElementById('v_per').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('per_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('v_per').value=document.getElementById('v_per').value+valor+"|";
    }
  }
  document.getElementById('v_ano').value="";
  for (i=0;i<document.formu1.elements.length;i++)
  {
    saux=document.formu1.elements[i].name;
    if (saux.indexOf('ano_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('v_ano').value=document.getElementById('v_ano').value+valor+"|";
    }
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "val_actu.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
      unidades: $("#v_uni").val(),
      periodos: $("#v_per").val(),
      anos: $("#v_ano").val()
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
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var notifica = registros.notifica;
      if (valida > 0)
      {
        var detalle = "<center><h3>Notificaci&oacute;n Enviada a: "+notifica+"</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar2").hide();
        $("#aceptar4").show();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar1").show();
      }
    }
  });
}
function graba2()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "veri_grab.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
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
      var registros = JSON.parse(data);
      var valida;
      valida = registros.salida;
      if (valida == "1")
      {
        $("#aceptar5").hide();
        $("#aceptar6").show();
        $("#aceptar6").click();
      }
      else
      {
        graba3();
      }
    }
  });
}
function graba3()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "val_grab1.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val(),
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
      var registros = JSON.parse(data);
      var valida = registros.salida;
      if (valida > 0)
      {
        $("#aceptar5").hide();
        $("#aceptar6").show();
        $("#aceptar6").click();
      }
      else
      {
        var detalle = "<center><h3>Error durante la grabación</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
        $("#aceptar5").show();
      }
    }
  });
}
function val_plan()
{
  var tp_admin = $("#admin").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "centra_consu2.php",
    data:
    {
      periodo: $("#periodo").val(),
      ano: $("#ano").val()
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
      var registros = JSON.parse(data);
      var valida = registros.salida;
      var gastos = registros.gastos;
      var pagos = registros.pagos;
      var recompensas = registros.recompensas;
      var gastos1 = registros.gastos1;
      var pagos1 = registros.pagos1;
      var recompensas1 = registros.recompensas1;
      if (valida == "1")
      {
        if ((tp_admin == "6") || (admin == "25"))
        {
          $("#aceptar1").hide();  
        }
        if (tp_admin == "10")
        {
          $("#aceptar5").hide();
          $("#aceptar6").show();
        }
        $("#gastos").prop("disabled",true);
        $("#pagos").prop("disabled",true);
        $("#recompensas").prop("disabled",true);
        $("#gastos2").prop("disabled",true);
        $("#pagos2").prop("disabled",true);
        $("#recompensas2").prop("disabled",true);
        $("#nota").prop("disabled",true);
        $("#gastos").val(gastos);
        $("#pagos").val(pagos);
        $("#recompensas").val(recompensas);
        $("#gastos2").val(gastos1);
        $("#pagos2").val(pagos1);
        $("#recompensas2").val(recompensas1);
        var detalle = "<center><h3>Saldos ya registrados para el periodo seleccionado</h3></center>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#dialogo").closest('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
      }
    }
  });
}
function link()
{
  var unidades, periodo, ano, link;
  unidades = $("#unidades").val();
  periodo = $("#periodo").val();
  ano = $("#ano").val();
  link = "unidades="+unidades+"&periodo="+periodo+"&ano="+ano;
  var url = "./fpdf/637.php?"+link;
  window.open(url, '_blank');
}
function link1(valor)
{
  var valor;
  var ano = $("#ano").val();
  if (valor == "0")
  {
    var detale;
    detalle = "<center><h3>Consolidado No Encontrado en la Base de Datos</h3></center>";
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
    var url = "./fpdf/638_2.php?conse="+valor+"&ano="+ano;
    window.open(url, '_blank');
  }
}
function link2(valor)
{
  var valor;
  var ano = $("#ano").val();
  var url = "./fpdf/638.php?conse="+valor+"&ano="+ano;
  window.open(url, '_blank');
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
// 10/08/2023 - Ajuste de cambio de sigla validando la fecha actual
// 05/07/2024 - Ajuste modificar observaciones desde CDO
// 28/01/2025 - Ajuste primer registro tabla desde division
// 30/01/2025 - Ajuste nombres gastos
?>