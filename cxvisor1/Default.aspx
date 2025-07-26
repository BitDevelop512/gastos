<%@ Page Title=":: Cx - Visor Documentos ::" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="CxVisor._Default" %>
<%@ Register Assembly="GdPicture.NET.14.WEB.DocuVieware" Namespace="GdPicture14.WEB" TagPrefix="cc1" %>
 <asp:Content ID="BodyContent" ContentPlaceHolderID="MainContent" runat="server">
    <link href="jquery/jquery-ui.css" rel="stylesheet">
    <script src="jquery/jquery.js"></script>
    <script src="jquery/jquery-ui.js"></script>
    <div align="center">
        <form id="formu">
            <img src="imagenes/descargar.png" id="boton1" width="30" border="0" title="Descargar Archivo" class="mas" onclick="descarga();">
            <asp:TextBox ID="v1" runat="server" />
            <asp:TextBox ID="v2" runat="server" />
            <asp:TextBox ID="v3" runat="server" />
            <asp:TextBox ID="v4" runat="server" />
            <cc1:DocuVieware ID="DocuVieware1" runat="server" Height="850px" Width="1200px" SinglePageView="true" ForceScrollBars="false" AllowedExportFormats="*" MaxUploadSize="52428800" EnableFileUploadButton="true" EnableLoadFromUriButton="true" EnableTwainAcquisitionButton="true" EnableSaveButton="true" EnablePrintButton="true" ShowAnnotationsSnapIn="true" ShowAnnotationsCommentsSnapIn="true" ShowBookmarksSnapIn="true" ShowTextSearchSnapIn="true" ShowThumbnailsSnapIn="true" CollapsedSnapIn="true" />
            <input type="hidden" name="servidor" id="servidor" class="form-control" disabled>
            <div id="descargar"></div>
        </form>
    </div>
    <style>
    .mas
    {
        cursor: pointer;
        padding-top: 5px;
    }
    </style>
    <script>
    $(document).bind("contextmenu",function(e) {
        return false;  
    });
    $(document).ready(function () {
        var servidor = location.host;
        $("#servidor").val(servidor);
        var btn1 = $("input[id*='v4']").val();
        if (btn1 == "1")
        {
            $("#boton1").show();
        }
        else
        {
            $("#boton1").hide();
        }
    });
    function descarga()
    {
        var var1 = $("input[id*='v1']").val();
        var var2 = $("input[id*='v2']").val();
        var var3 = $("input[id*='v3']").val();
        var var4 = $("input[id*='v4']").val();
        var cadena = var3 + "/" + var2;
        var var_ocu = var2.split('.');
        var extension = var_ocu[1];
        $("#descargar").html('');
        var ruta = "<a href='" + cadena + "' download='archivo." + extension + "'><img src='imagenes/blanco.png' id='link'></a>";
        $("#descargar").append(ruta);
        $("#link").click();
    }
    </script>
 </asp:Content>