<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cx Chat</title>
<style type="text/css">
.chat-box
{
    position: fixed;
    right: 15px;
    bottom: 0;
    box-shadow: 0 0 0.1em #000;
}

.chat-closed
{
    cursor: pointer;
    width: 600px;
    height: 35px;
    background: #59ABE3;
    line-height: 35px;
    font-size: 18px;
    text-align: center;
    border: 1px solid #777;
    color: #000;
}

.chat-header
{
    cursor: pointer;
    width: 600px;
    height: 35px;
    background: #8bc34a;
    line-height: 33px;
    text-indent: 20px;
    border: 1px solid #777;
    border-bottom: none;
}

.chat-content
{
    width: 600px;
    height: 500px;
    background: #ffffff;
    border: 1px solid #777;
    overflow-y: auto;
    word-wrap: break-word;
}

.box
{
    width: 10px;
    height: 10px;
    background: green;
    float: left;
    position: relative;
    top: 11px;
    left: 10px;
    border: 1px solid #ededed;
}

.hide
{
    display:none;
}



.wsa_dock
{
    cursor: pointer;
    position: fixed;
    z-index: 99999;
}

.imagen1
{
    margin-top: 10px;
}



*{padding:0;margin:0;}

body{
    font-family:Verdana, Geneva, sans-serif;
    background-color:#CCC;
    font-size:12px;
}

.label-container{
    position:fixed;
    bottom:48px;
    right:105px;
    display:table;
    visibility: hidden;
}

.label-text
{
    color: #FFF;
    background: rgba(51,51,51,0.5);
    display: table-cell;
    vertical-align: middle;
    padding: 10px;
    border-radius: 3px;
}

.label-arrow
{
    display: table-cell;
    vertical-align: middle;
    color: #333;
    opacity: 0.5;
}

.float
{
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #0C9;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    box-shadow: 2px 2px 3px #999;
}

.my-float
{
    font-size: 24px;
    margin-top: 18px;
}

a.float + div.label-container
{
  visibility: hidden;
  opacity: 0;
  transition: visibility 0s, opacity 0.5s ease;
}

a.float:hover + div.label-container
{
  visibility: visible;
  opacity: 1;
}


</style>
</head>
<body>

<a href="#" class="float" name="boton1" id="boton1">
    <i>
        <img src="imagenes/soporte1.png" width="40" class="imagen1">
    </i>
</a>
<div class="label-container">
    <div class="label-text">Soporte Chatbot</div>
    <i></i>
</div>


<!--
<a href="#" class="float" name="boton1" id="boton1">
    <div class="label-text">Feedback</div>
    <i><img src="imagenes/soporte1.png" width="40" class="imagen1"></i>
</a>
-->

<div class="chat-box">
    <div class="chat-closed"> Chat Now </div>
    <div class="chat-header hide">
        <div class="box"></div><font face="Verdana" size="2">Cx Computers - Soporte Online</font>
    </div>
    <div class="chat-content hide">
        <div name="chat1" id="chat1"></div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".chat-closed").hide();

    $(".chat-closed").on("click",function(e){
        $(".chat-header,.chat-content").removeClass("hide");
        $(this).addClass("hide");
    });

    $(".chat-header").on("click",function(e){
        $(".chat-header,.chat-content").addClass("hide");
        //$(".chat-closed").removeClass("hide");
        $("#boton1").show();
    });


    $("#boton1").on("click",function(e)
    {
        $(".chat-header,.chat-content").removeClass("hide");
        $(this).hide();

        var salida = "<embed src='http://192.168.1.107:8086/Demo/vistas/chat/' width='100%' height='465'/>";
        $("#chat1").html('');
        $("#chat1").append(salida);
    });

});
</script>
</body>

</html>