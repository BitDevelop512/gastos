<?php
	session_start();
?>
<?php
    $xw_url = "http://192.168.1.107:4545/Cx_wss_load.asmx?WSDL";
    echo $xw_url."<hr>";
    $WebService=new SoapClient($xw_url, array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE));
    $PC="192.168.1.181";                  
    $v1="-100";
    $v2="90";
    $v3="";
    $v4="";
    $v5="";
?>
<!doctype html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>Login</title>
			<link rel="stylesheet" type="text/css" href="css/main.css">
        	<link rel="stylesheet" type="text/css" href="css/chat.css">
	        <link href="jquery/jquery-ui.css" rel="stylesheet">
    	    <script src="jquery/jquery.js"></script>
        	<script src="jquery/jquery-ui.js"></script>
    	</head>
	<body>
    	<div class="contenedorPrincipal">
        	<header>
          </header>
                <?php
                    if(empty($_POST['usuario'])){
                        echo"<div class='error centrarTexto centrarDiv'>Su usuario esta vacio</div>";
                    }elseif(empty($_POST['password'])){
                        echo"<div class='error centrarTexto centrarDiv'>Su contraseña esta vacia</div>";
                    }else{
                        $usuario = $_POST['usuario'];
                        $password= $_POST['password'];
                        
                        $v3=$usuario."|".$password."|".$PC."|";
                        $cx=$WebService -> Cx_mbl_espe(array('CxIdeconx' => $v1, 'CxIdeacci' => $v2, 'CxSqlOrde' => $v3, 'CxResDato' => $v4, 'CxResEstr' => $v5));
                        $cx1=print_r($cx,true);
                        echo $cx1."<hr>";

                        $cx3=str_replace("stdClass Object","",$cx1);
                        $cx4=str_replace("[Cx_mbl_espeResult]","",$cx3);
                        $cx5=str_replace("[CxResDato]","",$cx4);
                        $cx6=str_replace("[CxResEstr]","",$cx5);
                        $cx7=explode("=>",$cx6);

                        echo $cx4."<hr><br>"; 
                    }
                ?>
    		  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
				      <label>Usuario:</label><input type="text" name="usuario"  id="usuario" placeholder="Ingrese su usuario"><br>
            	<label>Password:</label><input type="password" name="password"  id="password" placeholder="Ingrese su password">
            	<input type="submit" name="login"  id="login" value="Login">
        	</form>
    	</div>
	</body>