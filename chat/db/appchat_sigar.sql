USE [gastos2]
GO

/****** Object:  Table [dbo].[chat_msg]    Script Date: 02/08/2019 8:47:09 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[chat_msg](
	[conse] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [char](15) NOT NULL,
	[mensaje] [char](500) NOT NULL,
	[fecha] [datetime] NOT NULL,
 CONSTRAINT [PK_chat_msg] PRIMARY KEY CLUSTERED 
(
	[conse] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO


