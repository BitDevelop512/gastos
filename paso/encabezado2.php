<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
<link rel="stylesheet" href="plugins/iCheck/all.css">
<style>
input[type="checkbox"]
{
  width: 20px;
  height: 20px;
}
.fecha
{
  text-align: center;
}
.numero
{
  text-align: right;
}
.ui-dialog > .ui-widget-header
{
    color: #fff;
}
.highlight
{
	background-Color:yellow;
}
.highlight1
{
	background-Color:transparent;
}

#a-table tr:nth-child(even)
{
	background: #cecece;;
}
#a-table tr:hover
{
	background-color: red;
	color: white;
	cursor: pointer;
}
#a-table a
{
	text-decoration: none;
	color: inherit;
}
#a-table1 tr:nth-child(even)
{
  background: #cecece;
}
#a-table tr:hover
{
  color: white;
  cursor: pointer;
}
#a-table1 a
{
  text-decoration: none;
  color: inherit;
}
.espacio
{
  padding-top: 3px;
  padding-bottom: 3px;
}
.espacio1
{
  padding-top: 1px;
  padding-bottom: 1px;
}
.espacio2
{
  padding-top: 5px;
  padding-bottom: 5px;
}
.centrado
{
  padding: 7px;
}
#titulo
{
  background: #fff;
  color: white;
  height: 40px;
  width: 100%;
  left: 15px;
  top: 10px;
  position: fixed;
  z-index: 999;
}
.example-modal .modal
{
  position: relative;
  top: auto;
  bottom: auto;
  right: auto;
  left: auto;
  display: block;
  z-index: 1;
}
.example-modal .modal
{
  background: transparent !important;
}
#val_cajas
{
  height: 300px;
  overflow: auto;
  font-family: 'Verdana';
  font-size: 15px;
}
#val_estibas
{
  height: 400px;
  overflow: auto;
  font-family: 'Verdana';
  font-size: 15px;
}
</style>
<script>
function highlightText(id)
{
  listalotes.forEach(function(valor, indice, array) {
    var id1 = 'l_'+valor;
    var textObject = document.getElementById(id1);
    textObject.className = "highlight1";
  });
  var valida = id;
  var textObject1 = document.getElementById(valida);
  var textObject = document.getElementById(id);
  textObject.className = "highlight";
}
function highlightText1(id)
{
  listaimagenes.forEach(function(valor, indice, array) {
    var id1 = 'i_'+valor;
    var textObject = document.getElementById(id1);
    textObject.className = "highlight1";
  });
  var valida = id;
  var textObject1 = document.getElementById(valida);
  var textObject = document.getElementById(id);
  textObject.className = "highlight";
}
function highlightText2(id, contador)
{
  listareg.forEach(function(valor, indice, array) {
    for (i=1; i<=contador; i++)
    {
      var id1 = 'l'+i+'_'+valor;
      var textObject = document.getElementById(id1);
      textObject.className = "highlight1";
    }
  });
  for (j=1; j<=contador; j++)
  {
    var id1 = 'l'+j+'_'+id;
    var textObject = document.getElementById(id1);
    textObject.className = "highlight";
  }
}
</script>
