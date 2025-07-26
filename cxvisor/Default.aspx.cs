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
            string valor1 = Request.QueryString["valor1"];
            string valor2 = Request.QueryString["valor2"];
            if (!IsPostBack)
            {
                var stream = new FileStream(@valor1 + valor2, FileMode.Open, FileAccess.Read);
                DocuVieware1.LoadFromStream(stream, true, valor2);
            }
        }
    }
}