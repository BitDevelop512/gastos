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
  $verifica = time();
  $alea = strtoupper(md5($verifica));
  $alea = substr($alea,0,5);
  $pregunta = "SELECT unidad,dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
  $cur = odbc_exec($conexion, $pregunta);
  $n_unidad = odbc_result($cur,1);
  $n_dependencia = odbc_result($cur,2);
  $pregunta1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND unic='1'";
  $cur1 = odbc_exec($conexion, $pregunta1);
  $n_unidad1 = odbc_result($cur1,1);
?>
<html lang="es">
<head>
<?php
include('encabezado.php');
?>
</head>
<body>
<?php
include('titulo.php');
?>
<div id="tabs">
<ul>
	<li><a href="#tabs-1">Registro de Recompensas</a></li>
  	<li><a href="#tabs-2">Consulta de Registros</a></li>
</ul>
<div id="tabs-1">
	<form name="formu" method="post">
	  <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="20%" height="20" valign="bottom">
	            N&uacute;mero
	        </td>
	      	<td width="20%" height="20" valign="bottom">
	            Oficio de Solicitud
	        </td>
	      	<td width="20%" height="20" valign="bottom">
	      		Fecha Oficio
	        </td>
	      	<td width="20%" height="20" valign="bottom">
	            HR Inicio Tr&aacute;mite
	        </td>
	      	<td width="20%" height="20" valign="bottom">
	            Fecha HR Inicio Tr&aacute;mite
	        </td>
	    </tr>
	    <tr>
	      	<td>
	      		<input type="hidden" name="n_unidad" id="n_unidad" class="c2" value="<?php echo $uni_usuario; ?>" readonly="readonly">
	      		<input type="hidden" name="n_unidad1" id="n_unidad1" class="c2" value="<?php echo $n_unidad1; ?>" readonly="readonly">
	        	<input type="text" name="conse" id="conse" class="c2" value="0" readonly="readonly" tabindex="1">
	        </td>
	        <td>
	            <input type="text" name="oficio" id="oficio" class="c2" value="0" tabindex="2">  
	        </td>
	      	<td>
	      		<input type="text" name="fecha" id="fecha" class="c1" placeholder="yy/mm/dd" readonly="readonly" tabindex="3">
	        </td>
	      	<td>
	        	<input type="text" name="registro" id="registro" class="c2" value="0" tabindex="4">  
	        </td>
	        <td>
	            <input type="text" name="fecha1" id="fecha1" class="c1" placeholder="yy/mm/dd" readonly="readonly" tabindex="5">
	        </td>
	    </tr>
	  </table>
	  <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="25%" height="20" valign="bottom">
	            Unidad / Dependencia / Secci&oacute;n Manej&oacute; Fuente
	        </td>
	      	<td width="25%" height="20" valign="bottom">
	            Unidad que Efectu&oacute; la Operaci&oacute;n
	        </td>
	      	<td width="25%" height="20" valign="bottom">
	            Brigada
	        </td>
	      	<td width="25%" height="20" valign="bottom">
	            Divisi&oacute;n / Comando
	        </td>
	    </tr>
	    <tr>
            <td>
                <input type="text" name="filtro" id="filtro" class="c3" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off"  tabindex="6">
                <?php
                $menu1_1 = odbc_exec($conexion,"SELECT subdependencia,sigla FROM cx_org_sub WHERE tipo='8' ORDER BY sigla");
                $menu1="<select name='unidad' id='unidad' class='lista_sencilla2' tabindex='7'>";
               	$i=1;
                while($i<$row=odbc_fetch_array($menu1_1))
                {
                    $nombre=trim($row['sigla']);
                    $menu1.="\n<option value=$row[subdependencia]>".$nombre."</option>";
                    $i++;
                }
                $menu1.="\n</select>";
                echo $menu1;
                ?>
            </td>
            <td>
                <input type="text" name="filtro1" id="filtro1" class="c3" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off"  tabindex="8">
                <?php
                $menu2_2 = odbc_exec($conexion,"SELECT subdependencia,sigla FROM cx_org_sub WHERE tipo='8' ORDER BY sigla");
                $menu2="<select name='unidad1' id='unidad1' class='lista_sencilla2' tabindex='9'>";
               	$i=1;
                while($i<$row=odbc_fetch_array($menu2_2))
                {
                    $nombre=trim($row['sigla']);
                    $menu2.="\n<option value=$row[subdependencia]>".$nombre."</option>";
                    $i++;
                }
                $menu2.="\n</select>";
                echo $menu2;
                ?>
            </td>
            <td valign="bottom">
                <?php
                $menu3_3 = odbc_exec($conexion,"SELECT dependencia, nombre FROM cx_org_dep ORDER BY nombre");
                $menu3="<select name='brigada' id='brigada' class='lista_sencilla2' tabindex='10'>";
               	$i=1;
                while($i<$row=odbc_fetch_array($menu3_3))
                {
                    $nombre=trim($row['nombre']);
                    $menu3.="\n<option value=$row[dependencia]>".$nombre."</option>";
                    $i++;
                }
                $menu3.="\n</select>";
                echo $menu3;
                ?>
            </td>
            <td valign="bottom">
                <?php
                $menu4_4 = odbc_exec($conexion,"SELECT unidad, nombre FROM cx_org_uni ORDER BY nombre");
                $menu4="<select name='division' id='division' class='lista_sencilla2' tabindex='11'>";
               	$i=1;
                while($i<$row=odbc_fetch_array($menu4_4))
                {
                    $nombre=trim($row['nombre']);
                    $menu4.="\n<option value=$row[unidad]>".$nombre."</option>";
                    $i++;
                }
                $menu4.="\n</select>";
                echo $menu4;
                ?>
            </td>
        </tr>
      </table>
	  <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="70%" height="20" valign="bottom">
	            Sintesis de la Informaci&oacute;n
	        </td>
	      	<td width="30%" height="20" valign="bottom">
	            Valor Solicitado
	        </td>
	    </tr>
	    <tr>
	    	<td valign="top">
	    		<textarea name="sintesis" id="sintesis" rows="5" tabindex="12"></textarea>
	    	</td>
	    	<td valign="top">
			    <input type="text" name="valor" id="valor" class="c12" value="0.00" onkeyup="paso_val();" tabindex="13">
		        <input type="hidden" name="valor1" id="valor1" value="0" tabindex="14">
		        <br>
		        <div class="espacio">
		        Fecha Suministro de la Informaci&oacute;n
		        </div>
		        <input type="text" name="fecha10" id="fecha10" class="c1" placeholder="yy/mm/dd" readonly="readonly" tabindex="15">
	    	</td>
	    </tr>
	  </table>
      <table align="center" width="95%" border="0">
	      	<td width="33%" height="20" valign="bottom">
	            ORDOP
	        </td>
	      	<td width="15%" height="20" valign="bottom">
	            Fecha ORDOP
	        </td>
	      	<td width="25%" height="20" valign="bottom">
	            Orden Fragmentaria
	        </td>
	      	<td width="17%" height="20" valign="bottom">
	            Fecha OFRAG
	        </td>
	      	<td width="10%" height="20" valign="bottom">
	            &nbsp;
	        </td>
	    </tr>
        <tr>
		    <td>
				<input type="text" name="ordop1" id="ordop1" class="c10" onchange="javascript:this.value=this.value.toUpperCase();" onblur="val_ordop();" maxlength="5" tabindex="16" autocomplete="off">
          		<input type="text" name="ordop" id="ordop" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="17" autocomplete="off">
          	</td>
		    <td>
		    	<input type="text" name="fecha7" id="fecha7" class="c1" placeholder="yy/mm/dd" readonly="readonly" tabindex="18">
		    </td>
          	<td>
				<input type="text" name="orden" id="orden" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="19" autocomplete="off">
          	</td>
		    <td>
		    	<input type="text" name="fecha8" id="fecha8" class="c1" placeholder="yy/mm/dd" readonly="readonly" tabindex="20">
		    </td>
		    <td>
		    	&nbsp;
		    </td>
		</tr>
	  </table>
	  <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="30%" height="20" valign="bottom">
	            Sitio / Sector / Lugar
	        </td>
	      	<td width="40%" height="20" valign="bottom">
	            Municipio
	        </td>
	      	<td width="30%" height="20" valign="bottom">
	            Departamento
	        </td>
	    </tr>
	    <tr>
            <td>
				<input type="text" name="sitio" id="sitio" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="100" tabindex="21" autocomplete="off">
            </td>
            <td>
                <input type="text" name="filtro2" id="filtro2" class="c5" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" autocomplete="off"  tabindex="22">
                <?php
                $menu6_6 = odbc_exec($conexion,"SELECT * FROM cx_ctr_ciu ORDER BY nombre");
                $menu6="<select name='municipio' id='municipio' class='lista_sencilla8' tabindex='23'>";
               	$i=1;
                while($i<$row=odbc_fetch_array($menu6_6))
                {
                    $nombre=trim(utf8_encode($row['nombre']));
                    $codigo=$row['codigo']."|".$row['conse'];
                    $menu6.="\n<option value='$codigo'>".$nombre."</option>";
                    $i++;
                }
                $menu6.="\n</select>";
                echo $menu6;
                ?>
            </td>
	    	<td>
                <?php
                $menu5_5 = odbc_exec($conexion,"SELECT * FROM cx_ctr_dep ORDER BY nombre");
                $menu5="<select name='departamento' id='departamento' class='lista_sencilla2' tabindex='24'>";
               	$i=1;
                while($i<$row=odbc_fetch_array($menu5_5))
                {
                    $nombre=trim(utf8_encode($row['nombre']));
                    $menu5.="\n<option value=$row[codigo]>".$nombre."</option>";
                    $i++;
                }
                $menu5.="\n</select>";
                echo $menu5;
                ?>
            </td>
        </tr>
      </table>
	  <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="50%" height="20" valign="bottom">
	            Factor de Amenaza
	        </td>
	      	<td width="50%" height="20" valign="bottom">
	            Estructura
	        </td>
	    </tr>
        <tr>
        	<td>
		        <?php
		        $menu7_7 = odbc_exec($conexion,"SELECT * FROM cx_ctr_fac ORDER BY codigo");
		        $menu7="<select name='factor' id='factor' class='lista_sencilla1' tabindex='25'>";
		        $i=1;
		        $menu7.="\n<option value='- SELECCIONAR -'>- SELECCIONAR -</option>";
		        while($i<$row=odbc_fetch_array($menu7_7))
		        {
		          $nombre=utf8_encode($row['nombre']);
		          $menu7.="\n<option value=$row[codigo]>".$nombre."</option>";
		          $i++;
		        }
		        $menu7.="\n</select>";
		        echo $menu7;
		        ?>
		    </td>
		    <td>
        		<select name='estructura' id='estructura' class='lista_sencilla1' tabindex='26'>
          			<option value='0'>- SELECCIONAR -</option>
        		</select>
		    </td>
		</tr>
	  </table>
      <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="70%" height="20" valign="bottom">
	            Concepto: Resumen del Resultado Operacional
	        </td>
	      	<td width="30%" height="20" valign="bottom">
	            Fecha Resultado
	        </td>
	    </tr>
        <tr>
	    	<td>
	    		<textarea name="resultado" id="resultado" rows="4" tabindex="27"></textarea>
	    	</td>
		    <td valign="top">
		    	<input type="text" name="fecha2" id="fecha2" class="c1" placeholder="yy/mm/dd" readonly="readonly" tabindex="28">
		    </td>
		</tr>
	    <tr>
	    	<td>
		        <div id="add_form">
		          <table width="100%" align="center" border="0">
		            <tr>
		              	<td width="35%" height="20" valign="bottom">
	            			C&eacute;dula Fuente
	        			</td>
		              	<td width="35%" height="20" valign="bottom">
	            			Nombre Fuente
	        			</td>
		              	<td width="20%" height="20" valign="bottom">
	            			%
	        			</td>
	        			<td width="5%" height="20" valign="bottom">
	            			Anexar
	        			</td>
	        			<td width="5%" height="20" valign="bottom">
	            			&nbsp;
	        			</td>
		            </tr>
		          </table>
		        </div>
		        <a href="#" name="add_field" id="add_field"><img src="imagenes/boton1.jpg" border="0"></a>
		        <input type="hidden" name="cedulas" id="cedulas" readonly="readonly">
		        <input type="hidden" name="nombres" id="nombres" readonly="readonly">
		        <input type="hidden" name="porcentajes" id="porcentajes" readonly="readonly">
		        <input type="hidden" name="porcentajes1" id="porcentajes1" readonly="readonly">
		        <input type="hidden" name="paso1" id="paso1" readonly="readonly">
	    	</td>
	    </tr>
	  </table>
	  <table align="center" width="95%" border="0">
	    <tr>
	      	<td colspan="2" height="20" valign="bottom">
	            Total Suma Porcentaje Fuentes:&nbsp;&nbsp;&nbsp;<input type="text" name="porcentaje" id="porcentaje" class="c22" value="0" readonly="readonly">
	        </td>
	    </tr>
	  </table>
      <table align="center" width="95%" border="0">
	    <tr>
	      	<td width="20%" height="25" valign="bottom">
	            Pago Previo a la Fuente
	        </td>
	      	<td width="20%" height="25" valign="bottom">
	      		SI
				<input type="radio" name="pag_prev" id="pag_prev" value="1" onclick="previo()">
				&nbsp;&nbsp;&nbsp;
				NO
				<input type="radio" name="pag_prev" id="pag_prev" value="0" onclick="previo()" checked>
	        </td>
	      	<td width="30%" height="25" valign="bottom">
	            &nbsp;
	        </td>
	      	<td width="30%" height="25" valign="bottom">
	            &nbsp;
	        </td>
	    </tr>
	    <tr>
	      	<td height="20" valign="bottom">
	            Acta de Pago
	        </td>
	      	<td height="20" valign="bottom">
	            Fecha de Pago
	        </td>
	      	<td height="20" valign="bottom">
	            Valor del Pago
	        </td>
	      	<td height="20" valign="bottom">
	            Anexar
	        </td>
	    </tr>
	    <tr>
	    	<td>
	    		<input type="text" name="pago" id="pago" class="c2" value="0">
	    	</td>
		    <td>
		    	<input type="text" name="fecha9" id="fecha9" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		    </td>
		    <td>
			    <input type="text" name="valor_p" id="valor_p" class="c12" value="0.00" onkeyup="paso_val2();">
		        <input type="hidden" name="valor_p1" id="valor_p1" value="0">
		    </td>
		    <td>
				<a href="#" name="lnk1" id="lnk1" onclick="subir1();"><img src="imagenes/clip.png" border="0" title="Anexar Acta Pago"></a>
		    </td>
	    </td>
	  </table>
	<div id="reco1">
	    <table align="center" width="95%" border="0">
		    <tr>
		      	<td width="25%" height="20" valign="bottom">
		            Valor Aprobado
		        </td>
		      	<td width="15%" height="15" valign="bottom">
		            Acta Aval
		        </td>
		      	<td width="15%" height="15" valign="bottom">
		            Fecha Giro
		        </td>
		      	<td width="15%" height="15" valign="bottom">
		            Informe Giro
		        </td>
		      	<td width="30%" height="15" valign="bottom">
		            &nbsp;
		        </td>
		    </tr>
	        <tr>
	        	<td>
				    <input type="text" name="valor2" id="valor2" class="c12" value="0.00" readonly="readonly">
			    </td>
			    <td>
					<input type="text" name="aval" id="aval" class="c2" value="0" readonly="readonly">
			    </td>
			    <td>
					<input type="text" name="fecha3" id="fecha3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
	          	</td>
			    <td>
					<input type="text" name="inf_giro" id="inf_giro" class="c2" value="0" readonly="readonly">
			    </td>
			    <td>
			    	&nbsp;
			    </td>
			</tr>
		</table>
		<table align="center" width="95%" border="0">
		    <tr>
		      	<td width="15%" height="15" valign="bottom">
		            Acta Pago
		        </td>
		      	<td width="15%" height="15" valign="bottom">
		            Fecha Pago
		        </td>
		      	<td width="30%" height="20" valign="bottom">
		            Estado
		        </td>
		      	<td width="40%" height="15" valign="bottom">
		            &nbsp;
		        </td>
		    </tr>
	        <tr>
			    <td>
					<input type="text" name="acta" id="acta" class="c2" value="0" readonly="readonly">
			    </td>
	          	<td>
					<input type="text" name="fecha4" id="fecha4" class="c1" placeholder="yy/mm/dd" readonly="readonly">
	          	</td>
	          	<td>
	              	<select name="estado" id="estado" class="lista_sencilla2">
	              		<option value="0">-</option>
	                	<option value="1">EN TRAMITE U.T.</option>
	                	<option value="2">RECHAZADA</option>
	                	<option value="3">EN EVALUACION CRR</option>
	                	<option value="4">EVALUADA CRR</option>
	                	<option value="5">EN EVALUACION CCE</option>
	                	<option value="6">EVALUADA CCE</option>
	                	<option value="7">PENDIENTE ASIGNACION RECURSO</option>
	                	<option value="8">PENDIENTE PAGO</option>
	                	<option value="9">PAGADA</option>
	                	<option value="10">EN ACREEDORES VARIOS CEDE2</option>
	                	<option value="11">EN ACREEDORES VARIOS DTN</option>
	              	</select>
	          	</td>
			    <td>
			    	&nbsp;
			    </td>
			</tr>
		</table>
	</div>
	<table align="center" width="95%" border="0">
	    <tr>
	      	<td height="20" valign="bottom">
	            Observaciones Unidad Solicitante
	        </td>
	    </tr>
	    <tr>
	    	<td>
	    		<textarea name="observaciones" id="observaciones" rows="4"></textarea>
	    	</td>
	    </tr>
	  </table>
      <table align="center" width="95%" border="0">
	    <tr>
	      	<td colspan="2" height="20" valign="bottom">
	            Directiva Ministerial Permanente
	        </td>
	    </tr>
	    <tr>
	    	<td colspan="2">
              	<select name="directiva" id="directiva" class="lista_sencilla4">
                	<option value="1">No. 01 del 17 de Febrero de 2009</option>
                	<option value="2">No. 21 del 6 de Julio de 2011</option>
                	<option value="3">No. 16 del 25 de Mayo de 2012</option>
              	</select>
              	<input type="hidden" name="lista" id="lista" class="c3" readonly="readonly">
              	<input type="hidden" name="alea" id="alea" class="c2" value="<?php echo $alea; ?>" readonly="readonly">
	        </td>
	    </tr>
	  </table>
	  <br>
  	<div id="lista1">
	  <table align="center" width="95%" border="0">
		<tr>
		  	<td>
		  	<table align="center" width="100%" border="0">
		  		<tr>
		  			<td width="50%">
						&nbsp;
		  			</td>
		  			<td width="5%">
		  				<center>
		  					<b>SI</b>
		  				</center>
		  			</td>
		  			<td width="5%">
		  				<center>
		  					<b>NO</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>No. Doc</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>Fecha</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>Folio<br>Inicial</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>Folio<br>Final</b>
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGURAL CON EL RESPECTIVO APOYO BAT. BR. DIV.
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_1_1" id="l1_1_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_1_1" id="l1_1_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_1_2" id="l1_1_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_1_3" id="l1_1_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_1_4" id="l1_1_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_1_5" id="l1_1_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				DOCUMENTO OFICIAL CON EL CUAL LA RESPECTIVA UNIDAD INFORMA AL MANDO SUPERIOR LOS RESULTADOS OBTENIDOS
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_2_1" id="l1_2_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_2_1" id="l1_2_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_2_2" id="l1_2_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_2_3" id="l1_2_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_2_4" id="l1_2_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_2_5" id="l1_2_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				CERTIFICACION INFORMANTE NO PERTENECE A REINSERCION EXPEDIDO POR EL COMANDANTE DE LA UNIDAD
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_3_1" id="l1_3_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_3_1" id="l1_3_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_3_2" id="l1_3_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_3_3" id="l1_3_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_3_4" id="l1_3_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_3_5" id="l1_3_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				DOCUMENTO OFICIAL QUE ORDENE LA OPERACION DE LA UNIDAD TACTICA Y/O OPERATIVA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_4_1" id="l1_4_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_4_1" id="l1_4_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_4_2" id="l1_4_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_4_3" id="l1_4_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_4_4" id="l1_4_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_4_5" id="l1_4_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				INFORME DE PATRULLA O RESULTADOS
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_5_1" id="l1_5_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_5_1" id="l1_5_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_5_2" id="l1_5_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_5_3" id="l1_5_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_5_4" id="l1_5_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_5_5" id="l1_5_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				CERTIFICACION POR PARTE DEL JEFE DE LA SECCION DE INT.
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_6_1" id="l1_6_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_6_1" id="l1_6_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_6_2" id="l1_6_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_6_3" id="l1_6_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_6_4" id="l1_6_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_6_5" id="l1_6_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Capturas</b>
		  			</td>
		  		</tr>
				<tr>
		  			<td>
		  				DOCUMENTO DEJANDO A DISPOSICION AUTORIDAD JUD. CAPTURADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_7_1" id="l1_7_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_7_1" id="l1_7_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_7_2" id="l1_7_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_7_3" id="l1_7_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_7_4" id="l1_7_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_7_5" id="l1_7_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ORGANIGRAMA SIMPLIFICADO CON LA UBICACION DE LA ESTRUCTURA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_8_1" id="l1_8_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_8_1" id="l1_8_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_8_2" id="l1_8_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_8_3" id="l1_8_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_8_4" id="l1_8_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_8_5" id="l1_8_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				FOTOGRAFIAS DEL TERRORISTA CAPTURADO O FUGADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_9_1" id="l1_9_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_9_1" id="l1_9_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_9_2" id="l1_9_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_9_3" id="l1_9_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_9_4" id="l1_9_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_9_5" id="l1_9_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ANTECEDENTES PENALES Y/O ANOTACIONES DEL TERRORISTA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_10_1" id="l1_10_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_10_1" id="l1_10_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_10_2" id="l1_10_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_10_3" id="l1_10_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_10_4" id="l1_10_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_10_5" id="l1_10_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				TARJETA DECADACTILAR DEL CAPTURADO O FUGADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_11_1" id="l1_11_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_11_1" id="l1_11_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_11_2" id="l1_11_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_11_3" id="l1_11_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_11_4" id="l1_11_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_11_5" id="l1_11_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ENTREVISTA DEL CAPTURADO O FUGADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_12_1" id="l1_12_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_12_1" id="l1_12_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_12_2" id="l1_12_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_12_3" id="l1_12_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_12_4" id="l1_12_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_12_5" id="l1_12_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Abatidos</b>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ACTA DE LEVANTAMIENTO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_13_1" id="l1_13_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_13_1" id="l1_13_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_13_2" id="l1_13_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_13_3" id="l1_13_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_13_4" id="l1_13_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_13_5" id="l1_13_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ORGANIGRAMA SIMPLIFICADO CON LA UBICACION DE LA ESTRUCTURA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_14_1" id="l1_14_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_14_1" id="l1_14_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_14_2" id="l1_14_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_14_3" id="l1_14_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_14_4" id="l1_14_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_14_5" id="l1_14_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				FOTOGRAFIAS DEL TERRORISTA CAPTURADO O FUGADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_15_1" id="l1_15_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_15_1" id="l1_15_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_15_2" id="l1_15_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_15_3" id="l1_15_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_15_4" id="l1_15_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_15_5" id="l1_15_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ANTECEDENTES PENALES Y/O ANOTACIONES DEL TERRORISTA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_16_1" id="l1_16_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_16_1" id="l1_16_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_16_2" id="l1_16_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_16_3" id="l1_16_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_16_4" id="l1_16_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_16_5" id="l1_16_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				TARJETA DE NECRODACTILIA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_17_1" id="l1_17_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_17_1" id="l1_17_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_17_2" id="l1_17_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_17_3" id="l1_17_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_17_4" id="l1_17_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_17_5" id="l1_17_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Material</b>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ACTA O DOCUMENTO INTERNO DE LA INCAUTACION DE MATERIAL
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_18_1" id="l1_18_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_18_1" id="l1_18_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_18_2" id="l1_18_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_18_3" id="l1_18_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_18_4" id="l1_18_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_18_5" id="l1_18_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				FOTOGRAFIAS DEL MATERIAL INCAUTADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_19_1" id="l1_19_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_19_1" id="l1_19_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_19_2" id="l1_19_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_19_3" id="l1_19_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_19_4" id="l1_19_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_19_5" id="l1_19_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ANALISIS PRELIMINAR MATERIAL INCAUTADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_20_1" id="l1_20_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_20_1" id="l1_20_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_20_2" id="l1_20_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_20_3" id="l1_20_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_20_4" id="l1_20_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_20_5" id="l1_20_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Documentos</b>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ACTA O DOCUMENTO INTERNO DE LA INCAUTACION DE MATERIAL
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_21_1" id="l1_21_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_21_1" id="l1_21_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_21_2" id="l1_21_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_21_3" id="l1_21_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_21_4" id="l1_21_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_21_5" id="l1_21_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ANALISIS DE DOCUMENTOS INCAUTADOS - PERTENENCIA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_22_1" id="l1_22_1" value="1" onclick="val_lista1()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l1_22_1" id="l1_22_1" value="1" onclick="val_lista1()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_22_2" id="l1_22_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_22_3" id="l1_22_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_22_4" id="l1_22_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l1_22_5" id="l1_22_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  	</table>
		  	</td>
		</tr>
	  </table>
  	</div>
  	<div id="lista2">
	  <table align="center" width="95%" border="0">
		<tr>
		  	<td>
		  	<table align="center" width="100%" border="0">
		  		<tr>
		  			<td width="50%">
						&nbsp;
		  			</td>
		  			<td width="5%">
		  				<center>
		  					<b>SI</b>
		  				</center>
		  			</td>
		  			<td width="5%">
		  				<center>
		  					<b>NO</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>No. Doc</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>Fecha</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>Folio<br>Inicial</b>
		  				</center>
		  			</td>
		  			<td width="10%">
		  				<center>
		  					<b>Folio<br>Final</b>
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				LA SOLICITUD DEBE SEGUIR EL CONDUCTO REGURAL CON EL RESPECTIVO APOYO BAT. BR. DIV.
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_1_1" id="l2_1_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_1_1" id="l2_1_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_1_2" id="l2_1_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_1_3" id="l2_1_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_1_4" id="l2_1_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_1_5" id="l2_1_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				INFORME DE CONTACTO CON LA FUENTE (INICIAL O PRELIMINAR DE LA INFORMACION SUMINISTRADA POR LA FUENTE)
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_2_1" id="l2_2_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_2_1" id="l2_2_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_2_2" id="l2_2_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_2_3" id="l2_2_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_2_4" id="l2_2_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_2_5" id="l2_2_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				INFORME DE INTELIGENCIA DONDE SE INCLUYE LA INFORMACION ENTREGADA POR LA FUENTE DEBIDAMENTE EVALUADA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_3_1" id="l2_3_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_3_1" id="l2_3_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_3_2" id="l2_3_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_3_3" id="l2_3_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_3_4" id="l2_3_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_3_5" id="l2_3_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				DOCUMENTO OFICIAL CON EL QUE LA RESPECTIVA UNIDAD INFORMA AL MANDO SUPERIOR LOS RESULTADOS OBTENIDOS
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_4_1" id="l2_4_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_4_1" id="l2_4_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_4_2" id="l2_4_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_4_3" id="l2_4_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_4_4" id="l2_4_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_4_5" id="l2_4_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				CERTIFICACION EXPEDIDA POR EL COMANDANTE DE LA UNIDAD QUE NO SE TRAMITARA PAGO ANTE EL GAHD U OTRA AGENCIA DE INT.
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_5_1" id="l2_5_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_5_1" id="l2_5_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_5_2" id="l2_5_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_5_3" id="l2_5_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_5_5" id="l2_5_5" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_5_4" id="l2_5_4" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				DOCUMENTO OFICIAL QUE ORDENE LA OPERACION DE LA UNIDAD TACTICA Y/O OPERATIVA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_6_1" id="l2_6_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_6_1" id="l2_6_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_6_2" id="l2_6_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_6_3" id="l2_6_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_6_4" id="l2_6_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_6_5" id="l2_6_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
				<tr>
		  			<td>
		  				INFORME RESULTADOS OBTENIDOS EN DESARROLLO DE LA OPERACION FIRMADO, REFERENCIA PRODUCTO INFORMACION APORTADA POR FUENTE HUMANA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_7_1" id="l2_7_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_7_1" id="l2_7_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_7_2" id="l2_7_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_7_3" id="l2_7_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_7_4" id="l2_7_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_7_5" id="l2_7_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				COPIA INFORME PRIMER RESPONDIENTE DEJANDO A DISPOSICION DE AUTORIDAD LOS ELEMENTOS INCAUTADOS Y/O INMOVILIZADOS
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_8_1" id="l2_8_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_8_1" id="l2_8_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_8_2" id="l2_8_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_8_3" id="l2_8_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_8_4" id="l2_8_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_8_5" id="l2_8_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ACTA DE NEGOCIACION EFECTUADA CON LA FUENTE HUMANA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_9_1" id="l2_9_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_9_1" id="l2_9_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_9_2" id="l2_9_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_9_3" id="l2_9_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_9_4" id="l2_9_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_9_5" id="l2_9_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Neutralizaciones (Capturas o Desmovilizaciones)</b>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				DOCUMENTO DEJANDO A DISPOSICION AUTORIDAD COMPETENTE
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_10_1" id="l2_10_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_10_1" id="l2_10_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_10_2" id="l2_10_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_10_3" id="l2_10_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_10_4" id="l2_10_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_10_5" id="l2_10_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ORGANIGRAMA SIMPLIFICADO CON LA UBICACION DE LA ESTRUCTURA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_11_1" id="l2_11_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_11_1" id="l2_11_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_11_2" id="l2_11_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_11_3" id="l2_11_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_11_4" id="l2_11_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_11_5" id="l2_11_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				PRONTUARIO O PERFIL DELICTIVO DEL SUJETO(S) REPORTADO(S)
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_12_1" id="l2_12_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_12_1" id="l2_12_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_12_2" id="l2_12_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_12_3" id="l2_12_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_12_4" id="l2_12_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_12_5" id="l2_12_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				TARJETA DEDACTILAR DE NEUTRALIZADOS
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_13_1" id="l2_13_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_13_1" id="l2_13_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_13_2" id="l2_13_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_13_3" id="l2_13_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_13_4" id="l2_13_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_13_5" id="l2_13_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				CERTIFICADO DE CODA DE LA ACEPTACION POR PARTE DEL GAHD
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_14_1" id="l2_14_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_14_1" id="l2_14_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_14_2" id="l2_14_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_14_3" id="l2_14_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_14_4" id="l2_14_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_14_5" id="l2_14_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Muerte en Desarrollo de Operaci&oacute;n Militar</b>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ACTA DE INSPECCION DEL CADAVER
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_15_1" id="l2_15_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_15_1" id="l2_15_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_15_2" id="l2_15_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_15_3" id="l2_15_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_15_4" id="l2_15_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_15_5" id="l2_15_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ORGANIGRAMA SIMPLIFICADO CON LA UBICACION DE LA ESTRUCTURA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_16_1" id="l2_16_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_16_1" id="l2_16_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_16_2" id="l2_16_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_16_3" id="l2_16_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_16_4" id="l2_16_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_16_5" id="l2_16_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				FOTOGRAFIAS DEL TERRORISTA NEUTRALIZADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_17_1" id="l2_17_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_17_1" id="l2_17_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_17_2" id="l2_17_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_17_3" id="l2_17_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_17_4" id="l2_17_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_17_5" id="l2_17_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				PRONTUARIO DELICTIVO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_18_1" id="l2_18_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_18_1" id="l2_18_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_18_2" id="l2_18_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_18_3" id="l2_18_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_18_4" id="l2_18_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_18_5" id="l2_18_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				TARJETA DE NECRODACTILIA
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_19_1" id="l2_19_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_19_1" id="l2_19_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_19_2" id="l2_19_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_19_3" id="l2_19_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_19_4" id="l2_19_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_19_5" id="l2_19_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td colspan="4">
		  				<b>Material</b>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ACTA O DOCUMENTO INTERNO DE LA INCAUTACION DE MATERIAL
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_20_1" id="l2_20_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_20_1" id="l2_20_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_20_2" id="l2_20_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_20_3" id="l2_20_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_20_4" id="l2_20_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_20_5" id="l2_20_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				FOTOGRAFIAS DEL MATERIAL INCAUTADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_21_1" id="l2_21_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_21_1" id="l2_21_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_21_2" id="l2_21_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_21_3" id="l2_21_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_21_4" id="l2_21_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_21_5" id="l2_21_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  		<tr>
		  			<td>
		  				ANALISIS PRELIMINAR MATERIAL INCAUTADO
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_22_1" id="l2_22_1" value="1" onclick="val_lista2()">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="radio" name="l2_22_1" id="l2_22_1" value="1" onclick="val_lista2()" checked>
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_22_2" id="l2_22_2" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_22_3" id="l2_22_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_22_4" id="l2_22_4" class="c13" value="0">
		  				</center>
		  			</td>
		  			<td>
		  				<center>
		  					<input type="text" name="l2_22_5" id="l2_22_5" class="c13" value="0">
		  				</center>
		  			</td>
		  		</tr>
		  	</table>
		  	</td>
		</tr>
	  </table>
  	</div>
  	<div id="lista3">
	  	<table align="center" width="95%" border="0">
			<tr>
		  		<td>
			  		<table align="center" width="100%" border="0">
				  		<tr>
				  			<td width="50%">
								&nbsp;
				  			</td>
				  			<td width="5%">
				  				<center>
				  					<b>SI</b>
				  				</center>
				  			</td>
				  			<td width="5%">
				  				<center>
				  					<b>NO</b>
				  				</center>
				  			</td>
				  			<td width="10%">
				  				<center>
				  					<b>No. Doc</b>
				  				</center>
				  			</td>
				  			<td width="10%">
				  				<center>
				  					<b>Fecha</b>
				  				</center>
				  			</td>
				  			<td width="10%">
				  				<center>
				  					<b>Folio<br>Inicial</b>
				  				</center>
				  			</td>
				  			<td width="10%">
				  				<center>
				  					<b>Folio<br>Final</b>
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				1. Copia informe de contacto con la fuente - PROIC.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_1_1" id="l3_1_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_1_1" id="l3_1_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_1_2" id="l3_1_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_1_3" id="l3_1_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_1_4" id="l3_1_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_1_5" id="l3_1_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				2. Copia anexo de inteligencia a la ORDOP.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_2_1" id="l3_2_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_2_1" id="l3_2_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_2_2" id="l3_2_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_2_3" id="l3_2_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_2_4" id="l3_2_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_2_5" id="l3_2_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				3. Copia informe de inteligencia y contrainteligencia, informe preliminar de inteligencia o informe de inteligencia preventivo.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_3_1" id="l3_3_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_3_1" id="l3_3_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_3_2" id="l3_3_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_3_3" id="l3_3_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_3_4" id="l3_3_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_3_5" id="l3_3_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				4. Copia orden de operaci&oacute;n militar emitida por la unidad operativa y/o t&aacute;ctica.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_4_1" id="l3_4_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_4_1" id="l3_4_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_4_2" id="l3_4_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_4_3" id="l3_4_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_4_4" id="l3_4_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_4_5" id="l3_4_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				5. Copia orden fragmentaria emitida por la unidad operativa y/o t&aacute;ctica (Cuando aplique).
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_5_1" id="l3_5_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_5_1" id="l3_5_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_5_2" id="l3_5_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_5_3" id="l3_5_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_5_4" id="l3_5_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_5_5" id="l3_5_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				6. Copia del informe de patrullaje emitido por el responsable de la ORDOP militar.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_6_1" id="l3_6_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_6_1" id="l3_6_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_6_2" id="l3_6_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_6_3" id="l3_6_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_6_4" id="l3_6_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_6_5" id="l3_6_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
						<tr>
				  			<td>
				  				7. Copia radiograma de reporte al COE. del resultado operacional emitido por parte del comando de la Divisi&oacute;n.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_7_1" id="l3_7_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_7_1" id="l3_7_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_7_2" id="l3_7_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_7_3" id="l3_7_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_7_4" id="l3_7_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_7_5" id="l3_7_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
						<tr>
				  			<td>
				  				8. Documento emitido por el Comandante de la Unidad solicitante, donde certifica que NO dar&aacute; tramite de pago de la recompensa a trav&eacute;s del GAHD, otra Fuerza ni PONAL como tampoco a trav&eacute;s de la alcald&iacute;a o gobernaci&oacute;n con recursos de ley 418 de 1997.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_8_1" id="l3_8_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_8_1" id="l3_8_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_8_2" id="l3_8_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_8_3" id="l3_8_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_8_4" id="l3_8_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_8_5" id="l3_8_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				9. Certificaci&oacute;n informante no pertenece al programa de reinserci&oacute;n expedido por el GAHD.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_9_1" id="l3_9_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_9_1" id="l3_9_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_9_2" id="l3_9_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_9_3" id="l3_9_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_9_4" id="l3_9_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_9_5" id="l3_9_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				10. Acta de acuerdos con la fuente.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_10_1" id="l3_10_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_10_1" id="l3_10_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_10_2" id="l3_10_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_10_3" id="l3_10_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_10_4" id="l3_10_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_10_5" id="l3_10_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<?php
				  		if ($tpu_usuario == "7")
				  		{
				  		?>
				  		<tr>
				  			<td>
				  				11. Oficios de apoyo al tramite de recompensas emitido por el Comando Brigada y Divisi&oacute;n.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_11_1" id="l3_11_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_11_1" id="l3_11_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_11_2" id="l3_11_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_11_3" id="l3_11_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_11_4" id="l3_11_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_11_5" id="l3_11_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<?php
				  		}
				  		?>
						<tr>
					      	<td colspan="7" height="40">
					      		<br>
					            <b>Tipo de Resultado</b>
					        </td>
					    </tr>
					    <tr>
					    	<td colspan="7">
					          	<div id="tipo_l3">
					            	<input type="checkbox" name="tipo1_l3" id="tipo1_l3" onclick="vali1()"><label for="tipo1_l3">Cristalizadero - Laboratorio - Material</label>
					            	<input type="checkbox" name="tipo2_l3" id="tipo2_l3" onclick="vali2()"><label for="tipo2_l3">Capturas</label>
					            	<input type="checkbox" name="tipo3_l3" id="tipo3_l3" onclick="vali3()"><label for="tipo3_l3">M.D.O.M</label>
					          	</div>
					        </td>
					    </tr>
						<tr>
					      	<td colspan="7" height="15" valign="bottom">
					            &nbsp;
					        </td>
					    </tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="lista3_o1">
	  	<table align="center" width="95%" border="0">
			<tr>
		  		<td>
			  		<table align="center" width="100%" border="0">
				  		<tr>
				  			<td width="50%"></td>
				  			<td width="5%"></td>
				  			<td width="5%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  		</tr>
				  		<tr>
				  			<td colspan="7">
				  				<b>Neutralizaciones (Capturas o Desmovilizaciones)</b>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				1. Copia del informe del primer respondiente o informe ejecutivo dejando a disposici&oacute;n de autoridad competente los elementos incautados y/o inmovilizados, y/o personas capturadas seg&uacute;n el caso y sus anexos.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_12_1" id="l3_12_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_12_1" id="l3_12_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_12_2" id="l3_12_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_12_3" id="l3_12_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_12_4" id="l3_12_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_12_5" id="l3_12_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				2. Organigrama simplificado con la ubicaci&oacute;n de la estructura delincuencial del o los sujetos neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_13_1" id="l3_13_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_13_1" id="l3_13_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_13_2" id="l3_13_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_13_3" id="l3_13_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_13_4" id="l3_13_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_13_5" id="l3_13_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				3. Fofograf&iacute;as del o los neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_14_1" id="l3_14_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_14_1" id="l3_14_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_14_2" id="l3_14_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_14_3" id="l3_14_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_14_4" id="l3_14_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_14_5" id="l3_14_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				4. Prontuario o perfil delictivo o antecedentes delictivos del o los neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_15_1" id="l3_15_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_15_1" id="l3_15_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_15_2" id="l3_15_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_15_3" id="l3_15_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_15_4" id="l3_15_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_15_5" id="l3_15_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				5. Tarjeta dedactilar del o los neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_16_1" id="l3_16_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_16_1" id="l3_16_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_16_2" id="l3_16_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_16_3" id="l3_16_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_16_4" id="l3_16_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_16_5" id="l3_16_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				6. Certificado de coda de la aceptaci&oacute;n por parte del GAHD (aplica para desmovilizados).
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_17_1" id="l3_17_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_17_1" id="l3_17_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_17_2" id="l3_17_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_17_3" id="l3_17_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_17_4" id="l3_17_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_17_5" id="l3_17_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="lista3_o2">
	  	<table align="center" width="95%" border="0">
			<tr>
		  		<td>
			  		<table align="center" width="100%" border="0">
				  		<tr>
				  			<td width="50%"></td>
				  			<td width="5%"></td>
				  			<td width="5%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  		</tr>
				  		<tr>
				  			<td colspan="7">
				  				<b>Neutralizaciones (M.D.O.M)</b>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				1. Copia del informe del primer respondiente o informe ejecutivo dejando a disposici&oacute;n de autoridad competente los elementos incautados y/o inmovilizados, y/o personas capturadas seg&uacute;n el caso y sus anexos.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_18_1" id="l3_18_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_18_1" id="l3_18_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_18_2" id="l3_18_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_18_3" id="l3_18_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_18_4" id="l3_18_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_18_5" id="l3_18_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				2. Organigrama simplificado con la ubicaci&oacute;n de la estructura delincuencial del o los sujetos neutralizados. 
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_19_1" id="l3_19_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_19_1" id="l3_19_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_19_2" id="l3_19_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_19_3" id="l3_19_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_19_4" id="l3_19_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_19_5" id="l3_19_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				3. Registro fotogr&aacute;fico del o los neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_20_1" id="l3_20_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_20_1" id="l3_20_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_20_2" id="l3_20_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_20_3" id="l3_20_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_20_4" id="l3_20_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_20_5" id="l3_20_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				4. Prontuario delictivo o antecedentes delictivos del o los neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_21_1" id="l3_21_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_21_1" id="l3_21_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_21_2" id="l3_21_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_21_3" id="l3_21_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_21_4" id="l3_21_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_21_5" id="l3_21_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				5. Tarjeta de necrodactilia del o los neutralizados.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_22_1" id="l3_22_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_22_1" id="l3_22_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_22_2" id="l3_22_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_22_3" id="l3_22_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_22_4" id="l3_22_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_22_5" id="l3_22_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="lista3_o3">
	  	<table align="center" width="95%" border="0">
			<tr>
		  		<td>
			  		<table align="center" width="100%" border="0">
				  		<tr>
				  			<td width="50%"></td>
				  			<td width="5%"></td>
				  			<td width="5%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  			<td width="10%"></td>
				  		</tr>
				  		<tr>
				  			<td colspan="7">
				  				<b>Material</b>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				1. Copia del informe del primer respondiente o informe ejecutivo dejando a disposici&oacute;n de autoridad competente los elementos incautados y/o inmovilizados, y/o personas capturadas seg&uacute;n el caso y sus anexos.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_23_1" id="l3_23_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_23_1" id="l3_23_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_23_2" id="l3_23_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_23_3" id="l3_23_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_23_4" id="l3_23_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_23_5" id="l3_23_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				2. Fotograf&iacute;as del material incautado.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_24_1" id="l3_24_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_24_1" id="l3_24_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_24_2" id="l3_24_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_24_3" id="l3_24_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_24_4" id="l3_24_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_24_5" id="l3_24_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
				  		<tr>
				  			<td>
				  				3. An&aacute;lisis preliminar material incautado (Peritajes emitidos por autoridad competente) para el caso de explosivos se anexa copia del acta de destrucci&oacute;n.
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_25_1" id="l3_25_1" value="1" onclick="val_lista3()">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="radio" name="l3_25_1" id="l3_25_1" value="1" onclick="val_lista3()" checked>
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_25_2" id="l3_25_2" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_25_3" id="l3_25_3" class="c1" placeholder="yy/mm/dd" readonly="readonly">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_25_4" id="l3_25_4" class="c13" value="0">
				  				</center>
				  			</td>
				  			<td>
				  				<center>
				  					<input type="text" name="l3_25_5" id="l3_25_5" class="c13" value="0">
				  				</center>
				  			</td>
				  		</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="tipos" id="tipos" class="c3" readonly="readonly">
  	<br>
  	<div id="expediente">
	  	<center>
	  		Expediente Completo Comprimido en Formato .zip
	  		<br><br>
	  		<a href="#" name="lnk2" id="lnk2" onclick="subir2();"><img src="imagenes/clip.png" border="0" title="Anexar Expediente Comprimido"></a>
	  	</center>
  		<br>
  	</div>
  	<div id="botones">
    	<center>
      		<input type="button" name="aceptar" id="aceptar" value="Grabar">
      		&nbsp;
			<input type="button" name="actualizar" id="actualizar" value="Actualizar">
			&nbsp;
      		<input type="button" name="limpiar" id="limpiar" value="Limpiar">
			&nbsp;
			<input type="button" name="aceptar1" id="aceptar1" value="Solicitar Revisión">
    	</center>
  	</div>
  	</form>
	<div id="dialogo"></div>
	<div id="dialogo1"></div>
	<div id="dialogo2"></div>
 	<div id="dialogo3">
		<form name="formu2">
			<div id="val_modi"></div>
		</form>
  	</div>
 	<div id="dialogo4"></div>
	<div id="load">
	  <center>
	    <img src="imagenes/cargando.gif" alt="Cargando..." />
	  </center>
	</div>
</div>
<!--
Consulta
-->
<div id="tabs-2">
  <div id="content">
    <div id="menu">
      <h3>Menu</h3>
      <table align="center" width="100%" border="0">
      <!--
      <tr>
        <td height="20" valign="top">
          <label>Estado del Registro</label>
        </td>
      </tr>
      <tr>
        <td>
            <select name="tipo_e" id="tipo_e" class="lista_sencilla4">
              	<option value="99">TODOS</option>
	            <option value="1">EN TRAMITE U.T.</option>
	          	<option value="2">RECHAZADA</option>
	            <option value="3">EN EVALUACION CRR</option>
	          	<option value="4">EVALUADA CRR</option>
	           	<option value="5">EN EVALUACION CCE</option>
	            <option value="6">EVALUADA CCE</option>
	          	<option value="7">PENDIENTE ASIGNACION RECURSO</option>
	          	<option value="8">PENDIENTE PAGO</option>
	           	<option value="9">PAGADA</option>
	           	<option value="10">EN ACREEDORES VARIOS CEDE2</option>
	            <option value="11">EN ACREEDORES VARIOS DTN</option>
            </select>
        </td>
      </tr>
      -->
      <tr>
        <td height="20" valign="top">
          <label>Fecha</label>
        </td>
      </tr>
      <tr>
        <td>
            <input type="text" name="fecha5" id="fecha5" class="c1" placeholder="yy/mm/dd" readonly="readonly">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="fecha6" id="fecha6" class="c1" placeholder="yy/mm/dd" readonly="readonly">
        </td>
      </tr>
      <tr>
        <td>
          <br>
          <center>
            <input type="button" name="consultar" id="consultar" value="Consultar">
          </center>
        </td>
      </tr>
      </table>
    </div>
    <br>
    <div id="tabla"></div>
    <div id="resultados"></div>
  </div>
  <div id="load1">
    <center>
      <img src="imagenes/cargando.gif" alt="Cargando..." />
    </center>
  </div>
</div>
</div>
<script>
$(document).bind("contextmenu",function(e) {
  return false;  
});
$(document).ready(function () {
  $("#load").hide();
  $("#load1").hide();
  $("#dialogo").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 330,
    width: 350,
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
  $("#dialogo1").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 150,
    width: 480,
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
        $( this ).dialog( "close" );
        valida();
      },
      "Cancelar": function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo2").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 130,
    width: 470,
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
  $("#dialogo3").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 400,
    width: 600,
    modal: true,
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
      "Enviar": function() {
        enviar();
      },
      Cancelar: function() {
        $( this ).dialog( "close" );
      }
    }
  });
  $("#dialogo4").dialog({
    autoOpen: false,
    title: "SIGAR",
    height: 220,
    width: 440,
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
  $("#fecha").datepicker({
    dateFormat: "yy/mm/dd",
    minDate: "-150d",
    changeYear: true,
    changeMonth: true,
   	onSelect: function () {
    	$("#registro").focus();
    },
  });
  $("#fecha1").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    minDate: "-45d",
    changeYear: true,
    changeMonth: true,
   	onSelect: function () {
    	$("#filtro").focus();
    },
  });
  var valida1 = $("#n_unidad").val();
  if (valida1 == "1")
  {
	var v_dias = "+90d";
  }
  else
  {
	var v_dias = "+45d";
  }
  $("#fecha5").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
      $("#fecha6").prop("disabled", false);
      $("#fecha6").datepicker("destroy");
      $("#fecha6").val('');
      $("#fecha6").datepicker({
        dateFormat: "yy/mm/dd",
        minDate: $("#fecha5").val(),
        maxDate: 0,
        changeYear: true,
        changeMonth: true
      });
    },
  });
  $("#fecha7").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
	onSelect: function () {
		$("#orden").focus();
	    $("#l3_2_3").prop("disabled", false);
	    $("#l3_2_3").datepicker("destroy");
	   	$("#l3_2_3").val('');
	   	$("#l3_2_3").datepicker({
	        dateFormat: "yy/mm/dd",
	       	maxDate: $("#fecha7").val(),
	   		changeYear: true,
	       	changeMonth: true
	    });
	    $("#l3_6_3").prop("disabled", false);
	    $("#l3_6_3").datepicker("destroy");
	   	$("#l3_6_3").val('');
	   	$("#l3_6_3").datepicker({
	        dateFormat: "yy/mm/dd",
	       	maxDate: $("#fecha7").val(),
	   		changeYear: true,
	       	changeMonth: true
	    });
	    $("#l3_7_3").prop("disabled", false);
	    $("#l3_7_3").datepicker("destroy");
	   	$("#l3_7_3").val('');
	   	$("#l3_7_3").datepicker({
	        dateFormat: "yy/mm/dd",
	       	maxDate: $("#fecha7").val(),
	   		changeYear: true,
	       	changeMonth: true
	    });
	    $("#l3_8_3").prop("disabled", false);
	    $("#l3_8_3").datepicker("destroy");
	   	$("#l3_8_3").val('');
	   	$("#l3_8_3").datepicker({
	        dateFormat: "yy/mm/dd",
	       	maxDate: $("#fecha7").val(),
	   		changeYear: true,
	       	changeMonth: true
	    });
	    $("#l3_9_3").prop("disabled", false);
	    $("#l3_9_3").datepicker("destroy");
	   	$("#l3_9_3").val('');
	   	$("#l3_9_3").datepicker({
	        dateFormat: "yy/mm/dd",
	       	maxDate: $("#fecha7").val(),
	   		changeYear: true,
	       	changeMonth: true
	    });
	    $("#l3_10_3").prop("disabled", false);
	    $("#l3_10_3").datepicker("destroy");
	   	$("#l3_10_3").val('');
	   	$("#l3_10_3").datepicker({
	        dateFormat: "yy/mm/dd",
	       	maxDate: $("#fecha7").val(),
	   		changeYear: true,
	       	changeMonth: true
	    });
	},
  });
  $("#fecha8").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
    	$("#sitio").focus();
    },
  });
  $("#fecha10").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    minDate: "-45d",
    changeYear: true,
    changeMonth: true,
   	onSelect: function () {
    	$("#ordop1").focus();
  		$("#fecha9").prop("disabled", false);
      	$("#fecha9").datepicker("destroy");
      	$("#fecha9").val('');
      	$("#fecha9").datepicker({
   			dateFormat: "yy/mm/dd",
       		minDate: $("#fecha10").val(),
        	maxDate: 0,
        	changeYear: true,
       		changeMonth: true,
  			onSelect: function () {
  			  	$("#valor_p").focus();
			},
      	});
		$("#fecha2").prop("disabled", false);
      	$("#fecha2").datepicker("destroy");
      	$("#fecha2").val('');
		$("#fecha2").datepicker({
			dateFormat: "yy/mm/dd",
			minDate: $("#fecha10").val(),
		    maxDate: v_dias,
		    changeYear: true,
		    changeMonth: true,
		    onSelect: function () {
				$("#ced_1").focus();
		    },
		});
		$("#l3_1_3").prop("disabled", false);
		$("#l3_1_3").datepicker("destroy");
      	$("#l3_1_3").val('');
		$("#l3_1_3").datepicker({
		    dateFormat: "yy/mm/dd",
	    	minDate: $("#fecha10").val(),
		    maxDate: 0,
	   		changeYear: true,
		    changeMonth: true
		});
    },
  });
  $("#l3_3_3").datepicker({
    dateFormat: "yy/mm/dd",
    minDate: "-45d",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
  });
  $("#l3_4_3").datepicker({
    dateFormat: "yy/mm/dd",
    maxDate: 0,
    changeYear: true,
    changeMonth: true,
    onSelect: function () {
        $("#l3_5_3").datepicker("destroy");
        $("#l3_5_3").val('');
        $("#l3_5_3").datepicker({
            dateFormat: "yy/mm/dd",
            minDate: $("#l3_4_3").val(),
            maxDate: 0,
            changeYear: true,
            changeMonth: true,
        });
    },
  });
  $("#menu").accordion({
    collapsible: true
  });
  $("#tabs").tabs();
  $('#filtro').keyup(function () {
    var valthis = $(this).val().toLowerCase();
    var num = 0;
    $('select#unidad>option').each(function () {
      var text = $(this).text().toLowerCase();
      if(text.indexOf(valthis) !== -1)  
      {
        $(this).show(); $(this).prop('selected',true);
      }
      else
      {
        $(this).hide();
      }
    });
  });
  $('#filtro1').keyup(function () {
    var valthis = $(this).val().toLowerCase();
    var num = 0;
    $('select#unidad1>option').each(function () {
      var text = $(this).text().toLowerCase();
      if(text.indexOf(valthis) !== -1)  
      {
        $(this).show(); $(this).prop('selected',true);
      }
      else
      {
        $(this).hide();
      }
    });
    trae_brigada();
  });
  $('#filtro2').keyup(function () {
    var valthis = $(this).val().toLowerCase();
    var num = 0;
    $('select#municipio>option').each(function () {
      var text = $(this).text().toLowerCase();
      if(text.indexOf(valthis) !== -1)  
      {
        $(this).show(); $(this).prop('selected',true);
      }
      else
      {
        $(this).hide();
      }
    });
    trae_depto();
  });
  $("#valor").maskMoney();
  $("#valor_p").maskMoney();
  $("#pago").prop("disabled",true);
  $("#fecha9").prop("disabled",true);
  $("#valor_p").prop("disabled",true);
  $("#brigada").prop("disabled",true);
  $("#division").prop("disabled",true);
  $("#unidad1").change(trae_brigada);
  $("#aceptar").button();
  $("#aceptar1").button();
  $("#actualizar").button();
  $("#limpiar").button();
  $("#aceptar").click(pregunta);
  $("#aceptar1").click(solicitar);
  $("#actualizar").click(valida);
  $("#limpiar").click(limpiar);
  $("#actualizar").hide();
  $("#municipio").change(trae_depto);
  $("#departamento").change(trae_municipio);
  $("#departamento").prop("disabled",true);
  $("#factor").change(trae_estructura);
  $("#tipo_l3").buttonset();
  $("#sintesis").css('width',650);
  $("#resultado").css('width',650);
  $("#estado").prop("disabled",true);
  $("#observaciones").css('width',650);
  $("#consultar").button();
  $("#consultar").click(consultar);
  $("#aceptar1").hide();
  $("#lista1").hide();
  $("#lista2").hide();
  $("#lista3").hide();
  $("#lista3_o1").hide();
  $("#lista3_o2").hide();
  $("#lista3_o3").hide();
  $("#reco1").hide();
  $("#directiva").val('3');
  valida_direc();
  $("#directiva").change(valida_direc);
  $("#oficio").focus();
  // Lista  y 2
  for (i=1;i<=22;i++)
  {
  	$("#l1_"+i+"_2").prop("disabled",true);
  	$("#l1_"+i+"_3").prop("disabled",true);
  	$("#l1_"+i+"_4").prop("disabled",true);
   	$("#l1_"+i+"_5").prop("disabled",true);
  	$("#l2_"+i+"_2").prop("disabled",true);
  	$("#l2_"+i+"_4").prop("disabled",true);
    $("#l2_"+i+"_5").prop("disabled",true);
  	$("#l1_"+i+"_3").datepicker({
    	dateFormat: "yy/mm/dd",
   		maxDate: 0,
    	changeYear: true,
    	changeMonth: true,
  	});
  }
  // Lista 3
  for (i=1;i<=26;i++)
  {
  	$("#l3_"+i+"_2").prop("disabled",true);
  	$("#l3_"+i+"_4").prop("disabled",true);
  	$("#l3_"+i+"_5").prop("disabled",true);
  }
  trae_estruc();

  var MaxInputs       = 99;
  var InputsWrapper   = $("#add_form table tr");
  var AddButton       = $("#add_field");
  var x_1              = InputsWrapper.length;
  var FieldCount      = 1;
  $(AddButton).click(function (e) {
    if(x_1 <= MaxInputs)
    {
      var z = x_1;
      FieldCount++;
      if (z == "1")
      {
        $("#add_form table").append('<tr><td><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="c5" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="15" autocomplete="off"></td><td><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td><input type="text" name="por_'+z+'" id="por_'+z+'" class="c22" value="0.000" onblur="paso_val1('+z+');"><input type="hidden" name="pot_'+z+'" id="pot_'+z+'" class="c13" value="0"></td><td><a href="#" name="lnk_'+z+'" id="lnk_'+z+'" onclick="subir('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar C&eacute;dula"></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>');
      }
      else
      {
        $("#add_form table").append('<tr><td><input type="text" name="ced_'+z+'" id="ced_'+z+'" class="c5" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="15" autocomplete="off"></td><td><input type="text" name="nom_'+z+'" id="nom_'+z+'" class="c3" onchange="javascript:this.value=this.value.toUpperCase();" maxlength="60" autocomplete="off"></td><td><input type="text" name="por_'+z+'" id="por_'+z+'" class="c22" value="0.000" onblur="paso_val1('+z+');"><input type="hidden" name="pot_'+z+'" id="pot_'+z+'" class="c13" value="0"></td><td><a href="#" name="lnk_'+z+'" id="lnk_'+z+'" onclick="subir('+z+');"><img src="imagenes/clip.png" border="0" title="Anexar C&eacute;dula"></a></td><td><div id="men_'+z+'"><a href="#" class="removeclass"><img src="imagenes/boton2.jpg" border="0"></a></div></td></tr>');
      }
      x_1++;
    }
    return false;
  });
  $("body").on("click",".removeclass", function(e) {
    if(x_1 > 1)
    {
      $(this).closest('tr').remove();
      suma();
    }
    return false;
  })
  $("#add_field").click();
});
function subir(valor)
{
	var valor;
	var alea = $("#alea").val();
	var cedula = $("#ced_"+valor).val();
	var valida = 0;
	if (cedula == "")
	{
		valida = 0;
		var detalle = "Cédula de Fuente No Registrada, no se permite adjuntar imagen";
    	$("#dialogo2").html(detalle);
    	$("#dialogo2").dialog("open");
	}
	else
	{
		valida = 1;
		var url = "subir1.php?alea="+alea+"&conse="+valor+"&cedula="+cedula+"&valida="+valida;
  		window.open(url, this.target,'width=550, height=400, menubar=no, scrollbars=no, toolbar=no, location=no');
	}
}
function subir1()
{
	var alea = $("#alea").val();
	var url = "subir2.php?alea="+alea;
  	window.open(url, this.target,'width=550, height=400, menubar=no, scrollbars=no, toolbar=no, location=no');
}
function subir2()
{
	var alea = $("#alea").val();
	var url = "subir3.php?alea="+alea;
  	window.open(url, this.target,'width=550, height=400, menubar=no, scrollbars=no, toolbar=no, location=no');
}
// Valida numero de ordop
function val_ordop()
{
  var conse = $("#conse").val();
  var ordop = $("#ordop1").val();
  if (ordop == "")
  {
    $("#aceptar").hide();
    $("#actualizar").hide();
  }
  else
  {
    var ordop1 = $("#ordop1");
    var allFields = $([]).add(ordop1);
    var valid = true;
    ordop1.removeClass("ui-state-error");
    valid = checkRegexp(ordop1, /^([0-9])+$/, "Solo se premite caracteres: 0 - 9");
    if (valid == false)
    {
      $("#aceptar").hide();
      $("#actualizar").hide();
    }
    else
    {
      if (conse > 0)
      {
        $("#actualizar").show();
        $("#aceptar").hide();
      }
      else
      {
        $("#actualizar").hide();
        $("#aceptar").show();
      }
    }    
  }
}
function checkRegexp(o, regexp, n)
{
  if (!(regexp.test(o.val())))
  {
    o.addClass("ui-state-error");
    $("#dialogo").html(n);
    $("#dialogo").dialog("open");
    return false;
  }
  else
  {
    return true;
  }
}
function trae_brigada()
{
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "trae_brig1.php",
      data:
      {
        unidad: $("#unidad1").val()
      },
      success: function (data)
      {
        var registros = JSON.parse(data);
        $("#brigada").val(registros.brigada);
        $("#division").val(registros.division);
      }
    });
}
function paso_val()
{
  var valor;
  var valor1;
  valor1=document.getElementById('valor').value;
  valor1=parseFloat(valor1.replace(/,/g,''));
  $("#valor1").val(valor1);
}
// Pasa valor de porcentajes de fuentes
function paso_val1(valor)
{
  var valor;
  var valor1;
  valor1=document.getElementById('por_'+valor).value;
  if ($.isNumeric(valor1))
  {
    var value=parseFloat(valor1).toFixed(3);
    $("#por_"+valor).val(value);
  }
  else
  {
    $("#por_"+valor).val('0.000');
  }
  valor1=parseFloat(valor1.replace(/,/g,''));
  $("#pot_"+valor).val(valor1);
  suma();
}
// Paso valor pago previo fuente
function paso_val2()
{
  var valor;
  var valor1;
  valor1=document.getElementById('valor_p').value;
  valor1=parseFloat(valor1.replace(/,/g,''));
  $("#valor_p1").val(valor1);
}
// Activacion pago previo
function previo()
{
	if (document.getElementById('pag_prev').checked)
	{
		document.getElementById('pago').removeAttribute("disabled");
		document.getElementById('fecha9').removeAttribute("disabled");
		document.getElementById('valor_p').removeAttribute("disabled");
		$("#pago").focus();
	}
	else
	{
		$("#pago").val("0");
		$("#fecha9").val("");
		$("#valor_p").val("0");
		paso_val2();
		$("#pago").prop("disabled",true);
		$("#fecha9").prop("disabled",true);
		$("#valor_p").prop("disabled",true);
	}
}
// Suma porcentajes de las fuentes para validar el 100 %
function suma()
{
  var valor;
  var valor1;
  valor = 0;
  valor1 = 0;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('pot_')!=-1)
    {
      valor=document.getElementById(saux).value;
      valor=parseFloat(valor);
      valor1=valor1+valor;
    }
  }
  valor1=valor1.toFixed(3).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  $("#porcentaje").val(valor1);
}
// Trae municipio segun departamento seleccionado
function trae_municipio()
{
  $("#municipio").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_muni.php",
    data:
    {
      departamento: $("#departamento").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#municipio").append(salida);
    }
  });
}
// Trae departamento segun municipio seleccionado
function trae_depto()
{
  var valida;
  valida = $("#municipio").val();
  $("#departamento").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_dpto.php",
    data:
    {
      municipio: $("#municipio").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#departamento").append(salida);
    }
  });
}
// Trae listado estrcuturas
function trae_estruc()
{
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estruc.php",
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      $("#paso1").val(salida);
    }
  });
}
// Trae estrcuturas segun factor seleccionado
function trae_estructura()
{
  $("#estructura").html('');
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_estr.php",
    data:
    {
      factor: $("#factor").val()
    },
    success: function (data)
    {
      var registros = JSON.parse(data);
      var salida = "";
      for (var i in registros) 
      {
          var codigo = registros[i].codigo;
          var nombre = registros[i].nombre;
          salida+="<option value='"+codigo+"'>"+nombre+"</option>";
      }
      salida+="<option value='999'>N/A</option>";
      $("#estructura").append(salida);
    }
  });
}
function pregunta()
{
  var detalle="Esta seguro de continuar ?";
  $("#dialogo1").html(detalle);
  $("#dialogo1").dialog("open");
}
function val_lista1()
{
	if (document.getElementById('l1_1_1').checked)
	{
		document.getElementById('l1_1_2').removeAttribute("disabled");
		document.getElementById('l1_1_3').removeAttribute("disabled");
		document.getElementById('l1_1_4').removeAttribute("disabled");
		document.getElementById('l1_1_5').removeAttribute("disabled");
		$("#l1_1_2").focus();
	}
	else
	{
		$("#l1_1_2").val("0");
		$("#l1_1_3").val("");
		$("#l1_1_4").val("0");
		$("#l1_1_5").val("0");
		$("#l1_1_2").prop("disabled",true);
		$("#l1_1_3").prop("disabled",true);
		$("#l1_1_4").prop("disabled",true);
		$("#l1_1_5").prop("disabled",true);
	}
	if (document.getElementById('l1_2_1').checked)
	{
		document.getElementById('l1_2_2').removeAttribute("disabled");
		document.getElementById('l1_2_3').removeAttribute("disabled");
		document.getElementById('l1_2_4').removeAttribute("disabled");
		document.getElementById('l1_2_5').removeAttribute("disabled");
		$("#l1_2_2").focus();
	}
	else
	{
		$("#l1_2_2").val("0");
		$("#l1_2_3").val("");
		$("#l1_2_4").val("0");
		$("#l1_2_5").val("0");
		$("#l1_2_2").prop("disabled",true);
		$("#l1_2_3").prop("disabled",true);
		$("#l1_2_4").prop("disabled",true);
		$("#l1_2_5").prop("disabled",true);
	}
	if (document.getElementById('l1_3_1').checked)
	{
		document.getElementById('l1_3_2').removeAttribute("disabled");
		document.getElementById('l1_3_3').removeAttribute("disabled");
		document.getElementById('l1_3_4').removeAttribute("disabled");
		document.getElementById('l1_3_5').removeAttribute("disabled");
		$("#l1_3_2").focus();
	}
	else
	{
		$("#l1_3_2").val("0");
		$("#l1_3_3").val("");
		$("#l1_3_4").val("0");
		$("#l1_3_5").val("0");
		$("#l1_3_2").prop("disabled",true);
		$("#l1_3_3").prop("disabled",true);
		$("#l1_3_4").prop("disabled",true);
		$("#l1_3_5").prop("disabled",true);
	}
	if (document.getElementById('l1_4_1').checked)
	{
		document.getElementById('l1_4_2').removeAttribute("disabled");
		document.getElementById('l1_4_3').removeAttribute("disabled");
		document.getElementById('l1_4_4').removeAttribute("disabled");
		document.getElementById('l1_4_5').removeAttribute("disabled");
		$("#l1_4_2").focus();
	}
	else
	{
		$("#l1_4_2").val("0");
		$("#l1_4_3").val("");
		$("#l1_4_4").val("0");
		$("#l1_4_5").val("0");
		$("#l1_4_2").prop("disabled",true);
		$("#l1_4_3").prop("disabled",true);
		$("#l1_4_4").prop("disabled",true);
		$("#l1_4_5").prop("disabled",true);
	}
	if (document.getElementById('l1_5_1').checked)
	{
		document.getElementById('l1_5_2').removeAttribute("disabled");
		document.getElementById('l1_5_3').removeAttribute("disabled");
		document.getElementById('l1_5_4').removeAttribute("disabled");
		document.getElementById('l1_5_5').removeAttribute("disabled");
		$("#l1_5_2").focus();
	}
	else
	{
		$("#l1_5_2").val("0");
		$("#l1_5_3").val("");
		$("#l1_5_4").val("0");
		$("#l1_5_5").val("0");
		$("#l1_5_2").prop("disabled",true);
		$("#l1_5_3").prop("disabled",true);
		$("#l1_5_4").prop("disabled",true);
		$("#l1_5_5").prop("disabled",true);
	}
	if (document.getElementById('l1_6_1').checked)
	{
		document.getElementById('l1_6_2').removeAttribute("disabled");
		document.getElementById('l1_6_3').removeAttribute("disabled");
		document.getElementById('l1_6_4').removeAttribute("disabled");
		document.getElementById('l1_6_5').removeAttribute("disabled");
		$("#l1_6_2").focus();
	}
	else
	{
		$("#l1_6_2").val("0");
		$("#l1_6_3").val("");
		$("#l1_6_4").val("0");
		$("#l1_6_5").val("0");
		$("#l1_6_2").prop("disabled",true);
		$("#l1_6_3").prop("disabled",true);
		$("#l1_6_4").prop("disabled",true);
		$("#l1_6_5").prop("disabled",true);
	}
	if (document.getElementById('l1_7_1').checked)
	{
		document.getElementById('l1_7_2').removeAttribute("disabled");
		document.getElementById('l1_7_3').removeAttribute("disabled");
		document.getElementById('l1_7_4').removeAttribute("disabled");
		document.getElementById('l1_7_5').removeAttribute("disabled");
		$("#l1_7_2").focus();
	}
	else
	{
		$("#l1_7_2").val("0");
		$("#l1_7_3").val("");
		$("#l1_7_4").val("0");
		$("#l1_7_5").val("0");
		$("#l1_7_2").prop("disabled",true);
		$("#l1_7_3").prop("disabled",true);
		$("#l1_7_4").prop("disabled",true);
		$("#l1_7_5").prop("disabled",true);
	}
	if (document.getElementById('l1_8_1').checked)
	{
		document.getElementById('l1_8_2').removeAttribute("disabled");
		document.getElementById('l1_8_3').removeAttribute("disabled");
		document.getElementById('l1_8_4').removeAttribute("disabled");
		document.getElementById('l1_8_5').removeAttribute("disabled");
		$("#l1_8_2").focus();
	}
	else
	{
		$("#l1_8_2").val("0");
		$("#l1_8_3").val("");
		$("#l1_8_4").val("0");
		$("#l1_8_5").val("0");
		$("#l1_8_2").prop("disabled",true);
		$("#l1_8_3").prop("disabled",true);
		$("#l1_8_4").prop("disabled",true);
		$("#l1_8_5").prop("disabled",true);
	}
	if (document.getElementById('l1_9_1').checked)
	{
		document.getElementById('l1_9_2').removeAttribute("disabled");
		document.getElementById('l1_9_3').removeAttribute("disabled");
		document.getElementById('l1_9_4').removeAttribute("disabled");
		document.getElementById('l1_9_5').removeAttribute("disabled");
		$("#l1_9_2").focus();
	}
	else
	{
		$("#l1_9_2").val("0");
		$("#l1_9_3").val("");
		$("#l1_9_4").val("0");
		$("#l1_9_5").val("0");
		$("#l1_9_2").prop("disabled",true);
		$("#l1_9_3").prop("disabled",true);
		$("#l1_9_4").prop("disabled",true);
		$("#l1_9_5").prop("disabled",true);
	}
	if (document.getElementById('l1_10_1').checked)
	{
		document.getElementById('l1_10_2').removeAttribute("disabled");
		document.getElementById('l1_10_3').removeAttribute("disabled");
		document.getElementById('l1_10_4').removeAttribute("disabled");
		document.getElementById('l1_10_5').removeAttribute("disabled");
		$("#l1_10_2").focus();
	}
	else
	{
		$("#l1_10_2").val("0");
		$("#l1_10_3").val("");
		$("#l1_10_4").val("0");
		$("#l1_10_5").val("0");
		$("#l1_10_2").prop("disabled",true);
		$("#l1_10_3").prop("disabled",true);
		$("#l1_10_4").prop("disabled",true);
		$("#l1_10_5").prop("disabled",true);
	}
	if (document.getElementById('l1_11_1').checked)
	{
		document.getElementById('l1_11_2').removeAttribute("disabled");
		document.getElementById('l1_11_4').removeAttribute("disabled");
		document.getElementById('l1_11_4').removeAttribute("disabled");
		document.getElementById('l1_11_5').removeAttribute("disabled");
		$("#l1_11_2").focus();
	}
	else
	{
		$("#l1_11_2").val("0");
		$("#l1_11_3").val("");
		$("#l1_11_4").val("0");
		$("#l1_11_5").val("0");
		$("#l1_11_2").prop("disabled",true);
		$("#l1_11_3").prop("disabled",true);
		$("#l1_11_4").prop("disabled",true);
		$("#l1_11_5").prop("disabled",true);
	}
	if (document.getElementById('l1_12_1').checked)
	{
		document.getElementById('l1_12_2').removeAttribute("disabled");
		document.getElementById('l1_12_3').removeAttribute("disabled");
		document.getElementById('l1_12_4').removeAttribute("disabled");
		document.getElementById('l1_12_5').removeAttribute("disabled");
		$("#l1_12_2").focus();
	}
	else
	{
		$("#l1_12_2").val("0");
		$("#l1_12_3").val("");
		$("#l1_12_4").val("0");
		$("#l1_12_5").val("0");
		$("#l1_12_2").prop("disabled",true);
		$("#l1_12_3").prop("disabled",true);
		$("#l1_12_4").prop("disabled",true);
		$("#l1_12_5").prop("disabled",true);
	}
	if (document.getElementById('l1_13_1').checked)
	{
		document.getElementById('l1_13_2').removeAttribute("disabled");
		document.getElementById('l1_13_3').removeAttribute("disabled");
		document.getElementById('l1_13_4').removeAttribute("disabled");
		document.getElementById('l1_13_5').removeAttribute("disabled");
		$("#l1_13_2").focus();
	}
	else
	{
		$("#l1_13_2").val("0");
		$("#l1_13_3").val("");
		$("#l1_13_4").val("0");
		$("#l1_13_5").val("0");
		$("#l1_13_2").prop("disabled",true);
		$("#l1_13_3").prop("disabled",true);
		$("#l1_13_4").prop("disabled",true);
		$("#l1_13_5").prop("disabled",true);
	}
	if (document.getElementById('l1_14_1').checked)
	{
		document.getElementById('l1_14_2').removeAttribute("disabled");
		document.getElementById('l1_14_3').removeAttribute("disabled");
		document.getElementById('l1_14_4').removeAttribute("disabled");
		document.getElementById('l1_14_5').removeAttribute("disabled");
		$("#l1_14_2").focus();
	}
	else
	{
		$("#l1_14_2").val("0");
		$("#l1_14_3").val("");
		$("#l1_14_4").val("0");
		$("#l1_14_5").val("0");
		$("#l1_14_2").prop("disabled",true);
		$("#l1_14_3").prop("disabled",true);
		$("#l1_14_4").prop("disabled",true);
		$("#l1_14_5").prop("disabled",true);
	}
	if (document.getElementById('l1_15_1').checked)
	{
		document.getElementById('l1_15_2').removeAttribute("disabled");
		document.getElementById('l1_15_3').removeAttribute("disabled");
		document.getElementById('l1_15_4').removeAttribute("disabled");
		document.getElementById('l1_15_5').removeAttribute("disabled");
		$("#l1_15_2").focus();
	}
	else
	{
		$("#l1_15_2").val("0");
		$("#l1_15_3").val("");
		$("#l1_15_4").val("0");
		$("#l1_15_5").val("0");
		$("#l1_15_2").prop("disabled",true);
		$("#l1_15_3").prop("disabled",true);
		$("#l1_15_4").prop("disabled",true);
		$("#l1_15_5").prop("disabled",true);
	}
	if (document.getElementById('l1_16_1').checked)
	{
		document.getElementById('l1_16_2').removeAttribute("disabled");
		document.getElementById('l1_16_3').removeAttribute("disabled");
		document.getElementById('l1_16_4').removeAttribute("disabled");
		document.getElementById('l1_16_5').removeAttribute("disabled");
		$("#l1_16_2").focus();
	}
	else
	{
		$("#l1_16_2").val("0");
		$("#l1_16_3").val("");
		$("#l1_16_4").val("0");
		$("#l1_16_5").val("0");
		$("#l1_16_2").prop("disabled",true);
		$("#l1_16_3").prop("disabled",true);
		$("#l1_16_4").prop("disabled",true);
		$("#l1_16_5").prop("disabled",true);
	}
	if (document.getElementById('l1_17_1').checked)
	{
		document.getElementById('l1_17_2').removeAttribute("disabled");
		document.getElementById('l1_17_3').removeAttribute("disabled");
		document.getElementById('l1_17_4').removeAttribute("disabled");
		document.getElementById('l1_17_5').removeAttribute("disabled");
		$("#l1_17_2").focus();
	}
	else
	{
		$("#l1_17_2").val("0");
		$("#l1_17_3").val("");
		$("#l1_17_4").val("0");
		$("#l1_17_5").val("0");
		$("#l1_17_2").prop("disabled",true);
		$("#l1_17_3").prop("disabled",true);
		$("#l1_17_4").prop("disabled",true);
		$("#l1_17_5").prop("disabled",true);
	}
	if (document.getElementById('l1_18_1').checked)
	{
		document.getElementById('l1_18_2').removeAttribute("disabled");
		document.getElementById('l1_18_3').removeAttribute("disabled");
		document.getElementById('l1_18_4').removeAttribute("disabled");
		document.getElementById('l1_18_5').removeAttribute("disabled");
		$("#l1_18_2").focus();
	}
	else
	{
		$("#l1_18_2").val("0");
		$("#l1_18_3").val("");
		$("#l1_18_2").prop("disabled",true);
		$("#l1_18_3").prop("disabled",true);
		$("#l1_18_4").prop("disabled",true);
		$("#l1_18_5").prop("disabled",true);
	}
	if (document.getElementById('l1_19_1').checked)
	{
		document.getElementById('l1_19_2').removeAttribute("disabled");
		document.getElementById('l1_19_3').removeAttribute("disabled");
		document.getElementById('l1_19_4').removeAttribute("disabled");
		document.getElementById('l1_19_5').removeAttribute("disabled");
		$("#l1_19_2").focus();
	}
	else
	{
		$("#l1_19_2").val("0");
		$("#l1_19_3").val("");
		$("#l1_19_4").val("0");
		$("#l1_19_5").val("0");
		$("#l1_19_2").prop("disabled",true);
		$("#l1_19_3").prop("disabled",true);
		$("#l1_19_4").prop("disabled",true);
		$("#l1_19_5").prop("disabled",true);
	}
	if (document.getElementById('l1_20_1').checked)
	{
		document.getElementById('l1_20_2').removeAttribute("disabled");
		document.getElementById('l1_20_3').removeAttribute("disabled");
		document.getElementById('l1_20_4').removeAttribute("disabled");
		document.getElementById('l1_20_5').removeAttribute("disabled");
		$("#l1_20_2").focus();
	}
	else
	{
		$("#l1_20_2").val("0");
		$("#l1_20_3").val("");
		$("#l1_20_4").val("0");
		$("#l1_20_5").val("0");
		$("#l1_20_2").prop("disabled",true);
		$("#l1_20_3").prop("disabled",true);
		$("#l1_20_4").prop("disabled",true);
		$("#l1_20_5").prop("disabled",true);
	}
	if (document.getElementById('l1_21_1').checked)
	{
		document.getElementById('l1_21_2').removeAttribute("disabled");
		document.getElementById('l1_21_3').removeAttribute("disabled");
		document.getElementById('l1_21_4').removeAttribute("disabled");
		document.getElementById('l1_21_5').removeAttribute("disabled");
		$("#l1_21_2").focus();
	}
	else
	{
		$("#l1_21_2").val("0");
		$("#l1_21_3").val("");
		$("#l1_21_4").val("0");
		$("#l1_21_5").val("0");
		$("#l1_21_2").prop("disabled",true);
		$("#l1_21_3").prop("disabled",true);
		$("#l1_21_4").prop("disabled",true);
		$("#l1_21_5").prop("disabled",true);
	}
	if (document.getElementById('l1_22_1').checked)
	{
		document.getElementById('l1_22_2').removeAttribute("disabled");
		document.getElementById('l1_22_3').removeAttribute("disabled");
		document.getElementById('l1_22_4').removeAttribute("disabled");
		document.getElementById('l1_22_5').removeAttribute("disabled");
		$("#l1_22_2").focus();
	}
	else
	{
		$("#l1_22_2").val("0");
		$("#l1_22_3").val("");
		$("#l1_22_4").val("0");
		$("#l1_22_5").val("0");
		$("#l1_22_2").prop("disabled",true);
		$("#l1_22_3").prop("disabled",true);
		$("#l1_22_4").prop("disabled",true);
		$("#l1_22_5").prop("disabled",true);
	}
}
// Validaciones lista 2
function val_lista2()
{
	if (document.getElementById('l2_1_1').checked)
	{
		document.getElementById('l2_1_2').removeAttribute("disabled");
		document.getElementById('l2_1_3').removeAttribute("disabled");
		document.getElementById('l2_1_4').removeAttribute("disabled");
		document.getElementById('l2_1_5').removeAttribute("disabled");
		$("#l2_1_2").focus();
	}
	else
	{
		$("#l2_1_2").val("0");
		$("#l2_1_3").val("");
		$("#l2_1_4").val("0");
		$("#l2_1_5").val("0");
		$("#l2_1_2").prop("disabled",true);
		$("#l2_1_3").prop("disabled",true);
		$("#l2_1_4").prop("disabled",true);
		$("#l2_1_5").prop("disabled",true);
	}
	if (document.getElementById('l2_2_1').checked)
	{
		document.getElementById('l2_2_2').removeAttribute("disabled");
		document.getElementById('l2_2_3').removeAttribute("disabled");
		document.getElementById('l2_2_4').removeAttribute("disabled");
		document.getElementById('l2_2_5').removeAttribute("disabled");
		$("#l2_2_2").focus();
	}
	else
	{
		$("#l2_2_2").val("0");
		$("#l2_2_3").val("");
		$("#l2_2_4").val("0");
		$("#l2_2_5").val("0");
		$("#l2_2_2").prop("disabled",true);
		$("#l2_2_3").prop("disabled",true);
		$("#l2_2_4").prop("disabled",true);
		$("#l2_2_5").prop("disabled",true);
	}
	if (document.getElementById('l2_3_1').checked)
	{
		document.getElementById('l2_3_2').removeAttribute("disabled");
		document.getElementById('l2_3_3').removeAttribute("disabled");
		document.getElementById('l2_3_4').removeAttribute("disabled");
		document.getElementById('l2_3_5').removeAttribute("disabled");
		$("#l2_3_2").focus();
	}
	else
	{
		$("#l2_3_2").val("0");
		$("#l2_3_3").val("");
		$("#l2_3_4").val("0");
		$("#l2_3_5").val("0");
		$("#l2_3_2").prop("disabled",true);
		$("#l2_3_3").prop("disabled",true);
		$("#l2_3_4").prop("disabled",true);
		$("#l2_3_5").prop("disabled",true);
	}
	if (document.getElementById('l2_4_1').checked)
	{
		document.getElementById('l2_4_2').removeAttribute("disabled");
		document.getElementById('l2_4_3').removeAttribute("disabled");
		document.getElementById('l2_4_4').removeAttribute("disabled");
		document.getElementById('l2_4_5').removeAttribute("disabled");
		$("#l2_4_2").focus();
	}
	else
	{
		$("#l2_4_2").val("0");
		$("#l2_4_3").val("");
		$("#l2_4_4").val("0");
		$("#l2_4_5").val("0");
		$("#l2_4_2").prop("disabled",true);
		$("#l2_4_3").prop("disabled",true);
		$("#l2_4_4").prop("disabled",true);
		$("#l2_4_5").prop("disabled",true);
	}
	if (document.getElementById('l2_5_1').checked)
	{
		document.getElementById('l2_5_2').removeAttribute("disabled");
		document.getElementById('l2_5_3').removeAttribute("disabled");
		document.getElementById('l2_5_4').removeAttribute("disabled");
		document.getElementById('l2_5_5').removeAttribute("disabled");
		$("#l2_5_2").focus();
	}
	else
	{
		$("#l2_5_2").val("0");
		$("#l2_5_3").val("");
		$("#l2_5_4").val("0");
		$("#l2_5_5").val("0");
		$("#l2_5_2").prop("disabled",true);
		$("#l2_5_3").prop("disabled",true);
		$("#l2_5_4").prop("disabled",true);
		$("#l2_5_5").prop("disabled",true);
	}
	if (document.getElementById('l2_6_1').checked)
	{
		document.getElementById('l2_6_2').removeAttribute("disabled");
		document.getElementById('l2_6_3').removeAttribute("disabled");
		document.getElementById('l2_6_4').removeAttribute("disabled");
		document.getElementById('l2_6_5').removeAttribute("disabled");
		$("#l2_6_2").focus();
	}
	else
	{
		$("#l2_6_2").val("0");
		$("#l2_6_3").val("");
		$("#l2_6_4").val("0");
		$("#l2_6_5").val("0");
		$("#l2_6_2").prop("disabled",true);
		$("#l2_6_3").prop("disabled",true);
		$("#l2_6_4").prop("disabled",true);
		$("#l2_6_5").prop("disabled",true);
	}
	if (document.getElementById('l2_7_1').checked)
	{
		document.getElementById('l2_7_2').removeAttribute("disabled");
		document.getElementById('l2_7_3').removeAttribute("disabled");
		document.getElementById('l2_7_4').removeAttribute("disabled");
		document.getElementById('l2_7_5').removeAttribute("disabled");
		$("#l2_7_2").focus();
	}
	else
	{
		$("#l2_7_2").val("0");
		$("#l2_7_3").val("");
		$("#l2_7_4").val("0");
		$("#l2_7_5").val("0");
		$("#l2_7_2").prop("disabled",true);
		$("#l2_7_3").prop("disabled",true);
		$("#l2_7_4").prop("disabled",true);
		$("#l2_7_5").prop("disabled",true);
	}
	if (document.getElementById('l2_8_1').checked)
	{
		document.getElementById('l2_8_2').removeAttribute("disabled");
		document.getElementById('l2_8_3').removeAttribute("disabled");
		document.getElementById('l2_8_4').removeAttribute("disabled");
		document.getElementById('l2_8_5').removeAttribute("disabled");
		$("#l2_8_2").focus();
	}
	else
	{
		$("#l2_8_2").val("0");
		$("#l2_8_3").val("");
		$("#l2_8_4").val("0");
		$("#l2_8_5").val("0");
		$("#l2_8_2").prop("disabled",true);
		$("#l2_8_3").prop("disabled",true);
		$("#l2_8_4").prop("disabled",true);
		$("#l2_8_5").prop("disabled",true);
	}
	if (document.getElementById('l2_9_1').checked)
	{
		document.getElementById('l2_9_2').removeAttribute("disabled");
		document.getElementById('l2_9_3').removeAttribute("disabled");
		document.getElementById('l2_9_4').removeAttribute("disabled");
		document.getElementById('l2_9_5').removeAttribute("disabled");
		$("#l2_9_2").focus();
	}
	else
	{
		$("#l2_9_2").val("0");
		$("#l2_9_3").val("");
		$("#l2_9_4").val("0");
		$("#l2_9_5").val("0");
		$("#l2_9_2").prop("disabled",true);
		$("#l2_9_3").prop("disabled",true);
		$("#l2_9_4").prop("disabled",true);
		$("#l2_9_5").prop("disabled",true);
	}
	if (document.getElementById('l2_10_1').checked)
	{
		document.getElementById('l2_10_2').removeAttribute("disabled");
		document.getElementById('l2_10_3').removeAttribute("disabled");
		document.getElementById('l2_10_4').removeAttribute("disabled");
		document.getElementById('l2_10_5').removeAttribute("disabled");
		$("#l2_10_2").focus();
	}
	else
	{
		$("#l2_10_2").val("0");
		$("#l2_10_3").val("");
		$("#l2_10_4").val("0");
		$("#l2_10_5").val("0");
		$("#l2_10_2").prop("disabled",true);
		$("#l2_10_3").prop("disabled",true);
		$("#l2_10_4").prop("disabled",true);
		$("#l2_10_5").prop("disabled",true);
	}
	if (document.getElementById('l2_11_1').checked)
	{
		document.getElementById('l2_11_2').removeAttribute("disabled");
		document.getElementById('l2_11_4').removeAttribute("disabled");
		document.getElementById('l2_11_4').removeAttribute("disabled");
		document.getElementById('l2_11_5').removeAttribute("disabled");
		$("#l2_11_2").focus();
	}
	else
	{
		$("#l2_11_2").val("0");
		$("#l2_11_3").val("");
		$("#l2_11_4").val("0");
		$("#l2_11_5").val("0");
		$("#l2_11_2").prop("disabled",true);
		$("#l2_11_3").prop("disabled",true);
		$("#l2_11_4").prop("disabled",true);
		$("#l2_11_5").prop("disabled",true);
	}
	if (document.getElementById('l2_12_1').checked)
	{
		document.getElementById('l2_12_2').removeAttribute("disabled");
		document.getElementById('l2_12_3').removeAttribute("disabled");
		document.getElementById('l2_12_4').removeAttribute("disabled");
		document.getElementById('l2_12_5').removeAttribute("disabled");
		$("#l2_12_2").focus();
	}
	else
	{
		$("#l2_12_2").val("0");
		$("#l2_12_3").val("");
		$("#l2_12_4").val("0");
		$("#l2_12_5").val("0");
		$("#l2_12_2").prop("disabled",true);
		$("#l2_12_3").prop("disabled",true);
		$("#l2_12_4").prop("disabled",true);
		$("#l2_12_5").prop("disabled",true);
	}
	if (document.getElementById('l2_13_1').checked)
	{
		document.getElementById('l2_13_2').removeAttribute("disabled");
		document.getElementById('l2_13_3').removeAttribute("disabled");
		document.getElementById('l2_13_4').removeAttribute("disabled");
		document.getElementById('l2_13_5').removeAttribute("disabled");
		$("#l2_13_2").focus();
	}
	else
	{
		$("#l2_13_2").val("0");
		$("#l2_13_3").val("");
		$("#l2_13_4").val("0");
		$("#l2_13_5").val("0");
		$("#l2_13_2").prop("disabled",true);
		$("#l2_13_3").prop("disabled",true);
		$("#l2_13_4").prop("disabled",true);
		$("#l2_13_5").prop("disabled",true);
	}
	if (document.getElementById('l2_14_1').checked)
	{
		document.getElementById('l2_14_2').removeAttribute("disabled");
		document.getElementById('l2_14_3').removeAttribute("disabled");
		document.getElementById('l2_14_4').removeAttribute("disabled");
		document.getElementById('l2_14_5').removeAttribute("disabled");
		$("#l2_14_2").focus();
	}
	else
	{
		$("#l2_14_2").val("0");
		$("#l2_14_3").val("");
		$("#l2_14_4").val("0");
		$("#l2_14_5").val("0");
		$("#l2_14_2").prop("disabled",true);
		$("#l2_14_3").prop("disabled",true);
		$("#l2_14_4").prop("disabled",true);
		$("#l2_14_5").prop("disabled",true);
	}
	if (document.getElementById('l2_15_1').checked)
	{
		document.getElementById('l2_15_2').removeAttribute("disabled");
		document.getElementById('l2_15_3').removeAttribute("disabled");
		document.getElementById('l2_15_4').removeAttribute("disabled");
		document.getElementById('l2_15_5').removeAttribute("disabled");
		$("#l2_15_2").focus();
	}
	else
	{
		$("#l2_15_2").val("0");
		$("#l2_15_3").val("");
		$("#l2_15_4").val("0");
		$("#l2_15_5").val("0");
		$("#l2_15_2").prop("disabled",true);
		$("#l2_15_3").prop("disabled",true);
		$("#l2_15_4").prop("disabled",true);
		$("#l2_15_5").prop("disabled",true);
	}
	if (document.getElementById('l2_16_1').checked)
	{
		document.getElementById('l2_16_2').removeAttribute("disabled");
		document.getElementById('l2_16_3').removeAttribute("disabled");
		document.getElementById('l2_16_4').removeAttribute("disabled");
		document.getElementById('l2_16_5').removeAttribute("disabled");
		$("#l2_16_2").focus();
	}
	else
	{
		$("#l2_16_2").val("0");
		$("#l2_16_3").val("");
		$("#l2_16_4").val("0");
		$("#l2_16_5").val("0");
		$("#l2_16_2").prop("disabled",true);
		$("#l2_16_3").prop("disabled",true);
		$("#l2_16_4").prop("disabled",true);
		$("#l2_16_5").prop("disabled",true);
	}
	if (document.getElementById('l2_17_1').checked)
	{
		document.getElementById('l2_17_2').removeAttribute("disabled");
		document.getElementById('l2_17_3').removeAttribute("disabled");
		document.getElementById('l2_17_4').removeAttribute("disabled");
		document.getElementById('l2_17_5').removeAttribute("disabled");
		$("#l2_17_2").focus();
	}
	else
	{
		$("#l2_17_2").val("0");
		$("#l2_17_3").val("");
		$("#l2_17_4").val("0");
		$("#l2_17_5").val("0");
		$("#l2_17_2").prop("disabled",true);
		$("#l2_17_3").prop("disabled",true);
		$("#l2_17_4").prop("disabled",true);
		$("#l2_17_5").prop("disabled",true);
	}
	if (document.getElementById('l2_18_1').checked)
	{
		document.getElementById('l2_18_2').removeAttribute("disabled");
		document.getElementById('l2_18_3').removeAttribute("disabled");
		document.getElementById('l2_18_4').removeAttribute("disabled");
		document.getElementById('l2_18_5').removeAttribute("disabled");
		$("#l2_18_2").focus();
	}
	else
	{
		$("#l2_18_2").val("0");
		$("#l2_18_3").val("");
		$("#l2_18_2").prop("disabled",true);
		$("#l2_18_3").prop("disabled",true);
		$("#l2_18_4").prop("disabled",true);
		$("#l2_18_5").prop("disabled",true);
	}
	if (document.getElementById('l2_19_1').checked)
	{
		document.getElementById('l2_19_2').removeAttribute("disabled");
		document.getElementById('l2_19_3').removeAttribute("disabled");
		document.getElementById('l2_19_4').removeAttribute("disabled");
		document.getElementById('l2_19_5').removeAttribute("disabled");
		$("#l2_19_2").focus();
	}
	else
	{
		$("#l2_19_2").val("0");
		$("#l2_19_3").val("");
		$("#l2_19_4").val("0");
		$("#l2_19_5").val("0");
		$("#l2_19_2").prop("disabled",true);
		$("#l2_19_3").prop("disabled",true);
		$("#l2_19_4").prop("disabled",true);
		$("#l2_19_5").prop("disabled",true);
	}
	if (document.getElementById('l2_20_1').checked)
	{
		document.getElementById('l2_20_2').removeAttribute("disabled");
		document.getElementById('l2_20_3').removeAttribute("disabled");
		document.getElementById('l2_20_4').removeAttribute("disabled");
		document.getElementById('l2_20_5').removeAttribute("disabled");
		$("#l2_20_2").focus();
	}
	else
	{
		$("#l2_20_2").val("0");
		$("#l2_20_3").val("");
		$("#l2_20_4").val("0");
		$("#l2_20_5").val("0");
		$("#l2_20_2").prop("disabled",true);
		$("#l2_20_3").prop("disabled",true);
		$("#l2_20_4").prop("disabled",true);
		$("#l2_20_5").prop("disabled",true);
	}
	if (document.getElementById('l2_21_1').checked)
	{
		document.getElementById('l2_21_2').removeAttribute("disabled");
		document.getElementById('l2_21_3').removeAttribute("disabled");
		document.getElementById('l2_21_4').removeAttribute("disabled");
		document.getElementById('l2_21_5').removeAttribute("disabled");
		$("#l2_21_2").focus();
	}
	else
	{
		$("#l2_21_2").val("0");
		$("#l2_21_3").val("");
		$("#l2_21_4").val("0");
		$("#l2_21_5").val("0");
		$("#l2_21_2").prop("disabled",true);
		$("#l2_21_3").prop("disabled",true);
		$("#l2_21_4").prop("disabled",true);
		$("#l2_21_5").prop("disabled",true);
	}
	if (document.getElementById('l2_22_1').checked)
	{
		document.getElementById('l2_22_2').removeAttribute("disabled");
		document.getElementById('l2_22_3').removeAttribute("disabled");
		document.getElementById('l2_22_4').removeAttribute("disabled");
		document.getElementById('l2_22_5').removeAttribute("disabled");
		$("#l2_22_2").focus();
	}
	else
	{
		$("#l2_22_2").val("0");
		$("#l2_22_3").val("");
		$("#l2_22_4").val("0");
		$("#l2_22_5").val("0");
		$("#l2_22_2").prop("disabled",true);
		$("#l2_22_3").prop("disabled",true);
		$("#l2_22_4").prop("disabled",true);
		$("#l2_22_5").prop("disabled",true);
	}
}
// Validaciones lista 3
function val_lista3()
{
	if (document.getElementById('l3_1_1').checked)
	{
		document.getElementById('l3_1_2').removeAttribute("disabled");
		document.getElementById('l3_1_3').removeAttribute("disabled");
		document.getElementById('l3_1_4').removeAttribute("disabled");
		document.getElementById('l3_1_5').removeAttribute("disabled");
		$("#l3_1_2").focus();
	}
	else
	{
		$("#l3_1_2").val("0");
		$("#l3_1_3").val("");
		$("#l3_1_4").val("0");
		$("#l3_1_5").val("0");
		$("#l3_1_2").prop("disabled",true);
		$("#l3_1_3").prop("disabled",true);
		$("#l3_1_4").prop("disabled",true);
		$("#l3_1_5").prop("disabled",true);
	}
	if (document.getElementById('l3_2_1').checked)
	{
		document.getElementById('l3_2_2').removeAttribute("disabled");
		document.getElementById('l3_2_3').removeAttribute("disabled");
		document.getElementById('l3_2_4').removeAttribute("disabled");
		document.getElementById('l3_2_5').removeAttribute("disabled");
		$("#l3_2_2").focus();
	}
	else
	{
		$("#l3_2_2").val("0");
		$("#l3_2_3").val("");
		$("#l3_2_4").val("0");
		$("#l3_2_5").val("0");
		$("#l3_2_2").prop("disabled",true);
		$("#l3_2_3").prop("disabled",true);
		$("#l3_2_4").prop("disabled",true);
		$("#l3_2_5").prop("disabled",true);
	}
	if (document.getElementById('l3_3_1').checked)
	{
		document.getElementById('l3_3_2').removeAttribute("disabled");
		document.getElementById('l3_3_3').removeAttribute("disabled");
		document.getElementById('l3_3_4').removeAttribute("disabled");
		document.getElementById('l3_3_5').removeAttribute("disabled");
		$("#l3_3_2").focus();
	}
	else
	{
		$("#l3_3_2").val("0");
		$("#l3_3_3").val("");
		$("#l3_3_4").val("0");
		$("#l3_3_5").val("0");
		$("#l3_3_2").prop("disabled",true);
		$("#l3_3_3").prop("disabled",true);
		$("#l3_3_4").prop("disabled",true);
		$("#l3_3_5").prop("disabled",true);
	}
	if (document.getElementById('l3_4_1').checked)
	{
		document.getElementById('l3_4_2').removeAttribute("disabled");
		document.getElementById('l3_4_3').removeAttribute("disabled");
		document.getElementById('l3_4_4').removeAttribute("disabled");
		document.getElementById('l3_4_5').removeAttribute("disabled");
		$("#l3_4_2").focus();
	}
	else
	{
		$("#l3_4_2").val("0");
		$("#l3_4_3").val("");
		$("#l3_4_4").val("0");
		$("#l3_4_5").val("0");
		$("#l3_4_2").prop("disabled",true);
		$("#l3_4_3").prop("disabled",true);
		$("#l3_4_4").prop("disabled",true);
		$("#l3_4_5").prop("disabled",true);
	}
	if (document.getElementById('l3_5_1').checked)
	{
		document.getElementById('l3_5_2').removeAttribute("disabled");
		document.getElementById('l3_5_3').removeAttribute("disabled");
		document.getElementById('l3_5_4').removeAttribute("disabled");
		document.getElementById('l3_5_5').removeAttribute("disabled");
		$("#l3_5_2").focus();
	}
	else
	{
		$("#l3_5_2").val("0");
		$("#l3_5_3").val("");
		$("#l3_5_4").val("0");
		$("#l3_5_5").val("0");
		$("#l3_5_2").prop("disabled",true);
		$("#l3_5_3").prop("disabled",true);
		$("#l3_5_4").prop("disabled",true);
		$("#l3_5_5").prop("disabled",true);
	}
	if (document.getElementById('l3_6_1').checked)
	{
		document.getElementById('l3_6_2').removeAttribute("disabled");
		document.getElementById('l3_6_3').removeAttribute("disabled");
		document.getElementById('l3_6_4').removeAttribute("disabled");
		document.getElementById('l3_6_5').removeAttribute("disabled");
		$("#l3_6_2").focus();
	}
	else
	{
		$("#l3_6_2").val("0");
		$("#l3_6_3").val("");
		$("#l3_6_4").val("0");
		$("#l3_6_5").val("0");
		$("#l3_6_2").prop("disabled",true);
		$("#l3_6_3").prop("disabled",true);
		$("#l3_6_4").prop("disabled",true);
		$("#l3_6_5").prop("disabled",true);
	}
	if (document.getElementById('l3_7_1').checked)
	{
		document.getElementById('l3_7_2').removeAttribute("disabled");
		document.getElementById('l3_7_3').removeAttribute("disabled");
		document.getElementById('l3_7_4').removeAttribute("disabled");
		document.getElementById('l3_7_5').removeAttribute("disabled");
		$("#l3_7_2").focus();
	}
	else
	{
		$("#l3_7_2").val("0");
		$("#l3_7_3").val("");
		$("#l3_7_4").val("0");
		$("#l3_7_5").val("0");
		$("#l3_7_2").prop("disabled",true);
		$("#l3_7_3").prop("disabled",true);
		$("#l3_7_4").prop("disabled",true);
		$("#l3_7_5").prop("disabled",true);
	}
	if (document.getElementById('l3_8_1').checked)
	{
		document.getElementById('l3_8_2').removeAttribute("disabled");
		document.getElementById('l3_8_3').removeAttribute("disabled");
		document.getElementById('l3_8_4').removeAttribute("disabled");
		document.getElementById('l3_8_5').removeAttribute("disabled");
		$("#l3_8_2").focus();
	}
	else
	{
		$("#l3_8_2").val("0");
		$("#l3_8_3").val("");
		$("#l3_8_4").val("0");
		$("#l3_8_5").val("0");
		$("#l3_8_2").prop("disabled",true);
		$("#l3_8_3").prop("disabled",true);
		$("#l3_8_4").prop("disabled",true);
		$("#l3_8_5").prop("disabled",true);
	}
	if (document.getElementById('l3_9_1').checked)
	{
		document.getElementById('l3_9_2').removeAttribute("disabled");
		document.getElementById('l3_9_3').removeAttribute("disabled");
		document.getElementById('l3_9_4').removeAttribute("disabled");
		document.getElementById('l3_9_5').removeAttribute("disabled");
		$("#l3_9_2").focus();
	}
	else
	{
		$("#l3_9_2").val("0");
		$("#l3_9_3").val("");
		$("#l3_9_4").val("0");
		$("#l3_9_5").val("0");
		$("#l3_9_2").prop("disabled",true);
		$("#l3_9_3").prop("disabled",true);
		$("#l3_9_4").prop("disabled",true);
		$("#l3_9_5").prop("disabled",true);
	}
	if (document.getElementById('l3_10_1').checked)
	{
		document.getElementById('l3_10_2').removeAttribute("disabled");
		document.getElementById('l3_10_3').removeAttribute("disabled");
		document.getElementById('l3_10_4').removeAttribute("disabled");
		document.getElementById('l3_10_5').removeAttribute("disabled");
		$("#l3_10_2").focus();
	}
	else
	{
		$("#l3_10_2").val("0");
		$("#l3_10_3").val("");
		$("#l3_10_4").val("0");
		$("#l3_10_5").val("0");
		$("#l3_10_2").prop("disabled",true);
		$("#l3_10_3").prop("disabled",true);
		$("#l3_10_4").prop("disabled",true);
		$("#l3_10_5").prop("disabled",true);
	}
	//if (document.getElementById('l3_11_1').checked)
	//{
	//	document.getElementById('l3_11_2').removeAttribute("disabled");
	//	document.getElementById('l3_11_4').removeAttribute("disabled");
	//	document.getElementById('l3_11_4').removeAttribute("disabled");
	//	document.getElementById('l3_11_5').removeAttribute("disabled");
	//	$("#l3_11_2").focus();
	//}
	//else
	//{
	//	$("#l3_11_2").val("0");
	//	$("#l3_11_3").val("");
	//	$("#l3_11_4").val("0");
	//	$("#l3_11_5").val("0");
	//	$("#l3_11_2").prop("disabled",true);
	//	$("#l3_11_3").prop("disabled",true);
	//	$("#l3_11_4").prop("disabled",true);
	//	$("#l3_11_5").prop("disabled",true);
	//}
	if (document.getElementById('l3_12_1').checked)
	{
		document.getElementById('l3_12_2').removeAttribute("disabled");
		document.getElementById('l3_12_3').removeAttribute("disabled");
		document.getElementById('l3_12_4').removeAttribute("disabled");
		document.getElementById('l3_12_5').removeAttribute("disabled");
		$("#l3_12_2").focus();
	}
	else
	{
		$("#l3_12_2").val("0");
		$("#l3_12_3").val("");
		$("#l3_12_4").val("0");
		$("#l3_12_5").val("0");
		$("#l3_12_2").prop("disabled",true);
		$("#l3_12_3").prop("disabled",true);
		$("#l3_12_4").prop("disabled",true);
		$("#l3_12_5").prop("disabled",true);
	}
	if (document.getElementById('l3_13_1').checked)
	{
		document.getElementById('l3_13_2').removeAttribute("disabled");
		document.getElementById('l3_13_3').removeAttribute("disabled");
		document.getElementById('l3_13_4').removeAttribute("disabled");
		document.getElementById('l3_13_5').removeAttribute("disabled");
		$("#l3_13_2").focus();
	}
	else
	{
		$("#l3_13_2").val("0");
		$("#l3_13_3").val("");
		$("#l3_13_4").val("0");
		$("#l3_13_5").val("0");
		$("#l3_13_2").prop("disabled",true);
		$("#l3_13_3").prop("disabled",true);
		$("#l3_13_4").prop("disabled",true);
		$("#l3_13_5").prop("disabled",true);
	}
	if (document.getElementById('l3_14_1').checked)
	{
		document.getElementById('l3_14_2').removeAttribute("disabled");
		document.getElementById('l3_14_3').removeAttribute("disabled");
		document.getElementById('l3_14_4').removeAttribute("disabled");
		document.getElementById('l3_14_5').removeAttribute("disabled");
		$("#l3_14_2").focus();
	}
	else
	{
		$("#l3_14_2").val("0");
		$("#l3_14_3").val("");
		$("#l3_14_4").val("0");
		$("#l3_14_5").val("0");
		$("#l3_14_2").prop("disabled",true);
		$("#l3_14_3").prop("disabled",true);
		$("#l3_14_4").prop("disabled",true);
		$("#l3_14_5").prop("disabled",true);
	}
	if (document.getElementById('l3_15_1').checked)
	{
		document.getElementById('l3_15_2').removeAttribute("disabled");
		document.getElementById('l3_15_3').removeAttribute("disabled");
		document.getElementById('l3_15_4').removeAttribute("disabled");
		document.getElementById('l3_15_5').removeAttribute("disabled");
		$("#l3_15_2").focus();
	}
	else
	{
		$("#l3_15_2").val("0");
		$("#l3_15_3").val("");
		$("#l3_15_4").val("0");
		$("#l3_15_5").val("0");
		$("#l3_15_2").prop("disabled",true);
		$("#l3_15_3").prop("disabled",true);
		$("#l3_15_4").prop("disabled",true);
		$("#l3_15_5").prop("disabled",true);
	}
	if (document.getElementById('l3_16_1').checked)
	{
		document.getElementById('l3_16_2').removeAttribute("disabled");
		document.getElementById('l3_16_3').removeAttribute("disabled");
		document.getElementById('l3_16_4').removeAttribute("disabled");
		document.getElementById('l3_16_5').removeAttribute("disabled");
		$("#l3_16_2").focus();
	}
	else
	{
		$("#l3_16_2").val("0");
		$("#l3_16_3").val("");
		$("#l3_16_4").val("0");
		$("#l3_16_5").val("0");
		$("#l3_16_2").prop("disabled",true);
		$("#l3_16_3").prop("disabled",true);
		$("#l3_16_4").prop("disabled",true);
		$("#l3_16_5").prop("disabled",true);
	}
	if (document.getElementById('l3_17_1').checked)
	{
		document.getElementById('l3_17_2').removeAttribute("disabled");
		document.getElementById('l3_17_3').removeAttribute("disabled");
		document.getElementById('l3_17_4').removeAttribute("disabled");
		document.getElementById('l3_17_5').removeAttribute("disabled");
		$("#l3_17_2").focus();
	}
	else
	{
		$("#l3_17_2").val("0");
		$("#l3_17_3").val("");
		$("#l3_17_4").val("0");
		$("#l3_17_5").val("0");
		$("#l3_17_2").prop("disabled",true);
		$("#l3_17_3").prop("disabled",true);
		$("#l3_17_4").prop("disabled",true);
		$("#l3_17_5").prop("disabled",true);
	}
	if (document.getElementById('l3_18_1').checked)
	{
		document.getElementById('l3_18_2').removeAttribute("disabled");
		document.getElementById('l3_18_3').removeAttribute("disabled");
		document.getElementById('l3_18_4').removeAttribute("disabled");
		document.getElementById('l3_18_5').removeAttribute("disabled");
		$("#l3_18_2").focus();
	}
	else
	{
		$("#l3_18_2").val("0");
		$("#l3_18_3").val("");
		$("#l3_18_2").prop("disabled",true);
		$("#l3_18_3").prop("disabled",true);
		$("#l3_18_4").prop("disabled",true);
		$("#l3_18_5").prop("disabled",true);
	}
	if (document.getElementById('l3_19_1').checked)
	{
		document.getElementById('l3_19_2').removeAttribute("disabled");
		document.getElementById('l3_19_3').removeAttribute("disabled");
		document.getElementById('l3_19_4').removeAttribute("disabled");
		document.getElementById('l3_19_5').removeAttribute("disabled");
		$("#l3_19_2").focus();
	}
	else
	{
		$("#l3_19_2").val("0");
		$("#l3_19_3").val("");
		$("#l3_19_4").val("0");
		$("#l3_19_5").val("0");
		$("#l3_19_2").prop("disabled",true);
		$("#l3_19_3").prop("disabled",true);
		$("#l3_19_4").prop("disabled",true);
		$("#l3_19_5").prop("disabled",true);
	}
	if (document.getElementById('l3_20_1').checked)
	{
		document.getElementById('l3_20_2').removeAttribute("disabled");
		document.getElementById('l3_20_3').removeAttribute("disabled");
		document.getElementById('l3_20_4').removeAttribute("disabled");
		document.getElementById('l3_20_5').removeAttribute("disabled");
		$("#l3_20_2").focus();
	}
	else
	{
		$("#l3_20_2").val("0");
		$("#l3_20_3").val("");
		$("#l3_20_4").val("0");
		$("#l3_20_5").val("0");
		$("#l3_20_2").prop("disabled",true);
		$("#l3_20_3").prop("disabled",true);
		$("#l3_20_4").prop("disabled",true);
		$("#l3_20_5").prop("disabled",true);
	}
	if (document.getElementById('l3_21_1').checked)
	{
		document.getElementById('l3_21_2').removeAttribute("disabled");
		document.getElementById('l3_21_3').removeAttribute("disabled");
		document.getElementById('l3_21_4').removeAttribute("disabled");
		document.getElementById('l3_21_5').removeAttribute("disabled");
		$("#l3_21_2").focus();
	}
	else
	{
		$("#l3_21_2").val("0");
		$("#l3_21_3").val("");
		$("#l3_21_4").val("0");
		$("#l3_21_5").val("0");
		$("#l3_21_2").prop("disabled",true);
		$("#l3_21_3").prop("disabled",true);
		$("#l3_21_4").prop("disabled",true);
		$("#l3_21_5").prop("disabled",true);
	}
	if (document.getElementById('l3_22_1').checked)
	{
		document.getElementById('l3_22_2').removeAttribute("disabled");
		document.getElementById('l3_22_3').removeAttribute("disabled");
		document.getElementById('l3_22_4').removeAttribute("disabled");
		document.getElementById('l3_22_5').removeAttribute("disabled");
		$("#l3_22_2").focus();
	}
	else
	{
		$("#l3_22_2").val("0");
		$("#l3_22_3").val("");
		$("#l3_22_4").val("0");
		$("#l3_22_5").val("0");
		$("#l3_22_2").prop("disabled",true);
		$("#l3_22_3").prop("disabled",true);
		$("#l3_22_4").prop("disabled",true);
		$("#l3_22_5").prop("disabled",true);
	}
	if (document.getElementById('l3_23_1').checked)
	{
		document.getElementById('l3_23_2').removeAttribute("disabled");
		document.getElementById('l3_23_3').removeAttribute("disabled");
		document.getElementById('l3_23_4').removeAttribute("disabled");
		document.getElementById('l3_23_5').removeAttribute("disabled");
		$("#l3_23_2").focus();
	}
	else
	{
		$("#l3_23_2").val("0");
		$("#l3_23_3").val("");
		$("#l3_23_4").val("0");
		$("#l3_23_5").val("0");
		$("#l3_23_2").prop("disabled",true);
		$("#l3_23_3").prop("disabled",true);
		$("#l3_23_4").prop("disabled",true);
		$("#l3_23_5").prop("disabled",true);
	}
	if (document.getElementById('l3_24_1').checked)
	{
		document.getElementById('l3_24_2').removeAttribute("disabled");
		document.getElementById('l3_24_3').removeAttribute("disabled");
		document.getElementById('l3_24_4').removeAttribute("disabled");
		document.getElementById('l3_24_5').removeAttribute("disabled");
		$("#l3_24_2").focus();
	}
	else
	{
		$("#l3_24_2").val("0");
		$("#l3_24_3").val("");
		$("#l3_24_4").val("0");
		$("#l3_24_5").val("0");
		$("#l3_24_2").prop("disabled",true);
		$("#l3_24_3").prop("disabled",true);
		$("#l3_24_4").prop("disabled",true);
		$("#l3_24_5").prop("disabled",true);
	}
	if (document.getElementById('l3_25_1').checked)
	{
		document.getElementById('l3_25_2').removeAttribute("disabled");
		document.getElementById('l3_25_3').removeAttribute("disabled");
		document.getElementById('l3_25_4').removeAttribute("disabled");
		document.getElementById('l3_25_5').removeAttribute("disabled");
		$("#l3_25_2").focus();
	}
	else
	{
		$("#l3_25_2").val("0");
		$("#l3_25_3").val("");
		$("#l3_25_4").val("0");
		$("#l3_25_5").val("0");
		$("#l3_25_2").prop("disabled",true);
		$("#l3_25_3").prop("disabled",true);
		$("#l3_25_4").prop("disabled",true);
		$("#l3_25_5").prop("disabled",true);
	}
}
function vali1()
{
	if ($("#tipo1_l3").is(':checked'))
  	{
    	$("#lista3_o3").show();
  	}
  	else
  	{
    	$("#lista3_o3").hide();
  	}
}
function vali2()
{
	if ($("#tipo2_l3").is(':checked'))
  	{
    	$("#lista3_o1").show();
  	}
  	else
  	{
    	$("#lista3_o1").hide();
  	}
}
function vali3()
{
	if ($("#tipo3_l3").is(':checked'))
  	{
    	$("#lista3_o2").show();
  	}
  	else
  	{
    	$("#lista3_o2").hide();
  	}
}
function valida()
{
  document.getElementById('cedulas').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('cedulas').value=document.getElementById('cedulas').value+valor+"|";
    }
  }
  document.getElementById('nombres').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('nombres').value=document.getElementById('nombres').value+valor+"|";
    }
  }
  document.getElementById('porcentajes').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('por_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('porcentajes').value=document.getElementById('porcentajes').value+valor+"|";
    }
  }
  document.getElementById('porcentajes1').value="";
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('pot_')!=-1)
    {
      valor=document.getElementById(saux).value;
      document.getElementById('porcentajes1').value=document.getElementById('porcentajes1').value+valor+"|";
    }
  }
  document.getElementById('tipos').value="";
//  if (document.getElementById('tipo1').checked)
//  {
//    valor="1";
//  }
//  else
//  {
//    valor="0";
//  }
//  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
//  if (document.getElementById('tipo2').checked)
//  {
//    valor="1";
//  }
//  else
//  {
//    valor="0";
//  }
//  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
//  if (document.getElementById('tipo3').checked)
//  {
//    valor="1";
//  }
//  else
//  {
//    valor="0";
//  }
//  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
//  if (document.getElementById('tipo4').checked)
//  {
//    valor="1";
//  }
//  else
//  {
//    valor="0";
//  }
//  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
  document.getElementById('lista').value="";
  var directiva;
  directiva = $("#directiva").val();
  if (directiva == "3")
  {
	  if ($("#tipo1_l3").is(":checked"))
	  {
	  	valor="1";
	  }
	  else
	  {
	    valor="0";
	  }
	  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
	  if ($("#tipo2_l3").is(":checked"))
	  {
	  	valor="1";
	  }
	  else
	  {
	    valor="0";
	  }
	  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
	  if ($("#tipo3_l3").is(":checked"))
	  {
	  	valor="1";
	  }
	  else
	  {
	    valor="0";
	  }
	  document.getElementById('tipos').value=document.getElementById('tipos').value+valor+"|";
  }
  switch (directiva)
  {
  	case '1':
		if (document.getElementById('l1_1_1').checked)
	  	{
	    	valor1="1";
	  	}
	  	else
	  	{
	    	valor1="0";
	  	}
	  	var valor2 = $("#l1_1_2").val();
	  	var valor3 = $("#l1_1_3").val();
	  	var valor4 = $("#l1_1_4").val();
	  	var valor5 = $("#l1_1_5").val();
	  	//	2
		if (document.getElementById('l1_2_1').checked)
	  	{
	    	valor6="1";
	  	}
	  	else
	  	{
	    	valor6="0";
	  	}
	  	var valor7 = $("#l1_2_2").val();
	  	var valor8 = $("#l1_2_3").val();
	  	var valor9 = $("#l1_2_4").val();
	  	var valor10 = $("#l1_2_5").val();
	  	// 3
		if (document.getElementById('l1_3_1').checked)
	  	{
	    	valor11="1";
	  	}
	  	else
	  	{
	    	valor11="0";
	  	}
	  	var valor12 = $("#l1_3_2").val();
	  	var valor13 = $("#l1_3_3").val();
	  	var valor14 = $("#l1_3_4").val();
	  	var valor15 = $("#l1_3_5").val();
	  	// 4
	  	if (document.getElementById('l1_4_1').checked)
	  	{
	    	valor16="1";
	  	}
	  	else
	  	{
	    	valor16="0";
	  	}
	  	var valor17 = $("#l1_4_2").val();
	  	var valor18 = $("#l1_4_3").val();
	  	var valor19 = $("#l1_4_4").val();
	  	var valor20 = $("#l1_4_5").val();
	  	// 5
		if (document.getElementById('l1_5_1').checked)
	  	{
	    	valor21="1";
	  	}
	  	else
	  	{
	    	valor21="0";
	  	}
	  	var valor22 = $("#l1_5_2").val();
	  	var valor23 = $("#l1_5_3").val();
	  	var valor24 = $("#l1_5_4").val();
	  	var valor25 = $("#l1_5_5").val();
	  	// 6 
		if (document.getElementById('l1_6_1').checked)
	  	{
	    	valor26="1";
	  	}
	  	else
	  	{
	    	valor26="0";
	  	}
	  	var valor27 = $("#l1_6_2").val();
	  	var valor28 = $("#l1_6_3").val();
	  	var valor29 = $("#l1_6_4").val();
	  	var valor30 = $("#l1_6_5").val();
	  	// 7
		if (document.getElementById('l1_7_1').checked)
	  	{
	    	valor31="1";
	  	}
	  	else
	  	{
	    	valor31="0";
	  	}
	  	var valor32 = $("#l1_7_2").val();
	  	var valor33 = $("#l1_7_3").val();
	  	var valor34 = $("#l1_7_4").val();
	  	var valor35 = $("#l1_7_5").val();
	  	// 8
		if (document.getElementById('l1_8_1').checked)
	  	{
	    	valor36="1";
	  	}
	  	else
	  	{
	    	valor36="0";
	  	}
	  	var valor37 = $("#l1_8_2").val();
	  	var valor38 = $("#l1_8_3").val();
	  	var valor39 = $("#l1_8_4").val();
	  	var valor40 = $("#l1_8_5").val();
	  	// 9
		if (document.getElementById('l1_9_1').checked)
	  	{
	    	valor41="1";
	  	}
	  	else
	  	{
	    	valor41="0";
	  	}
	  	var valor42 = $("#l1_9_2").val();
	  	var valor43 = $("#l1_9_3").val();
	  	var valor44 = $("#l1_9_4").val();
	  	var valor45 = $("#l1_9_5").val();
	  	//	10
		if (document.getElementById('l1_10_1').checked)
	  	{
	    	valor46="1";
	  	}
	  	else
	  	{
	    	valor46="0";
	  	}
	  	var valor47 = $("#l1_10_2").val();
	  	var valor48 = $("#l1_10_3").val();
	  	var valor49 = $("#l1_10_4").val();
	  	var valor50 = $("#l1_10_5").val();
	  	// 11
		if (document.getElementById('l1_11_1').checked)
	  	{
	    	valor51="1";
	  	}
	  	else
	  	{
	    	valor51="0";
	  	}
	  	var valor52 = $("#l1_11_2").val();
	  	var valor53 = $("#l1_11_3").val();
	  	var valor54 = $("#l1_11_4").val();
	  	var valor55 = $("#l1_11_5").val();
	  	// 12
		if (document.getElementById('l1_12_1').checked)
	  	{
	    	valor56="1";
	  	}
	  	else
	  	{
	    	valor56="0";
	  	}
	  	var valor57 = $("#l1_12_2").val();
	  	var valor58 = $("#l1_12_3").val();
	  	var valor59 = $("#l1_12_4").val();
	  	var valor60 = $("#l1_12_5").val();
	  	//	13
		if (document.getElementById('l1_13_1').checked)
	  	{
	    	valor61="1";
	  	}
	  	else
	  	{
	    	valor61="0";
	  	}
	  	var valor62 = $("#l1_13_2").val();
	  	var valor63 = $("#l1_13_3").val();
	  	var valor64 = $("#l1_13_4").val();
	  	var valor65 = $("#l1_13_5").val();
	  	// 14
		if (document.getElementById('l1_14_1').checked)
	  	{
	    	valor66="1";
	  	}
	  	else
	  	{
	    	valor66="0";
	  	}
	  	var valor67 = $("#l1_14_2").val();
	  	var valor68 = $("#l1_14_3").val();
	  	var valor69 = $("#l1_14_4").val();
	  	var valor70 = $("#l1_14_5").val();
	  	// 15
		if (document.getElementById('l1_15_1').checked)
	  	{
	    	valor71="1";
	  	}
	  	else
	  	{
	    	valor71="0";
	  	}
	  	var valor72 = $("#l1_15_2").val();
	  	var valor73 = $("#l1_15_3").val();
	  	var valor74 = $("#l1_15_4").val();
	  	var valor75 = $("#l1_15_5").val();
	  	// 16
		if (document.getElementById('l1_16_1').checked)
	  	{
	    	valor76="1";
	  	}
	  	else
	  	{
	    	valor76="0";
	  	}
	  	var valor77 = $("#l1_16_2").val();
	  	var valor78 = $("#l1_16_3").val();
	  	var valor79 = $("#l1_16_4").val();
	  	var valor80 = $("#l1_16_5").val();
	  	// 17
		if (document.getElementById('l1_17_1').checked)
	  	{
	    	valor81="1";
	  	}
	  	else
	  	{
	    	valor81="0";
	  	}
	  	var valor82 = $("#l1_17_2").val();
	  	var valor83 = $("#l1_17_3").val();
	  	var valor84 = $("#l1_17_4").val();
	  	var valor85 = $("#l1_17_5").val();
	  	// 18
		if (document.getElementById('l1_18_1').checked)
	  	{
	    	valor86="1";
	  	}
	  	else
	  	{
	    	valor86="0";
	  	}
	  	var valor87 = $("#l1_18_2").val();
	  	var valor88 = $("#l1_18_3").val();
	  	var valor89 = $("#l1_18_4").val();
	  	var valor90 = $("#l1_18_5").val();
	  	// 19
		if (document.getElementById('l1_19_1').checked)
	  	{
	    	valor91="1";
	  	}
	  	else
	  	{
	    	valor91="0";
	  	}
	  	var valor92 = $("#l1_19_2").val();
	  	var valor93 = $("#l1_19_3").val();
	  	var valor94 = $("#l1_19_4").val();
	  	var valor95 = $("#l1_19_5").val();
	  	// 20
		if (document.getElementById('l1_20_1').checked)
	  	{
	    	valor96="1";
	  	}
	  	else
	  	{
	    	valor96="0";
	  	}
	  	var valor97 = $("#l1_20_2").val();
	  	var valor98 = $("#l1_20_3").val();
	  	var valor99 = $("#l1_20_4").val();
	  	var valor100 = $("#l1_20_5").val();
	  	// 21
		if (document.getElementById('l1_21_1').checked)
	  	{
	    	valor101="1";
	  	}
	  	else
	  	{
	    	valor101="0";
	  	}
	  	var valor102 = $("#l1_21_2").val();
	  	var valor103 = $("#l1_21_3").val();
	  	var valor104 = $("#l1_21_4").val();
	  	var valor105 = $("#l1_21_5").val();
	  	//	22
		if (document.getElementById('l1_22_1').checked)
	  	{
	    	valor106="1";
	  	}
	  	else
	  	{
	    	valor106="0";
	  	}
	  	var valor107 = $("#l1_22_2").val();
	  	var valor108 = $("#l1_22_3").val();
	  	var valor109 = $("#l1_22_4").val();
	  	var valor110 = $("#l1_22_5").val();
		document.getElementById('lista').value=valor1+"|"+valor2+"|"+valor3+"|"+valor4+"|"+valor5+"|"+valor6+"|"+valor7+"|"+valor8+"|"+valor9+"|"+valor10+"|"+valor11+"|"+valor12+"|"+valor13+"|"+valor14+"|"+valor15+"|"+valor16+"|"+valor17+"|"+valor18+"|"+valor19+"|"+valor20+"|"+valor21+"|"+valor22+"|"+valor23+"|"+valor24+"|"+valor25+"|"+valor26+"|"+valor27+"|"+valor28+"|"+valor29+"|"+valor30+"|"+valor31+"|"+valor32+"|"+valor33+"|"+valor34+"|"+valor35+"|"+valor36+"|"+valor37+"|"+valor38+"|"+valor39+"|"+valor40+"|"+valor41+"|"+valor42+"|"+valor43+"|"+valor44+"|"+valor45+"|"+valor46+"|"+valor47+"|"+valor48+"|"+valor49+"|"+valor50+"|"+valor51+"|"+valor52+"|"+valor53+"|"+valor54+"|"+valor55+"|"+valor56+"|"+valor57+"|"+valor58+"|"+valor59+"|"+valor60+"|"+valor61+"|"+valor62+"|"+valor63+"|"+valor64+"|"+valor65+"|"+valor66+"|"+valor67+"|"+valor68+"|"+valor69+"|"+valor70+"|"+valor71+"|"+valor72+"|"+valor73+"|"+valor74+"|"+valor75+"|"+valor76+"|"+valor77+"|"+valor78+"|"+valor79+"|"+valor80+"|"+valor81+"|"+valor82+"|"+valor83+"|"+valor84+"|"+valor85+"|"+valor86+"|"+valor87+"|"+valor88+"|"+valor89+"|"+valor90+"|"+valor91+"|"+valor92+"|"+valor93+"|"+valor94+"|"+valor95+"|"+valor96+"|"+valor97+"|"+valor98+"|"+valor99+"|"+valor100+"|"+valor101+"|"+valor102+"|"+valor103+"|"+valor104+"|"+valor105+"|"+valor106+"|"+valor107+"|"+valor108+"|"+valor109+"|"+valor110+"|";
  		break;
  	case '2':
		if (document.getElementById('l2_1_1').checked)
	  	{
	    	valor1="1";
	  	}
	  	else
	  	{
	    	valor1="0";
	  	}
	  	var valor2 = $("#l2_1_2").val();
	  	var valor3 = $("#l2_1_3").val();
	  	var valor4 = $("#l2_1_4").val();
	  	var valor5 = $("#l2_1_5").val();
	  	//	2
		if (document.getElementById('l2_2_1').checked)
	  	{
	    	valor6="1";
	  	}
	  	else
	  	{
	    	valor6="0";
	  	}
	  	var valor7 = $("#l2_2_2").val();
	  	var valor8 = $("#l2_2_3").val();
	  	var valor9 = $("#l2_2_4").val();
	  	var valor10 = $("#l2_2_5").val();
	  	// 3
		if (document.getElementById('l2_3_1').checked)
	  	{
	    	valor11="1";
	  	}
	  	else
	  	{
	    	valor11="0";
	  	}
	  	var valor12 = $("#l2_3_2").val();
	  	var valor13 = $("#l2_3_3").val();
	  	var valor14 = $("#l2_3_4").val();
	  	var valor15 = $("#l2_3_5").val();
	  	// 4
	  	if (document.getElementById('l2_4_1').checked)
	  	{
	    	valor16="1";
	  	}
	  	else
	  	{
	    	valor16="0";
	  	}
	  	var valor17 = $("#l2_4_2").val();
	  	var valor18 = $("#l2_4_3").val();
	  	var valor19 = $("#l2_4_4").val();
	  	var valor20 = $("#l2_4_5").val();
	  	// 5
		if (document.getElementById('l2_5_1').checked)
	  	{
	    	valor21="1";
	  	}
	  	else
	  	{
	    	valor21="0";
	  	}
	  	var valor22 = $("#l2_5_2").val();
	  	var valor23 = $("#l2_5_3").val();
	  	var valor24 = $("#l2_5_4").val();
	  	var valor25 = $("#l2_5_5").val();
	  	// 6 
		if (document.getElementById('l2_6_1').checked)
	  	{
	    	valor26="1";
	  	}
	  	else
	  	{
	    	valor26="0";
	  	}
	  	var valor27 = $("#l2_6_2").val();
	  	var valor28 = $("#l2_6_3").val();
	  	var valor29 = $("#l2_6_4").val();
	  	var valor30 = $("#l2_6_5").val();
	  	// 7
		if (document.getElementById('l2_7_1').checked)
	  	{
	    	valor31="1";
	  	}
	  	else
	  	{
	    	valor31="0";
	  	}
	  	var valor32 = $("#l2_7_2").val();
	  	var valor33 = $("#l2_7_3").val();
	  	var valor34 = $("#l2_7_4").val();
	  	var valor35 = $("#l2_7_5").val();
	  	// 8
		if (document.getElementById('l2_8_1').checked)
	  	{
	    	valor36="1";
	  	}
	  	else
	  	{
	    	valor36="0";
	  	}
	  	var valor37 = $("#l2_8_2").val();
	  	var valor38 = $("#l2_8_3").val();
	  	var valor39 = $("#l2_8_4").val();
	  	var valor40 = $("#l2_8_5").val();
	  	// 9
		if (document.getElementById('l2_9_1').checked)
	  	{
	    	valor41="1";
	  	}
	  	else
	  	{
	    	valor41="0";
	  	}
	  	var valor42 = $("#l2_9_2").val();
	  	var valor43 = $("#l2_9_3").val();
	  	var valor44 = $("#l2_9_4").val();
	  	var valor45 = $("#l2_9_5").val();
	  	//	10
		if (document.getElementById('l2_10_1').checked)
	  	{
	    	valor46="1";
	  	}
	  	else
	  	{
	    	valor46="0";
	  	}
	  	var valor47 = $("#l2_10_2").val();
	  	var valor48 = $("#l2_10_3").val();
	  	var valor49 = $("#l2_10_4").val();
	  	var valor50 = $("#l2_10_5").val();
	  	// 11
		if (document.getElementById('l2_11_1').checked)
	  	{
	    	valor51="1";
	  	}
	  	else
	  	{
	    	valor51="0";
	  	}
	  	var valor52 = $("#l2_11_2").val();
	  	var valor53 = $("#l2_11_3").val();
	  	var valor54 = $("#l2_11_4").val();
	  	var valor55 = $("#l2_11_5").val();
	  	// 12
		if (document.getElementById('l2_12_1').checked)
	  	{
	    	valor56="1";
	  	}
	  	else
	  	{
	    	valor56="0";
	  	}
	  	var valor57 = $("#l2_12_2").val();
	  	var valor58 = $("#l2_12_3").val();
	  	var valor59 = $("#l2_12_4").val();
	  	var valor60 = $("#l2_12_5").val();
	  	//	13
		if (document.getElementById('l2_13_1').checked)
	  	{
	    	valor61="1";
	  	}
	  	else
	  	{
	    	valor61="0";
	  	}
	  	var valor62 = $("#l2_13_2").val();
	  	var valor63 = $("#l2_13_3").val();
	  	var valor64 = $("#l2_13_4").val();
	  	var valor65 = $("#l2_13_5").val();
	  	// 14
		if (document.getElementById('l2_14_1').checked)
	  	{
	    	valor66="1";
	  	}
	  	else
	  	{
	    	valor66="0";
	  	}
	  	var valor67 = $("#l2_14_2").val();
	  	var valor68 = $("#l2_14_3").val();
	  	var valor69 = $("#l2_14_4").val();
	  	var valor70 = $("#l2_14_5").val();
	  	// 15
		if (document.getElementById('l2_15_1').checked)
	  	{
	    	valor71="1";
	  	}
	  	else
	  	{
	    	valor71="0";
	  	}
	  	var valor72 = $("#l2_15_2").val();
	  	var valor73 = $("#l2_15_3").val();
	  	var valor74 = $("#l2_15_4").val();
	  	var valor75 = $("#l2_15_5").val();
	  	// 16
		if (document.getElementById('l2_16_1').checked)
	  	{
	    	valor76="1";
	  	}
	  	else
	  	{
	    	valor76="0";
	  	}
	  	var valor77 = $("#l2_16_2").val();
	  	var valor78 = $("#l2_16_3").val();
	  	var valor79 = $("#l2_16_4").val();
	  	var valor80 = $("#l2_16_5").val();
	  	// 17
		if (document.getElementById('l2_17_1').checked)
	  	{
	    	valor81="1";
	  	}
	  	else
	  	{
	    	valor81="0";
	  	}
	  	var valor82 = $("#l2_17_2").val();
	  	var valor83 = $("#l2_17_3").val();
	  	var valor84 = $("#l2_17_4").val();
	  	var valor85 = $("#l2_17_5").val();
	  	// 18
		if (document.getElementById('l2_18_1').checked)
	  	{
	    	valor86="1";
	  	}
	  	else
	  	{
	    	valor86="0";
	  	}
	  	var valor87 = $("#l2_18_2").val();
	  	var valor88 = $("#l2_18_3").val();
	  	var valor89 = $("#l2_18_4").val();
	  	var valor90 = $("#l2_18_5").val();
	  	// 19
		if (document.getElementById('l2_19_1').checked)
	  	{
	    	valor91="1";
	  	}
	  	else
	  	{
	    	valor91="0";
	  	}
	  	var valor92 = $("#l2_19_2").val();
	  	var valor93 = $("#l2_19_3").val();
	  	var valor94 = $("#l2_19_4").val();
	  	var valor95 = $("#l2_19_5").val();
	  	// 20
		if (document.getElementById('l2_20_1').checked)
	  	{
	    	valor96="1";
	  	}
	  	else
	  	{
	    	valor96="0";
	  	}
	  	var valor97 = $("#l2_20_2").val();
	  	var valor98 = $("#l2_20_3").val();
	  	var valor99 = $("#l2_20_4").val();
	  	var valor100 = $("#l2_20_5").val();
	  	// 21
		if (document.getElementById('l2_21_1').checked)
	  	{
	    	valor101="1";
	  	}
	  	else
	  	{
	    	valor101="0";
	  	}
	  	var valor102 = $("#l2_21_2").val();
	  	var valor103 = $("#l2_21_3").val();
	  	var valor104 = $("#l2_21_4").val();
	  	var valor105 = $("#l2_21_5").val();
	  	//	22
		if (document.getElementById('l2_22_1').checked)
	  	{
	    	valor106="1";
	  	}
	  	else
	  	{
	    	valor106="0";
	  	}
	  	var valor107 = $("#l2_22_2").val();
	  	var valor108 = $("#l2_22_3").val();
	  	var valor109 = $("#l2_22_4").val();
	  	var valor110 = $("#l2_22_5").val();
		document.getElementById('lista').value=valor1+"|"+valor2+"|"+valor3+"|"+valor4+"|"+valor5+"|"+valor6+"|"+valor7+"|"+valor8+"|"+valor9+"|"+valor10+"|"+valor11+"|"+valor12+"|"+valor13+"|"+valor14+"|"+valor15+"|"+valor16+"|"+valor17+"|"+valor18+"|"+valor19+"|"+valor20+"|"+valor21+"|"+valor22+"|"+valor23+"|"+valor24+"|"+valor25+"|"+valor26+"|"+valor27+"|"+valor28+"|"+valor29+"|"+valor30+"|"+valor31+"|"+valor32+"|"+valor33+"|"+valor34+"|"+valor35+"|"+valor36+"|"+valor37+"|"+valor38+"|"+valor39+"|"+valor40+"|"+valor41+"|"+valor42+"|"+valor43+"|"+valor44+"|"+valor45+"|"+valor46+"|"+valor47+"|"+valor48+"|"+valor49+"|"+valor50+"|"+valor51+"|"+valor52+"|"+valor53+"|"+valor54+"|"+valor55+"|"+valor56+"|"+valor57+"|"+valor58+"|"+valor59+"|"+valor60+"|"+valor61+"|"+valor62+"|"+valor63+"|"+valor64+"|"+valor65+"|"+valor66+"|"+valor67+"|"+valor68+"|"+valor69+"|"+valor70+"|"+valor71+"|"+valor72+"|"+valor73+"|"+valor74+"|"+valor75+"|"+valor76+"|"+valor77+"|"+valor78+"|"+valor79+"|"+valor80+"|"+valor81+"|"+valor82+"|"+valor83+"|"+valor84+"|"+valor85+"|"+valor86+"|"+valor87+"|"+valor88+"|"+valor89+"|"+valor90+"|"+valor91+"|"+valor92+"|"+valor93+"|"+valor94+"|"+valor95+"|"+valor96+"|"+valor97+"|"+valor98+"|"+valor99+"|"+valor100+"|"+valor101+"|"+valor102+"|"+valor103+"|"+valor104+"|"+valor105+"|"+valor106+"|"+valor107+"|"+valor108+"|"+valor109+"|"+valor110+"|";
  		break;
  	case '3':
		if (document.getElementById('l3_1_1').checked)
	  	{
	    	valor1="1";
	  	}
	  	else
	  	{
	    	valor1="0";
	  	}
	  	var valor2 = $("#l3_1_2").val();
	  	var valor3 = $("#l3_1_3").val();
	  	var valor4 = $("#l3_1_4").val();
	  	var valor5 = $("#l3_1_5").val();
	  	//	2
		if (document.getElementById('l3_2_1').checked)
	  	{
	    	valor6="1";
	  	}
	  	else
	  	{
	    	valor6="0";
	  	}
	  	var valor7 = $("#l3_2_2").val();
	  	var valor8 = $("#l3_2_3").val();
	  	var valor9 = $("#l3_2_4").val();
	  	var valor10 = $("#l3_2_5").val();
	  	// 3
		if (document.getElementById('l3_3_1').checked)
	  	{
	    	valor11="1";
	  	}
	  	else
	  	{
	    	valor11="0";
	  	}
	  	var valor12 = $("#l3_3_2").val();
	  	var valor13 = $("#l3_3_3").val();
	  	var valor14 = $("#l3_3_4").val();
	  	var valor15 = $("#l3_3_5").val();
	  	// 4
	  	if (document.getElementById('l3_4_1').checked)
	  	{
	    	valor16="1";
	  	}
	  	else
	  	{
	    	valor16="0";
	  	}
	  	var valor17 = $("#l3_4_2").val();
	  	var valor18 = $("#l3_4_3").val();
	  	var valor19 = $("#l3_4_4").val();
	  	var valor20 = $("#l3_4_5").val();
	  	// 5
		if (document.getElementById('l3_5_1').checked)
	  	{
	    	valor21="1";
	  	}
	  	else
	  	{
	    	valor21="0";
	  	}
	  	var valor22 = $("#l3_5_2").val();
	  	var valor23 = $("#l3_5_3").val();
	  	var valor24 = $("#l3_5_4").val();
	  	var valor25 = $("#l3_5_5").val();
	  	// 6 
		if (document.getElementById('l3_6_1').checked)
	  	{
	    	valor26="1";
	  	}
	  	else
	  	{
	    	valor26="0";
	  	}
	  	var valor27 = $("#l3_6_2").val();
	  	var valor28 = $("#l3_6_3").val();
	  	var valor29 = $("#l3_6_4").val();
	  	var valor30 = $("#l3_6_5").val();
	  	// 7
		if (document.getElementById('l3_7_1').checked)
	  	{
	    	valor31="1";
	  	}
	  	else
	  	{
	    	valor31="0";
	  	}
	  	var valor32 = $("#l3_7_2").val();
	  	var valor33 = $("#l3_7_3").val();
	  	var valor34 = $("#l3_7_4").val();
	  	var valor35 = $("#l3_7_5").val();
	  	// 8
		if (document.getElementById('l3_8_1').checked)
	  	{
	    	valor36="1";
	  	}
	  	else
	  	{
	    	valor36="0";
	  	}
	  	var valor37 = $("#l3_8_2").val();
	  	var valor38 = $("#l3_8_3").val();
	  	var valor39 = $("#l3_8_4").val();
	  	var valor40 = $("#l3_8_5").val();
	  	// 9
		if (document.getElementById('l3_9_1').checked)
	  	{
	    	valor41="1";
	  	}
	  	else
	  	{
	    	valor41="0";
	  	}
	  	var valor42 = $("#l3_9_2").val();
	  	var valor43 = $("#l3_9_3").val();
	  	var valor44 = $("#l3_9_4").val();
	  	var valor45 = $("#l3_9_5").val();
	  	//	10
		if (document.getElementById('l3_10_1').checked)
	  	{
	    	valor46="1";
	  	}
	  	else
	  	{
	    	valor46="0";
	  	}
	  	var valor47 = $("#l3_10_2").val();
	  	var valor48 = $("#l3_10_3").val();
	  	var valor49 = $("#l3_10_4").val();
	  	var valor50 = $("#l3_10_5").val();
	  	// 11
		//if (document.getElementById('l3_11_1').checked)
	  	//{
	    //	valor51="1";
	  	//}
	  	//else
	  	//{
	    	valor51="0";
	  	//}
	  	//var valor52 = $("#l3_11_2").val();
	  	//var valor53 = $("#l3_11_3").val();
	  	//var valor54 = $("#l3_11_4").val();
	  	//var valor55 = $("#l3_11_5").val();
		var valor52 = "0";
	  	var valor53 = "";
	  	var valor54 = "0";
	  	var valor55 = "0";
	  	// 12
		if (document.getElementById('l3_12_1').checked)
	  	{
	    	valor56="1";
	  	}
	  	else
	  	{
	    	valor56="0";
	  	}
	  	var valor57 = $("#l3_12_2").val();
	  	var valor58 = $("#l3_12_3").val();
	  	var valor59 = $("#l3_12_4").val();
	  	var valor60 = $("#l3_12_5").val();
	  	//	13
		if (document.getElementById('l3_13_1').checked)
	  	{
	    	valor61="1";
	  	}
	  	else
	  	{
	    	valor61="0";
	  	}
	  	var valor62 = $("#l3_13_2").val();
	  	var valor63 = $("#l3_13_3").val();
	  	var valor64 = $("#l3_13_4").val();
	  	var valor65 = $("#l3_13_5").val();
	  	// 14
		if (document.getElementById('l3_14_1').checked)
	  	{
	    	valor66="1";
	  	}
	  	else
	  	{
	    	valor66="0";
	  	}
	  	var valor67 = $("#l3_14_2").val();
	  	var valor68 = $("#l3_14_3").val();
	  	var valor69 = $("#l3_14_4").val();
	  	var valor70 = $("#l3_14_5").val();
	  	// 15
		if (document.getElementById('l3_15_1').checked)
	  	{
	    	valor71="1";
	  	}
	  	else
	  	{
	    	valor71="0";
	  	}
	  	var valor72 = $("#l3_15_2").val();
	  	var valor73 = $("#l3_15_3").val();
	  	var valor74 = $("#l3_15_4").val();
	  	var valor75 = $("#l3_15_5").val();
	  	// 16
		if (document.getElementById('l3_16_1').checked)
	  	{
	    	valor76="1";
	  	}
	  	else
	  	{
	    	valor76="0";
	  	}
	  	var valor77 = $("#l3_16_2").val();
	  	var valor78 = $("#l3_16_3").val();
	  	var valor79 = $("#l3_16_4").val();
	  	var valor80 = $("#l3_16_5").val();
	  	// 17
		if (document.getElementById('l3_17_1').checked)
	  	{
	    	valor81="1";
	  	}
	  	else
	  	{
	    	valor81="0";
	  	}
	  	var valor82 = $("#l3_17_2").val();
	  	var valor83 = $("#l3_17_3").val();
	  	var valor84 = $("#l3_17_4").val();
	  	var valor85 = $("#l3_17_5").val();
	  	// 18
		if (document.getElementById('l3_18_1').checked)
	  	{
	    	valor86="1";
	  	}
	  	else
	  	{
	    	valor86="0";
	  	}
	  	var valor87 = $("#l3_18_2").val();
	  	var valor88 = $("#l3_18_3").val();
	  	var valor89 = $("#l3_18_4").val();
	  	var valor90 = $("#l3_18_5").val();
	  	// 19
		if (document.getElementById('l3_19_1').checked)
	  	{
	    	valor91="1";
	  	}
	  	else
	  	{
	    	valor91="0";
	  	}
	  	var valor92 = $("#l3_19_2").val();
	  	var valor93 = $("#l3_19_3").val();
	  	var valor94 = $("#l3_19_4").val();
	  	var valor95 = $("#l3_19_5").val();
	  	// 20
		if (document.getElementById('l3_20_1').checked)
	  	{
	    	valor96="1";
	  	}
	  	else
	  	{
	    	valor96="0";
	  	}
	  	var valor97 = $("#l3_20_2").val();
	  	var valor98 = $("#l3_20_3").val();
	  	var valor99 = $("#l3_20_4").val();
	  	var valor100 = $("#l3_20_5").val();
	  	// 21
		if (document.getElementById('l3_21_1').checked)
	  	{
	    	valor101="1";
	  	}
	  	else
	  	{
	    	valor101="0";
	  	}
	  	var valor102 = $("#l3_21_2").val();
	  	var valor103 = $("#l3_21_3").val();
	  	var valor104 = $("#l3_21_4").val();
	  	var valor105 = $("#l3_21_5").val();
	  	//	22
		if (document.getElementById('l3_22_1').checked)
	  	{
	    	valor106="1";
	  	}
	  	else
	  	{
	    	valor106="0";
	  	}
	  	var valor107 = $("#l3_22_2").val();
	  	var valor108 = $("#l3_22_3").val();
	  	var valor109 = $("#l3_22_4").val();
	  	var valor110 = $("#l3_22_5").val();
	  	//	23
		if (document.getElementById('l3_23_1').checked)
	  	{
	    	valor111="1";
	  	}
	  	else
	  	{
	    	valor111="0";
	  	}
	  	var valor112 = $("#l3_23_2").val();
	  	var valor113 = $("#l3_23_3").val();
	  	var valor114 = $("#l3_23_4").val();
	  	var valor115 = $("#l3_23_5").val();
	  	//	24
		if (document.getElementById('l3_24_1').checked)
	  	{
	    	valor116="1";
	  	}
	  	else
	  	{
	    	valor116="0";
	  	}
	  	var valor117 = $("#l3_24_2").val();
	  	var valor118 = $("#l3_24_3").val();
	  	var valor119 = $("#l3_24_4").val();
	  	var valor120 = $("#l3_24_5").val();
	  	//	25
		if (document.getElementById('l3_25_1').checked)
	  	{
	    	valor121="1";
	  	}
	  	else
	  	{
	    	valor121="0";
	  	}
	  	var valor122 = $("#l3_25_2").val();
	  	var valor123 = $("#l3_25_3").val();
	  	var valor124 = $("#l3_25_4").val();
	  	var valor125 = $("#l3_25_5").val();
		document.getElementById('lista').value=valor1+"|"+valor2+"|"+valor3+"|"+valor4+"|"+valor5+"|"+valor6+"|"+valor7+"|"+valor8+"|"+valor9+"|"+valor10+"|"+valor11+"|"+valor12+"|"+valor13+"|"+valor14+"|"+valor15+"|"+valor16+"|"+valor17+"|"+valor18+"|"+valor19+"|"+valor20+"|"+valor21+"|"+valor22+"|"+valor23+"|"+valor24+"|"+valor25+"|"+valor26+"|"+valor27+"|"+valor28+"|"+valor29+"|"+valor30+"|"+valor31+"|"+valor32+"|"+valor33+"|"+valor34+"|"+valor35+"|"+valor36+"|"+valor37+"|"+valor38+"|"+valor39+"|"+valor40+"|"+valor41+"|"+valor42+"|"+valor43+"|"+valor44+"|"+valor45+"|"+valor46+"|"+valor47+"|"+valor48+"|"+valor49+"|"+valor50+"|"+valor51+"|"+valor52+"|"+valor53+"|"+valor54+"|"+valor55+"|"+valor56+"|"+valor57+"|"+valor58+"|"+valor59+"|"+valor60+"|"+valor61+"|"+valor62+"|"+valor63+"|"+valor64+"|"+valor65+"|"+valor66+"|"+valor67+"|"+valor68+"|"+valor69+"|"+valor70+"|"+valor71+"|"+valor72+"|"+valor73+"|"+valor74+"|"+valor75+"|"+valor76+"|"+valor77+"|"+valor78+"|"+valor79+"|"+valor80+"|"+valor81+"|"+valor82+"|"+valor83+"|"+valor84+"|"+valor85+"|"+valor86+"|"+valor87+"|"+valor88+"|"+valor89+"|"+valor90+"|"+valor91+"|"+valor92+"|"+valor93+"|"+valor94+"|"+valor95+"|"+valor96+"|"+valor97+"|"+valor98+"|"+valor99+"|"+valor100+"|"+valor101+"|"+valor102+"|"+valor103+"|"+valor104+"|"+valor105+"|"+valor106+"|"+valor107+"|"+valor108+"|"+valor109+"|"+valor110+"|"+valor111+"|"+valor112+"|"+valor113+"|"+valor114+"|"+valor115+"|"+valor116+"|"+valor117+"|"+valor118+"|"+valor119+"|"+valor120+"|"+valor121+"|"+valor122+"|"+valor123+"|"+valor124+"|"+valor125+"|";
		break;
  	default:
  		document.getElementById('lista').value="";
  }
  var salida = true, detalle = '';
  if ($("#fecha").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una Fecha de Oficio<br><br>";
  }
  if ($("#oficio").val() == '0')
  {
    salida = false;
    detalle += "Debe ingresar un Número de Oficio<br><br>";
  }
  if ($("#registro").val() == '0')
  {
    salida = false;
    detalle += "Debe ingresar un Número de Radicación<br><br>";
  }
  if ($("#fecha1").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una Fecha de Radicación<br><br>";
  }
  if ($("#sintesis").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una Sintesis<br><br>";
  }
  if ($("#valor").val() == '0.00')
  {
    salida = false;
    detalle += "Debe ingresar el Valor Solicitado<br><br>";
  }
  if ($("#fecha2").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una Fecha de Resultado<br><br>";
  }
  if ($("#ordop1").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Código de ORDOP<br><br>";
  }
  if ($("#ordop").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una ORDOP<br><br>";
  }
  if ($("#fecha7").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar una Fecha de ORDOP<br><br>";
  }
  if ($("#departamento").val() == '- SELECCIONAR -')
  {
    salida = false;
    detalle += "Debe seleccionar un Departamento<br><br>";
  }
  if ($("#municipio").val() == '- SELECCIONAR -')
  {
    salida = false;
    detalle += "Debe seleccionar un Municipio<br><br>";
  }
  if ($("#sitio").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Sitio / Sector / Lugar<br><br>";
  }
  if ($("#factor").val() == '- SELECCIONAR -')
  {
    salida = false;
    detalle += "Debe seleccionar un Factor de Amenaza<br><br>";
  }
  if ($("#resultado").val() == '')
  {
    salida = false;
    detalle += "Debe ingresar un Concepto<br><br>";
  }
  var v_cedulas = 0;
  var valor;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_cedulas ++;
      }
    }
  }
  if (v_cedulas > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+v_cedulas+" Número(s) de Cedula(s)<br><br>";
  }
  var v_nombres = 0;
  var valor;
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('nom_')!=-1)
    {
      valor = document.getElementById(saux).value.trim().length;
      if (valor == "0")
      {
        v_nombres ++;
      }
    }
  }
  if (v_nombres > 0)
  {
    salida = false;
    detalle += "Debe ingresar "+v_nombres+" Nombre(s) de Fuente(s)<br><br>";
  }
  if ($("#porcentaje").val() == '100.000')
  {
  }
  else
  {
    salida = false;
    detalle += "Suma de Porcentajes de Fuentes No Válido<br><br>";
  }
  if (salida == false)
  {
    $("#dialogo").html(detalle);
    $("#dialogo").dialog("open");
  }
  else
  {
  	var valida;
  	valida = $("#conse").val();
  	if (valida == "0")
  	{
    	nuevo();
    }
    else
    {
    	actualiza();
    }
  }
}
function nuevo()
{
  if (document.getElementById('pag_prev').checked)
  {
	previo1="1";
  }
  else
  {
	previo1="0";
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_grab.php",
    data:
    {
      fecha: $("#fecha").val(),
      oficio: $("#oficio").val(),
      registro: $("#registro").val(),
      fecha1: $("#fecha1").val(),
      unidad: $("#unidad").val(),
      unidad1: $("#unidad1").val(),
      brigada: $("#brigada").val(),
      division: $("#division").val(),
      sintesis: $("#sintesis").val(),
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      fecha2: $("#fecha2").val(),
      ordop1: $("#ordop1").val(),
      ordop: $("#ordop").val(),
      orden: $("#orden").val(),
      departamento: $("#departamento").val(),
      municipio: $("#municipio").val(),
      sitio: $("#sitio").val(),
      factor: $("#factor").val(),
      estructura: $("#estructura").val(),
      tipos: $("#tipos").val(),
      resultado: $("#resultado").val(),
      cedulas: $("#cedulas").val(),
      nombres: $("#nombres").val(),
      porcentajes: $("#porcentajes").val(),
      porcentajes1: $("#porcentajes1").val(),
      directiva: $("#directiva").val(),
      lista: $("#lista").val(),
      fecha7: $("#fecha7").val(),
      fecha8: $("#fecha8").val(),
      previo: previo1,
      pago: $("#pago").val(),
      fecha9: $("#fecha9").val(),
      valor_p: $("#valor_p").val(),
      valor_p1: $("#valor_p1").val(),
      alea: $("#alea").val(),
      fecha10: $("#fecha10").val()
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
      $("#conse").val(registros.salida);
      var valida, valor, valor1;
      valida = registros.salida;
      if (valida > 0)
      {      	
        $("#aceptar").hide();
        $("#aceptar1").show();
      	$("#estado").val('1');
      	$("#expediente").hide();
      	$("#lnk1").hide();
      	apaga1();
      	apaga2();
  		for (i=0;i<document.formu.elements.length;i++)
  		{
    		saux=document.formu.elements[i].name;
    		if (saux.indexOf('ced_')!=-1)
    		{
    			valor=document.getElementById(saux).value;
    			valor1="XXXX"+valor.substr(valor.length-4);
    			document.getElementById(saux).value=valor1;
    		}
    		if (saux.indexOf('nom_')!=-1)
    		{
    			document.getElementById(saux).value="INF. SECRETO";
    		}
    	}
    	for (i=1;i<10;i++)
    	{
    		$("#lnk_"+i).hide();
    	}
    	var direc = $("#directiva").val();
    	if (direc == "3")
    	{
    		apaga3('25');
	    	$("#tipo1_l3").prop("disabled", true);
	    	$("#tipo2_l3").prop("disabled", true);
	    	$("#tipo3_l3").prop("disabled", true);
    	}
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#aceptar").show();
      }
    }
  });
}
function limpiar()
{
  location.href = "reg_recom.php";
}
function valida_direc()
{
  var valida;
  valida = $("#directiva").val();
  $("#lista3_o1").hide();
  $("#lista3_o2").hide();
  $("#lista3_o3").hide();
  switch (valida)
  {
  	case '1':
  		$("#lista1").show();
  		$("#lista2").hide();
  		$("#lista3").hide();
  		break;
  	case '2':
  		$("#lista1").hide();
  		$("#lista2").show();
  		$("#lista3").hide();
  		break;
  	case '3':
  		$("#lista1").hide();
  		$("#lista2").hide();
  		$("#lista3").show();
  		break;
  	default:
  		$("#lista1").hide();
  		$("#lista2").hide();
  		$("#lista3").hide();
  }
}
function consultar()
{
  $("#menu").accordion({active: 1});
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu.php",
    data:
    {
      //estado: $("#tipo_e").val(),
      fecha1: $("#fecha5").val(),
      fecha2: $("#fecha6").val()
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load1").hide();
      $("#tabla").html('');
      $("#resultados").html('');
      var registros = JSON.parse(data);
      var valida,valida1;
      var salida1 = "";
      var salida2 = "";
      listareg = [];
      valida = registros.salida;
      valida1 = registros.total;
      salida1 += "<table width='60%' align='center' border='0'><tr><td width='85%'><b>Registros Encontrados: ( "+valida1+" )</b></td></tr></table>";
      salida1 += "<table width='60%' align='center' border='0'><tr><td width='10%'><b>No.</b></td><td width='20%'><b>Fecha</b></td><td width='30%'><b>Estado</b></td><td width='20%'><b>Usuario</b></td><td width='10%'>&nbsp;</td></tr></table>";
      salida2 += "<table width='60%' align='center' border='0' id='a-table'>";
      $.each(registros.rows, function (index, value)
      {
        salida2 += "<tr><td width='10%'>"+value.conse+"</td>";
        salida2 += "<td width='20%'>"+value.fecha+"</td>";
        salida2 += "<td width='30%'>"+value.n_estado+"</td>";
        salida2 += "<td width='20%'>"+value.usuario+"</td>";
        if (value.estado == "P")
        {
          salida2 += "<td width='10%'><center><a href='#' onclick='modif("+value.conse+")'><img src='imagenes/ver.png' border='0' title='Ver'></a></center></td>";
        }
        else
        {
	        if ((value.estado == " ") && (value.estado1 == "1")) 
	        {
	          salida2 += "<td width='10%'><center><a href='#' onclick='modif("+value.conse+")'><img src='imagenes/editar.png' border='0' title='Modificar'></a></center></td>";
	        }
	        else
	        {
	          salida2 += "<td width='10%'><center><a href='#' onclick='modif("+value.conse+")'><img src='imagenes/ver.png' border='0' title='Ver'></a></center></td>";
	        }
	    }
        listareg.push(value.conse);
      });
      salida2 += "</table>";
      $("#tabla").append(salida1);
      $("#resultados").append(salida2);
    }
  });
}
function modif(valor)
{
  var valor;
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_consu1.php",
    data:
    {
      registro: valor
    },
    beforeSend: function ()
    {
      $("#load1").show();
    },
    error: function ()
    {
      $("#load1").hide();
    },
    success: function (data)
    {
      $("#load1").hide();
      var registros = JSON.parse(data);
      $("#conse").val(registros.conse);
      $("#fecha").val(registros.fecha1);
      $("#oficio").val(registros.oficio);
      $("#registro").val(registros.registro);
      $("#fecha1").val(registros.fecha2);
      $("#unidad").val(registros.unidad);
      $("#unidad1").val(registros.unidad1);
	  $("#brigada").val(registros.brigada);
	  $("#division").val(registros.division);
	  $("#valor").val(registros.valor);
	  $("#valor1").val(registros.valor1);
      $("#fecha2").val(registros.fecha3);
      $("#ordop1").val(registros.n_ordop);
	  $("#ordop").val(registros.ordop);
	  $("#orden").val(registros.orden);
	  $("#departamento").val(registros.departamento);
	  $("#municipio").val(registros.municipio);
	  $("#sitio").val(registros.sitio);
      $("#factor").val(registros.factor);
      var paso1;
      paso1 = $("#paso1").val();
      $("#estructura").append(paso1);
      $("#estructura").val(registros.estructura);
      $("#resultado").val(registros.concepto);
      $("#sintesis").val(registros.sintesis);
      var cedulas = registros.cedulas;
      var nombres = registros.nombres;
      var porcentajes = registros.porcentajes;
      var porcentajes1 = registros.porcentajes1;
      var var_ocu = cedulas.split("|");
      var var_ocu1 = var_ocu.length;
      var var_nom = nombres.split("|");
      var var_por = porcentajes.split("|");
      var var_pot = porcentajes1.split("|");
      var j=0;
      for(var i=0; i<var_ocu1-1; i++)
      {
      	j=j+1;
      	var cedula = var_ocu[i];
      	var nombre = var_nom[i];
      	var porcentaje = var_por[i];
      	var porcentaje1 = var_pot[i];
		if ($("#ced_"+j).length)
		{ 
		}
		else
		{
		  $("#add_field").click();
		}
      	$("#ced_"+j).val(cedula);
      	$("#nom_"+j).val(nombre);
      	$("#por_"+j).val(porcentaje);
      	$("#pot_"+j).val(porcentaje1);
      }
      suma();
      var valor2 = registros.valor2;
      if (valor2 == ".00")
      {
      	valor2="0.00";      	
      }
      valor2=parseInt(valor2);
      valor2=valor2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	  $("#valor2").val(valor2);
	  $("#aval").val(registros.acta);
	  $("#fecha3").val(registros.fecha4);
	  $("#fecha4").val(registros.fecha5);
      $("#estado1").val(registros.estado1);
      $("#observaciones").val(registros.observa);
      $("#directiva").val(registros.directiva);
      if (registros.directiva == "3")
      {
	    if (registros.tipo1 == "1")
	    {
	  		if (document.getElementById('tipo1_l3').checked)
	  		{
	  		  $("#tipo1_l3").click();
	  		}
	      	$("#tipo1_l3").click();
	    }
	    if (registros.tipo2 == "1")
	    {
	  		if (document.getElementById('tipo2_l3').checked)
	  		{
	  		  $("#tipo2_l3").click();
	  		}
	      	$("#tipo2_l3").click();
	    }
	    if (registros.tipo3 == "1")
	    {
	  		if (document.getElementById('tipo3_l3').checked)
	  		{
	  		  $("#tipo3_l3").click();
	  		}
	      	$("#tipo3_l3").click();
	    }
      }
	  $("#fecha7").val(registros.fecha7);
	  $("#fecha8").val(registros.fecha8);
	  $("#fecha9").val(registros.fecha9);
	  $("#fecha10").val(registros.fecha10);
	  $("#pago").val(registros.act_prev);
	  $("#valor_p").val(registros.valor3);
	  $("#valor_p1").val(registros.valor4);
      if (registros.pag_prev == "1")
      {
      	$("#pag_prev").prop("checked", true); 
      }
	  $("#alea").val(registros.rep_arch);
      $("#lista1").hide();
      $("#lista2").hide();
      $("#lista3").hide();
      var direc = registros.directiva;
      switch (direc)
      {
      	case '1':
      		$("#lista1").show();
      		if (registros.l1 == "1")
      		{
      			$("#l1_1_1").prop("checked", true); 
      		}
      		$("#l1_1_2").val(registros.l2);
      		$("#l1_1_3").val(registros.l3);
      		$("#l1_1_4").val(registros.l4);
      		$("#l1_1_5").val(registros.l5);
      		if (registros.l6 == "1")
      		{
      			$("#l1_2_1").prop("checked", true); 
      		}
      		$("#l1_2_2").val(registros.l7);
      		$("#l1_2_3").val(registros.l8);
      		$("#l1_2_4").val(registros.l9);
      		$("#l1_2_5").val(registros.l10);
      		if (registros.l11 == "1")
      		{
      			$("#l1_3_1").prop("checked", true); 
      		}
      		$("#l1_3_2").val(registros.l12);
      		$("#l1_3_3").val(registros.l13);
      		$("#l1_3_4").val(registros.l14);
      		$("#l1_3_5").val(registros.l15);
      		if (registros.l16 == "1")
      		{
      			$("#l1_4_1").prop("checked", true); 
      		}
      		$("#l1_4_2").val(registros.l17);
      		$("#l1_4_3").val(registros.l18);
      		$("#l1_4_4").val(registros.l19);
      		$("#l1_4_5").val(registros.l20);
      		if (registros.l21 == "1")
      		{
      			$("#l1_5_1").prop("checked", true); 
      		}
      		$("#l1_5_2").val(registros.l22);
      		$("#l1_5_3").val(registros.l23);
      		$("#l1_5_4").val(registros.l24);
      		$("#l1_5_5").val(registros.l25);
      		if (registros.l26 == "1")
      		{
      			$("#l1_6_1").prop("checked", true); 
      		}
      		$("#l1_6_2").val(registros.l27);
      		$("#l1_6_3").val(registros.l28);
      		$("#l1_6_4").val(registros.l29);
      		$("#l1_6_5").val(registros.l30);
      		if (registros.l31 == "1")
      		{
      			$("#l1_7_1").prop("checked", true); 
      		}
      		$("#l1_7_2").val(registros.l32);
      		$("#l1_7_3").val(registros.l33);
      		$("#l1_7_4").val(registros.l34);
      		$("#l1_7_5").val(registros.l35);
      		if (registros.l36 == "1")
      		{
      			$("#l1_8_1").prop("checked", true); 
      		}
      		$("#l1_8_2").val(registros.l37);
      		$("#l1_8_3").val(registros.l38);
      		$("#l1_8_4").val(registros.l39);
      		$("#l1_8_5").val(registros.l40);
      		if (registros.l41 == "1")
      		{
      			$("#l1_9_1").prop("checked", true); 
      		}
      		$("#l1_9_2").val(registros.l42);
      		$("#l1_9_3").val(registros.l43);
      		$("#l1_9_4").val(registros.l44);
      		$("#l1_9_5").val(registros.l45);
      		if (registros.l46 == "1")
      		{
      			$("#l1_10_1").prop("checked", true); 
      		}
      		$("#l1_10_2").val(registros.l47);
      		$("#l1_10_3").val(registros.l48);
      		$("#l1_10_4").val(registros.l49);
      		$("#l1_10_5").val(registros.l50);
      		if (registros.l51 == "1")
      		{
      			$("#l1_11_1").prop("checked", true); 
      		}
      		$("#l1_11_2").val(registros.l52);
      		$("#l1_11_3").val(registros.l53);
      		$("#l1_11_4").val(registros.l54);
      		$("#l1_11_5").val(registros.l55);
      		if (registros.l56 == "1")
      		{
      			$("#l1_12_1").prop("checked", true); 
      		}
      		$("#l1_12_2").val(registros.l57);
      		$("#l1_12_3").val(registros.l58);
      		$("#l1_12_4").val(registros.l59);
      		$("#l1_12_5").val(registros.l60);

      		if (registros.l61 == "1")
      		{
      			$("#l1_13_1").prop("checked", true); 
      		}
      		$("#l1_13_2").val(registros.l62);
      		$("#l1_13_3").val(registros.l63);
      		$("#l1_13_4").val(registros.l64);
      		$("#l1_13_5").val(registros.l65);
      		if (registros.l66 == "1")
      		{
      			$("#l1_14_1").prop("checked", true); 
      		}
      		$("#l1_14_2").val(registros.l67);
      		$("#l1_14_3").val(registros.l68);
      		$("#l1_14_4").val(registros.l69);
      		$("#l1_14_5").val(registros.l70);
      		if (registros.l71 == "1")
      		{
      			$("#l1_15_1").prop("checked", true); 
      		}
      		$("#l1_15_2").val(registros.l72);
      		$("#l1_15_3").val(registros.l73);
      		$("#l1_15_4").val(registros.l74);
      		$("#l1_15_5").val(registros.l75);
      		if (registros.l76 == "1")
      		{
      			$("#l1_16_1").prop("checked", true); 
      		}
      		$("#l1_16_2").val(registros.l77);
      		$("#l1_16_3").val(registros.l78);
      		$("#l1_16_4").val(registros.l79);
      		$("#l1_16_5").val(registros.l80);
      		if (registros.l81 == "1")
      		{
      			$("#l1_17_1").prop("checked", true); 
      		}
      		$("#l1_17_2").val(registros.l82);
      		$("#l1_17_3").val(registros.l83);
      		$("#l1_17_4").val(registros.l84);
      		$("#l1_17_5").val(registros.l85);
      		if (registros.l86 == "1")
      		{
      			$("#l1_18_1").prop("checked", true); 
      		}
      		$("#l1_18_2").val(registros.l87);
      		$("#l1_18_3").val(registros.l88);
      		$("#l1_18_4").val(registros.l89);
      		$("#l1_18_5").val(registros.l90);
      		if (registros.l91 == "1")
      		{
      			$("#l1_19_1").prop("checked", true); 
      		}
      		$("#l1_19_2").val(registros.l92);
      		$("#l1_19_3").val(registros.l93);
      		$("#l1_19_4").val(registros.l94);
      		$("#l1_19_5").val(registros.l95);
      		if (registros.l96 == "1")
      		{
      			$("#l1_20_1").prop("checked", true); 
      		}
      		$("#l1_20_2").val(registros.l97);
      		$("#l1_20_3").val(registros.l98);
      		$("#l1_20_4").val(registros.l99);
      		$("#l1_20_5").val(registros.l100);
      		if (registros.l101 == "1")
      		{
      			$("#l1_21_1").prop("checked", true); 
      		}
      		$("#l1_21_2").val(registros.l102);
      		$("#l1_21_3").val(registros.l103);
      		$("#l1_21_4").val(registros.l104);
      		$("#l1_21_5").val(registros.l105);
      		if (registros.l106 == "1")
      		{
      			$("#l1_22_1").prop("checked", true); 
      		}
      		$("#l1_22_2").val(registros.l107);
      		$("#l1_22_3").val(registros.l108);
      		$("#l1_22_4").val(registros.l109);
      		$("#l1_22_5").val(registros.l110);
      		break;
      	case '2':
      		$("#lista2").show();
      		if (registros.l1 == "1")
      		{
      			$("#l2_1_1").prop("checked", true); 
      		}
      		$("#l2_1_2").val(registros.l2);
      		$("#l2_1_3").val(registros.l3);
      		$("#l2_1_4").val(registros.l4);
      		$("#l2_1_5").val(registros.l5);
      		if (registros.l6 == "1")
      		{
      			$("#l2_2_1").prop("checked", true); 
      		}
      		$("#l2_2_2").val(registros.l7);
      		$("#l2_2_3").val(registros.l8);
      		$("#l2_2_4").val(registros.l9);
      		$("#l2_2_5").val(registros.l10);
      		if (registros.l11 == "1")
      		{
      			$("#l2_3_1").prop("checked", true); 
      		}
      		$("#l2_3_2").val(registros.l12);
      		$("#l2_3_3").val(registros.l13);
      		$("#l2_3_4").val(registros.l14);
      		$("#l2_3_5").val(registros.l15);
      		if (registros.l16 == "1")
      		{
      			$("#l2_4_1").prop("checked", true); 
      		}
      		$("#l2_4_2").val(registros.l17);
      		$("#l2_4_3").val(registros.l18);
      		$("#l2_4_4").val(registros.l19);
      		$("#l2_4_5").val(registros.l20);
      		if (registros.l21 == "1")
      		{
      			$("#l2_5_1").prop("checked", true); 
      		}
      		$("#l2_5_2").val(registros.l22);
      		$("#l2_5_3").val(registros.l23);
      		$("#l2_5_4").val(registros.l24);
      		$("#l2_5_5").val(registros.l25);
      		if (registros.l26 == "1")
      		{
      			$("#l2_6_1").prop("checked", true); 
      		}
      		$("#l2_6_2").val(registros.l27);
      		$("#l2_6_3").val(registros.l28);
      		$("#l2_6_4").val(registros.l29);
      		$("#l2_6_5").val(registros.l30);
      		if (registros.l31 == "1")
      		{
      			$("#l2_7_1").prop("checked", true); 
      		}
      		$("#l2_7_2").val(registros.l32);
      		$("#l2_7_3").val(registros.l33);
      		$("#l2_7_4").val(registros.l34);
      		$("#l2_7_5").val(registros.l35);
      		if (registros.l36 == "1")
      		{
      			$("#l2_8_1").prop("checked", true); 
      		}
      		$("#l2_8_2").val(registros.l37);
      		$("#l2_8_3").val(registros.l38);
      		$("#l2_8_4").val(registros.l39);
      		$("#l2_8_5").val(registros.l40);
      		if (registros.l41 == "1")
      		{
      			$("#l2_9_1").prop("checked", true); 
      		}
      		$("#l2_9_2").val(registros.l42);
      		$("#l2_9_3").val(registros.l43);
      		$("#l2_9_4").val(registros.l44);
      		$("#l2_9_5").val(registros.l45);
      		if (registros.l46 == "1")
      		{
      			$("#l2_10_1").prop("checked", true); 
      		}
      		$("#l2_10_2").val(registros.l47);
      		$("#l2_10_3").val(registros.l48);
      		$("#l2_10_4").val(registros.l49);
      		$("#l2_10_5").val(registros.l50);
      		if (registros.l51 == "1")
      		{
      			$("#l2_11_1").prop("checked", true); 
      		}
      		$("#l2_11_2").val(registros.l52);
      		$("#l2_11_3").val(registros.l53);
      		$("#l2_11_4").val(registros.l54);
      		$("#l2_11_5").val(registros.l55);
      		if (registros.l56 == "1")
      		{
      			$("#l2_12_1").prop("checked", true); 
      		}
      		$("#l2_12_2").val(registros.l57);
      		$("#l2_12_3").val(registros.l58);
      		$("#l2_12_4").val(registros.l59);
      		$("#l2_12_5").val(registros.l60);

      		if (registros.l61 == "1")
      		{
      			$("#l2_13_1").prop("checked", true); 
      		}
      		$("#l2_13_2").val(registros.l62);
      		$("#l2_13_3").val(registros.l63);
      		$("#l2_13_4").val(registros.l64);
      		$("#l2_13_5").val(registros.l65);
      		if (registros.l66 == "1")
      		{
      			$("#l2_14_1").prop("checked", true); 
      		}
      		$("#l2_14_2").val(registros.l67);
      		$("#l2_14_3").val(registros.l68);
      		$("#l2_14_4").val(registros.l69);
      		$("#l2_14_5").val(registros.l70);
      		if (registros.l71 == "1")
      		{
      			$("#l2_15_1").prop("checked", true); 
      		}
      		$("#l2_15_2").val(registros.l72);
      		$("#l2_15_3").val(registros.l73);
      		$("#l2_15_4").val(registros.l74);
      		$("#l2_15_5").val(registros.l75);
      		if (registros.l76 == "1")
      		{
      			$("#l2_16_1").prop("checked", true); 
      		}
      		$("#l2_16_2").val(registros.l77);
      		$("#l2_16_3").val(registros.l78);
      		$("#l2_16_4").val(registros.l79);
      		$("#l2_16_5").val(registros.l80);
      		if (registros.l81 == "1")
      		{
      			$("#l2_17_1").prop("checked", true); 
      		}
      		$("#l2_17_2").val(registros.l82);
      		$("#l2_17_3").val(registros.l83);
      		$("#l2_17_4").val(registros.l84);
      		$("#l2_17_5").val(registros.l85);
      		if (registros.l86 == "1")
      		{
      			$("#l2_18_1").prop("checked", true); 
      		}
      		$("#l2_18_2").val(registros.l87);
      		$("#l2_18_3").val(registros.l88);
      		$("#l2_18_4").val(registros.l89);
      		$("#l2_18_5").val(registros.l90);
      		if (registros.l91 == "1")
      		{
      			$("#l2_19_1").prop("checked", true); 
      		}
      		$("#l2_19_2").val(registros.l92);
      		$("#l2_19_3").val(registros.l93);
      		$("#l2_19_4").val(registros.l94);
      		$("#l2_19_5").val(registros.l95);
      		if (registros.l96 == "1")
      		{
      			$("#l2_20_1").prop("checked", true); 
      		}
      		$("#l2_20_2").val(registros.l97);
      		$("#l2_20_3").val(registros.l98);
      		$("#l2_20_4").val(registros.l99);
      		$("#l2_20_5").val(registros.l100);
      		if (registros.l101 == "1")
      		{
      			$("#l2_21_1").prop("checked", true); 
      		}
      		$("#l2_21_2").val(registros.l102);
      		$("#l2_21_3").val(registros.l103);
      		$("#l2_21_4").val(registros.l104);
      		$("#l2_21_5").val(registros.l105);
      		if (registros.l106 == "1")
      		{
      			$("#l2_22_1").prop("checked", true); 
      		}
      		$("#l2_22_2").val(registros.l107);
      		$("#l2_22_3").val(registros.l108);
      		$("#l2_22_4").val(registros.l109);
      		$("#l2_22_5").val(registros.l110);
      		break;
      	case '3':
      		$("#lista3").show();
      		if (registros.l1 == "1")
      		{
      			$("#l3_1_1").prop("checked", true); 
      		}
      		$("#l3_1_2").val(registros.l2);
      		$("#l3_1_3").val(registros.l3);
      		$("#l3_1_4").val(registros.l4);
      		$("#l3_1_5").val(registros.l5);
      		if (registros.l6 == "1")
      		{
      			$("#l3_2_1").prop("checked", true); 
      		}
      		$("#l3_2_2").val(registros.l7);
      		$("#l3_2_3").val(registros.l8);
      		$("#l3_2_4").val(registros.l9);
      		$("#l3_2_5").val(registros.l10);
      		if (registros.l11 == "1")
      		{
      			$("#l3_3_1").prop("checked", true); 
      		}
      		$("#l3_3_2").val(registros.l12);
      		$("#l3_3_3").val(registros.l13);
      		$("#l3_3_4").val(registros.l14);
      		$("#l3_3_5").val(registros.l15);
      		if (registros.l16 == "1")
      		{
      			$("#l3_4_1").prop("checked", true); 
      		}
      		$("#l3_4_2").val(registros.l17);
      		$("#l3_4_3").val(registros.l18);
      		$("#l3_4_4").val(registros.l19);
      		$("#l3_4_5").val(registros.l20);
      		if (registros.l21 == "1")
      		{
      			$("#l3_5_1").prop("checked", true); 
      		}
      		$("#l3_5_2").val(registros.l22);
      		$("#l3_5_3").val(registros.l23);
      		$("#l3_5_4").val(registros.l24);
      		$("#l3_5_5").val(registros.l25);
      		if (registros.l26 == "1")
      		{
      			$("#l3_6_1").prop("checked", true); 
      		}
      		$("#l3_6_2").val(registros.l27);
      		$("#l3_6_3").val(registros.l28);
      		$("#l3_6_4").val(registros.l29);
      		$("#l3_6_5").val(registros.l30);
      		if (registros.l31 == "1")
      		{
      			$("#l3_7_1").prop("checked", true); 
      		}
      		$("#l3_7_2").val(registros.l32);
      		$("#l3_7_3").val(registros.l33);
      		$("#l3_7_4").val(registros.l34);
      		$("#l3_7_5").val(registros.l35);
      		if (registros.l36 == "1")
      		{
      			$("#l3_8_1").prop("checked", true); 
      		}
      		$("#l3_8_2").val(registros.l37);
      		$("#l3_8_3").val(registros.l38);
      		$("#l3_8_4").val(registros.l39);
      		$("#l3_8_5").val(registros.l40);
      		if (registros.l41 == "1")
      		{
      			$("#l3_9_1").prop("checked", true); 
      		}
      		$("#l3_9_2").val(registros.l42);
      		$("#l3_9_3").val(registros.l43);
      		$("#l3_9_4").val(registros.l44);
      		$("#l3_9_5").val(registros.l45);
      		if (registros.l46 == "1")
      		{
      			$("#l3_10_1").prop("checked", true); 
      		}
      		$("#l3_10_2").val(registros.l47);
      		$("#l3_10_3").val(registros.l48);
      		$("#l3_10_4").val(registros.l49);
      		$("#l3_10_5").val(registros.l50);
      		//if (registros.l51 == "1")
      		//{
      		//	$("#l3_11_1").prop("checked", true); 
      		//}
      		//$("#l3_11_2").val(registros.l52);
      		//$("#l3_11_3").val(registros.l53);
      		//$("#l3_11_4").val(registros.l54);
      		//$("#l3_11_5").val(registros.l55);
      		if (registros.l56 == "1")
      		{
      			$("#l3_12_1").prop("checked", true); 
      		}
      		$("#l3_12_2").val(registros.l57);
      		$("#l3_12_3").val(registros.l58);
      		$("#l3_12_4").val(registros.l59);
      		$("#l3_12_5").val(registros.l60);

      		if (registros.l61 == "1")
      		{
      			$("#l3_13_1").prop("checked", true); 
      		}
      		$("#l3_13_2").val(registros.l62);
      		$("#l3_13_3").val(registros.l63);
      		$("#l3_13_4").val(registros.l64);
      		$("#l3_13_5").val(registros.l65);
      		if (registros.l66 == "1")
      		{
      			$("#l3_14_1").prop("checked", true); 
      		}
      		$("#l3_14_2").val(registros.l67);
      		$("#l3_14_3").val(registros.l68);
      		$("#l3_14_4").val(registros.l69);
      		$("#l3_14_5").val(registros.l70);
      		if (registros.l71 == "1")
      		{
      			$("#l3_15_1").prop("checked", true); 
      		}
      		$("#l3_15_2").val(registros.l72);
      		$("#l3_15_3").val(registros.l73);
      		$("#l3_15_4").val(registros.l74);
      		$("#l3_15_5").val(registros.l75);
      		if (registros.l76 == "1")
      		{
      			$("#l3_16_1").prop("checked", true); 
      		}
      		$("#l3_16_2").val(registros.l77);
      		$("#l3_16_3").val(registros.l78);
      		$("#l3_16_4").val(registros.l79);
      		$("#l3_16_5").val(registros.l80);
      		if (registros.l81 == "1")
      		{
      			$("#l3_17_1").prop("checked", true); 
      		}
      		$("#l3_17_2").val(registros.l82);
      		$("#l3_17_3").val(registros.l83);
      		$("#l3_17_4").val(registros.l84);
      		$("#l3_17_5").val(registros.l85);
      		if (registros.l86 == "1")
      		{
      			$("#l3_18_1").prop("checked", true); 
      		}
      		$("#l3_18_2").val(registros.l87);
      		$("#l3_18_3").val(registros.l88);
      		$("#l3_18_4").val(registros.l89);
      		$("#l3_18_5").val(registros.l90);
      		if (registros.l91 == "1")
      		{
      			$("#l3_19_1").prop("checked", true); 
      		}
      		$("#l3_19_2").val(registros.l92);
      		$("#l3_19_3").val(registros.l93);
      		$("#l3_19_4").val(registros.l94);
      		$("#l3_19_5").val(registros.l95);
      		if (registros.l96 == "1")
      		{
      			$("#l3_20_1").prop("checked", true); 
      		}
      		$("#l3_20_2").val(registros.l97);
      		$("#l3_20_3").val(registros.l98);
      		$("#l3_20_4").val(registros.l99);
      		$("#l3_20_5").val(registros.l100);
      		if (registros.l101 == "1")
      		{
      			$("#l3_21_1").prop("checked", true); 
      		}
      		$("#l3_21_2").val(registros.l102);
      		$("#l3_21_3").val(registros.l103);
      		$("#l3_21_4").val(registros.l104);
      		$("#l3_21_5").val(registros.l105);
      		if (registros.l106 == "1")
      		{
      			$("#l3_22_1").prop("checked", true); 
      		}
      		$("#l3_22_2").val(registros.l107);
      		$("#l3_22_3").val(registros.l108);
      		$("#l3_22_4").val(registros.l109);
      		$("#l3_22_5").val(registros.l110);
      		if (registros.l111 == "1")
      		{
      			$("#l3_23_1").prop("checked", true); 
      		}
      		$("#l3_23_2").val(registros.l112);
      		$("#l3_23_3").val(registros.l113);
      		$("#l3_23_4").val(registros.l114);
      		$("#l3_23_5").val(registros.l115);
      		if (registros.l116 == "1")
      		{
      			$("#l3_24_1").prop("checked", true); 
      		}
      		$("#l3_24_2").val(registros.l117);
      		$("#l3_24_3").val(registros.l118);
      		$("#l3_24_4").val(registros.l119);
      		$("#l3_24_5").val(registros.l120);
      		if (registros.l121 == "1")
      		{
      			$("#l3_25_1").prop("checked", true); 
      		}
      		$("#l3_25_2").val(registros.l122);
      		$("#l3_25_3").val(registros.l123);
      		$("#l3_25_4").val(registros.l124);
      		$("#l3_25_5").val(registros.l125);
      		break;
      	default:
      }
      $("#tabs").tabs({
        active: 0
      });
      $("#aceptar").hide();
      $("#actualizar").show();
      var estado = registros.estado;
      var estado1 = registros.estado1;
      if (estado == "P")
      {
      	$("#actualizar").hide();
      	apaga1();
      	apaga2();
    	for (i=1;i<10;i++)
    	{
    		$("#lnk_"+i).hide();
    	}
      	$("#expediente").hide();
      	$("#lnk1").hide();
	    if (direc == "3")
	    {
	    	apaga3();
	    	$("#tipo1_l3").prop("disabled", true); 
	    	$("#tipo2_l3").prop("disabled", true); 
	    	$("#tipo3_l3").prop("disabled", true); 
	    }
      }
      else
      {
      	prende1();
      	prende2();
      }
      $("#directiva").prop("disabled",true);
    }
  });
}
function actualiza()
{
  if (document.getElementById('pag_prev').checked)
  {
	previo1="1";
  }
  else
  {
	previo1="0";
  }
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "reg_actu.php",
    data:
    {
      conse: $("#conse").val(),
      fecha: $("#fecha").val(),
      oficio: $("#oficio").val(),
      registro: $("#registro").val(),
      fecha1: $("#fecha1").val(),
      unidad: $("#unidad").val(),
      unidad1: $("#unidad1").val(),
      brigada: $("#brigada").val(),
      division: $("#division").val(),
      valor: $("#valor").val(),
      valor1: $("#valor1").val(),
      fecha2: $("#fecha2").val(),
      ordop1: $("#ordop1").val(),
      ordop: $("#ordop").val(),
      orden: $("#orden").val(),
      departamento: $("#departamento").val(),
      municipio: $("#municipio").val(),
      sitio: $("#sitio").val(),
      factor: $("#factor").val(),
      estructura: $("#estructura").val(),
      tipos: $("#tipos").val(),
      resultado: $("#resultado").val(),
      cedulas: $("#cedulas").val(),
      nombres: $("#nombres").val(),
      porcentajes: $("#porcentajes").val(),
      porcentajes1: $("#porcentajes1").val(),
      directiva: $("#directiva").val(),
      fecha7: $("#fecha7").val(),
      fecha8: $("#fecha8").val(),
      previo: previo1,
      pago: $("#pago").val(),
      fecha9: $("#fecha9").val(),
      valor_p: $("#valor_p").val(),
      valor_p1: $("#valor_p1").val(),
      fecha10: $("#fecha10").val()
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
      $("#conse").val(registros.salida);
      var valida;
      valida = registros.salida;
      if (valida > 0)
      {
        $("#actualizar").hide();
        apaga1();
        apaga2();
  		for (i=0;i<document.formu.elements.length;i++)
  		{
    		saux=document.formu.elements[i].name;
    		if (saux.indexOf('ced_')!=-1)
    		{
    			valor=document.getElementById(saux).value;
    			valor1="XXXX"+valor.substr(valor.length-4);
    			document.getElementById(saux).value=valor1;
    		}
    		if (saux.indexOf('nom_')!=-1)
    		{
    			document.getElementById(saux).value="INF. SECRETO";
    		}
    	}
    	for (i=1;i<10;i++)
    	{
    		$("#lnk_"+i).hide();
    	}
      }
      else
      {
        detalle = "<br><h2><center>Error durante la grabación</center></h2>";
        $("#dialogo").html(detalle);
        $("#dialogo").dialog("open");
        $("#actualizar").show();
      }
    }
  });	
}
function prende1()
{
  $("#fecha").prop("disabled",false);
  $("#oficio").prop("disabled",false);
  $("#registro").prop("disabled",false);
  $("#fecha1").prop("disabled",false);
  $("#filtro").prop("disabled",false);
  $("#unidad").prop("disabled",false);
  $("#filtro1").prop("disabled",false);
  $("#unidad1").prop("disabled",false);
  $("#sintesis").prop("disabled",false);
  $("#valor").prop("disabled",false);
  $("#fecha2").prop("disabled",false);
  $("#ordop").prop("disabled",false);
  $("#ordop1").prop("disabled",false);
  $("#orden").prop("disabled",false);
  $("#filtro2").prop("disabled",false);
  $("#departamento").prop("disabled",false);
  $("#municipio").prop("disabled",false);
  $("#sitio").prop("disabled",false);
  $("#factor").prop("disabled",false);
  $("#estructura").prop("disabled",false);
  $("#tipo1").prop("disabled",false);
  $("#tipo2").prop("disabled",false);
  $("#tipo3").prop("disabled",false);
  $("#tipo4").prop("disabled",false);
  $("#resultado").prop("disabled",false);
  $("#directiva").prop("disabled",false);
  $("#fecha7").prop("disabled",false);
  $("#fecha8").prop("disabled",false);
  $("#fecha9").prop("disabled",false);
  $("#fecha10").prop("disabled",false);
  $("#pago").prop("disabled",false);
  $("#valor_p").prop("disabled",false);
  $("#pag_prev").prop("disabled",false);
}
function apaga1()
{
  $("#fecha").prop("disabled",true);
  $("#oficio").prop("disabled",true);
  $("#registro").prop("disabled",true);
  $("#fecha1").prop("disabled",true);
  $("#filtro").prop("disabled",true);
  $("#unidad").prop("disabled",true);
  $("#filtro1").prop("disabled",true);
  $("#unidad1").prop("disabled",true);
  $("#sintesis").prop("disabled",true);
  $("#valor").prop("disabled",true);
  $("#fecha2").prop("disabled",true);
  $("#ordop").prop("disabled",true);
  $("#ordop1").prop("disabled",true);
  $("#orden").prop("disabled",true);
  $("#filtro2").prop("disabled",true);
  $("#departamento").prop("disabled",true);
  $("#municipio").prop("disabled",true);
  $("#sitio").prop("disabled",true);
  $("#factor").prop("disabled",true);
  $("#estructura").prop("disabled",true);
  $("#tipo1").prop("disabled",true);
  $("#tipo2").prop("disabled",true);
  $("#tipo3").prop("disabled",true);
  $("#tipo4").prop("disabled",true);
  $("#resultado").prop("disabled",true);
  $("#directiva").prop("disabled",true);
  $("#fecha7").prop("disabled",true);
  $("#fecha8").prop("disabled",true);
  $("#fecha9").prop("disabled",true);
  $("#fecha10").prop("disabled",true);
  $("#pago").prop("disabled",true);
  $("#valor_p").prop("disabled",true);
  $("#pag_prev").prop("disabled",true);
}
function prende2()
{
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      document.getElementById(saux).removeAttribute("disabled");
    }
    if (saux.indexOf('nom_')!=-1)
    {
      document.getElementById(saux).removeAttribute("disabled");
    }
    if (saux.indexOf('por_')!=-1)
    {
      document.getElementById(saux).removeAttribute("disabled");
    }
  }
  for (j=1;j<=10;j++)
  {
    $("#men_"+j).show();
  }
  $("#add_field").show();
}
function apaga2()
{
  for (i=0;i<document.formu.elements.length;i++)
  {
    saux=document.formu.elements[i].name;
    if (saux.indexOf('ced_')!=-1)
    {
      document.getElementById(saux).setAttribute("disabled","disabled");
    }
    if (saux.indexOf('nom_')!=-1)
    {
      document.getElementById(saux).setAttribute("disabled","disabled");
    }
    if (saux.indexOf('por_')!=-1)
    {
      document.getElementById(saux).setAttribute("disabled","disabled");
    }
  }
  for (j=1;j<=10;j++)
  {
    $("#men_"+j).hide();
  }
  $("#add_field").hide();
}
function apaga3(valor)
{
	var valor;
	valor = parseInt(valor);
	for (j=1;j<=valor;j++)
	{
	    $("#l3_"+j+"_1").prop("disabled",true);
	   	$("#l3_"+j+"_2").prop("disabled",true);
	   	$("#l3_"+j+"_3").prop("disabled",true);
	   	$("#l3_"+j+"_4").prop("disabled",true);
	   	$("#l3_"+j+"_5").prop("disabled",true);
  	}
}
function solicitar()
{
  var interno = $("#conse").val();
  var unidad = $("#n_unidad").val();
  var unidad1 = $("#n_unidad1").val();
  $.ajax({
    type: "POST",
    datatype: "json",
    url: "trae_personas.php",
    data:
    {
      unidad: unidad,
      unidad1: unidad1
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
      salida += "<table width='95%' align='center' border='0'>";
      salida += "<tr><td width='30%' height='25'><b>Usuario</b></td><td width='50%' height='25'><b>Nombre</b></td><td width='15%' height='25'><b>Unidad</b></td><td width='5%' height='25'>&nbsp;</td></tr>";
      var var_con = registros.conses.split('|');
      var var_usu = registros.usuarios.split('|');
      var var_nom = registros.nombres.split('|');
      var var_sig = registros.siglas.split('|');
      var var_con1 = var_con.length;
      for (var j=0; j<var_con1-1; j++)
      {
        var var1 = var_con[j];
        var var2 = var_usu[j];
        var var3 = var_nom[j];
        var var4 = var_sig[j];
        var paso = "\'"+var2+"\'";
        var paso1 = "\'"+var3+"\'";
        salida += '<tr><td width="30%">'+var2+'</td><td width="50%">'+var3+'</td><td width="15%">'+var4+'</td><td width="5%"><input type="checkbox" name="seleccionados[]" id="chk_'+j+'" value='+var2+' onclick="trae_marca('+paso+','+paso1+','+j+');"></td></tr>';
      }
      salida += '</table>';
      salida += '<input type="hidden" name="interno" id="interno" value="'+interno+'"><input type="hidden" name="usu1" id="usu1" readonly="readonly"><input type="hidden" name="nom1" id="nom1" readonly="readonly">';
      $("#val_modi").append(salida);
      $("#dialogo3").dialog("open");
    }
  });
}
function trae_marca(valor, valor1, valor2)
{
  var valor, valor1, valor2;
  $("#usu1").val(valor);
  $("#nom1").val(valor1);
  $("input[name='seleccionados[]']").each(
  	function ()
    {
    	$(this).prop('checked', false);
    }
  );
  $("#chk_"+valor2).prop('checked', true);
}
function enviar()
{
  	var seleccionadosarray = [];
  	$("input[name='seleccionados[]']").each(
    	function ()
    	{
	      	if ($(this).is(":checked"))
	      	{
	        	seleccionadosarray.push($(this).val());
	      	}
    	}
  	);
  	var num_sel = seleccionadosarray.length;
  	if (num_sel == "0")
  	{
    	var detalle = "<br><h3><center>Debe seleccionar un usuario a notificar.</center></h3>";
    	$("#dialogo4").html(detalle);
    	$("#dialogo4").dialog("open");
  	}
  	else
  	{
		var valor = $("#usu1").val();
		var valor1 = $("#nom1").val();
		var valor2 = $("#interno").val();
		var tipo = "1";
	    $.ajax({
	      type: "POST",
	      datatype: "json",
	      url: "noti_grab6.php",
	      data:
	      {
	        valor: valor,
	        valor1: valor1,
	        valor2: valor2,
	        tipo: tipo
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
		    if (valida == "A")
		    {
		      	$("#dialogo2").dialog("close");
		      	$("#aceptar1").hide();
		      	var detalle;
		      	detalle = "<br><h3><center>Notificaci&oacute;n Enviada a: "+valor1+"</center></h3>";
		        $("#dialogo").html(detalle);
		        $("#dialogo").dialog("open");
		    }
	      }
	    });
	}
}
</script>
</body>
</html>
<?php
}
?>