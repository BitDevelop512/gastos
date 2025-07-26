var propReporte = {};
$(document).ready(function ()
{
    propReporte = showdivs();
    ejecutaConsulta();
});

function showdivs()
{
    var salida = {};
    salida = {
        colnames:
                [
                    'No.', 'Unidad', 'Compañia', 'Fecha', 'Tipo', 'Usuario', 'Estado', ''
                ],
        colmodels:
                [
                    {name: 'conse', index: 'conse', width: 50, align: 'right'},
                    {name: 'sigla', index: 'sigla', width: 90},
                    {name: 'compania', index: 'compania', width: 200},
                    {name: 'fecha', index: 'fecha', width: 80, formatter: "date", align: 'center', formatoptions: {srcformat: "ISO8601Long", newformat: "Y/m/d"}},
                    {name: 'tipo1', index: 'tipo1', width: 135},
                    {name: 'usuario', index: 'usuario', width: 100},
                    {name: 'estado1', index: 'estado1', width: 130},
                    {name: 'tipo', index: 'tipo', width: 130}
                ],
        sort: 'conse',
        titulo: 'Revisión Planes / Solicitudes SIGAR',
        multiselect: false,
        rowNum: 50
    };
    function btnLink(cellvalue, options, rowObject)
    {
        return "<a href='consulta2.php?datos="+options.rowId+"' target=\"_blank\" title='Resultados' class='btn btn-info btn-xs'>Resultados</a>";
    }
    return salida;
}

function ejecutaConsulta()
{
    var forma = '<table id="lista"></table><div id="paginador"></div>'
    jQuery("#lista").jqGrid({
        url: 'revi_plan_ejecuta.php',
        datatype: "json",
        mtype: "POST",
        postData: {
            unidad: $("#paso").val(),
            compania: $("#paso1").val(),
            usu: $("#paso2").val(),
            mes: $("#mes").val(),
            ano: $("#ano").val(),
            admin: $("#admin").val(),
            nunidad: $("#nunidad").val()
        },
        colNames: propReporte.colnames,
        colModel: propReporte.colmodels,
        multiselect: propReporte.multiselect,
        rowNum: propReporte.rowNum,
        height: 430,
        width: 999,
        rowList: [50, 100, 200, 500, 1000],
        rownumbers: true,
        rownumWidth: 40,
        pager: '#paginador',
        sortname: propReporte.sort,
        viewrecords: true,
        sortorder: "asc",
        gridview: true,
        shrinkToFit: false,
        forceFit: true,
        toppager: false,
        caption: propReporte.titulo,
        loadui: "disable",
        footerrow: false,
        beforeRequest: function () {
            $(".estiloGifLoad").show();
        }, 
        loadComplete: function (respuesta) {
            //$("#dato1").html(respuesta.records);
            //$("#dato2").html('Registros encontrados: '+respuesta.records);
            //$("#datoe").val(respuesta.queryTotal);
            //$("#datox").val(respuesta.queryTotal);
            //$("#datoa").val(respuesta.abc);
            $(".ui-pg-input").css("color", "#000000");
            $(".ui-pg-selbox").css("color", "#000000");
            $(".estiloGifLoad").hide();
        },
        //gridComplete: function()
        //{
        //    var rows = $("#lista").getDataIDs(); 
        //    for (var i = 0; i < rows.length; i++)
        //    {
                //var status = $("#lista").getCell(rows[i],"est_ans");
                //if(status == "NO")
                //{
                //    $("#lista").jqGrid('setRowData',rows[i],false, {color:'black',weightfont:'bold',background:'#FFFF33'});           
                //}
        //    }
        //}
    });
    jQuery("#lista").jqGrid('navGrid', '#paginador', {
        edit: false, add: false, del: false, search: true, view: true
    },{},{},{},
    {width: 580, jqModal: false, closeOnEscape: true},
    {width: 480, jqModal: false, closeOnEscape: true, resize: true, labelswidth: "35%", viewPagerButtons: true}
    );
}
function validacionData(dataCargada)
{
    var salida = true, detalle = '';
    return salida;
}