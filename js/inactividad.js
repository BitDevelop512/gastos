var idleTime = 0;
var idleMinutes = 0;
$(document).ready(function() {
    consulta();
    var idleInterval = setInterval(inactividad, 60000);
    $(this).mousemove(function (e)
    {
        idleTime = 0;
    });
    $(this).keypress(function (e)
    {
        idleTime = 0;
    });
});
function consulta()
{
    $.ajax({
      type: "POST",
      datatype: "json",
      url: "./trae_inactividad.php",
      success: function (data)
      {
        var registros = JSON.parse(data);
        var inactividad = registros.salida;
        idleMinutes = inactividad;
      }
    });
}
function inactividad()
{
    idleTime = idleTime + 1;
    var detalle = "Inactividad Registrada "+idleTime+"/"+idleMinutes+" minutos(s)";
    alertify.error(detalle);
    if (idleTime >= idleMinutes)
    {
        var detalle = "Cerrado por Inactividad";
        alertify.error(detalle);
        setInterval(cierre, 2000);
    }
}
function cierre()
{
    location.href = "logout.php";
}