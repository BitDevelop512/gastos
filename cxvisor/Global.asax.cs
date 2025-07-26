using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Security;
using System.Web.SessionState;
using System.Web.Http;
using System.Web.Optimization;
using System.Web.Routing;
using GdPicture14;
using GdPicture14.WEB;

namespace CxVisor
{
    public class Global : HttpApplication
    {
        public static readonly int SESSION_TIMEOUT = 20;
        public static readonly bool STICKY_SESSION = true;
        public static string getCacheDirectory()
        {
            return HttpRuntime.AppDomainAppPath + "\\Cache";
        }
        public static string getDocumentsDirectory()
        {
            return HttpRuntime.AppDomainAppPath + "\\Documentos";
        }
        void Application_Start(object sender, EventArgs e)
        {
            // Código que se ejecuta al iniciar la aplicación
            RouteConfig.RegisterRoutes(RouteTable.Routes);
            BundleConfig.RegisterBundles(BundleTable.Bundles);

            //DocuViewareManager.SetupConfiguration();
            DocuViewareManager.SetupConfiguration(true, DocuViewareSessionStateMode.InProc, HttpRuntime.AppDomainAppPath + "\\Cache");
            DocuViewareLicensing.RegisterKEY("02a16659ee2249c9bd479e4d591acc1800d6e2899f778a7cGx4ZcGz7zE8pzwYyLtCWhhqcW/TElpE8vdNooePcDI5/eFimqlbgw4626xZ5akP8");
        }
    }
}