<%@ Page Title=":: Cx - Visor Documentos ::" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="CxVisor._Default" %>

<%@ Register Assembly="GdPicture.NET.14.WEB.DocuVieware" Namespace="GdPicture14.WEB" TagPrefix="cc1" %>

<asp:Content ID="BodyContent" ContentPlaceHolderID="MainContent" runat="server">
    <div align="center">
        <form id="formu">
            <cc1:DocuVieware ID="DocuVieware1" runat="server" Height="900px" Width="1200px" SinglePageView="true" ForceScrollBars="false" AllowedExportFormats="*" MaxUploadSize="52428800" EnableFileUploadButton="false" EnableLoadFromUriButton="false" EnableTwainAcquisitionButton="false" EnableSaveButton="false" EnablePrintButton="false" ShowAnnotationsSnapIn="false" ShowAnnotationsCommentsSnapIn="false" ShowBookmarksSnapIn="false" ShowTextSearchSnapIn="false" ShowThumbnailsSnapIn="true" CollapsedSnapIn="true" />
        </form>
    </div>
</asp:Content>