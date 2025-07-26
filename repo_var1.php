<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
  $tipo = $_POST['tipo'];
  $concepto = $_POST['concepto'];
  $conceptos = stringArray1($concepto);
  $unidad = $_POST['unidad'];
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $valida = "0";
  // Gastos Solicitados y Versus
	if (($tipo == "1") or ($tipo == "3"))
	{
		$pregunta = "SELECT conse, unidad, ano, usuario, fecha, periodo, ordop, misiones, estado, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_pla_inv.unidad) AS n_unidad, tipo FROM cx_pla_inv WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND unidad!='999' AND estado!='' AND EXISTS (SELECT * FROM cx_pla_gad WHERE cx_pla_gad.conse1=cx_pla_inv.conse AND cx_pla_gad.ano=cx_pla_inv.ano";
		if ($conceptos == "999")
		{
			$pregunta .= ")";
		}
		else
		{
			$pregunta .= " AND cx_pla_gad.gasto IN ($conceptos))";
		}
		if ($unidad == "-")
		{
		}
		else
		{
      if (($sup_usuario == "1") or ($sup_usuario == "2"))
      {
        $query = "SELECT unidad, dependencia, tipo, unic FROM cx_org_sub WHERE subdependencia='$unidad'";
        $cur = odbc_exec($conexion, $query);
        $n_unidad = odbc_result($cur,1);
        $n_dependencia = odbc_result($cur,2);
        $n_tipo = odbc_result($cur,3);
        $n_unic = odbc_result($cur,4);
        if ($n_unic == "0")
        {
          $numero = $unidad;
        }
        else
        {
          if (($n_unidad == "1") or ($n_unidad == "2") or ($n_unidad == "3"))
          {
            if (($n_unidad == "2") or ($n_unidad == "3"))
            {
              $pregunta0 = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad'";
              $sql0 = odbc_exec($conexion, $pregunta0);
              $dependencia = odbc_result($sql0,1);
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
            }
            else
            {
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE (dependencia='$n_dependencia' AND tipo='2' AND unic='0') OR (unidad='$n_unidad') ORDER BY subdependencia";
            }
          }
          else
          {
            if ($n_tipo == "7")
            {
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
            }
            else
            {
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY subdependencia";
            }
          }
          $cur1 = odbc_exec($conexion, $query1);
          $numero = "";
          while($i<$row=odbc_fetch_array($cur1))
          {
            $numero .= "'".odbc_result($cur1,1)."',";
          }
          $numero = substr($numero,0,-1);
          // Se verifica si es unidad centralizadora especial
          if (strpos($especial, $unidad) !== false)
          {
            $numero .= ",";
            $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$n_unidad' ORDER BY unidad";
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
        }
        $pregunta .= " AND unidad in ($numero)";
      }
      else
      {
        $pregunta .= " AND unidad='$unidad'";
      }
		}
		$pregunta .= " ORDER BY fecha DESC";
		$sql = odbc_exec($conexion, $pregunta);
		$total = odbc_num_rows($sql);
		$valores = "";
		$salida = new stdClass();
		if ($total>0)
		{
			$i = 0;
			while ($i < $row = odbc_fetch_array($sql))
			{
				$conse = odbc_result($sql,1);
				$unidad1 = odbc_result($sql,2);
				$ano = odbc_result($sql,3);
				$usuario = trim(odbc_result($sql,4));
				$fecha = odbc_result($sql,5);
				$fecha = substr($fecha,0,10);
				$periodo = odbc_result($sql,6);
				$ordop = trim($row['ordop']);
				$ordop1 = decrypt1($ordop, $llave);
				$ordop1 = str_replace("#", "", $ordop1);
				$ordop1 = str_replace("|", "", $ordop1);
        $ordop1 = str_replace('"', "", $ordop1);
				$ordop1 = trim($ordop1);
				$mision = trim($row['misiones']);
				$mision1 = decrypt1($mision, $llave);
				$mision1 = str_replace("|", "¥", $mision1);
				$estado = odbc_result($sql,9);
				$n_unidad = trim(odbc_result($sql,10));
        $tipo2 = odbc_result($sql,11);
        if ($tipo2 == "1")
        {
          $tipo3 = "Plan de Inversión";
        }
        else
        {
          $tipo3 = "Solicitud de Recursos";
        }
				$mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
				$pregunta1 = "SELECT valor, bienes, gasto, (SELECT nombre FROM cx_ctr_pag WHERE cx_ctr_pag.codigo=cx_pla_gad.gasto) AS n_gasto, interno FROM cx_pla_gad WHERE conse1='$conse' AND ano='$ano'";
        if ($conceptos == "999")
        {
        }
        else
        {
          $pregunta1 .= " AND gasto IN ($conceptos)";
        }
        $pregunta1 .= " ORDER BY gasto";
				$sql1 = odbc_exec($conexion, $pregunta1);
				$l = 0;
				while ($l < $row1 = odbc_fetch_array($sql1))
				{
					$valor = trim(odbc_result($sql1,1));
					$datos = trim(utf8_encode($row1['bienes']));
					$gasto1 = trim(odbc_result($sql1,3));
					$gasto2 = trim(utf8_encode(odbc_result($sql1,4)));
          $interno = odbc_result($sql1,5);
					$num_datos = explode("|",$datos);
          $placa = "";
          $clase = "";
          $tpcombus1 = "";
					// Combustible
					if (($gasto1 == "36") or ($gasto1 == "42"))
					{
						$otros = "";
						$val_bie = $datos;
						$val_bie1 = explode("#", $val_bie);
						$val_bie2 = explode("&", $val_bie1[0]);
						$val_bie3 = explode("&", $val_bie1[1]);
						$val_bie4 = explode("&", $val_bie1[2]);
						$val_bie5 = explode("&", $val_bie1[3]);
						$val_bie6 = explode("&", $val_bie1[4]);
						for ($k=0;$k<count($val_bie4)-1;++$k)
						{
							// Variables
							$placa = trim($val_bie3[$k]);
							$clase = trim($val_bie2[$k]);
							$valor = trim($val_bie4[$k]);
							$valor = str_replace(',','',$valor);
							$valor = floatval($valor);
							$detalle = trim($val_bie6[$k]);
							$numero = "";
							$consecu = $conse;
							$kilometraje = "";
							$kilometraja = "";
							$cantidad = "0";
							// Tipo de combustible
							$pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
							$sql5 = odbc_exec($conexion, $pregunta5);
							$tpcombus = odbc_result($sql5,1);
							// Nombre tipo de combustible
							$pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
							$sql6 = odbc_exec($conexion, $pregunta6);
							$tpcombus1 = trim(odbc_result($sql6,1));
              if (($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                if ($tipo == "3")
                {
                  $pregunta5 = "SELECT valor1, datos, (SELECT periodo FROM cx_rel_gas WHERE consecu='$conse' AND ano='$ano' AND unidad='$unidad1' and numero='$interno') AS periodo, tipo FROM cx_rel_dis WHERE gasto='$gasto1' AND consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno' AND cx_rel_gas.unidad!='999')";
                  $sql5 = odbc_exec($conexion, $pregunta5);
                  $tot5 = odbc_num_rows($sql5);
                  if ($tot5 == "0")
                  {
                    $valor1 = "0";
                  }
                  else
                  {
                    $valor2 = 0;
                    $m = 0;
                    while ($m < $row5 = odbc_fetch_array($sql5))
                    {
                      $valor1 = odbc_result($sql5,1);
                      $tipo1 = odbc_result($sql5,4);
                      if ($tipo1 == "S")
                      {
                        $datos1 = trim($row5["datos"]);
                        $num_datos = explode("|",$datos1);
                        $con_datos = count($num_datos);
                        if ($con_datos > 2)
                        {
                          for ($z=0;$z<$con_datos;++$z)
                          {
                            $v_paso = utf8_encode($num_datos[$z]);
                            $v_placas = explode("»",$v_paso);
                            $v_paso1 = $v_placas[1];
                            $v_paso2 = $v_placas[3];
                            if ($placa == $v_paso1)
                            {
                              $valor1 = $v_paso2;
                              $valor1 = floatval($valor1);
                            }
                          }
                        }
                        $valor2 = $valor2+$valor1;
                      }
                      else
                      {
                        $valor2 = $valor2+$valor1;
                      }
                      $valor1 = $valor2;
                      $m++;
                    }
                    $periodor = odbc_result($sql5,3);
                    if ($periodo == $periodor)
                    {
                    }
                    else
                    {
                      $valor1 = "0"; 
                    }
                  }
                }
                else
                {
                  $valor1 = "0";
                  $periodor = $periodo;
                }
  							$valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|".$valor1."|".$periodor."|#";
              }
						}
						$valida = "1";
					}
					// Mantenimiento
					if (($gasto1 == "38") or ($gasto1 == "44"))
					{
						$otros = "";
						$val_bie = $datos;
						$val_bie1 = explode("#", $val_bie);
						$val_bie2 = explode("&", $val_bie1[0]);
						$val_bie3 = explode("&", $val_bie1[1]);
						$val_bie4 = explode("&", $val_bie1[2]);
						$val_bie5 = explode("&", $val_bie1[3]);
						$val_bie6 = explode("&", $val_bie1[4]);
						$val_bie7 = explode("&", $val_bie1[5]);
						$val_bie8 = explode("&", $val_bie1[6]);
						$val_bie9 = explode("&", $val_bie1[7]);
						$val_bie10 = explode("&", $val_bie1[8]);
						$val_bie11 = explode("&", $val_bie1[9]);
						$val_bie12 = explode("&", $val_bie1[10]);
						$val_bie13 = explode("&", $val_bie1[11]);
						$val_bie14 = explode("&", $val_bie1[12]);
						$val_bie15 = explode("&", $val_bie1[13]);
						$val_bie16 = explode("&", $val_bie1[14]);
						$val_bie17 = explode("&", $val_bie1[15]);
						$val_bie18 = explode("&", $val_bie1[16]);
						for ($k=0;$k<count($val_bie4)-1;++$k)
						{
							// Variables
							$placa = trim($val_bie3[$k]);
							$clase = trim($val_bie2[$k]);
							$consulta4 = "SELECT nombre FROM cx_ctr_rep WHERE codigo='$val_bie10[$k]'";
							$cur4 = odbc_exec($conexion,$consulta4);
							$detalle = trim(utf8_encode(odbc_result($cur4,1)));
							$valor = floatval($val_bie8[$k])+floatval($val_bie15[$k]);
							$numero = "";
							$consecu = $conse;
							$kilometraje = "";
							$kilometraja = "";
							$cantidad = "0";
							// Tipo de combustible
							$pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
							$sql5 = odbc_exec($conexion, $pregunta5);
							$tpcombus = odbc_result($sql5,1);
							// Nombre tipo de combustible
							$pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
							$sql6 = odbc_exec($conexion, $pregunta6);
							$tpcombus1 = trim(odbc_result($sql6,1));
              if (($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                if ($tipo == "3")
                {
                  $pregunta5 = "SELECT valor1, datos, (SELECT periodo FROM cx_rel_gas WHERE consecu='$conse' AND ano='$ano' AND unidad='$unidad1' and numero='$interno') AS periodo FROM cx_rel_dis WHERE gasto='$gasto1' AND consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno' AND cx_rel_gas.unidad!='999')";
                  $sql5 = odbc_exec($conexion, $pregunta5);
                  $tot5 = odbc_num_rows($sql5);
                  if ($tot5 == "0")
                  {
                    $valor1 = "0";
                  }
                  else
                  {
                    $m = 0;
                    while ($m < $row5 = odbc_fetch_array($sql5))
                    {
                      $valor1 = odbc_result($sql5,1);
                      $datos1 = trim(utf8_encode($row5["datos"]));
                      $num_datos = explode("|",$datos1);
                      $con_datos = count($num_datos)-1;
                      $v_paso = $num_datos[$k];
                      $v_placas = explode("»",$v_paso);
                      $v_paso1 = $v_placas[1];
                      $v_paso2 = $v_placas[13];
                      $valor1 = $v_paso2;
                      $valor1 = floatval($valor1);
                      $m++;
                    }
                    $periodor = odbc_result($sql5,3);
                    if ($periodo == $periodor)
                    {
                    }
                    else
                    {
                      $valor1 = "0"; 
                    }
                  }
                }
                else
                {
                  $valor1 = "0";
                  $periodor = $periodo;
                }
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|".$valor1."|".$periodor."|#";
              }
						}
						$valida = "1";
					}
					// RTM
          if (($gasto1 == "39") or ($gasto1 == "45"))
          {
            $otros = "";
            $val_bie = $datos;
            $val_bie = utf8_encode($val_bie);
            $val_bie1 = explode("#", $val_bie);
            $val_bie2 = explode("&", $val_bie1[0]);
            $val_bie3 = explode("&", $val_bie1[1]);
            $val_bie4 = explode("&", $val_bie1[2]);
            $val_bie5 = explode("&", $val_bie1[3]);
            $val_bie6 = explode("&", $val_bie1[4]);
            $val_bie7 = explode("&", $val_bie1[5]);
            $val_bie8 = explode("&", $val_bie1[6]);
            $val_bie9 = explode("&", $val_bie1[7]);
            for ($k=0;$k<count($val_bie4)-1;++$k)
            {
              // Variables
              $placa = trim($val_bie3[$k]);
              $clase = trim($val_bie2[$k]);
              $valor = floatval($val_bie7[$k]);
              $detalle = trim($val_bie9[$k]);
              $numero = "";
              $consecu = $conse;
              $kilometraje = "";
              $kilometraja = "";
              $cantidad = "0";
              // Tipo de combustible
              $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
              $sql5 = odbc_exec($conexion, $pregunta5);
              $tpcombus = odbc_result($sql5,1);
              // Nombre tipo de combustible
              $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
              $sql6 = odbc_exec($conexion, $pregunta6);
              $tpcombus1 = trim(odbc_result($sql6,1));
              if (($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                if ($tipo == "3")
                {
                  $pregunta5 = "SELECT valor1, datos, (SELECT periodo FROM cx_rel_gas WHERE consecu='$conse' AND ano='$ano' AND unidad='$unidad1' and numero='$interno') AS periodo FROM cx_rel_dis WHERE gasto='$gasto1' AND consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno' AND cx_rel_gas.unidad!='999')";
                  $sql5 = odbc_exec($conexion, $pregunta5);
                  $tot5 = odbc_num_rows($sql5);
                  $row5 = odbc_fetch_array($sql5);
                  if ($tot5 == "0")
                  {
                    $valor1 = "0";
                  }
                  else
                  {
                    $valor1 = odbc_result($sql5,1);
                    $datos1 = trim($row5["datos"]);
                    $num_datos = explode("|",$datos1);
                    $con_datos = count($num_datos);
                    if ($con_datos > 2)
                    {
                      for ($z=0;$z<$con_datos;++$z)
                      {
                        $v_paso = utf8_encode($num_datos[$z]);
                        $v_placas = explode("»",$v_paso);
                        $v_paso1 = $v_placas[1];
                        $v_paso2 = $v_placas[6];
                        if ($placa == $v_paso1)
                        {
                          $valor1 = $v_paso2;
                          $valor1 = floatval($valor1);
                        }
                      }
                    }
                    $periodor = odbc_result($sql5,3);
                    if ($periodo == $periodor)
                    {
                    }
                    else
                    {
                      $valor1 = "0"; 
                    }
                  }
                }
                else
                {
                  $valor1 = "0";
                  $periodor = $periodo;
                }
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|".$valor1."|".$periodor."|#";
              }
            }
            $valida = "1";
          }
          // Llantas
          if (($gasto1 == "40") or ($gasto1 == "46"))
          {
            $otros = "";
            $val_bie = $datos;
            $val_bie = utf8_encode($val_bie);
            $val_bie1 = explode("#", $val_bie);
            $val_bie2 = explode("&", $val_bie1[0]);
            $val_bie3 = explode("&", $val_bie1[1]);
            $val_bie4 = explode("&", $val_bie1[2]);
            $val_bie5 = explode("&", $val_bie1[3]);
            $val_bie6 = explode("&", $val_bie1[4]);
            $val_bie7 = explode("&", $val_bie1[5]);
            $val_bie8 = explode("&", $val_bie1[6]);
            $val_bie9 = explode("&", $val_bie1[7]);
            $val_bie10 = explode("&", $val_bie1[8]);
            $val_bie11 = explode("&", $val_bie1[9]);
            $val_bie12 = explode("&", $val_bie1[10]);
            $val_bie13 = explode("&", $val_bie1[11]);
            $val_bie14 = explode("&", $val_bie1[12]);
            $val_bie15 = explode("&", $val_bie1[13]);
            $val_bie16 = explode("&", $val_bie1[14]);
            for ($k=0;$k<count($val_bie4)-1;++$k)
            {
              // Variables
              $placa = trim($val_bie3[$k]);
              $clase = trim($val_bie2[$k]);
              $valor = floatval($val_bie8[$k]);
              $detalle = trim($val_bie10[$k]);
              $numero = "";
              $consecu = $conse;
              $kilometraje = "";
              $kilometraja = "";
              $cantidad = "0";
              // Tipo de combustible
              $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
              $sql5 = odbc_exec($conexion, $pregunta5);
              $tpcombus = odbc_result($sql5,1);
              // Nombre tipo de combustible
              $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
              $sql6 = odbc_exec($conexion, $pregunta6);
              $tpcombus1 = trim(odbc_result($sql6,1));
              if (($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                if ($tipo == "3")
                {
                  $pregunta5 = "SELECT valor1, datos, (SELECT periodo FROM cx_rel_gas WHERE consecu='$conse' AND ano='$ano' AND unidad='$unidad1' and numero='$interno') AS periodo FROM cx_rel_dis WHERE gasto='$gasto1' AND consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno' AND cx_rel_gas.unidad!='999')";
                  $sql5 = odbc_exec($conexion, $pregunta5);
                  $tot5 = odbc_num_rows($sql5);
                  $row5 = odbc_fetch_array($sql5);
                  if ($tot5 == "0")
                  {
                    $valor1 = "0";
                  }
                  else
                  {
                    $valor1 = odbc_result($sql5,1);
                    $datos1 = trim($row5["datos"]);
                    $num_datos = explode("|",$datos1);
                    $con_datos = count($num_datos);
                    if ($con_datos > 2)
                    {
                      for ($z=0;$z<$con_datos;++$z)
                      {
                        $v_paso = utf8_encode($num_datos[$z]);
                        $v_placas = explode("»",$v_paso);
                        $v_paso1 = $v_placas[1];
                        $v_paso2 = $v_placas[3];
                        if ($placa == $v_paso1)
                        {
                          $valor1 = $v_paso2;
                          $valor1 = floatval($valor1);
                        }
                      }
                    }
                    $periodor = odbc_result($sql5,3);
                    if ($periodo == $periodor)
                    {
                    }
                    else
                    {
                      $valor1 = "0"; 
                    }
                  }
                }
                else
                {
                  $valor1 = "0";
                  $periodor = $periodo;
                }
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|".$valor1."|".$periodor."|#";
              }
            }
            $valida = "1";
          }
          // Bienes
          if ($gasto1 == "18")
          {
            $otros = "";
            $valor = str_replace(',','',$valor);
            $valor = floatval($valor);
            $val_bie = $datos;
            $val_bie1 = explode("#", $val_bie);
            $val_bie2 = $val_bie1[2];
            $val_bie3 = strtoupper($val_bie1[3]);
            $val_bie4 = explode("&", $val_bie3);
            $val_bie5 = explode("&", $val_bie2);
            $val_bie6 = strtoupper($val_bie1[4]);
            $val_bie7 = explode("&", $val_bie6);
            for ($k=0;$k<count($val_bie4)-1;++$k)
            {
              $detalle = $val_bie4[$k];
              if (($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                $valor = $val_bie5[$k];
                if ($tipo == "3")
                {
                  $pregunta5 = "SELECT valor1, datos, (SELECT periodo FROM cx_rel_gas WHERE consecu='$conse' AND ano='$ano' AND unidad='$unidad1' and numero='$interno') AS periodo FROM cx_rel_dis WHERE gasto='$gasto1' AND consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno' AND cx_rel_gas.unidad!='999')";
                  $sql5 = odbc_exec($conexion, $pregunta5);
                  $tot5 = odbc_num_rows($sql5);
                  $row5 = odbc_fetch_array($sql5);
                  if ($tot5 == "0")
                  {
                    $valor1 = "0";
                  }
                  else
                  {
                    $valor1 = odbc_result($sql5,1);
                    $datos1 = trim($row5["datos"]);
                    $periodor = odbc_result($sql5,3);
                    if ($periodo == $periodor)
                    {
                      $valor1 = $val_bie5[$k];
                    }
                    else
                    {
                      $valor1 = "0"; 
                    }
                  }
                }
                else
                {
                  $valor1 = "0";
                  $periodor = $periodo;
                }
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|".$valor1."|".$periodor."|#";
              }
            }
            $valida = "1";
          }
          if ($valida == "0")
          {
            $otros = "";
            $valor = str_replace(',','',$valor);
            $valor = floatval($valor);
            $detalle = "";
            $numero = "";
            $consecu = $conse;
            $kilometraje = "";
            $kilometraja = "";
            $cantidad = "0";
            if (($valor == "0,0") or ($valor == "0"))
            {
            }
            else
            {
              if ($tipo == "3")
              {
                $pregunta5 = "SELECT valor1, datos, (SELECT periodo FROM cx_rel_gas WHERE consecu='$conse' AND ano='$ano' AND unidad='$unidad1' and numero='$interno') AS periodo, tipo FROM cx_rel_dis WHERE gasto='$gasto1' AND consecu='$conse' AND ano='$ano' AND EXISTS (SELECT * FROM cx_rel_gas WHERE cx_rel_gas.conse=cx_rel_dis.conse1 AND cx_rel_gas.consecu=cx_rel_dis.consecu AND cx_rel_gas.numero='$interno' AND cx_rel_gas.unidad!='999')";
                $sql5 = odbc_exec($conexion, $pregunta5);
                $tot5 = odbc_num_rows($sql5);
                if ($tot5 == "0")
                {
                  $valor1 = "0";
                }
                else
                {
                  $valor2 = 0;
                  $m = 0;
                  while ($m < $row5 = odbc_fetch_array($sql5))
                  {
                    $valor1 = odbc_result($sql5,1);
                    $tipo1 = odbc_result($sql5,4);
                    if ($tipo1 == "S")
                    {
                      $datos1 = trim($row5["datos"]);
                      $num_datos = explode("|",$datos1);
                      $con_datos = count($num_datos);
                      if ($con_datos > 2)
                      {
                        for ($z=0;$z<$con_datos;++$z)
                        {
                          $v_paso = utf8_encode($num_datos[$z]);
                          $v_placas = explode("»",$v_paso);
                          $v_paso1 = $v_placas[1];
                          $v_paso2 = $v_placas[3];
                          if ($placa == $v_paso1)
                          {
                            $valor1 = $v_paso2;
                            $valor1 = floatval($valor1);
                          }
                        }
                      }
                      $valor2 = $valor2+$valor1;
                    }
                    else
                    {
                      $valor2 = $valor2+$valor1;
                    }
                    $valor1 = $valor2;
                    $m++;
                  }
                }
              }
              else
              {
                $valor1 = "0";
                $periodor = $periodo;
              }
              $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|".$valor1."|".$periodor."|#";
            }
          }
          $valida = "0";
          $l++;
        }
        $i++;
      }
      $salida->valores = $valores;
    }
  }
  // Gastos Ejecutados
  if ($tipo == "2")
  {
    $pregunta = "SELECT conse, unidad, consecu, ano, usuario, fecha, periodo, ordop, mision, numero, (SELECT sigla FROM cx_org_sub WHERE cx_org_sub.subdependencia=cx_rel_gas.unidad) AS n_unidad FROM cx_rel_gas WHERE CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND unidad!='999' AND EXISTS (SELECT * FROM cx_rel_dis WHERE cx_rel_dis.conse1=cx_rel_gas.conse AND cx_rel_dis.ano=cx_rel_gas.ano AND cx_rel_dis.consecu=cx_rel_gas.consecu";
    if ($conceptos == "999")
    {
      $pregunta .= ")";
    }
    else
    {
      $pregunta .= " AND cx_rel_dis.gasto IN ($conceptos))";
    }
    if ($unidad == "-")
    {
    }
    else
    {
      if (($sup_usuario == "1") or ($sup_usuario == "2"))
      {
        $query = "SELECT unidad, dependencia, tipo, unic FROM cx_org_sub WHERE subdependencia='$unidad'";
        $cur = odbc_exec($conexion, $query);
        $n_unidad = odbc_result($cur,1);
        $n_dependencia = odbc_result($cur,2);
        $n_tipo = odbc_result($cur,3);
        $n_unic = odbc_result($cur,4);
        if ($n_unic == "0")
        {
          $numero = $unidad;
        }
        else
        {
          if (($n_unidad == "1") or ($n_unidad == "2") or ($n_unidad == "3"))
          {
            if (($n_unidad == "2") or ($n_unidad == "3"))
            {
              $pregunta0 = "SELECT dependencia FROM cx_org_sub WHERE unidad='$n_unidad'";
              $sql0 = odbc_exec($conexion, $pregunta0);
              $dependencia = odbc_result($sql0,1);
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
            }
            else
            {
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE dependencia='$n_dependencia' AND tipo='2' AND unic='0' ORDER BY subdependencia";
            }
          }
          else
          {
            if ($n_tipo == "7")
            {
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' AND dependencia='$n_dependencia' ORDER BY subdependencia";
            }
            else
            {
              $query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY subdependencia";
            }
          }
          $cur1 = odbc_exec($conexion, $query1);
          $numero = "";
          while($i<$row=odbc_fetch_array($cur1))
          {
            $numero .= "'".odbc_result($cur1,1)."',";
          }
          $numero = substr($numero,0,-1);
          // Se verifica si es unidad centralizadora especial
          if (strpos($especial, $unidad) !== false)
          {
            $numero .= ",";
            $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$n_unidad' ORDER BY unidad";
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
        }
        $pregunta .= " AND unidad in ($numero)";
      }
      else
      {
        $pregunta .= " AND unidad='$unidad'";
      }
    }
    $pregunta .= " ORDER BY fecha DESC";
    $sql = odbc_exec($conexion, $pregunta);
    $total = odbc_num_rows($sql);
    $valores = "";
    $salida = new stdClass();
    if ($total>0)
    {
			$i = 0;
			while ($i < $row = odbc_fetch_array($sql))
			{
				$conse = odbc_result($sql,1);
				$unidad1 = odbc_result($sql,2);
				$consecu = odbc_result($sql,3);
				$ano = odbc_result($sql,4);
				$usuario = odbc_result($sql,5);
				$fecha = odbc_result($sql,6);
				$fecha = substr($fecha,0,10);
				$periodo = odbc_result($sql,7);
				$ordop = trim(utf8_encode(odbc_result($sql,8)));
        $ordop = str_replace("#", "", $ordop);
        $ordop = str_replace("|", "", $ordop);
        $mision = trim(utf8_encode(odbc_result($sql,9)));
        $numero = odbc_result($sql,10);
        $n_unidad = trim(odbc_result($sql,11));
        $mes = str_pad($periodo,2,"0",STR_PAD_LEFT);
        $pregunta1 = "SELECT valor, datos, gasto, tipo, (SELECT tipo FROM cx_pla_inv WHERE conse=cx_rel_dis.consecu AND ano=cx_rel_dis.ano) AS tipo1 FROM cx_rel_dis WHERE conse1='$conse' AND consecu='$consecu' AND ano='$ano'";
        if ($conceptos == "999")
        {
        }
        else
        {
          $pregunta1 .= " AND gasto IN ($conceptos)";
        }
        $sql1 = odbc_exec($conexion, $pregunta1);
        $l = 0;
        while ($l < $row = odbc_fetch_array($sql1))
        {
          $valor = trim(odbc_result($sql1,1));
          $datos = trim(utf8_encode($row['datos']));
          $gasto1 = odbc_result($sql1,3);
          $soporte = trim(odbc_result($sql1,4));
          $tipo2 = odbc_result($sql1,5);
          if ($tipo2 == "1")
          {
            $tipo3 = "Plan de Inversión";
          }
          else
          {
            $tipo3 = "Solicitud de Recursos";
          }
          $num_datos = explode("|",$datos);
          $placa = "";
          $clase = "";
          $tpcombus1 = "";
          // Combustible
          if (($gasto1 == "36") or ($gasto1 == "42"))
          {
            $otros = "";
            for ($j=0;$j<count($num_datos)-1;++$j)
            {
              $paso = $num_datos[$j];
              $paso1 = explode("»",$paso);
              for ($k=0;$k<count($paso1)-1;++$k)
              {
                $clase = $paso1[0];
                $placa = $paso1[1];
                $valor = $paso1[2];
                if (($valor == "") or ($valor == "0"))
                {
                  $valor = "0,0";
                }
                $valor = str_replace(',','',$valor);
                $valor = floatval($valor);
                $detalle = $paso1[4];
                $unidad = $paso1[6];
                if ($soporte == "N")
                {
                  $pregunta0 = "SELECT SUM(total) AS total FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha1',102) AND (CONVERT(datetime,'$fecha2',102)+1) AND solicitud='$consecu' AND soporte='0'";
                  if ($gasto1 == "36")
                  {
                    $pregunta0 .= " AND tipo='1'";
                  }
                  else
                  {
                    $pregunta0 .= " AND tipo='2'";
                  }
                  $sql0 = odbc_exec($conexion, $pregunta0);
                  $valor = odbc_result($sql0,1);
                }
              }
              $otros = "";
              // Kilometraje
              $pregunta2 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND solicitud='$consecu'";
              $sql2 = odbc_exec($conexion, $pregunta2);
              $kilometraje = odbc_result($sql2,1);
              if ($kilometraje == "0.00")
              {
                if ($gasto == "36")
                {
                  $tipo1 = "1";
                }
                else
                {
                  $tipo1 = "2";   
                }
                switch ($periodo)
                {
                  case '1':
                  case '3':
                  case '5':
                  case '7':
                  case '8':
                  case '10':
                  case '12':
                    $dia = "31";
                    break;
                  case '2':
                    if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                    {
                      $dia = "29";
                    }
                    else
                    {
                      $dia = "28";
                    }
                    break;
                  case '4':
                  case '6':
                  case '9':
                  case '11':
                    $dia = "30";
                    break;
                  default:
                    $dia = "31";
                    break;
                }
                $fecha3 = $ano."/".$mes."/01";
                $fecha4 = $ano."/".$mes."/".$dia;
                $pregunta2 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha3',102) AND CONVERT(datetime,'$fecha4',102) AND tipo='$tipo1'";
                $sql2 = odbc_exec($conexion, $pregunta2);
                $kilometraje = odbc_result($sql2,1);
                if ($kilometraje == "0.00")
                {
                  $periodo1 = $periodo+1;
                  $mes1 = str_pad($periodo1,2,"0",STR_PAD_LEFT);
                  switch ($periodo1)
                  {
                    case '1':
                    case '3':
                    case '5':
                    case '7':
                    case '8':
                    case '10':
                    case '12':
                      $dia1 = "31";
                      break;
                    case '2':
                      if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                      {
                        $dia1 = "29";
                      }
                      else
                      {
                        $dia1 = "28";
                      }
                      break;
                    case '4':
                    case '6':
                    case '9':
                    case '11':
                      $dia1 = "30";
                      break;
                    default:
                      $dia1 = "31";
                      break;
                  }
                  $fecha5 = $ano."/".$mes1."/01";
                  $fecha6 = $ano."/".$mes1."/".$dia1;
                }
              }
              // Kilometraje recorrido mes y mes anterior
              if ($periodo == "1")
              {
                $kilometraja = 0;
              }
              else
              {
                $periodoa = $periodo-1;
                $mesa = str_pad($periodoa,2,"0",STR_PAD_LEFT);
                switch ($periodoa)
                {
                  case '1':
                  case '3':
                  case '5':
                  case '7':
                  case '8':
                  case '10':
                  case '12':
                    $diaa = "31";
                    break;
                  case '2':
                    if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                    {
                      $diaa = "29";
                    }
                    else
                    {
                      $diaa = "28";
                    }
                    break;
                  case '4':
                  case '6':
                  case '9':
                  case '11':
                    $diaa = "30";
                    break;
                  default:
                    $diaa = "31";
                    break;
                }
                $fecha7 = $ano."/".$mesa."/01";
                $fecha8 = $ano."/".$mesa."/".$diaa;
                $pregunta3 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha7',102) AND CONVERT(datetime,'$fecha8',102)";
                $sql3 = odbc_exec($conexion, $pregunta3);
                $kilometraja = odbc_result($sql3,1);
                if ($kilometraja == "0.00")
                {
                  $periodob = $periodo-2;
                  $mesb = str_pad($periodob,2,"0",STR_PAD_LEFT);
                  switch ($periodob)
                  {
                    case '1':
                    case '3':
                    case '5':
                    case '7':
                    case '8':
                    case '10':
                    case '12':
                      $diab = "31";
                      break;
                    case '2':
                      if (($ano == "2020") or ($ano == "2024") or ($ano == "2028"))
                      {
                        $diab = "29";
                      }
                      else
                      {
                        $diab = "28";
                      }
                      break;
                    case '4':
                    case '6':
                    case '9':
                    case '11':
                      $diab = "30";
                      break;
                    default:
                      $diab = "31";
                      break;
                  }
                  $fecha7 = $ano."/".$mesb."/01";
                  $fecha8 = $ano."/".$mesb."/".$diab;
                  $pregunta3 = "SELECT ISNULL(MAX(kilometraje),0) AS kilometraje FROM cx_tra_mov WHERE placa='$placa' AND CONVERT(datetime,fecha,102) BETWEEN CONVERT(datetime,'$fecha7',102) AND CONVERT(datetime,'$fecha8',102)";
                  $sql3 = odbc_exec($conexion, $pregunta3);
                  $kilometraja = odbc_result($sql3,1);
                  $kilometraja = $kilometraje-$kilometraja;
                }
                else
                {
                  $kilometraja = $kilometraje-$kilometraja;
                }
              }
              // Nombre del gasto
              $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
              $sql4 = odbc_exec($conexion, $pregunta4);
              $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
              // Tipo de combustible
              $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
              $sql5 = odbc_exec($conexion, $pregunta5);
              $tpcombus = odbc_result($sql5,1);
              // Nombre tipo de combustible
              $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
              $sql6 = odbc_exec($conexion, $pregunta6);
              $tpcombus1 = trim(odbc_result($sql6,1));
              if ((trim($placa) == "") or ($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|0|".$tipo3."|#";
              }
            }
            $valida = "1";
          }
          // Mantenimiento
          if (($gasto1 == "38") or ($gasto1 == "44"))
          {
            $kilometraja = 0;
            $otros = "";
            $pregunta2 = "SELECT bienes FROM cx_pla_gad WHERE conse1='$consecu' AND ano='$ano' AND gasto='$gasto'";
            $sql2 = odbc_exec($conexion, $pregunta2);
            $t_sql2 = odbc_num_rows($sql2);
            if ($t_sql2 > 0)
            {
              $j = 0;
              while($j<$row=odbc_fetch_array($sql2))
              {
                $val_bie = trim($row['bienes']);
                $val_bie = utf8_encode($val_bie);
                $j++;
              }
              $arreglo = [];
              $val_bie1 = explode("#", $val_bie);
              $val_bie2 = explode("&", $val_bie1[0]);
              $val_bie3 = explode("&", $val_bie1[1]);
              $val_bie4 = explode("&", $val_bie1[2]);
              $val_bie5 = explode("&", $val_bie1[3]);
              $val_bie6 = explode("&", $val_bie1[4]);
              $val_bie7 = explode("&", $val_bie1[5]);
              $val_bie8 = explode("&", $val_bie1[6]);
              $val_bie9 = explode("&", $val_bie1[7]);
              $val_bie10 = explode("&", $val_bie1[8]);
              $val_bie11 = explode("&", $val_bie1[9]);
              $val_bie12 = explode("&", $val_bie1[10]);
              $val_bie13 = explode("&", $val_bie1[11]);
              $val_bie14 = explode("&", $val_bie1[12]);
              $val_bie15 = explode("&", $val_bie1[13]);
              $val_bie16 = explode("&", $val_bie1[14]);
              $val_bie17 = explode("&", $val_bie1[15]);
              $det_bienes = "";
              for ($k=0;$k<count($val_bie4)-1;++$k)
              {
                $det_bienes = $val_bie17[$k];
                array_push($arreglo, $det_bienes);
              }
            }
            for ($j=0;$j<count($num_datos)-1;++$j)
            {
              $paso = $num_datos[$j];
              $paso1 = explode("»",$paso);
              for ($k=0;$k<count($paso1)-1;++$k)
              {
                $clase = $paso1[0];
                $placa = $paso1[1];
                $cantidad = $paso1[2];
                $valor = $paso1[12];
                if (($valor == "") or ($valor == "0"))
                {
                  $valor = "0,0";
                }
                $valor = str_replace(',','',$valor);
                $valor = floatval($valor);
                $detalle = $paso1[14];
                $alea = $paso1[18];
                $unidad = $paso1[19];
                $kilometraje = $arreglo[$j];
              }
              // Nombre del gasto
              $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
              $sql4 = odbc_exec($conexion, $pregunta4);
              $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
              // Tipo de combustible
              $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
              $sql5 = odbc_exec($conexion, $pregunta5);
              $tpcombus = odbc_result($sql5,1);
              // Nombre tipo de combustible
              $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
              $sql6 = odbc_exec($conexion, $pregunta6);
              $tpcombus1 = trim(odbc_result($sql6,1));
              if ((trim($placa) == "") or ($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|#";
              }
            }
            $valida = "1";
          }
          // RTM
          if (($gasto1 == "39") or ($gasto1 == "45"))
          {
            $kilometraje = "";
            $kilometraja = 0;
            $otros = "";
            for ($j=0;$j<count($num_datos)-1;++$j)
            {
              $paso = $num_datos[$j];
              $paso1 = explode("»",$paso);
              for ($k=0;$k<count($paso1)-1;++$k)
              {
                $clase = $paso1[0];
                $placa = $paso1[1];
                $cantidad = "1";
                $valor = $paso1[5];
                if (($valor == "") or ($valor == "0"))
                {
                  $valor = "0,0";
                }
                $valor = str_replace(',','',$valor);
                $valor = floatval($valor);
                $detalle = $paso1[7];
                $alea = $paso1[10];
                $unidad = $paso1[11];
              }
              // Nombre del gasto
              $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
              $sql4 = odbc_exec($conexion, $pregunta4);
              $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
              // Tipo de combustible
              $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
              $sql5 = odbc_exec($conexion, $pregunta5);
              $tpcombus = odbc_result($sql5,1);
              // Nombre tipo de combustible
              $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
              $sql6 = odbc_exec($conexion, $pregunta6);
              $tpcombus1 = trim(odbc_result($sql6,1));
              if ((trim($placa) == "") or ($valor == "0,0"))
              {
              }
              else
              {
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|#";
              }
            }
            $valida = "1";
          }
          // Llantas
          if (($gasto1 == "40") or ($gasto1 == "46"))
          {
            $kilometraje = "";
            $kilometraja = 0;
            $otros = "";
            $repu = count($num_datos)-1;
            for ($j=0;$j<count($num_datos)-1;++$j)
            {
              $paso = $num_datos[$j];
              $paso1 = explode("»",$paso);
              for ($k=0;$k<count($paso1)-1;++$k)
              {
                $clase = $paso1[0];
                $placa = $paso1[1];
                $cantidad = $paso1[2];
                $valor = $paso1[6];
                if (($valor == "") or ($valor == "0"))
                {
                  $valor = "0,0";
                }
                $valor = str_replace(',','',$valor);
                $valor = floatval($valor);
                $detalle = $paso1[8]." - ".$paso1[9]." - ".$paso1[10];
                $alea = $paso1[13];
                $unidad = $paso1[14];
              }
              // Nombre del gasto
              $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
              $sql4 = odbc_exec($conexion, $pregunta4);
              $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
              // Tipo de combustible
              $pregunta5 = "SELECT tipo FROM cx_pla_tra WHERE placa='$placa'";
              $sql5 = odbc_exec($conexion, $pregunta5);
              $tpcombus = odbc_result($sql5,1);
              // Nombre tipo de combustible
              $pregunta6 = "SELECT nombre FROM cx_ctr_com WHERE codigo='$tpcombus'";
              $sql6 = odbc_exec($conexion, $pregunta6);
              $tpcombus1 = trim(odbc_result($sql6,1));
              if ((trim($placa) == "") or ($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|#";
              }
            }
            $valida = "1";
          }
          $actual = date('Y-m-d');
          // Bienes
          if ($gasto1 == "18")
          {
            $otros = "";
            $valor = str_replace(',','',$valor);
            $valor = floatval($valor);
            // Cambio de sigla
            $pregunta5 = "SELECT sigla1, fecha FROM cx_org_sub WHERE sigla='$n_unidad'";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $sig_usuario = trim(odbc_result($sql5,1));
            $fec_usuario = trim(odbc_result($sql5,2));
            if ($fec_usuario == "")
            {
            }
            else
            {
              $fec_usuario = str_replace("/", "-", $fec_usuario);
              if ($actual >= $fec_usuario)
              {
                $n_unidad = $sig_usuario;
              }
            }
            $pregunta4 = "SELECT codigo, descripcion, valor1 FROM cx_pla_bie WHERE numero='$consecu' AND relacion='$conse'";
            $sql4 = odbc_exec($conexion, $pregunta4);
            $y = 0;
            while ($y < $row = odbc_fetch_array($sql4))
            {
              $inventario = trim(odbc_result($sql4,1));
              $descripcion = trim(utf8_encode($row['descripcion']));
              $valor = odbc_result($sql4,3);
              $valor = floatval($valor);
              $detalle = $inventario." ".$descripcion;
              if (($valor == "0,0") or ($valor == "0") or (trim($valor) == ""))
              {
              }
              else
              {
                $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop1."|".$mision1."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|#";
              }
              $y++;
            }
            $valida = "1";
          }
         	if ($valida == "0")
          {
            $otros = "";
            $valor = str_replace(',','',$valor);
            $valor = floatval($valor);
            // Nombre del gasto
            $pregunta4 = "SELECT nombre FROM cx_ctr_pag WHERE codigo='$gasto1'";
            $sql4 = odbc_exec($conexion, $pregunta4);
            $gasto2 = trim(utf8_encode(odbc_result($sql4,1)));
            // Cambio de sigla
            $pregunta5 = "SELECT sigla1, fecha FROM cx_org_sub WHERE sigla='$n_unidad'";
            $sql5 = odbc_exec($conexion, $pregunta5);
            $sig_usuario = trim(odbc_result($sql5,1));
            $fec_usuario = trim(odbc_result($sql5,2));
            if ($fec_usuario == "")
            {
            }
            else
            {
              $fec_usuario = str_replace("/", "-", $fec_usuario);
              if ($actual >= $fec_usuario)
              {
                $n_unidad = $sig_usuario;
              }
            }
            if (($valor == "0,0") or ($valor == "0"))
            {
            }
            else
            {
              $valores .= $conse."|".$placa."|".$clase."|".$valor."|".$detalle."|".$n_unidad."|".$usuario."|".$fecha."|".$periodo."|".$kilometraje."|".$ordop."|".$mision."|".$numero."|".$consecu."|".$otros."|".$gasto1."|".$unidad1."|".$kilometraja."|".$gasto2."|".$tpcombus1."|".$cantidad."|".$tipo3."|#";
            }
          }
          $valida = "0";
          $l++;
        }
       	$i++;
      }
     	$salida->valores = $valores;
    }
    else
    {
      $salida->valores = "";
    }
  }
  echo json_encode($salida);
}
// 11/03/2024 - Ajuste consulta varios conceptos de gastos
// 10/04/2024 - Ajuste nombre desde tabla de combustible
// 22/07/2024 - Ajuste inclusion de unidades que dependen de centralizadora
// 24/07/2024 - Ajuste inclusion tipo de plan / solicitud
// 25/07/2024 - Ajuste cuando se envia a buscar por todos los conceptos
// 29/07/2024 - Ajuste valores en 0 para no enviar a excel y descricion de bienes
// 30/07/2024 - Ajuste ordop tildes y caracteres especiales a excel
// 13/09/2024 - Ajuste validacion periodo de reporte versus
// 17/12/2024 - Ajsute sigla otros gastos
// 25/03/2025 - Ajuste valor bienes en varios items
?>