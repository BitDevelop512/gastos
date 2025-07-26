<?php
session_start();
error_reporting(0);
require('conf.php');
include('permisos.php');
// Notificaciones
$cur = odbc_exec($conexion,"SELECT COUNT(1) AS contador FROM cx_notifica WHERE usuario1='$usu_usuario' AND unidad1='$uni_usuario' AND visto='1'");
$contador = odbc_result($cur,1);
// Mensajes informativos
$cur1 = odbc_exec($conexion,"SELECT COUNT(1) AS contador1 FROM cx_men_usu WHERE usuario1='$usu_usuario' AND visto='1'");
$contador1 = odbc_result($cur1,1);
$contador = $contador+$contador1;
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/style1.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<style>
	body
	{
	    background: #f4f7f9;
	}
	.logo
	{
		margin-top: 5px;
		margin-left: 5px;
	}
	A:link			{ text-decoration: none }
	A:visited		{ text-decoration: none }
	A:active		{ text-decoration: none }
	A:hover			{ text-decoration: none }
	</style>
</head>
<body style="overflow-x:hidden; overflow-y:auto;">
	<ul class="mainmenu">
		<?php
		if (strpos($per_usuario, "A|") !== false)
		{
		?>
		<li>
			<img src="images/user.png" class="icon"><span>Planeaci&oacute;n<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "A|01/") !== false)
			{
			?>
				<li>
					<a href="plan_inver.php" target="derecha">
						<span>
							<font color="#ffffff">Plan de Inversi&oacute;n / Solicitud</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "A|02/") !== false)
			{
			?>
				<li>
					<a href="revi_plav.php" target="derecha">
						<span>
							<font color="#ffffff">Revisi&oacute;n Planes / Solicitudes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "A|03/") !== false)
			{
			?>
				<li>
					<a href="plan_centra.php" target="derecha">
						<span>
							<font color="#ffffff">Plan de Inver. Centralizado</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "A|05/") !== false)
			{
			?>
				<li>
					<a href="plan_conso.php" target="derecha">
						<span>
							<font color="#ffffff">Consulta Plan Consolidado</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "A|06/") !== false)
			{
			?>
				<li>
					<a href="plan_centra1.php" target="derecha">
						<span>
							<font color="#ffffff">Consulta Plan Centralizado</font>
						</span>
					</a>
				</li>
			<?php
			}
			if ((strpos($per_usuario, "A|04/") !== false) and (($uni_usuario == "1") or ($uni_usuario == "2")))
			{
			?>
				<li>
					<a href="plan_nece.php" target="derecha">
						<span>
							<font color="#ffffff">Plan de Necesidades</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Ejecucion
-->
		<?php
		if (strpos($per_usuario, "B|") !== false)
		{
		?>
		<li>
			<img src="images/ejec.png" class="icon"><span>Ejecuci&oacute;n<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "B|06/") !== false)
			{
			?>
				<li>
					<a href="cuen_banc.php" target="derecha">
						<span>
							<font color="#ffffff">Cuentas Bancarias</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "B|01/") !== false)
			{
			?>
				<li>
					<a href="info_giro.php" target="derecha">
						<span>
							<font color="#ffffff">Informe de Giro</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "B|02/") !== false)
			{
			?>
				<li>
					<a href="info_auto.php" target="derecha">
						<span>
							<font color="#ffffff">Informe de Autorizaci&oacute;n</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "B|03/") !== false)
			{
			?>
				<li>
					<a href="comp_ingr.php" target="derecha">
						<span>
							<font color="#ffffff">Comprobantes de Ingreso</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "B|04/") !== false)
			{
			?>
				<li>
					<a href="comp_egrc.php" target="derecha">
						<span>
							<font color="#ffffff">Comprobantes de Egreso</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "B|05/") !== false)
			{
			?>
				<li>
					<a href="comp_consu.php" target="derecha">
						<span>
							<font color="#ffffff">Consulta de Comprobantes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "B|07/") !== false)
			{
			?>
				<li>
					<a href="acre_vari.php" target="derecha">
						<span>
							<font color="#ffffff">Acreedores Varios</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Soportes
-->
		<?php
		if (strpos($per_usuario, "C|") !== false)
		{
		?>
		<li>
			<img src="images/comp.png" class="icon"><span>Soportes Ejecuci&oacute;n<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "C|01/") !== false)
			{
			?>
				<li>
					<a href="acta_inf.php" target="derecha">
						<span>
							<font color="#ffffff">Acta Pago de Informaci&oacute;n</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|06/") !== false)
			{
			?>
				<li>
					<a href="acta_rec.php" target="derecha">
						<span>
							<font color="#ffffff">Acta Pago de Recompensa</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|02/") !== false)
			{
			?>
				<li>
					<a href="plan_gas.php" target="derecha">
						<span>
							<font color="#ffffff">Planilla Gastos B&aacute;sicos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|03/") !== false)
			{
			?>
				<li>
					<a href="rela_gas.php?tipo=1" target="derecha">
						<span>
							<font color="#ffffff">Informe de Gastos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|04/") !== false)
			{
			?>
				<li>
					<a href="rela_gas.php?tipo=2" target="derecha">
						<span>
							<font color="#ffffff">Relaci&oacute;n de Gastos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|05/") !== false)
			{
			?>
				<li>
					<a href="info_eje.php" target="derecha">
						<span>
							<font color="#ffffff">Informe Ejecutivo</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|08/") !== false)
			{
			?>
				<li>
					<a href="acta_ver.php" target="derecha">
						<span>
							<font color="#ffffff">Informe de Verificaci&oacute;n GGRR</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|09/") !== false)
			{
			?>
				<li>
					<a href="cuen_gas.php" target="derecha">
						<span>
							<font color="#ffffff">Cuenta Gastos Reservados</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|07/") !== false)
			{
			?>
				<li>
					<a href="auto_recur.php" target="derecha">
						<span>
							<font color="#ffffff">Autorizaci&oacute;n Recurso Adicional</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "C|10/") !== false)
			{
			?>
				<li>
					<a href="repo_var.php" target="derecha">
						<span>
							<font color="#ffffff">Reportes</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Libros
-->
		<?php
		if (strpos($per_usuario, "D|") !== false)
		{
		?>
		<li>
			<img src="images/libro.png" class="icon"><span>Libros Auxiliares</span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "D|01/") !== false)
			{
			?>
				<li>
					<a href="libr_auxi.php?tipo=1" target="derecha">
						<span>
							<font color="#ffffff">Auxiliar de Bancos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "D|02/") !== false)
			{
			?>
				<li>
					<a href="libr_auxi.php?tipo=2" target="derecha">
						<span>
							<font color="#ffffff">Inf. Consolidado Ejecuci&oacute;n</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "D|03/") !== false)
			{
			?>
				<li>
					<a href="libr_auxi.php?tipo=3" target="derecha">
						<span>
							<font color="#ffffff">Inf. Detallado Comprobantes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "D|04/") !== false)
			{
			?>
				<li>
					<a href="libr_auxi.php?tipo=4" target="derecha">
						<span>
							<font color="#ffffff">Control Erogaciones</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "D|05/") !== false)
			{
			?>
				<li>
					<a href="conc_banc.php" target="derecha">
						<span>
							<font color="#ffffff">Conciliaci&oacute;n Bancaria</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Recompensas
-->
		<?php
		if (strpos($per_usuario, "E|") !== false)
		{
		?>
		<li>
			<img src="images/recom.png" class="icon"><span>Recompensas</span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "E|01/") !== false)
			{
			?>
				<li>
					<a href="reg_recom.php" target="derecha">
						<span>
							<font color="#ffffff">Registro de Recompensas</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "E|02/") !== false)
			{
			?>
				<li>
					<a href="reg_verif.php" target="derecha">
						<span>
							<font color="#ffffff">Revisi&oacute;n Recompensa / PI</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "E|03/") !== false)
			{
			?>
				<li>
					<a href="acta_reg.php" target="derecha">
						<span>
							<font color="#ffffff">Acta Comit&eacute; Regional Recomp.</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "E|05/") !== false)
			{
			?>
				<li>
					<a href="acta_cen.php" target="derecha">
						<span>
							<font color="#ffffff">Acta Comit&eacute; Central Recomp.</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "E|04/") !== false)
			{
			?>
				<li>
					<a href="reg_recom1.php" target="derecha">
						<span>
							<font color="#ffffff">Registro Manual Recompensas</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "E|07/") !== false)
			{
			?>
				<li>
					<a href="reg_recom2.php" target="derecha">
						<span>
							<font color="#ffffff">Registro Pago Información</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "E|06/") !== false)
			{
			?>
				<li>
					<a href="auto_recom.php" target="derecha">
						<span>
							<font color="#ffffff">Autorizaci&oacute;n Recompensas</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Presupuesto
-->
		<?php
		if (strpos($per_usuario, "F|") !== false)
		{
		?>
		<li>
			<img src="images/pres.png" class="icon"><span>Presupuesto<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "F|01/") !== false)
			{
			?>
				<li>
					<a href="cont_pres.php" target="derecha">
						<span>
							<font color="#ffffff">Control Presupuestal</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "F|02/") !== false)
			{
			?>
				<li>
					<a href="cont_dist.php" target="derecha">
						<span>
							<font color="#ffffff">Contratos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "F|03/") !== false)
			{
			?>
				<li>
					<a href="cont_carg.php" target="derecha">
						<span>
							<font color="#ffffff">Cargue Presupuesto PAA</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Bienes
-->
		<?php
		if (strpos($per_usuario, "H|") !== false)
		{
		?>
		<li>
			<img src="images/bienes.png" class="icon"><span>Bienes<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "H|01/") !== false)
			{
			?>
				<li>
					<a href="admi_bienes.php" target="derecha">
						<span>
							<font color="#ffffff">Creaci&oacute;n de Bienes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "H|02/") !== false)
			{
			?>
				<li>
					<a href="admi_bienes1.php" target="derecha">
						<span>
							<font color="#ffffff">Administraci&oacute;n de Bienes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "H|03/") !== false)
			{
			?>
				<li>
					<a href="movi_bienes.php" target="derecha">
						<span>
							<font color="#ffffff">Movimiento de Bienes</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Transportes
-->
		<?php
		if (strpos($per_usuario, "J|") !== false)
		{
		?>
		<li>
			<img src="images/trans.png" class="icon"><span>Transportes<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "J|01/") !== false)
			{
			?>
				<li>
					<a href="admi_transpor.php" target="derecha">
						<span>
							<font color="#ffffff">Administraci&oacute;n de Transportes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "J|06/") !== false)
			{
			?>
				<li>
					<a href="admi_techos.php" target="derecha">
						<span>
							<font color="#ffffff">Administraci&oacute;n de Techos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "J|02/") !== false)
			{
			?>
				<li>
					<a href="movi_transpor.php" target="derecha">
						<span>
							<font color="#ffffff">Movimiento de Veh&iacute;culos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "J|04/") !== false)
			{
			?>
				<li>
					<a href="movi_transpor1.php" target="derecha">
						<span>
							<font color="#ffffff">Movimiento Transp. Contratos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "J|03/") !== false)
			{
			?>
				<li>
					<a href="repo_transpor.php" target="derecha">
						<span>
							<font color="#ffffff">Reportes Transportes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "J|05/") !== false)
			{
			?>
				<li>
					<a href="recu_consu.php" target="derecha">
						<span>
							<font color="#ffffff">Recursos Formalizados</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Mensajes
-->
		<li>
			<img src="images/envelope.png" class="icon"><span>Mensajes</span><div class="messages"><?php echo $contador; ?></div>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<li>
				<a href="mensajes.php?tipo=1" target="derecha">
					<span>
						<font color="#ffffff">Nuevos</font>
					</span>
				</a>
			</li>
			<li>
				<a href="mensajes.php?tipo=0" target="derecha">
					<span>
						<font color="#ffffff">Todos</font>
					</span>
				</a>
			</li>
			<?php
			if (strpos($per_usuario, "G|15/") !== false)
			{
			?>
				<li>
					<a href="admi_mensajes.php" target="derecha">
						<span>
							<font color="#ffffff">Mensajes Informativos</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
<!--
Informacion
-->
		<li>
			<img src="images/info.png" class="icon"><span>Informaci&oacute;n<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<li>
				<a href="para_usua.php" target="derecha">
					<span>
						<font color="#ffffff">Par&aacute;metros de Usuario</font>
					</span>
				</a>
			</li>
			<li>
				<a href="cambio.php?mensaje=1" target="derecha">
					<span>
						<font color="#ffffff">Cambio de Clave</font>
					</span>
				</a>
			</li>
		</ul>

<!--
Administrador
-->
		<?php
		if ((strpos($per_usuario, "G|") !== false) or ($sup_usuario == "1"))
		{
		?>
		<li>
			<img src="images/cog.png" class="icon"><span>Administrador</span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "G|01/") !== false)
			{
			?>
				<li>
					<a href="admi_unidad.php" target="derecha">
						<span>
							<font color="#ffffff">Creaci&oacute;n Unidades</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|02/") !== false)
			{
			?>
				<li>
					<a href="admi_roles.php" target="derecha">
						<span>
							<font color="#ffffff">Creaci&oacute;n Roles Usuarios</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|03/") !== false)
			{
			?>
				<li>
					<a href="admi_usuarios.php" target="derecha">
						<span>
							<font color="#ffffff">Control de Usuarios</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|04/") !== false)
			{
			?>
				<li>
					<a href="admi_parame.php" target="derecha">
						<span>
							<font color="#ffffff">Usuarios Parametrizados</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|05/") !== false)
			{
			?>
				<li>
					<a href="admi_material.php" target="derecha">
						<span>
							<font color="#ffffff">Creaci&oacute;n Material - Niveles</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|09/") !== false)
			{
			?>
				<li>
					<a href="admi_gastos.php" target="derecha">
						<span>
							<font color="#ffffff">Creaci&oacute;n Configuraciones</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|17/") !== false)
			{
			?>
				<li>
					<a href="admi_norma.php" target="derecha">
						<span>
							<font color="#ffffff">Cargue Normatividad</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|06/") !== false)
			{
			?>
				<li>
					<a href="admi_excel.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de Usuarios</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|07/") !== false)
			{
			?>
				<li>
					<a href="admi_bienes2.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de Bienes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|10/") !== false)
			{
			?>
				<li>
					<a href="admi_transpor1.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de Transportes</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|11/") !== false)
			{
			?>
				<li>
					<a href="admi_repuestos.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de Repuestos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|12/") !== false)
			{
			?>
				<li>
					<a href="admi_manteni.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de Mantenimientos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|13/") !== false)
			{
			?>
				<li>
					<a href="admi_llantas.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de Llantas</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|14/") !== false)
			{
			?>
				<li>
					<a href="admi_rtm.php" target="derecha">
						<span>
							<font color="#ffffff">Importaci&oacute;n de RTM</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|08/") !== false)
			{
			?>
				<li>
					<a href="admi_accam.php" target="derecha">
						<span>
							<font color="#ffffff">Control ACCAM</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "G|16/") !== false)
			{
			?>
				<li>
					<a href="admi_radica.php" target="derecha">
						<span>
							<font color="#ffffff">Radicaci&oacute;n Documentos</font>
						</span>
					</a>
				</li>
			<?php
			}
			if ($sup_usuario == "1")
			{
			?>
				<li>
					<a href="admi_sigar.php" target="_blank">
						<span>
							<font color="#ffffff">Admnistraci&oacute;n SIGAR</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
			</ul>
		</li>
		<?php
		}
		?>
<!--
Estadisticas
-->
		<?php
		if (strpos($per_usuario, "I|") !== false)
		{
		?>
		<li>
			<img src="images/estadis.png" class="icon"><span>Estad&iacute;sticas<span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<?php
			if (strpos($per_usuario, "I|01/") !== false)
			{
			?>
				<li>
					<a href="esta_sigar.php" target="derecha">
						<span>
							<font color="#ffffff">Estad&iacute;sticas Varias</font>
						</span>
					</a>
				</li>
			<?php
			}
			if (strpos($per_usuario, "I|02/") !== false)
			{
			?>
				<li>
					<a href="esta_sigar1.php" target="derecha">
						<span>
							<font color="#ffffff">Seguimiento GGRR</font>
						</span>
					</a>
				</li>
			<?php
			}
			?>
		</ul>
		<?php
		}
		?>
<!--
Normograma
-->
		<li>
			<img src="images/normas.png" class="icon"><span>Normatividad</span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<li>
				<a href="normas.php?tipo=1" target="derecha">
					<span>
						<font color="#ffffff">Leyes</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=2" target="derecha">
					<span>
						<font color="#ffffff">Decretos</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=3" target="derecha">
					<span>
						<font color="#ffffff">Resoluciones</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=4" target="derecha">
					<span>
						<font color="#ffffff">Manuales</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=5" target="derecha">
					<span>
						<font color="#ffffff">Directivas</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=6" target="derecha">
					<span>
						<font color="#ffffff">Planes</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=7" target="derecha">
					<span>
						<font color="#ffffff">Circulares</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=8" target="derecha">
					<span>
						<font color="#ffffff">Boletines Instructivos</font>
					</span>
				</a>
			</li>
			<li>
				<a href="normas.php?tipo=9" target="derecha">
					<span>
						<font color="#ffffff">Otras Comunicaciones</font>
					</span>
				</a>
			</li>
		</ul>
<!--
Chat - PQR
-->
		<li>
			<img src="images/chat.png" class="icon"><span>Soporte</span>
		</li>
		<ul class="submenu">
			<div class="expand-triangle">
				<img src="images/expand.png">
			</div>
			<li>
				<a href="./chat/chat_sigar.php" target="_blank">
					<span>
						<font color="#ffffff">Chat</font>
					</span>
				</a>
			</li>
			<li>
				<a href="pqr_sigar.php" target="derecha">
					<span>
						<font color="#ffffff">Soporte T&eacute;cnico</font>
					</span>
				</a>
			</li>
		</ul>
		<li><img src="images/key.png" class="icon"><a href="logout.php"><span><font color="#ffffff">Cerrar Sesi&oacute;n</font></span></a></li>
	</ul>
</body>
<script src="js/script.js"></script>
<script src="js/retina.min.js"></script>
</html>
<?php
// 25/08/2023 - Nuevo pemriso incluido - Importador de Mantenimientos
// 14/12/2023 - Nuevo pemriso incluido - Importador de Llantas
// 09/04/2024 - Nuevo pemriso incluido - Consulta Concepto del Gasto
// 12/08/2024 - Nuevo permiso incluido - Radicación Documentos
// 05/12/2024 - Nuevo permiso incluido - Cargue Presupuesto PAA
?>