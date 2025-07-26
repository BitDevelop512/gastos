using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using GdPicture14.WEB;

namespace CxVisor
{
    public partial class _Default : Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            DocuVieware1.Timeout = Global.SESSION_TIMEOUT;
            v1.Style.Add("display", "none");
            v2.Style.Add("display", "none");
            v3.Style.Add("display", "none");
            v4.Style.Add("display", "none");
            string valor1 = Request.QueryString["valor1"];
            string valor2 = Request.QueryString["valor2"];
            string valor3 = Request.QueryString["valor3"];
            string valor4 = Request.QueryString["valor4"];
            v1.Text = valor1;
            v2.Text = valor2;
            v3.Text = valor3;
            v4.Text = valor4;
            if (!IsPostBack)
            {
                var stream = new FileStream(@valor1 + valor2, FileMode.Open, FileAccess.Read);
                DocuVieware1.LoadFromStream(stream, true, valor2);
            }
        }
    }
}