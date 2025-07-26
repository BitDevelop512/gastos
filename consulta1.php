<?php
session_start();
?>
<html>
<head>
<title>:: Cx Computers ::</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<meta name="generator" content="Bootply" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="shortcut icon" href="images/Cx.ico">
<link rel="icon" href="images/Cx.ico" type="image/ico">
<link href="css2/ui.jqgrid.css" rel="stylesheet" type="text/css"/>
<link href="css2/magnific-popup.css" rel="stylesheet" type="text/css"/>
<link href="css2/bootstrap.css" rel="stylesheet">
<link href="css2/jquery-ui.css" rel="stylesheet">
<link href="css2/EstilosPropios.css" rel="stylesheet">
<script src="js3/jquery-1.11.2.js?1.0.0" ></script>
<script src="js3/jquery-ui-1.9.2.custom.min.js?1.0.0" ></script> 
<script src="js3/respond.js?1.0.0" ></script>
</head>
<body>
<table width="750" border="0" align="center">
<tr>
  <td width="100%">
    <?php
    echo "<center><font face='Verdana' size='2' color='#000000'>Consulta";
    echo "</font>";
    echo "<font face='Verdana' size='2' color='#000000'><div id='dato2'></div></center>";
    ?>
  </td>
</tr>
</table>
<br>
<div align="center">
  <table id="lista"></table> 
  <div id="paginador"></div>
</div>
<script src="js3/jquery-migrate-1.2.1.js?1.0.0" type="text/javascript"></script>
<script src="consulta1.js?1.0.0" type="text/javascript"></script>
<script src="js3/grid.locale-es.js?1.0.0" type="text/javascript"></script>
<script src="js3/jquery.jqGrid.min.js?1.0.0" type="text/javascript"></script>
<script src="js3/jquery.magnific-popup.min.js?1.0.0" type="text/javascript"></script>
</body>
</html>