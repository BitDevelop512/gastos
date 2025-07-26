using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(CxVisor.Startup))]
namespace CxVisor
{
    public partial class Startup {
        public void Configuration(IAppBuilder app) {
            ConfigureAuth(app);
        }
    }
}
