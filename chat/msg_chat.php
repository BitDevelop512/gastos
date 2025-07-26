<?php
	include "../conf.php";
	///consultamos a la base
	$consulta_msg = "select * from cx_chat_msg order by conse DESC";
	$cur_msg = odbc_exec($conexion,$consulta_msg);

	$f = 1;
	while($f<$nreg=odbc_fetch_array($cur_msg))
	{ 
?>
	<div id="datos-chat">
        <div style="color: #1C62C4;"><?php echo odbc_result($cur_msg,2); ?></div> 
		<div style="color: #848484;"><?php echo odbc_result($cur_msg,3); ?></div>
		<div style="float: right;"><?php echo odbc_result($cur_msg,4); ?></div>
	</div>
	<?php } ?>  